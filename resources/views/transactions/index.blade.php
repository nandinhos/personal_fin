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
                        <div class="flex items-center gap-1">
                            @if($transaction->type === 'transfer')
                                <span class="text-xs px-2 py-1 bg-indigo-500/20 text-indigo-300 rounded-md">
                                    Transferência
                                </span>
                            @else
                                <span class="text-xs px-2 py-1 bg-slate-700/50 text-slate-300 rounded-md">
                                    {{ $transaction->category->name ?? '-' }}
                                </span>
                            @endif
                            <button 
                                type="button"
                                @click="
                                    dispatchEvent(new CustomEvent('open-confirm-modal', {
                                        detail: {
                                            title: 'Excluir Transação',
                                            message: 'Tem certeza que deseja excluir esta transação?',
                                            onConfirm: () => {
                                                fetch('{{ route('transactions.destroy', $transaction) }}', {
                                                    method: 'DELETE',
                                                    headers: {
                                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                        'Content-Type': 'application/json'
                                                    }
                                                }).then(() => window.location.reload())
                                            }
                                        }
                                    }))
                                "
                                class="ml-1 p-1 text-slate-500 hover:text-rose-400 transition-colors" title="Excluir">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex-1 min-w-0 pr-4">
                            @if($transaction->type === 'transfer')
                                <h3 class="text-white font-medium truncate">{{ $transaction->account->name ?? '-' }} → {{ $transaction->toAccount->name ?? '-' }}</h3>
                            @else
                                <h3 class="text-white font-medium truncate">{{ $transaction->description ?? '-' }}</h3>
                                <p class="text-xs text-slate-400 mt-0.5 truncate">{{ $transaction->account->name ?? '-' }}</p>
                            @endif
                        </div>
                        <div class="text-right">
                            <span class="font-bold text-lg {{ $transaction->type === 'income' ? 'text-emerald-400' : ($transaction->type === 'expense' ? 'text-rose-400' : 'text-indigo-400') }}">
                                @if($transaction->type === 'income')
                                    +R$ {{ number_format($transaction->amount, 2, ',', '.') }}
                                @elseif($transaction->type === 'expense')
                                    -R$ {{ number_format($transaction->amount, 2, ',', '.') }}
                                @else
                                    R$ {{ number_format($transaction->amount, 2, ',', '.') }}
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-12 text-center border bg-slate-800/50 backdrop-blur-sm border-slate-700/50 rounded-2xl">
                    <p class="text-slate-400 font-medium">Nenhuma transação encontrada.</p>
                    <a href="{{ route('transactions.create') }}" class="mt-4 inline-block text-indigo-400 hover:text-indigo-300">Criar primeira transação</a>
                </div>
            @endforelse
        </div>

        <!-- Desktop View (Table) -->
        <div class="hidden sm:block overflow-x-auto border bg-slate-800/50 backdrop-blur-sm border-slate-700/50 rounded-2xl">
            <table class="min-w-full text-left">
                <thead class="bg-slate-800/80">
                    <tr>
                        <th class="px-4 py-3 text-xs font-semibold text-slate-300 uppercase tracking-wider">Data</th>
                        <th class="px-4 py-3 text-xs font-semibold text-slate-300 uppercase tracking-wider">Tipo</th>
                        <th class="px-4 py-3 text-xs font-semibold text-slate-300 uppercase tracking-wider">Descrição</th>
                        <th class="px-4 py-3 text-xs font-semibold text-slate-300 uppercase tracking-wider">Categoria</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-slate-300 uppercase tracking-wider">Valor</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-slate-300 uppercase tracking-wider w-16"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $transaction)
                        <tr class="hover:bg-slate-700/30 transition-colors group">
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-400 font-medium">
                                {{ \Carbon\Carbon::parse($transaction->date)->format('d/m') }}
                                <span class="text-slate-600 text-xs">{{ \Carbon\Carbon::parse($transaction->date)->format('/Y') }}</span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                @if($transaction->type === 'income')
                                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-md bg-emerald-500/20 text-emerald-400 text-xs font-medium">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12" />
                                        </svg>
                                        Receita
                                    </span>
                                @elseif($transaction->type === 'expense')
                                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-md bg-rose-500/20 text-rose-400 text-xs font-medium">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6" />
                                        </svg>
                                        Despesa
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-md bg-indigo-500/20 text-indigo-400 text-xs font-medium">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                        </svg>
                                        Transfer
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-white">
                                @if($transaction->type === 'transfer')
                                    {{ $transaction->account->name ?? '-' }} <span class="text-slate-500">→</span> {{ $transaction->toAccount->name ?? '-' }}
                                @else
                                    {{ $transaction->description ?? '-' }}
                                @endif
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-400">
                                @if($transaction->type === 'transfer')
                                    <span class="text-slate-500">—</span>
                                @else
                                    {{ $transaction->category->name ?? '-' }}
                                @endif
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-right text-sm font-semibold 
                                {{ $transaction->type === 'income' ? 'text-emerald-400' : ($transaction->type === 'expense' ? 'text-rose-400' : 'text-indigo-400') }}">
                                @if($transaction->type === 'income')
                                    +R$ {{ number_format($transaction->amount, 2, ',', '.') }}
                                @elseif($transaction->type === 'expense')
                                    -R$ {{ number_format($transaction->amount, 2, ',', '.') }}
                                @else
                                    R$ {{ number_format($transaction->amount, 2, ',', '.') }}
                                @endif
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-right">
                                <div class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <button 
                                        type="button"
                                        @click="
                                            dispatchEvent(new CustomEvent('open-confirm-modal', {
                                                detail: {
                                                    title: 'Excluir Transação',
                                                    message: 'Tem certeza que deseja excluir esta transação?',
                                                    onConfirm: () => {
                                                        fetch('{{ route('transactions.destroy', $transaction) }}', {
                                                            method: 'DELETE',
                                                            headers: {
                                                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                                'Content-Type': 'application/json'
                                                            }
                                                        }).then(() => window.location.reload())
                                                    }
                                                }
                                            }))
                                        "
                                        class="p-2 text-slate-400 hover:text-rose-400 transition-colors" title="Excluir">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400 font-medium font-sans">
                                <p>Nenhuma transação encontrada.</p>
                                <a href="{{ route('transactions.create') }}" class="mt-2 inline-block text-indigo-400 hover:text-indigo-300">Criar primeira transação</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
