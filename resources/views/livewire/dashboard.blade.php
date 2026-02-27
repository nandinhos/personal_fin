<div wire:poll.10s>
    {{-- Header Section --}}
    <header class="mb-8">
        <h1 class="text-3xl font-bold tracking-tight text-white">Dashboard Financeiro</h1>
        <p class="mt-2 text-sm text-slate-400">Bem-vindo de volta! Aqui está um resumo das suas finanças.</p>
    </header>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 gap-6 mb-8 sm:grid-cols-2 lg:grid-cols-4">
        {{-- Total Balance --}}
        <div class="p-6 transition-all border group bg-slate-800/50 backdrop-blur-sm border-slate-700/50 rounded-2xl hover:border-indigo-500/50 hover:bg-slate-800/80">
            <div class="flex items-center justify-between mb-4">
                <span class="inline-flex items-center justify-center p-2 bg-indigo-500/10 rounded-xl">
                    <svg class="w-6 h-6 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>
                <span class="text-xs font-medium text-emerald-400">+12.5%</span>
            </div>
            <h3 class="text-sm font-medium text-slate-400">Saldo Total</h3>
            <p class="mt-1 text-2xl font-semibold text-white">R$ 45.230,00</p>
        </div>

        {{-- Monthly Income --}}
        <div class="p-6 transition-all border group bg-slate-800/50 backdrop-blur-sm border-slate-700/50 rounded-2xl hover:border-emerald-500/50 hover:bg-slate-800/80">
            <div class="flex items-center justify-between mb-4">
                <span class="inline-flex items-center justify-center p-2 bg-emerald-500/10 rounded-xl">
                    <svg class="w-6 h-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </span>
            </div>
            <h3 class="text-sm font-medium text-slate-400">Receitas (Mês)</h3>
            <p class="mt-1 text-2xl font-semibold text-white">R$ 12.450,00</p>
        </div>

        {{-- Monthly Expenses --}}
        <div class="p-6 transition-all border group bg-slate-800/50 backdrop-blur-sm border-slate-700/50 rounded-2xl hover:border-rose-500/50 hover:bg-slate-800/80">
            <div class="flex items-center justify-between mb-4">
                <span class="inline-flex items-center justify-center p-2 bg-rose-500/10 rounded-xl">
                    <svg class="w-6 h-6 text-rose-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6" />
                    </svg>
                </span>
            </div>
            <h3 class="text-sm font-medium text-slate-400">Despesas (Mês)</h3>
            <p class="mt-1 text-2xl font-semibold text-white">R$ 8.120,00</p>
        </div>

        {{-- Savings Goal --}}
        <div class="p-6 transition-all border group bg-slate-800/50 backdrop-blur-sm border-slate-700/50 rounded-2xl hover:border-amber-500/50 hover:bg-slate-800/80">
            <div class="flex items-center justify-between mb-4">
                <span class="inline-flex items-center justify-center p-2 bg-amber-500/10 rounded-xl">
                    <svg class="w-6 h-6 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>
            </div>
            <h3 class="text-sm font-medium text-slate-400">Metas de Reserva</h3>
            <p class="mt-1 text-2xl font-semibold text-white">75%</p>
        </div>
    </div>

    {{-- Main Content Grid --}}
    <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
        {{-- Recent Transactions --}}
        <div class="lg:col-span-2 overflow-hidden border bg-slate-800/50 backdrop-blur-sm border-slate-700/50 rounded-2xl">
            <div class="flex items-center justify-between p-6 border-b border-slate-700/50">
                <h3 class="text-lg font-semibold text-white">Transações Recentes</h3>
                <button class="text-sm font-medium text-indigo-400 hover:text-indigo-300">Ver todas</button>
            </div>
            <div class="divide-y divide-slate-700/50">
                @forelse ([
                    ['name' => 'Supermercado Continental', 'category' => 'Alimentação', 'amount' => -345.20, 'date' => 'Hoje'],
                    ['name' => 'Transferência Recebida', 'category' => 'Receita', 'amount' => 1200.00, 'date' => 'Hoje'],
                    ['name' => 'Assinatura Netflix', 'category' => 'Entretenimento', 'amount' => -55.90, 'date' => 'Ontem'],
                ] as $item)
                    <div class="flex items-center justify-between p-6 transition-colors hover:bg-slate-700/20">
                        <div class="flex items-center gap-4">
                            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-slate-700/50 flex items-center justify-center">
                                <span class="text-lg">{{ $item['amount'] > 0 ? '💰' : '🛒' }}</span>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-white">{{ $item['name'] }}</p>
                                <p class="text-xs text-slate-500">{{ $item['category'] }} • {{ $item['date'] }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-semibold {{ $item['amount'] > 0 ? 'text-emerald-400' : 'text-slate-300' }}">
                                {{ $item['amount'] > 0 ? '+' : '' }}R$ {{ number_format(abs($item['amount']), 2, ',', '.') }}
                            </p>
                        </div>
                    </div>
                @empty
                    <p class="p-6 text-sm text-slate-500 text-center">Nenhuma transação encontrada.</p>
                @endforelse
            </div>
        </div>

        {{-- Quick Actions & Sidebar Info --}}
        <div class="space-y-6">
            {{-- Quick Actions --}}
            <div class="p-6 border bg-slate-800/50 backdrop-blur-sm border-slate-700/50 rounded-2xl">
                <h3 class="mb-4 text-lg font-semibold text-white">Ações Rápidas</h3>
                <div class="grid grid-cols-2 gap-4">
                    <button class="flex flex-col items-center justify-center p-4 transition-all border border-slate-700 rounded-xl hover:bg-indigo-500/10 hover:border-indigo-500/50 group">
                        <svg class="w-6 h-6 mb-2 text-slate-400 group-hover:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span class="text-xs font-medium text-slate-400 group-hover:text-white">Nova Receita</span>
                    </button>
                    <button class="flex flex-col items-center justify-center p-4 transition-all border border-slate-700 rounded-xl hover:bg-rose-500/10 hover:border-rose-500/50 group">
                        <svg class="w-6 h-6 mb-2 text-slate-400 group-hover:text-rose-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                        </svg>
                        <span class="text-xs font-medium text-slate-400 group-hover:text-white">Nova Despesa</span>
                    </button>
                </div>
            </div>

            {{-- Monthly Limit --}}
            <div class="p-6 border bg-slate-800/50 backdrop-blur-sm border-slate-700/50 rounded-2xl">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-semibold text-white">Limite Mensal</h3>
                    <span class="text-xs text-slate-500">65% usado</span>
                </div>
                <div class="w-full h-2 rounded-full bg-slate-700">
                    <div class="h-2 rounded-full bg-indigo-500" style="width: 65%"></div>
                </div>
                <p class="mt-4 text-xs text-slate-500">Você ainda tem R$ 1.200,00 disponíveis para gastos este mês.</p>
            </div>
        </div>
    </div>
</div>
