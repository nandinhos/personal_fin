# Project Handbook — personal_fin

> Documento mestre de governança e referência técnica do projeto.
> **Fonte única de verdade** para decisões arquiteturais e padrões.

**Gerado em:** 2026-02-26 | **Versão:** 1.1 (Robust Mode) | **Maturidade:** Greenfield

---

## 🎯 Objetivo do Produto

Sistema de **Gerenciamento de Finanças Pessoais** focado em:
- **Mobile-First**: Experiência premium em dispositivos móveis.
- **Multi-Perfil**: Isolamento total de dados por perfil financeiro (`profile_id`).
- **Design Moderno**: Estética minimalista e profissional.
- **API First**: Endpoints preparados para integração e migração futura.

---

## 🛠️ Stack Técnica (TALL Stack)

| Camada | Tecnologia | Versão |
|--------|------------|--------|
| **Backend** | Laravel | 12.x (MVC + Services + Actions) |
| **Frontend** | Livewire | 4.x |
| **Estilização** | Tailwind CSS | JIT Enabled |
| **Interatividade** | Alpine.js | Core integration |
| **Banco de Dados** | PostgreSQL | 16+ (UUIDs mandatórios) |
| **Infraestrutura** | Docker | Laravel Sail |

---

## 🎨 Design & UI Blueprint

O layout do projeto é baseado no blueprint do **MCP Stitch**:
- **Project ID:** `7807222790950721645`
- **Diretriz:** Adaptar a estética premium deste projeto à realidade das finanças pessoais, mantendo a consistência visual.

---

## 🦾 Governança e Fluxo (AIDEV Superpowers)

### 1. Orquestração e Respeito aos Agentes
- O **Orquestrador** (`.aidev/agents/orchestrator.md`) é a autoridade máxima.
- Respeite o fluxo de intents e skills definidas em `.aidev/QUICKSTART.md`.
- Em caso de ambiguidade: **Pare e questione o usuário.**

### 2. TDD Mandatório (RED -> GREEN -> REFACTOR)
- **Zero código sem teste**: Toda feature deve começar por um teste de funcionalidade.
- Exceções devem ser aprovadas pelo usuário.

### 3. Commits e Idioma
- **Idioma**: Português (Brasil) para código e documentação.
- **Formato**: `tipo(escopo): descrição` (Sem emojis).

---

## 🏗️ Padrões de Código

- **Identificadores**: Usar UUID v4 para todas as chaves primárias.
- **Segurança**: Integração de login somente pós-validação de funcionalidade do MVP.
- **Multi-tenancy**: Filtro global de `profile_id` em quase todas as queries.
- **Consultas**: Documentação via MCP Context7; Refinamento via MCP Laravel Boost; Navegação via MCP Serena.

---

## 📉 Decisões Arquiteturais

| Data | Decisão | Rationale |
|------|---------|-----------|
| 2026-02-26 | Laravel Sail | Padronização de ambiente local e portas altas (10000+). |
| 2026-02-26 | TALL Stack | Foco em produtividade Laravel 12 e reatividade com Livewire 4. |

---

## 🚨 Armadilhas Conhecidas

- **MCP Docker**: Executar o MCP Laravel Boost **dentro do container** (`docker compose exec`) para evitar erros de conexão com o DB.
- **Permissões**: Alinhamento de `WWWUSER/WWWGROUP` para evitar bugs de escrita local vs docker.

---

*Última atualização: 2026-02-26 — AI Dev Superpowers v4.7.1*
