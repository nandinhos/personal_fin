<div>
    <div class="space-y-6">
        <header class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold tracking-tight text-white">Categorias</h1>
                <p class="mt-2 text-sm text-slate-400">Gerencie suas categorias e subcategorias.</p>
            </div>
            <button 
                wire:click="openCategoryModal()"
                class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl transition-colors inline-flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Nova Categoria
            </button>
        </header>

        <div class="flex gap-2 border-b border-slate-700">
            <button 
                wire:click="switchTab('expense')"
                class="px-4 py-3 text-sm font-medium transition-colors border-b-2 {{ $activeTab === 'expense' ? 'border-indigo-500 text-indigo-400' : 'border-transparent text-slate-400 hover:text-white' }}">
                Despesas
            </button>
            <button 
                wire:click="switchTab('income')"
                class="px-4 py-3 text-sm font-medium transition-colors border-b-2 {{ $activeTab === 'income' ? 'border-indigo-500 text-indigo-400' : 'border-transparent text-slate-400 hover:text-white' }}">
                Receitas
            </button>
        </div>

        <div class="space-y-4">
            @forelse($filteredCategories as $category)
                <div class="border bg-slate-800/50 backdrop-blur-sm border-slate-700/50 rounded-2xl overflow-hidden">
                    <div class="flex items-center justify-between p-4 cursor-pointer hover:bg-slate-700/30 transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background-color: {{ $category['color'] ?? '#6366f1' }}20">
                                @if($category['icon'])
                                    {!! \App\Helpers\IconHelper::render($category['icon'], $category['color'] ?? null) !!}
                                @else
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="color: {{ $category['color'] ?? '#6366f1' }}">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                                    </svg>
                                @endif
                            </div>
                            <div>
                                <h3 class="font-semibold text-white">{{ $category['name'] }}</h3>
                                <p class="text-xs text-slate-500">{{ count($category['subcategories'] ?? []) }} subcategorias</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <button 
                                wire:click="openSubcategoryModal({{ json_encode($category) }})"
                                class="p-2 text-slate-400 hover:text-indigo-400 transition-colors rounded-lg hover:bg-slate-700/50"
                                title="Adicionar subcategoria">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                            </button>
                            <button 
                                wire:click="openCategoryModal({{ json_encode($category) }})"
                                class="p-2 text-slate-400 hover:text-indigo-400 transition-colors rounded-lg hover:bg-slate-700/50"
                                title="Editar categoria">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>
                            <button 
                                wire:click="confirmDelete('category', {{ json_encode($category) }})"
                                @click="
                                    $wire.set('deleteType', 'category');
                                    $wire.set('itemToDelete',{{ json_encode($category) }});
                                    dispatchEvent(new CustomEvent('open-confirm-modal', {
                                        detail: {
                                            title: 'Excluir Categoria',
                                            message: 'Tem certeza que deseja excluir a categoria &quot;{{ $category['name'] }}&quot;? Isso também excluirá todas as subcategorias.',
                                            onConfirm: () => $wire.deleteItem()
                                        }
                                    }));
                                    $event.stopPropagation();
                                "
                                class="p-2 text-slate-400 hover:text-rose-400 transition-colors rounded-lg hover:bg-slate-700/50"
                                title="Excluir categoria">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    
                    @if(!empty($category['subcategories']))
                        <div class="border-t border-slate-700/50 bg-slate-800/30 p-3">
                            <div class="flex flex-wrap gap-2">
                                @foreach($category['subcategories'] as $subcategory)
                                    <div class="flex items-center gap-2 px-3 py-1.5 bg-slate-700/50 rounded-lg group">
                                        <span class="text-sm text-slate-300">{{ $subcategory['name'] }}</span>
                                        <button 
                                            wire:click="openSubcategoryModal({{ json_encode($category) }}, {{ json_encode($subcategory) }})"
                                            class="opacity-0 group-hover:opacity-100 p-1 text-slate-400 hover:text-indigo-400 transition-all"
                                            title="Editar">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </button>
                                        <button 
                                            wire:click="confirmDelete('subcategory', {{ json_encode($subcategory) }})"
                                            @click="
                                                $wire.set('deleteType', 'subcategory');
                                                $wire.set('itemToDelete',{{ json_encode($subcategory) }});
                                                dispatchEvent(new CustomEvent('open-confirm-modal', {
                                                    detail: {
                                                        title: 'Excluir Subcategoria',
                                                        message: 'Tem certeza que deseja excluir a subcategoria &quot;{{ $subcategory['name'] }}&quot;?',
                                                        onConfirm: () => $wire.deleteItem()
                                                    }
                                                }));
                                                $event.stopPropagation();
                                            "
                                            class="opacity-0 group-hover:opacity-100 p-1 text-slate-400 hover:text-rose-400 transition-all"
                                            title="Excluir">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @empty
                <div class="p-12 text-center border bg-slate-800/50 backdrop-blur-sm border-slate-700/50 rounded-2xl">
                    <p class="text-slate-400">Nenhuma categoria encontrada.</p>
                    <button 
                        wire:click="openCategoryModal()"
                        class="mt-4 text-indigo-400 hover:text-indigo-300">
                        Criar primeira categoria
                    </button>
                </div>
            @endforelse
        </div>
    </div>

    @if($showCategoryModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" wire:click="closeCategoryModal"></div>
            <div class="relative bg-slate-800 border border-slate-700 rounded-2xl w-full max-w-md p-6 shadow-2xl">
                <h2 class="text-xl font-semibold text-white mb-6">
                    {{ $editingCategory ? 'Editar Categoria' : 'Nova Categoria' }}
                </h2>
                
                <form wire:submit.prevent="saveCategory" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-400 mb-2">Nome</label>
                        <input 
                            type="text" 
                            wire:model="categoryForm.name"
                            class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600 rounded-xl text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                            placeholder="Ex: Alimentação">
                        @error('categoryForm.name')
                            <p class="mt-1 text-sm text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-400 mb-2">Tipo</label>
                        <select 
                            wire:model="categoryForm.type"
                            class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            <option value="expense">Despesa</option>
                            <option value="income">Receita</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-400 mb-2">Cor</label>
                        <div class="flex items-center gap-3">
                            <input 
                                type="color" 
                                wire:model="categoryForm.color"
                                class="w-12 h-12 rounded-lg border-0 cursor-pointer bg-transparent">
                            <input 
                                type="text" 
                                wire:model="categoryForm.color"
                                class="flex-1 px-4 py-3 bg-slate-700/50 border border-slate-600 rounded-xl text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                placeholder="#6366f1">
                        </div>
                    </div>

                    <div class="flex gap-3 pt-4">
                        <button 
                            type="button"
                            wire:click="closeCategoryModal"
                            class="flex-1 px-4 py-3 bg-slate-700 hover:bg-slate-600 text-white font-medium rounded-xl transition-colors">
                            Cancelar
                        </button>
                        <button 
                            type="submit"
                            class="flex-1 px-4 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl transition-colors">
                            {{ $editingCategory ? 'Atualizar' : 'Criar' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    @if($showSubcategoryModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" wire:click="closeSubcategoryModal"></div>
            <div class="relative bg-slate-800 border border-slate-700 rounded-2xl w-full max-w-md p-6 shadow-2xl">
                <h2 class="text-xl font-semibold text-white mb-6">
                    {{ $editingSubcategory ? 'Editar Subcategoria' : 'Nova Subcategoria' }}
                </h2>
                <p class="text-sm text-slate-400 mb-6">
                    Categoria: <span class="text-white font-medium">{{ $parentCategory['name'] ?? '' }}</span>
                </p>
                
                <form wire:submit.prevent="saveSubcategory" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-400 mb-2">Nome</label>
                        <input 
                            type="text" 
                            wire:model="subcategoryForm.name"
                            class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600 rounded-xl text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                            placeholder="Ex: Supermercado">
                        @error('subcategoryForm.name')
                            <p class="mt-1 text-sm text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-400 mb-2">Cor</label>
                        <div class="flex items-center gap-3">
                            <input 
                                type="color" 
                                wire:model="subcategoryForm.color"
                                class="w-12 h-12 rounded-lg border-0 cursor-pointer bg-transparent">
                            <input 
                                type="text" 
                                wire:model="subcategoryForm.color"
                                class="flex-1 px-4 py-3 bg-slate-700/50 border border-slate-600 rounded-xl text-white placeholder-slate-400 focus:outline-none2 focus:ring focus:ring--indigo-500 focus:border-transparent"
                                placeholder="#6366f1">
                        </div>
                    </div>

                    <div class="flex gap-3 pt-4">
                        <button 
                            type="button"
                            wire:click="closeSubcategoryModal"
                            class="flex-1 px-4 py-3 bg-slate-700 hover:bg-slate-600 text-white font-medium rounded-xl transition-colors">
                            Cancelar
                        </button>
                        <button 
                            type="submit"
                            class="flex-1 px-4 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl transition-colors">
                            {{ $editingSubcategory ? 'Atualizar' : 'Criar' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
