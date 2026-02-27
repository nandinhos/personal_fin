# Feature: Card Metas de Reserva Clicável

**Status:** ✅ Implementado
**Data:** 2026-02-27
**Prioridade:** 🟡 Média

---

## Objetivo

Card clicável para gerenciamento de metas de reserva financeira.

---

## Tarefas Concluídas

| # | Tarefa | Status |
|---|--------|--------|
| M.1 | Tornar card "Metas de Reserva" clicável | ✅ |
| M.2 | Criar página de gerenciamento de metas | ✅ |
| M.3 | Exibir percentual de cada meta por linha no card | ✅ |
| M.4 | CRUD de metas de reserva (nome, valor alvo, prazo) | ✅ |
| M.5 | Barra de progresso para cada meta | ✅ |

---

## Implementação

**Arquivos:**
- `app/Http/Controllers/GoalController.php` - CRUD de metas
- `resources/views/goals/index.blade.php` - UI do gerenciador
- `resources/views/livewire/dashboard.blade.php` - Card clicável
- `routes/web.php` - Rotas `/goals`

**Funcionalidades:**
- Card do dashboard leva para página de metas
- CRUD de metas com nome, valor alvo, prazo
- Barra de progresso visual
- Atualização de progresso inline
