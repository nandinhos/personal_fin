<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function index(): JsonResponse
    {
        $profile = auth()->user()->profiles()->first();

        if (! $profile) {
            return response()->json([]);
        }

        $loans = Loan::where('profile_id', $profile->id)
            ->orderBy('end_date')
            ->get();

        return response()->json($loans);
    }

    public function store(Request $request): JsonResponse
    {
        $profile = auth()->user()->profiles()->firstOrCreate(
            ['user_id' => auth()->id()],
            ['name' => 'Principal', 'is_default' => true]
        );

        $validated = $request->validate([
            'name'              => 'required|string|max:255',
            'amount'            => 'required|numeric|min:0.01',
            'interest_rate'     => 'required|numeric|min:0',
            'installments'      => 'required|integer|min:1',
            'start_date'        => 'required|date',
            'end_date'          => 'nullable|date|after:start_date',
        ]);

        $validated['profile_id']         = $profile->id;
        $validated['remaining_amount']   = $validated['amount'];
        $validated['paid_installments']  = 0;
        $validated['is_active']          = true;

        $loan = Loan::create($validated);

        return response()->json($loan, 201);
    }

    public function update(Request $request, Loan $loan): JsonResponse
    {
        abort_if($loan->profile_id !== auth()->user()->profiles()->first()?->id, 403);

        $validated = $request->validate([
            'name'             => 'sometimes|string|max:255',
            'interest_rate'    => 'sometimes|numeric|min:0',
            'remaining_amount' => 'sometimes|numeric|min:0',
            'end_date'         => 'nullable|date',
            'is_active'        => 'sometimes|boolean',
        ]);

        $loan->update($validated);

        return response()->json($loan);
    }

    public function pay(Request $request, Loan $loan): JsonResponse
    {
        abort_if($loan->profile_id !== auth()->user()->profiles()->first()?->id, 403);

        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01',
        ]);

        $newRemaining = max(0, $loan->remaining_amount - $validated['amount']);
        $newPaid      = $loan->paid_installments + 1;
        $isCompleted  = $newRemaining <= 0 || $newPaid >= $loan->installments;

        $loan->update([
            'remaining_amount'  => $newRemaining,
            'paid_installments' => $newPaid,
            'is_active'         => ! $isCompleted,
        ]);

        return response()->json($loan);
    }

    public function destroy(Loan $loan): JsonResponse
    {
        abort_if($loan->profile_id !== auth()->user()->profiles()->first()?->id, 403);

        $loan->delete();

        return response()->json(null, 204);
    }
}
