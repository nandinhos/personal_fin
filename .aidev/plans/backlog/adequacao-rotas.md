# Adequação e Saneamento de Rotas

**Origem:** Varredura diagnóstica em 2026-02-27
**Tipo:** Correção + Segurança + Arquitetura
**Prioridade:** 🔴 CRÍTICA
**Status:** 💡 Backlog

---

## Contexto

Varredura completa das 68 rotas registradas identificou:

- **49 rotas funcionais**
- **10 rotas com erro 500** (métodos ou views ausentes)
- **3 alertas de segurança** (queries sem isolamento por usuário)

Problema raiz: os controllers foram gerados via `Route::resource` (que cria 7 rotas automaticamente), mas nem todos os métodos e views foram implementados. Além disso, os controllers `AccountController` e `CardController` retornam dados de todos os usuários sem filtragem.

---

## Problemas Identificados

### Rotas que causam erro 500

| Rota | Problema |
|------|---------|
| `GET /accounts/{id}/edit` | `AccountController::edit()` não existe |
| `GET /cards/create` | `CardController::create()` não existe |
| `GET /cards/{id}/edit` | `CardController::edit()` não existe |
| `GET /transactions/{id}/edit` | `TransactionController::edit()` não existe |
| `GET /categories/create` | View `categories.create` não existe |
| `GET /categories/{id}` | View `categories.show` não existe |
| `GET /categories/{id}/edit` | View `categories.edit` não existe |
| `GET /subcategories/create` | Sem view |
| `GET /subcategories/{id}` | Sem view |
| `GET /subcategories/{id}/edit` | Sem view |

### Alertas de segurança

| Controller | Problema | Impacto |
|-----------|---------|---------|
| `AccountController::index` | `Account::all()` sem filtro por usuário | Expõe contas de todos os usuários |
| `CardController::index` | `Card::all()` sem filtro por usuário | Expõe cartões de todos os usuários |
| Demais controllers | Auditoria necessária | Potencial vazamento de dados |

---

## Decisão Arquitetural (Prerequisito)

Antes de implementar, definir a estratégia de roteamento:

**Opção A — REST-only (recomendado para Livewire):**
```php
Route::resource('accounts', AccountController::class)
    ->except(['create', 'edit']);
```
- Elimina rotas `create` e `edit` (substituídas por componentes Livewire)
- Controllers respondem apenas JSON
- Mais simples de manter

**Opção B — Híbrido (HTML + Livewire):**
- Manter todas as rotas
- Implementar views e métodos faltantes
- Mais trabalho, mais rotas para manter

---

## Tarefas

### Bloco 1 — Decisão Arquitetural
- [ ] R.11 — Definir se rotas são REST-only ou híbridas

### Bloco 2 — Segurança (executar independente da decisão)
- [ ] R.7 — Corrigir `AccountController::index` com filtro por usuário
- [ ] R.8 — Corrigir `CardController::index` com filtro por usuário
- [ ] R.9 — Auditar todos os controllers (isolamento por `profile_id`)
- [ ] R.10 — Criar Policies: `AccountPolicy`, `CardPolicy`, `TransactionPolicy`

### Bloco 3 — Rotas (depende da decisão R.11)
- [ ] R.1 — Remover ou implementar rotas `*/edit` em todos os resources
- [ ] R.2 — Resolver rota `GET /accounts/{id}/edit`
- [ ] R.3 — Resolver rotas faltantes em `CardController`
- [ ] R.4 — Resolver rota `GET /transactions/{id}/edit`
- [ ] R.5 — Resolver rotas de categorias (views ou exclusão)
- [ ] R.6 — Resolver rotas de subcategorias (views ou exclusão)

### Bloco 4 — Qualidade
- [ ] R.12 — Testes de integração para rotas críticas (auth, accounts, transactions)

---

## Correção de Segurança (Referência)

```php
// ERRADO — expõe dados de todos os usuários:
$accounts = Account::all();

// CORRETO — isolado por profile do usuário autenticado:
$profile = auth()->user()->profiles()->first();
$accounts = Account::where('profile_id', $profile->id)->get();
```

**Com Policy:**
```php
// AccountPolicy.php
public function view(User $user, Account $account): bool
{
    return $user->profiles()->where('id', $account->profile_id)->exists();
}

// AccountController.php
public function show(Account $account): JsonResponse
{
    $this->authorize('view', $account);
    return response()->json($account);
}
```

---

## Como Priorizar

1. Mover este arquivo para `../features/`
2. Definir sprint no `ROADMAP.md`
3. Executar Bloco 2 (segurança) imediatamente — independe de sprint
4. Executar demais blocos na ordem definida

---

*Criado em: 2026-02-27*
*Baseado em: varredura diagnóstica de rotas*
