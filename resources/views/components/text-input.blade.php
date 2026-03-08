@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'glass-panel w-full px-5 py-3.5 rounded-2xl bg-slate-900/5 dark:bg-black/40 border-slate-200 dark:border-white/5 text-slate-900 dark:text-white focus:border-obsidian-primary focus:ring-1 focus:ring-obsidian-primary transition-all duration-300 placeholder-slate-400 dark:placeholder-slate-500 text-sm font-medium shadow-inner']) }}>
