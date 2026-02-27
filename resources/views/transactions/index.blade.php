<x-app-layout>
    <div class="space-y-6">
        <header class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold tracking-tight text-white">Transações</h1>
                <p class="mt-2 text-sm text-slate-400">Gerencie suas receitas e despesas.</p>
            </div>
            <a href="{{ route('transactions.create') }}" 
                class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl transition-colors inline-flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Nova Transação
            </a>
        </header>

        <div class="overflow-hidden border bg-slate-800/50 backdrop-blur-sm border-slate-700/50 rounded-2xl">
            <table class="min-w-full divide-y divide-slate-700/50">
                <thead class="bg-slate-800/80">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Data</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Descrição</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Categoria</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Conta</th>
                        <th class="px-6 py-4 text-right text-xs font-medium text-slate-400 uppercase tracking-wider">Valor</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700/50">
                    @forelse($transactions as $transaction)
                        <tr class="hover:bg-slate-700/20 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-400">
                                {{ \Carbon\Carbon::parse($transaction->date)->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-white">
                                {{ $transaction->description ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-400">
                                {{ $transaction->category->name ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-400">
                                {{ $transaction->account->name ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-semibold {{ $transaction->type === 'income' ? 'text-emerald-400' : 'text-rose-400' }}">
                                {{ $transaction->type === 'income' ? '+' : '-' }}R$ {{ number_format($transaction->amount, 2, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-sm text-slate-500">
                                Nenhuma transação encontrada.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
