<div>
    <div class="space-y-8">
        <header class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-indigo-500/10 rounded-2xl border border-indigo-500/20 shadow-[0_0_20px_rgba(99,102,241,0.15)]">
                    <svg class="w-8 h-8 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white leading-none">Contas e Carteiras</h1>
                    <p class="mt-2 text-sm text-slate-400 font-medium">Controle seus saldos e gerencie suas instituições financeiras.</p>
                </div>
            </div>
            
            @if(!$showForm)
                <button 
                    wire:click="openForm"
                    class="glass-button-primary group">
                    <svg class="w-5 h-5 group-hover:rotate-90 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Nova Conta</span>
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
                <livewire:account-form :account-id="$editingAccountId" wire:key="account-form-{{ $editingAccountId ?? 'new' }}" />
            @else
                <livewire:account-list wire:key="account-list" />
            @endif
        </div>
    </div>
</div>
