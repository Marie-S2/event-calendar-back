<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request) {
        $now   = Carbon::now();
        $month = $request->get('month', $now->month);
        $year  = $request->get('year', $now->year);

        // Événements ce mois
        $eventsThisMonth = Event::whereMonth('date', $month)
            ->whereYear('date', $year)
            ->count();

        // Par statut ce mois
        $confirmed = Event::whereMonth('date', $month)
            ->whereYear('date', $year)
            ->where('status', 'confirmed')
            ->count();

        $pending = Event::whereMonth('date', $month)
            ->whereYear('date', $year)
            ->where('status', 'pending')
            ->count();

        $cancelled = Event::whereMonth('date', $month)
            ->whereYear('date', $year)
            ->where('status', 'cancelled')
            ->count();

        // Prochains événements (5 prochains)
        $upcoming = Event::with(['eventType', 'materials'])
            ->where('date', '>=', $now->toDateString())
            ->where('status', '!=', 'cancelled')
            ->orderBy('date', 'asc')
            ->limit(5)
            ->get();

        // Événements du mois pour le calendrier
        $monthEvents = Event::with(['eventType'])
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->orderBy('date', 'asc')
            ->get();

        return response()->json([
            'stats' => [
                'total_this_month' => $eventsThisMonth,
                'confirmed'        => $confirmed,
                'pending'          => $pending,
                'cancelled'        => $cancelled,
            ],
            'upcoming'     => $upcoming,
            'month_events' => $monthEvents,
        ]);
    }
}

