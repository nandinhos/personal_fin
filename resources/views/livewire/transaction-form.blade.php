<div class="glass-panel p-8 rounded-[2.5rem] mt-4 relative overflow-hidden">
    {{-- Decorative Background Aura --}}
    <div class="absolute -right-20 -top-20 w-80 h-80 bg-indigo-500 rounded-full blur-[100px] opacity-10 pointer-events-none"></div>
    
    <div class="flex items-center justify-between mb-8 relative z-10">
        <div class="flex items-center gap-4">
            <div class="p-3 @if($type === 'income') bg-emerald-500/20 @elseif($type === 'expense') bg-rose-500/20 @else bg-indigo-500/20 @endif rounded-2xl border border-white/10 shadow-lg transition-colors duration-500">
                <svg class="w-6 h-6 @if($type === 'income') text-emerald-400 @elseif($type === 'expense') text-rose-400 @else text-indigo-400 @endif" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                </svg>
            </div>
            <h2 class="text-2xl font-black text-slate-900 dark:text-white leading-none tracking-tight">
                {{ $transactionId ? 'Editar Lançamento' : 'Novo Lançamento' }}
            </h2>
        </div>

        <!-- Seletor de Tipo Obsidian Style -->
        <div class="flex p-1 bg-slate-100 dark:bg-white/5 rounded-2xl border border-black/5 dark:border-white/5 shadow-inner">
            <button type="button" wire:click="$set('type', 'expense')" class="px-6 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ $type === 'expense' ? 'bg-white dark:bg-slate-700 text-rose-500 shadow-md scale-105' : 'text-slate-500 hover:text-slate-700 dark:hover:text-slate-300' }}">
                Despesa
            </button>
            <button type="button" wire:click="$set('type', 'income')" class="px-6 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ $type === 'income' ? 'bg-white dark:bg-slate-700 text-emerald-500 shadow-md scale-105' : 'text-slate-500 hover:text-slate-700 dark:hover:text-slate-300' }}">
                Receita
            </button>
            <button type="button" wire:click="$set('type', 'transfer')" class="px-6 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ $type === 'transfer' ? 'bg-white dark:bg-slate-700 text-indigo-500 shadow-md scale-105' : 'text-slate-500 hover:text-slate-700 dark:hover:text-slate-300' }}">
                Transferência
            </button>
        </div>
    </div>

    <form wire:submit="save" class="space-y-8 relative z-10">
        @if (session()->has('success'))
            <div class="p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm font-bold rounded-2xl flex items-center gap-3 animate-pulse">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Coluna 1: O que e Quanto -->
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2 uppercase tracking-wider">Valor da Operação</label>
                    <div class="relative group">
                        <span class="absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 font-black text-xl">R$</span>
                        <input type="number" step="0.01" wire:model="amount" 
                               class="w-full pl-16 pr-6 py-5 bg-slate-50 dark:bg-slate-900/50 border-slate-200 dark:border-white/10 rounded-[1.5rem] text-4xl font-black tracking-tighter focus:ring-4 transition-all shadow-inner 
                               {{ $type === 'income' ? 'text-emerald-500 focus:ring-emerald-500/20 focus:border-emerald-500' : ($type === 'expense' ? 'text-rose-500 focus:ring-rose-500/20 focus:border-rose-500' : 'text-indigo-500 focus:ring-indigo-500/20 focus:border-indigo-500') }}"
                               placeholder="0,00">
                    </div>
                    @error('amount') <span class="text-xs text-rose-500 font-bold mt-2 block ml-2">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2 uppercase tracking-wider">Descrição / Título</label>
                    <input type="text" wire:model="description" 
                           class="w-full px-6 py-4 bg-slate-50 dark:bg-slate-900/50 border-slate-200 dark:border-white/10 rounded-2xl text-lg font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all shadow-sm" 
                           placeholder="Ex: Aluguel, Supermercado, Salário...">
                    @error('description') <span class="text-xs text-rose-500 font-bold mt-2 block ml-2">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2 uppercase tracking-wider">Data</label>
                        <input type="date" wire:model="date" 
                               class="w-full px-6 py-4 bg-slate-50 dark:bg-slate-900/50 border-slate-200 dark:border-white/10 rounded-2xl font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all shadow-sm">
                        @error('date') <span class="text-xs text-rose-500 font-bold mt-2 block ml-2">{{ $message }}</span> @enderror
                    </div>
                    @if($type !== 'transfer')
                        <div>
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2 uppercase tracking-wider">Categoria</label>
                            <select wire:model="category_id" 
                                    class="w-full px-6 py-4 bg-slate-50 dark:bg-slate-900/50 border-slate-200 dark:border-white/10 rounded-2xl font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all shadow-sm">
                                <option value="">Selecione...</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <span class="text-xs text-rose-500 font-bold mt-2 block ml-2">{{ $message }}</span> @enderror
                        </div>
                    @endif
                </div>
            </div>

            <!-- Coluna 2: Origem e Destino -->
            <div class="space-y-6">
                @if($type === 'transfer')
                    <div class="p-6 bg-indigo-500/5 rounded-3xl border border-indigo-500/10 space-y-6">
                        <div>
                            <label class="block text-[10px] font-black text-indigo-500 uppercase tracking-[0.2em] mb-3">Retirar da Conta</label>
                            <select wire:model="account_id" 
                                    class="w-full px-6 py-4 bg-white dark:bg-slate-900 border-slate-200 dark:border-white/10 rounded-2xl font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all shadow-sm">
                                <option value="">Selecione a Origem...</option>
                                @foreach($accounts as $acc)
                                    <option value="{{ $acc->id }}">{{ $acc->name }} (R$ {{ number_format($acc->balance, 2, ',', '.') }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex justify-center -my-3 relative z-10">
                            <div class="p-2 bg-indigo-500 rounded-full text-white shadow-lg shadow-indigo-500/40">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 14l-7 7m0 0l-7-7m7 7V3" /></svg>
                            </div>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-indigo-500 uppercase tracking-[0.2em] mb-3">Depositar na Conta</label>
                            <select wire:model="to_account_id" 
                                    class="w-full px-6 py-4 bg-white dark:bg-slate-900 border-slate-200 dark:border-white/10 rounded-2xl font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all shadow-sm">
                                <option value="">Selecione o Destino...</option>
                                @foreach($accounts as $acc)
                                    <option value="{{ $acc->id }}">{{ $acc->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @else
                    <div class="p-6 bg-slate-50 dark:bg-white/5 rounded-3xl border border-slate-200 dark:border-white/10 space-y-6">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Movimentar na Conta</label>
                            <select wire:model="account_id" @if($card_id) disabled @endif
                                    class="w-full px-6 py-4 bg-white dark:bg-slate-900 border-slate-200 dark:border-white/10 rounded-2xl font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all shadow-sm disabled:opacity-40 disabled:grayscale">
                                <option value="">--- Escolher uma Conta ---</option>
                                @foreach($accounts as $acc)
                                    <option value="{{ $acc->id }}">{{ $acc->name }} (R$ {{ number_format($acc->balance, 2, ',', '.') }})</option>
                                @endforeach
                            </select>
                        </div>

                        @if($type === 'expense')
                            <div class="relative flex py-2 items-center">
                                <div class="flex-grow border-t border-slate-200 dark:border-white/5"></div>
                                <span class="flex-shrink mx-4 text-[10px] font-black text-slate-300 dark:text-slate-600 tracking-widest">OU USE UM CARTÃO</span>
                                <div class="flex-grow border-t border-slate-200 dark:border-white/5"></div>
                            </div>

                            <div>
                                <select wire:model="card_id" @if($account_id) disabled @endif
                                        class="w-full px-6 py-4 bg-white dark:bg-slate-900 border-slate-200 dark:border-white/10 rounded-2xl font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all shadow-sm disabled:opacity-40 disabled:grayscale">
                                    <option value="">--- Escolher um Cartão ---</option>
                                    @foreach($cards as $card)
                                        <option value="{{ $card->id }}">{{ $card->name }} (Final {{ $card->last_four_digits }})</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Recorrência Obsidian Style -->
                <div class="pt-4 px-2">
                    <label class="flex items-center gap-4 cursor-pointer group">
                        <div class="relative">
                            <input type="checkbox" wire:model.live="is_recurring" class="sr-only peer">
                            <div class="w-12 h-6 bg-slate-200 dark:bg-white/10 rounded-full peer peer-checked:bg-indigo-500 transition-all duration-300"></div>
                            <div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition-all duration-300 peer-checked:translate-x-6"></div>
                        </div>
                        <span class="text-xs font-black text-slate-500 group-hover:text-slate-700 dark:group-hover:text-slate-300 transition-colors tracking-[0.15em] uppercase">Lançamento Recorrente</span>
                    </label>

                    @if($is_recurring)
                        <div class="mt-6 p-4 bg-indigo-500/5 rounded-2xl border border-indigo-500/10 animate-in fade-in slide-in-from-top-4">
                            <label class="block text-[10px] font-bold text-indigo-400 uppercase tracking-widest mb-2">Frequência da Repetição</label>
                            <select wire:model="recurring_frequency" class="w-full bg-transparent border-none font-black text-slate-900 dark:text-white focus:ring-0 p-0 text-sm">
                                <option value="weekly">Toda Semana</option>
                                <option value="monthly">Todo Mês</option>
                                <option value="yearly">Todo Ano</option>
                            </select>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Rodapé Obsidian -->
        <div class="flex items-center justify-end gap-4 pt-8 border-t border-slate-200 dark:border-white/10">
            <button type="button" wire:click="$dispatch('close-transaction-form')" 
                    class="px-8 py-4 text-xs font-black uppercase tracking-[0.2em] rounded-2xl text-slate-500 hover:bg-slate-100 dark:hover:bg-white/5 transition-all">
                Cancelar
            </button>
            <button type="submit" 
                    class="glass-button-primary px-16 py-4 rounded-2xl transition-all duration-500 
                    {{ $type === 'income' ? '!from-emerald-600 !to-emerald-500 !shadow-emerald-500/30' : ($type === 'expense' ? '!from-rose-600 !to-rose-500 !shadow-rose-500/30' : '!from-indigo-600 !to-indigo-500 !shadow-indigo-500/30') }}">
                <span class="flex items-center gap-2">
                    <span wire:loading.remove wire:target="save">{{ $transactionId ? 'Salvar Alterações' : 'Confirmar Lançamento' }}</span>
                    <span wire:loading wire:target="save">Sincronizando...</span>
                    <svg wire:loading.remove wire:target="save" class="w-5 h-5 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                </span>
            </button>
        </div>
    </form>
</div>
