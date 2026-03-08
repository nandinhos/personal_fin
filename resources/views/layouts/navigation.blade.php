<nav x-data="{ open: false }" class="bg-obsidian-bg/80 backdrop-blur-xl border-b border-white/5 sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center group">
                    <a href="{{ route('dashboard') }}" class="relative">
                        <div class="w-12 h-12 bg-cyan-500/10 rounded-2xl flex items-center justify-center border border-cyan-500/20 shadow-[0_0_20px_rgba(6,182,212,0.1)] group-hover:scale-105 transition-all duration-500 overflow-hidden relative">
                             <div class="absolute inset-0 bg-gradient-to-tr from-cyan-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                             <span class="text-cyan-400 font-black text-xl tracking-tighter relative z-10">PF</span>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-1 sm:-my-px sm:ms-10 sm:flex items-center h-full">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-[11px] font-bold uppercase tracking-[0.2em]">
                        {{ __('Painel') }}
                    </x-nav-link>
                    
                    <x-nav-link :href="route('transactions.index')" :active="request()->routeIs('transactions.index')" class="text-[11px] font-bold uppercase tracking-[0.2em]">
                        {{ __('O Registro') }}
                    </x-nav-link>
                    
                    <x-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.index')" class="text-[11px] font-bold uppercase tracking-[0.2em]">
                        {{ __('Categorias') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <div class="ms-3 relative">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-4 py-2 border border-white/5 text-[11px] leading-4 font-bold rounded-xl text-slate-400 bg-white/5 hover:text-white hover:bg-white/10 hover:border-white/10 focus:outline-none transition-all duration-300 group">
                                <div class="w-2 h-2 rounded-full bg-cyan-500 mr-3 shadow-[0_0_8px_rgba(6,182,212,0.5)]"></div>
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ms-2 opacity-50 group-hover:opacity-100 transition-opacity">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="px-4 py-3 border-b border-white/5 bg-white/[0.02]">
                                <p class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Usuário Autenticado</p>
                                <p class="text-xs font-medium text-white mt-1">{{ Auth::user()->email }}</p>
                            </div>
                            
                            <x-dropdown-link :href="route('profile.edit')" class="text-xs font-bold uppercase tracking-widest py-3">
                                {{ __('Meu Perfil') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();"
                                        class="text-xs font-bold uppercase tracking-widest py-3 text-rose-400 hover:text-rose-300">
                                    {{ __('Encerrar Sessão') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-3 rounded-xl text-slate-400 hover:text-white hover:bg-white/5 focus:outline-none focus:bg-white/10 transition duration-300">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-white/5 bg-obsidian-bg/95 backdrop-blur-2xl">
        <div class="pt-4 pb-3 space-y-1 px-4">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="rounded-xl overflow-hidden mb-2">
                {{ __('Painel Principal') }}
            </x-responsive-nav-link>
            
            <x-responsive-nav-link :href="route('transactions.index')" :active="request()->routeIs('transactions.index')" class="rounded-xl overflow-hidden mb-2">
                {{ __('O Registro') }}
            </x-responsive-nav-link>
            
            <x-responsive-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.index')" class="rounded-xl overflow-hidden mb-2">
                {{ __('Categorias') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-6 pb-6 border-t border-white/5 px-6">
            <div class="flex items-center mb-6">
                <div class="w-10 h-10 rounded-full bg-cyan-500/20 flex items-center justify-center border border-cyan-500/30 text-cyan-400 font-bold">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="ms-4">
                    <div class="font-bold text-sm text-white">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-xs text-slate-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="space-y-2">
                <x-responsive-nav-link :href="route('profile.edit')" class="rounded-xl">
                    {{ __('Configurações do Perfil') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();"
                            class="rounded-xl text-rose-400">
                        {{ __('Sair do Sistema') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>

