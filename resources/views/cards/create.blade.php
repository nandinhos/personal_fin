<x-app-layout>
    <div class="space-y-6 max-w-2xl">
        <header class="mb-8">
            <h1 class="text-3xl font-bold tracking-tight text-white">Novo Cartão</h1>
            <p class="mt-2 text-sm text-slate-400">Adicione um novo cartão de crédito ou débito.</p>
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

        <form action="{{ route('cards.store') }}" method="POST" class="space-y-4">
            @csrf

            <div class="p-6 border bg-slate-800/50 backdrop-blur-sm border-slate-700/50 rounded-2xl space-y-4">

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <label for="name" class="block text-sm font-medium text-slate-400 mb-2">Nome do Cartão</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                            class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                            placeholder="Ex: Nubank Roxinho, Itaú Visa">
                    </div>

                    <div>
                        <label for="type" class="block text-sm font-medium text-slate-400 mb-2">Tipo</label>
                        <select name="type" id="type" required
                            class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            <option value="credit" {{ old('type') === 'credit' ? 'selected' : '' }}>Crédito</option>
                            <option value="debit"  {{ old('type') === 'debit'  ? 'selected' : '' }}>Débito</option>
                        </select>
                    </div>

                    <div>
                        <label for="last_four_digits" class="block text-sm font-medium text-slate-400 mb-2">Últimos 4 Dígitos</label>
                        <input type="text" name="last_four_digits" id="last_four_digits" value="{{ old('last_four_digits') }}" required
                            maxlength="4" minlength="4" pattern="\d{4}"
                            class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent font-mono tracking-widest"
                            placeholder="0000">
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label for="limit" class="block text-sm font-medium text-slate-400 mb-2">Limite</label>
                        <input type="number" step="0.01" name="limit" id="limit" value="{{ old('limit', '0.00') }}" required
                            class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                            placeholder="0,00">
                    </div>

                    <div>
                        <label for="brand" class="block text-sm font-medium text-slate-400 mb-2">Bandeira (opcional)</label>
                        <input type="text" name="brand" id="brand" value="{{ old('brand') }}"
                            class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                            placeholder="Ex: Visa, Mastercard, Elo">
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label for="closing_day" class="block text-sm font-medium text-slate-400 mb-2">Dia de Fechamento (opcional)</label>
                        <input type="number" name="closing_day" id="closing_day" value="{{ old('closing_day') }}"
                            min="1" max="31"
                            class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                            placeholder="Ex: 15">
                    </div>

                    <div>
                        <label for="due_day" class="block text-sm font-medium text-slate-400 mb-2">Dia de Vencimento (opcional)</label>
                        <input type="number" name="due_day" id="due_day" value="{{ old('due_day') }}"
                            min="1" max="31"
                            class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                            placeholder="Ex: 22">
                    </div>
                </div>

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
            </div>

            <div class="flex gap-3">
                <a href="{{ route('cards.index') }}"
                    class="flex-1 px-4 py-3 bg-slate-700 hover:bg-slate-600 text-white font-medium rounded-xl transition-colors text-center">
                    Cancelar
                </a>
                <button type="submit"
                    class="flex-1 px-4 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl transition-colors">
                    Criar Cartão
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
