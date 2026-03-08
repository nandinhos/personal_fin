<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-red-500/10 border border-red-500/50 rounded-lg font-semibold text-xs text-red-400 uppercase tracking-widest hover:bg-red-500 hover:text-white active:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-slate-900 transition ease-in-out duration-150 shadow-[0_0_15px_rgba(239,68,68,0.1)]']) }}>
    {{ $slot }}
</button>

