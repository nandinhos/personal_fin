<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InvestmentController extends Controller
{
    public function index(): JsonResponse
    {
        $profile = auth()->user()->profiles()->first();

        if (! $profile) {
            return response()->json([]);
        }

        $investments = Investment::where('profile_id', $profile->id)
            ->orderBy('purchase_date', 'desc')
            ->get();

        return response()->json($investments);
    }

    public function summary(): JsonResponse
    {
        $profile = auth()->user()->profiles()->first();

        if (! $profile) {
            return response()->json(['invested' => 0, 'current' => 0, 'gain' => 0, 'gain_percent' => 0]);
        }

        $investments  = Investment::where('profile_id', $profile->id)->get();
        $invested     = (float) $investments->sum('amount');
        $current      = (float) $investments->sum('current_value');
        $gain         = $current - $invested;
        $gainPercent  = $invested > 0 ? round(($gain / $invested) * 100, 2) : 0;

        return response()->json(compact('invested', 'current', 'gain', 'gainPercent'));
    }

    public function store(Request $request): JsonResponse
    {
        $profile = auth()->user()->profiles()->firstOrCreate(
            ['user_id' => auth()->id()],
            ['name' => 'Principal', 'is_default' => true]
        );

        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'type'          => 'required|string|max:50',
            'amount'        => 'required|numeric|min:0.01',
            'current_value' => 'nullable|numeric|min:0',
            'purchase_date' => 'required|date',
        ]);

        $validated['profile_id']    = $profile->id;
        $validated['current_value'] = $validated['current_value'] ?? $validated['amount'];

        $investment = Investment::create($validated);

        return response()->json($investment, 201);
    }

    public function update(Request $request, Investment $investment): JsonResponse
    {
        abort_if($investment->profile_id !== auth()->user()->profiles()->first()?->id, 403);

        $validated = $request->validate([
            'name'          => 'sometimes|string|max:255',
            'type'          => 'sometimes|string|max:50',
            'amount'        => 'sometimes|numeric|min:0.01',
            'current_value' => 'sometimes|numeric|min:0',
            'purchase_date' => 'sometimes|date',
        ]);

        $investment->update($validated);

        return response()->json($investment);
    }

    public function destroy(Investment $investment): JsonResponse
    {
        abort_if($investment->profile_id !== auth()->user()->profiles()->first()?->id, 403);

        $investment->delete();

        return response()->json(null, 204);
    }
}
