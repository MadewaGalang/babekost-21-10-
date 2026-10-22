<x-layouts.visitor title="Babekost" :logo="true">

    <div class="space-y-5 p-4">

        {{-- Foto utama --}}
        <div>
            <div class="flex h-52 items-center justify-center rounded-xl" style="background: var(--grad-photo)">
                <x-heroicon-o-photo class="h-8 w-8 text-gold-500" />
            </div>
            <div class="mt-2 flex justify-center gap-1.5">
                <span class="h-1.5 w-1.5 rounded-full bg-gold-700"></span>
                <span class="h-1.5 w-1.5 rounded-full bg-handle"></span>
                <span class="h-1.5 w-1.5 rounded-full bg-handle"></span>
            </div>
        </div>

        {{-- Nama dan alamat --}}
        <div>
            <h2 class="text-base font-bold">Babekost</h2>
            <p class="mt-0.5 flex items-start gap-1 text-xs text-slate">
                <x-heroicon-o-map-pin class="mt-0.5 h-4 w-4 shrink-0 text-gold-700" />
                Jl. Mertojoyo Bar., Merjosari, Kec. Lowokwaru, Kota Malang
            </p>
        </div>

        {{-- Info singkat --}}
        <div class="grid grid-cols-2 gap-3">
            <x-card class="p-3">
                <p class="text-[11px] text-slate">Harga mulai</p>
                <p class="mt-0.5 text-sm font-bold">Rp 6.500.000/thn</p>
            </x-card>
            <x-card class="p-3">
                <p class="text-[11px] text-slate">Kamar tersedia</p>
                <p class="mt-0.5 text-sm font-bold">14 dari 60</p>
            </x-card>
        </div>

        <x-button href="https://wa.me/6281222223215">
            <x-icon-whatsapp class="h-5 w-5" /> Hubungi via WhatsApp
        </x-button>

        {{-- Aksi cepat --}}
        <section>
            <div class="mb-2 flex items-center justify-between">
                <h3 class="text-sm font-semibold">Aksi cepat</h3>
                <a href="#" class="text-xs font-medium text-gold-700">Lihat semua</a>
            </div>
            <div class="grid grid-cols-2 gap-3">
                @foreach ([['Kamar 02', 'Rp 6.500.000/thn'], ['Kamar 04', 'Rp 6.500.000/thn']] as [$nama, $harga])
                    <x-card class="p-2">
                        <div class="flex h-20 items-center justify-center rounded-lg" style="background: var(--grad-photo)">
                            <x-heroicon-o-photo class="h-6 w-6 text-gold-500" />
                        </div>
                        <p class="mt-2 text-xs font-semibold">{{ $nama }}</p>
                        <p class="text-[11px] text-slate">{{ $harga }}</p>
                    </x-card>
                @endforeach
            </div>
        </section>

        {{-- Fasilitas --}}
        <section>
            <h3 class="mb-2 text-sm font-semibold">Fasilitas</h3>
            <div class="flex flex-wrap gap-2">
                @foreach (['AC', 'Kasur', 'Lemari', 'WiFi'] as $f)
                    <span class="rounded-full border border-line-chip bg-white px-3 py-1 text-xs">{{ $f }}</span>
                @endforeach
            </div>
        </section>

        {{-- Lokasi --}}
        @php
            $lat = -7.939617820200654;
            $lng = 112.60377989495964;
        @endphp
        <section>
            <h3 class="mb-2 text-sm font-semibold">Lokasi</h3>
            <div class="overflow-hidden rounded-xl ring-1 ring-line">
                <iframe
                    src="https://www.google.com/maps?q={{ $lat }},{{ $lng }}&z=18&output=embed"
                    class="h-40 w-full border-0"
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    title="Lokasi Babekost"></iframe>
            </div>
            <a href="https://www.google.com/maps/search/?api=1&query={{ $lat }},{{ $lng }}"
                target="_blank" rel="noopener"
                class="mt-2 flex items-center gap-1 text-xs font-medium text-gold-700">
                <x-heroicon-o-map-pin class="h-4 w-4" /> Buka di Google Maps
            </a>
        </section>

        {{-- Promo dan agenda --}}
        <section class="space-y-2">
            @foreach ([['Diskon sewa tahunan', 'Promo aktif', 'megaphone'], ['Santunan anak yatim', '20 Sep 2026', 'heart']] as [$judul, $sub, $ikon])
                <x-card class="flex items-center gap-3 p-3">
                    <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-tint-gold text-gold-700">
                        <x-dynamic-component :component="'heroicon-o-' . $ikon" class="h-5 w-5" />
                    </span>
                    <div class="flex-1">
                        <p class="text-xs font-semibold">{{ $judul }}</p>
                        <p class="text-[11px] text-slate">{{ $sub }}</p>
                    </div>
                    <x-heroicon-o-chevron-right class="h-4 w-4 text-muted" />
                </x-card>
            @endforeach
        </section>

    </div>
</x-layouts.visitor>