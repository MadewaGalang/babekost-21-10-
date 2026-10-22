<?php

namespace App\Http\Controllers\Visitor;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function __invoke(Request $request)
    {
        $tab = $request->query('tab') === 'kamar' ? 'kamar' : 'bangunan';

        // Foto bangunan.
        $buildingPhotos = Gallery::where('category', 'bangunan')->latest()->get();

        // Foto per kamar: hanya kamar yang punya foto kategori kamar.
        $rooms = Room::whereHas('galleries', fn ($q) => $q->where('category', 'kamar'))
            ->orderBy('number')->get();
        $selected = $rooms->firstWhere('id', (int) $request->query('room')) ?? $rooms->first();
        $roomPhotos = $selected
            ? $selected->galleries()->where('category', 'kamar')->latest()->get()
            : collect();

        return view('visitor.gallery', compact('tab', 'buildingPhotos', 'rooms', 'selected', 'roomPhotos'));
    }
}