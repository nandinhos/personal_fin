# 📌 PRD — Sistema de Gerenciamento de Finanças Pessoais

## 1. Visão Geral do Produto

### 1.1 Nome Provisório

**Personal Finance Manager (PFM)**

### 1.2 Objetivo

Desenvolver um sistema de gerenciamento de finanças pessoais **mobile-first**, com suporte completo para:

* 📱 Mobile
* 📲 Tablet
* 💻 Web

Permitir controle de:

* Receitas
* Despesas
* Transferências
* Cartões
* Contas
* Investimentos
* Empréstimos
* Metas
* Limites por categoria
* Relatórios inteligentes com insights

---

## 2. Stack Técnica

### 2.1 Backend

* **Framework:** Laravel 12
* Arquitetura: MVC + Services + Actions
* Autenticação: Laravel Breeze / Jetstream customizado
* Multi-tenant por usuário (isolamento por user_id)

### 2.2 Frontend

* Tailwind CSS
* Livewire 4
* Alpine.js
* UI Component-driven
* Responsividade mobile-first

### 2.3 Banco de Dados

* PostgreSQL
* UUIDs como PK
* Soft deletes
* Índices estratégicos para consultas por período

### 2.4 Infraestrutura

* Docker
* Docker Compose
* Ambiente local padronizado

---

# 3. Arquitetura de Informação

## 3.1 Dashboard Principal

### Exibição padrão:

* Mês vigente (current month)
* Saldo atual
* Receitas totais
* Despesas totais
* Valores recebidos
* Valores pagos

### Cards Expansíveis:

* Recebimentos futuros
* Pagamentos futuros
* Saldo projetado
* Balanço

✔ Cards ocultáveis
✔ Personalização de visibilidade

---

## 4. Módulos Funcionais

---

# 4.1 Contas

### Funcionalidades:

* CRUD de contas
* Ícone customizável
* Nome do banco
* Saldo atual

### Exibição:

Card com:

* Ícone
* Nome
* Saldo

---

# 4.2 Cartões

### Dashboard:

Card estilo cartão físico contendo:

* Ícone do banco
* Nome
* Limite disponível
* Data de fechamento
* Status (aberto/fechado)
* Valor da fatura atual

### Tela Interna do Cartão:

1. Card superior:

   * Fatura
   * Total de gastos
   * Status de pagamento
2. Carrossel de mês/ano
3. Listagem filtrada por período

---

# 4.3 Transações

## Tipos:

* Receita
* Despesa
* Transferência

### Campos comuns:

* Título
* Descrição
* Data
* Categoria
* Conta ou Cartão (obrigatório)
* Tipo de lançamento:

  * Único
  * Recorrente
  * Parcelado

### Regras:

* Toda movimentação deve estar vinculada a conta ou cartão
* Parcelamento gera múltiplos registros vinculados
* Recorrência gera agendamento automático

---

# 4.4 Metas

Campos:

* Imagem
* Título
* Valor alvo
* Categoria
* Data opcional

Visual:

* Barra de progresso
* Percentual atingido

---

# 4.5 Limites por Categoria

Campos:

* Categoria
* Valor limite
* Recorrência (mensal, anual, custom)
* Data de início:

  * Hoje
  * Primeiro dia do mês
  * Último dia do mês

Sistema deve:

* Alertar quando atingir percentual crítico (ex: 80%)
* Bloquear ou apenas notificar (configurável)

---

# 4.6 Investimentos

MVP:

* Tipo
* Valor investido
* Rentabilidade estimada
* Data
* Conta vinculada

Fase futura:

* Cálculo automático de rendimento

---

# 4.7 Empréstimos

Campos:

* Valor total
* Taxa
* Parcelas
* Valor da parcela
* Status
* Vinculação com conta

---

# 5. Navegação Mobile

## Bottom Navigation Fixa

1. Dashboard
2. Transações
3. Botão central "+"
4. Relatórios
5. Perfil

---

## 5.1 Tela Global de Transações

Filtros:

* Carrossel Ano/Mês
* Subfiltro:

  * Geral
  * Cartões
  * Contas
  * Investimentos
  * Empréstimos

---

# 6. Relatórios

## 6.1 Relatório Detalhado

Por:

* Categoria
* Cartão
* Conta
* Período

## 6.2 Insights Inteligentes

Exemplos:

* Categoria que mais cresceu
* Gastos acima da média
* Alerta de limite
* Previsão de saldo negativo

---

# 7. Perfil & Configurações

## 7.1 Dados do Usuário

* Avatar
* Nome
* Badge:

  * Free
  * Premium

## 7.2 Plano

Possibilidade:

* Assinatura mensal
* Chave API personalizada
* Plano comercial futuro

---

## 7.3 Multiusuário

* Um usuário pode possuir múltiplos perfis financeiros
* Seleção de perfil no login
* Isolamento total por profile_id

---

# 8. Configurações Avançadas

Gerenciamento de:

* Cartões
* Contas
* Categorias
* Subcategorias
* Metas
* Limites
* Investimentos
* Empréstimos

---

# 9. Feedback e Problemas

Categoria de feedback:

* Sugestões
* Problemas técnicos
* Falta de acessibilidade
* Bugs
* Sincronização
* Perda de dados
* Outros

Funções:

* Exportar dados
* Termos de uso
* Logout

---

# 10. Notificações

* Alertas de limite
* Fatura próxima do vencimento
* Meta próxima de conclusão
* Saldo projetado negativo

Configuração customizável por usuário.

---

# 11. Menu Rápido (Quick Menu)

Botão flutuante:

* Contas
* Cartões
* Categorias
* Subcategorias
* Metas
* Limites
* Investimentos
* Empréstimos

---

# 12. Requisitos Não Funcionais

### Performance

* Dashboard < 200ms
* Queries indexadas por:

  * user_id
  * profile_id
  * date

### Segurança

* Autenticação JWT / Session segura
* CSRF protection
* Hash bcrypt/argon2
* Isolamento multiusuário

### Escalabilidade

* Estrutura preparada para:

  * Open Banking
  * Integração com APIs externas

### Backup

* Exportação JSON/CSV
* Restore manual

---

# 13. Modelo Inicial de Banco (Macro Estrutura)

Principais tabelas:

* users
* profiles
* accounts
* cards
* transactions
* installments
* categories
* subcategories
* goals
* limits
* investments
* loans
* notifications
* feedbacks

Relacionamentos base:

```
users 1:N profiles
profiles 1:N accounts
profiles 1:N cards
profiles 1:N transactions
transactions N:1 categories
```

---

# 14. Roadmap de Fases

## Fase 1 – MVP

* Auth
* Dashboard
* Contas
* Cartões
* Transações
* Metas
* Limites

## Fase 2

* Investimentos
* Empréstimos
* Relatórios avançados

## Fase 3

* Insights inteligentes
* Assinatura
* API externa
* Open Finance

---

# 15. Diferenciais Estratégicos

* UX altamente visual
* Mobile-first real
* Multi-perfil financeiro
* Personalização total de dashboard
* Sistema preparado para monetização

---

Se quiser, posso agora:

1. Gerar o **diagrama ER completo**
2. Criar o **schema SQL otimizado para PostgreSQL**
3. Montar a **estrutura de pastas Laravel 12 profissional**
4. Criar o **backlog técnico já dividido em épicos e histórias**
5. Criar o **Dockerfile + docker-compose.yml padrão produção**
