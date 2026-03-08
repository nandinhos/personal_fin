<div>
    <div class="space-y-8">
        <header class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-indigo-500/10 rounded-2xl border border-indigo-500/20 shadow-[0_0_20px_rgba(99,102,241,0.15)]">
                    <svg class="w-8 h-8 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white leading-none">Movimentações</h1>
                    <p class="mt-2 text-sm text-slate-400 font-medium">Acompanhe seu fluxo de caixa e histórico financeiro.</p>
                </div>
            </div>
            
            @if(!$showForm)
                <button 
                    wire:click="openForm"
                    class="glass-button-primary group">
                    <svg class="w-5 h-5 group-hover:rotate-90 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Novo Lançamento</span>
                </button>
            @else
                <button 
                    wire:click="cancelForm"
                    class="px-6 py-2.5 text-sm font-bold rounded-xl transition-all duration-300 bg-slate-200 dark:bg-white/10 text-slate-600 dark:text-slate-300 hover:bg-slate-300 dark:hover:bg-white/20 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Voltar
                </button>
            @endif
        </header>

        <div>
            @if($showForm)
                <livewire:transaction-form :transaction-id="$editingTransactionId" wire:key="transaction-form-{{ $editingTransactionId ?? 'new' }}" />
            @else
                <livewire:transaction-list wire:key="transaction-list" />
            @endif
        </div>
    </div>
</div>
