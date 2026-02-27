<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-white">Contas</h2>
                        <a href="{{ route('accounts.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                            + Nova Conta
                        </a>
                    </div>

                    @forelse($accounts as $account)
                        <div class="p-6 bg-slate-700/50 rounded-xl border border-slate-600 mb-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-lg font-semibold text-white">{{ $account->name }}</h3>
                                    <p class="text-sm text-slate-400">{{ ucfirst($account->type) }}</p>
                                </div>
                            </div>
                            <p class="mt-4 text-2xl font-bold text-white">R$ {{ number_format($account->balance, 2, ',', '.') }}</p>
                        </div>
                    @empty
                        <p class="text-slate-400 text-center py-8">Nenhuma conta cadastrada.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
