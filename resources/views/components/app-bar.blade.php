@props(['title', 'logo' => false])
<header class="sticky top-0 z-40 flex h-14 items-center justify-between border-b border-line bg-white px-4">
    <div class="flex items-center gap-2">
        @if ($logo)
            <img src="{{ asset('images/logo.png') }}" alt="" class="h-6">
        @endif
        <h1 class="text-sm font-bold text-ink">{{ $title }}</h1>
    </div>
    <div class="flex items-center gap-2 text-slate">{{ $action ?? '' }}</div>
</header>