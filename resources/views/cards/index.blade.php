<x-app-layout>
    <div class="space-y-6">
        <header class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold tracking-tight text-white">Cartões</h1>
                <p class="mt-2 text-sm text-slate-400">Gerencie seus cartões de crédito e débito.</p>
            </div>
            <a href="{{ route('cards.create') }}"
                class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl transition-colors inline-flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Novo Cartão
            </a>
        </header>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($cards as $card)
                <div class="relative p-6 border bg-slate-800/50 backdrop-blur-sm border-slate-700/50 rounded-2xl hover:border-indigo-500/50 transition-colors group overflow-hidden">
                    <!-- Glass reflection effect -->
                    <div class="absolute -top-10 -right-10 w-32 h-32 bg-white/5 rounded-full blur-3xl group-hover:bg-white/10 transition-colors"></div>
                    
                    <div class="flex items-start justify-between relative z-10">
                        <div>
                            <p class="text-xs font-semibold text-indigo-400 uppercase tracking-widest">{{ $card->brand ?? 'BANCO' }}</p>
                            <h3 class="text-lg font-bold text-white mt-1">{{ $card->name }}</h3>
                        </div>
                        <div class="text-2xl opacity-80">
                            @if($card->type === 'credit')
                                💳
                            @else
                                🏧
                            @endif
                        </div>
                    </div>

                    <div class="mt-8 relative z-10">
                        <p class="text-slate-500 text-xs font-mono tracking-widest">•••• •••• •••• {{ $card->last_four_digits }}</p>
                        <div class="mt-4 flex justify-between items-end">
                            <div>
                                <p class="text-[10px] text-slate-500 uppercase tracking-tighter">Limite Disponível</p>
                                <p class="text-xl font-bold text-white">R$ {{ number_format($card->limit, 2, ',', '.') }}</p>
                            </div>
                            <span class="text-[10px] px-2 py-0.5 rounded bg-slate-700 text-slate-300 border border-slate-600 uppercase">
                                {{ $card->type === 'credit' ? 'Crédito' : 'Débito' }}
                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full p-12 text-center border bg-slate-800/50 backdrop-blur-sm border-slate-700/50 rounded-2xl">
                    <p class="text-slate-400">Nenhum cartão cadastrado.</p>
                    <a href="{{ route('cards.create') }}" class="mt-4 inline-block text-indigo-400 hover:text-indigo-300">Cadastrar primeiro cartão</a>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
