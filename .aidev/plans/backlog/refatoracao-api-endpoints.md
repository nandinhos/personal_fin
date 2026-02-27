# 🔌 FEATURE: Refatoração — Padronizar Todas as Saídas como API JSON

**Data:** 2026-02-27
**Status:** 💡 Backlog
**Origem:** Análise profunda dos controllers
**Prioridade:** 🔴 CRÍTICA

---

## Diagnóstico Geral

A stack do projeto (Laravel 12 + Livewire 3 + Alpine.js) usa uma **arquitetura SPA-like** onde as *pages* são servidas por rotas web que retornam `view()`, e **toda a lógica de dados deve ser consumida via API JSON** — seja por Livewire internamente, seja por fetch do frontend.

Após auditoria completa em todos os 21 controllers, identificamos **4 categorias de problema**:

| Categoria | Controllers | Criticidade |
|-----------|-------------|-------------|
| 🔴 Totalmente HTML/Redirect | `LimitController`, `GoalController` | CRÍTICA |
| 🟡 Comportamento dual (HTML + JSON) | `AccountController`, `TransactionController` | MÉDIA |
| 🟠 Bugs de dados + HTML | `DashboardController` | ALTA |
| ⚫ Dead code | `FinancialProfileController` | BAIXA |

> **Exceções legítimas** (não precisam ser refatoradas):
> - `ProfileController` (Breeze — formulários de perfil do usuário)
> - Todos os controllers em `Auth/` (Breeze — login, register, reset)
> - Rotas de dashboard/page shells que apenas retornam `view()`

---

## Análise Detalhada por Controller

---

### 🔴 LimitController — 100% HTML/Redirect

**Arquivo:** `app/Http/Controllers/LimitController.php`

| Método | Saída Atual | Saída Esperada |
|--------|-------------|----------------|
| `index()` | `view('limits.index')` + dados embutidos | `response()->json($limits)` |
| `store()` | `redirect()->route('limits.index')` | `response()->json($limit, 201)` |
| `update()` | `redirect()->route('limits.index')` | `response()->json($limit)` |
| `destroy()` | `redirect()->route('limits.index')` | `response()->json(null, 204)` |

**Bugs adicionais:**
- `update()` e `destroy()`: autorização via `if ($limit->profile_id !== $profile->id) return redirect()` — deveria ser `abort_if(403)`
- `store()` não usa `firstOrCreate` — se não houver perfil, silencia com redirect sem criar

**Impacto:** A view `limits/index.blade.php` recebe dados pelo controller. Precisa ser convertida para consumir via Livewire/fetch.

---

### 🔴 GoalController — 100% HTML/Redirect

**Arquivo:** `app/Http/Controllers/GoalController.php`

| Método | Saída Atual | Saída Esperada |
|--------|-------------|----------------|
| `index()` | `view('goals.index')` + dados embutidos | `response()->json($goals)` |
| `store()` | `redirect()->route('goals.index')` | `response()->json($goal, 201)` |
| `update()` | `redirect()->route('goals.index')` | `response()->json($goal)` |
| `destroy()` | `redirect()->route('goals.index')` | `response()->json(null, 204)` |
| `updateProgress()` | `redirect()->route('goals.index')` | `response()->json($goal)` |

**Bugs adicionais:**
- `updateProgress()` não tem rota registrada em `routes/web.php` (método órfão)
- Autorização: `if ($goal->profile_id !== $profile->id) return redirect()` — deveria ser `abort_if(403)`
- `store()` não usa `firstOrCreate`

---

### 🟡 AccountController — Comportamento Dual

**Arquivo:** `app/Http/Controllers/AccountController.php`

| Método | Saída Atual | Problema |
|--------|-------------|----------|
| `index()` | Dual: `view()` ou `json()` via `expectsJson()` | Lógica ambígua — qual o contrato? |
| `create()` | `view('accounts.create')` | Forma HTML legada; deve ser modal Livewire |
| `store()` | Dual: `redirect()` ou `json()` via `expectsJson()` | Lógica ambígua |
| `show()` | `response()->json()` ✅ | OK |
| `update()` | `response()->json()` ✅ | OK |
| `destroy()` | `response()->json(null, 204)` ✅ | OK |

