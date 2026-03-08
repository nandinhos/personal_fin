<x-guest-layout>
    <div class="mb-10 text-center">
        <h1 class="text-3xl font-black text-white tracking-tight mb-2">Nova Senha</h1>
        <p class="text-slate-500 text-sm font-medium">Crie uma nova credencial de acesso segura</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
        @csrf

        <!-- Token de Redefinição de Senha -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Endereço de Email -->
        <div>
            <x-input-label for="email" :value="__('Confirmar E-mail')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Senha -->
        <div>
            <x-input-label for="password" :value="__('Nova Senha')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" placeholder="Mínimo 8 caracteres" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirmar Senha -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirmar Nova Senha')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" placeholder="Repita a nova senha" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="pt-2">
            <x-primary-button>
                Salvar Nova Senha
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
