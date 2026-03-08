# 📋 BACKLOG - personal_fin (PFM)

> Sistema de Gerenciamento de Finanças Pessoais
> Stack: Laravel 12 + Livewire 4 + Tailwind CSS + PostgreSQL

---

## 🎯 SPRINTS

---

### � SPRINT 1: Fundamentos & Autenticação
**Status:** ✅ Em andamento
**Objetivo:** Setup + Auth + Design System Base

| # | Tarefa | Prioridade | Status |
|---|--------|------------|--------|
| 1.1 | Setup Laravel 12 + Docker | 🔴 CRÍTICA | ✅ Concluído |
| 1.2 | Laravel Breeze (Auth) | 🔴 CRÍTICA | ✅ Concluído |
| 1.3 | Migration: profiles | 🔴 CRÍTICA | ✅ Concluído |
| 1.4 | Migration: categories | 🔴 CRÍTICA | ✅ Concluído |
| 1.5 | Migration: subcategories | 🔴 CRÍTICA | ✅ Concluído |
| 1.6 | Models: Profile, Category, Subcategory | 🔴 CRÍTICA | ✅ Concluído |
| 1.7 | Controllers + Routes REST | 🟡 Média | ✅ Concluído |
| 1.8 | Seeders categorias PT-BR | 🟡 Média | ✅ Concluído |
| 1.9 | Design System (Glassmorphism + Dark Mode) | 🔴 CRÍTICA | ✅ Concluído |
| 1.10 | Layout base com Bottom Navigation | 🔴 CRÍTICA | ✅ Concluído |

---

### � SPRINT 2: Dashboard MVP
**Status:** ⏳ Pendente
**Objetivo:** Dashboard com UI profissional + dados mockados

| # | Tarefa | Prioridade | Status |
|---|--------|------------|--------|
| 2.1 | Layout Livewire + Tailwind | 🔴 CRÍTICA | ✅ Concluído |
| 2.2 | Bottom Navigation Mobile | 🔴 CRÍTICA | ✅ Concluído |
| 2.3 | Card Saldo/Receitas/Despesas (Glass) | 🔴 CRÍTICA | ✅ Concluído |
| 2.4 | Cards expansíveis (projetado/futuro) | 🟡 Média | ⏳ Pendente |
| 2.5 | Mock data para demonstração | 🟡 Média | ✅ Concluído |
| 2.6 | Toggle Dark/Light Mode | 🟡 Média | ✅ Concluído |

---

### � SPRINT 3: Contas & Cartões
**Status:** ⏳ Pendente
**Objetivo:** Gestão de contas bancárias e cartões

| # | Tarefa | Prioridade | Status |
|---|--------|------------|--------|
| 3.1 | Migration: accounts | 🔴 CRÍTICA | ✅ Concluído |
| 3.2 | Migration: cards | 🔴 CRÍTICA | ✅ Concluído |
| 3.3 | Model: Account, Card | 🔴 CRÍTICA | ✅ Concluído |
| 3.4 | CRUD Accounts API (Controllers/Routes) | 🔴 CRÍTICA | ✅ Concluído |
| 3.5 | CRUD Cards API (Controllers/Routes) | 🔴 CRÍTICA | ✅ Concluído |
| 3.6 | Dashboard Cards (UI Livewire) | 🔴 CRÍTICA | ⏳ Pendente |
| 3.7 | Fatura do cartão (Lógica Backend) | 🟡 Média | ✅ Concluído |

---

### � SPRINT 4: Transações Core
**Status:** ⏳ Pendente
**Objetivo:** Cadastro e listagem de transações

| # | Tarefa | Prioridade | Status |
|---|--------|------------|--------|
| 4.1 | Migration: transactions | 🔴 CRÍTICA | ✅ Concluído |
| 4.2 | Model: Transaction | 🔴 CRÍTICA | ✅ Concluído |
| 4.3 | Transactions API (CRUD Backend) | 🔴 CRÍTICA | ✅ Concluído |
| 4.4 | Listagem com filtros (Lógica Backend) | 🔴 CRÍTICA | ✅ Concluído |
| 4.5 | Formulário de transação (UI) | 🔴 CRÍTICA | ⏳ Pendente |
| 4.6 | Carrossel Ano/Mês (UI) | 🟡 Média | ⏳ Pendente |
| 4.7 | Modal de Quick Add (+) (UI) | 🔴 CRÍTICA | ⏳ Pendente |

