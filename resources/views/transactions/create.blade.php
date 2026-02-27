<x-app-layout>
    <div class="space-y-6">
        <header class="mb-8">
            <h1 class="text-3xl font-bold tracking-tight text-white">Nova Transação</h1>
            <p class="mt-2 text-sm text-slate-400">Adicione uma nova receita ou despesa.</p>
        </header>

        <form action="{{ route('transactions.store') }}" method="POST" class="space-y-6 max-w-2xl">
            @csrf

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div class="p-6 border bg-slate-800/50 backdrop-blur-sm border-slate-700/50 rounded-2xl">
                    <label class="block text-sm font-medium text-slate-400 mb-2">Tipo</label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="type" value="income" class="text-emerald-500 bg-slate-700 border-slate-600 focus:ring-emerald-500">
                            <span class="text-emerald-400">Receita</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="type" value="expense" class="text-rose-500 bg-slate-700 border-slate-600 focus:ring-rose-500">
                            <span class="text-rose-400">Despesa</span>
                        </label>
                    </div>
                </div>

                <div class="p-6 border bg-slate-800/50 backdrop-blur-sm border-slate-700/50 rounded-2xl">
                    <label for="amount" class="block text-sm font-medium text-slate-400 mb-2">Valor</label>
                    <input type="number" name="amount" id="amount" step="0.01" min="0.01" required
                        class="w-full px-4 py-2 bg-slate-700/50 border border-slate-600 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                </div>

                <div class="p-6 border bg-slate-800/50 backdrop-blur-sm border-slate-700/50 rounded-2xl">
                    <label for="category_id" class="block text-sm font-medium text-slate-400 mb-2">Categoria</label>
                    <select name="category_id" id="category_id" required
                        class="w-full px-4 py-2 bg-slate-700/50 border border-slate-600 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <option value="">Selecione uma categoria</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="p-6 border bg-slate-800/50 backdrop-blur-sm border-slate-700/50 rounded-2xl">
                    <label for="date" class="block text-sm font-medium text-slate-400 mb-2">Data</label>
                    <input type="date" name="date" id="date" required
                        class="w-full px-4 py-2 bg-slate-700/50 border border-slate-600 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                </div>

                <div class="p-6 border bg-slate-800/50 backdrop-blur-sm border-slate-700/50 rounded-2xl">
                    <label for="account_id" class="block text-sm font-medium text-slate-400 mb-2">Conta</label>
                    <select name="account_id" id="account_id"
                        class="w-full px-4 py-2 bg-slate-700/50 border border-slate-600 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <option value="">Selecione uma conta</option>
                        @foreach($accounts as $account)
                            <option value="{{ $account->id }}">{{ $account->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="p-6 border bg-slate-800/50 backdrop-blur-sm border-slate-700/50 rounded-2xl">
                    <label for="card_id" class="block text-sm font-medium text-slate-400 mb-2">Cartão</label>
                    <select name="card_id" id="card_id"
                        class="w-full px-4 py-2 bg-slate-700/50 border border-slate-600 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <option value="">Selecione um cartão</option>
                        @foreach($cards as $card)
                            <option value="{{ $card->id }}">{{ $card->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="p-6 border bg-slate-800/50 backdrop-blur-sm border-slate-700/50 rounded-2xl">
                <label for="description" class="block text-sm font-medium text-slate-400 mb-2">Descrição</label>
                <textarea name="description" id="description" rows="3"
                    class="w-full px-4 py-2 bg-slate-700/50 border border-slate-600 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                    placeholder="Adicione uma descrição opcional..."></textarea>
            </div>

            <div class="flex gap-4">
                <button type="submit"
                    class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl transition-colors">
                    Salvar Transação
                </button>
                <a href="{{ route('transactions.index') }}"
                    class="px-6 py-3 bg-slate-700 hover:bg-slate-600 text-white font-medium rounded-xl transition-colors">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
