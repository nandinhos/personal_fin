<?php

namespace App\Http\Controllers;

use App\Models\Limit;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LimitController extends Controller
{
    public function index(): JsonResponse
    {
        $profile = Auth::user()->profiles()->first();

        if (! $profile) {
            return response()->json([]);
        }

        $limits = Limit::where('profile_id', $profile->id)
            ->with('category')
            ->get();

        return response()->json($limits);
    }

    public function store(Request $request): JsonResponse
    {
        $profile = Auth::user()->profiles()->firstOrCreate(
            ['user_id' => Auth::id()],
            ['name' => 'Principal', 'is_default' => true]
        );

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'amount'      => 'required|numeric|min:0',
            'period'      => 'nullable|in:monthly,weekly,daily',
        ]);

        $validated['profile_id'] = $profile->id;
        $validated['is_active']  = true;
        $validated['period']     = $validated['period'] ?? 'monthly';

        $limit = Limit::create($validated);

        return response()->json($limit->load('category'), 201);
    }

    public function update(Request $request, Limit $limit): JsonResponse
    {
        abort_if($limit->profile_id !== Auth::user()->profiles()->first()?->id, 403);

        $validated = $request->validate([
            'amount'    => 'required|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        $limit->update($validated);

        return response()->json($limit->load('category'));
    }

    public function destroy(Limit $limit): JsonResponse
    {
        abort_if($limit->profile_id !== Auth::user()->profiles()->first()?->id, 403);

        $limit->delete();

        return response()->json(null, 204);
    }
}
