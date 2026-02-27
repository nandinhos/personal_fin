# 🚀 FEATURE: Melhorias e Funcionalidades do Frontend

**Data:** 2026-02-27
**Status:** 🔄 Em Andamento (6/10 implementadas)
**Origem:** Solicitação do usuário

---

## Objetivo

Implementar melhorias de UX/UI e funcionalidades pendentes identificadas durante testes manuais do sistema.

---

## 1. Botões de Ação Rápida do Dashboard

**Objetivo:** Implementar botões "+ Nova Receita" e "- Nova Despesa" funcionais

**Status:** ✅ Implementado

### Tarefas

| # | Tarefa | Prioridade | Status |
|---|--------|------------|--------|
| B.1 | Criar modal de Quick Add para transações | 🔴 CRÍTICA | ✅ Concluído |
| B.2 | Integrar botão "+ Nova Receita" com modal de receita | 🔴 CRÍTICA | ✅ Concluído |
| B.3 | Integrar botão "- Nova Despesa" com modal de despesa | 🔴 CRÍTICA | ✅ Concluído |
| B.4 | Ao salvar, atualizar dados do dashboard em tempo real | 🟡 Média | ✅ Concluído |

---

## 2. Card Limite Mensal Clicável

**Objetivo:** Card clicável que abre gerenciador de limites por tipo

**Status:** ✅ Implementado

### Tarefas

| # | Tarefa | Prioridade | Status |
|---|--------|------------|--------|
| L.1 | Tornar card "Limite Mensal" clicável | 🔴 CRÍTICA | ✅ Concluído |
| L.2 | Criar página de gerenciador de limites | 🔴 CRÍTICA | ✅ Concluído |
| L.3 | Listar cada tipo de limite por linha no card | 🟡 Média | ✅ Concluído |
| L.4 | CRUD para configurar limites por categoria/tipo | 🟡 Média | ✅ Concluído |
| L.5 | Exibir percentual utilizado em cada linha do card | 🟡 Média | ✅ Concluído |

---

## 3. Card Metas de Reserva Clicável

**Objetivo:** Card clicável para gerenciamento de metas de reserva

**Status:** ✅ Implementado

### Tarefas

| # | Tarefa | Prioridade | Status |
|---|--------|------------|--------|
| M.1 | Tornar card "Metas de Reserva" clicável | 🔴 CRÍTICA | ✅ Concluído |
| M.2 | Criar página de gerenciamento de metas | 🔴 CRÍTICA | ✅ Concluído |
| M.3 | Exibir percentual de cada meta por linha no card | 🟡 Média | ✅ Concluído |
| M.4 | CRUD de metas de reserva (nome, valor alvo, prazo) | 🟡 Média | ✅ Concluído |
| M.5 | Barra de progresso para cada meta | 🟡 Média | ✅ Concluído |

---

## 4. Cards de Receitas/Despesas Clicáveis

**Objetivo:** Cards clicáveis abrem listagem de transações com filtro

**Status:** ✅ Implementado

### Tarefas

| # | Tarefa | Prioridade | Status |
|---|--------|------------|--------|
| R.1 | Tornar card "Receitas (Mês)" clicável | 🔴 CRÍTICA | ✅ Concluído |
| R.2 | Tornar card "Despesas (Mês)" clicável | 🔴 CRÍTICA | ✅ Concluído |
| R.3 | Ao clicar, abrir página de transações com filtro específico | 🔴 CRÍTICA | ✅ Concluído |
| R.4 | Implementar filtros na página de transações (type=income/expense) | 🟡 Média | ✅ Concluído |

---

## 5. Gerenciador de Conta Específico

**Objetivo:** Ao clicar no card da conta, abrir extrato de movimentos

### Tarefas

| # | Tarefa | Prioridade | Status |
|---|--------|------------|--------|
| GC.1 | Tornar card de conta clicável | 🔴 CRÍTICA | ⏳ Pendente |
| GC.2 | Criar página de extrato da conta | 🔴 CRÍTICA | ⏳ Pendente |
| GC.3 | Listar transações relacionadas à conta | 🔴 CRÍTICA | ⏳ Pendente |
| GC.4 | Exibir saldo inicial, movimentações e saldo final | 🟡 Média | ⏳ Pendente |
| GC.5 | Filtros por período no extrato | 🟡 Média | ⏳ Pendente |

