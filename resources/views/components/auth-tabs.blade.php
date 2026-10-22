@props(['active' => 'login'])
@php
    $tab = fn ($key) => $active === $key ? 'bg-white text-ink shadow-segment' : 'text-slate';
@endphp
<div class="flex rounded-lg bg-segmented p-1 text-xs font-medium">
    <a href="{{ route('login') }}" class="flex-1 rounded-md py-2 text-center {{ $tab('login') }}">Login</a>
    <a href="{{ route('register') }}" class="flex-1 rounded-md py-2 text-center {{ $tab('register') }}">Register</a>
</div>