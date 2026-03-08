<x-app-layout>
    <div class="space-y-10">
        <header class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6 relative">
            <div class="absolute -top-10 -left-10 w-64 h-64 obsidian-glow opacity-30 pointer-events-none"></div>
            <div>
                <h1 class="text-4xl font-extrabold tracking-tight text-slate-900 dark:text-white glow-text">Seus Cartões</h1>
                <p class="mt-2 text-base text-slate-400 font-medium italic">Gerencie seus artefatos de crédito e débito.</p>
            </div>
            <a href="{{ route('cards.create') }}"
                class="glass-button px-8 py-4 flex items-center gap-3 group transition-all">
                <div class="w-6 h-6 rounded-lg bg-cyan-500/20 flex items-center justify-center group-hover:bg-cyan-500/40 transition-colors">
                    <svg class="w-4 h-4 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
                <span class="font-bold uppercase tracking-widest text-[11px]">Novo Cartão</span>
            </a>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
            @forelse($cards as $card)
                <div class="glass-panel p-8 rounded-[2.5rem] relative overflow-hidden group hover:scale-[1.02] transition-all duration-500 shadow-[0_20px_50px_rgba(0,0,0,0.3)]">
                    <!-- Dynamic Glow -->
                    <div class="absolute -top-12 -right-12 w-48 h-48 bg-cyan-500/10 rounded-full blur-[80px] group-hover:bg-cyan-500/20 transition-all duration-700"></div>
                    <div class="absolute -bottom-12 -left-12 w-32 h-32 bg-purple-500/5 rounded-full blur-[60px] group-hover:bg-purple-500/10 transition-all duration-700"></div>
                    
                    <div class="flex items-start justify-between relative z-10">
                        <div>
                            <span class="text-[9px] font-black uppercase tracking-[0.3em] text-cyan-400/60 mb-2 block">
                                {{ $card->brand ?? 'BANCO EMISSOR' }}
                            </span>
                            <h3 class="text-2xl font-bold text-slate-900 dark:text-white tracking-tight leading-none">{{ $card->name }}</h3>
                        </div>
                        <div class="flex flex-col items-end gap-2">
                            <div class="w-12 h-12 rounded-2xl bg-black/5 dark:bg-white/5 flex items-center justify-center border border-black/10 dark:border-white/10 shadow-inner group-hover:border-cyan-500/30 transition-colors">
                                @if($card->type === 'credit')
                                    <svg class="w-6 h-6 text-slate-400 group-hover:text-cyan-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                @else
                                    <svg class="w-6 h-6 text-slate-400 group-hover:text-cyan-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                @endif
                            </div>
                            <div class="opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('cards.edit', $card) }}" class="p-2 text-slate-500 hover:text-cyan-400 transition-colors block">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="mt-12 relative z-10">
                        <div class="flex items-center gap-1.5 mb-6">
                            @for($i = 0; $i < 3; $i++)
                                <span class="text-slate-600 text-lg font-bold tracking-widest flex gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-700/50"></span>
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-700/50"></span>
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-700/50"></span>
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-700/50"></span>
                                </span>
                            @endfor
                            <span class="text-lg font-black text-slate-900 dark:text-white ml-2 tabular-nums tracking-tighter">{{ $card->last_four_digits }}</span>
                        </div>
                        
                        <div class="flex justify-between items-end border-t border-black/5 dark:border-white/5 pt-6">
                            <div>
                                <p class="text-[9px] text-slate-500 uppercase font-black tracking-[0.2em] mb-1">Limite Disponível</p>
                                <p class="text-2xl font-black text-slate-900 dark:text-white tabular-nums tracking-tighter">
                                    <span class="text-sm font-bold text-slate-500 mr-1">R$</span>{{ number_format($card->limit, 2, ',', '.') }}
                                </p>
                            </div>
                            <div class="flex flex-col items-end gap-2">
                                <span class="text-[9px] px-3 py-1 rounded-lg bg-cyan-500/10 text-cyan-400 border border-cyan-400/20 font-black uppercase tracking-widest shadow-[0_0_15px_rgba(6,182,212,0.1)]">
                                    {{ $card->type === 'credit' ? 'Crédito' : 'Débito' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full glass-panel p-20 text-center rounded-[3rem]">
                    <div class="w-20 h-20 bg-white/5 rounded-3xl flex items-center justify-center mx-auto mb-8 border border-white/5">
                        <svg class="w-10 h-10 text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                    </div>
                    <p class="text-slate-500 font-medium italic mb-6">Nenhum cartão registrado no diretório.</p>
                    <a href="{{ route('cards.create') }}" class="inline-flex items-center gap-2 text-cyan-400 font-bold uppercase tracking-widest text-[10px] hover:glow-text transition-all group">
                        <span>Configurar Primeiro Cartão</span>
                        <svg class="w-3 h-3 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>

