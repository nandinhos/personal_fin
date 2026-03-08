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

        <div>
            <label for="balance" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Saldo Atual Inicial (R$)</label>
            <input type="number" step="0.01" id="balance" wire:model="balance" class="mt-1 block w-full bg-slate-50 dark:bg-slate-900/50 border-slate-200 dark:border-white/10 rounded-xl text-slate-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm" required>
            @error('balance') <span class="text-sm text-red-500 dark:text-red-400 mt-1 block font-medium">{{ $message }}</span> @enderror
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
