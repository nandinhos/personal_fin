# Feature: Cards de Receitas/Despesas Clicáveis

**Status:** ✅ Implementado
**Data:** 2026-02-27
**Prioridade:** 🟡 Média

---

## Objetivo

Cards clicáveis que abrem listagem de transações com filtro específico (receitas ou despesas).

---

## Tarefas Concluídas

| # | Tarefa | Status |
|---|--------|--------|
| R.1 | Tornar card "Receitas (Mês)" clicável | ✅ |
| R.2 | Tornar card "Despesas (Mês)" clicável | ✅ |
| R.3 | Ao clicar, abrir página de transações com filtro específico | ✅ |
| R.4 | Implementar filtros na página de transações (type=income/expense) | ✅ |

---

## Implementação

**Arquivos:**
- `app/Http/Controllers/TransactionController.php` - Suporte a filtro `?type=`
- `resources/views/livewire/dashboard.blade.php` - Cards clicáveis

**Funcionalidades:**
- Card Receitas → `/transactions?type=income`
- Card Despesas → `/transactions?type=expense`
- TransactionController já suporta filtro via query string
