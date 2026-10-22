@props(['variant' => 'primary', 'href' => null])
@php
    $styles = match ($variant) {
        'outline' => 'border border-gold-border text-gold-700 bg-transparent',
        'danger'  => 'border border-danger-border bg-danger-soft text-danger',
        default   => 'bg-gold-700 text-white',
    };
    $classes = "flex w-full items-center justify-center gap-2 rounded-lg px-4 py-3 text-sm font-semibold $styles";
@endphp
@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</a>
@else
    <button {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</button>
@endif