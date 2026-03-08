<x-guest-layout>
    <!-- Sessão de Status da Autenticação -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <div class="mb-12 text-center relative">
        <div class="absolute -top-10 -left-10 w-32 h-32 bg-cyan-500/5 rounded-full blur-3xl -z-10"></div>
        <h1 class="text-4xl font-black text-slate-900 dark:text-white tracking-tight mb-3 glow-text leading-none italic">
            Bem-vindo<br>
            <span class="text-cyan-400 not-italic">de volta</span>
        </h1>
        <p class="text-slate-500 dark:text-slate-400 text-sm font-medium tracking-tight">Gerencie sua jornada financeira agora mesmo</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-7">
        @csrf

        <!-- Endereço de Email -->
        <div class="space-y-1.5 group">
            <x-input-label for="email" :value="__('Endereço de E-mail')" class="group-focus-within:text-cyan-400 transition-colors" />
            <div class="relative">
                <div class="absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 dark:text-slate-600 group-focus-within:text-cyan-400 transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                    </svg>
                </div>
                <x-text-input id="email" class="pl-12" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="seu@email.com" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Senha -->
        <div class="space-y-1.5 group">
            <div class="flex items-center justify-between mb-1 px-1">
                <x-input-label for="password" :value="__('Sua Senha')" class="group-focus-within:text-cyan-400 transition-colors mb-0" />
                @if (Route::has('password.request'))
                    <a class="text-[10px] font-black uppercase tracking-widest text-cyan-400 hover:text-white hover:glow-text transition-all" href="{{ route('password.request') }}">
                        Esqueceu?
                    </a>
                @endif
            </div>

            <div class="relative">
                <div class="absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 dark:text-slate-600 group-focus-within:text-cyan-400 transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <x-text-input id="password" class="pl-12"
                                type="password"
                                name="password"
                                required autocomplete="current-password" 
                                placeholder="••••••••" />
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Lembrar-me -->
        <div class="flex items-center px-1">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group select-none">
                <div class="relative flex items-center justify-center">
                    <input id="remember_me" type="checkbox" class="peer appearance-none w-5 h-5 rounded-lg bg-slate-900/5 dark:bg-black/40 border border-slate-200 dark:border-white/10 checked:bg-cyan-500 checked:border-cyan-500 transition-all cursor-pointer shadow-inner" name="remember">
                    <svg class="w-3 h-3 text-white absolute pointer-events-none opacity-0 peer-checked:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <span class="ms-3 text-xs font-black uppercase tracking-widest text-slate-400 group-hover:text-cyan-400 transition-colors">Manter conectado</span>
            </label>
        </div>

        <div class="pt-4">
            <x-primary-button class="py-4 text-xs tracking-[0.2em] shadow-[0_15px_30px_rgba(6,182,212,0.2)]">
                ACESSAR COFRE
            </x-primary-button>
        </div>

        <div class="text-center mt-10 pt-10 border-t border-slate-200/50 dark:border-white/5">
            <p class="text-slate-500 dark:text-slate-500 text-[10px] font-black uppercase tracking-[0.3em] mb-4">Ainda sem acesso?</p>
            <a href="{{ route('register') }}" class="group inline-flex items-center gap-2 text-slate-900 dark:text-white font-black uppercase tracking-widest text-sm hover:text-cyan-400 transition-all">
                <span>Criar Nova Identidade</span>
                <svg class="w-4 h-4 text-cyan-400 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </a>
        </div>
    </form>
</x-guest-layout>
