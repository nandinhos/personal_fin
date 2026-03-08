<div>
    <div class="space-y-8">
        {{-- Header Area with summary --}}
        <header class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-6 relative">
            
            @if($showForm)
                <div class="w-full">
                    <livewire:account-form :account-id="$account->id" wire:key="account-form-edit" />
                </div>
            @else
                {{-- Account Info --}}
                <div class="flex items-start gap-4 glass-panel p-6 rounded-[2rem] w-full sm:w-auto flex-1 relative overflow-hidden group">
                    <div class="absolute -right-10 -bottom-10 w-40 h-40 rounded-full blur-3xl opacity-20 pointer-events-none transition-opacity duration-500 group-hover:opacity-30" style="background-color: {{ $account->color ?? '#6366f1' }}"></div>
                    
                    <div class="p-4 rounded-3xl border shadow-lg flex-shrink-0" 
                        style="background-color: {{ $account->color ?? '#6366f1' }}15; border-color: {{ $account->color ?? '#6366f1' }}30">
                        <svg class="w-10 h-10" style="color: {{ $account->color ?? '#6366f1' }}; filter: drop-shadow(0 0 10px currentColor);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                    </div>
                    
                    <div>
                        <h1 class="text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white leading-none">{{ $account->name }}</h1>
                        <p class="text-xs uppercase font-bold tracking-wider text-slate-500 mt-2 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full" style="background-color: {{ $account->color ?? '#6366f1' }}"></span>
                            @switch($account->type)
                                @case('checking') Conta Corrente @break
                                @case('savings') Poupança @break
                                @case('investment') Investimento @break
                                @case('cash') Carteira @break
                                @case('other') Outros @break
                                @default {{ $account->type }}
                            @endswitch
                        </p>
                        <div class="mt-4 pt-4 border-t border-black/5 dark:border-white/10">
                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1">Saldo Atual</p>
                            <p class="text-3xl font-black {{ $account->balance < 0 ? 'text-red-500 dark:text-red-400' : 'text-emerald-600 dark:text-emerald-400' }} tracking-tight">
                                {{ 'R$ ' . number_format($account->balance, 2, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex flex-col sm:flex-col gap-3">
                    <button wire:click="openQuickTransaction" class="px-5 py-2.5 text-sm font-bold rounded-xl transition-all duration-300 bg-sky-600 hover:bg-sky-500 text-white shadow-[0_0_15px_rgba(2,132,199,0.4)] flex items-center justify-center gap-2">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                        Lançamento Rápido
                    </button>

                    <button wire:click="importData" class="px-5 py-2.5 text-sm font-bold rounded-xl transition-all duration-300 bg-slate-100 dark:bg-white/5 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-white/10 flex items-center justify-center gap-2 border border-slate-200 dark:border-white/5 hover:border-indigo-500/50">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" /></svg>
                        Importar Dados (OFX/CSV)
                    </button>
                    
                    <button wire:click="exportData" class="px-5 py-2.5 text-sm font-bold rounded-xl transition-all duration-300 bg-slate-100 dark:bg-white/5 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-white/10 flex items-center justify-center gap-2 border border-slate-200 dark:border-white/5 hover:border-emerald-500/50">
                        <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                        Exportar Extrato
                    </button>
                    
                    <button wire:click="openForm" class="px-5 py-2.5 text-sm font-bold rounded-xl transition-all duration-300 bg-indigo-600 hover:bg-indigo-500 text-white shadow-[0_0_15px_rgba(99,102,241,0.4)] flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                        Editar Informações
                    </button>
                </div>
            @endif
        </header>

        {{-- Alerts --}}
        @if (session()->has('success'))
            <div class="p-4 text-sm text-emerald-700 bg-emerald-500/10 border border-emerald-500/20 rounded-2xl dark:text-emerald-400 font-medium" role="alert">
                {{ session('success') }}
            </div>
        @endif

        {{-- Transactions List --}}
        <div class="glass-panel rounded-[2rem] overflow-hidden">
            <div class="px-6 py-5 border-b border-black/5 dark:border-white/10 flex items-center justify-between">
                <h3 class="text-lg font-bold text-slate-800 dark:text-slate-200 flex items-center gap-2">
                    <svg class="w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    Extrato de Movimentações
                </h3>
            </div>
            
            <div class="p-0">
                @if($transactions->count() > 0)
                    <div class="divide-y divide-black/5 dark:divide-white/5">
                        @foreach($transactions as $transaction)
                            <div class="px-6 py-4 flex items-center justify-between hover:bg-black/5 dark:hover:bg-white/5 transition-colors group/row">
                                <div class="flex items-center gap-4">
                                    <div class="p-3 rounded-xl {{ $transaction->amount < 0 || $transaction->type === 'expense' ? 'bg-red-500/10 text-red-500' : 'bg-emerald-500/10 text-emerald-500' }}">
                                        @if($transaction->amount < 0 || $transaction->type === 'expense')
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" /></svg>
                                        @else
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" /></svg>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-900 dark:text-white">{{ $transaction->description }}</p>
                                        <p class="text-xs font-medium text-slate-500">{{ $transaction->date->format('d/m/Y') }} • 
                                            @if($transaction->category)
                                                {{ $transaction->category->name }}
                                            @elseif($transaction->to_account_id)
                                                Transferência para {{ $transaction->toAccount->name ?? 'Conta' }}
                                            @else
                                                Movimentação manual
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-lg font-bold {{ $transaction->amount < 0 || $transaction->type === 'expense' ? 'text-red-500 dark:text-red-400' : 'text-emerald-500 dark:text-emerald-400' }}">
                                        {{ $transaction->amount < 0 || $transaction->type === 'expense' ? '- ' : '+ ' }}R$ {{ number_format(abs($transaction->amount), 2, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="py-16 text-center">
                        <div class="w-16 h-16 bg-slate-100 dark:bg-white/5 rounded-full flex items-center justify-center mx-auto mb-4 border border-black/5 dark:border-white/10">
                            <svg class="w-8 h-8 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        </div>
                        <h4 class="text-lg font-bold text-slate-800 dark:text-slate-200 mb-2">Sem movimentações</h4>
                        <p class="text-slate-500 font-medium max-w-sm mx-auto">Esta conta ainda não possui entradas ou saídas registradas.</p>
                    </div>
                @endif
            </div>

            @if($transactions->hasPages())
                <div class="p-4 border-t border-black/5 dark:border-white/10 bg-black/5 dark:bg-white/5">
                    {{ $transactions->links() }}
                </div>
            @endif
        </div>
    </div>
    
    <livewire:account-import-form :account-id="$account->id" wire:key="import-modal-{{ $account->id }}" />
    <livewire:quick-transaction-form :account-id="$account->id" wire:key="quick-form-{{ $account->id }}" />
</div>
