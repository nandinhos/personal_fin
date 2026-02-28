<x-app-layout>
    <div class="space-y-6 max-w-2xl">
        <header class="mb-8">
            <h1 class="text-3xl font-bold tracking-tight text-white">Nova Conta</h1>
            <p class="mt-2 text-sm text-slate-400">Adicione uma nova conta bancária ou carteira.</p>
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

        <form action="{{ route('accounts.store') }}" method="POST" class="space-y-4">
            @csrf

            <div class="p-6 border bg-slate-800/50 backdrop-blur-sm border-slate-700/50 rounded-2xl space-y-4">

                <div>
                    <label for="name" class="block text-sm font-medium text-slate-400 mb-2">Nome da Conta</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                        class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        placeholder="Ex: Nubank, Itaú, Carteira">
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label for="type" class="block text-sm font-medium text-slate-400 mb-2">Tipo</label>
                        <select name="type" id="type" required
                            class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            <option value="checking"  {{ old('type') === 'checking'    ? 'selected' : '' }}>Conta Corrente</option>
                            <option value="savings"   {{ old('type') === 'savings'     ? 'selected' : '' }}>Poupança</option>
                            <option value="investment"{{ old('type') === 'investment'  ? 'selected' : '' }}>Investimentos</option>
                            <option value="cash"      {{ old('type') === 'cash'        ? 'selected' : '' }}>Dinheiro</option>
                            <option value="other"     {{ old('type') === 'other'       ? 'selected' : '' }}>Outro</option>
                        </select>
                    </div>

                    <div>
                        <label for="balance" class="block text-sm font-medium text-slate-400 mb-2">Saldo Inicial</label>
                        <input type="number" step="0.01" name="balance" id="balance" value="{{ old('balance', '0.00') }}" required
                            class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                            placeholder="0,00">
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label for="color" class="block text-sm font-medium text-slate-400 mb-2">Cor (opcional)</label>
                        <div class="flex items-center gap-3">
                            <input type="color" name="color" id="color" value="{{ old('color', '#6366f1') }}"
                                class="w-12 h-12 rounded-lg border-0 cursor-pointer bg-transparent">
                            <input type="text" name="color_text" value="{{ old('color', '#6366f1') }}"
                                oninput="document.getElementById('color').value = this.value"
                                class="flex-1 px-4 py-3 bg-slate-700/50 border border-slate-600 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                placeholder="#6366f1">
                        </div>
                    </div>

                    <div>
                        <label for="icon" class="block text-sm font-medium text-slate-400 mb-2">Ícone (opcional)</label>
                        <input type="text" name="icon" id="icon" value="{{ old('icon') }}"
                            class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                            placeholder="Ex: 💳 🏦">
                    </div>
                </div>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('accounts.index') }}"
                    class="flex-1 px-4 py-3 bg-slate-700 hover:bg-slate-600 text-white font-medium rounded-xl transition-colors text-center">
                    Cancelar
                </a>
                <button type="submit"
                    class="flex-1 px-4 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl transition-colors">
                    Criar Conta
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
