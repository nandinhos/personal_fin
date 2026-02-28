<x-app-layout>
    <div class="space-y-6">
        <header class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold tracking-tight text-white">Contas</h1>
                <p class="mt-2 text-sm text-slate-400">Gerencie suas contas bancárias e carteiras.</p>
            </div>
            <a href="{{ route('accounts.create') }}"
                class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl transition-colors inline-flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Nova Conta
            </a>
        </header>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($accounts as $account)
                <div class="p-6 border bg-slate-800/50 backdrop-blur-sm border-slate-700/50 rounded-2xl hover:border-indigo-500/50 transition-colors">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-white">{{ $account->name }}</h3>
                            <p class="text-sm text-slate-400">{{ ucfirst($account->type) }}</p>
                        </div>
                        <span class="text-2xl">{{ $account->icon ?? '💳' }}</span>
                    </div>
                    <p class="mt-4 text-2xl font-bold text-white">R$ {{ number_format($account->balance, 2, ',', '.') }}</p>
                </div>
            @empty
                <div class="col-span-full p-12 text-center border bg-slate-800/50 backdrop-blur-sm border-slate-700/50 rounded-2xl">
                    <p class="text-slate-400">Nenhuma conta cadastrada.</p>
                    <a href="{{ route('accounts.create') }}" class="mt-4 inline-block text-indigo-400 hover:text-indigo-300">Criar primeira conta</a>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