**Decisão arquitetural necessária:**
- Remover `create()` (substituir por modal Livewire)
- `index()` e `store()`: eliminar o dual behavior — sempre JSON

---

### 🟡 TransactionController — Comportamento Dual

**Arquivo:** `app/Http/Controllers/TransactionController.php`

| Método | Saída Atual | Problema |
|--------|-------------|----------|
| `index()` | Dual: `view()` ou `json()` via `expectsJson()` | Lógica ambígua |
| `create()` | `view('transactions.create')` | Forma HTML legada; deve ser modal Livewire |
| `store()` | Dual: `redirect()` ou `json()` via `expectsJson()` | Lógica ambígua |
| `show()` | `response()->json()` ✅ | OK |
| `update()` | `response()->json()` ✅ | OK |
| `destroy()` | `response()->json(null, 204)` ✅ | OK |

---

### 🟠 DashboardController — Bug + HTML

**Arquivo:** `app/Http/Controllers/DashboardController.php`

| Problema | Detalhe |
|----------|---------|
| **Bug crítico** | Usa `$user->profile` (propriedade mágica inexistente) em vez de `$user->profiles()->first()` — retorna `null` silenciosamente |
| **Dados embutidos na view** | `totalBalance`, `monthlyIncome`, `monthlyExpenses`, etc. são computados e passados como blade vars |
| **Limite hardcoded** | `$defaultLimit = 5000` — valor mágico sem relação com os limites cadastrados pelo usuário |

**Situação especial:** O `/dashboard` em si é uma rota `view()` legítima (é a shell da SPA). Porém, os **dados** que alimenta devem vir de endpoints API separados (ex: `/api/dashboard/summary`), não ser pré-computados no controller e injetados no blade.

> O projeto já tem `/reports/*` como endpoints separados — o DashboardController deveria delegar para lá ou ter seus próprios endpoints `/dashboard/*`.

---

### ⚫ FinancialProfileController — Dead Code

**Arquivo:** `app/Http/Controllers/FinancialProfileController.php`

- Todos os 7 métodos estão **vazios** (apenas comentários do scaffold)
- **Não há nenhuma rota registrada** para este controller em `routes/web.php`
- Ação: deletar o arquivo

---

## Mapa Completo de Saídas (todos os controllers)

### Controllers puramente JSON ✅ (corretos)

| Controller | Todos os métodos JSON? |
|------------|----------------------|
| `CardController` | ✅ Sim |
| `CategoryController` | ✅ Sim |
| `SubcategoryController` | ✅ Sim |
| `ReportController` | ✅ Sim (5 endpoints) |

### Controllers com problemas ❌

| Controller | Métodos com HTML/Redirect | Gravidade |
|------------|--------------------------|-----------|
| `LimitController` | `index`, `store`, `update`, `destroy` (4/4) | 🔴 |
| `GoalController` | `index`, `store`, `update`, `destroy`, `updateProgress` (5/5) | 🔴 |
| `AccountController` | `create` (HTML puro), `index`+`store` (dual) | 🟡 |
| `TransactionController` | `create` (HTML puro), `index`+`store` (dual) | 🟡 |
| `DashboardController` | `__invoke` (HTML + bug profile) | 🟠 |

### Controllers legítimos com HTML ✅ (não refatorar)

| Controller | Justificativa |
|------------|---------------|
| `ProfileController` | Breeze — formulário de conta do usuário |
| `Auth/*` (6 controllers) | Breeze — fluxo de autenticação por sessão |
| Closures em `routes/web.php` | Shell pages (dashboard, categories.manager) |

---

## Plano de Refatoração

### Fase 1 — LimitController (🔴 CRÍTICA)

