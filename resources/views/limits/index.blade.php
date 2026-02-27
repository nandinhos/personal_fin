@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <header class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-white">Limites por Categoria</h1>
            <p class="mt-2 text-sm text-slate-400">Gerencie seus limites mensais de gastos por categoria.</p>
        </div>
    </header>

    <div class="p-6 border bg-slate-800/50 backdrop-blur-sm border-slate-700/50 rounded-2xl">
        <h3 class="text-lg font-semibold text-white mb-4">Criar Novo Limite</h3>
        <form action="{{ route('limits.store') }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-400 mb-2">Categoria</label>
                    <select name="category_id" class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">Selecione...</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-400 mb-2">Valor Limite</label>
                    <input type="number" name="amount" step="0.01" min="0" class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600 rounded-xl text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="0,00">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-400 mb-2">Período</label>
                    <select name="period" class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="monthly">Mensal</option>
                        <option value="weekly">Semanal</option>
                        <option value="daily">Diário</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl transition-colors">
                Criar Limite
            </button>
        </form>
    </div>

    <div class="space-y-4">
        <h3 class="text-lg font-semibold text-white">Limites Configurados</h3>
        @forelse($limits as $limit)
            <div class="p-4 border bg-slate-800/50 backdrop-blur-sm border-slate-700/50 rounded-2xl">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background-color: {{ $limit->category->color ?? '#6366f1' }}20">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="color: {{ $limit->category->color ?? '#6366f1' }}">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-white">{{ $limit->category->name ?? 'Categoria' }}</h4>
                            <p class="text-xs text-slate-500">Limite: R$ {{ number_format($limit->amount, 2, ',', '.') }} / {{ $limit->period }}</p>
                        </div>
                    </div>
                    <form action="{{ route('limits.destroy', $limit) }}" method="POST" class="flex items-center gap-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-2 text-slate-400 hover:text-rose-400 transition-colors rounded-lg hover:bg-slate-700/50" title="Excluir">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-center text-slate-400 py-8">Nenhum limite configurado.</p>
        @endforelse
    </div>
</div>
@endsection
