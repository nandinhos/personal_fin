<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-manrope antialiased bg-obsidian-bg text-obsidian-text overflow-x-hidden">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative">
            <!-- Background Decorative Elements -->
            <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none -z-10">
                <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] bg-cyan-500/10 rounded-full blur-[120px]"></div>
                <div class="absolute top-[60%] -right-[10%] w-[35%] h-[45%] bg-purple-500/5 rounded-full blur-[100px]"></div>
            </div>

            <div class="mb-10 relative group">
                <a href="/" wire:navigate class="block">
                    <div class="w-24 h-24 bg-cyan-500/10 rounded-[2.5rem] flex items-center justify-center border border-cyan-500/20 shadow-[0_0_40px_rgba(6,182,212,0.15)] group-hover:scale-110 group-hover:shadow-[0_0_60px_rgba(6,182,212,0.3)] transition-all duration-700 relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-tr from-cyan-500/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
                        <span class="text-cyan-400 font-black text-3xl tracking-tighter relative z-10">PF</span>
                    </div>
                </a>
                <div class="absolute -inset-4 bg-cyan-500/5 rounded-[3.5rem] blur-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-700 -z-10"></div>
            </div>

            <div class="w-full sm:max-w-md px-10 py-12 glass-panel rounded-[3.5rem] border-white/10 shadow-[0_50px_100px_rgba(0,0,0,0.5)] relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-cyan-500/40 to-transparent"></div>
                {{ $slot }}
            </div>

            <div class="mt-8 text-center">
                <p class="text-[10px] uppercase tracking-[0.3em] font-black text-slate-500/50">Personal Fin &copy; {{ date('Y') }}</p>
            </div>
        </div>
    </body>
</html>