---

## 6. Gerenciador de Cartão com Faturas Futuras

**Objetivo:** Extrato por cartão + visualização estilo Nubank de faturas futuras

### Tarefas

| # | Tarefa | Prioridade | Status |
|---|--------|------------|--------|
| CC.1 | Tornar card de cartão clicável | 🔴 CRÍTICA | ⏳ Pendente |
| CC.2 | Criar página de extrato do cartão | 🔴 CRÍTICA | ⏳ Pendente |
| CC.3 | Criar módulo de faturas futuras (style Nubank) | 🔴 CRÍTICA | ⏳ Pendente |
| CC.4 | Exibir previsão de fatura por mês futuro | 🟡 Média | ⏳ Pendente |
| CC.5 | Permitir personalizar cor do cartão (Glassmorphism) | 🟡 Média | ⏳ Pendente |
| CC.6 | Exibir limite disponível e utilizado | 🟡 Média | ⏳ Pendente |

---

## 7. Menu Gastos com Carrossel e Filtros

**Objetivo:** Interface melhorada para página de transações

### Tarefas

| # | Tarefa | Prioridade | Status |
|---|--------|------------|--------|
| G.1 | Implementar carrossel de seleção de Mês | 🔴 CRÍTICA | ⏳ Pendente |
| G.2 | Implementar carrossel de seleção de Ano | 🔴 CRÍTICA | ⏳ Pendente |
| G.3 | Adicionar badges de filtro: "Geral", "Receitas", "Despesas" | 🔴 CRÍTICA | ⏳ Pendente |
| G.4 | Criar card com gráfico de barras laterais por categoria | 🟡 Média | ⏳ Pendente |
| G.5 | Integrar filtros com listagem de transações | 🟡 Média | ⏳ Pendente |

---

## 8. CRUD Completo de Categorias

**Objetivo:** Funcionalidades completas de CRUD para categorias e subcategorias

**Status:** ✅ Implementado

### Tarefas

| # | Tarefa | Prioridade | Status |
|---|--------|------------|--------|
| C.1 | Criar nova categoria (botão funcional) | 🔴 CRÍTICA | ✅ Concluído |
| C.2 | Criar nova subcategoria | 🔴 CRÍTICA | ✅ Concluído |
| C.3 | Editar categoria | 🔴 CRÍTICA | ✅ Concluído |
| C.4 | Editar subcategoria | 🔴 CRÍTICA | ✅ Concluído |
| C.5 | Deletar categoria com aviso de desassociação | 🔴 CRÍTICA | ✅ Concluído |
| C.6 | Deletar subcategoria | 🔴 CRÍTICA | ✅ Concluído |
| C.7 | Ao deletar categoria com movimentos, associar a "Sem Categoria" | 🔴 CRÍTICA | ✅ Concluído |

---

## 9. Abas Funcionais na Página de Categorias

**Objetivo:** Corrigir e implementar abas de Despesas/Receitas

**Status:** ✅ Implementado

### Tarefas

| # | Tarefa | Prioridade | Status |
|---|--------|------------|--------|
| A.1 | Corrigir funcionamento da aba "Despesas" | 🔴 CRÍTICA | ✅ Concluído |
| A.2 | Corrigir funcionamento da aba "Receitas" | 🔴 CRÍTICA | ✅ Concluído |
| A.3 | Testar alternância entre abas | 🟡 Média | ✅ Concluído |
| A.4 | Persistir estado da aba selecionada | 🟢 Baixa | ✅ Concluído |

---

## 10. Relatórios para Gestão de Finanças Pessoais

**Objetivo:** Implementar relatórios úteis para finanças pessoais

### Relatórios Sugeridos

