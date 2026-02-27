<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CategoryManager extends Component
{
    public $categories = [];

    public $subcategories = [];

    public $activeTab = 'expense';

    public $showCategoryModal = false;

    public $showSubcategoryModal = false;

    public $showDeleteConfirm = false;

    public $editingCategory = null;

    public $editingSubcategory = null;

    public $parentCategory = null;

    public $categoryForm = [
        'name' => '',
        'type' => 'expense',
        'icon' => '',
        'color' => '#6366f1',
    ];

    public $subcategoryForm = [
        'name' => '',
        'icon' => '',
        'color' => '#6366f1',
    ];

    public $deleteItem = null;

    public $deleteType = null;

    protected $listeners = ['refreshCategories' => 'loadCategories'];

    public function mount()
    {
        $this->loadCategories();
    }

    public function loadCategories()
    {
        $profile = $this->getProfile();

        if (! $profile) {
            return;
        }

        $this->categories = Category::where('profile_id', $profile->id)
            ->with('subcategories')
            ->orderBy('type')
            ->orderBy('name')
            ->get()
            ->toArray();
    }

    protected function getProfile()
    {
        return Auth::user()->profiles()->first();
    }

    public function switchTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function openCategoryModal($category = null)
    {
        if ($category) {
            $this->editingCategory = $category;
            $this->categoryForm = [
                'name' => $category['name'],
                'type' => $category['type'],
                'icon' => $category['icon'] ?? '',
                'color' => $category['color'] ?? '#6366f1',
            ];
        } else {
            $this->editingCategory = null;
            $this->categoryForm = [
                'name' => '',
                'type' => $this->activeTab,
                'icon' => '',
                'color' => '#6366f1',
            ];
        }
        $this->showCategoryModal = true;
    }

    public function saveCategory()
    {
        $profile = $this->getProfile();

        $this->validate([
            'categoryForm.name' => 'required|string|max:255',
            'categoryForm.type' => 'required|in:income,expense',
            'categoryForm.color' => 'nullable|string|max:20',
        ]);

        if ($this->editingCategory) {
            $category = Category::where('profile_id', $profile->id)
                ->findOrFail($this->editingCategory['id']);
            $category->update($this->categoryForm);
            $this->dispatch('notify', ['message' => 'Categoria atualizada com sucesso!']);
        } else {
            Category::create([
                ...$this->categoryForm,
                'profile_id' => $profile->id,
            ]);
            $this->dispatch('notify', ['message' => 'Categoria criada com sucesso!']);
        }

        $this->closeCategoryModal();
        $this->loadCategories();
    }

    public function closeCategoryModal()
    {
        $this->showCategoryModal = false;
        $this->editingCategory = null;
        $this->categoryForm = [
            'name' => '',
            'type' => 'expense',
            'icon' => '',
            'color' => '#6366f1',
        ];
    }

    public function openSubcategoryModal($category, $subcategory = null)
    {
        $this->parentCategory = $category;

        if ($subcategory) {
            $this->editingSubcategory = $subcategory;
            $this->subcategoryForm = [
                'name' => $subcategory['name'],
                'icon' => $subcategory['icon'] ?? '',
                'color' => $subcategory['color'] ?? '#6366f1',
            ];
        } else {
            $this->editingSubcategory = null;
            $this->subcategoryForm = [
                'name' => '',
                'icon' => '',
                'color' => '#6366f1',
            ];
        }
        $this->showSubcategoryModal = true;
    }

    public function saveSubcategory()
    {
        $this->validate([
            'subcategoryForm.name' => 'required|string|max:255',
            'parentCategory.id' => 'required|exists:categories,id',
        ]);

        if ($this->editingSubcategory) {
            $subcategory = Subcategory::findOrFail($this->editingSubcategory['id']);
            $subcategory->update($this->subcategoryForm);
            $this->dispatch('notify', ['message' => 'Subcategoria atualizada com sucesso!']);
        } else {
            Subcategory::create([
                ...$this->subcategoryForm,
                'category_id' => $this->parentCategory['id'],
            ]);
            $this->dispatch('notify', ['message' => 'Subcategoria criada com sucesso!']);
        }

        $this->closeSubcategoryModal();
        $this->loadCategories();
    }

    public function closeSubcategoryModal()
    {
        $this->showSubcategoryModal = false;
        $this->editingSubcategory = null;
        $this->parentCategory = null;
        $this->subcategoryForm = [
            'name' => '',
            'icon' => '',
            'color' => '#6366f1',
        ];
    }

    public function confirmDelete($type, $item)
    {
        $this->deleteType = $type;
        $this->deleteItem = $item;
        $this->showDeleteConfirm = true;
    }

    public function deleteItem()
    {
        \Illuminate\Support\Facades\Log::info('deleteItem chamado', [
            'deleteType' => $this->deleteType,
            'deleteItem' => $this->deleteItem,
        ]);

        try {
            if ($this->deleteType === 'category') {
                $categoryId = $this->deleteItem['id'];
                $category = Category::find($categoryId);

                if (! $category) {
                    $this->dispatch('notify', ['message' => 'Categoria não encontrada', 'type' => 'error']);

                    return;
                }

                $noCategory = Category::firstOrCreate(
                    [
                        'profile_id' => $category->profile_id,
                        'name' => 'Sem Categoria',
                        'type' => $category->type,
                    ],
                    [
                        'is_default' => true,
                        'color' => '#6b7280',
                    ]
                );

                Transaction::where('category_id', $category->id)
                    ->update(['category_id' => $noCategory->id]);

                $category->delete();
                $this->dispatch('notify', ['message' => 'Categoria excluída com sucesso!']);
            } elseif ($this->deleteType === 'subcategory') {
                $subcategory = Subcategory::find($this->deleteItem['id']);
                if ($subcategory) {
                    $subcategory->delete();
                    $this->dispatch('notify', ['message' => 'Subcategoria excluída com sucesso!']);
                } else {
                    $this->dispatch('notify', ['message' => 'Subcategoria não encontrada', 'type' => 'error']);
                }
            }

            $this->closeDeleteConfirm();
            $this->loadCategories();
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Erro ao excluir: '.$e->getMessage());
            $this->dispatch('notify', ['message' => 'Erro ao excluir: '.$e->getMessage(), 'type' => 'error']);
        }
    }

    public function closeDeleteConfirm()
    {
        $this->showDeleteConfirm = false;
        $this->deleteItem = null;
        $this->deleteType = null;
    }

    public function render()
    {
        $filteredCategories = array_filter($this->categories, function ($cat) {
            return $cat['type'] === $this->activeTab;
        });

        return view('livewire.category-manager', [
            'filteredCategories' => array_values($filteredCategories),
        ]);
    }
}
