# 🗂️ FEATURE: API JSON Completa + Catálogo de Endpoints + Área Dev

**Data:** 2026-02-27
**Status:** 📋 Feature (Pronta para implementação)
**Origem:** Backlog: refatoracao-api-endpoints + gaps-controllers + solicitação usuário
**Prioridade:** 🔴 CRÍTICA

---

## Visão Geral

Este plano consolida **3 entregáveis interdependentes**:

1. **API JSON** — Padronizar todas as saídas de dados como `response()->json()`
2. **Catálogo de Endpoints** — Config centralizada documentando todos os endpoints por módulo
3. **Área Dev** — UI admin-only para visualizar, testar e monitorar os endpoints em tempo real

```
┌─────────────────────────────────────────────────────────────┐
│                    ÁREA DEV (admin only)                     │
│  ┌──────────────────┐  ┌─────────────────┐  ┌───────────┐  │
│  │  Catálogo de     │  │  Endpoint       │  │  Logs de  │  │
│  │  Endpoints       │  │  Explorer       │  │  Debug    │  │
│  │  (por módulo)    │  │  (fire & see)   │  │  Runtime  │  │
│  └──────────────────┘  └─────────────────┘  └───────────┘  │
└─────────────────────────────────────────────────────────────┘
           ↑ consome
┌─────────────────────────────────────────────────────────────┐
│              config/api-catalog.php                          │
│  (fonte única de verdade dos endpoints)                      │
└─────────────────────────────────────────────────────────────┘
           ↑ documenta
┌─────────────────────────────────────────────────────────────┐
│                    CONTROLLERS JSON                          │
│  Accounts │ Cards │ Transactions │ Goals │ Limits │ ...      │
└─────────────────────────────────────────────────────────────┘
```

---

## FASE 1 — Infraestrutura Base

### 1.1 — Migration: coluna `is_admin` na tabela `users`

**Arquivo:** `database/migrations/YYYY_MM_DD_add_is_admin_to_users_table.php`

```php
Schema::table('users', function (Blueprint $table) {
    $table->boolean('is_admin')->default(false)->after('email');
});
```

**Atualizar UserSeeder:** `admin@fin.com` → `is_admin: true`

**Atualizar User model:** adicionar `is_admin` ao `$fillable` e cast `boolean`

---

### 1.2 — Middleware `EnsureIsAdmin`

**Arquivo:** `app/Http/Middleware/EnsureIsAdmin.php`

```php
public function handle(Request $request, Closure $next): Response
{
    if (! auth()->check() || ! auth()->user()->is_admin) {
        abort(403, 'Área restrita.');
    }
    return $next($request);
}
```

**Registrar no `bootstrap/app.php`:**
```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias(['admin' => EnsureIsAdmin::class]);
})
```

---

### 1.3 — Catálogo de Endpoints: `config/api-catalog.php`

Fonte única de verdade. Cada entrada documenta um endpoint.

