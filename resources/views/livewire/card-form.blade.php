<div class="glass-panel p-8 rounded-[2.5rem] mt-4 relative overflow-hidden">
    <div class="flex items-center gap-4 mb-8">
        <div class="p-3 bg-emerald-500/20 rounded-2xl border border-emerald-500/30 shadow-[0_0_15px_rgba(16,185,129,0.2)]">
            <svg class="w-6 h-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
            </svg>
        </div>
        <h2 class="text-2xl font-black text-slate-900 dark:text-white leading-none tracking-tight">
            {{ $cardId ? 'Atualizar Cartão' : 'Cadastrar Novo Cartão' }}
        </h2>
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
            <!-- Lado Esquerdo: Campos -->
            <div class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Nome do Cartão</label>
                        <input type="text" wire:model="name" class="mt-1 block w-full bg-slate-50 dark:bg-slate-900/50 border-slate-200 dark:border-white/10 rounded-xl text-slate-900 dark:text-white focus:ring-emerald-500 focus:border-emerald-500 shadow-sm" placeholder="Ex: Nubank Platinum">
                        @error('name') <span class="text-sm text-red-500 dark:text-red-400 mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Bandeira</label>
                        <select wire:model="brand" class="mt-1 block w-full bg-slate-50 dark:bg-slate-900/50 border-slate-200 dark:border-white/10 rounded-xl text-slate-900 dark:text-white focus:ring-emerald-500 focus:border-emerald-500 shadow-sm">
                            <option value="Visa">Visa</option>
                            <option value="Mastercard">Mastercard</option>
                            <option value="Elo">Elo</option>
                            <option value="Amex">Amex</option>
                            <option value="Outra">Outra</option>
                        </select>
                        @error('brand') <span class="text-sm text-red-500 dark:text-red-400 mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Tipo</label>
                        <select wire:model="type" class="mt-1 block w-full bg-slate-50 dark:bg-slate-900/50 border-slate-200 dark:border-white/10 rounded-xl text-slate-900 dark:text-white focus:ring-emerald-500 focus:border-emerald-500 shadow-sm">
                            <option value="credit">Crédito</option>
                            <option value="debit">Débito</option>
                        </select>
                        @error('type') <span class="text-sm text-red-500 dark:text-red-400 mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Últimos 4 Dígitos</label>
                        <input type="text" wire:model="last_four_digits" maxlength="4" class="mt-1 block w-full bg-slate-50 dark:bg-slate-900/50 border-slate-200 dark:border-white/10 rounded-xl text-slate-900 dark:text-white focus:ring-emerald-500 focus:border-emerald-500 shadow-sm text-center tracking-widest font-mono" placeholder="0000">
                        @error('last_four_digits') <span class="text-sm text-red-500 dark:text-red-400 mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Limite Total (R$)</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold">R$</span>
                        <input type="number" step="0.01" wire:model="limit" class="mt-1 block w-full bg-slate-50 dark:bg-slate-900/50 border-slate-200 dark:border-white/10 rounded-xl text-slate-900 dark:text-white focus:ring-emerald-500 focus:border-emerald-500 shadow-sm pl-12 text-xl font-black tracking-tight">
                    </div>
                    @error('limit') <span class="text-sm text-red-500 dark:text-red-400 mt-1 block font-medium">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Fechamento (Dia)</label>
                        <input type="number" min="1" max="31" wire:model="closing_day" class="mt-1 block w-full bg-slate-50 dark:bg-slate-900/50 border-slate-200 dark:border-white/10 rounded-xl text-slate-900 dark:text-white focus:ring-emerald-500 focus:border-emerald-500 shadow-sm text-center font-bold">
                        @error('closing_day') <span class="text-sm text-red-500 dark:text-red-400 mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Vencimento (Dia)</label>
                        <input type="number" min="1" max="31" wire:model="due_day" class="mt-1 block w-full bg-slate-50 dark:bg-slate-900/50 border-slate-200 dark:border-white/10 rounded-xl text-slate-900 dark:text-white focus:ring-emerald-500 focus:border-emerald-500 shadow-sm text-center font-bold">
                        @error('due_day') <span class="text-sm text-red-500 dark:text-red-400 mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Cor do Cartão</label>
                    <div class="flex items-center gap-4 mt-1">
                        <input type="color" wire:model="color" class="w-12 h-12 rounded-xl border-0 cursor-pointer bg-black/5 dark:bg-white/5 p-1 ring-1 ring-black/10 dark:ring-white/10 shadow-sm">
                        <input type="text" wire:model="color" class="flex-1 bg-slate-50 dark:bg-slate-900/50 border-slate-200 dark:border-white/10 rounded-xl text-slate-900 dark:text-white focus:ring-emerald-500 focus:border-emerald-500 shadow-sm" placeholder="#10b981" />
                    </div>
                    @error('color') <span class="text-sm text-red-500 dark:text-red-400 mt-1 block font-medium">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Lado Direito: Preview -->
            <div class="flex flex-col justify-center items-center space-y-6">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.3em]">Pré-visualização Digital</p>
                
                <div class="relative w-full max-w-[380px] h-56 rounded-[2rem] p-8 text-white shadow-2xl transition-all duration-700 group hover:scale-[1.02]" 
                     style="background: linear-gradient(135deg, {{ $color }} 0%, {{ $color }}dd 100%);">
                    
                    <div class="absolute inset-0 opacity-20 overflow-hidden rounded-[2rem]">
                        <div class="absolute -right-10 -top-10 w-40 h-40 bg-white rounded-full blur-3xl"></div>
                        <div class="absolute -left-10 -bottom-10 w-40 h-40 bg-black rounded-full blur-3xl"></div>
                    </div>

                    <div class="relative h-full flex flex-col justify-between">
                        <div class="flex justify-between items-start">
                            <div class="flex flex-col">
                                <span class="text-[10px] font-bold uppercase tracking-widest opacity-60">Bandeira</span>
                                <span class="text-2xl font-black italic tracking-tighter">{{ $brand }}</span>
                            </div>
                            <div class="w-12 h-8 bg-yellow-400/80 rounded-lg shadow-inner flex items-center justify-center">
                                <div class="w-8 h-px bg-black/10"></div>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="flex gap-4 text-xl font-mono tracking-[0.2em] text-white/90">
                                <span>****</span> <span>****</span> <span>****</span> <span>{{ $last_four_digits ?: '0000' }}</span>
                            </div>
                            
                            <div class="flex justify-between items-end">
                                <div>
                                    <p class="text-[10px] uppercase font-bold opacity-60 tracking-wider">Limite Total</p>
                                    <p class="text-xl font-black tracking-tight text-white">R$ {{ number_format((float)($limit ?: 0), 2, ',', '.') }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-[10px] uppercase font-bold opacity-60 tracking-wider">Vencimento</p>
                                    <p class="text-sm font-bold">DIA {{ str_pad($due_day ?: 0, 2, '0', STR_PAD_LEFT) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center space-y-1">
                    <p class="text-sm font-bold text-slate-900 dark:text-white">{{ $name ?: 'Nome do Cartão' }}</p>
                    <p class="text-xs text-slate-500 font-medium capitalize">{{ $type === 'credit' ? 'Cartão de Crédito' : 'Cartão de Débito' }}</p>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-4 pt-8 border-t border-slate-200 dark:border-white/10">
            <button type="button" wire:click="$dispatch('close-card-form')" class="px-8 py-3 text-sm font-bold rounded-xl transition-all duration-300 bg-slate-100 dark:bg-white/5 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-white/10">
                Cancelar
            </button>
            <button type="submit" class="glass-button-primary !from-emerald-600 !to-emerald-500 !shadow-emerald-500/20">
                <span wire:loading.remove wire:target="save">{{ $cardId ? 'Salvar Alterações' : 'Confirmar Cadastro' }}</span>
                <span wire:loading wire:target="save">Processando...</span>
            </button>
        </div>
    </form>
    
    {{-- Decorative gradient background --}}
    <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-emerald-500 rounded-full blur-[100px] opacity-10 pointer-events-none"></div>
</div>
