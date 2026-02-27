<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $profileId = $request->user()->profiles()->first()?->id;

        $categories = Category::where('profile_id', $profileId)
            ->with('subcategories')
            ->orderBy('name')
            ->get();

        return response()->json($categories);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:20',
        ]);

        $profile = $request->user()->profiles()->firstOrCreate(
            ['user_id' => auth()->id()],
            ['name' => 'Padrão', 'is_default' => true]
        );

        $category = Category::create([...$validated, 'profile_id' => $profile->id]);

        return response()->json($category, 201);
    }

    public function update(Request $request, Category $category): JsonResponse
    {
        abort_if($category->profile->user_id !== auth()->id(), 403);

        $category->update($request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:20',
        ]));

        return response()->json($category);
    }

    public function destroy(Category $category): JsonResponse
    {
        abort_if($category->profile->user_id !== auth()->id(), 403);

        $category->delete();

        return response()->json(null, 204);
    }
}
