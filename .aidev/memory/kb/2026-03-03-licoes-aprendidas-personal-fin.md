---
titulo: "Lições Aprendidas — Projeto personal_fin"
data: 2026-03-03
stack: Laravel 12, Livewire 4, Alpine.js, Tailwind CSS, PostgreSQL, Docker
categoria: retrospectiva
scope: projeto
tags: [retrospectiva, arch-decision, security, bug, config, deployment, success-pattern, tdd]
---

# Lições Aprendidas — personal_fin (PFM)

> Retrospectiva técnica completa do ciclo de desenvolvimento.
> Período: 2026-02-26 → 2026-03-03

---

## 1. Git & Setup

### L01 — .gitignore root-relative não cobre subdiretórios

**Categoria:** `config`
**Impacto:** Crítico
**Arquivo de detalhes:** `2026-02-27-gitignore-root-relative-patterns.md`

**Problema:** No primeiro `git add .`, foram staged **8.599 arquivos** em vez dos ~200 esperados. O diretório `tmp_laravel/vendor/` foi incluído porque o `.gitignore` padrão do Laravel usa `/vendor` (root-relative) — que ignora apenas a raiz, não subpastas.

**Prevenção:**
- Adicionar diretórios temporários de setup (`tmp_*`, `setup_*`) ao `.gitignore` antes de qualquer `git add`
- Sempre verificar `git status --short | wc -l` antes do primeiro commit. Esperado: ~180–220 arquivos para Laravel limpo

---

### L02 — Branch padrão deve ser `main` desde o init

**Categoria:** `config`
**Impacto:** Médio

**Problema:** Git inicializa com `master` por padrão em ambientes não configurados. É necessário setar `init.defaultBranch=main` na config global ou usar `git init -b main`.

**Solução:**
```bash
git config --global init.defaultBranch main
# ou no momento do init:
git init -b main
```

---

## 2. Docker & Ambiente

### L03 — Arquivos criados via `docker exec` pertencem ao root

**Categoria:** `deployment`
**Impacto:** Alto

**Problema:** Ao usar `docker exec <container> php artisan make:*`, os arquivos gerados pertencem ao usuário `root` do container. Tentativas de edição local resultam em `EACCES` (Permission denied).

**Solução:**
```bash
sudo chown -R $USER:$USER .
```

**Prevenção:** Sempre corrigir permissões após qualquer geração de arquivo via container.

---

### L04 — MCP Server criado mas não registrado no ServiceProvider

**Categoria:** `bug`, `config`
**Impacto:** Alto
**Commit de fix:** `fix(mcp): registra servidor laravel-boost no AppServiceProvider`

**Problema:** `php artisan make:mcp-server` cria o arquivo do servidor mas **não o registra automaticamente**. O servidor não aparecia no `mcp:list` até ser manualmente registrado em `AppServiceProvider`.

**Prevenção:** Após `make:mcp-server`, sempre registrar o servidor no `AppServiceProvider::boot()`.

---

### L05 — Laravel 12: MCP usa pacote oficial `laravel/mcp`

**Categoria:** `config`
**Impacto:** Crítico
**Arquivo de detalhes:** `2026-02-27-laravel-12-mcp-setup.md`

**Problema:** O pacote comunitário usado em versões anteriores (`nando-goncalves/laravel-boost`) é incompatível com Laravel 12. O suporte a MCP foi unificado no pacote oficial.

**Solução:**
```bash
docker exec <container> composer require laravel/mcp --dev
php artisan make:mcp-server <nome>
php artisan mcp:start <nome>  # nome é obrigatório
```

**Configuração `.mcp.json`:**
```json
"laravel-boost": {
  "command": "docker",
  "args": ["compose", "exec", "-T", "laravel.test", "php", "artisan", "mcp:start", "boost"]
}
```

---

## 3. Laravel — Rotas & Controllers

### L06 — `Route::resource()` sem `->except()` gera 500 imediato

**Categoria:** `bug`
**Impacto:** Crítico
**Commit de fix:** `fix: core functional routes, controller redirects and data persistence logic`

**Problema:** `Route::resource('cards', CardController::class)` registra automaticamente 7 rotas, incluindo `GET /cards/create` e `GET /cards/{id}/edit`. Se os métodos `create()` e `edit()` não existem no controller, qualquer request resulta em `BadMethodCallException` (HTTP 500).

**Sintoma:** Varredura diagnóstica identificou 10 rotas com erro 500 de 68 registradas.

**Solução:**
```php
// Sempre excluir rotas sem implementação:
Route::resource('cards', CardController::class)
    ->except(['create', 'edit'])
    ->parameters(['cards' => 'card']);
```

**Regra geral:** Em projetos Livewire, rotas `create` e `edit` de resources REST geralmente devem ser excluídas — essas operações são gerenciadas por componentes Livewire.

---

### L07 — Método no Controller sem rota registrada (dead endpoint)

