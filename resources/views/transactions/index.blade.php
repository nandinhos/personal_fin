<x-app-layout>
    <div class="space-y-6">
        <header class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold tracking-tight text-white">Transações</h1>
                <p class="mt-2 text-sm text-slate-400">Gerencie suas receitas e despesas.</p>
            </div>
            <a href="{{ route('transactions.create') }}" 
                class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl transition-colors inline-flex items-center gap-2 whitespace-nowrap">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span class="hidden sm:inline">Nova Transação</span>
                <span class="sm:hidden">Novo</span>
            </a>
        </header>

        <!-- Mobile View (Cards) -->
        <div class="space-y-4 sm:hidden">
            @forelse($transactions as $transaction)
                <div class="p-5 border bg-slate-800/50 backdrop-blur-sm border-slate-700/50 rounded-2xl">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-medium text-slate-400">
                            {{ \Carbon\Carbon::parse($transaction->date)->format('d/m/Y') }}
                        </span>
                        <span class="text-xs px-2 py-1 bg-slate-700/50 text-slate-300 rounded-md">
                            {{ $transaction->category->name ?? '-' }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex-1 min-w-0 pr-4">
                            <h3 class="text-white font-medium truncate">{{ $transaction->description ?? '-' }}</h3>
                            <p class="text-xs text-slate-400 mt-0.5 truncate">{{ $transaction->account->name ?? '-' }}</p>
                        </div>
                        <div class="text-right">
                            <span class="font-bold text-lg {{ $transaction->type === 'income' ? 'text-emerald-400' : 'text-rose-400' }}">
                                {{ $transaction->type === 'income' ? '+' : '-' }}R$ {{ number_format($transaction->amount, 2, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-12 text-center border bg-slate-800/50 backdrop-blur-sm border-slate-700/50 rounded-2xl">
                    <p class="text-slate-400 font-medium">Nenhuma transação encontrada.</p>
                </div>
            @endforelse
        </div>

        <!-- Desktop View (Table) -->
        <div class="hidden sm:block overflow-x-auto border bg-slate-800/50 backdrop-blur-sm border-slate-700/50 rounded-2xl">
            <table class="min-w-full divide-y divide-slate-700/50 text-left">
                <thead class="bg-slate-800/80">
                    <tr>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-300 uppercase tracking-wider">Data</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-300 uppercase tracking-wider">Descrição</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-300 uppercase tracking-wider">Categoria</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-300 uppercase tracking-wider">Conta</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-slate-300 uppercase tracking-wider">Valor</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700/50">
                    @forelse($transactions as $transaction)
                        <tr class="hover:bg-slate-700/20 transition-colors group">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-300 font-medium">
                                {{ \Carbon\Carbon::parse($transaction->date)->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-white font-medium">
                                {{ $transaction->description ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-400">
                                <span class="px-2 py-1 bg-slate-700/30 text-slate-300 rounded-md text-xs">
                                    {{ $transaction->category->name ?? '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-400">
                                {{ $transaction->account->name ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold {{ $transaction->type === 'income' ? 'text-emerald-400' : 'text-rose-400' }}">
                                {{ $transaction->type === 'income' ? '+' : '-' }}R$ {{ number_format($transaction->amount, 2, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400 font-medium font-sans">
                                Nenhuma transação encontrada.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
