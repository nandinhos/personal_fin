<h1 align="center">
  💰 Personal Finance Manager
</h1>

<p align="center">
  Sistema de gerenciamento de finanças pessoais — mobile-first, multi-perfil e preparado para escala.
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 12">
  <img src="https://img.shields.io/badge/Livewire-3-FB70A9?style=for-the-badge&logo=livewire&logoColor=white" alt="Livewire 3">
  <img src="https://img.shields.io/badge/Tailwind_CSS-3-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white" alt="Tailwind CSS">
  <img src="https://img.shields.io/badge/PostgreSQL-16-4169E1?style=for-the-badge&logo=postgresql&logoColor=white" alt="PostgreSQL">
  <img src="https://img.shields.io/badge/Docker-Compose-2496ED?style=for-the-badge&logo=docker&logoColor=white" alt="Docker">
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.2+">
</p>

<p align="center">
  <img src="https://img.shields.io/badge/status-em_desenvolvimento-yellow?style=flat-square">
  <img src="https://img.shields.io/badge/sprint-01_%2F_09-blue?style=flat-square">
  <img src="https://img.shields.io/badge/design-glassmorphism_%2B_dark_mode-purple?style=flat-square">
  <img src="https://img.shields.io/badge/licença-MIT-green?style=flat-square">
</p>

---

## 📋 Sobre o Projeto

O **Personal Finance Manager (PFM)** é uma aplicação web focada em controle financeiro pessoal, construída com foco em usabilidade mobile-first e experiência visual moderna (Glassmorphism + Dark Mode).

O sistema permite gerenciar receitas, despesas, cartões, contas, metas, limites de gastos, investimentos e empréstimos — tudo com suporte a múltiplos perfis financeiros por usuário.

---

## ✨ Funcionalidades

| Módulo | Descrição | Status |
|--------|-----------|--------|
| 🔐 **Autenticação** | Registro, login, recuperação de senha (Breeze) | ✅ Concluído |
| 📊 **Dashboard** | Saldo, receitas, despesas, projeções do mês | 🔄 Em andamento |
| 🏦 **Contas** | CRUD de contas bancárias com saldo em tempo real | 📋 Planejado |
| 💳 **Cartões** | Gestão de cartões, faturas, limites e vencimentos | 📋 Planejado |
| 💸 **Transações** | Receitas, despesas e transferências (único, recorrente, parcelado) | 📋 Planejado |
| 🎯 **Metas** | Definição de objetivos com barra de progresso | 📋 Planejado |
| 🚦 **Limites** | Alertas e bloqueios por categoria de gasto | 📋 Planejado |
| 📈 **Investimentos** | Registro e acompanhamento de rentabilidade | 📋 Planejado |
| 🤝 **Empréstimos** | Controle de parcelas e taxas | 📋 Planejado |
| 📉 **Relatórios** | Análises por categoria, período, conta e cartão | 📋 Planejado |
| 💡 **Insights** | Alertas inteligentes e previsões financeiras | 📋 Planejado |

---

## 🧱 Stack Técnica

### Backend
- **[Laravel 12](https://laravel.com)** — Framework PHP com arquitetura MVC + Services + Actions
- **[Laravel Breeze](https://github.com/laravel/breeze)** — Autenticação leve e customizável
- **[Livewire 3](https://livewire.laravel.com)** — Componentes reativos full-stack sem JavaScript
- **PostgreSQL** — Banco relacional com UUIDs, soft deletes e índices otimizados

### Frontend
- **[Tailwind CSS](https://tailwindcss.com)** — Utility-first CSS framework
- **[Alpine.js](https://alpinejs.dev)** — Reatividade leve no browser
- **Design System** — Glassmorphism + Dark Mode, responsivo mobile-first

### Infra
- **Docker + Docker Compose** — Ambiente local padronizado e reproduzível

---

## 🗂️ Estrutura do Projeto

```
personal_fin/
├── app/
│   ├── Http/Controllers/     # Controllers REST
│   ├── Livewire/             # Componentes Livewire
│   ├── Models/               # Eloquent Models
│   └── Providers/
├── database/
│   ├── migrations/           # Estrutura do banco
│   ├── factories/
│   └── seeders/
├── resources/
│   ├── views/                # Blade templates
│   └── css/ js/
├── routes/
│   ├── web.php
│   └── auth.php
├── docs/
│   ├── PRD.md                # Product Requirements Document
│   └── schema.md             # Modelagem do banco
└── .aidev/                   # Configuração de agentes AI Dev
```

---

## 🚀 Instalação e Execução

### Pré-requisitos

- Docker e Docker Compose instalados
- PHP 8.2+ (para execução sem Docker)
- Composer

### Com Docker

```bash
# Clone o repositório
git clone https://github.com/nandinhos/personal_fin.git
cd personal_fin

# Copie o arquivo de ambiente
cp .env.example .env

# Suba os containers
docker compose up -d

# Instale as dependências
docker compose exec app composer install
docker compose exec app npm install

# Gere a chave da aplicação
docker compose exec app php artisan key:generate

# Execute as migrations
docker compose exec app php artisan migrate --seed
```

### Sem Docker

```bash
git clone https://github.com/nandinhos/personal_fin.git
cd personal_fin

cp .env.example .env

composer install
npm install

php artisan key:generate
php artisan migrate --seed

php artisan serve
npm run dev
```

A aplicação estará disponível em `http://localhost:8000`.

---

## 🗺️ Roadmap

```
Sprint 01  ████████░░  Fundamentos & Autenticação        🔄 Em andamento
Sprint 02  ░░░░░░░░░░  Dashboard MVP                     📋 Planejado
Sprint 03  ░░░░░░░░░░  Contas & Cartões                  📋 Planejado
Sprint 04  ░░░░░░░░░░  Transações Core                   📋 Planejado
Sprint 05  ░░░░░░░░░░  Transações Avançadas              📋 Planejado
Sprint 06  ░░░░░░░░░░  Metas & Limites                   📋 Planejado
Sprint 07  ░░░░░░░░░░  Relatórios & Insights             📋 Planejado
Sprint 08  ░░░░░░░░░░  Investimentos & Empréstimos       📋 Planejado
Sprint 09  ░░░░░░░░░░  Perfil & Configurações            📋 Planejado
```

---

## 🗄️ Modelo de Dados (Macro)

```
users
  └── profiles (1:N)
        ├── accounts (1:N)
        ├── cards (1:N)
        ├── transactions (1:N)
        │     └── categories / subcategories
        ├── goals (1:N)
        ├── limits (1:N)
        ├── investments (1:N)
        └── loans (1:N)
```

---

## 🤝 Contribuindo

Este projeto está em desenvolvimento ativo. Contribuições são bem-vindas.

```bash
# Crie uma branch para sua feature
git checkout -b feat/nome-da-feature

# Commit seguindo o padrão Conventional Commits
git commit -m "feat(modulo): descricao da mudanca"

# Abra um Pull Request
```

**Padrão de commits:**

| Tipo | Uso |
|------|-----|
| `feat` | Nova funcionalidade |
| `fix` | Correção de bug |
| `refactor` | Refatoração sem mudança de comportamento |
| `test` | Adição ou ajuste de testes |
| `docs` | Documentação |
| `chore` | Tarefas de manutenção |

---

## 📄 Licença

Distribuído sob a licença MIT. Veja [LICENSE](LICENSE) para mais informações.

---

<p align="center">
  Feito com ❤️ por <strong>Nando Dev</strong>
</p>
