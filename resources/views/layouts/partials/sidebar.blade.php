<div class="flex flex-col h-full overflow-hidden">
    <!-- Logo / Brand: The Core -->
    <div class="flex items-center justify-between h-24 px-8 border-b border-white/5">
        <div class="flex items-center gap-4" x-show="sidebarExpanded !== false">
            <div class="w-10 h-10 bg-obsidian-primary rounded-2xl flex items-center justify-center shadow-[0_0_15px_var(--obsidian-primary-glow)]">
                <span class="text-white font-black text-xs tracking-tighter">PF</span>
            </div>
            <div class="flex flex-col">
                <span class="text-slate-900 dark:text-white font-extrabold tracking-tight text-lg">Personal Fin</span>
                <span class="text-[10px] text-obsidian font-bold uppercase tracking-[0.2em] opacity-80">Premium OS</span>
            </div>
        </div>
        <!-- Toggle Button (Desktop) -->
        <button 
            @click="sidebarExpanded = !sidebarExpanded"
            class="hidden lg:flex items-center justify-center w-10 h-10 text-slate-500 hover:text-slate-900 dark:hover:text-white rounded-xl hover:bg-black/5 dark:hover:bg-white/5 transition-all">
            <svg class="w-6 h-6 transition-transform duration-500" :class="sidebarExpanded ? 'rotate-0' : 'rotate-180'" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
            </svg>
        </button>
        <!-- Close Button (Mobile) -->
        <button 
            @click="sidebarOpen = false"
            class="lg:hidden flex items-center justify-center w-10 h-10 text-slate-500 hover:text-slate-900 dark:hover:text-white rounded-xl hover:bg-black/5 dark:hover:bg-white/5">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Navigation: The Grid -->
    <nav class="flex-1 px-4 py-8 space-y-2 overflow-y-auto scrollbar-hide">
        @php
            $navItems = [
                ['route' => 'dashboard', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', 'label' => 'Painel'],
                ['route' => 'accounts.index', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'label' => 'Minhas Contas'],
                ['route' => 'cards.index', 'icon' => 'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z', 'label' => 'Cartões'],
                ['route' => 'transactions.index', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01', 'label' => 'Extrato'],
                ['route' => 'categories.manager', 'icon' => 'M7 7h.01M7 11h.01M7 15h.01M11 7h.01M11 11h.01M11 15h.01M15 7h.01M15 11h.01M15 15h.01', 'label' => 'Categorias'],
            ];
        @endphp

        @foreach($navItems as $item)
            @php
                $activePattern = str_replace('.index', '', $item['route']) . '*';
            @endphp
            <a href="{{ route($item['route']) }}" 
                class="group flex items-center gap-4 px-4 py-3.5 rounded-2xl transition-all duration-300 {{ request()->routeIs($activePattern) ? 'bg-black/5 dark:bg-white/10 text-obsidian shadow-lg shadow-black/10' : 'text-slate-500 hover:bg-black/5 dark:hover:bg-white/5 hover:text-slate-900 dark:hover:text-white' }}">
                <svg class="w-6 h-6 flex-shrink-0 transition-transform group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" />
                </svg>
                <span x-show="sidebarExpanded !== false" class="font-bold text-sm tracking-tight">{{ $item['label'] }}</span>
            </a>
        @endforeach
    </nav>

    <!-- User & Settings: The Identity -->
    <div class="p-6 mt-auto border-t border-black/5 dark:border-white/5" x-data="{ userMenuOpen: false }">
        <div class="relative">
            <button 
                @click="userMenuOpen = !userMenuOpen"
                class="glass-card-premium flex items-center gap-4 w-full p-3 group border-white/10">
                <div class="w-10 h-10 bg-obsidian-primary/20 border border-obsidian-primary/30 rounded-full flex items-center justify-center shrink-0">
                    <span class="text-obsidian font-bold text-sm">{{ substr(Auth::user()->name ?? 'U', 0, 1) }}</span>
                </div>
                <div x-show="sidebarExpanded !== false" class="flex-1 min-w-0 text-left">
                    <p class="text-sm font-bold text-slate-900 dark:text-white truncate">{{ Auth::user()->name ?? 'Usuário' }}</p>
                    <p class="text-[10px] text-slate-500 font-medium truncate uppercase tracking-widest">Perfil Ativo</p>
                </div>
                <svg x-show="sidebarExpanded !== false" class="w-4 h-4 text-slate-500 group-hover:text-slate-900 dark:group-hover:text-white transition-transform duration-200" :class="userMenuOpen ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <!-- User Dropdown: The Portal -->
            <div 
                x-show="userMenuOpen" 
                x-cloak
                @click.away="userMenuOpen = false"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-2"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-2"
                class="absolute bottom-full left-0 w-full mb-4 glass-panel border border-white/10 rounded-2xl shadow-2xl z-50 overflow-hidden">
                <div class="p-2 space-y-1">
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 text-sm text-slate-600 dark:text-slate-300 hover:bg-black/5 dark:hover:bg-white/5 hover:text-slate-900 dark:hover:text-white rounded-xl transition-all">
                        <svg class="w-4 h-4 text-obsidian" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Configurações
                    </a>
                    
                    <button 
                        @click="document.documentElement.classList.toggle('dark'); localStorage.setItem('theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light')"
                        class="flex w-full items-center gap-3 px-4 py-3 text-sm text-slate-600 dark:text-slate-300 hover:bg-black/5 dark:hover:bg-white/5 hover:text-slate-900 dark:hover:text-white rounded-xl transition-all">
                        <svg class="w-4 h-4 text-obsidian" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                        Alternar Tema
                    </button>

                    <div class="h-px bg-black/5 dark:bg-white/5 mx-2 my-2"></div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex w-full items-center gap-3 px-4 py-3 text-sm text-rose-400 hover:bg-rose-500/10 hover:text-rose-300 rounded-xl transition-all font-bold">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Encerrar Sessão
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