**Categoria:** `bug`
**Impacto:** Médio

**Problema:** `GoalController::updateProgress()` foi implementado com lógica completa mas **nenhuma rota apontava para ele** em `routes/web.php`. O método era completamente inacessível.

**Prevenção:** Após implementar qualquer método de controller, imediatamente registrar a rota correspondente. Auditar periodicamente com:
```bash
php artisan route:list | grep -v closure
```

---

### L08 — Estratégia híbrida REST + Livewire não definida explicitamente gerou débito técnico

**Categoria:** `arch-decision`
**Impacto:** Alto

**Problema:** O projeto usou `Route::resource()` completo (REST) mas o frontend usa Livewire. Sem uma decisão explícita sobre quais rotas são REST (JSON) e quais são Livewire (HTML), acumulou-se inconsistência: rotas GET de `create`/`edit` registradas sem views correspondentes.

**Decisão recomendada (documentada no backlog):**
```php
// Para controllers usados com Livewire:
Route::resource('accounts', AccountController::class)
    ->except(['create', 'edit']);

// Para controllers de API pura (JSON):
Route::apiResource('transactions', TransactionController::class);
```

---

## 4. Segurança

### L09 — Queries sem isolamento por `profile_id` expõem dados de outros usuários

**Categoria:** `security`
**Impacto:** Crítico
**Commits relacionados:** `e8ae486`

**Problema:** `AccountController::index()` e `CardController::index()` usavam `Account::all()` e `Card::all()` — retornando dados de **todos os usuários** para qualquer usuário autenticado.

**Varredura diagnóstica identificou 3 alertas de segurança deste tipo.**

**Padrão errado:**
```php
// ERRADO — expõe dados de todos os usuários:
$accounts = Account::all();
```

**Padrão correto:**
```php
// CORRETO — isolado por profile do usuário autenticado:
$profile = auth()->user()->profiles()->first();
$accounts = Account::where('profile_id', $profile->id)->get();
```

**Prevenção:**
- Nunca usar `Model::all()` em controllers autenticados
- Criar Global Scope de `profile_id` nos models ou usar Policies
- Considerar `AccountPolicy`, `CardPolicy`, `TransactionPolicy` com `$this->authorize()`

---

## 5. Livewire

### L10 — Componente Livewire com múltiplos elementos raiz causa erro

**Categoria:** `bug`
**Impacto:** Alto
**Commit de fix:** `fix(dashboard): corrige erro multiple root elements livewire`

**Problema:** Livewire 3+ exige **exatamente um elemento raiz** por componente. Templates com dois ou mais elementos no topo geram `Livewire: Multiple root elements` e o componente não renderiza.

**Padrão correto:**
```blade
{{-- ERRADO: dois elementos raiz --}}
<div>...</div>
<section>...</section>

{{-- CORRETO: um único elemento raiz --}}
<div>
    <section>...</section>
</div>
```

---

### L11 — Alpine.js complementa Livewire para interatividade client-side

**Categoria:** `success-pattern`
**Impacto:** Alto

**Padrão que funcionou:** Usar Alpine.js para UI state local (modais, toggles, animações) e Livewire apenas para operações que precisam de dados do servidor. Isso elimina round-trips desnecessários e mantém a UI responsiva.

**Exemplo aplicado no projeto:**
```blade
{{-- Modal de confirmação de transferência: Alpine.js --}}
<div x-data="{ open: false }">
    <button @click="open = true">Transferir</button>
    <div x-show="open" x-transition>
        {{-- formulário de confirmação --}}
    </div>
</div>
```

**Commit de referência:** `feat: transferências entre contas, modal de confirmação Alpine e melhorias na UI`

---

## 6. Planejamento & Processo

### L12 — Sprints marcadas como concluídas sem implementação real criam falsa percepção de progresso

**Categoria:** `arch-decision`
**Impacto:** Crítico

**Problema:** Os commits `feat(sprint-5)` a `feat(sprint-9)` foram realizados marcando as sprints como concluídas no README, mas o **backlog permaneceu com praticamente todos os itens como `⏳ Pendente`**. O README e o backlog ficaram divergentes.

**Lição:** O status de sprint deve refletir apenas o que foi **testado e validado em produção**. Commits de documentação não substituem implementação. O backlog é a fonte de verdade, não o README.

**Prevenção:**
- Manter o backlog (`backlog.md`) como única fonte de verdade de status
- Só marcar sprint como concluída quando todos os itens críticos (`🔴`) estiverem implementados e testados

---

### L13 — TDD foi definido como mandatório mas não seguido na prática

**Categoria:** `arch-decision`
**Impacto:** Alto

**Contexto:** O `project-handbook.md` define "TDD Mandatório (RED → GREEN → REFACTOR)" e "Zero código sem teste". Na prática, **nenhum teste foi escrito** durante o desenvolvimento das sprints.

