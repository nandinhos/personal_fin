# Feature: Abas Funcionais na Página de Categorias

**Status:** ✅ Implementado
**Data:** 2026-02-27

---

## Descrição

Correção e implementação de abas funcionais para alternar entre categorias de Despesas e Receitas na página de gerenciamento de categorias.

---

## Tarefas Concluídas

| # | Tarefa | Status |
|---|--------|--------|
| A.1 | Corrigir funcionamento da aba "Despesas" | ✅ |
| A.2 | Corrigir funcionamento da aba "Receitas" | ✅ |
| A.3 | Testar alternância entre abas | ✅ |
| A.4 | Persistir estado da aba selecionada | ✅ |

---

## Implementação

**Arquivos:**
- `app/Livewire/CategoryManager.php` - Métodos `switchTab()` e propriedade `$activeTab`
- `resources/views/livewire/category-manager.blade.php` - UI das abas com botões toggle

**Funcionalidades:**
- Botões de alternância entre "Despesas" e "Receitas"
- Filtragem de categorias por tipo
- Estilo visual ativo para aba selecionada
