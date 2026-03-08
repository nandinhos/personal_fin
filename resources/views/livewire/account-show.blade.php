<div>
    <div class="space-y-8">
        {{-- Botão Voltar --}}
        <div>
            <a href="{{ route('accounts.index') }}" wire:navigate class="group inline-flex items-center gap-2 text-slate-500 hover:text-slate-900 dark:hover:text-white transition-all duration-300">
                <div class="w-8 h-8 rounded-lg bg-black/5 dark:bg-white/5 flex items-center justify-center group-hover:bg-black/10 dark:group-hover:bg-white/10 transition-colors">
                    <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                    </svg>
                </div>
                <span class="text-xs font-black uppercase tracking-[0.2em]">Voltar para Contas</span>
            </a>
        </div>

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
                        <div class="mt-4 pt-4 border-t border-black/5 dark:border-white/10 flex flex-wrap gap-8">
                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1">Saldo Inicial</p>
                                <p class="text-xl font-bold text-slate-500 dark:text-slate-400 tracking-tight">
                                    {{ 'R$ ' . number_format($account->initial_balance, 2, ',', '.') }}
                                </p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1">Saldo Atual</p>
                                <p class="text-3xl font-black {{ $account->balance < 0 ? 'text-red-500 dark:text-red-400' : 'text-emerald-600 dark:text-emerald-400' }} tracking-tight">
                                    {{ 'R$ ' . number_format($account->balance, 2, ',', '.') }}
                                </p>
                            </div>
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
                
                @if(count($selectedTransactions) > 0)
                    <button wire:click="deleteSelectedTransactions" onclick="confirm('Tem certeza que deseja excluir os registros selecionados?') || event.stopImmediatePropagation()" class="text-xs font-bold bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg flex items-center gap-1 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                        Excluir Selecionados ({{ count($selectedTransactions) }})
                    </button>
                @endif
            </div>
            
            <div class="p-0">
                @if($transactions->count() > 0)
                    {{-- Cabeçalho da Tabela (Fica visível apenas em telas MD+) --}}
                    <div class="hidden md:flex bg-slate-50 dark:bg-slate-800/50 px-6 py-3 border-b border-black/5 dark:border-white/5 items-center text-xs font-bold text-slate-500 uppercase tracking-wider">
                        <div class="w-10">
                            <input type="checkbox" wire:model.live="selectAll" class="w-4 h-4 text-indigo-600 bg-white border-slate-300 rounded focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:ring-offset-slate-900 focus:ring-2 dark:bg-slate-700 dark:border-slate-600 cursor-pointer">
                        </div>
                        <div class="flex-1">Data / Histórico</div>
                        <div class="w-32 text-right">Valor</div>
                        <div class="w-24 text-right">Ações</div>
                    </div>

                    <div class="divide-y divide-black/5 dark:divide-white/5">
                        @foreach($transactions as $transaction)
                            <div class="px-4 md:px-6 py-4 flex flex-col md:flex-row md:items-center justify-between hover:bg-black/5 dark:hover:bg-white/5 transition-colors group/row gap-4 md:gap-0">
                                
                                {{-- Esquerda: Checkbox + Ícone + Info --}}
                                <div class="flex items-start md:items-center gap-4 flex-1 min-w-0">
                                    <div class="w-6 shrink-0 mt-1 md:mt-0">
                                        <input type="checkbox" value="{{ $transaction->id }}" wire:model.live="selectedTransactions" class="w-4 h-4 text-indigo-600 bg-white border-slate-300 rounded focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:ring-offset-slate-900 focus:ring-2 dark:bg-slate-700 dark:border-slate-600 cursor-pointer">
                                    </div>
                                    
                                    <div class="p-2 md:p-3 rounded-xl shrink-0 {{ $transaction->amount < 0 || $transaction->type === 'expense' ? 'bg-red-500/10 text-red-500' : 'bg-emerald-500/10 text-emerald-500' }}">
                                        @if($transaction->amount < 0 || $transaction->type === 'expense')
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" /></svg>
                                        @else
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" /></svg>
                                        @endif
                                    </div>

                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between md:justify-start gap-2">
                                            <p class="text-sm font-bold text-slate-900 dark:text-white truncate">
                                                {{ $transaction->description }}
                                            </p>
                                            @if($transaction->is_imported)
                                                <span class="inline-flex items-center px-2 py-0.5 text-[9px] font-bold text-slate-500 bg-slate-100 dark:bg-slate-800 rounded-md uppercase tracking-wider">Importado</span>
                                            @endif
                                        </div>
                                        <p class="text-[11px] md:text-xs font-medium text-slate-500 truncate mt-0.5">
                                            {{ $transaction->date->format('d/m/Y') }} • 
                                            <span class="text-slate-400">
                                                @if($transaction->category)
                                                    {{ $transaction->category->name }}
                                                @elseif($transaction->to_account_id)
                                                    Transferência para {{ $transaction->toAccount->name ?? 'Conta' }}
                                                @else
                                                    Sem Categoria
                                                @endif
                                            </span>
                                        </p>
                                    </div>
                                </div>

                                {{-- Direita: Valor e Ações (Empilhado no mobile, Lado a lado no MD+) --}}
                                <div class="flex items-center justify-between md:justify-end gap-6 md:gap-4 pl-10 md:pl-0">
                                    <div class="text-right">
                                        <p class="text-base md:text-sm font-black {{ $transaction->amount < 0 || $transaction->type === 'expense' ? 'text-red-500 dark:text-red-400' : 'text-emerald-500 dark:text-emerald-400' }} tracking-tight">
                                            {{ $transaction->amount < 0 || $transaction->type === 'expense' ? '- ' : '+ ' }}R$ {{ number_format(abs($transaction->amount), 2, ',', '.') }}
                                        </p>
                                    </div>

                                    <div class="flex justify-end gap-1 md:opacity-0 md:group-hover/row:opacity-100 transition-opacity">
                                        <button wire:click="editTransaction({{ $transaction->id }})" class="p-2 md:p-1.5 text-slate-400 hover:text-indigo-600 bg-black/5 dark:bg-white/5 md:bg-transparent rounded-lg transition-colors" title="Editar">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                        </button>
                                        <button wire:click="deleteTransaction({{ $transaction->id }})" onclick="confirm('Tem certeza que deseja excluir?') || event.stopImmediatePropagation()" class="p-2 md:p-1.5 text-slate-400 hover:text-red-600 bg-black/5 dark:bg-white/5 md:bg-transparent rounded-lg transition-colors" title="Excluir">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </div>
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
        @if($editingTransactionId)
        <div class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-slate-900/50 dark:bg-slate-900/80 backdrop-blur-sm transition-opacity">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-[2rem] shadow-[0_0_50px_rgba(0,0,0,0.1)] dark:bg-slate-800 dark:border dark:border-white/10 overflow-hidden">
                    
                    <!-- Decorative Background -->
                    <div class="absolute -right-20 -top-20 w-64 h-64 bg-indigo-500 rounded-full blur-[80px] opacity-20 pointer-events-none"></div>

                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-6 border-b border-black/5 dark:border-white/10 relative z-10">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-indigo-500/20 rounded-xl">
                                <svg class="w-6 h-6 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                            </div>
                            <h3 class="text-xl font-bold text-slate-900 dark:text-white">
                                Editar Movimentação
                            </h3>
                        </div>
                        <button type="button" wire:click="cancelEditTransaction" class="text-slate-400 bg-transparent hover:bg-slate-200 hover:text-slate-900 rounded-xl text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-slate-700 dark:hover:text-white transition-colors">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                        </button>
                    </div>
                    
                    <!-- Modal body -->
                    <div class="p-6 relative z-10">
                        <form wire:submit.prevent="updateTransaction" class="space-y-4">
                            
                            @if($editIsImported)
                                <div class="p-3 mb-4 text-sm text-amber-700 bg-amber-500/10 border border-amber-500/20 rounded-xl dark:text-amber-400 flex items-start gap-2">
                                    <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    <p>Este é um lançamento importado automaticamente via extrato. Por segurança apenas a edição da descrição e categoria é permitida.</p>
                                </div>
                            @endif

                            <div>
                                <label class="block mb-2 text-sm font-bold text-slate-700 dark:text-slate-300">Descrição/Histórico</label>
                                <input type="text" wire:model="editDescription" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 dark:bg-slate-900 dark:border-slate-600 dark:placeholder-slate-400 dark:text-white" required>
                                @error('editDescription') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block mb-2 text-sm font-bold text-slate-700 dark:text-slate-300">Categoria</label>
                                <select wire:model="editCategoryId" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 dark:bg-slate-900 dark:border-slate-600 dark:placeholder-slate-400 dark:text-white">
                                    <option value="">Sem categoria</option>
                                    @foreach($categories as $category)
                                        @if($category->type === $editType || empty($editType))
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('editCategoryId') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            @if(!$editIsImported)
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block mb-2 text-sm font-bold text-slate-700 dark:text-slate-300">Tipo</label>
                                        <select wire:model.live="editType" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 dark:bg-slate-900 dark:border-slate-600 dark:placeholder-slate-400 dark:text-white">
                                            <option value="expense">Despesa / Saída</option>
                                            <option value="income">Receita / Entrada</option>
                                        </select>
                                        @error('editType') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block mb-2 text-sm font-bold text-slate-700 dark:text-slate-300">Data</label>
                                        <input type="date" wire:model="editDate" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 dark:bg-slate-900 dark:border-slate-600 dark:placeholder-slate-400 dark:text-white" required>
                                        @error('editDate') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-slate-700 dark:text-slate-300">Valor (R$)</label>
                                    <input type="number" step="0.01" min="0.01" wire:model="editAmount" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 dark:bg-slate-900 dark:border-slate-600 dark:placeholder-slate-400 dark:text-white" required>
                                    @error('editAmount') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                                </div>
                            @endif

                            <div class="flex flex-col sm:flex-row items-center gap-3 mt-6 pt-4 border-t border-black/5 dark:border-white/10">
                                <button type="button" wire:click="cancelEditTransaction" class="w-full sm:w-1/2 py-2.5 px-5 text-sm font-bold text-slate-900 focus:outline-none bg-white rounded-xl border border-slate-200 hover:bg-slate-100 hover:text-indigo-700 dark:bg-slate-800 dark:text-slate-400 dark:border-slate-600 dark:hover:text-white dark:hover:bg-slate-700">
                                    Cancelar
                                </button>
                                <button type="submit" class="w-full sm:w-1/2 text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-bold rounded-xl text-sm px-5 py-2.5 text-center dark:bg-indigo-600 dark:hover:bg-indigo-500 disabled:opacity-50">
                                    Salvar Alterações
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
    
    <livewire:account-import-form :account-id="$account->id" wire:key="import-modal-{{ $account->id }}" />
    <livewire:quick-transaction-form :account-id="$account->id" wire:key="quick-form-{{ $account->id }}" />
</div>
