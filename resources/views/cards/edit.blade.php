<x-app-layout>
    <div class="space-y-8 max-w-2xl">
        <header class="relative">
            <div class="absolute -top-10 -left-10 w-64 h-64 obsidian-glow opacity-20 pointer-events-none"></div>
            <h1 class="text-4xl font-extrabold tracking-tight text-slate-900 dark:text-white glow-text">Editar Cartão</h1>
            <p class="mt-2 text-base text-slate-400 font-medium">Atualize os dados do seu cartão de crédito ou débito.</p>
        </header>

        @if($errors->any())
            <div class="glass-panel p-4 border-rose-500/30 bg-rose-500/5 text-sm text-rose-500 dark:text-rose-400">
                <ul class="space-y-1 list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('cards.update', $card) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="glass-panel p-8 space-y-6">

                <div class="sm:col-span-2 space-y-2">
                    <x-input-label for="name" value="Nome do Cartão" />
                    <x-text-input type="text" name="name" id="name" :value="old('name', $card->name)" class="w-full" placeholder="Ex: Nubank Roxinho, Itaú Visa" required />
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div class="space-y-2">
                        <x-input-label for="type" value="Tipo" />
                        <select name="type" id="type" required
                            class="glass-panel w-full px-5 py-3.5 rounded-2xl bg-slate-900/5 dark:bg-black/40 border-slate-200 dark:border-white/5 text-slate-900 dark:text-white focus:border-obsidian-primary focus:ring-1 focus:ring-obsidian-primary transition-all duration-300 placeholder-slate-400 dark:placeholder-slate-500 text-sm font-medium shadow-inner">
                            <option value="credit" {{ old('type', $card->type) === 'credit' ? 'selected' : '' }}>Crédito</option>
                            <option value="debit"  {{ old('type', $card->type) === 'debit'  ? 'selected' : '' }}>Débito</option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <x-input-label for="last_four_digits" value="Últimos 4 Dígitos" />
                        <x-text-input type="text" name="last_four_digits" id="last_four_digits" :value="old('last_four_digits', $card->last_four_digits)"
                            maxlength="4" minlength="4" pattern="\d{4}"
                            class="w-full font-mono tracking-widest" placeholder="0000" required />
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div class="space-y-2">
                        <x-input-label for="limit" value="Limite" />
                        <x-text-input type="number" step="0.01" name="limit" id="limit" :value="old('limit', $card->limit)" class="w-full" placeholder="0,00" required />
                    </div>

                    <div class="space-y-2">
                        <x-input-label for="brand" value="Bandeira (opcional)" />
                        <x-text-input type="text" name="brand" id="brand" :value="old('brand', $card->brand)" class="w-full" placeholder="Ex: Visa, Mastercard, Elo" />
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div class="space-y-2">
                        <x-input-label for="closing_day" value="Dia de Fechamento (opcional)" />
                        <x-text-input type="number" name="closing_day" id="closing_day" :value="old('closing_day', $card->closing_day)" min="1" max="31" class="w-full" placeholder="Ex: 15" />
                    </div>

                    <div class="space-y-2">
                        <x-input-label for="due_day" value="Dia de Vencimento (opcional)" />
                        <x-text-input type="number" name="due_day" id="due_day" :value="old('due_day', $card->due_day)" min="1" max="31" class="w-full" placeholder="Ex: 22" />
                    </div>
                </div>

                <div class="space-y-2">
                    <x-input-label for="color" value="Cor (opcional)" />
                    <div class="flex items-center gap-3">
                        <input type="color" name="color" id="color" value="{{ old('color', $card->color ?? '#05b7d6') }}"
                            class="w-12 h-12 rounded-xl border border-black/10 dark:border-white/10 cursor-pointer bg-transparent">
                        <x-text-input type="text" name="color_text" :value="old('color', $card->color ?? '#05b7d6')"
                            oninput="document.getElementById('color').value = this.value"
                            class="flex-1" placeholder="#05b7d6" />
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $card->is_active) ? 'checked' : '' }}
                        class="rounded border-slate-300 dark:border-white/10 text-cyan-600 shadow-sm focus:ring-cyan-500">
                    <x-input-label for="is_active" value="Cartão Ativo" class="inline" />
                </div>
            </div>

            <div class="flex gap-4">
                <a href="{{ route('cards.index') }}" class="glass-button flex-1 px-6 py-4 text-center font-bold uppercase tracking-widest text-[11px]">
                    Cancelar
                </a>
                <button type="submit" class="glass-button-primary flex-1 px-6 py-4 font-bold uppercase tracking-widest text-[11px]">
                    Salvar Alterações
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