---

### � SPRINT 5: Transações Avançadas
**Status:** ⏳ Pendente
**Objetivo:** Parcelamento e recorrência

| # | Tarefa | Prioridade | Status |
|---|--------|------------|--------|
| 5.1 | Migration: installments | 🟡 Média | ⏳ Pendente |
| 5.2 | Model: Installment | 🟡 Média | ⏳ Pendente |
| 5.3 | Transação parcelada | 🟡 Média | ⏳ Pendente |
| 5.4 | Transação recorrente | 🟡 Média | ⏳ Pendente |
| 5.5 | Cron jobs para recorrências | 🟡 Média | ⏳ Pendente |
| 5.6 | Listagem de parcelas | 🟡 Média | ⏳ Pendente |

---

### � SPRINT 6: Metas & Limites
**Status:** ⏳ Pendente
**Objetivo:** Sistema de metas e alertas de limite

| # | Tarefa | Prioridade | Status |
|---|--------|------------|--------|
| 6.1 | Migration: goals | 🟡 Média | ⏳ Pendente |
| 6.2 | Migration: limits | 🟡 Média | ⏳ Pendente |
| 6.3 | Model: Goal, Limit | 🟡 Média | ⏳ Pendente |
| 6.4 | Goals CRUD | 🟡 Média | ⏳ Pendente |
| 6.5 | Barra de progresso | 🟡 Média | ⏳ Pendente |
| 6.6 | Limits por categoria | 🟡 Média | ⏳ Pendente |
| 6.7 | Alertas (80% limite) | 🟡 Média | ⏳ Pendente |

---

### � SPRINT 7: Relatórios & Insights
**Status:** ⏳ Pendente
**Objetivo:** Relatórios e insights inteligentes

| # | Tarefa | Prioridade | Status |
|---|--------|------------|--------|
| 7.1 | Relatório por categoria | 🟡 Média | ⏳ Pendente |
| 7.2 | Relatório por período | 🟡 Média | ⏳ Pendente |
| 7.3 | Relatório por cartão | 🟡 Média | ⏳ Pendente |
| 7.4 | Relatório por conta | 🟡 Média | ⏳ Pendente |
| 7.5 | Gráficos (Chart.js/Recharts) | 🟡 Média | ⏳ Pendente |
| 7.6 | Insights inteligente | 🟢 Baixa | ⏳ Pendente |
| 7.7 | Export JSON/CSV | 🟢 Baixa | ⏳ Pendente |

---

### � SPRINT 8: Investimentos & Empréstimos
**Status:** ⏳ Pendente

| # | Tarefa | Prioridade | Status |
|---|--------|------------|--------|
| 8.1 | Migration: investments | 🟢 Baixa | ⏳ Pendente |
| 8.2 | Migration: loans | 🟢 Baixa | ⏳ Pendente |
| 8.3 | Model: Investment, Loan | 🟢 Baixa | ⏳ Pendente |
| 8.4 | CRUD Investments | 🟢 Baixa | ⏳ Pendente |
| 8.5 | CRUD Loans | 🟢 Baixa | ⏳ Pendente |

---

### � SPRINT 9: Perfil & Configurações
**Status:** ⏳ Pendente

| # | Tarefa | Prioridade | Status |
|---|--------|------------|--------|
| 9.1 | Dados do usuário (Avatar, Badge) | 🟡 Média | ⏳ Pendente |
| 9.2 | Configurações de notificações | 🟢 Baixa | ⏳ Pendente |
| 9.3 | Gerenciamento de categorias (UI) | 🟡 Média | ⏳ Pendente |
| 9.4 | Feedback e problemas | 🟢 Baixa | ⏳ Pendente |
| 9.5 | Export/Import dados | 🟢 Baixa | ⏳ Pendente |
| 9.6 | UI Premium: Obsidian Glass Adaptation | 🔴 CRÍTICA | ✅ Concluído |

---

---

### 🛠️ FEATURE: Adequação e Saneamento de Rotas
**Origem:** Varredura diagnóstica realizada em 2026-02-27
**Status:** ⏳ Pendente
**Objetivo:** Corrigir rotas quebradas, eliminar rotas desnecessárias e aplicar isolamento por usuário nos controllers

#### Contexto

