<x-app-layout>
    <div class="space-y-10">
        <header class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6 relative">
            <div class="absolute -top-10 -left-10 w-64 h-64 obsidian-glow opacity-30 pointer-events-none"></div>
            <div>
                <h1 class="text-4xl font-extrabold tracking-tight text-slate-900 dark:text-white glow-text">Minhas Contas</h1>
                <p class="mt-2 text-base text-slate-500 font-medium italic">Gerencie suas contas bancárias e carteiras digitais.</p>
            </div>
            <a href="{{ route('accounts.create') }}"
                class="glass-button-primary px-8 py-4 flex items-center gap-3 group transition-all">
                <div class="w-6 h-6 rounded-lg bg-white/20 flex items-center justify-center group-hover:rotate-90 transition-transform">
                    <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
                <span class="font-bold uppercase tracking-widest text-[11px]">Nova Conta</span>
            </a>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
            @forelse($accounts as $account)
                <div class="glass-panel p-8 rounded-[2.5rem] relative overflow-hidden group hover:scale-[1.02] transition-all duration-500 shadow-[0_20px_50px_rgba(0,0,0,0.2)]">
                    <!-- Subtle Glow -->
                    <div class="absolute -top-12 -right-12 w-48 h-48 bg-obsidian-primary/5 rounded-full blur-[80px] group-hover:bg-obsidian-primary/10 transition-all"></div>
                    
                    <div class="flex items-start justify-between relative z-10">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 rounded-2xl bg-white/5 dark:bg-black/5 flex items-center justify-center border border-white/10 dark:border-black/5 text-2xl shadow-inner group-hover:border-obsidian-primary/30 transition-colors">
                                {{ $account->icon ?? '💳' }}
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-slate-900 dark:text-white tracking-tight leading-none mb-2">{{ $account->name }}</h3>
                                <span class="px-2 py-0.5 rounded-lg bg-obsidian-primary/10 border border-obsidian-primary/20 text-[9px] font-black text-obsidian-primary uppercase tracking-widest">
                                    {{ ucfirst($account->type) }}
                                </span>
                            </div>
                        </div>
                        <div class="opacity-0 group-hover:opacity-100 transition-opacity flex gap-2">
                             <a href="{{ route('accounts.edit', $account) }}" class="p-2 text-slate-500 hover:text-cyan-400 transition-colors">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                             </a>
                        </div>
                    </div>

                    <div class="mt-10 relative z-10">
                        <p class="text-[9px] text-slate-500 uppercase font-black tracking-[0.2em] mb-1">Saldo Atual</p>
                        <p class="text-3xl font-black text-slate-900 dark:text-white tabular-nums tracking-tighter">
                            <span class="text-sm font-bold text-slate-500 mr-1">R$</span>{{ number_format($account->balance, 2, ',', '.') }}
                        </p>
                    </div>

                    <div class="absolute bottom-0 right-0 w-full h-1 bg-gradient-to-r from-transparent via-obsidian-primary/20 to-transparent group-hover:via-obsidian-primary transition-all"></div>
                </div>
            @empty
                <div class="col-span-full glass-panel p-20 text-center rounded-[3rem]">
                    <div class="w-20 h-20 bg-white/5 dark:bg-black/5 rounded-3xl flex items-center justify-center mx-auto mb-8 border border-white/5">
                        <svg class="w-10 h-10 text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                    </div>
                    <p class="text-slate-500 font-medium italic mb-6">Nenhuma conta registrada no cofre.</p>
                    <a href="{{ route('accounts.create') }}" class="inline-flex items-center gap-2 text-cyan-400 font-bold uppercase tracking-widest text-[10px] hover:glow-text transition-all group">
                        <span>Configurar Primeira Conta</span>
                        <svg class="w-3 h-3 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>

