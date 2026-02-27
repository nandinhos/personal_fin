<?php

namespace App\Http\Controllers;

use App\Models\Subcategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $profileId = $request->user()->profiles()->first()?->id;

        $subcategories = Subcategory::whereHas('category', function ($q) use ($profileId) {
            $q->where('profile_id', $profileId);
        })->orderBy('name')->get();

        return response()->json($subcategories);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:20',
        ]);

        $subcategory = Subcategory::create($validated);

        return response()->json($subcategory, 201);
    }

    public function update(Request $request, Subcategory $subcategory): JsonResponse
    {
        $subcategory->update($request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:20',
        ]));

        return response()->json($subcategory);
    }

    public function destroy(Subcategory $subcategory): JsonResponse
    {
        $subcategory->delete();

        return response()->json(null, 204);
    }
}
