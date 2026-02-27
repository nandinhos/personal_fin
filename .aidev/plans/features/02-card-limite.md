# Feature: Card Limite Mensal Clicável

**Status:** ✅ Implementado
**Data:** 2026-02-27
**Prioridade:** 🟡 Média

---

## Objetivo

Card clicável que abre gerenciador de limites por tipo de despesa.

---

## Tarefas Concluídas

| # | Tarefa | Status |
|---|--------|--------|
| L.1 | Tornar card "Limite Mensal" clicável | ✅ |
| L.2 | Criar página de gerenciador de limites | ✅ |
| L.3 | Listar cada tipo de limite por linha no card | ✅ |
| L.4 | CRUD para configurar limites por categoria/tipo | ✅ |
| L.5 | Exibir percentual utilizado em cada linha do card | ✅ |

---

## Implementação

**Arquivos:**
- `app/Http/Controllers/LimitController.php` - CRUD de limites
- `resources/views/limits/index.blade.php` - UI do gerenciador
- `resources/views/livewire/dashboard.blade.php` - Card clicável
- `routes/web.php` - Rotas `/limits`

**Funcionalidades:**
- Card do dashboard leva para página de limites
- CRUD de limites por categoria
- Visualização de limites configurados
