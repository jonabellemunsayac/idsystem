<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use App\Models\BlotterRecord;
use App\Models\Appointment;
use App\Models\Asset;
use App\Models\Certificate;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display the reports and analytics dashboard
     */
    public function index()
    {
        return view('reports.index');
    }

    /**
     * Get resident demographics data
     */
    public function getResidentDemographics()
    {
        $genderStats = Resident::selectRaw('gender, count(*) as count')
            ->groupBy('gender')
            ->where('gender', '!=', null)
            ->get();

        $civilStatusStats = Resident::selectRaw('civil_status, count(*) as count')
            ->groupBy('civil_status')
            ->where('civil_status', '!=', null)
            ->get();

        return response()->json([
            'gender' => $genderStats,
            'civilStatus' => $civilStatusStats,
            'totalResidents' => Resident::count(),
        ]);
    }

    /**
     * Get monthly appointments data
     */
    public function getMonthlyAppointments()
    {
        $currentYear = now()->year;
        
        $monthlyData = Appointment::selectRaw('MONTH(scheduled_time) as month, COUNT(*) as count')
            ->whereYear('scheduled_time', $currentYear)
            ->groupByRaw('MONTH(scheduled_time)')
            ->orderByRaw('MONTH(scheduled_time)')
            ->get();

        $statusStats = Appointment::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->get();

        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $chartData = array_fill(0, 12, 0);

        foreach ($monthlyData as $data) {
            $chartData[$data->month - 1] = $data->count;
        }

        return response()->json([
            'months' => $months,
            'data' => $chartData,
            'statusStats' => $statusStats,
            'totalAppointments' => Appointment::count(),
        ]);
    }

    /**
     * Get blotter case statistics
     */
    public function getBlotterStatistics()
    {
        $severityStats = BlotterRecord::selectRaw('severity, count(*) as count')
            ->groupBy('severity')
            ->get();

        $statusStats = BlotterRecord::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->get();

        $incidentTypeStats = BlotterRecord::selectRaw('incident_type, count(*) as count')
            ->groupBy('incident_type')
            ->orderByRaw('count(*) DESC')
            ->limit(8)
            ->get();

        $currentYear = now()->year;
        $monthlyData = BlotterRecord::selectRaw('MONTH(incident_date) as month, COUNT(*) as count')
            ->whereYear('incident_date', $currentYear)
            ->groupByRaw('MONTH(incident_date)')
            ->orderByRaw('MONTH(incident_date)')
            ->get();

        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $chartData = array_fill(0, 12, 0);

        foreach ($monthlyData as $data) {
            $chartData[$data->month - 1] = $data->count;
        }

        return response()->json([
            'severity' => $severityStats,
            'status' => $statusStats,
            'incidentTypes' => $incidentTypeStats,
            'months' => $months,
            'monthlyData' => $chartData,
            'totalCases' => BlotterRecord::count(),
        ]);
    }

    /**
     * Get asset utilization statistics
     */
    public function getAssetUtilization()
    {
        $statusStats = Asset::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->get();

        $categoryStats = Asset::selectRaw('category, count(*) as count, SUM(quantity) as total_quantity')
            ->groupBy('category')
            ->orderByRaw('count(*) DESC')
            ->limit(8)
            ->get();

        $totalAssets = Asset::count();
        $totalQuantity = Asset::sum('quantity');

        return response()->json([
            'status' => $statusStats,
            'categories' => $categoryStats,
            'totalAssets' => $totalAssets,
            'totalQuantity' => $totalQuantity,
        ]);
    }

    /**
     * Get comprehensive dashboard statistics
     */
    public function getDashboardStats()
    {
        return response()->json([
            'residents' => Resident::count(),
            'blotterCases' => BlotterRecord::count(),
            'appointments' => Appointment::count(),
            'assets' => Asset::count(),
            'certificates' => Certificate::count(),
            'pendingCases' => BlotterRecord::where('status', 'pending')->count(),
            'investigatingCases' => BlotterRecord::where('status', 'investigating')->count(),
            'resolvedCases' => BlotterRecord::where('status', 'resolved')->count(),
        ]);
    }

    /**
     * Get demographic statistics
     */
    public function getDemographics()
    {
        $pwdCount = Resident::where('special_sector', 'PWD')->count();
        $seniorCitizenCount = Resident::where('special_sector', 'Senior Citizen')->count();
        $soloParentCount = Resident::where('special_sector', 'Solo Parent')->count();
        $femaleCount = Resident::where('gender', 'Female')->count();
        $maleCount = Resident::where('gender', 'Male')->count();

        return response()->json([
            'pwd' => $pwdCount,
            'seniorCitizen' => $seniorCitizenCount,
            'soloParent' => $soloParentCount,
            'female' => $femaleCount,
            'male' => $maleCount,
        ]);
    }

    /**
     * Export reports to PDF
     */
    public function exportPDF()
    {
        $data = [
            'residents' => Resident::count(),
            'blotterCases' => BlotterRecord::count(),
            'appointments' => Appointment::count(),
            'assets' => Asset::count(),
            'certificates' => Certificate::count(),
            'pwd' => Resident::where('special_sector', 'PWD')->count(),
            'seniorCitizen' => Resident::where('special_sector', 'Senior Citizen')->count(),
            'soloParent' => Resident::where('special_sector', 'Solo Parent')->count(),
            'female' => Resident::where('gender', 'Female')->count(),
            'male' => Resident::where('gender', 'Male')->count(),
        ];

        // Log the export action
        \App\Services\ActivityLogger::logExport('Reports Dashboard', 'PDF');

        // Return a download response with JSON data formatted as text
        $content = "BARANGAY MANAGEMENT SYSTEM - REPORTS DASHBOARD\n";
        $content .= "Generated on: " . now()->format('F d, Y h:i A') . "\n\n";
        $content .= "GENERAL STATISTICS\n";
        $content .= "Total Residents: {$data['residents']}\n";
        $content .= "Total Blotter Cases: {$data['blotterCases']}\n";
        $content .= "Total Appointments: {$data['appointments']}\n";
        $content .= "Total Assets: {$data['assets']}\n";
        $content .= "Total Certificates: {$data['certificates']}\n\n";
        $content .= "DEMOGRAPHIC STATISTICS\n";
        $content .= "PWD: {$data['pwd']}\n";
        $content .= "Senior Citizen: {$data['seniorCitizen']}\n";
        $content .= "Solo Parent: {$data['soloParent']}\n";
        $content .= "Female: {$data['female']}\n";
        $content .= "Male: {$data['male']}\n";

        return response($content)
            ->header('Content-Type', 'text/plain')
            ->header('Content-Disposition', 'attachment; filename="reports-' . now()->format('Y-m-d') . '.txt"');
    }

    /**
     * Export reports to Excel
     */
    public function exportExcel()
    {
        $data = [
            ['Metric', 'Count'],
            ['Total Residents', Resident::count()],
            ['Total Blotter Cases', BlotterRecord::count()],
            ['Total Appointments', Appointment::count()],
            ['Total Assets', Asset::count()],
            ['Total Certificates', Certificate::count()],
            [''],
            ['Demographic Statistics', ''],
            ['PWD', Resident::where('special_sector', 'PWD')->count()],
            ['Senior Citizen', Resident::where('special_sector', 'Senior Citizen')->count()],
            ['Solo Parent', Resident::where('special_sector', 'Solo Parent')->count()],
            ['Female', Resident::where('gender', 'Female')->count()],
            ['Male', Resident::where('gender', 'Male')->count()],
        ];

        // Log the export action
        \App\Services\ActivityLogger::logExport('Reports Dashboard', 'XLS');

        // Create CSV content
        $csv = '';
        foreach ($data as $row) {
            $csv .= implode(',', $row) . "\n";
        }

        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="reports-' . now()->format('Y-m-d') . '.csv"');
    }
}