```php
return [
    'modules' => [

        'dashboard' => [
            'label' => 'Dashboard',
            'icon'  => 'chart-bar',
            'color' => '#6366f1',
            'endpoints' => [
                [
                    'method'      => 'GET',
                    'uri'         => '/dashboard/summary',
                    'name'        => 'dashboard.summary',
                    'description' => 'Resumo financeiro do mês atual',
                    'params'      => [],
                    'response'    => ['total_balance', 'monthly_income', 'monthly_expenses', 'goals_progress'],
                    'auth'        => true,
                    'status'      => 'active', // active | planned | deprecated
                ],
            ],
        ],

        'accounts' => [
            'label' => 'Contas',
            'icon'  => 'bank',
            'color' => '#22c55e',
            'endpoints' => [
                ['method' => 'GET',   'uri' => '/accounts',              'name' => 'accounts.index',   'description' => 'Lista contas do perfil', 'status' => 'active'],
                ['method' => 'POST',  'uri' => '/accounts',              'name' => 'accounts.store',   'description' => 'Cria conta',             'status' => 'active'],
                ['method' => 'GET',   'uri' => '/accounts/{id}',         'name' => 'accounts.show',    'description' => 'Exibe conta',            'status' => 'active'],
                ['method' => 'PATCH', 'uri' => '/accounts/{id}',         'name' => 'accounts.update',  'description' => 'Atualiza conta',         'status' => 'active'],
                ['method' => 'DELETE','uri' => '/accounts/{id}',         'name' => 'accounts.destroy', 'description' => 'Remove conta',           'status' => 'active'],
                ['method' => 'GET',   'uri' => '/accounts/{id}/transactions', 'name' => 'accounts.transactions', 'description' => 'Extrato da conta', 'status' => 'planned'],
                ['method' => 'PATCH', 'uri' => '/accounts/{id}/toggle',  'name' => 'accounts.toggle',  'description' => 'Ativa/desativa conta',   'status' => 'planned'],
            ],
        ],

        'cards' => [
            'label' => 'Cartões',
            'icon'  => 'credit-card',
            'color' => '#3b82f6',
            'endpoints' => [
                ['method' => 'GET',    'uri' => '/cards',             'name' => 'cards.index',        'description' => 'Lista cartões',            'status' => 'active'],
                ['method' => 'POST',   'uri' => '/cards',             'name' => 'cards.store',        'description' => 'Cria cartão',              'status' => 'active'],
                ['method' => 'GET',    'uri' => '/cards/{id}',        'name' => 'cards.show',         'description' => 'Exibe cartão',             'status' => 'active'],
                ['method' => 'PATCH',  'uri' => '/cards/{id}',        'name' => 'cards.update',       'description' => 'Atualiza cartão',          'status' => 'active'],
                ['method' => 'DELETE', 'uri' => '/cards/{id}',        'name' => 'cards.destroy',      'description' => 'Remove cartão',            'status' => 'active'],
                ['method' => 'GET',    'uri' => '/cards/{id}/transactions', 'name' => 'cards.transactions', 'description' => 'Transações do cartão', 'status' => 'planned'],
                ['method' => 'GET',    'uri' => '/cards/{id}/summary', 'name' => 'cards.summary',     'description' => 'Limite e saldo atual',     'status' => 'planned'],
                ['method' => 'PATCH',  'uri' => '/cards/{id}/toggle', 'name' => 'cards.toggle',       'description' => 'Ativa/desativa cartão',    'status' => 'planned'],
            ],
        ],

        'transactions' => [
            'label' => 'Transações',
            'icon'  => 'arrows-right-left',
            'color' => '#f59e0b',
            'endpoints' => [
                ['method' => 'GET',    'uri' => '/transactions',      'name' => 'transactions.index',   'description' => 'Lista transações (filtros: type, category_id, account_id, card_id, date_from, date_to)', 'status' => 'active'],
                ['method' => 'POST',   'uri' => '/transactions',      'name' => 'transactions.store',   'description' => 'Cria transação', 'status' => 'active'],
                ['method' => 'GET',    'uri' => '/transactions/{id}', 'name' => 'transactions.show',    'description' => 'Exibe transação', 'status' => 'active'],
                ['method' => 'PATCH',  'uri' => '/transactions/{id}', 'name' => 'transactions.update',  'description' => 'Atualiza transação', 'status' => 'active'],
                ['method' => 'DELETE', 'uri' => '/transactions/{id}', 'name' => 'transactions.destroy', 'description' => 'Remove transação', 'status' => 'active'],
            ],
        ],

        'categories' => [
            'label' => 'Categorias',
            'icon'  => 'tag',
            'color' => '#8b5cf6',
            'endpoints' => [
                ['method' => 'GET',    'uri' => '/categories',        'name' => 'categories.index',   'description' => 'Lista categorias com subcategorias', 'status' => 'active'],
                ['method' => 'POST',   'uri' => '/categories',        'name' => 'categories.store',   'description' => 'Cria categoria', 'status' => 'active'],
                ['method' => 'PATCH',  'uri' => '/categories/{id}',   'name' => 'categories.update',  'description' => 'Atualiza categoria', 'status' => 'active'],
                ['method' => 'DELETE', 'uri' => '/categories/{id}',   'name' => 'categories.destroy', 'description' => 'Remove categoria', 'status' => 'active'],
                ['method' => 'GET',    'uri' => '/subcategories',     'name' => 'subcategories.index',   'description' => 'Lista subcategorias do perfil', 'status' => 'active'],
                ['method' => 'POST',   'uri' => '/subcategories',     'name' => 'subcategories.store',   'description' => 'Cria subcategoria', 'status' => 'active'],
                ['method' => 'PATCH',  'uri' => '/subcategories/{id}','name' => 'subcategories.update',  'description' => 'Atualiza subcategoria', 'status' => 'active'],
                ['method' => 'DELETE', 'uri' => '/subcategories/{id}','name' => 'subcategories.destroy', 'description' => 'Remove subcategoria', 'status' => 'active'],
            ],
        ],

        'limits' => [
            'label' => 'Limites',
            'icon'  => 'gauge',
            'color' => '#ef4444',
            'endpoints' => [
                ['method' => 'GET',    'uri' => '/limits',        'name' => 'limits.index',   'description' => 'Lista limites mensais', 'status' => 'active'],
                ['method' => 'POST',   'uri' => '/limits',        'name' => 'limits.store',   'description' => 'Define limite por categoria', 'status' => 'active'],
                ['method' => 'PATCH',  'uri' => '/limits/{id}',   'name' => 'limits.update',  'description' => 'Atualiza limite', 'status' => 'active'],
                ['method' => 'DELETE', 'uri' => '/limits/{id}',   'name' => 'limits.destroy', 'description' => 'Remove limite', 'status' => 'active'],
            ],
        ],

        'goals' => [
            'label' => 'Metas',
            'icon'  => 'target',
            'color' => '#10b981',
            'endpoints' => [
                ['method' => 'GET',    'uri' => '/goals',                  'name' => 'goals.index',    'description' => 'Lista metas de reserva', 'status' => 'active'],
                ['method' => 'POST',   'uri' => '/goals',                  'name' => 'goals.store',    'description' => 'Cria meta', 'status' => 'active'],
                ['method' => 'PATCH',  'uri' => '/goals/{id}',             'name' => 'goals.update',   'description' => 'Atualiza meta', 'status' => 'active'],
                ['method' => 'DELETE', 'uri' => '/goals/{id}',             'name' => 'goals.destroy',  'description' => 'Remove meta', 'status' => 'active'],
                ['method' => 'PATCH',  'uri' => '/goals/{id}/progress',    'name' => 'goals.progress', 'description' => 'Atualiza valor atual da meta', 'status' => 'active'],
            ],
        ],

        'installments' => [
            'label' => 'Parcelas',
            'icon'  => 'list-numbered',
            'color' => '#f97316',
            'endpoints' => [
                ['method' => 'GET',    'uri' => '/installments',          'name' => 'installments.index',   'description' => 'Lista parcelas', 'status' => 'planned'],
                ['method' => 'GET',    'uri' => '/installments/pending',  'name' => 'installments.pending', 'description' => 'Parcelas em aberto', 'status' => 'planned'],
                ['method' => 'PATCH',  'uri' => '/installments/{id}/pay', 'name' => 'installments.pay',     'description' => 'Marca parcela como paga', 'status' => 'planned'],
                ['method' => 'PATCH',  'uri' => '/installments/{id}',     'name' => 'installments.update',  'description' => 'Atualiza parcela', 'status' => 'planned'],
                ['method' => 'DELETE', 'uri' => '/installments/{id}',     'name' => 'installments.destroy', 'description' => 'Remove parcela', 'status' => 'planned'],
            ],
        ],

        'investments' => [
            'label' => 'Investimentos',
            'icon'  => 'trending-up',
            'color' => '#06b6d4',
            'endpoints' => [
                ['method' => 'GET',    'uri' => '/investments',           'name' => 'investments.index',   'description' => 'Lista investimentos', 'status' => 'planned'],
                ['method' => 'POST',   'uri' => '/investments',           'name' => 'investments.store',   'description' => 'Registra investimento', 'status' => 'planned'],
                ['method' => 'PATCH',  'uri' => '/investments/{id}',      'name' => 'investments.update',  'description' => 'Atualiza valor atual', 'status' => 'planned'],
                ['method' => 'DELETE', 'uri' => '/investments/{id}',      'name' => 'investments.destroy', 'description' => 'Remove investimento', 'status' => 'planned'],
                ['method' => 'GET',    'uri' => '/investments/summary',   'name' => 'investments.summary', 'description' => 'Rentabilidade geral', 'status' => 'planned'],
            ],
        ],

        'loans' => [
            'label' => 'Empréstimos',
            'icon'  => 'hand-coins',
            'color' => '#dc2626',
            'endpoints' => [
                ['method' => 'GET',    'uri' => '/loans',             'name' => 'loans.index',   'description' => 'Lista empréstimos', 'status' => 'planned'],
                ['method' => 'POST',   'uri' => '/loans',             'name' => 'loans.store',   'description' => 'Registra empréstimo', 'status' => 'planned'],
                ['method' => 'PATCH',  'uri' => '/loans/{id}',        'name' => 'loans.update',  'description' => 'Atualiza empréstimo', 'status' => 'planned'],
                ['method' => 'PATCH',  'uri' => '/loans/{id}/pay',    'name' => 'loans.pay',     'description' => 'Registra pagamento de parcela', 'status' => 'planned'],
                ['method' => 'DELETE', 'uri' => '/loans/{id}',        'name' => 'loans.destroy', 'description' => 'Remove empréstimo', 'status' => 'planned'],
            ],
        ],

        'reports' => [
            'label' => 'Relatórios',
            'icon'  => 'chart-pie',
            'color' => '#a855f7',
            'endpoints' => [
                ['method' => 'GET', 'uri' => '/reports/expenses-by-category', 'name' => 'reports.expensesByCategory', 'description' => 'Total de despesas por categoria', 'status' => 'active'],
                ['method' => 'GET', 'uri' => '/reports/income-expense',       'name' => 'reports.incomeVsExpense',     'description' => 'Receitas vs Despesas + saldo', 'status' => 'active'],
                ['method' => 'GET', 'uri' => '/reports/monthly',              'name' => 'reports.monthly',             'description' => 'Histórico mensal por tipo', 'status' => 'active'],
                ['method' => 'GET', 'uri' => '/reports/by-card',              'name' => 'reports.byCard',              'description' => 'Total gasto por cartão', 'status' => 'active'],
                ['method' => 'GET', 'uri' => '/reports/by-account',           'name' => 'reports.byAccount',           'description' => 'Total por conta', 'status' => 'active'],
            ],
        ],

    ],
];
```