Varredura completa identificou **68 rotas registradas**, sendo:
- 49 funcionais
- 10 que causam erro 500
- 3 alertas de segurança (queries sem filtro por usuário)

---

#### Tarefas

| # | Tarefa | Prioridade | Status |
|---|--------|------------|--------|
| R.1 | Remover rotas `*/edit` de todos os resources (não usadas no Livewire) | 🔴 CRÍTICA | ⏳ Pendente |
| R.2 | Adicionar método `edit()` ou excluir rota em `AccountController` | 🔴 CRÍTICA | ⏳ Pendente |
| R.3 | Adicionar métodos `create()` e `edit()` ou excluir rotas em `CardController` | 🔴 CRÍTICA | ⏳ Pendente |
| R.4 | Adicionar método `edit()` ou excluir rota em `TransactionController` | 🔴 CRÍTICA | ⏳ Pendente |
| R.5 | Criar views `categories.create`, `categories.show`, `categories.edit` ou excluir rotas | 🔴 CRÍTICA | ⏳ Pendente |
| R.6 | Criar views de subcategorias ou excluir rotas GET de subcategory | 🟡 Média | ⏳ Pendente |
| R.7 | Corrigir `AccountController::index` — filtrar por usuário autenticado (sem `Account::all()`) | 🔴 CRÍTICA | ⏳ Pendente |
| R.8 | Corrigir `CardController::index` — filtrar por usuário autenticado | 🔴 CRÍTICA | ⏳ Pendente |
| R.9 | Auditar todos os controllers: garantir isolamento por `profile_id` do usuário autenticado | 🔴 CRÍTICA | ⏳ Pendente |
| R.10 | Adicionar Policy ou middleware de autorização por recurso (account, card, transaction) | 🟡 Média | ⏳ Pendente |
| R.11 | Definir estratégia: rotas são REST-only (JSON) ou híbridas (HTML + Livewire)? | 🔴 CRÍTICA | ⏳ Pendente |
| R.12 | Adicionar testes de integração para as rotas críticas (auth, accounts, transactions) | 🟡 Média | ⏳ Pendente |

---

#### Plano de Adequação

**Decisão arquitetural a tomar (R.11):**

> O projeto usa Livewire para o frontend. Isso significa que a maioria das rotas `GET */create` e `GET */edit` não são necessárias como rotas standalone — elas serão componentes Livewire. A recomendação é:

```php
// Opção A — REST puro (recomendado para Livewire):
Route::resource('accounts', AccountController::class)
    ->except(['create', 'edit']);

// Opção B — Manter rotas HTML para fallback:
// manter como está, mas implementar as views e métodos faltantes
```

**Correção de segurança (R.7, R.8, R.9):**

```php
// ERRADO — expõe dados de todos os usuários:
$accounts = Account::all();

// CORRETO — isolado por profile do usuário autenticado:
$profile = auth()->user()->profiles()->first();
$accounts = Account::where('profile_id', $profile->id)->get();
```

**Isolamento por recurso (R.10):**
- Criar `AccountPolicy`, `CardPolicy`, `TransactionPolicy`
- Registrar em `AuthServiceProvider`
- Usar `$this->authorize('view', $account)` nos controllers

---

### 🚀 FEATURE: Análise Profunda de Frontend com Agente Especialista
**Origem:** Solicitação do usuário em 2026-02-27
**Status:** ⏳ Pendente
**Objetivo:** Contratar agente especialista em frontend para análise aprofundada do layout, otimização UX/UI e implementação de melhores práticas

#### Contexto

O sistema `personal_fin` precisa de uma análise detalhada de frontend para:
- Melhorar a experiência do usuário (UX)
- Otimizar o design visual (UI)
- Implementar as melhores práticas de layout
- Utilizar ferramentas como Context7 e Laravel Boost para acelerar o desenvolvimento

#### Justificativa

O frontend atual precisa de uma revisão profissional para:
1. **Posicionamento estratégico dos elementos** - Organizar componentes de forma mais intuitiva
2. **Consistência visual** - Garantir padrões visuais em todas as telas
3. **Performance** - Otimizar carregamento e renderização
4. **Acessibilidade** - Garantir que o sistema seja acessível
5. **Responsividade** - Melhorar experiência em diferentes dispositivos

#### Ferramentas Recomendadas

- **Context7** - Context-aware AI para análise de código
- **Laravel Boost** - Kit de componentes Laravel para produtividade

