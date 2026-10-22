<?php

namespace App\Http\Controllers\Visitor;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use App\Models\Promo;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function __invoke(Request $request)
    {
        $today = today();
        $tab = $request->query('tab') === 'agenda' ? 'agenda' : 'promo';

        $promos = collect();
        $upcoming = collect();
        $past = collect();

        if ($tab === 'promo') {
            $promos = Promo::where('is_active', true)
                ->where(fn ($q) => $q->whereNull('starts_at')->orWhereDate('starts_at', '<=', $today))
                ->where(fn ($q) => $q->whereNull('ends_at')->orWhereDate('ends_at', '>=', $today))
                ->latest()->get();
        } else {
            $upcoming = Agenda::where('status', 'rencana')
                ->whereDate('agenda_date', '>=', $today)
                ->orderBy('agenda_date')->get();

            $past = Agenda::where('status', 'selesai')
                ->orderByDesc('agenda_date')->get();
        }

        return view('visitor.news', compact('tab', 'promos', 'upcoming', 'past'));
    }
}