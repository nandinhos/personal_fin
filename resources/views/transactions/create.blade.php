<x-app-layout>
    <div class="space-y-6 max-w-2xl" x-data="{ type: '{{ old('type', 'expense') }}' }">
        <header class="mb-8">
            <h1 class="text-3xl font-bold tracking-tight text-white">Nova Transação</h1>
            <p class="mt-2 text-sm text-slate-400">Registre uma receita, despesa ou transferência.</p>
        </header>

        @if($errors->any())
            <div class="p-4 bg-rose-500/10 border border-rose-500/30 rounded-xl text-sm text-rose-400">
                <ul class="space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('transactions.store') }}" method="POST" class="space-y-4">
            @csrf

            <div class="p-6 border bg-slate-800/50 backdrop-blur-sm border-slate-700/50 rounded-2xl space-y-4">

                <!-- Tipo -->
                <div>
                    <label class="block text-sm font-medium text-slate-400 mb-2">Tipo</label>
                    <div class="grid grid-cols-3 gap-2">
                        <label class="cursor-pointer">
                            <input type="radio" name="type" value="expense" x-model="type" class="sr-only" {{ old('type', 'expense') === 'expense' ? 'checked' : '' }}>
                            <div :class="type === 'expense' ? 'border-rose-500 bg-rose-500/10 text-rose-400' : 'border-slate-600 text-slate-400 hover:border-slate-500'"
                                class="px-4 py-3 border rounded-xl text-sm font-medium text-center transition-colors">
                                Despesa
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="type" value="income" x-model="type" class="sr-only" {{ old('type') === 'income' ? 'checked' : '' }}>
                            <div :class="type === 'income' ? 'border-emerald-500 bg-emerald-500/10 text-emerald-400' : 'border-slate-600 text-slate-400 hover:border-slate-500'"
                                class="px-4 py-3 border rounded-xl text-sm font-medium text-center transition-colors">
                                Receita
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="type" value="transfer" x-model="type" class="sr-only" {{ old('type') === 'transfer' ? 'checked' : '' }}>
                            <div :class="type === 'transfer' ? 'border-indigo-500 bg-indigo-500/10 text-indigo-400' : 'border-slate-600 text-slate-400 hover:border-slate-500'"
                                class="px-4 py-3 border rounded-xl text-sm font-medium text-center transition-colors">
                                Transferência
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Descrição -->
                <div>
                    <label for="description" class="block text-sm font-medium text-slate-400 mb-2">Descrição (opcional)</label>
                    <input type="text" name="description" id="description" value="{{ old('description') }}"
                        class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        placeholder="Ex: Mercado, Salário, Aluguel...">
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <!-- Valor -->
                    <div>
                        <label for="amount" class="block text-sm font-medium text-slate-400 mb-2">Valor</label>
                        <input type="number" step="0.01" name="amount" id="amount" value="{{ old('amount') }}" required
                            class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                            placeholder="0,00">
                    </div>

                    <!-- Data -->
                    <div>
                        <label for="date" class="block text-sm font-medium text-slate-400 mb-2">Data</label>
                        <input type="date" name="date" id="date" value="{{ old('date', now()->format('Y-m-d')) }}" required
                            class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    </div>
                </div>

                <!-- Categoria (oculta para transferência) -->
                <div x-show="type !== 'transfer'">
                    <label for="category_id" class="block text-sm font-medium text-slate-400 mb-2">Categoria</label>
                    <select name="category_id" id="category_id" :required="type !== 'transfer'"
                        class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <option value="">Selecione uma categoria</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Conta de origem -->
                <div>
                    <label for="account_id" class="block text-sm font-medium text-slate-400 mb-2"
                        x-text="type === 'transfer' ? 'Conta de Origem' : 'Conta'"></label>
                    <select name="account_id" id="account_id"
                        class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <option value="">Selecione uma conta</option>
                        @foreach($accounts as $account)
                            <option value="{{ $account->id }}" {{ old('account_id') == $account->id ? 'selected' : '' }}>
                                {{ $account->name }} — R$ {{ number_format($account->balance, 2, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Conta de destino (apenas para transferência) -->
                <div x-show="type === 'transfer'">
                    <label for="to_account_id" class="block text-sm font-medium text-slate-400 mb-2">Conta de Destino</label>
                    <select name="to_account_id" id="to_account_id" :required="type === 'transfer'"
                        class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <option value="">Selecione a conta de destino</option>
                        @foreach($accounts as $account)
                            <option value="{{ $account->id }}" {{ old('to_account_id') == $account->id ? 'selected' : '' }}>
                                {{ $account->name }} — R$ {{ number_format($account->balance, 2, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Cartão (opcional, não aparece em transferências) -->
                @if($cards->isNotEmpty())
                    <div x-show="type !== 'transfer'">
                        <label for="card_id" class="block text-sm font-medium text-slate-400 mb-2">Cartão (opcional)</label>
                        <select name="card_id" id="card_id"
                            class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            <option value="">Nenhum cartão</option>
                            @foreach($cards as $card)
                                <option value="{{ $card->id }}" {{ old('card_id') == $card->id ? 'selected' : '' }}>
                                    {{ $card->name }} •••• {{ $card->last_four_digits }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif
            </div>

            <div class="flex gap-3">
                <a href="{{ route('transactions.index') }}"
                    class="flex-1 px-4 py-3 bg-slate-700 hover:bg-slate-600 text-white font-medium rounded-xl transition-colors text-center">
                    Cancelar
                </a>
                <button type="submit"
                    class="flex-1 px-4 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl transition-colors">
                    Criar Transação
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
