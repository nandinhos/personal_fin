<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-cyan-500/10 rounded-lg border border-cyan-500/20 shadow-[0_0_15px_rgba(6,182,212,0.1)]">
                <svg class="w-6 h-6 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <h2 class="font-bold text-xl text-white leading-tight tracking-tight">
                {{ __('Perfil do Usuário') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <div class="glass-panel p-8 sm:p-10 relative overflow-hidden group shadow-[0_20px_50px_rgba(0,0,0,0.1)] transition-all">
                <div class="absolute -right-8 -top-8 w-32 h-32 bg-cyan-500/5 dark:bg-cyan-500/10 rounded-full blur-3xl group-hover:bg-cyan-500/15 transition-colors duration-500"></div>
                <div class="max-w-xl relative divide-y divide-white/5 dark:divide-slate-200/10">
                    <div class="pb-6 mb-6">
                        <h3 class="text-lg font-black text-slate-900 dark:text-white tracking-tight">Dados Cadastrais</h3>
                        <p class="text-xs text-slate-500 font-bold uppercase tracking-widest mt-1">Identificação e Comunicação</p>
                    </div>
                    <div class="pt-6">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            <div class="glass-panel p-8 sm:p-10 relative overflow-hidden group shadow-[0_20px_50px_rgba(0,0,0,0.1)] transition-all">
                <div class="absolute -right-8 -top-8 w-32 h-32 bg-amber-500/5 dark:bg-amber-500/10 rounded-full blur-3xl group-hover:bg-amber-500/15 transition-colors duration-500"></div>
                <div class="max-w-xl relative divide-y divide-white/5 dark:divide-slate-200/10">
                    <div class="pb-6 mb-6">
                        <h3 class="text-lg font-black text-slate-900 dark:text-white tracking-tight">Segurança</h3>
                        <p class="text-xs text-slate-500 font-bold uppercase tracking-widest mt-1">Alterar senha de acesso</p>
                    </div>
                    <div class="pt-6">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            <div class="glass-panel p-8 sm:p-10 border-red-500/10 dark:border-red-500/20 relative overflow-hidden group shadow-[0_20px_50px_rgba(0,0,0,0.1)] transition-all">
                <div class="absolute -right-8 -top-8 w-32 h-32 bg-red-500/5 dark:bg-red-500/10 rounded-full blur-3xl group-hover:bg-red-500/15 transition-colors duration-500"></div>
                <div class="max-w-xl relative divide-y divide-white/5 dark:divide-slate-200/10">
                    <div class="pb-6 mb-6">
                        <h3 class="text-lg font-black text-red-500 tracking-tight">Área de Perigo</h3>
                        <p class="text-xs text-slate-500 font-bold uppercase tracking-widest mt-1">Exclusão irreversível de conta</p>
                    </div>
                    <div class="pt-6">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

