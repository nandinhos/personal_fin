<div>
    <div class="space-y-8">
        <header class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-cyan-500/10 rounded-2xl border border-cyan-500/20 shadow-[0_0_20px_rgba(6,182,212,0.15)]">
                    <svg class="w-8 h-8 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white leading-none">Categorias</h1>
                    <p class="mt-2 text-sm text-slate-400 font-medium">Organize suas finanças com precisão cirúrgica.</p>
                </div>
            </div>
            <button 
                wire:click="openCategoryModal()"
                class="glass-button-primary group">
                <svg class="w-5 h-5 group-hover:rotate-90 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>Nova Categoria</span>
            </button>
        </header>

        <div class="flex gap-4 p-1 bg-black/5 dark:bg-white/5 backdrop-blur-md rounded-2xl border border-black/10 dark:border-white/10 w-fit">
            <button 
                wire:click="switchTab('expense')"
                class="px-6 py-2.5 text-sm font-bold rounded-xl transition-all duration-300 {{ $activeTab === 'expense' ? 'bg-cyan-500 text-white shadow-[0_0_15px_rgba(6,182,212,0.4)]' : 'text-slate-500 hover:text-slate-900 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }}">
                Despesas
            </button>
            <button 
                wire:click="switchTab('income')"
                class="px-6 py-2.5 text-sm font-bold rounded-xl transition-all duration-300 {{ $activeTab === 'income' ? 'bg-cyan-500 text-white shadow-[0_0_15px_rgba(6,182,212,0.4)]' : 'text-slate-500 hover:text-slate-900 dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/5' }}">
                Receitas
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($filteredCategories as $category)
                <div class="glass-card-premium group/card">
                    <div class="p-5">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl flex items-center justify-center border transition-transform duration-500 group-hover/card:scale-110" 
                                     style="background-color: {{ $category['color'] ?? '#05b7d6' }}15; border-color: {{ $category['color'] ?? '#05b7d6' }}30">
                                    @if($category['icon'])
                                        {!! \App\Helpers\IconHelper::render($category['icon'], $category['color'] ?? null) !!}
                                    @else
                                        <svg class="w-6 h-6 shadow-[0_0_10px_currentColor]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="color: {{ $category['color'] ?? '#05b7d6' }}">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                                        </svg>
                                    @endif
                                </div>
                                <div>
                                    <h3 class="font-bold text-slate-900 dark:text-white tracking-tight">{{ $category['name'] }}</h3>
                                    <p class="text-[10px] uppercase font-bold tracking-widest text-slate-500">{{ count($category['subcategories'] ?? []) }} Subcategorias</p>
                                </div>
                            </div>
                            
                            <div class="flex opacity-0 group-hover/card:opacity-100 transition-opacity duration-300">
                                <button wire:click="openSubcategoryModal({{ json_encode($category) }})" class="p-2 text-slate-400 hover:text-cyan-400 transition-colors" title="Nova Sub">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                                </button>
                                <button wire:click="openCategoryModal({{ json_encode($category) }})" class="p-2 text-slate-400 hover:text-cyan-400 transition-colors" title="Editar">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                </button>
                                <button wire:click="confirmDelete('category', {{ json_encode($category) }})" class="p-2 text-slate-400 hover:text-red-400 transition-colors" title="Excluir">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </div>
                        </div>

                        @if(!empty($category['subcategories']))
                            <div class="space-y-2 mt-4">
                                @foreach(array_slice($category['subcategories'], 0, 3) as $subcategory)
                                    <div class="flex items-center justify-between px-3 py-2 bg-black/5 dark:bg-white/5 rounded-xl border border-black/5 dark:border-white/5 group/sub">
                                        <span class="text-xs text-slate-700 dark:text-slate-300 font-medium">{{ $subcategory['name'] }}</span>
                                        <div class="flex opacity-0 group-hover/sub:opacity-100 transition-opacity">
                                            <button wire:click="openSubcategoryModal({{ json_encode($category) }}, {{ json_encode($subcategory) }})" class="p-1 text-slate-500 hover:text-cyan-400">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                            </button>
                                            <button wire:click="confirmDelete('subcategory', {{ json_encode($subcategory) }})" class="p-1 text-slate-500 hover:text-red-400">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                                @if(count($category['subcategories']) > 3)
                                    <p class="text-[10px] text-center text-slate-500 font-bold uppercase tracking-widest pt-1">+ {{ count($category['subcategories']) - 3 }} outras</p>
                                @endif
                            </div>
                        @else
                            <div class="mt-4 p-4 border border-dashed border-black/10 dark:border-white/10 rounded-2xl text-center">
                                <p class="text-xs text-slate-500 font-medium">Sem subcategorias</p>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 text-center glass-panel rounded-3xl">
                    <div class="w-20 h-20 bg-black/5 dark:bg-white/5 rounded-full flex items-center justify-center mx-auto mb-4 border border-black/10 dark:border-white/10">
                        <svg class="w-10 h-10 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                    </div>
                    <p class="text-slate-400 font-medium">Nenhuma categoria encontrada para este filtro.</p>
                    <button 
                        wire:click="openCategoryModal()"
                        class="mt-6 text-cyan-400 font-bold hover:text-cyan-300 transition-colors flex items-center gap-2 mx-auto uppercase text-xs tracking-widest">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                        Criar primeira categoria
                    </button>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Modal Categoria --}}
    @if($showCategoryModal)
        <div class="fixed inset-0 z-[60] flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/80 backdrop-blur-xl" wire:click="closeCategoryModal"></div>
            <div class="relative glass-panel rounded-[2.5rem] w-full max-w-md p-8 shadow-[0_0_50px_rgba(0,0,0,0.5)] border-white/20">
                <div class="flex items-center gap-4 mb-8">
                    <div class="p-3 bg-cyan-500/20 rounded-2xl border border-cyan-500/30">
                        <svg class="w-6 h-6 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-black text-slate-900 dark:text-white leading-none tracking-tight">
                        {{ $editingCategory ? 'Editar Categoria' : 'Nova Categoria' }}
                    </h2>
                </div>
                
                <form wire:submit.prevent="saveCategory" class="space-y-6">
                    <div>
                        <x-input-label for="cat_name" value="Nome da Categoria" />
                        <x-text-input id="cat_name" type="text" wire:model="categoryForm.name" class="mt-1 block w-full" placeholder="Ex: Alimentação" />
                        @error('categoryForm.name') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <x-input-label for="cat_type" value="Tipo de Movimentação" />
                        <select wire:model="categoryForm.type" class="mt-1 block w-full bg-slate-50 dark:bg-slate-900/50 border-slate-200 dark:border-white/10 rounded-xl text-slate-900 dark:text-white focus:ring-cyan-500 focus:border-cyan-500">
                            <option value="expense">Despesa (Gasto)</option>
                            <option value="income">Receita (Ganho)</option>
                        </select>
                    </div>

                    <div>
                        <x-input-label for="cat_color" value="Cor de Identificação" />
                        <div class="flex items-center gap-4 mt-1">
                            <input type="color" wire:model="categoryForm.color" class="w-12 h-12 rounded-xl border-0 cursor-pointer bg-white/5 p-1 ring-1 ring-white/10">
                            <x-text-input id="cat_color_text" type="text" wire:model="categoryForm.color" class="flex-1" placeholder="#05b7d6" />
                        </div>
                    </div>

                    <div class="flex gap-4 pt-4">
                        <x-secondary-button wire:click="closeCategoryModal" class="flex-1">Cancelar</x-secondary-button>
                        <x-primary-button type="submit" class="flex-1">
                            {{ $editingCategory ? 'Salvar Alterações' : 'Criar Categoria' }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- Modal Subcategoria --}}
    @if($showSubcategoryModal)
        <div class="fixed inset-0 z-[60] flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/80 backdrop-blur-xl" wire:click="closeSubcategoryModal"></div>
            <div class="relative glass-panel rounded-[2.5rem] w-full max-w-md p-8 shadow-[0_0_50px_rgba(0,0,0,0.5)] border-white/20">
                <div class="flex items-center gap-4 mb-2">
                    <div class="p-3 bg-cyan-500/20 rounded-2xl border border-cyan-500/30">
                        <svg class="w-6 h-6 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-black text-slate-900 dark:text-white leading-none tracking-tight">
                        {{ $editingSubcategory ? 'Editar Sub' : 'Nova Sub' }}
                    </h2>
                </div>
                <p class="text-xs text-slate-500 font-bold uppercase tracking-widest mb-8">
                    Vinculada a: <span class="text-cyan-400">{{ $parentCategory['name'] ?? '' }}</span>
                </p>
                
                <form wire:submit.prevent="saveSubcategory" class="space-y-6">
                    <div>
                        <x-input-label for="sub_name" value="Nome da Subcategoria" />
                        <x-text-input id="sub_name" type="text" wire:model="subcategoryForm.name" class="mt-1 block w-full" placeholder="Ex: Supermercado" />
                        @error('subcategoryForm.name') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <x-input-label for="sub_color" value="Cor (Opcional)" />
                        <div class="flex items-center gap-4 mt-1">
                            <input type="color" wire:model="subcategoryForm.color" class="w-12 h-12 rounded-xl border-0 cursor-pointer bg-white/5 p-1 ring-1 ring-white/10">
                            <x-text-input id="sub_color_text" type="text" wire:model="subcategoryForm.color" class="flex-1" placeholder="#05b7d6" />
                        </div>
                    </div>

                    <div class="flex gap-4 pt-4">
                        <x-secondary-button wire:click="closeSubcategoryModal" class="flex-1">Cancelar</x-secondary-button>
                        <x-primary-button type="submit" class="flex-1">
                            {{ $editingSubcategory ? 'Salvar' : 'Criar' }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>

