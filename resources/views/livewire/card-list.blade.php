<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    @forelse($cards as $card)
        <div class="group relative glass-panel rounded-[2.5rem] p-8 transition-all duration-500 hover:shadow-[0_20px_50px_rgba(0,0,0,0.1)] dark:hover:shadow-[0_20px_50px_rgba(0,0,0,0.3)] hover:-translate-y-1 overflow-hidden">
            
            {{-- Background Aura --}}
            <div class="absolute -right-10 -top-10 w-32 h-32 rounded-full blur-3xl opacity-10 transition-opacity duration-500 group-hover:opacity-20"
                 style="background-color: {{ $card->color ?? '#10B981' }}"></div>

            <div class="absolute top-6 right-6 flex gap-2 opacity-0 group-hover:opacity-100 transition-all duration-300 translate-x-4 group-hover:translate-x-0">
                <button 
                    wire:click="$parent.openForm({{ $card->id }})"
                    class="p-2.5 bg-white dark:bg-slate-900 rounded-xl border border-slate-100 dark:border-white/10 text-slate-400 hover:text-indigo-400 transition-all shadow-xl hover:scale-110">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </button>
                <button 
                    wire:click="delete({{ $card->id }})"
                    wire:confirm="Tem certeza que deseja excluir este cartão?"
                    class="p-2.5 bg-white dark:bg-slate-900 rounded-xl border border-slate-100 dark:border-white/10 text-slate-400 hover:text-rose-400 transition-all shadow-xl hover:scale-110">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            </div>

            <div class="flex items-start justify-between">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-white shadow-lg rotate-3 group-hover:rotate-0 transition-transform duration-500" 
                     style="background: linear-gradient(135deg, {{ $card->color ?? '#10B981' }} 0%, {{ $card->color ?? '#10B981' }}dd 100%);">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                </div>
                <div class="text-right">
                    <span class="px-3 py-1 text-[10px] font-black uppercase tracking-widest rounded-full bg-slate-100 dark:bg-white/5 text-slate-500 dark:text-slate-400 border border-black/5 dark:border-white/5">
                        {{ $card->brand }}
                    </span>
                </div>
            </div>

            <div class="mt-8">
                <h3 class="text-xl font-black text-slate-900 dark:text-white group-hover:text-emerald-400 transition-colors tracking-tight leading-none">{{ $card->name }}</h3>
                <p class="text-[10px] font-bold text-slate-400 uppercase mt-2 tracking-[0.2em]">Limite Disponível</p>
                <div class="mt-1 flex items-baseline gap-1">
                    <span class="text-sm font-bold text-slate-400">R$</span>
                    <span class="text-3xl font-black text-slate-900 dark:text-white tracking-tighter">
                        {{ number_format($card->limit, 2, ',', '.') }}
                    </span>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-slate-100 dark:border-white/5 flex justify-between items-center">
                <div class="space-y-1">
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Final</p>
                    <p class="text-sm text-slate-900 dark:text-white font-mono font-bold tracking-[0.3em]">**** {{ $card->last_four_digits }}</p>
                </div>
                <div class="text-right space-y-1">
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Vencimento</p>
                    <div class="flex items-center justify-end gap-1.5">
                        <svg class="w-3 h-3 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p class="text-sm text-slate-900 dark:text-white font-black italic">Dia {{ str_pad($card->due_day, 2, '0', STR_PAD_LEFT) }}</p>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-full py-20 text-center glass-panel rounded-[2.5rem] border-dashed">
            <div class="inline-flex p-6 rounded-3xl bg-slate-100 dark:bg-white/5 text-slate-400 mb-6">
                <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                </svg>
            </div>
            <h3 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">Nenhum cartão ativo</h3>
            <p class="text-slate-500 mt-2 max-w-sm mx-auto font-medium">Sua carteira digital está vazia. Adicione cartões para gerenciar seus limites e datas de fatura.</p>
            <button wire:click="$parent.openForm" class="mt-8 glass-button-primary !from-emerald-600 !to-emerald-500 mx-auto">
                Cadastrar Primeiro Cartão
            </button>
        </div>
    @endforelse
</div>
