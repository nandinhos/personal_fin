<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GoalController extends Controller
{
    public function index(): JsonResponse
    {
        $profile = Auth::user()->profiles()->first();

        if (! $profile) {
            return response()->json([]);
        }

        $goals = Goal::where('profile_id', $profile->id)
            ->orderBy('deadline')
            ->get();

        return response()->json($goals);
    }

    public function store(Request $request): JsonResponse
    {
        $profile = Auth::user()->profiles()->firstOrCreate(
            ['user_id' => Auth::id()],
            ['name' => 'Principal', 'is_default' => true]
        );

        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'target_amount' => 'required|numeric|min:0.01',
            'deadline'      => 'required|date|after:today',
        ]);

        $validated['profile_id']     = $profile->id;
        $validated['current_amount'] = 0;
        $validated['is_completed']   = false;

        $goal = Goal::create($validated);

        return response()->json($goal, 201);
    }

    public function update(Request $request, Goal $goal): JsonResponse
    {
        abort_if($goal->profile_id !== Auth::user()->profiles()->first()?->id, 403);

        $validated = $request->validate([
            'name'           => 'sometimes|string|max:255',
            'target_amount'  => 'sometimes|numeric|min:0.01',
            'current_amount' => 'sometimes|numeric|min:0',
            'deadline'       => 'sometimes|date',
            'is_completed'   => 'sometimes|boolean',
        ]);

        if (isset($validated['current_amount'], $validated['target_amount'])) {
            $validated['is_completed'] = $validated['current_amount'] >= $validated['target_amount'];
        }

        $goal->update($validated);

        return response()->json($goal);
    }

    public function destroy(Goal $goal): JsonResponse
    {
        abort_if($goal->profile_id !== Auth::user()->profiles()->first()?->id, 403);

        $goal->delete();

        return response()->json(null, 204);
    }

    public function updateProgress(Request $request, Goal $goal): JsonResponse
    {
        abort_if($goal->profile_id !== Auth::user()->profiles()->first()?->id, 403);

        $validated = $request->validate([
            'current_amount' => 'required|numeric|min:0',
        ]);

        $goal->update([
            'current_amount' => $validated['current_amount'],
            'is_completed'   => $validated['current_amount'] >= $goal->target_amount,
        ]);

        return response()->json($goal);
    }
}
