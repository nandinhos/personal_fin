@use('Illuminate\Support\Facades\Auth')
<div class="glass-panel p-8 rounded-[2.5rem] mt-4 relative overflow-hidden">
    <div class="flex items-center gap-4 mb-8">
        <div class="p-3 bg-indigo-500/20 rounded-2xl border border-indigo-500/30 shadow-[0_0_15px_rgba(99,102,241,0.2)]">
            <svg class="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
        </div>
        <h2 class="text-2xl font-black text-slate-900 dark:text-white leading-none tracking-tight">
            {{ $accountId ? 'Atualizar Conta' : 'Criar Nova Conta' }}
        </h2>
    </div>

    <form wire:submit="save" class="space-y-6 max-w-2xl relative z-10">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="name" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Nome da Conta / Carteira</label>
                <input type="text" id="name" wire:model="name" class="mt-1 block w-full bg-slate-50 dark:bg-slate-900/50 border-slate-200 dark:border-white/10 rounded-xl text-slate-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm" placeholder="Ex: Nubank, Carteira..." required>
                @error('name') <span class="text-sm text-red-500 dark:text-red-400 mt-1 block font-medium">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="type" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Tipo de Instituição</label>
                <select id="type" wire:model="type" class="mt-1 block w-full bg-slate-50 dark:bg-slate-900/50 border-slate-200 dark:border-white/10 rounded-xl text-slate-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
                    <option value="checking">Conta Corrente</option>
                    <option value="savings">Poupança</option>
                    <option value="investment">Investimento</option>
                    <option value="cash">Carteira (Dinheiro Físico)</option>
                    <option value="other">Outros</option>
                </select>
                @error('type') <span class="text-sm text-red-500 dark:text-red-400 mt-1 block font-medium">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="initial_balance" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Saldo Inicial (R$)</label>
                <input type="number" step="0.01" id="initial_balance" wire:model.live="initial_balance" class="mt-1 block w-full bg-slate-50 dark:bg-slate-900/50 border-slate-200 dark:border-white/10 rounded-xl text-slate-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm" required>
                @error('initial_balance') <span class="text-sm text-red-500 dark:text-red-400 mt-1 block font-medium">{{ $message }}</span> @enderror
                <p class="text-xs text-slate-500 mt-1">O valor que a conta possuía no momento do cadastro.</p>
            </div>

            @if($accountId)
            <div>
                <div class="flex items-center justify-between mb-2">
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 opacity-60">Saldo Atual (Lançamentos p/ hoje)</label>
                    <button type="button" wire:click="recalculate" class="text-[10px] uppercase font-bold text-indigo-500 hover:text-indigo-400 flex items-center gap-1 transition-colors" title="Recalcular saldo com base nas transações">
                        <svg wire:loading.class="animate-spin" wire:target="recalculate" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                        Sincronizar
                    </button>
                </div>
                <div class="mt-1 flex items-center h-[42px] px-4 bg-slate-100 dark:bg-slate-800/50 border border-transparent rounded-xl text-slate-500 dark:text-slate-400 font-mono relative overflow-hidden">
                    <span wire:loading.remove wire:target="recalculate">R$ {{ number_format($balance, 2, ',', '.') }}</span>
                    <span wire:loading wire:target="recalculate" class="text-xs italic">Calculando...</span>
                </div>
                <p class="text-[10px] text-slate-400 mt-1">Calculado automaticamente com base no Saldo Inicial + Movimentações.</p>
            </div>
            @endif
        </div>

        <div>
            <label for="color" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Cor de Identificação</label>
            <div class="flex items-center gap-4 mt-1">
                <input type="color" id="color" wire:model="color" class="w-12 h-12 rounded-xl border-0 cursor-pointer bg-black/5 dark:bg-white/5 p-1 ring-1 ring-black/10 dark:ring-white/10 shadow-sm">
                <input type="text" wire:model="color" class="flex-1 bg-slate-50 dark:bg-slate-900/50 border-slate-200 dark:border-white/10 rounded-xl text-slate-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm" placeholder="#6366f1" />
            </div>
            @error('color') <span class="text-sm text-red-500 dark:text-red-400 mt-1 block font-medium">{{ $message }}</span> @enderror
        </div>

        <div class="flex items-center justify-end gap-4 pt-6 border-t border-slate-200 dark:border-white/10">
            <button type="button" wire:click="$dispatch('close-account-form')" class="px-6 py-3 text-sm font-bold rounded-xl transition-all duration-300 bg-slate-100 dark:bg-white/5 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-white/10">
                Cancelar
            </button>
            <button type="submit" class="glass-button-primary">
                <span wire:loading.remove wire:target="save">{{ $accountId ? 'Salvar Alterações' : 'Criar Conta' }}</span>
                <span wire:loading wire:target="save">Salvando...</span>
            </button>
        </div>
    </form>
    
    {{-- Decorative gradient background --}}
    <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-indigo-500 rounded-full blur-[100px] opacity-10 pointer-events-none"></div>
</div>
