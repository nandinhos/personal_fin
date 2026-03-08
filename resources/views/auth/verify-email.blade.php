<x-guest-layout>
    <div class="mb-8 text-center">
        <h1 class="text-2xl font-black text-white tracking-tight mb-4">Verifique seu e-mail</h1>
        <p class="text-slate-500 text-sm font-medium leading-relaxed">
            Obrigado por se cadastrar! Antes de começar, você poderia verificar seu endereço de e-mail clicando no link que acabamos de enviar para você? Se você não recebeu o e-mail, teremos o prazer de enviar outro.
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-6 font-bold text-sm text-obsidian-primary bg-obsidian-primary/10 p-4 rounded-2xl border border-obsidian-primary/20">
            Um novo link de verificação foi enviado para o endereço de e-mail fornecido durante o registro.
        </div>
    @endif

    <div class="mt-8 space-y-4">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <x-primary-button>
                Reenviar E-mail de Verificação
            </x-primary-button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="text-center">
            @csrf

            <button type="submit" class="text-sm font-bold text-slate-500 hover:text-white transition-all uppercase tracking-widest">
                Sair do Sistema
            </button>
        </form>
    </div>
</x-guest-layout>