---

## FASE 2 — Refatoração dos Controllers para JSON

### Ordem de execução (por criticidade):

#### 2.1 Fix crítico imediato (bugs/rotas 500)
```php
// routes/web.php
Route::resource('cards', CardController::class)
    ->except(['create', 'edit'])      // ← FIX CRÍTICO: CardController não tem esses métodos
    ->parameters(['cards' => 'card']);

Route::patch('/goals/{goal}/progress', [GoalController::class, 'updateProgress'])
    ->name('goals.progress');         // ← método existe mas sem rota
```

#### 2.2 LimitController — 100% para JSON
```php
// Cada método: view()/redirect() → response()->json()
// Autorização: if (...) return redirect() → abort_if(403)
// store(): adicionar firstOrCreate
```

#### 2.3 GoalController — 100% para JSON
```php
// Idem LimitController
// updateProgress(): converter redirect() → response()->json()
```

#### 2.4 AccountController — remover dual behavior
```php
// Remover expectsJson() — sempre JSON
// Remover create() — substituir por modal Livewire
// routes/web.php: ->except(['create', 'edit'])
```

#### 2.5 TransactionController — remover dual behavior
```php
// Idem AccountController
```

#### 2.6 DashboardController — separar dados da view
```php
// Criar GET /dashboard/summary → JsonResponse
// __invoke() → apenas return view('dashboard-wrapper')
// Corrigir bug: $user->profile → profiles()->first()
// Remover $defaultLimit hardcoded
```

