<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use App\Models\Appointment;
use App\Models\Certificate;
use App\Models\ID;
use App\Models\BlotterRecord;
use App\Models\Asset;

class DashboardController extends Controller
{
    public function index()
    {
        // Get statistics
        $stats = [
            'residents_count' => Resident::count(),
            'appointments_count' => Appointment::where('status', 'pending')->count(),
            'blotter_count' => BlotterRecord::where('status', 'pending')->count(),
            'assets_count' => Asset::count(),
            'certificates_count' => Certificate::count(),
            'ids_count' => ID::count(),
        ];

        // Get recent appointments (3 latest)
        $recent_appointments = Appointment::with('resident')
            ->orderBy('scheduled_time', 'desc')
            ->limit(3)
            ->get()
            ->map(fn($apt) => [
                'id' => $apt->id,
                'resident_name' => $apt->resident->first_name . ' ' . $apt->resident->last_name,
                'service_type' => $apt->service_type,
                'scheduled_time' => $apt->scheduled_time,
                'status' => $apt->status,
            ])
            ->toArray();

        // Get recent blotter cases (3 latest)
        $recent_blotter_cases = BlotterRecord::orderBy('incident_date', 'desc')
            ->limit(3)
            ->get()
            ->map(fn($case) => [
                'id' => $case->id,
                'case_number' => $case->case_number,
                'incident_type' => $case->incident_type,
                'incident_date' => $case->incident_date,
                'status' => $case->status,
            ])
            ->toArray();

        // Get weekly statistics - appointments by day
        $weeklyAppointments = Appointment::selectRaw('DAYNAME(scheduled_time) as day, COUNT(*) as count')
            ->whereRaw('WEEK(scheduled_time) = WEEK(NOW())')
            ->groupByRaw('DAYNAME(scheduled_time), DAYOFWEEK(scheduled_time)')
            ->orderByRaw('DAYOFWEEK(scheduled_time)')
            ->get();

        // Get weekly statistics - blotter cases by day
        $weeklyBlotterCases = BlotterRecord::selectRaw('DAYNAME(incident_date) as day, COUNT(*) as count')
            ->whereRaw('WEEK(incident_date) = WEEK(NOW())')
            ->groupByRaw('DAYNAME(incident_date), DAYOFWEEK(incident_date)')
            ->orderByRaw('DAYOFWEEK(incident_date)')
            ->get();

        return view('dashboard', [
            'stats' => $stats,
            'recent_appointments' => $recent_appointments,
            'recent_blotter_cases' => $recent_blotter_cases,
            'weeklyAppointments' => $weeklyAppointments,
            'weeklyBlotterCases' => $weeklyBlotterCases,
        ]);
    }
}

