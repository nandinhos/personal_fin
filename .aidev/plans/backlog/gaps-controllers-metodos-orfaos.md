# 🕳️ BACKLOG: Gaps — Controllers, Métodos Órfãos e Módulos Sem Implementação

**Data:** 2026-02-27
**Status:** 🟡 Parcialmente Concluído (2026-02-27)

**Itens resolvidos:**
- ✅ Cat.1: InstallmentController, InvestmentController, LoanController criados + rotas registradas
- ✅ Cat.2: `GoalController::updateProgress()` — rota `PATCH /goals/{goal}/progress` registrada
- ✅ Cat.3: `cards` resource com `->except(['create','edit'])` — 500 eliminado
- ✅ Dead code: `FinancialProfileController.php` deletado

**Itens pendentes (Cat.4 — Endpoints lógicos):**
- ⏳ `GET /accounts/{account}/transactions`
- ⏳ `GET /cards/{card}/transactions`
- ⏳ `PATCH /accounts/{account}/toggle`
- ⏳ `PATCH /cards/{card}/toggle`
- ⏳ `GET /cards/{card}/summary`
**Origem:** Análise de models vs controllers vs rotas
**Prioridade:** 🔴 CRÍTICA

---

## Diagnóstico

Após cruzar todos os **models**, **controllers** e **rotas registradas**, identificamos 4 categorias de lacunas no sistema:

---

## Categoria 1 — Módulos Completos Sem Controller nem Rota

Esses models têm **migration** e **model** criados, mas **zero implementação** de controller ou rota.

### `Installment` (Parcelas)

**Model:** `app/Models/Installment.php`

| Campo | Tipo |
|-------|------|
| `transaction_id` | FK → Transaction |
| `profile_id` | FK → Profile |
| `installment_number` | int |
| `total_installments` | int |
| `amount` | decimal |
| `due_date` | date |
| `paid_at` | date |
| `is_paid` | boolean |

**Endpoints necessários:**
```
GET    /installments             → listar parcelas do perfil (com filtros)
GET    /installments/pending     → parcelas em aberto
PATCH  /installments/{id}/pay   → marcar como paga
PATCH  /installments/{id}       → atualizar dados
DELETE /installments/{id}       → excluir
```

---

### `Investment` (Investimentos)

**Model:** `app/Models/Investment.php`

| Campo | Tipo |
|-------|------|
| `profile_id` | FK → Profile |
| `name` | string |
| `type` | string (enum: CDB, LCI, ações, FII...) |
| `amount` | decimal (valor investido) |
| `current_value` | decimal (valor atual) |
| `purchase_date` | date |

**Endpoints necessários:**
```
GET    /investments              → listar investimentos
POST   /investments              → criar
PATCH  /investments/{id}        → atualizar (ex: current_value)
DELETE /investments/{id}        → excluir
GET    /investments/summary     → total investido vs valor atual (rentabilidade)
```

---

### `Loan` (Empréstimos)

**Model:** `app/Models/Loan.php`

| Campo | Tipo |
|-------|------|
| `profile_id` | FK → Profile |
| `name` | string |
| `amount` | decimal (valor original) |
| `remaining_amount` | decimal (saldo devedor) |
| `interest_rate` | decimal |
| `installments` | int (total) |
| `paid_installments` | int (pagas) |
| `start_date` | date |
| `end_date` | date |
| `is_active` | boolean |

**Endpoints necessários:**
```
GET    /loans                    → listar empréstimos
POST   /loans                    → criar
PATCH  /loans/{id}              → atualizar
PATCH  /loans/{id}/pay          → registrar pagamento de parcela
DELETE /loans/{id}              → excluir
```

---

## Categoria 2 — Métodos no Controller Sem Rota Registrada

### `GoalController::updateProgress()`

**Arquivo:** `app/Http/Controllers/GoalController.php:87`

O método existe com lógica completa, mas **nenhuma rota aponta para ele** em `routes/web.php`.

```php
// Método existe, sem rota!
public function updateProgress(Request $request, Goal $goal) { ... }
```

**Rota necessária:**
```php
Route::patch('/goals/{goal}/progress', [GoalController::class, 'updateProgress']);
```

---

## Categoria 3 — Rotas Registradas Sem Método no Controller (500 imediato)

O `Route::resource()` sem `->except()` registra métodos que **não existem** no controller.

### `CardController` — Rotas `create` e `edit` sem implementação

```php
// routes/web.php — SEM except:
Route::resource('cards', CardController::class) ...
```

**Rotas registradas automaticamente mas sem método:**

| Rota | Método Esperado | Status |
|------|----------------|--------|
| `GET /cards/create` → `cards.create` | `CardController@create` | ❌ Não existe |
| `GET /cards/{card}/edit` → `cards.edit` | `CardController@edit` | ❌ Não existe |

**Resultado:** Qualquer request para essas rotas gera `BadMethodCallException: Method App\Http\Controllers\CardController::create does not exist`.

**Fix necessário:**
```php
Route::resource('cards', CardController::class)
    ->except(['create', 'edit'])
    ->parameters(['cards' => 'card']);
```

---

## Categoria 4 — Endpoints Lógicos Ausentes (Operações sem rota)

Operações que fazem sentido pelo modelo de dados mas não têm nenhum endpoint:

| Operação | Endpoint Sugerido | Controller |
|----------|------------------|------------|
| Transações de uma conta específica | `GET /accounts/{account}/transactions` | AccountController |
| Transações de um cartão específico | `GET /cards/{card}/transactions` | CardController |
| Resumo financeiro do dashboard | `GET /dashboard/summary` | (novo DashboardApiController) |
| Toggle ativo/inativo de conta | `PATCH /accounts/{account}/toggle` | AccountController |
| Toggle ativo/inativo de cartão | `PATCH /cards/{card}/toggle` | CardController |
| Dados consolidados do cartão (limite usado) | `GET /cards/{card}/summary` | CardController |

---

## Resumo dos Gaps

| Tipo | Quantidade | Prioridade |
|------|------------|------------|
| Módulos sem nenhuma implementação | 3 (Installment, Investment, Loan) | 🟡 Média |
| Métodos órfãos (sem rota) | 1 (updateProgress) | 🔴 CRÍTICA |
| Rotas 500 imediato (sem método) | 2 (cards.create, cards.edit) | 🔴 CRÍTICA |
| Endpoints lógicos ausentes | 6 | 🟡 Média |

---

## Fix Imediato Recomendado

Os **2 itens críticos** devem ser corrigidos antes de qualquer implementação nova:

1. `routes/web.php`: adicionar `->except(['create', 'edit'])` no resource de `cards`
2. `routes/web.php`: registrar rota `PATCH /goals/{goal}/progress`
