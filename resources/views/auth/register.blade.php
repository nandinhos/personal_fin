<x-guest-layout>
    <div class="mb-12 text-center relative">
        <div class="absolute -top-10 -right-10 w-32 h-32 bg-purple-500/5 rounded-full blur-3xl -z-10"></div>
        <h1 class="text-4xl font-black text-slate-900 dark:text-white tracking-tight mb-3 glow-text leading-none italic">
            Crie sua<br>
            <span class="text-cyan-400 not-italic">identidade</span>
        </h1>
        <p class="text-slate-500 dark:text-slate-400 text-sm font-medium tracking-tight">Comece sua jornada financeira hoje mesmo</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Nome -->
        <div class="space-y-1.5 group">
            <x-input-label for="name" :value="__('Nome Completo')" class="group-focus-within:text-cyan-400 transition-colors" />
            <div class="relative">
                <div class="absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 dark:text-slate-600 group-focus-within:text-cyan-400 transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <x-text-input id="name" class="pl-12" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Ex: João Silva" />
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Endereço de Email -->
        <div class="space-y-1.5 group">
            <x-input-label for="email" :value="__('Endereço de E-mail')" class="group-focus-within:text-cyan-400 transition-colors" />
            <div class="relative">
                <div class="absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 dark:text-slate-600 group-focus-within:text-cyan-400 transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                    </svg>
                </div>
                <x-text-input id="email" class="pl-12" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="seu@email.com" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Senha -->
        <div class="space-y-1.5 group">
            <x-input-label for="password" :value="__('Senha Segura')" class="group-focus-within:text-cyan-400 transition-colors" />
            <div class="relative">
                <div class="absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 dark:text-slate-600 group-focus-within:text-cyan-400 transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <x-text-input id="password" class="pl-12"
                                type="password"
                                name="password"
                                required autocomplete="new-password" 
                                placeholder="Mínimo 8 caracteres" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirmar Senha -->
        <div class="space-y-1.5 group">
            <x-input-label for="password_confirmation" :value="__('Confirme a Senha')" class="group-focus-within:text-cyan-400 transition-colors" />
            <div class="relative">
                <div class="absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 dark:text-slate-600 group-focus-within:text-cyan-400 transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <x-text-input id="password_confirmation" class="pl-12"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" 
                                placeholder="Repita sua senha" />
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="pt-4">
            <x-primary-button class="py-4 text-xs tracking-[0.2em] shadow-[0_15px_30px_rgba(6,182,212,0.2)]">
                FINALIZAR ACESSO
            </x-primary-button>
        </div>

        <div class="text-center mt-10 pt-10 border-t border-slate-200/50 dark:border-white/5">
            <p class="text-slate-500 dark:text-slate-500 text-[10px] font-black uppercase tracking-[0.3em] mb-4">Já possui identidade?</p>
            <a href="{{ route('login') }}" class="group inline-flex items-center gap-2 text-slate-900 dark:text-white font-black uppercase tracking-widest text-sm hover:text-cyan-400 transition-all">
                <svg class="w-4 h-4 text-cyan-400 group-hover:-translate-x-1 transition-transform rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
                <span>Retornar ao Login</span>
            </a>
        </div>
    </form>
</x-guest-layout>
