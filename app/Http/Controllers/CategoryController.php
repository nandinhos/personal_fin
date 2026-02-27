<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(Request $request): View
    {
        $profileId = $request->user()->profiles()->first()?->id;

        $categories = Category::where('profile_id', $profileId)
            ->with('subcategories')
            ->orderBy('name')
            ->get();

        return view('categories.index', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:20',
        ]);

        $profileId = $request->user()->profiles()->first()?->id
            ?? auth()->user()->profiles()->create([
                'name' => 'Padrão',
                'is_default' => true,
            ])->id;

        Category::create([
            ...$validated,
            'profile_id' => $profileId,
        ]);

        return redirect()->route('categories.index')->with('success', 'Categoria criada com sucesso');
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $this->authorize('update', $category);

        $category->update($request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:20',
        ]));

        return redirect()->route('categories.index')->with('success', 'Categoria atualizada');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $this->authorize('delete', $category);

        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Categoria excluída');
    }
}
