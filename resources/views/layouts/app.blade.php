                <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Personal Fin') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

        <script>
            if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="h-full font-sans antialiased bg-slate-900 text-slate-200">
        <div x-data="{ sidebarOpen: false, sidebarExpanded: true }" class="min-h-full">
            <!-- Mobile Bottom Navigation -->
            <nav class="fixed bottom-0 left-0 right-0 z-50 border-t bg-slate-900/95 backdrop-blur-lg border-slate-800 lg:hidden">
                <div class="flex justify-around items-center h-16 max-w-lg mx-auto">
                    <a href="{{ route('dashboard') }}" class="flex flex-col items-center justify-center w-16 h-full {{ request()->routeIs('dashboard') ? 'text-indigo-400' : 'text-slate-400 hover:text-indigo-400' }}">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                        <span class="text-xs mt-1">Home</span>
                    </a>
                    <a href="{{ route('accounts.index') }}" class="flex flex-col items-center justify-center w-16 h-full {{ request()->routeIs('accounts.*') ? 'text-indigo-400' : 'text-slate-400 hover:text-indigo-400' }}">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                        </svg>
                        <span class="text-[10px] mt-1">Contas</span>
                    </a>
                    <a href="{{ route('cards.index') }}" class="flex flex-col items-center justify-center w-16 h-full {{ request()->routeIs('cards.*') ? 'text-indigo-400' : 'text-slate-400 hover:text-indigo-400' }}">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75-6.15a.48.48 0 0 0-.245.088A.477.477 0 0 0 4.5 10.5v1.125c0 .414.336.75.75.75h1.125V13.5h0c0 .414.336.75.75.75H8.25v2.25h.375a1.125 1.125 0 0 1 1.125 1.125V18.75m-3.75-10.5h15c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-15a1.125 1.125 0 0 1-1.125-1.125v-9.75c0-.621.504-1.125 1.125-1.125Z" />
                        </svg>
                        <span class="text-[10px] mt-1">Cartões</span>
                    </a>
                    <a href="{{ route('transactions.index') }}" class="flex flex-col items-center justify-center w-16 h-full {{ request()->routeIs('transactions.*') ? 'text-indigo-400' : 'text-slate-400 hover:text-indigo-400' }}">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <span class="text-[10px] mt-1">Gastos</span>
                    </a>
                    <a href="{{ route('categories.manager') }}" class="flex flex-col items-center justify-center w-16 h-full {{ request()->routeIs('categories.*') ? 'text-indigo-400' : 'text-slate-400 hover:text-indigo-400' }}">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-8.69-6.44-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
                        </svg>
                        <span class="text-[10px] mt-1">Categorias</span>
                    </a>
                    <a href="#" class="flex flex-col items-center justify-center w-16 h-full text-slate-400 hover:text-indigo-400">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                        </svg>
                        <span class="text-xs mt-1">Relatórios</span>
                    </a>
                    <a href="{{ route('profile.edit') }}" class="flex flex-col items-center justify-center w-16 h-full {{ request()->routeIs('profile.*') ? 'text-indigo-400' : 'text-slate-400 hover:text-indigo-400' }}">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 1 1 0-.255c-.007-.378.138-.75.43-.99l1.005-.828c.242-.127.451-.346.581-.61.13-.266.16-.577.16-.827 0-.224-.033-.447-.097-.661l-1.331-1.741a1.125 1.125 0 0 1-.515-.91l-.846-1.123c-.13-.185-.334-.303-.534-.404l-.224-.051c-.336-.063-.535-.4-.535-.827V4.077c0-.338.183-.65.467-.849l1.267-.977a2.335 2.335 0 0 1 1.544-.003Z" />
                        </svg>
                        <span class="text-xs mt-1">Ajustes</span>
                    </a>
                </div>
            </nav>

            <!-- Desktop Sidebar -->
            <aside 
                x-show="sidebarOpen"
                x-transition:enter="transition-transform ease-in-out duration-300"
                x-transition:enter-start="-translate-x-full"
                x-transition:enter-end="translate-x-0"
                x-transition:leave="transition-transform ease-in-out duration-300"
                x-transition:leave-start="translate-x-0"
                x-transition:leave-end="-translate-x-full"
                @click.away="sidebarOpen = false"
                class="fixed inset-y-0 left-0 z-50 w-64 bg-slate-900 border-r border-slate-800 transform lg:hidden"
                style="display: none;">
                @include('layouts.partials.sidebar')
            </aside>

            <!-- Desktop Sidebar (always visible on lg+) -->
            <div class="hidden lg:fixed lg:inset-y-0 lg:z-40 lg:flex lg:flex-col">
                <div 
                    :class="sidebarExpanded ? 'w-64' : 'w-20'"
                    class="flex flex-col h-full bg-slate-900 border-r border-slate-800 transition-all duration-300">
                    @include('layouts.partials.sidebar')
                </div>
            </div>

            <!-- Main Content -->
            <div class="lg:pl-64 transition-all duration-300" :class="sidebarExpanded ? 'lg:pl-64' : 'lg:pl-20'">
                <div class="min-h-full">
                    <main class="pb-24 lg:pb-8">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                            {{ $slot }}
                        </div>
                    </main>
                </div>
            </div>
        </div>

        <!-- Confirm Modal Alpine.js -->
        <div 
            x-data="confirmModal"
            x-show="show"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @open-confirm-modal.window="open($event.detail.title, $event.detail.message, $event.detail.onConfirm)"
            style="display: none;"
            class="fixed inset-0 z-[100] flex items-center justify-center p-4"
        >
            <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="close()"></div>
            <div class="relative bg-slate-800 border border-slate-700 rounded-2xl w-full max-w-sm p-6 shadow-2xl">
                <h2 class="text-xl font-semibold text-white mb-2" x-text="title"></h2>
                <p class="text-slate-400 mb-6" x-text="message"></p>
                <div class="flex gap-3">
                    <button 
                        @click="close()"
                        class="flex-1 px-4 py-3 bg-slate-700 hover:bg-slate-600 text-white font-medium rounded-xl transition-colors">
                        Cancelar
                    </button>
                    <button 
                        @click="confirm()"
                        class="flex-1 px-4 py-3 bg-rose-600 hover:bg-rose-700 text-white font-medium rounded-xl transition-colors">
                        Excluir
                    </button>
                </div>
            </div>
        </div>
    </body>
    @livewireScripts
</html>
