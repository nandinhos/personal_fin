<div class="flex flex-col flex-1 min-h-0">
    <!-- Logo / Brand -->
    <div class="flex items-center justify-between h-16 px-4 border-b border-slate-800">
        <div class="flex items-center gap-3" x-show="sidebarExpanded !== false">
            <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center">
                <span class="text-white font-bold text-sm">PF</span>
            </div>
            <span class="text-white font-semibold">Personal Fin</span>
        </div>
        <!-- Toggle Button (Desktop) -->
        <button 
            @click="sidebarExpanded = !sidebarExpanded"
            class="hidden lg:flex items-center justify-center w-8 h-8 text-slate-400 hover:text-white rounded-lg hover:bg-slate-800 transition-colors">
            <svg class="w-5 h-5 transition-transform" :class="sidebarExpanded ? 'rotate-0' : 'rotate-180'" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
            </svg>
        </button>
        <!-- Close Button (Mobile) -->
        <button 
            @click="sidebarOpen = false"
            class="lg:hidden flex items-center justify-center w-8 h-8 text-slate-400 hover:text-white rounded-lg hover:bg-slate-800">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
        <a href="{{ route('dashboard') }}" 
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('dashboard') ? 'bg-indigo-600/10 text-indigo-400' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
            <svg class="w-6 h-6 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
            </svg>
            <span x-show="sidebarExpanded !== false" class="font-medium">Dashboard</span>
        </a>

        <a href="{{ route('accounts.index') }}" 
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('accounts.*') ? 'bg-indigo-600/10 text-indigo-400' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
            <svg class="w-6 h-6 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
            </svg>
            <span x-show="sidebarExpanded !== false" class="font-medium">Contas</span>
        </a>

        <a href="{{ route('transactions.index') }}" 
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('transactions.*') ? 'bg-indigo-600/10 text-indigo-400' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
            <svg class="w-6 h-6 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
            <span x-show="sidebarExpanded !== false" class="font-medium">Transações</span>
        </a>

        <a href="#" 
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors text-slate-400 hover:bg-slate-800 hover:text-white">
            <svg class="w-6 h-6 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
            </svg>
            <span x-show="sidebarExpanded !== false" class="font-medium">Relatórios</span>
        </a>

        <div class="pt-4 mt-4 border-t border-slate-800">
            <a href="{{ route('profile.edit') }}" 
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('profile.*') ? 'bg-indigo-600/10 text-indigo-400' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-6 h-6 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 1 1 0-.255c-.007-.378.138-.75.43-.99l1.005-.828c.242-.127.451-.346.581-.61.13-.266.16-.577.16-.827 0-.224-.033-.447-.097-.661l-1.331-1.741a1.125 1.125 0 0 1-.515-.91l-.846-1.123c-.13-.185-.334-.303-.534-.404l-.224-.051c-.336-.063-.535-.4-.535-.827V4.077c0-.338.183-.65.467-.849l1.267-.977a2.335 2.335 0 0 1 1.544-.003Z" />
                </svg>
                <span x-show="sidebarExpanded !== false" class="font-medium">Configurações</span>
            </a>
        </div>
    </nav>

    <!-- User Info -->
    <div class="border-t border-slate-800 p-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-slate-700 rounded-full flex items-center justify-center">
                <span class="text-white font-medium">{{ substr(Auth::user()->name ?? 'U', 0, 1) }}</span>
            </div>
            <div x-show="sidebarExpanded !== false" class="flex-1 min-w-0">
                <p class="text-sm font-medium text-white truncate">{{ Auth::user()->name ?? 'Usuário' }}</p>
                <p class="text-xs text-slate-500 truncate">{{ Auth::user()->email ?? '' }}</p>
            </div>
        </div>
    </div>
</div>
