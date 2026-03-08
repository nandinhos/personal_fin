<button {{ $attributes->merge(['type' => 'submit', 'class' => 'glass-button-primary w-full']) }}>
    {{ $slot }}
</button>
