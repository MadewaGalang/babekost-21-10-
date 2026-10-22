@props(['status' => 'default'])
@php
    $styles = match ($status) {
        'aktif', 'lunas', 'terverifikasi', 'tersedia' => 'bg-tint-success text-success',
        'menunggu', 'terbooking'                      => 'bg-tint-warning text-warning',
        'ditolak', 'baru', 'terlambat'                => 'bg-tint-danger text-danger',
        'nonaktif', 'terisi', 'kosong'                => 'bg-tint-ink text-ink',
        default                                       => 'bg-tint-gold text-gold-700',
    };
@endphp
<span {{ $attributes->merge(['class' => "rounded-full px-2 py-0.5 text-[11px] font-medium $styles"]) }}>
    {{ $slot }}
</span>