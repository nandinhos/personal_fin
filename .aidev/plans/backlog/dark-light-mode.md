# 🌗 FEATURE: Modo Dark / Light

**Data:** 2026-02-27
**Status:** 💡 Backlog
**Origem:** Solicitação do usuário
**Prioridade:** 🟡 Média

---

## Objetivo

Implementar alternância entre modo escuro (Dark) e modo claro (Light) de forma persistente, respeitando a preferência do sistema operacional e seguindo as melhores práticas da stack: **Tailwind CSS + Alpine.js + Livewire 3 + Laravel 12**.

---

## Arquitetura da Solução

### Decisões técnicas

| Decisão | Escolha | Justificativa |
|---------|---------|---------------|
| Estratégia Tailwind | `darkMode: 'class'` | Controle programático via JS; mais flexível que `'media'` |
| Gerenciador de estado | Alpine.js `$store` | Já está na stack; reativo; sem dependência extra |
| Persistência | `localStorage` | Leve, client-side, sem round-trip ao servidor |
| Fallback inicial | `prefers-color-scheme` | Respeita preferência do SO na primeira visita |
| Anti-FOUC | Script inline no `<head>` | Aplica a classe `dark` antes do render para evitar flash |
| Transição | CSS `transition-colors duration-300` | Suavidade sem prejudicar performance |

### Por que Alpine.js `$store` e não Livewire?

O tema é um estado **puramente client-side** e não precisa ser persistido no servidor ou reativo com o backend. Usar Alpine.js `$store` é a abordagem correta e mais performática — Livewire seria overhead desnecessário aqui (viola YAGNI).

---

## Estrutura de Implementação

### 1. Tailwind Config

**Arquivo:** `tailwind.config.js`

```js
// Mudar de 'media' para 'class'
darkMode: 'class',
```

### 2. Script Anti-FOUC

**Arquivo:** `resources/views/layouts/app.blade.php` — inserir no `<head>` **antes** de qualquer CSS:

```html
<!-- Anti-FOUC: aplica tema antes do render -->
<script>
    (function() {
        const stored = localStorage.getItem('theme');
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        const theme = stored ?? (prefersDark ? 'dark' : 'light');
        if (theme === 'dark') document.documentElement.classList.add('dark');
    })();
</script>
```

### 3. Alpine.js Store

**Arquivo:** `resources/js/app.js`

```js
Alpine.store('theme', {
    current: localStorage.getItem('theme')
        ?? (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'),

    toggle() {
        this.current = this.current === 'dark' ? 'light' : 'dark';
        this.apply();
    },

    set(value) {
        this.current = value;
        this.apply();
    },

    apply() {
        document.documentElement.classList.toggle('dark', this.current === 'dark');
        localStorage.setItem('theme', this.current);
    },

    get isDark() {
        return this.current === 'dark';
    }
});
```

### 4. Botão de Toggle

**Arquivo:** `resources/views/layouts/navigation.blade.php` (navbar)

```html
<button
    x-data
    @click="$store.theme.toggle()"
    class="p-2 rounded-lg text-slate-400 hover:text-white hover:bg-slate-700/50 transition-colors"
    :aria-label="$store.theme.isDark ? 'Ativar modo claro' : 'Ativar modo escuro'"
    :title="$store.theme.isDark ? 'Modo Claro' : 'Modo Escuro'"
>
    <!-- Ícone Sol (Light) -->
    <svg x-show="$store.theme.isDark" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
    </svg>
    <!-- Ícone Lua (Dark) -->
    <svg x-show="!$store.theme.isDark" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
    </svg>
</button>
```

### 5. Paleta de Cores Light Mode

Todos os componentes usam classes Tailwind com prefixo `dark:`. O design atual é 100% dark (glassmorphism). O light mode precisa de tokens alternativos:

| Elemento | Dark (atual) | Light (novo) |
|----------|-------------|--------------|
| Background body | `bg-slate-900` | `bg-slate-50` |
| Cards | `bg-slate-800/50` | `bg-white/80` |
| Texto principal | `text-white` | `text-slate-900` |
| Texto secundário | `text-slate-400` | `text-slate-500` |
| Bordas | `border-slate-700/50` | `border-slate-200` |
| Navbar | `bg-slate-900/95` | `bg-white/95` |
| Hover | `hover:bg-slate-700/50` | `hover:bg-slate-100` |

### 6. CSS Global

**Arquivo:** `resources/css/app.css`

```css
/* Transição suave ao alternar tema */
*, *::before, *::after {
    transition-property: background-color, border-color, color;
    transition-duration: 300ms;
    transition-timing-function: ease;
}

/* Exceção: não transicionar SVGs e ícones */
svg, img, video {
    transition: none;
}
```

---

## Tarefas

| # | Tarefa | Prioridade | Estimativa |
|---|--------|------------|------------|
| DL.1 | Configurar `darkMode: 'class'` no `tailwind.config.js` | 🔴 CRÍTICA | 5 min |
| DL.2 | Inserir script anti-FOUC no `<head>` do layout principal | 🔴 CRÍTICA | 15 min |
| DL.3 | Criar Alpine.js `$store('theme')` em `app.js` | 🔴 CRÍTICA | 20 min |
| DL.4 | Adicionar botão de toggle na navbar | 🔴 CRÍTICA | 15 min |
| DL.5 | Mapear e adicionar classes `dark:` em todas as views | 🔴 CRÍTICA | 2-3h |
| DL.6 | Adicionar transição CSS global | 🟡 Média | 10 min |
| DL.7 | Testar FOUC (recarregar com cada tema salvo) | 🟡 Média | 20 min |
| DL.8 | Testar com `prefers-color-scheme: dark/light` no OS | 🟡 Média | 15 min |
| DL.9 | Testar componentes Livewire após rerenders | 🟡 Média | 30 min |
| DL.10 | Garantir acessibilidade (contraste WCAG AA) no light mode | 🟢 Baixa | 30 min |

---

## Dependências

- Tailwind CSS (já instalado) — apenas reconfiguração
- Alpine.js (já instalado) — apenas novo store
- **Sem novas dependências** — solução 100% com a stack atual

---

## Pontos de Atenção

### FOUC (Flash of Unstyled Content)
O script anti-FOUC no `<head>` é **obrigatório**. Sem ele, o usuário verá um flash do tema incorreto toda vez que recarregar a página, pois Alpine.js inicializa depois do DOM.

### Componentes Livewire
Livewire rerenders parciais do DOM não afetam o tema pois a classe `dark` está no `<html>` (persistente). Nenhuma lógica Livewire especial é necessária.

### Glassmorphism no Light Mode
O design atual usa `backdrop-blur` + transparências sobre fundos escuros. No light mode, os cards precisam de bordas mais sólidas (`border-slate-200`) e sombras (`shadow-sm`) para manter a hierarquia visual.

---

## Estimativa Total

| Fase | Esforço |
|------|---------|
| Setup (DL.1–DL.4) | ~1h |
| Mapeamento de views (DL.5) | 2-3h |
| Testes e ajustes (DL.6–DL.10) | ~1.5h |
| **Total** | **~5h** |

---

## Referências

- [Tailwind CSS Dark Mode](https://tailwindcss.com/docs/dark-mode)
- [Alpine.js Stores](https://alpinejs.dev/globals/alpine-store)
- [WCAG 2.1 — Contraste mínimo AA](https://www.w3.org/TR/WCAG21/#contrast-minimum)