---

## FASE 3 — Área Dev (Admin Only)

### 3.1 — Estrutura de arquivos

```
app/Http/Controllers/Dev/
    ApiCatalogController.php    ← index + proxy de test

resources/views/dev/
    layout.blade.php            ← shell da área dev
    api-catalog.blade.php       ← catálogo visual
```

### 3.2 — Rotas da Área Dev

```php
Route::middleware(['auth', 'admin'])->prefix('dev')->name('dev.')->group(function () {
    Route::get('/', fn() => redirect()->route('dev.catalog'))->name('home');
    Route::get('/catalog',              [ApiCatalogController::class, 'index'])->name('catalog');
    Route::post('/catalog/probe',       [ApiCatalogController::class, 'probe'])->name('catalog.probe');
});
```

### 3.3 — ApiCatalogController

```php
class ApiCatalogController extends Controller
{
    // index: carrega config/api-catalog.php
    // Agrega stats: total por módulo, quantos active/planned/deprecated
    // Para cada endpoint active: faz HEAD request interno para verificar status HTTP

    public function index(): View
    {
        $catalog   = config('api-catalog.modules');
        $stats     = $this->buildStats($catalog);
        return view('dev.api-catalog', compact('catalog', 'stats'));
    }

    // probe: dispara o endpoint selecionado com params do usuário
    // Retorna: status HTTP, tempo de resposta, headers, corpo JSON formatado
    public function probe(Request $request): JsonResponse
    {
        // Faz request interno via Http::withToken(...)
        // Captura: status, duration, response body, headers
        // Retorna como JSON para o frontend exibir
    }
}
```

