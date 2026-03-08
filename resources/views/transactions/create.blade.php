<x-app-layout>
    <div class="space-y-8 max-w-2xl" x-data="{ type: '{{ old('type', 'expense') }}' }">
        <header class="relative">
            <div class="absolute -top-10 -left-10 w-64 h-64 obsidian-glow opacity-20 pointer-events-none"></div>
            <h1 class="text-4xl font-extrabold tracking-tight text-slate-900 dark:text-white glow-text">Nova Transação</h1>
            <p class="mt-2 text-base text-slate-400 font-medium">Registre uma receita, despesa ou transferência.</p>
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

        <form action="{{ route('transactions.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="glass-panel p-8 space-y-6">

                <!-- Tipo -->
                <div class="space-y-2">
                    <x-input-label value="Tipo" />
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                        <label class="cursor-pointer">
                            <input type="radio" name="type" value="expense" x-model="type" class="sr-only" {{ old('type', 'expense') === 'expense' ? 'checked' : '' }}>
                            <div :class="type === 'expense' ? 'border-rose-500 bg-rose-500/10 text-rose-500 dark:text-rose-400' : 'border-black/10 dark:border-white/10 text-slate-600 dark:text-slate-400 hover:border-black/20 dark:hover:border-white/20 bg-black/5 dark:bg-white/5'"
                                class="px-4 py-3 border rounded-xl text-sm font-bold uppercase tracking-widest text-center transition-all">
                                Despesa
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="type" value="income" x-model="type" class="sr-only" {{ old('type') === 'income' ? 'checked' : '' }}>
                            <div :class="type === 'income' ? 'border-emerald-500 bg-emerald-500/10 text-emerald-500 dark:text-emerald-400' : 'border-black/10 dark:border-white/10 text-slate-600 dark:text-slate-400 hover:border-black/20 dark:hover:border-white/20 bg-black/5 dark:bg-white/5'"
                                class="px-4 py-3 border rounded-xl text-sm font-bold uppercase tracking-widest text-center transition-all">
                                Receita
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="type" value="transfer" x-model="type" class="sr-only" {{ old('type') === 'transfer' ? 'checked' : '' }}>
                            <div :class="type === 'transfer' ? 'border-cyan-500 bg-cyan-500/10 text-cyan-500 dark:text-cyan-400' : 'border-black/10 dark:border-white/10 text-slate-600 dark:text-slate-400 hover:border-black/20 dark:hover:border-white/20 bg-black/5 dark:bg-white/5'"
                                class="px-4 py-3 border rounded-xl text-sm font-bold uppercase tracking-widest text-center transition-all">
                                Transf.
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Descrição -->
                <div class="space-y-2">
                    <x-input-label for="description" value="Descrição (opcional)" />
                    <x-text-input type="text" name="description" id="description" :value="old('description')" class="w-full" placeholder="Ex: Mercado, Salário, Aluguel..." />
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <!-- Valor -->
                    <div class="space-y-2">
                        <x-input-label for="amount" value="Valor" />
                        <x-text-input type="number" step="0.01" name="amount" id="amount" :value="old('amount')" class="w-full" placeholder="0,00" required />
                    </div>

                    <!-- Data -->
                    <div class="space-y-2">
                        <x-input-label for="date" value="Data" />
                        <x-text-input type="date" name="date" id="date" :value="old('date', now()->format('Y-m-d'))" class="w-full" required />
                    </div>
                </div>

                <!-- Categoria (oculta para transferência) -->
                <div x-show="type !== 'transfer'" class="space-y-2">
                    <x-input-label for="category_id" value="Categoria" />
                    <select name="category_id" id="category_id" :required="type !== 'transfer'"
                        class="w-full px-4 py-3 bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/5 rounded-xl text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-colors">
                        <option value="">Selecione uma categoria</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Conta de origem -->
                <div class="space-y-2">
                    <x-input-label for="account_id" ::value="type === 'transfer' ? 'Conta de Origem' : 'Conta'" />
                    <select name="account_id" id="account_id" required
                        class="w-full px-4 py-3 bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/5 rounded-xl text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-colors">
                        <option value="">Selecione uma conta</option>
                        @foreach($accounts as $account)
                            <option value="{{ $account->id }}" {{ old('account_id') == $account->id ? 'selected' : '' }}>
                                {{ $account->name }} — R$ {{ number_format($account->balance, 2, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Conta de destino (apenas para transferência) -->
                <div x-show="type === 'transfer'" class="space-y-2">
                    <x-input-label for="to_account_id" value="Conta de Destino" />
                    <select name="to_account_id" id="to_account_id" :required="type === 'transfer'"
                        class="w-full px-4 py-3 bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/5 rounded-xl text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-colors">
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
                    <div x-show="type !== 'transfer'" class="space-y-2">
                        <x-input-label for="card_id" value="Cartão (opcional)" />
                        <select name="card_id" id="card_id"
                            class="w-full px-4 py-3 bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/5 rounded-xl text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-colors">
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

            <div class="flex gap-4">
                <a href="{{ route('transactions.index') }}" class="glass-button flex-1 px-6 py-4 text-center font-bold uppercase tracking-widest text-[11px]">
                    Cancelar
                </a>
                <button type="submit" class="glass-button-primary flex-1 px-6 py-4 font-bold uppercase tracking-widest text-[11px]">
                    Criar Transação
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