**Consequência:** Sem testes, a varredura diagnóstica de 2026-02-27 identificou 10 rotas com erro 500 e 3 vulnerabilidades de segurança que passariam despercebidas num ciclo com testes.

**Aprendizado:** TDD deve ser operacionalizado via checklist no início de cada sprint, não apenas declarado no handbook.

---

### L14 — Dead code acumula silenciosamente sem varredura diagnóstica

**Categoria:** `bug`
**Impacto:** Médio
**Commit de fix:** `chore: limpeza de arquivos obsoletos e refatoração de controllers`

**Problema:** `FinancialProfileController.php` existia no projeto sem nenhuma rota, nenhum teste e nenhuma referência. Identificado apenas via varredura manual de models vs controllers vs rotas.

**Prevenção:**
- Varredura diagnóstica periódica: cruzar models, controllers e rotas
- Ao remover uma feature, remover o controller junto no mesmo commit

---

## 7. Design System

### L15 — Glassmorphism + Dark Mode como padrão visual funciona bem com Tailwind JIT

**Categoria:** `success-pattern`
**Impacto:** Positivo

**Padrão aplicado:**
```css
/* Glassmorphism base */
background: rgba(255, 255, 255, 0.05);
backdrop-filter: blur(10px);
border: 1px solid rgba(255, 255, 255, 0.1);
```

**Com Tailwind:**
```blade
<div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl">
```

**Resultado:** Design coeso e premium com mínimo de CSS customizado. Padrão aplicado consistentemente em todos os módulos (Dashboard, Cards, Accounts, Transactions).

---

## 8. Banco de Dados & Modelos

### L16 — UUID obrigatório mas fácil de esquecer em migrations

**Categoria:** `config`
**Impacto:** Médio

**Contexto:** O `project-handbook.md` define "UUID v4 para todas as chaves primárias". Em alguns módulos criados rapidamente (sprint-8, sprint-9), `$table->id()` foi usado em vez de `$table->uuid('id')->primary()`.

**Padrão correto:**
```php
// Migration com UUID
$table->uuid('id')->primary();
$table->uuid('profile_id');
$table->foreign('profile_id')->references('id')->on('profiles');
```

**Model:**
```php
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Account extends Model {
    use HasUuids;
}
```

---

## Resumo Executivo

| # | Lição | Categoria | Impacto | Repetibilidade |
|---|-------|-----------|---------|----------------|
| L01 | .gitignore root-relative | config | Crítico | Alta |
| L02 | Branch main desde o init | config | Médio | Alta |
| L03 | Docker exec cria arquivos como root | deployment | Alto | Alta |
| L04 | MCP server não auto-registrado | bug/config | Alto | Alta |
| L05 | Laravel 12 usa `laravel/mcp` oficial | config | Crítico | Alta |
| L06 | `Route::resource()` sem `->except()` | bug | Crítico | Alta |
| L07 | Método controller sem rota | bug | Médio | Média |
| L08 | Estratégia REST/Livewire não definida | arch-decision | Alto | Alta |
| L09 | Queries sem isolamento por usuário | security | Crítico | Alta |
| L10 | Livewire múltiplos root elements | bug | Alto | Média |
| L11 | Alpine.js + Livewire como complemento | success-pattern | Alto | Alta |
| L12 | Sprint "concluída" sem implementação | processo | Crítico | Média |
| L13 | TDD declarado mas não praticado | processo | Alto | Alta |
| L14 | Dead code acumula sem varredura | bug | Médio | Média |
| L15 | Glassmorphism com Tailwind JIT | success-pattern | Positivo | Alta |
| L16 | UUID obrigatório fácil de esquecer | config | Médio | Alta |

---

## Checklists de Prevenção

### Novo Projeto Laravel (Sprint 0)
- [ ] Configurar `init.defaultBranch=main` na git config global
- [ ] Adicionar diretórios temporários ao `.gitignore` antes do primeiro commit
- [ ] Verificar `git status --short | wc -l` (esperado: ~200 arquivos)
- [ ] Definir estratégia REST vs Livewire no handbook
- [ ] Configurar UUID como padrão em todos os models
- [ ] Instalar `laravel/mcp` via docker exec, não direto no host

### Novo Controller
- [ ] Usar `->except(['create', 'edit'])` em resources Livewire
- [ ] Registrar rota imediatamente após implementar método
- [ ] Filtrar sempre por `profile_id` do usuário autenticado
- [ ] Nunca usar `Model::all()` em controllers autenticados

### Nova Sprint
- [ ] Só marcar como concluída com todos os itens `🔴` implementados e testados
- [ ] Escrever pelo menos um Feature Test por rota nova (TDD)
- [ ] Executar varredura de rotas: `php artisan route:list`
- [ ] Corrigir permissões após geração de arquivos via Docker

---

*Gerado em: 2026-03-03 | Retrospectiva: personal_fin v1.x | AI Dev Agent*
