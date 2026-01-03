<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use App\Models\Appointment;
use App\Models\Certificate;
use App\Models\ID;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'residents_count' => Resident::count(),
            'appointments_count' => Appointment::count(),
            'certificates_count' => Certificate::count(),
            'ids_count' => ID::count(),
        ];

        $recent_appointments = Appointment::with('resident')
            ->orderBy('scheduled_time', 'desc')
            ->limit(5)
            ->get()
            ->map(fn($apt) => [
                'id' => $apt->id,
                'resident_name' => $apt->resident->first_name . ' ' . $apt->resident->last_name,
                'appointment_date' => $apt->scheduled_time,
            ])
            ->toArray();

        $recent_residents = Resident::orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(fn($r) => [
                'id' => $r->id,
                'first_name' => $r->first_name,
                'last_name' => $r->last_name,
                'barangay' => $r->barangay,
                'created_at' => $r->created_at,
            ])
            ->toArray();

        return view('dashboard', [
            'stats' => $stats,
            'recent_appointments' => $recent_appointments,
            'recent_residents' => $recent_residents,
        ]);
    }
}
