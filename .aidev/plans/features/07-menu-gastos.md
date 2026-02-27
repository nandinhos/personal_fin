# Feature: Menu Gastos com Carrossel e Filtros

**Status:** ⏳ Pendente
**Prioridade:** 🟢 Baixa

---

## Objetivo

Interface melhorada para página de transações (Gastos) com carrossel de mês/ano e filtros.

---

## Tarefas

| # | Tarefa | Prioridade | Status |
|---|--------|------------|--------|
| G.1 | Implementar carrossel de seleção de Mês | 🔴 CRÍTICA | ⏳ Pendente |
| G.2 | Implementar carrossel de seleção de Ano | 🔴 CRÍTICA | ⏳ Pendente |
| G.3 | Adicionar badges de filtro: "Geral", "Receitas", "Despesas" | 🔴 CRÍTICA | ⏳ Pendente |
| G.4 | Criar card com gráfico de barras laterais por categoria | 🟡 Média | ⏳ Pendente |
| G.5 | Integrar filtros com listagem de transações | 🟡 Média | ⏳ Pendente |

---

## Implementação Sugerida

### Backend
- Modificar `TransactionController::index()` para aceitar `?month=1-12&year=2026&type=income|expense`
- Adicionar método para buscar totais por categoria

### Frontend
- Modificar view de transações (`transactions/index.blade.php`)
- Carrossel horizontal para seleção de mês (botões < Mês >)
- Seleção de ano (dropdown ou carrossel)
- Badges clicáveis para filtros: Geral | Receitas | Despesas
- Gráfico de barras lateral (Chart.js) com gastos por categoria
- Atualizar listagem via AJAX ou página com parâmetros