| # | Tarefa |
|---|--------|
| API.L1 | Converter `index()` → `response()->json()` |
| API.L2 | Converter `store()` → `response()->json(201)` + `firstOrCreate` |
| API.L3 | Converter `update()` → `response()->json()` + `abort_if(403)` |
| API.L4 | Converter `destroy()` → `response()->json(null, 204)` + `abort_if(403)` |
| API.L5 | Adaptar `limits/index.blade.php` para ser page shell (Livewire/fetch) |

### Fase 2 — GoalController (🔴 CRÍTICA)

| # | Tarefa |
|---|--------|
| API.G1 | Converter `index()` → `response()->json()` |
| API.G2 | Converter `store()` → `response()->json(201)` + `firstOrCreate` |
| API.G3 | Converter `update()` → `response()->json()` + `abort_if(403)` |
| API.G4 | Converter `destroy()` → `response()->json(null, 204)` + `abort_if(403)` |
| API.G5 | Converter `updateProgress()` → `response()->json()` + registrar rota |
| API.G6 | Adaptar `goals/index.blade.php` para ser page shell |

### Fase 3 — AccountController e TransactionController (🟡 MÉDIA)

| # | Tarefa |
|---|--------|
| API.A1 | Remover `create()` do `AccountController` + deletar `accounts/create.blade.php` |
| API.A2 | Remover dual behavior de `index()` e `store()` → sempre JSON |
| API.A3 | Adicionar rota `->except(['create'])` no `accounts` resource |
| API.T1 | Remover `create()` do `TransactionController` + deletar `transactions/create.blade.php` |
| API.T2 | Remover dual behavior de `index()` e `store()` → sempre JSON |
| API.T3 | Verificar rota `transactions.create` — se ainda usada |

### Fase 4 — DashboardController (🟠 ALTA)

| # | Tarefa |
|---|--------|
| API.D1 | Corrigir bug: `$user->profile` → `$user->profiles()->first()` |
| API.D2 | Criar endpoint `GET /dashboard/summary` retornando dados como JSON |
| API.D3 | Remover computações do `__invoke()` — deixar só `return view()` |
| API.D4 | Atualizar Livewire dashboard para consumir `/dashboard/summary` |
| API.D5 | Remover `$defaultLimit = 5000` hardcoded — usar limites reais do usuário |

### Fase 5 — Limpeza (🟢 BAIXA)

| # | Tarefa |
|---|--------|
| API.C1 | Deletar `FinancialProfileController.php` (dead code) |
| API.C2 | Revisar views que ainda dependem de dados injetados via blade vars |
| API.C3 | Revisar `cards/create.blade.php` — verificar se ainda tem rota |

---

## Padrão Final Esperado

Após a refatoração, todos os controllers de negócio seguirão este contrato:

```php
// ✅ Padrão correto para todos os métodos de dados
public function index(): JsonResponse
{
    $profile = auth()->user()->profiles()->first();
    // ...
    return response()->json($data);
}

public function store(Request $request): JsonResponse
{
    $profile = auth()->user()->profiles()->firstOrCreate([...]);
    // ...
    return response()->json($resource, 201);
}

public function update(Request $request, Model $model): JsonResponse
{
    abort_if($model->profile->user_id !== auth()->id(), 403);
    // ...
    return response()->json($model);
}

public function destroy(Model $model): JsonResponse
{
    abort_if($model->profile->user_id !== auth()->id(), 403);
    $model->delete();
    return response()->json(null, 204);
}
```

---

## Estimativa

| Fase | Controllers | Esforço |
|------|-------------|---------|
| Fase 1 — LimitController | 4 métodos | ~2h |
| Fase 2 — GoalController | 5 métodos | ~2h |
| Fase 3 — Account + Transaction | 4 métodos + views | ~1.5h |
| Fase 4 — DashboardController | refactor + endpoint | ~3h |
| Fase 5 — Limpeza | dead code + views | ~1h |
| **Total** | | **~9.5h** |
