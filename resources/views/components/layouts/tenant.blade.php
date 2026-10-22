@props(['title' => 'Babekost', 'greeting' => null])
<x-mobile-shell :title="$title">
    <x-app-bar :title="$greeting ?? $title" :logo="(bool) $greeting">
        <x-slot:action>
            @isset($action)
                {{ $action }}
            @else
                <a href="#" class="relative flex h-10 w-10 items-center justify-center rounded-full bg-tint-gold text-gold-700" aria-label="Notifikasi">
                    <x-heroicon-o-bell class="h-5 w-5" />
                    <span class="absolute right-2.5 top-2.5 h-2 w-2 rounded-full bg-danger"></span>
                </a>
            @endisset
        </x-slot:action>
    </x-app-bar>

    {{ $slot }}

    <x-slot:nav>
        <x-bottom-nav :items="[
            ['label' => 'Home',       'route' => 'tenant.home',       'icon' => 'home', 'match' => ['tenant.home']],
            ['label' => 'Booking',    'route' => 'tenant.booking',    'icon' => 'calendar'],
            ['label' => 'Payment',    'route' => 'tenant.payment',    'icon' => 'receipt-percent'],
            ['label' => 'Complaints', 'route' => 'tenant.complaints', 'icon' => 'chat-bubble-left-right'],
            ['label' => 'Profile',    'route' => 'tenant.profile',    'icon' => 'user'],
        ]" />
    </x-slot:nav>
</x-mobile-shell>