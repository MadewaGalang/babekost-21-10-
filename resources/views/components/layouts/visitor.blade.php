@props(['title' => 'Babekost', 'logo' => false])
<x-mobile-shell :title="$title">
    <x-app-bar :title="$title" :logo="$logo">
        <x-slot:action>
            @isset($action)
                {{ $action }}
            @else
                <a href="https://wa.me/6281222223215" target="_blank" rel="noopener"
                    class="flex h-10 w-10 items-center justify-center rounded-full bg-tint-success text-success" aria-label="WhatsApp">
                    <x-icon-whatsapp class="h-5 w-5" />
                </a>
            @endisset
        </x-slot:action>
    </x-app-bar>

    {{ $slot }}

    <x-slot:nav>
        <x-bottom-nav :items="[
            ['label' => 'Home',    'route' => 'home',            'icon' => 'home'],
            ['label' => 'Rooms',   'route' => 'visitor.rooms',   'icon' => 'icon-bed'],
            ['label' => 'Gallery', 'route' => 'visitor.gallery', 'icon' => 'photo'],
            ['label' => 'Promo',   'route' => 'visitor.promos',  'icon' => 'megaphone'],
            ['label' => 'Login',   'route' => 'login',           'icon' => 'arrow-right-end-on-rectangle'],
        ]" />
    </x-slot:nav>
</x-mobile-shell>