<div>
    @if($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-slate-900/50 dark:bg-slate-900/80 backdrop-blur-sm transition-opacity">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-[2rem] shadow-[0_0_50px_rgba(0,0,0,0.1)] dark:bg-slate-800 dark:border dark:border-white/10 overflow-hidden">
                    
                    <!-- Decorative Background -->
                    <div class="absolute -right-20 -top-20 w-64 h-64 bg-sky-500 rounded-full blur-[80px] opacity-20 pointer-events-none"></div>

                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-6 border-b border-black/5 dark:border-white/10 relative z-10">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-sky-500/20 rounded-xl">
                                <svg class="w-6 h-6 text-sky-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                            </div>
                            <h3 class="text-xl font-bold text-slate-900 dark:text-white">
                                Lançamento Rápido
                            </h3>
                        </div>
                        <button type="button" wire:click="closeModal" class="text-slate-400 bg-transparent hover:bg-slate-200 hover:text-slate-900 rounded-xl text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-slate-700 dark:hover:text-white transition-colors">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    
                    <!-- Modal body -->
                    <div class="p-6 relative z-10">
                        <form wire:submit="save" class="space-y-4">
                            
                            {{-- Type selection (Income/Expense) --}}
                            <div class="flex rounded-xl shadow-sm bg-slate-100 p-1 dark:bg-slate-800/50" role="group">
                                <button type="button" wire:click="$set('type', 'expense')" class="flex-1 px-4 py-2 text-sm font-bold rounded-lg transition-colors {{ $type === 'expense' ? 'bg-white shadow-sm text-red-600 dark:bg-slate-700 dark:text-red-400' : 'text-slate-500 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white' }}">
                                    Despesa
                                </button>
                                <button type="button" wire:click="$set('type', 'income')" class="flex-1 px-4 py-2 text-sm font-bold rounded-lg transition-colors {{ $type === 'income' ? 'bg-white shadow-sm text-emerald-600 dark:bg-slate-700 dark:text-emerald-400' : 'text-slate-500 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white' }}">
                                    Receita
                                </button>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-2">
                                {{-- Valor --}}
                                <div>
                                    <label for="amount" class="block mb-2 text-sm font-bold text-slate-700 dark:text-slate-300">Valor (R$)</label>
                                    <input type="number" step="0.01" min="0.01" wire:model="amount" id="amount" class="bg-slate-50 border border-slate-300 text-slate-900 text-lg sm:text-sm rounded-xl focus:ring-sky-500 focus:border-sky-500 block w-full p-3 dark:bg-slate-900 dark:border-white/10 dark:placeholder-slate-400 dark:text-white" placeholder="0,00" required>
                                    @error('amount') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                                </div>

                                {{-- Data --}}
                                <div>
                                    <label for="date" class="block mb-2 text-sm font-bold text-slate-700 dark:text-slate-300">Data</label>
                                    <input type="date" wire:model="date" id="date" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-sky-500 focus:border-sky-500 block w-full p-3 dark:bg-slate-900 dark:border-white/10 dark:placeholder-slate-400 dark:text-white" required>
                                    @error('date') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            {{-- Descrição --}}
                            <div>
                                <label for="description" class="block mb-2 text-sm font-bold text-slate-700 dark:text-slate-300">Descrição</label>
                                <input type="text" wire:model="description" id="description" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-sky-500 focus:border-sky-500 block w-full p-3 dark:bg-slate-900 dark:border-white/10 dark:placeholder-slate-400 dark:text-white" placeholder="Ex: Conta de Luz" required>
                                @error('description') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            {{-- Categoria --}}
                            <div>
                                <label for="category_id" class="block mb-2 text-sm font-bold text-slate-700 dark:text-slate-300">Categoria (opcional)</label>
                                <select wire:model="category_id" id="category_id" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-sky-500 focus:border-sky-500 block w-full p-3 dark:bg-slate-900 dark:border-white/10 dark:placeholder-slate-400 dark:text-white">
                                    <option value="">Sem categoria</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <button type="submit" class="w-full text-white bg-sky-600 hover:bg-sky-500 focus:ring-4 focus:outline-none focus:ring-sky-300 font-bold rounded-xl text-sm px-5 py-3 mt-4 text-center dark:focus:ring-sky-800 transition-colors shadow-lg shadow-sky-500/30">
                                <span wire:loading.remove wire:target="save">Salvar Lançamento</span>
                                <span wire:loading wire:target="save">Salvando...</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
