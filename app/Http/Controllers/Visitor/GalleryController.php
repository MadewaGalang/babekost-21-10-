<?php

namespace App\Http\Controllers\Visitor;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Room;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function __invoke(Request $request)
    {
        $tab = $request->query('tab') === 'kamar' ? 'kamar' : 'bangunan';

        // Foto bangunan: tidak terikat ke kamar.
        $buildingPhotos = Gallery::whereNull('room_id')->latest()->get();

        // Foto per kamar: hanya kamar yang punya foto.
        $rooms = Room::whereHas('galleries')->orderBy('number')->get();
        $selected = $rooms->firstWhere('id', (int) $request->query('room')) ?? $rooms->first();
        $roomPhotos = $selected ? $selected->galleries()->latest()->get() : collect();

        return view('visitor.gallery', compact('tab', 'buildingPhotos', 'rooms', 'selected', 'roomPhotos'));
    }
}