#### Tarefas

| # | Tarefa | Prioridade | Status |
|---|--------|------------|--------|
| F.1 | Contratar/acionar agente especialista em frontend | 🔴 CRÍTICA | ⏳ Pendente |
| F.2 | Análise completa do layout atual | 🔴 CRÍTICA | ⏳ Pendente |
| F.3 | Levantamento de pontos de melhoria | 🔴 CRÍTICA | ⏳ Pendente |
| F.4 | Implementação de melhorias no design system | 🟡 Média | ⏳ Pendente |
| F.5 | Aplicação de Laravel Boost para componentes | 🟡 Média | ⏳ Pendente |
| F.6 | Testes de UX e ajustes finais | 🟡 Média | ⏳ Pendente |

#### Recursos de参考

- Documentação Context7: https://context7.com
- Laravel Boost: https://laravel.com/docs/12.x
- Design System atual: Glassmorphism + Dark Mode

---

### 🚀 FEATURE: Botões de Ação Rápida do Dashboard
**Origem:** Solicitação do usuário em 2026-02-27
**Status:** ⏳ Pendente
**Objetivo:** Implementar botões "+ Nova Receita" e "- Nova Despesa" funcionais

#### Tarefas

| # | Tarefa | Prioridade | Status |
|---|--------|------------|--------|
| B.1 | Criar modal de Quick Add para transações | 🔴 CRÍTICA | ⏳ Pendente |
| B.2 | Integrar botão "+ Nova Receita" com modal de receita | 🔴 CRÍTICA | ⏳ Pendente |
| B.3 | Integrar botão "- Nova Despesa" com modal de despesa | 🔴 CRÍTICA | ⏳ Pendente |
| B.4 | Ao salvar, atualizar dados do dashboard em tempo real | 🟡 Média | ⏳ Pendente |

---

### 🚀 FEATURE: Card Limite Mensal Clicável
**Origem:** Solicitação do usuário em 2026-02-27
**Status:** ⏳ Pendente
**Objetivo:** Card clicável que abre gerenciador de limites por tipo

#### Tarefas

| # | Tarefa | Prioridade | Status |
|---|--------|------------|--------|
| L.1 | Tornar card "Limite Mensal" clicável | 🔴 CRÍTICA | ⏳ Pendente |
| L.2 | Criar página de gerenciador de limites | 🔴 CRÍTICA | ⏳ Pendente |
| L.3 | Listar cada tipo de limite por linha no card | 🟡 Média | ⏳ Pendente |
| L.4 | CRUD para configurar limites por categoria/tipo | 🟡 Média | ⏳ Pendente |
| L.5 | Exibir percentual utilizado em cada linha do card | 🟡 Média | ⏳ Pendente |

---

### 🚀 FEATURE: Card Metas de Reserva Clicável
**Origem:** Solicitação do usuário em 2026-02-27
**Status:** ⏳ Pendente
**Objetivo:** Card clicável para gerenciamento de metas de reserva

#### Tarefas

| # | Tarefa | Prioridade | Status |
|---|--------|------------|--------|
| M.1 | Tornar card "Metas de Reserva" clicável | 🔴 CRÍTICA | ⏳ Pendente |
| M.2 | Criar página de gerenciamento de metas | 🔴 CRÍTICA | ⏳ Pendente |
| M.3 | Exibir percentual de cada meta por linha no card | 🟡 Média | ⏳ Pendente |
| M.4 | CRUD de metas de reserva (nome, valor alvo, prazo) | 🟡 Média | ⏳ Pendente |
| M.5 | Barra de progresso para cada meta | 🟡 Média | ⏳ Pendente |

---

### 🚀 FEATURE: Cards de Receitas/Despesas Clicáveis
**Origem:** Solicitação do usuário em 2026-02-27
**Status:** ⏳ Pendente
**Objetivo:** Cards clicáveis abrem listagem de transações com filtro

#### Tarefas

| # | Tarefa | Prioridade | Status |
|---|--------|------------|--------|
| R.1 | Tornar card "Receitas (Mês)" clicável | 🔴 CRÍTICA | ⏳ Pendente |
| R.2 | Tornar card "Despesas (Mês)" clicável | 🔴 CRÍTICA | ⏳ Pendente |
| R.3 | Ao clicar, abrir página de transações com filtro específico | 🔴 CRÍTICA | ⏳ Pendente |
| R.4 | Implementar filtros na página de transações (type=income/expense) | 🟡 Média | ⏳ Pendente |

