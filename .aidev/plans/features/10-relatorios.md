# Feature: Relatórios para Gestão de Finanças Pessoais

**Status:** ⏳ Pendente
**Prioridade:** 🟢 Baixa

---

## Objetivo

Implementar relatórios úteis para finanças pessoais com visualização de dados e gráficos.

---

## Relatórios Sugeridos

| # | Relatório | Descrição |
|---|-----------|-----------|
| REL.1 | **Evolução Patrimonial** | Evolução do patrimônio ao longo do tempo |
| REL.2 | **Fluxo de Caixa** | Entradas vs saídas por período |
| REL.3 | **Gastos por Categoria** | Pizza/barra de despesas por categoria |
| REL.4 | **Comparativo Mensal** | Comparar meses anteriores |
| REL.5 | **Gastos por Cartão** | Breakdown de gastos por cartão |
| REL.6 | **Gastos por Conta** | Breakdown de gastos por conta |
| REL.7 | **Top Gastos** | Maiores despesas do período |
| REL.8 | **Receitas vs Despesas** | Gráfico comparativo |
| REL.9 | **Projeção de Gastos** | Estimar gastos no final do mês |
| REL.10 | **Análise de Metas** | Progresso das metas de reserva |

---

## Tarefas

| # | Tarefa | Prioridade | Status |
|---|--------|------------|--------|
| REL.1 | Implementar endpoint de cada relatório | 🟡 Média | ⏳ Pendente |
| REL.2 | Criar UI para visualização de relatórios | 🟡 Média | ⏳ Pendente |
| REL.3 | Adicionar gráficos (Chart.js ou similar) | 🟡 Média | ⏳ Pendente |
| REL.4 | Exportar relatório (PDF/Excel) | 🟢 Baixa | ⏳ Pendente |

---

## Implementação Sugerida

### Backend
- Criar `ReportController` com métodos para cada relatório
- Rotas já existem em `routes/web.php`:
  - `/reports/expenses-by-category`
  - `/reports/income-expense`
  - `/reports/monthly`
  - `/reports/by-card`
  - `/reports/by-account`
- Adicionar mais endpoints conforme necessidade

### Frontend
- Criar página `/reports` com menu de seleção
- Usar Chart.js para visualizações:
  - Gráfico de pizza para gastos por categoria
  - Gráfico de linhas para evolução patrimonial
  - Gráfico de barras para comparativo mensal
- Implementar filtros de período
- (Opcional) Exportação via DOMPDF ou similar
