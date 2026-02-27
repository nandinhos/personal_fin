<?php

namespace App\Http\Controllers;

use App\Models\Subcategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SubcategoryController extends Controller
{
    public function index(Request $request): View
    {
        $profileId = $request->user()->profiles()->first()?->id;

        $subcategories = Subcategory::whereHas('category', function ($q) use ($profileId) {
            $q->where('profile_id', $profileId);
        })->orderBy('name')->get();

        return view('subcategories.index', compact('subcategories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:20',
        ]);

        Subcategory::create($validated);

        return redirect()->route('subcategories.index')->with('success', 'Subcategoria criada');
    }

    public function update(Request $request, Subcategory $subcategory): RedirectResponse
    {
        $subcategory->update($request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:20',
        ]));

        return redirect()->route('subcategories.index')->with('success', 'Subcategoria atualizada');
    }

    public function destroy(Subcategory $subcategory): RedirectResponse
    {
        $subcategory->delete();

        return redirect()->route('subcategories.index')->with('success', 'Subcategoria excluída');
    }
}