| # | Relatório | Descrição | Prioridade |
|---|-----------|-----------|------------|
| REL.1 | **Evolução Patrimonial** | Evolução do patrimônio ao longo do tempo | 🟡 Média |
| REL.2 | **Fluxo de Caixa** | Entradas vs saídas por período | 🔴 CRÍTICA |
| REL.3 | **Gastos por Categoria** | Pizza/barra de despesas por categoria | 🔴 CRÍTICA |
| REL.4 | **Comparativo Mensal** | Comparar meses anteriores | 🟡 Média |
| REL.5 | **Gastos por Cartão** | Breakdown de gastos por cartão | 🟡 Média |
| REL.6 | **Gastos por Conta** | Breakdown de gastos por conta | 🟡 Média |
| REL.7 | **Top Gastos** | Maiores despesas do período | 🟡 Média |
| REL.8 | **Receitas vs Despesas** | Gráfico comparativo | 🔴 CRÍTICA |
| REL.9 | **Projeção de Gastos** | Estimar gastos no final do mês | 🟢 Baixa |
| REL.10 | **Análise de Metas** | Progresso das metas de reserva | 🟡 Média |

### Tarefas

| # | Tarefa | Prioridade | Status |
|---|--------|------------|--------|
| REL.1 | Implementar endpoint de cada relatório | 🟡 Média | ⏳ Pendente |
| REL.2 | Criar UI para visualização de relatórios | 🟡 Média | ⏳ Pendente |
| REL.3 | Adicionar gráficos (Chart.js ou similar) | 🟡 Média | ⏳ Pendente |
| REL.4 | Exportar relatório (PDF/Excel) | 🟢 Baixa | ⏳ Pendente |

---

## Stack do Projeto

- Laravel 12
- Livewire 4
- Tailwind CSS
- PostgreSQL
- Design System: Glassmorphism + Dark Mode

---

## 📊 Análise de Dependência, Complexidade e Prioridade

### Legenda

| Símbolo | Significado |
|---------|-------------|
| 🔴 CRÍTICA | Essential para MVP |
| 🟡 Média | Importante |
| 🟢 Baixa | Fase futura |
| ⬆️ Simple | Baixa complexidade (1-2 dias) |
| ⬆️⬆️ Medium | Média complexidade (3-5 dias) |
| ⬆️⬆️⬆️ Complex | Alta complexidade (5+ dias) |

---

### Matriz de Dependências

| Feature | Depende de | Bloqueia |
|---------|------------|----------|
| **1. Botões Ação Rápida** | nenhuma | 4 |
| **2. Card Limite** | 1 (modal base) | nenhuma |
| **3. Card Metas** | 1 (modal base) | nenhuma |
| **4. Cards Rec/Desp** | 1 (modal base) | nenhuma |
| **5. Gerenciador Conta** | nenhuma | nenhuma |
| **6. Gerenciador Cartão** | 5 (padrão) | nenhuma |
| **7. Menu Gastos** | nenhuma | nenhuma |
| **8. CRUD Categorias** | 9 (abas) | nenhuma |
| **9. Abas Categorias** | nenhuma | 8 |
| **10. Relatórios** | 7 (dados) | nenhuma |

---

### Análise por Feature

#### 🔴 PRIORIDADE 1 - Fundamentais (Semanas 1-2)

| Feature | Complexidade | Esforço | Justificativa |
|---------|--------------|---------|----------------|
| **9. Abas Categorias** | ⬆️ Simple | 1 dia | Resolve problema crítico de UX; bloqueia feature 8 |
| **8. CRUD Categorias** | ⬆️ Simple | 2 dias | Funcionalidade básica necessária para o sistema funcionar |
| **1. Botões Ação Rápida** | ⬆️ Medium | 2 dias | Base para todas as outras funcionalidades de transação |

**Impacto:** Resolve problemas críticos de usabilidade e cria base para outras features.

---

#### 🟡 PRIORIDADE 2 - Dashboard Interativo (Semanas 2-3)

| Feature | Complexidade | Esforço | Justificativa |
|---------|--------------|---------|----------------|
| **4. Cards Rec/Desp** | ⬆️ Simple | 1 dia | Melora navegação sem complexidade |
| **2. Card Limite** | ⬆️⬆️ Medium | 3 dias | Requer nova página + CRUD de limites |
| **3. Card Metas** | ⬆️⬆️ Medium | 3 dias | Semelhante ao limite; pode usar mesma base |

