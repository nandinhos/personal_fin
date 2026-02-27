# 🗺️ ROADMAP DE IMPLEMENTAÇÃO - personal_fin

> Sistema de Gerenciamento de Finanças Pessoais (PFM)
> Formato: AI Dev Superpowers Sprint Planning
> Status: Ativo

---

## 📋 VISÃO GERAL

**Stack:** Laravel 12 + Livewire 4 + Tailwind CSS + PostgreSQL
**Design:** Glassmorphism + Dark Mode (mobile-first)

Este documento serve como **fonte única de verdade** para implementação de funcionalidades no projeto.

---

## 🎯 SPRINTS PLANEJADOS

---

### 📅 SPRINT 1: Fundamentos & Autenticação
**Objetivo:** Setup + Auth + Design System Base
**Status:** 🔴 Em andamento

| # | Tarefa | Prioridade | Status |
|---|--------|------------|--------|
| 1.1 | Setup Laravel 12 + Docker | 🔴 CRÍTICA | ✅ Concluído |
| 1.2 | Laravel Breeze (Auth) | 🔴 CRÍTICA | ✅ Concluído |
| 1.3 | Migration: profiles, categories, subcategories | 🔴 CRÍTICA | ✅ Concluído |
| 1.4 | Models: Profile, Category, Subcategory | 🔴 CRÍTICA | ✅ Concluído |
| 1.5 | Controllers + Routes REST | 🟡 Média | ✅ Concluído |
| 1.6 | Seeders categorias PT-BR | 🟡 Média | ⏳ Pendente |
| 1.7 | Design System (Glassmorphism + Dark Mode) | 🔴 CRÍTICA | ⏳ Pendente |
| 1.8 | Layout base com Bottom Navigation | 🔴 CRÍTICA | ⏳ Pendente |

**Próximas tarefas:**
- [ ] Executar migrações
- [ ] Seeders com categorias padrão
- [ ] Configurar Tailwind CSS
- [ ] Criar layout base

---

### 📅 SPRINT 2: Dashboard MVP
**Objetivo:** Dashboard com UI profissional + dados mockados
**Status:** ⏳ Pendente

| # | Tarefa | Prioridade | Status |
|---|--------|------------|--------|
| 2.1 | Layout Livewire + Tailwind | 🔴 CRÍTICA | ⏳ Pendente |
| 2.2 | Bottom Navigation Mobile | 🔴 CRÍTICA | ⏳ Pendente |
| 2.3 | Card Saldo/Receitas/Despesas (Glass) | 🔴 CRÍTICA | ⏳ Pendente |
| 2.4 | Cards expansíveis (projetado/futuro) | 🟡 Média | ⏳ Pendente |
| 2.5 | Mock data para demonstração | 🟡 Média | ⏳ Pendente |
| 2.6 | Toggle Dark/Light Mode | 🟡 Média | ⏳ Pendente |

---

### 📅 SPRINT 3: Contas & Cartões
**Status:** ⏳ Pendente

| # | Tarefa | Prioridade | Status |
|---|--------|------------|--------|
| 3.1 | Migration: accounts, cards | 🔴 CRÍTICA | ⏳ Pendente |
| 3.2 | Model: Account, Card | 🔴 CRÍTICA | ⏳ Pendente |
| 3.3 | CRUD Accounts API + UI | 🔴 CRÍTICA | ⏳ Pendente |
| 3.4 | CRUD Cards API + UI | 🔴 CRÍTICA | ⏳ Pendente |
| 3.5 | Dashboard Cards (estilo físico) | 🔴 CRÍTICA | ⏳ Pendente |
| 3.6 | Fatura do cartão (por período) | 🟡 Média | ⏳ Pendente |

---

### 📅 SPRINT 4: Transações Core
**Status:** ⏳ Pendente

| # | Tarefa | Prioridade | Status |
|---|--------|------------|--------|
| 4.1 | Migration: transactions | 🔴 CRÍTICA | ⏳ Pendente |
| 4.2 | Model: Transaction | 🔴 CRÍTICA | ⏳ Pendente |
| 4.3 | Transactions API (CRUD) | 🔴 CRÍTICA | ⏳ Pendente |
| 4.4 | Listagem com filtros | 🔴 CRÍTICA | ⏳ Pendente |
| 4.5 | Formulário de transação | 🔴 CRÍTICA | ⏳ Pendente |
| 4.6 | Carrossel Ano/Mês | 🟡 Média | ⏳ Pendente |
| 4.7 | Modal de Quick Add (+) | 🔴 CRÍTICA | ⏳ Pendente |

---

### 📅 SPRINT 5: Transações Avançadas
**Status:** ⏳ Pendente

