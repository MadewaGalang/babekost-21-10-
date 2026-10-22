<x-layouts.visitor title="Login">
    <div class="px-4 pt-6">
        <img src="{{ asset('images/logo.png') }}" alt="Babe Kos" class="mx-auto h-16">

        <div class="mt-6"><x-auth-tabs active="register" /></div>
        <h2 class="mt-5 text-center text-base font-semibold">Daftar akun</h2>

        <form method="POST" action="{{ route('register') }}" class="mt-4 space-y-3">
            @csrf
            <x-field name="name" icon="user" placeholder="Nama lengkap" autocomplete="name" required />
            <x-field name="phone" type="tel" icon="phone" placeholder="Nomor HP" autocomplete="tel" required />
            <x-field name="password" type="password" icon="lock-closed" placeholder="Password" autocomplete="new-password" required />
            <x-field name="password_confirmation" type="password" icon="lock-closed" placeholder="Ulangi password" autocomplete="new-password" required />
            <x-button type="submit">Daftar</x-button>
        </form>

        <p class="mt-3 text-center text-xs text-slate">
            Sudah punya akun? <a href="{{ route('login') }}" class="font-semibold text-gold-700">Login</a>
        </p>
    </div>
</x-layouts.visitor>