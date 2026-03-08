                <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Personal Fin') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">

        <script>
            function applyTheme() {
                if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            }
            applyTheme();
            document.addEventListener('livewire:navigated', applyTheme);
        </script>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="h-full font-manrope antialiased">
        <div x-data="{ sidebarOpen: false, sidebarExpanded: true }" class="min-h-full">
            <!-- Obsidian Bottom Nav (Mobile) -->
            <div class="fixed bottom-6 left-1/2 -translate-x-1/2 z-50 w-[92%] max-w-lg lg:hidden">
                <nav class="glass-panel px-4 py-3 rounded-[2rem] border-white/10 shadow-[0_20px_50px_rgba(0,0,0,0.3)]">
                    <div class="flex justify-around items-center h-12">
                        <a href="{{ route('dashboard') }}" class="flex flex-col items-center justify-center p-2 rounded-xl transition-all {{ request()->routeIs('dashboard') ? 'text-obsidian scale-110' : 'text-slate-500 hover:text-obsidian' }}">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                            </svg>
                        </a>
                        <a href="{{ route('accounts.index') }}" class="flex flex-col items-center justify-center p-2 rounded-xl transition-all {{ request()->routeIs('accounts.*') ? 'text-obsidian scale-110' : 'text-slate-500 hover:text-obsidian' }}">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                            </svg>
                        </a>
                        <!-- Botão Flutuante de Ação Rápida -->
                        <div class="relative -top-6">
                            <button @click="window.location.href='{{ route('transactions.create') }}'" class="w-14 h-14 rounded-full bg-obsidian-primary flex items-center justify-center text-white shadow-[0_0_20px_var(--obsidian-primary-glow)] hover:scale-110 transition-transform">
                                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                                </svg>
                            </button>
                        </div>
                        <a href="{{ route('transactions.index') }}" class="flex flex-col items-center justify-center p-2 rounded-xl transition-all {{ request()->routeIs('transactions.*') ? 'text-obsidian scale-110' : 'text-slate-500 hover:text-obsidian' }}">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </a>
                        <a href="{{ route('profile.edit') }}" class="flex flex-col items-center justify-center p-2 rounded-xl transition-all {{ request()->routeIs('profile.*') ? 'text-obsidian scale-110' : 'text-slate-500 hover:text-obsidian' }}">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 1 1 0-.255c-.007-.378.138-.75.43-.99l1.005-.828" />
                            </svg>
                        </a>
                    </div>
                </nav>
            </div>

            <!-- Desktop Sidebar -->
            <aside 
                x-show="sidebarOpen"
                x-cloak
                x-transition:enter="transition-transform ease-in-out duration-300"
                x-transition:enter-start="-translate-x-full"
                x-transition:enter-end="translate-x-0"
                x-transition:leave="transition-transform ease-in-out duration-300"
                x-transition:leave-start="translate-x-0"
                x-transition:leave-end="-translate-x-full"
                @click.away="sidebarOpen = false"
                class="fixed inset-y-0 left-0 z-50 w-72 glass-panel border-r border-white/5 shadow-2xl lg:hidden"
                style="display: none;">
                @include('layouts.partials.sidebar')
            </aside>

            <!-- Desktop Sidebar (always visible on lg+) -->
            <div class="hidden lg:fixed lg:inset-y-0 lg:z-40 lg:flex lg:flex-col">
                <div 
                    :class="sidebarExpanded ? 'w-72' : 'w-24'"
                    class="flex flex-col h-full glass-panel border-r border-black/5 dark:border-white/5 transition-all duration-300">
                    @include('layouts.partials.sidebar')
                </div>
            </div>

            <!-- Main Content -->
            <div class="lg:pl-72 transition-all duration-300" :class="sidebarExpanded ? 'lg:pl-72' : 'lg:pl-24'">
                <div class="min-h-full">
                    <main class="py-12 pb-32 lg:pb-12">
                        <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
                            {{ $slot }}
                        </div>
                    </main>
                </div>
            </div>
        </div>

        <!-- Obsidian Glass Modal -->
        <div 
            x-data="confirmModal"
            x-show="show"
            x-cloak
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 backdrop-blur-0"
            x-transition:enter-end="opacity-100 backdrop-blur-sm"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 backdrop-blur-sm"
            x-transition:leave-end="opacity-0 backdrop-blur-0"
            @open-confirm-modal.window="open($event.detail.title, $event.detail.message, $event.detail.onConfirm)"
            style="display: none;"
            class="fixed inset-0 z-[100] flex items-center justify-center p-6"
        >
            <div class="absolute inset-0 bg-black/40" @click="close()"></div>
            <div class="relative glass-panel rounded-[2.5rem] w-full max-w-md p-10 border-white/10 shadow-[0_30px_60px_rgba(0,0,0,0.5)]">
                <h2 class="text-2xl font-extrabold text-slate-900 dark:text-white mb-4 tracking-tight" x-text="title"></h2>
                <p class="text-slate-600 dark:text-slate-400 mb-10 text-base font-medium leading-relaxed" x-text="message"></p>
                <div class="flex gap-4">
                    <button 
                        @click="close()"
                        class="flex-1 px-6 py-4 glass-panel border-black/5 dark:border-white/5 hover:bg-black/5 dark:hover:bg-white/5 text-slate-600 dark:text-slate-300 font-bold uppercase tracking-widest text-xs transition-all">
                        Cancelar
                    </button>
                    <button 
                        @click="confirm()"
                        class="flex-1 px-6 py-4 bg-rose-600 hover:bg-rose-700 text-white font-bold uppercase tracking-widest text-xs rounded-2xl shadow-lg shadow-rose-900/20 transition-all">
                        Confirmar
                    </button>
                </div>
            </div>
        </div>
    </body>
    @livewireScripts
</html>
