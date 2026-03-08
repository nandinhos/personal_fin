<x-app-layout>
    <div class="space-y-8">
        <header class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6 relative">
            <div class="absolute -top-10 -left-10 w-64 h-64 obsidian-glow opacity-30 pointer-events-none"></div>
            <div>
                <h1 class="text-4xl font-extrabold tracking-tight text-slate-900 dark:text-white glow-text">O Registro</h1>
                <p class="mt-2 text-base text-slate-400 font-medium">Histórico universal de movimentações financeiras.</p>
            </div>
            <a href="{{ route('transactions.create') }}"
                class="glass-button px-8 py-4 flex items-center gap-3 group transition-all">
                <div class="w-6 h-6 rounded-lg bg-cyan-500/20 flex items-center justify-center group-hover:bg-cyan-500/40 transition-colors">
                    <svg class="w-4 h-4 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
                <span class="font-bold uppercase tracking-widest text-[11px]">Novo Registro</span>
            </a>
        </header>

        <!-- Mobile View (The Registry Cards) -->
        <div class="space-y-4 sm:hidden">
            @forelse($transactions as $transaction)
                <div class="glass-panel p-6 group relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-bl from-white/5 to-transparent -z-10 group-hover:from-cyan-500/10 transition-colors duration-500"></div>
                    
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-[10px] font-bold uppercase tracking-widest text-slate-500">
                            {{ \Carbon\Carbon::parse($transaction->date)->format('d . m . Y') }}
                        </span>
                        <div class="flex items-center gap-2">
                            @if($transaction->type === 'transfer')
                                <span class="text-[9px] font-bold uppercase tracking-widest px-2 py-1 bg-cyan-500/10 text-cyan-400 rounded-md border border-cyan-500/20">
                                    Transferência
                                </span>
                            @else
                                <span class="text-[9px] font-bold uppercase tracking-widest px-2 py-1 bg-white/5 text-slate-400 rounded-md border border-white/10">
                                    {{ $transaction->category->name ?? '-' }}
                                </span>
                            @endif
                            
                            <button 
                                type="button"
                                @click="
                                    dispatchEvent(new CustomEvent('open-confirm-modal', {
                                        detail: {
                                            title: 'Remover Registro?',
                                            message: 'Tem certeza que deseja remover este registro permanentemente?',
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
                                class="p-2 text-slate-600 hover:text-rose-500 transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex-1 min-w-0 pr-4">
                            @if($transaction->type === 'transfer')
                                <h3 class="text-slate-900 dark:text-white font-bold text-lg leading-tight">{{ $transaction->account->name ?? '-' }} <span class="text-cyan-500 px-1">→</span> {{ $transaction->toAccount->name ?? '-' }}</h3>
                            @else
                                <h3 class="text-slate-900 dark:text-white font-bold text-lg leading-tight truncate">{{ $transaction->description ?? '-' }}</h3>
                                <p class="text-xs text-slate-500 mt-1 font-medium tracking-wide">{{ $transaction->account->name ?? '-' }}</p>
                            @endif
                        </div>
                        <div class="text-right">
                            <span class="font-extrabold text-xl leading-none tabular-nums {{ $transaction->type === 'income' ? 'text-emerald-400' : ($transaction->type === 'expense' ? 'text-rose-400' : 'text-cyan-400') }}">
                                @if($transaction->type === 'income')
                                    +{{ number_format($transaction->amount, 2, ',', '.') }}
                                @elseif($transaction->type === 'expense')
                                    -{{ number_format($transaction->amount, 2, ',', '.') }}
                                @else
                                    {{ number_format($transaction->amount, 2, ',', '.') }}
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="glass-panel p-16 text-center rounded-[2rem]">
                    <div class="w-16 h-16 bg-white/5 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <p class="text-slate-500 font-medium italic">Nenhum registro encontrado no sistema.</p>
                    <a href="{{ route('transactions.create') }}" class="mt-6 inline-flex items-center gap-2 text-cyan-400 font-bold uppercase tracking-widest text-[10px] hover:glow-text transition-all">
                        <span>Iniciar Novo Registro</span>
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Desktop View (The Registry Table) -->
        <div class="hidden sm:block glass-panel rounded-[2rem] overflow-hidden border-white/5">
            <table class="min-w-full text-left">
                <thead>
                    <tr class="border-b border-white/5 bg-white/[0.01]">
                        <th class="px-8 py-6 text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em]">Data do Log</th>
                        <th class="px-6 py-6 text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em]">Função</th>
                        <th class="px-6 py-6 text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em]">Descrição / Origem</th>
                        <th class="px-6 py-6 text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em]">Categoria</th>
                        <th class="px-6 py-6 text-right text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em]">Valor</th>
                        <th class="px-8 py-6 text-right w-16"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($transactions as $transaction)
                        <tr class="hover:bg-white/[0.02] transition-colors group">
                            <td class="px-8 py-6 whitespace-nowrap">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-slate-900 dark:text-white tabular-nums">{{ \Carbon\Carbon::parse($transaction->date)->format('d . m') }}</span>
                                    <span class="text-[10px] text-slate-600 font-medium tracking-widest">{{ \Carbon\Carbon::parse($transaction->date)->format('Y') }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-6 whitespace-nowrap">
                                @if($transaction->type === 'income')
                                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-lg bg-emerald-500/10 text-emerald-400 text-[9px] font-bold uppercase tracking-widest border border-emerald-500/20">
                                        Entrada
                                    </span>
                                @elseif($transaction->type === 'expense')
                                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-lg bg-rose-500/10 text-rose-400 text-[9px] font-bold uppercase tracking-widest border border-rose-500/20">
                                        Saída
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-lg bg-cyan-500/10 text-cyan-400 text-[9px] font-bold uppercase tracking-widest border border-cyan-500/20">
                                        Transf.
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-6 whitespace-nowrap">
                                <div class="flex flex-col">
                                    @if($transaction->type === 'transfer')
                                        <span class="text-sm font-bold text-slate-900 dark:text-white">{{ $transaction->account->name ?? '-' }} <span class="text-cyan-500 mx-1">→</span> {{ $transaction->toAccount->name ?? '-' }}</span>
                                    @else
                                        <span class="text-sm font-bold text-slate-900 dark:text-white group-hover:text-cyan-500 dark:group-hover:text-cyan-400 transition-colors">{{ $transaction->description ?? '-' }}</span>
                                        <span class="text-[10px] text-slate-600 font-medium tracking-wide mt-0.5">{{ $transaction->account->name ?? '-' }}</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-6 whitespace-nowrap">
                                @if($transaction->type === 'transfer')
                                    <span class="text-slate-700 text-[10px] uppercase font-bold tracking-widest">---</span>
                                @else
                                    <span class="px-2 py-1 rounded-md bg-white/5 border border-white/10 text-slate-400 text-[10px] uppercase font-bold tracking-widest transition-all">
                                        {{ $transaction->category->name ?? '-' }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-6 whitespace-nowrap text-right">
                                <span class="text-lg font-extrabold tabular-nums leading-none {{ $transaction->type === 'income' ? 'text-emerald-400' : ($transaction->type === 'expense' ? 'text-rose-400' : 'text-cyan-400') }}">
                                    @if($transaction->type === 'income')
                                        +{{ number_format($transaction->amount, 2, ',', '.') }}
                                    @elseif($transaction->type === 'expense')
                                        -{{ number_format($transaction->amount, 2, ',', '.') }}
                                    @else
                                        {{ number_format($transaction->amount, 2, ',', '.') }}
                                    @endif
                                </span>
                            </td>
                            <td class="px-8 py-6 whitespace-nowrap text-right">
                                <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-all transform translate-x-4 group-hover:translate-x-0">
                                    <button 
                                        type="button"
                                        @click="
                                            dispatchEvent(new CustomEvent('open-confirm-modal', {
                                                detail: {
                                                    title: 'Remover Registro?',
                                                    message: 'Deseja realmente remover este artefato do sistema?',
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
                                        class="p-2 text-slate-600 hover:text-rose-500 transition-colors" title="Remover Log">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-8 py-32 text-center">
                                <p class="text-slate-500 font-medium italic">Nenhum artefato encontrado no sistema.</p>
                                <a href="{{ route('transactions.create') }}" class="mt-6 inline-flex items-center gap-2 text-cyan-400 font-bold uppercase tracking-widest text-[10px] hover:glow-text transition-all">
                                    <span>Novo Registro</span>
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>