---

### 🚀 FEATURE: Gerenciador de Conta Específico
**Origem:** Solicitação do usuário em 2026-02-27
**Status:** ⏳ Pendente
**Objetivo:** Ao clicar no card da conta, abrir extrato de movimentos

#### Tarefas

| # | Tarefa | Prioridade | Status |
|---|--------|------------|--------|
| GC.1 | Tornar card de conta clicável | 🔴 CRÍTICA | ⏳ Pendente |
| GC.2 | Criar página de extrato da conta | 🔴 CRÍTICA | ⏳ Pendente |
| GC.3 | Listar transações relacionadas à conta | 🔴 CRÍTICA | ⏳ Pendente |
| GC.4 | Exibir saldo inicial, movimentações e saldo final | 🟡 Média | ⏳ Pendente |
| GC.5 | Filtros por período no extrato | 🟡 Média | ⏳ Pendente |

---

### 🚀 FEATURE: Gerenciador de Cartão com Faturas Futuras
**Origem:** Solicitação do usuário em 2026-02-27
**Status:** ⏳ Pendente
**Objetivo:** Extrato por cartão + visualização estilo Nubank de faturas futuras

#### Tarefas

| # | Tarefa | Prioridade | Status |
|---|--------|------------|--------|
| CC.1 | Tornar card de cartão clicável | 🔴 CRÍTICA | ⏳ Pendente |
| CC.2 | Criar página de extrato do cartão | 🔴 CRÍTICA | ⏳ Pendente |
| CC.3 | Criar módulo de faturas futuras (style Nubank) | 🔴 CRÍTICA | ⏳ Pendente |
| CC.4 | Exibir预测 de fatura por mês futuro | 🟡 Média | ⏳ Pendente |
| CC.5 | Permitir personalizar cor do cartão (Glassmorphism) | 🟡 Média | ⏳ Pendente |
| CC.6 | Exibir limite disponível e utilizado | 🟡 Média | ⏳ Pendente |

---

### 🚀 FEATURE: Menu Gastos com Carrossel e Filtros
**Origem:** Solicitação do usuário em 2026-02-27
**Status:** ⏳ Pendente
**Objetivo:** Interface melhorada para página de transações

#### Tarefas

| # | Tarefa | Prioridade | Status |
|---|--------|------------|--------|
| G.1 | Implementar carrossel de seleção de Mês | 🔴 CRÍTICA | ⏳ Pendente |
| G.2 | Implementar carrossel de seleção de Ano | 🔴 CRÍTICA | ⏳ Pendente |
| G.3 | Adicionar badges de filtro: "Geral", "Receitas", "Despesas" | 🔴 CRÍTICA | ⏳ Pendente |
| G.4 | Criar card com gráfico de barras laterais por categoria | 🟡 Média | ⏳ Pendente |
| G.5 | Integrar filtros com listagem de transações | 🟡 Média | ⏳ Pendente |

---

### 🚀 FEATURE: CRUD Completo de Categorias
**Origem:** Solicitação do usuário em 2026-02-27
**Status:** ⏳ Pendente
**Objetivo:** Funcionalidades completas de CRUD para categorias e subcategorias

#### Tarefas

| # | Tarefa | Prioridade | Status |
|---|--------|------------|--------|
| C.1 | Criar nova categoria (botão funcional) | 🔴 CRÍTICA | ⏳ Pendente |
| C.2 | Criar nova subcategoria | 🔴 CRÍTICA | ⏳ Pendente |
| C.3 | Editar categoria | 🔴 CRÍTICA | ⏳ Pendente |
| C.4 | Editar subcategoria | 🔴 CRÍTICA | ⏳ Pendente |
| C.5 | Deletar categoria com aviso de desassociação | 🔴 CRÍTICA | ⏳ Pendente |
| C.6 | Deletar subcategoria | 🔴 CRÍTICA | ⏳ Pendente |
| C.7 | Ao deletar categoria com movimentos, associar a "Sem Categoria" | 🔴 CRÍTICA | ⏳ Pendente |

---

### 🚀 FEATURE: Abas Funcionais na Página de Categorias
**Origem:** Solicitação do usuário em 2026-02-27
**Status:** ⏳ Pendente
**Objetivo:** Corrigir e implementar abas de Despesas/Receitas