### 3.4 — UI da Área Dev (wireframe)

```
┌────────────────────────────────────────────────────────────────────┐
│  🔧 ÁREA DEV — API Explorer                        [admin@fin.com] │
├────────┬───────────────────────────────────────────────────────────┤
│        │                                                           │
│ MÓDULOS│  📦 accounts (7 endpoints)  ● 5 active  ○ 2 planned      │
│        │  ┌─────────────────────────────────────────────────────┐ │
│ ● Dash │  │ METHOD  URI                      STATUS  LATENCY    │ │
│ ● Acct │  │ GET     /accounts                ✅ 200   12ms      │ │
│ ● Card │  │ POST    /accounts                ✅ 201   —         │ │
│ ● Tran │  │ GET     /accounts/{id}           ✅ 200   8ms       │ │
│ ● Cat  │  │ PATCH   /accounts/{id}           ✅ 200   —         │ │
│ ● Lim  │  │ DELETE  /accounts/{id}           ✅ 204   —         │ │
│ ● Goal │  │ GET     /accounts/{id}/transact  ○ planned          │ │
│ ● Inst │  │ PATCH   /accounts/{id}/toggle    ○ planned          │ │
│ ● Inv  │  └─────────────────────────────────────────────────────┘ │
│ ● Loan │                                                           │
│ ● Rep  │  [▶ TESTAR ENDPOINT]  ← abre painel lateral             │
│        │                                                           │
│        │  ┌── Painel de Teste ───────────────────────────────┐    │
│        │  │ GET /accounts                                     │    │
│        │  │ Headers: Authorization: Bearer ***               │    │
│        │  │ Params: (nenhum)                         [FIRE]  │    │
│        │  │ ─────────────────────────────────────────────    │    │
│        │  │ Response: 200 OK  |  12ms                        │    │
│        │  │ [{ "id": 1, "name": "Nubank", ... }]             │    │
│        │  └──────────────────────────────────────────────────┘    │
└────────┴───────────────────────────────────────────────────────────┘
```

### 3.5 — Funcionalidades do Explorer

| Funcionalidade | Descrição |
|----------------|-----------|
| **Catálogo por módulo** | Todos os endpoints agrupados, com status visual (active/planned/deprecated) |
| **Health check automático** | Ao carregar a página, faz HEAD em todos os endpoints `active` e exibe latência + status HTTP |
| **Endpoint Tester** | Seleciona endpoint, preenche params, dispara request, exibe response formatado |
| **Status badge** | ✅ 200/201/204, ❌ 4xx/5xx, ○ planned |
| **Copy cURL** | Botão que gera o comando `curl` equivalente |
| **Filtro por módulo** | Sidebar clicável por módulo |
| **Filtro por status** | Active / Planned / Deprecated |

---

## FASE 4 — Módulos Novos (Installment, Investment, Loan)

Após fases 1-3, implementar os 3 controllers ausentes seguindo o padrão JSON estabelecido:

```
InstallmentController (index, pending, pay, update, destroy)
InvestmentController  (index, store, update, destroy, summary)
LoanController        (index, store, update, pay, destroy)
```

---

## Ordem de Implementação Recomendada

```
DIA 1 — Infraestrutura
  ├─ Migration is_admin
  ├─ Middleware EnsureIsAdmin
  ├─ config/api-catalog.php
  └─ Fix bugs críticos (routes: cards.except, goals.progress)

DIA 2 — Refatoração JSON
  ├─ LimitController → JSON
  ├─ GoalController → JSON
  └─ AccountController → JSON (remove dual)

DIA 3 — Refatoração JSON (cont.)
  ├─ TransactionController → JSON (remove dual)
  └─ DashboardController → separar view/api

DIA 4 — Área Dev
  ├─ ApiCatalogController
  ├─ view dev/api-catalog.blade.php
  └─ Rotas /dev/*

DIA 5 — Novos módulos
  ├─ InstallmentController
  ├─ InvestmentController
  └─ LoanController
```

---

## Estimativa Total

| Fase | Esforço |
|------|---------|
| Fase 1 — Infra (is_admin + middleware + config + bugs) | ~2h |
| Fase 2 — Refatoração JSON (6 controllers) | ~5h |
| Fase 3 — Área Dev | ~4h |
| Fase 4 — Novos controllers (3 módulos) | ~3h |
| **Total** | **~14h** |
