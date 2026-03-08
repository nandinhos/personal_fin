<div class="space-y-8 pb-20">
    <header class="relative mb-8 py-4">
        <div class="absolute -top-10 -left-10 w-64 h-64 bg-obsidian-primary/20 blur-[100px] pointer-events-none rounded-full"></div>
        <h1 class="text-4xl font-black tracking-tight text-slate-900 dark:text-white glow-text">Painel de Controle</h1>
        <p class="mt-2 text-base text-slate-600 dark:text-slate-400 font-medium font-italic">Gestão centralizada das suas finanças. Status: <span class="text-obsidian-primary font-bold">Operacional</span></p>
    </header>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
        <!-- Saldo Total -->
        <div class="glass-panel p-8 group relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-obsidian-primary/5 blur-3xl rounded-full -mr-10 -mt-10 group-hover:bg-obsidian-primary/10 transition-all"></div>
            <div class="flex items-center justify-between mb-6">
                <div class="p-3 rounded-2xl bg-obsidian-primary/10 border border-obsidian-primary/20">
                    <svg class="w-8 h-8 text-obsidian-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="opacity-30 group-hover:opacity-100 transition-opacity">
                    <span class="text-[10px] font-black uppercase tracking-widest text-obsidian-primary">Saldo</span>
                </div>
            </div>
            <h3 class="text-xs font-bold text-slate-600 dark:text-slate-400 uppercase tracking-widest">Patrimônio Líquido</h3>
            <p class="mt-2 text-3xl font-black text-slate-900 dark:text-white tabular-nums tracking-tight">R$ {{ number_format($totalBalance, 2, ',', '.') }}</p>
        </div>

        <!-- Receitas -->
        <div class="glass-panel p-8 group cursor-pointer relative overflow-hidden" onclick="window.location.href='{{ route('transactions.index') }}?type=income'">
            <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/5 blur-3xl rounded-full -mr-10 -mt-10 group-hover:bg-emerald-500/10 transition-all"></div>
            <div class="flex items-center justify-between mb-6">
                <div class="p-3 rounded-2xl bg-emerald-500/10 border border-emerald-500/20">
                    <svg class="w-8 h-8 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
                <div class="text-[10px] font-black uppercase tracking-widest text-emerald-400">Ganhos</div>
            </div>
            <h3 class="text-xs font-bold text-slate-600 dark:text-slate-400 uppercase tracking-widest">Entradas do Mês</h3>
            <p class="mt-2 text-3xl font-black text-emerald-600 dark:text-emerald-400 tabular-nums tracking-tight">R$ {{ number_format($monthlyIncome, 2, ',', '.') }}</p>
        </div>

        <!-- Despesas -->
        <div class="glass-panel p-8 group cursor-pointer relative overflow-hidden" onclick="window.location.href='{{ route('transactions.index') }}?type=expense'">
            <div class="absolute top-0 right-0 w-32 h-32 bg-rose-500/5 blur-3xl rounded-full -mr-10 -mt-10 group-hover:bg-rose-500/10 transition-all"></div>
            <div class="flex items-center justify-between mb-6">
                <div class="p-3 rounded-2xl bg-rose-500/10 border border-rose-500/20">
                    <svg class="w-8 h-8 text-rose-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6" />
                    </svg>
                </div>
                <div class="text-[10px] font-black uppercase tracking-widest text-rose-400">Gastos</div>
            </div>
            <h3 class="text-xs font-bold text-slate-600 dark:text-slate-400 uppercase tracking-widest">Saídas do Mês</h3>
            <p class="mt-2 text-3xl font-black text-rose-600 dark:text-rose-400 tabular-nums tracking-tight">R$ {{ number_format($monthlyExpenses, 2, ',', '.') }}</p>
        </div>

        <!-- Metas -->
        <div class="glass-panel p-8 group cursor-pointer relative overflow-hidden" onclick="window.location.href='{{ route('goals.index') }}'">
            <div class="absolute top-0 right-0 w-32 h-32 bg-amber-500/5 blur-3xl rounded-full -mr-10 -mt-10 group-hover:bg-amber-500/10 transition-all"></div>
            <div class="flex items-center justify-between mb-6">
                <div class="p-3 rounded-2xl bg-amber-500/10 border border-amber-500/20">
                    <svg class="w-8 h-8 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="text-[10px] font-black uppercase tracking-widest text-amber-400">Progresso</div>
            </div>
            <h3 class="text-xs font-bold text-slate-600 dark:text-slate-400 uppercase tracking-widest">Objetivos</h3>
            <div class="mt-2 flex items-baseline gap-2">
                <p class="text-3xl font-black text-slate-900 dark:text-white tabular-nums tracking-tight">{{ $goalsProgress }}%</p>
                <div class="flex-1 h-2 rounded-full bg-slate-200 dark:bg-white/10 overflow-hidden">
                    <div class="h-full bg-amber-500 shadow-[0_0_10px_#f59e0b] duration-1000 transition-all" style="width: {{ $goalsProgress }}%"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
        <!-- Registro Financeiro -->
        <div class="lg:col-span-2 glass-panel rounded-[2.5rem] overflow-hidden">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between p-8 border-b border-white/5">
                <div>
                    <h3 class="text-xl font-black text-slate-900 dark:text-white tracking-tight">Registros Recentes</h3>
                    <p class="text-xs text-slate-500 font-bold uppercase tracking-widest mt-1">Últimas transações no sistema</p>
                </div>
                <a href="{{ route('transactions.index') }}" class="glass-button text-[10px] py-3 px-6 uppercase tracking-widest font-black mt-4 sm:mt-0">Ver Tudo</a>
            </div>
            <div class="divide-y divide-white/5">
                @forelse($recentTransactions as $item)
                    <div class="flex items-center justify-between p-8 transition-all hover:bg-white/[0.02]">
                        <div class="flex items-center gap-6">
                            <div class="w-14 h-14 rounded-2xl glass-panel border-white/10 flex items-center justify-center text-xl">
                                {{ $item['type'] === 'income' ? '💰' : '💸' }}
                            </div>
                            <div>
                                <p class="text-base font-black text-slate-900 dark:text-white">{{ $item['name'] }}</p>
                                <p class="text-[10px] font-bold text-slate-500 flex items-center gap-2 mt-1 uppercase tracking-widest">
                                    <span class="px-2 py-0.5 rounded-lg bg-obsidian-primary/10 border border-obsidian-primary/20 text-obsidian-primary">{{ $item['category'] }}</span>
                                    <span>{{ $item['date'] }}</span>
                                </p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-black tabular-nums {{ $item['amount'] > 0 ? 'text-emerald-400' : 'text-rose-400' }}">
                                {{ $item['amount'] > 0 ? '+' : '' }}R$ {{ number_format(abs($item['amount']), 2, ',', '.') }}
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="p-16 text-center">
                        <div class="w-20 h-20 bg-white/5 rounded-full flex items-center justify-center mx-auto mb-4 border border-white/5">
                            <svg class="w-10 h-10 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <p class="text-slate-500 font-bold uppercase tracking-widest text-xs">Nenhum registro encontrado</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Painel de Ações & Margem -->
        <div class="space-y-8">
            <div class="glass-panel p-8 rounded-[2.5rem]">
                <h3 class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-8">Painel de Ações</h3>
                <div class="grid grid-cols-3 gap-4">
                    <button wire:click="openQuickTransactionModal('income')" class="flex flex-col items-center justify-center p-5 rounded-2xl glass-panel border-white/5 hover:border-emerald-500/50 hover:bg-emerald-500/10 transition-all group">
                        <div class="w-10 h-10 rounded-full bg-emerald-500/10 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                            </svg>
                        </div>
                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-500 group-hover:text-slate-900 dark:group-hover:text-white transition-colors">Receita</span>
                    </button>
                    <button wire:click="openQuickTransactionModal('expense')" class="flex flex-col items-center justify-center p-5 rounded-2xl glass-panel border-white/5 hover:border-rose-500/50 hover:bg-rose-500/10 transition-all group">
                        <div class="w-10 h-10 rounded-full bg-rose-500/10 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 text-rose-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 12H4" />
                            </svg>
                        </div>
                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-500 group-hover:text-slate-900 dark:group-hover:text-white transition-colors">Despesa</span>
                    </button>
                    <button wire:click="openQuickTransactionModal('transfer')" class="flex flex-col items-center justify-center p-5 rounded-2xl glass-panel border-white/5 hover:border-obsidian-primary/50 hover:bg-obsidian-primary/10 transition-all group">
                        <div class="w-10 h-10 rounded-full bg-obsidian-primary/10 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 text-obsidian-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                            </svg>
                        </div>
                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-500 group-hover:text-slate-900 dark:group-hover:text-white transition-colors">Trocar</span>
                    </button>
                </div>
            </div>

            <div class="glass-panel p-8 rounded-[2.5rem] relative overflow-hidden group">
                <a href="{{ route('limits.index') }}" class="block relative z-10">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Status de Margem</h3>
                        <span class="text-xs font-black text-obsidian-primary">{{ $monthlyLimitPercent }}%</span>
                    </div>
                    <div class="w-full h-3 rounded-full bg-slate-300 dark:bg-white/10 overflow-hidden">
                        <div class="h-full rounded-full bg-gradient-to-r from-obsidian-primary to-emerald-400 shadow-[0_0_12px_rgba(5,183,214,0.6)] transition-all duration-1000" style="width: {{ max(min($monthlyLimitPercent, 100), 2) }}%"></div>
                    </div>
                </a>
                <p class="mt-6 text-[11px] text-slate-500 font-bold uppercase tracking-widest leading-loose">
                    Sobram <span class="text-slate-900 dark:text-white">R$ {{ number_format($monthlyLimitAvailable, 2, ',', '.') }}</span> para o ciclo atual.
                </p>
            </div>
        </div>
    </div>

    @if($showQuickTransactionModal)
        <div class="fixed inset-0 z-[60] flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/60 backdrop-blur-md" wire:click="closeQuickTransactionModal"></div>
            <div class="relative glass-panel rounded-[2.5rem] w-full max-w-lg p-10 overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-obsidian-primary to-emerald-400"></div>
                
                <h2 class="text-3xl font-black text-slate-900 dark:text-white mb-8 tracking-tight">
                    @if($quickTransactionType === 'income')
                        💰 Nova Receita
                    @elseif($quickTransactionType === 'expense')
                        💸 Nova Despesa
                    @else
                        🔄 Transferência
                    @endif
                </h2>
                
                <form wire:submit.prevent="saveQuickTransaction" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <x-input-label for="q-desc" value="Descrição da Atividade" />
                            <x-text-input id="q-desc" type="text" wire:model="quickForm.description" placeholder="Ex: Supermercado, Aluguel..." />
                            @error('quickForm.description') <p class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <x-input-label for="q-amount" value="Valor (R$)" />
                            <x-text-input id="q-amount" type="number" step="0.01" min="0.01" wire:model="quickForm.amount" placeholder="0,00" />
                            @error('quickForm.amount') <p class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <x-input-label for="q-date" value="Data" />
                            <x-text-input id="q-date" type="date" wire:model="quickForm.date" />
                            @error('quickForm.date') <p class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</p> @enderror
                        </div>

                        @if($quickTransactionType !== 'transfer')
                        <div class="md:col-span-2">
                            <x-input-label for="q-cat" value="Categoria" />
                            <select id="q-cat" wire:model="quickForm.category_id" class="w-full px-5 py-4 bg-slate-100 dark:bg-white/5 border border-slate-300 dark:border-white/10 rounded-2xl text-slate-900 dark:text-white font-bold focus:outline-none focus:ring-2 focus:ring-obsidian-primary transition-all appearance-none cursor-pointer">
                                <option value="" class="text-slate-900 dark:text-white bg-white dark:bg-slate-900">Selecione...</option>
                                @foreach($categories as $cat)
                                    @if($cat['type'] === $quickTransactionType)
                                        <option value="{{ $cat['id'] }}" class="text-slate-900 dark:text-white bg-white dark:bg-slate-900">{{ $cat['name'] }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('quickForm.category_id') <p class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</p> @enderror
                        </div>
                        @endif

                        <div class="{{ $quickTransactionType === 'transfer' ? 'md:col-span-1' : 'md:col-span-2' }}">
                            <x-input-label for="q-acc" :value="$quickTransactionType === 'transfer' ? 'Conta Origem' : 'Conta Responsável'" />
                            <select id="q-acc" wire:model="quickForm.account_id" class="w-full px-5 py-4 bg-slate-100 dark:bg-white/5 border border-slate-300 dark:border-white/10 rounded-2xl text-slate-900 dark:text-white font-bold focus:outline-none focus:ring-2 focus:ring-obsidian-primary transition-all appearance-none cursor-pointer">
                                @foreach($accounts as $acc)
                                    <option value="{{ $acc['id'] }}" class="text-slate-900 dark:text-white bg-white dark:bg-slate-900">{{ $acc['name'] }}</option>
                                @endforeach
                            </select>
                            @error('quickForm.account_id') <p class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</p> @enderror
                        </div>

                        @if($quickTransactionType === 'transfer')
                        <div>
                            <x-input-label for="q-to-acc" value="Conta Destino" />
                            <select id="q-to-acc" wire:model="quickForm.to_account_id" class="w-full px-5 py-4 bg-slate-100 dark:bg-white/5 border border-slate-300 dark:border-white/10 rounded-2xl text-slate-900 dark:text-white font-bold focus:outline-none focus:ring-2 focus:ring-obsidian-primary transition-all appearance-none cursor-pointer">
                                <option value="" class="text-slate-900 dark:text-white bg-white dark:bg-slate-900">Selecione...</option>
                                @foreach($accounts as $acc)
                                    @if($acc['id'] != $quickForm['account_id'])
                                        <option value="{{ $acc['id'] }}" class="text-slate-900 dark:text-white bg-white dark:bg-slate-900">{{ $acc['name'] }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('quickForm.to_account_id') <p class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</p> @enderror
                        </div>
                        @endif
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4 pt-6">
                        <button type="button" wire:click="closeQuickTransactionModal" class="flex-1 px-8 py-4 glass-button uppercase tracking-widest text-[10px] font-black">
                            Cancelar
                        </button>
                        <button type="submit" class="flex-1 px-8 py-4 {{ $quickTransactionType === 'income' ? 'bg-emerald-600' : ($quickTransactionType === 'expense' ? 'bg-rose-600' : 'bg-obsidian-primary') }} text-white font-black rounded-2xl shadow-lg uppercase tracking-widest text-[10px] hover:scale-[1.02] active:scale-[0.98] transition-all">
                            Confirmar Registro
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
