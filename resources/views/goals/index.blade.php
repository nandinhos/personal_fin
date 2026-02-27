@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <header class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-white">Metas de Reserva</h1>
            <p class="mt-2 text-sm text-slate-400">Gerencie suas metas de economia e reserva financeira.</p>
        </div>
    </header>

    <div class="p-6 border bg-slate-800/50 backdrop-blur-sm border-slate-700/50 rounded-2xl">
        <h3 class="text-lg font-semibold text-white mb-4">Criar Nova Meta</h3>
        <form action="{{ route('goals.store') }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-400 mb-2">Nome da Meta</label>
                    <input type="text" name="name" class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600 rounded-xl text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Ex: Viagem, Emergência...">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-400 mb-2">Valor Alvo</label>
                    <input type="number" name="target_amount" step="0.01" min="0.01" class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600 rounded-xl text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="0,00">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-400 mb-2">Prazo</label>
                    <input type="date" name="deadline" class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600 rounded-xl text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>
            <button type="submit" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl transition-colors">
                Criar Meta
            </button>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($goals as $goal)
            <div class="p-6 border bg-slate-800/50 backdrop-blur-sm border-slate-700/50 rounded-2xl">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h4 class="font-semibold text-white">{{ $goal->name }}</h4>
                        <p class="text-xs text-slate-500">Prazo: {{ $goal->deadline->format('d/m/Y') }}</p>
                    </div>
                    @if($goal->is_completed)
                        <span class="px-2 py-1 bg-emerald-500/20 text-emerald-400 text-xs font-medium rounded-full">Concluída</span>
                    @endif
                </div>
                
                <div class="mb-4">
                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-slate-400">Progresso</span>
                        <span class="text-white font-medium">{{ $goal->progress_percentage }}%</span>
                    </div>
                    <div class="w-full h-2 rounded-full bg-slate-700 overflow-hidden">
                        <div class="h-2 rounded-full bg-indigo-500 transition-all duration-300" style="width: {{ min($goal->progress_percentage, 100) }}%"></div>
                    </div>
                </div>

                <div class="flex justify-between text-sm mb-4">
                    <span class="text-slate-400">R$ {{ number_format($goal->current_amount, 2, ',', '.') }}</span>
                    <span class="text-slate-400">R$ {{ number_format($goal->target_amount, 2, ',', '.') }}</span>
                </div>

                <form action="{{ route('goals.updateProgress', $goal) }}" method="POST" class="space-y-2">
                    @csrf
                    @method('PATCH')
                    <input type="number" name="current_amount" step="0.01" min="0" value="{{ $goal->current_amount }}" class="w-full px-3 py-2 bg-slate-700/50 border border-slate-600 rounded-lg text-white text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Atualizar valor">
                    <div class="flex gap-2">
                        <button type="submit" class="flex-1 px-3 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors">
                            Atualizar
                        </button>
                        <button type="submit" form="delete-goal-{{ $goal->id }}" class="p-2 text-slate-400 hover:text-rose-400 transition-colors rounded-lg hover:bg-slate-700/50">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                </form>
                <form action="{{ route('goals.destroy', $goal) }}" method="POST" id="delete-goal-{{ $goal->id }}" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        @empty
            <div class="col-span-full text-center py-8">
                <p class="text-slate-400">Nenhuma meta configurada.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
