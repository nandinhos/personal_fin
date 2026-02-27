<x-app-layout>
    <div class="space-y-6">
        <header class="mb-8">
            <h1 class="text-3xl font-bold tracking-tight text-white">Nova Conta</h1>
            <p class="mt-2 text-sm text-slate-400">Adicione uma nova conta bancária ou carteira.</p>
        </header>

        <form action="{{ route('accounts.store') }}" method="POST" class="space-y-6 max-w-2xl">
            @csrf

            <div class="p-6 border bg-slate-800/50 backdrop-blur-sm border-slate-700/50 rounded-2xl">
                <label for="name" class="block text-sm font-medium text-slate-400 mb-2">Nome da Conta</label>
                <input type="text" name="name" id="name" required
                    class="w-full px-4 py-2 bg-slate-700/50 border border-slate-600 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                    placeholder="Ex: Nubank, Itaú, Carteira">
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div class="p-6 border bg-slate-800/50 backdrop-blur-sm border-slate-700/50 rounded-2xl">
                    <label for="type" class="block text-sm font-medium text-slate-400 mb-2">Tipo</label>
                    <select name="type" id="type" required
                        class="w-full px-4 py-2 bg-slate-700/50 border border-slate-600 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <option value="checking">Conta Corrente</option>
                        <option value="savings">Poupança</option>
                        <option value="investment">Investimento</option>
                        <option value="cash">Dinheiro</option>
                        <option value="other">Outro</option>
                    </select>
                </div>

                <div class="p-6 border bg-slate-800/50 backdrop-blur-sm border-slate-700/50 rounded-2xl">
                    <label for="balance" class="block text-sm font-medium text-slate-400 mb-2">Saldo Inicial</label>
                    <input type="number" name="balance" id="balance" step="0.01" required
                        class="w-full px-4 py-2 bg-slate-700/50 border border-slate-600 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        placeholder="0,00">
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div class="p-6 border bg-slate-800/50 backdrop-blur-sm border-slate-700/50 rounded-2xl">
                    <label for="color" class="block text-sm font-medium text-slate-400 mb-2">Cor</label>
                    <input type="color" name="color" id="color" value="#6366f1"
                        class="w-full h-12 bg-slate-700/50 border border-slate-600 rounded-xl cursor-pointer">
                </div>

                <div class="p-6 border bg-slate-800/50 backdrop-blur-sm border-slate-700/50 rounded-2xl">
                    <label for="icon" class="block text-sm font-medium text-slate-400 mb-2">Ícone</label>
                    <input type="text" name="icon" id="icon"
                        class="w-full px-4 py-2 bg-slate-700/50 border border-slate-600 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        placeholder="Ex: 💳">
                </div>
            </div>

            <div class="flex gap-4">
                <button type="submit"
                    class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl transition-colors">
                    Salvar Conta
                </button>
                <a href="{{ route('accounts.index') }}"
                    class="px-6 py-3 bg-slate-700 hover:bg-slate-600 text-white font-medium rounded-xl transition-colors">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
