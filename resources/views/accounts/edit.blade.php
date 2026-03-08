<x-app-layout>
    <div class="space-y-8 max-w-2xl">
        <header class="relative">
            <div class="absolute -top-10 -left-10 w-64 h-64 obsidian-glow opacity-20 pointer-events-none"></div>
            <h1 class="text-4xl font-extrabold tracking-tight text-slate-900 dark:text-white glow-text">Editar Conta</h1>
            <p class="mt-2 text-base text-slate-400 font-medium">Atualize os dados da sua conta bancária ou carteira.</p>
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

        <form action="{{ route('accounts.update', $account) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="glass-panel p-8 space-y-6">

                <div class="space-y-2">
                    <x-input-label for="name" value="Nome da Conta" />
                    <x-text-input type="text" name="name" id="name" :value="old('name', $account->name)" class="w-full" placeholder="Ex: Nubank, Itaú, Carteira" required />
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div class="space-y-2">
                        <x-input-label for="type" value="Tipo" />
                        <select name="type" id="type" required
                            class="glass-panel w-full px-5 py-3.5 rounded-2xl bg-slate-900/5 dark:bg-black/40 border-slate-200 dark:border-white/5 text-slate-900 dark:text-white focus:border-obsidian-primary focus:ring-1 focus:ring-obsidian-primary transition-all duration-300 placeholder-slate-400 dark:placeholder-slate-500 text-sm font-medium shadow-inner">
                            <option value="checking"   {{ old('type', $account->type) === 'checking'   ? 'selected' : '' }}>Conta Corrente</option>
                            <option value="savings"    {{ old('type', $account->type) === 'savings'    ? 'selected' : '' }}>Poupança</option>
                            <option value="investment" {{ old('type', $account->type) === 'investment' ? 'selected' : '' }}>Investimentos</option>
                            <option value="cash"       {{ old('type', $account->type) === 'cash'       ? 'selected' : '' }}>Dinheiro</option>
                            <option value="other"      {{ old('type', $account->type) === 'other'      ? 'selected' : '' }}>Outro</option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <x-input-label for="balance" value="Saldo" />
                        <x-text-input type="number" step="0.01" name="balance" id="balance" :value="old('balance', $account->balance)" class="w-full" placeholder="0,00" required />
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div class="space-y-2">
                        <x-input-label for="color" value="Cor (opcional)" />
                        <div class="flex items-center gap-3">
                            <input type="color" name="color" id="color" value="{{ old('color', $account->color ?? '#05b7d6') }}"
                                class="w-12 h-12 rounded-xl border border-black/10 dark:border-white/10 cursor-pointer bg-transparent">
                            <x-text-input type="text" name="color_text" :value="old('color', $account->color ?? '#05b7d6')"
                                oninput="document.getElementById('color').value = this.value"
                                class="flex-1" placeholder="#05b7d6" />
                        </div>
                    </div>

                    <div class="space-y-2">
                        <x-input-label for="icon" value="Ícone (opcional)" />
                        <x-text-input type="text" name="icon" id="icon" :value="old('icon', $account->icon)" class="w-full" placeholder="Ex: 💳 🏦" />
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $account->is_active) ? 'checked' : '' }}
                        class="rounded border-slate-300 dark:border-white/10 text-cyan-600 shadow-sm focus:ring-cyan-500">
                    <x-input-label for="is_active" value="Conta Ativa" class="inline" />
                </div>
            </div>

            <div class="flex gap-4">
                <a href="{{ route('accounts.index') }}" class="glass-button flex-1 px-6 py-4 text-center font-bold uppercase tracking-widest text-[11px]">
                    Cancelar
                </a>
                <button type="submit" class="glass-button-primary flex-1 px-6 py-4 font-bold uppercase tracking-widest text-[11px]">
                    Salvar Alterações
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