| # | Tarefa | Prioridade | Status |
|---|--------|------------|--------|
| 5.1 | Migration: installments | 🟡 Média | ⏳ Pendente |
| 5.2 | Model: Installment | 🟡 Média | ⏳ Pendente |
| 5.3 | Transação parcelada | 🟡 Média | ⏳ Pendente |
| 5.4 | Transação recorrente | 🟡 Média | ⏳ Pendente |
| 5.5 | Cron jobs para recorrências | 🟡 Média | ⏳ Pendente |

---

### 📅 SPRINT 6: Metas & Limites
**Status:** ⏳ Pendente

| # | Tarefa | Prioridade | Status |
|---|--------|------------|--------|
| 6.1 | Migration: goals, limits | 🟡 Média | ⏳ Pendente |
| 6.2 | Model: Goal, Limit | 🟡 Média | ⏳ Pendente |
| 6.3 | Goals CRUD + Barra de progresso | 🟡 Média | ⏳ Pendente |
| 6.4 | Limits por categoria | 🟡 Média | ⏳ Pendente |
| 6.5 | Alertas (80% limite) | 🟡 Média | ⏳ Pendente |

---

### 📅 SPRINT 7: Relatórios & Insights
**Status:** ⏳ Pendente

| # | Tarefa | Prioridade | Status |
|---|--------|------------|--------|
| 7.1 | Relatório por categoria/período/cartão/conta | 🟡 Média | ⏳ Pendente |
| 7.2 | Gráficos (Chart.js) | 🟡 Média | ⏳ Pendente |
| 7.3 | Insights inteligente | 🟢 Baixa | ⏳ Pendente |
| 7.4 | Export JSON/CSV | 🟢 Baixa | ⏳ Pendente |

---

### 📅 SPRINT 8: Investimentos & Empréstimos
**Status:** ⏳ Pendente

| # | Tarefa | Prioridade | Status |
|---|--------|------------|--------|
| 8.1 | Migration: investments, loans | 🟢 Baixa | ⏳ Pendente |
| 8.2 | Model: Investment, Loan | 🟢 Baixa | ⏳ Pendente |
| 8.3 | CRUD Investments | 🟢 Baixa | ⏳ Pendente |
| 8.4 | CRUD Loans | 🟢 Baixa | ⏳ Pendente |

---

### 📅 SPRINT 9: Perfil & Configurações
**Status:** ⏳ Pendente

| # | Tarefa | Prioridade | Status |
|---|--------|------------|--------|
| 9.1 | Dados do usuário (Avatar, Badge) | 🟡 Média | ⏳ Pendente |
| 9.2 | Configurações de notificações | 🟢 Baixa | ⏳ Pendente |
| 9.3 | Gerenciamento de categorias (UI) | 🟡 Média | ⏳ Pendente |
| 9.4 | Feedback e problemas | 🟢 Baixa | ⏳ Pendente |
| 9.5 | Export/Import dados | 🟢 Baixa | ⏳ Pendente |

---

## 📊 RESUMO DE PRIORIDADES

| Sprint | Escopo | Tarefas | Status |
|--------|--------|---------|--------|
| 1 | Fundamentos & Auth | 8 | 🔴 Em andamento |
| 2 | Dashboard MVP | 6 | ⏳ Pendente |
| 3 | Contas & Cartões | 6 | ⏳ Pendente |
| 4 | Transações Core | 7 | ⏳ Pendente |
| 5 | Transações Avançadas | 5 | ⏳ Pendente |
| 6 | Metas & Limites | 5 | ⏳ Pendente |
| 7 | Relatórios | 4 | ⏳ Pendente |
| 8 | Investimentos | 4 | ⏳ Pendente |
| 9 | Perfil & Config | 5 | ⏳ Pendente |

---

## 🏷️ LEGENDA

| Símbolo | Significado |
|---------|-------------|
| 🔴 CRÍTICA | Essential para MVP |
| 🟡 Média | Importante |
| 🟢 Baixa | Fase futura |
| ✅ Concluído | Pronto |
| ⏳ Pendente | A fazer |
| 🔴 Em andamento | Em progresso |

---

## 🔄 FLUXO DE TRABALHO

1. **Selecionar Sprint**: Escolher sprint do backlog/roadmap
2. **Skill TDD**: Usar `aidev` com skill TDD para implementar
3. **Código**: Escrever teste → código → refatorar
4. **Revisão**: Code review antes de marcar concluído
5. **Próximo**: Avançar para próxima tarefa

---

## 📁 ARQUITETURA DE DADOS

```
users (Laravel Breeze)
  └── profiles (multi-perfil financeiro)
        ├── categories (receita/despesa)
        │     └── subcategories
        ├── accounts (contas bancárias)
        ├── cards (cartões)
        ├── transactions (lançamentos)
        │     └── installments (parcelas)
        ├── goals (metas)
        ├── limits (limites por categoria)
        ├── investments
        └── loans (empréstimos)
```

---

**Versão:** 1.0
**Status:** Ativo
**Última atualização:** 2026-02-27