**Impacto:** Torna o dashboard mais interativo e útil para o usuário.

---

#### 🟡 PRIORIDADE 3 - Gestão de Contas e Cartões (Semanas 3-4)

| Feature | Complexidade | Esforço | Justificativa |
|---------|--------------|---------|----------------|
| **5. Gerenciador Conta** | ⬆️⬆️ Medium | 3 dias | Essencial para gestão financeira |
| **6. Gerenciador Cartão** | ⬆️⬆️⬆️ Complex | 5 dias | Requer faturas futuras; feature mais complexa |

**Impacto:** Funcionalidades avançadas de gestão de contas.

---

#### 🟢 PRIORIDADE 4 - Melhorias UI/UX (Semanas 4-5)

| Feature | Complexidade | Esforço | Justificativa |
|---------|--------------|---------|----------------|
| **7. Menu Gastos** | ⬆️⬆️ Medium | 3 dias | Melora experiência de uso |

**Impacto:** Melhora significativa na usabilidade.

---

#### 🟢 PRIORIDADE 5 - Relatórios (Semanas 5-6+)

| Feature | Complexidade | Esforço | Justificativa |
|---------|--------------|---------|----------------|
| **10. Relatórios** | ⬆️⬆️⬆️ Complex | 5-7 dias | Pode ser implementado em fases |

**Impacto:** Funcionalidade de valor agregado; pode ser adiada.

---

### 🚀 Fluxo de Implementação Recomendado

```
SEMANA 1                    SEMANA 2                    SEMANA 3
┌─────────────────────┐    ┌─────────────────────┐    ┌─────────────────────┐
│  9. Abas Categorias │ →  │  8. CRUD Categorias │ →  │  4. Cards Rec/Desp  │
│     (1 dia)         │    │     (2 dias)        │    │     (1 dia)         │
└─────────────────────┘    └─────────────────────┘    └─────────────────────┘
                                                                
┌─────────────────────┐    ┌─────────────────────┐    ┌─────────────────────┐
│  1. Botões Ação     │    │  2. Card Limite     │    │  3. Card Metas      │
│     (2 dias)        │    │     (3 dias)        │    │     (3 dias)        │
└─────────────────────┘    └─────────────────────┘    └─────────────────────┘

SEMANA 4                    SEMANA 5                    SEMANA 6+
┌─────────────────────┐    ┌─────────────────────┐    ┌─────────────────────┐
│  5. Gerenciador     │    │  6. Gerenc. Cartão  │    │  10. Relatórios    │
│     Conta (3 dias)  │    │     (5 dias)        │    │     (5-7 dias)     │
└─────────────────────┘    └─────────────────────┘    └─────────────────────┘
                                           │
                                           ▼
                                    ┌─────────────────────┐
                                    │  7. Menu Gastos     │
                                    │     (3 dias)        │
                                    └─────────────────────┘
```

---

### 📈 Resumo de Esforço Total

| Fase | Features | Dias Totais |
|------|----------|-------------|
| Prioridade 1 | 3 | 5 dias |
| Prioridade 2 | 3 | 7 dias |
| Prioridade 3 | 2 | 8 dias |
| Prioridade 4 | 1 | 3 dias |
| Prioridade 5 | 1 | 5-7 dias |
| **TOTAL** | **10** | **28-30 dias** |

---

### ✅ Recomendação de Priorização

1. **Começar por:** 9 (Abas) → 8 (CRUD) → 1 (Botões ação)
   - Resolve problemas críticos immediately
   - Cria base sólida para o resto

2. **Próximo:** 2 (Limite) → 3 (Metas) → 4 (Cards clicáveis)
   - Dashboard interativo
   - Boa relação impacto/esforço

3. **Depois:** 5 (Conta) → 6 (Cartão) → 7 (Menu Gastos)
   - Funcionalidades avançadas

4. **Por último:** 10 (Relatórios)
   - Feature de valor mas não blocking
