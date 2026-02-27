# Feature: Gerenciador de Conta Específico

**Status:** ⏳ Pendente
**Prioridade:** 🟡 Média

---

## Objetivo

Ao clicar no card da conta no dashboard, abrir extrato de movimentos da conta específica.

---

## Tarefas

| # | Tarefa | Prioridade | Status |
|---|--------|------------|--------|
| GC.1 | Tornar card de conta clicável | 🔴 CRÍTICA | ⏳ Pendente |
| GC.2 | Criar página de extrato da conta | 🔴 CRÍTICA | ⏳ Pendente |
| GC.3 | Listar transações relacionadas à conta | 🔴 CRÍTICA | ⏳ Pendente |
| GC.4 | Exibir saldo inicial, movimentações e saldo final | 🟡 Média | ⏳ Pendente |
| GC.5 | Filtros por período no extrato | 🟡 Média | ⏳ Pendente |

---

## Implementação Sugerida

### Backend
- Criar `AccountStatementController` ou método no `AccountController`
- Rota `/accounts/{account}/statement`
- Query para listar transações da conta no período

### Frontend
- Na listagem de contas do dashboard, adicionar link clicável
- Criar view `accounts/statement.blade.php`
- Exibir saldo inicial (calculado até data inicial)
- Listar transações do período
- Calcular saldo final
- Filtros por data (mês/ano)