#### Tarefas

| # | Tarefa | Prioridade | Status |
|---|--------|------------|--------|
| A.1 | Corrigir funcionamento da aba "Despesas" | 🔴 CRÍTICA | ⏳ Pendente |
| A.2 | Corrigir funcionamento da aba "Receitas" | 🔴 CRÍTICA | ⏳ Pendente |
| A.3 | Testar alternância entre abas | 🟡 Média | ⏳ Pendente |
| A.4 | Persistir estado da aba selecionada | 🟢 Baixa | ⏳ Pendente |

---

### 🚀 FEATURE: Relatórios para Gestão de Finanças Pessoais
**Origem:** Solicitação do usuário em 2026-02-27
**Status:** ⏳ Pendente
**Objetivo:** Implementar relatórios úteis para finanças pessoais

#### Relatórios Sugeridos

| # | Relatório | Descrição | Prioridade |
|---|-----------|-----------|------------|
| REL.1 | **Evolução Patrimonial** | Evolução do patrimônio ao longo do tempo | 🟡 Média |
| REL.2 | **Fluxo de Caixa** | Entradas vs saídas por período | 🔴 CRÍTICA |
| REL.3 | **Gastos por Categoria** | Pizza/barra de despesas por categoria | 🔴 CRÍTICA |
| REL.4 | **Comparativo Mensal** | Comparar meses anteriores | 🟡 Média |
| REL.5 | **Gastos por Cartão** | breakdown de gastos por cartão | 🟡 Média |
| REL.6 | **Gastos por Conta** | breakdown de gastos por conta | 🟡 Média |
| REL.7 | **Top Gastos** | Maiores despesas do período | 🟡 Média |
| REL.8 | **Receitas vs Despesas** | Gráfico comparativo | 🔴 CRÍTICA |
| REL.9 | **Projeção de Gastos** | Estimar gastos no final do mês | 🟢 Baixa |
| REL.10 | **Análise de Metas** | Progresso das metas de reserva | 🟡 Média |

#### Tarefas

| # | Tarefa | Prioridade | Status |
|---|--------|------------|--------|
| REL.1 | Implementar endpoint de cada relatório | 🟡 Média | ⏳ Pendente |
| REL.2 | Criar UI para visualização de relatórios | 🟡 Média | ⏳ Pendente |
| REL.3 | Adicionar gráficos (Chart.js ou similar) | 🟡 Média | ⏳ Pendente |
| REL.4 | Exportar relatório (PDF/Excel) | 🟢 Baixa | ⏳ Pendente |

---

## 📊 RESUMO DE PRIORIDADES

| Sprint | Escopo | Tarefas | Status |
|--------|--------|---------|--------|
| 1 | Fundamentos & Auth | 10 | 🔴 Em andamento |
| 2 | Dashboard MVP | 6 | ⏳ Pendente |
| 3 | Contas & Cartões | 7 | ⏳ Pendente |
| 4 | Transações Core | 7 | ⏳ Pendente |
| 5 | Transações Avançadas | 6 | ⏳ Pendente |
| 6 | Metas & Limites | 7 | ⏳ Pendente |
| 7 | Relatórios | 7 | ⏳ Pendente |
| 8 | Investimentos | 5 | ⏳ Pendente |
| 9 | Perfil & Config | 5 | ⏳ Pendente |
| **R** | **Adequação de Rotas** | **12** | **⏳ Pendente** |

---

## 🏷️ LEGENDA

| Símbolo | Significado |
|---------|-------------|
| 🔴 CRÍTICA | Essential para MVP |
| 🟡 Média | Importante |
| 🟢 Baixa | Fase futura |
| ✅ Concluído | Pronto |
| ⏳ Pendente | A fazer |
| 🚧 Em andamento | Em progresso |

---

## 🔄 FLUXO DE TRABALHO

1. **Selecionar Sprint**: Escolher sprint do backlog
2. **Skill TDD**: Usar `aidev` com skill TDD para implementar
3. **Código**: Escrever teste → código → refatorar
4. **Revisão**: Code review antes de marcar concluído
5. **Próximo**: Avançar para próxima tarefa

---

**Versão:** 1.1
**Última atualização:** 2026-02-27
**Responsável:** AI Dev Agent
