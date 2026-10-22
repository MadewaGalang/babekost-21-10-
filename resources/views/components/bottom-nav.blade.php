@props(['items'])
<nav class="fixed bottom-0 left-1/2 z-50 flex w-full max-w-[430px] -translate-x-1/2 border-t border-line bg-white">
    @foreach ($items as $item)
        @php
            $patterns = $item['match'] ?? [$item['route'] . '*'];
            $active = request()->routeIs(...$patterns);
            $href = Route::has($item['route']) ? route($item['route']) : '#';
        @endphp
        <a href="{{ $href }}" class="flex flex-1 flex-col items-center gap-0.5 py-2 text-[11px] font-medium {{ $active ? 'text-gold-700' : 'text-muted' }}">
            <span class="rounded-full px-4 py-1 {{ $active ? 'bg-tint-gold' : '' }}">
                <x-dynamic-component :component="str_starts_with($item['icon'], 'icon-') ? $item['icon'] : 'heroicon-o-' . $item['icon']" class="h-6 w-6" />
            </span>
            {{ $item['label'] }}
        </a>
    @endforeach
</nav>