<x-guest-layout>
    <div class="mb-8 text-center">
        <h1 class="text-2xl font-black text-white tracking-tight mb-4">Recuperar acesso</h1>
        <p class="text-slate-500 text-sm font-medium leading-relaxed">
            Esqueceu sua senha? Sem problemas. Informe seu e-mail e enviaremos um link para você criar uma nova senha.
        </p>
    </div>

    <!-- Sessão de Status da Autenticação -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <!-- Endereço de Email -->
        <div>
            <x-input-label for="email" :value="__('E-mail cadastrado')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus placeholder="seu@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="pt-2">
            <x-primary-button>
                Enviar Link de Recuperação
            </x-primary-button>
        </div>

        <div class="text-center mt-8 pt-8 border-t border-white/5">
            <a href="{{ route('login') }}" class="text-sm font-bold text-slate-500 hover:text-white transition-all">
                Voltar para o Login
            </a>
        </div>
    </form>
</x-guest-layout>
