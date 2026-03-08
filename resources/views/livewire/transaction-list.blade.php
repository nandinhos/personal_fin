<div class="space-y-8">
    <!-- Barra de Ferramentas / Filtros Obsidian -->
    <div class="glass-panel p-6 rounded-[2rem] flex flex-col md:flex-row gap-6 items-center justify-between border-black/5 dark:border-white/5 shadow-2xl">
        
        <!-- Busca Dinâmica -->
        <div class="relative w-full md:w-96 group">
            <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-500 transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input 
                type="text" 
                wire:model.live.debounce.300ms="search" 
                placeholder="Pesquisar transação..." 
                class="w-full pl-12 pr-4 py-3 bg-slate-50 dark:bg-slate-900/50 border-slate-200 dark:border-white/10 rounded-2xl text-sm font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all shadow-inner"
            >
        </div>

        <!-- Seletores de Filtro -->
        <div class="flex flex-wrap items-center gap-4 w-full md:w-auto">
            <div class="flex items-center gap-2 bg-slate-50 dark:bg-white/5 p-1.5 rounded-2xl border border-slate-200 dark:border-white/10">
                <select wire:model.live="typeFilter" class="bg-transparent border-none text-[10px] font-black uppercase tracking-widest text-slate-500 dark:text-slate-400 focus:ring-0 cursor-pointer pr-8">
                    <option value="">TODOS TIPOS</option>
                    <option value="expense">DESPESAS</option>
                    <option value="income">RECEITAS</option>
                    <option value="transfer">TRANSFERÊNCIAS</option>
                </select>
            </div>

            <div class="flex items-center gap-2 bg-slate-50 dark:bg-white/5 p-1.5 rounded-2xl border border-slate-200 dark:border-white/10">
                <select wire:model.live="accountFilter" class="bg-transparent border-none text-[10px] font-black uppercase tracking-widest text-slate-500 dark:text-slate-400 focus:ring-0 cursor-pointer pr-8">
                    <option value="">TODAS CONTAS</option>
                    @foreach($accounts as $acc)
                        <option value="{{ $acc->id }}">{{ mb_strtoupper($acc->name) }}</option>
                    @endforeach
                </select>
            </div>

            @if($search || $typeFilter || $accountFilter)
                <button 
                    wire:click="$set('search', ''); $set('typeFilter', ''); $set('accountFilter', '')"
                    class="p-2 text-rose-500 hover:bg-rose-500/10 rounded-xl transition-colors"
                    title="Limpar Filtros">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            @endif
        </div>
    </div>

    <!-- Container da Tabela Glass -->
    <div class="glass-panel rounded-[2.5rem] overflow-hidden border-black/5 dark:border-white/5 shadow-2xl relative">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 dark:bg-white/[0.03] text-[10px] uppercase font-black text-slate-400 tracking-[0.2em]">
                        <th class="px-8 py-6">Data</th>
                        <th class="px-8 py-6">Detalhes</th>
                        <th class="px-8 py-6">Fluxo</th>
                        <th class="px-8 py-6 text-right">Valor</th>
                        <th class="px-8 py-6 text-center">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-white/5">
                    @forelse($transactions as $transaction)
                        <tr class="group hover:bg-slate-50/80 dark:hover:bg-white/[0.02] transition-all duration-300">
                            <td class="px-8 py-5">
                                <div class="flex flex-col">
                                    <span class="text-sm font-black text-slate-900 dark:text-white leading-none">
                                        {{ $transaction->date->format('d/m') }}
                                    </span>
                                    <span class="text-[10px] font-bold text-slate-400 mt-1 uppercase">
                                        {{ $transaction->date->translatedFormat('D') }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white shrink-0 shadow-lg" 
                                         style="background-color: {{ $transaction->category?->color ?? '#64748b' }}">
                                        {!! \App\Helpers\IconHelper::render($transaction->category?->icon ?? 'collection') !!}
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold text-slate-900 dark:text-white group-hover:text-indigo-500 transition-colors">
                                            {{ $transaction->description }}
                                        </span>
                                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-wider mt-0.5">
                                            {{ $transaction->category?->name ?? ($transaction->type === 'transfer' ? 'Transferência' : 'Geral') }}
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-2">
                                    @if($transaction->card_id)
                                        <div class="flex items-center gap-1.5 px-3 py-1 rounded-lg bg-emerald-500/10 text-emerald-500 border border-emerald-500/20">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
                                            <span class="text-[10px] font-black uppercase">{{ $transaction->card->name }}</span>
                                        </div>
                                    @elseif($transaction->account_id)
                                        <div class="flex items-center gap-1.5 px-3 py-1 rounded-lg bg-indigo-500/10 text-indigo-500 border border-indigo-500/20">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H5a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                                            <span class="text-[10px] font-black uppercase">{{ $transaction->account->name }}</span>
                                        </div>
                                    @endif

                                    @if($transaction->type === 'transfer')
                                        <svg class="w-4 h-4 text-slate-300 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                        </svg>
                                        <div class="flex items-center gap-1.5 px-3 py-1 rounded-lg bg-indigo-500/10 text-indigo-500 border border-indigo-500/20">
                                            <span class="text-[10px] font-black uppercase">{{ $transaction->toAccount->name }}</span>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-8 py-5 text-right">
                                <div class="flex flex-col items-end">
                                    <span class="text-base font-black tracking-tight @if($transaction->type === 'income') text-emerald-500 @elseif($transaction->type === 'expense') text-rose-500 @else text-slate-500 @endif">
                                        {{ $transaction->type === 'expense' ? '-' : '' }} R$ {{ number_format($transaction->amount, 2, ',', '.') }}
                                    </span>
                                    @if($transaction->is_recurring)
                                        <span class="text-[8px] font-black bg-indigo-500/10 text-indigo-500 px-1.5 py-0.5 rounded-md mt-1 uppercase tracking-tighter">Recorrente</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <div class="flex items-center justify-center gap-3 opacity-0 group-hover:opacity-100 transition-all duration-300 translate-x-2 group-hover:translate-x-0">
                                    <button 
                                        wire:click="$parent.openForm({{ $transaction->id }})"
                                        class="p-2 text-slate-400 hover:text-indigo-500 hover:bg-indigo-500/10 rounded-xl transition-all">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                    <button 
                                        wire:confirm="Deseja realmente excluir este lançamento?"
                                        wire:click="delete({{ $transaction->id }})"
                                        class="p-2 text-slate-400 hover:text-rose-500 hover:bg-rose-500/10 rounded-xl transition-all">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-32 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="p-6 rounded-full bg-slate-100 dark:bg-white/5 text-slate-300 dark:text-slate-600 mb-4">
                                        <svg class="w-16 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-black text-slate-900 dark:text-white tracking-tight">Nenhuma transação aqui</h3>
                                    <p class="text-slate-500 mt-2 font-medium max-w-xs mx-auto">Ajuste os filtros ou registre sua primeira movimentação financeira.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($transactions->hasPages())
            <div class="px-8 py-6 bg-slate-50/50 dark:bg-white/[0.03] border-t border-slate-100 dark:border-white/5">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>
</div>
