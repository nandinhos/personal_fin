<?php

namespace App\Http\Controllers;

use App\Models\Installment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InstallmentController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $profile = auth()->user()->profiles()->first();

        if (! $profile) {
            return response()->json([]);
        }

        $query = Installment::where('profile_id', $profile->id)
            ->with('transaction');

        if ($request->has('is_paid')) {
            $query->where('is_paid', filter_var($request->is_paid, FILTER_VALIDATE_BOOLEAN));
        }

        return response()->json($query->orderBy('due_date')->get());
    }

    public function pending(): JsonResponse
    {
        $profile = auth()->user()->profiles()->first();

        if (! $profile) {
            return response()->json([]);
        }

        $installments = Installment::where('profile_id', $profile->id)
            ->where('is_paid', false)
            ->with('transaction')
            ->orderBy('due_date')
            ->get();

        return response()->json($installments);
    }

    public function pay(Installment $installment): JsonResponse
    {
        abort_if($installment->profile_id !== auth()->user()->profiles()->first()?->id, 403);

        $installment->update([
            'is_paid' => true,
            'paid_at' => now(),
        ]);

        return response()->json($installment);
    }

    public function update(Request $request, Installment $installment): JsonResponse
    {
        abort_if($installment->profile_id !== auth()->user()->profiles()->first()?->id, 403);

        $validated = $request->validate([
            'amount'   => 'sometimes|numeric|min:0.01',
            'due_date' => 'sometimes|date',
            'is_paid'  => 'sometimes|boolean',
            'paid_at'  => 'nullable|date',
        ]);

        $installment->update($validated);

        return response()->json($installment);
    }

    public function destroy(Installment $installment): JsonResponse
    {
        abort_if($installment->profile_id !== auth()->user()->profiles()->first()?->id, 403);

        $installment->delete();

        return response()->json(null, 204);
    }
}
