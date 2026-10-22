<x-layouts.visitor title="Gallery">
    <div class="space-y-3 p-4">

        {{-- Tab --}}
        <div class="flex rounded-lg bg-segmented p-1 text-xs font-medium">
            @foreach (['bangunan' => 'Bangunan', 'kamar' => 'Per kamar'] as $key => $label)
                <a href="{{ route('visitor.gallery', ['tab' => $key]) }}"
                   class="flex-1 rounded-md py-2 text-center {{ $tab === $key ? 'bg-white text-ink shadow-segment' : 'text-slate' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        @if ($tab === 'kamar')
            {{-- Chip kamar --}}
            @if ($rooms->isNotEmpty())
                <div class="flex gap-2 overflow-x-auto pb-1">
                    @foreach ($rooms as $r)
                        <a href="{{ route('visitor.gallery', ['tab' => 'kamar', 'room' => $r->id]) }}"
                           class="shrink-0 rounded-full border px-3 py-1 text-xs font-medium
                                  {{ $selected?->id === $r->id ? 'border-gold-border bg-tint-gold text-gold-700' : 'border-line-chip bg-white text-slate' }}">
                            Kamar {{ $r->number }}
                        </a>
                    @endforeach
                </div>
            @endif
            @php $photos = $roomPhotos; @endphp
        @else
            @php $photos = $buildingPhotos; @endphp
        @endif

        {{-- Grid foto --}}
        @if ($photos->isEmpty())
            <p class="py-10 text-center text-sm text-slate">Belum ada foto.</p>
        @else
            <div class="grid grid-cols-2 gap-3">
                @foreach ($photos as $photo)
                    <div class="relative aspect-[3/4] overflow-hidden rounded-xl bg-track">
                        <img src="{{ asset('storage/' . $photo->photo_path) }}"
                            alt="{{ $photo->title }}" loading="lazy"
                            class="h-full w-full object-cover">
                        @if ($photo->title)
                            <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/55 to-transparent p-2 pt-6">
                                <p class="text-[11px] font-medium text-white">{{ $photo->title }}</p>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-layouts.visitor>