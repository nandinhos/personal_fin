<label {{ $attributes->merge(['class' => 'block font-bold text-xs uppercase tracking-widest text-slate-500 mb-2 ml-1']) }}>
    {{ $value ?? $slot }}
</label>
