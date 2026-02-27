# Feature: Gerenciador de Cartão com Faturas Futuras

**Status:** ⏳ Pendente
**Prioridade:** 🟡 Média
**Dependências:** 5 (padrão)

---

## Objetivo

Extrato por cartão de crédito + visualização estilo Nubank de faturas futuras.

---

## Tarefas

| # | Tarefa | Prioridade | Status |
|---|--------|------------|--------|
| CC.1 | Tornar card de cartão clicável | 🔴 CRÍTICA | ⏳ Pendente |
| CC.2 | Criar página de extrato do cartão | 🔴 CRÍTICA | ⏳ Pendente |
| CC.3 | Criar módulo de faturas futuras (style Nubank) | 🔴 CRÍTICA | ⏳ Pendente |
| CC.4 | Exibir previsão de fatura por mês futuro | 🟡 Média | ⏳ Pendente |
| CC.5 | Permitir personalizar cor do cartão (Glassmorphism) | 🟡 Média | ⏳ Pendente |
| CC.6 | Exibir limite disponível e utilizado | 🟡 Média | ⏳ Pendente |

---

## Implementação Sugerida

### Backend
- Criar `CardStatementController`
- Rota `/cards/{card}/statement`
- Calcular faturas abertas e futuras baseado nas transações com `card_id`
- Considerar data de fechamento e vencimento do cartão

### Frontend
- Tornar cards de cartões clicáveis no dashboard
- Criar view de extrato do cartão
- Estilo Nubank: fatura atual + gráficos de gastos futuros
- Card visual com cor personalizável
- Exibir limite total e disponível
