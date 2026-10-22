@props(['name', 'type' => 'text', 'placeholder' => '', 'icon' => 'user', 'autocomplete' => null])
<div x-data="{ show: false }">
    <div class="flex items-center gap-2 rounded-lg border border-line-chip bg-white px-3 focus-within:border-gold-700">
        <x-dynamic-component :component="'heroicon-o-' . $icon" class="h-5 w-5 shrink-0 text-muted" />
        <input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}"
            @if ($type === 'password') x-bind:type="show ? 'text' : 'password'" @endif
            value="{{ $type === 'password' ? '' : old($name) }}"
            placeholder="{{ $placeholder }}"
            @if ($autocomplete) autocomplete="{{ $autocomplete }}" @endif
            {{ $attributes->merge(['class' => 'w-full border-0 bg-transparent py-3 text-sm text-ink placeholder:text-muted focus:ring-0']) }}>
        @if ($type === 'password')
            <button type="button" x-on:click="show = !show" class="text-muted" aria-label="Tampilkan password">
                <x-heroicon-o-eye x-show="!show" class="h-5 w-5" />
                <x-heroicon-o-eye-slash x-show="show" x-cloak class="h-5 w-5" />
            </button>
        @endif
    </div>
    @error($name)
        <p class="mt-1 text-xs text-danger">{{ $message }}</p>
    @enderror
</div>