<x-app-layout>
    <div class="space-y-6">
        <header class="mb-8">
            <h1 class="text-3xl font-bold tracking-tight text-white">Novo Cartão</h1>
            <p class="mt-2 text-sm text-slate-400">Adicione um novo cartão de crédito ou débito.</p>
        </header>

        <form action="{{ route('cards.store') }}" method="POST" class="space-y-6 max-w-2xl">
            @csrf

            <div class="p-6 border bg-slate-800/50 backdrop-blur-sm border-slate-700/50 rounded-2xl">
                <label for="name" class="block text-sm font-medium text-slate-400 mb-2">Nome do Cartão (Apelido)</label>
                <input type="text" name="name" id="name" required
                    class="w-full px-4 py-2 bg-slate-700/50 border border-slate-600 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                    placeholder="Ex: Nubank, Inter Gold, Cartão Black">
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div class="p-6 border bg-slate-800/50 backdrop-blur-sm border-slate-700/50 rounded-2xl">
                    <label for="type" class="block text-sm font-medium text-slate-400 mb-2">Tipo</label>
                    <select name="type" id="type" required
                        class="w-full px-4 py-2 bg-slate-700/50 border border-slate-600 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <option value="credit">Crédito</option>
                        <option value="debit">Débito</option>
                    </select>
                </div>

                <div class="p-6 border bg-slate-800/50 backdrop-blur-sm border-slate-700/50 rounded-2xl">
                    <label for="brand" class="block text-sm font-medium text-slate-400 mb-2">Bandeira / Banco</label>
                    <input type="text" name="brand" id="brand"
                        class="w-full px-4 py-2 bg-slate-700/50 border border-slate-600 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        placeholder="Ex: Visa, Mastercard, Nubank">
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div class="p-6 border bg-slate-800/50 backdrop-blur-sm border-slate-700/50 rounded-2xl">
                    <label for="last_four_digits" class="block text-sm font-medium text-slate-400 mb-2">Últimos 4 Dígitos</label>
                    <input type="text" name="last_four_digits" id="last_four_digits" maxlength="4" minlength="4" required
                        class="w-full px-4 py-2 bg-slate-700/50 border border-slate-600 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        placeholder="1234">
                </div>

                <div class="p-6 border bg-slate-800/50 backdrop-blur-sm border-slate-700/50 rounded-2xl">
                    <label for="limit" class="block text-sm font-medium text-slate-400 mb-2">Limite</label>
                    <input type="number" name="limit" id="limit" step="0.01" required
                        class="w-full px-4 py-2 bg-slate-700/50 border border-slate-600 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        placeholder="0,00">
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div class="p-6 border bg-slate-800/50 backdrop-blur-sm border-slate-700/50 rounded-2xl">
                    <label for="closing_day" class="block text-sm font-medium text-slate-400 mb-2">Dia do Fechamento</label>
                    <input type="number" name="closing_day" id="closing_day" min="1" max="31"
                        class="w-full px-4 py-2 bg-slate-700/50 border border-slate-600 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        placeholder="Ex: 5">
                </div>

                <div class="p-6 border bg-slate-800/50 backdrop-blur-sm border-slate-700/50 rounded-2xl">
                    <label for="due_day" class="block text-sm font-medium text-slate-400 mb-2">Dia do Vencimento</label>
                    <input type="number" name="due_day" id="due_day" min="1" max="31"
                        class="w-full px-4 py-2 bg-slate-700/50 border border-slate-600 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        placeholder="Ex: 12">
                </div>
            </div>

            <div class="flex gap-4">
                <button type="submit"
                    class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl transition-colors">
                    Salvar Cartão
                </button>
                <a href="{{ route('cards.index') }}"
                    class="px-6 py-3 bg-slate-700 hover:bg-slate-600 text-white font-medium rounded-xl transition-colors">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
