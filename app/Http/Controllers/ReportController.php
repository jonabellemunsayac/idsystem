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
    public function getDashboardStats(Request $request)
    {
        $residentsQuery = Resident::query();

        // Apply filters only to residents count
        if ($request->filled('gender')) {
            $residentsQuery->where('gender', $request->gender);
        }
        if ($request->filled('specialSector')) {
            $residentsQuery->where('special_sector', $request->specialSector);
        }
        if ($request->filled('streetName')) {
            $residentsQuery->where('street_name', $request->streetName);
        }
        if ($request->filled('ageGroup')) {
            $today = now();
            if ($request->ageGroup === 'children') {
                $residentsQuery->whereRaw('TIMESTAMPDIFF(YEAR, birth_date, ?) < 18', [$today]);
            } elseif ($request->ageGroup === 'adult') {
                $residentsQuery->whereRaw('TIMESTAMPDIFF(YEAR, birth_date, ?) BETWEEN 18 AND 59', [$today]);
            } elseif ($request->ageGroup === 'senior') {
                $residentsQuery->whereRaw('TIMESTAMPDIFF(YEAR, birth_date, ?) >= 60', [$today]);
            }
        }

        return response()->json([
            'residents' => $residentsQuery->count(),
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
    public function getDemographics(Request $request)
    {
        $query = Resident::query();

        // Apply filters
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }
        if ($request->filled('specialSector')) {
            $query->where('special_sector', $request->specialSector);
        }
        if ($request->filled('streetName')) {
            $query->where('street_name', $request->streetName);
        }
        if ($request->filled('ageGroup')) {
            $today = now();
            if ($request->ageGroup === 'children') {
                $query->whereRaw('TIMESTAMPDIFF(YEAR, birth_date, ?) < 18', [$today]);
            } elseif ($request->ageGroup === 'adult') {
                $query->whereRaw('TIMESTAMPDIFF(YEAR, birth_date, ?) BETWEEN 18 AND 59', [$today]);
            } elseif ($request->ageGroup === 'senior') {
                $query->whereRaw('TIMESTAMPDIFF(YEAR, birth_date, ?) >= 60', [$today]);
            }
        }

        $pwdCount = (clone $query)->where('special_sector', 'PWD')->count();
        $seniorCitizenCount = (clone $query)->where('special_sector', 'Senior Citizen')->count();
        $soloParentCount = (clone $query)->where('special_sector', 'Solo Parent')->count();
        $lgbtqCount = (clone $query)->where('special_sector', 'LGBTQ')->count();
        
        // Calculate children count (0-17 years old)
        $childrenQuery = clone $query;
        $childrenCount = $childrenQuery->whereRaw('TIMESTAMPDIFF(YEAR, birth_date, NOW()) < 18')->count();
        
        $femaleCount = (clone $query)->where('gender', 'Female')->count();
        $maleCount = (clone $query)->where('gender', 'Male')->count();

        return response()->json([
            'pwd' => $pwdCount,
            'seniorCitizen' => $seniorCitizenCount,
            'soloParent' => $soloParentCount,
            'lgbtq' => $lgbtqCount,
            'children' => $childrenCount,
            'female' => $femaleCount,
            'male' => $maleCount,
        ]);
    }

    /**
     * Get street statistics
     */
    public function getStreetStats(Request $request)
    {
        $query = Resident::query();

        // Apply filters
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }
        if ($request->filled('specialSector')) {
            $query->where('special_sector', $request->specialSector);
        }
        if ($request->filled('streetName')) {
            $query->where('street_name', $request->streetName);
        }
        if ($request->filled('ageGroup')) {
            $today = now();
            if ($request->ageGroup === 'children') {
                $query->whereRaw('TIMESTAMPDIFF(YEAR, birth_date, ?) < 18', [$today]);
            } elseif ($request->ageGroup === 'adult') {
                $query->whereRaw('TIMESTAMPDIFF(YEAR, birth_date, ?) BETWEEN 18 AND 59', [$today]);
            } elseif ($request->ageGroup === 'senior') {
                $query->whereRaw('TIMESTAMPDIFF(YEAR, birth_date, ?) >= 60', [$today]);
            }
        }

        $streetStats = $query->selectRaw('
            street_name,
            COUNT(*) as total,
            SUM(CASE WHEN gender = "Male" THEN 1 ELSE 0 END) as male,
            SUM(CASE WHEN gender = "Female" THEN 1 ELSE 0 END) as female
        ')
        ->whereNotNull('street_name')
        ->where('street_name', '!=', '')
        ->groupBy('street_name')
        ->orderBy('street_name')
        ->get();

        return response()->json([
            'streets' => $streetStats
        ]);
    }

    /**
     * Get all street names for filter dropdown
     */
    public function getStreetNames()
    {
        $streets = Resident::select('street_name')
            ->whereNotNull('street_name')
            ->where('street_name', '!=', '')
            ->distinct()
            ->orderBy('street_name')
            ->pluck('street_name');

        return response()->json([
            'streets' => $streets
        ]);
    }

    /**
     * Get gender distribution
     */
    public function getGenderDistribution(Request $request)
    {
        $query = Resident::query();

        // Apply filters
        if ($request->filled('specialSector')) {
            $query->where('special_sector', $request->specialSector);
        }
        if ($request->filled('streetName')) {
            $query->where('street_name', $request->streetName);
        }
        if ($request->filled('ageGroup')) {
            $today = now();
            if ($request->ageGroup === 'children') {
                $query->whereRaw('TIMESTAMPDIFF(YEAR, birth_date, ?) < 18', [$today]);
            } elseif ($request->ageGroup === 'adult') {
                $query->whereRaw('TIMESTAMPDIFF(YEAR, birth_date, ?) BETWEEN 18 AND 59', [$today]);
            } elseif ($request->ageGroup === 'senior') {
                $query->whereRaw('TIMESTAMPDIFF(YEAR, birth_date, ?) >= 60', [$today]);
            }
        }

        return response()->json([
            'male' => (clone $query)->where('gender', 'Male')->count(),
            'female' => (clone $query)->where('gender', 'Female')->count(),
        ]);
    }

    /**
     * Get age group distribution
     */
    public function getAgeGroupDistribution(Request $request)
    {
        $query = Resident::query();

        // Apply filters
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }
        if ($request->filled('specialSector')) {
            $query->where('special_sector', $request->specialSector);
        }
        if ($request->filled('streetName')) {
            $query->where('street_name', $request->streetName);
        }

        $today = now();
        return response()->json([
            'children' => (clone $query)->whereRaw('TIMESTAMPDIFF(YEAR, birth_date, ?) < 18', [$today])->count(),
            'adult' => (clone $query)->whereRaw('TIMESTAMPDIFF(YEAR, birth_date, ?) BETWEEN 18 AND 59', [$today])->count(),
            'senior' => (clone $query)->whereRaw('TIMESTAMPDIFF(YEAR, birth_date, ?) >= 60', [$today])->count(),
        ]);
    }

    /**
     * Get special sector distribution
     */
    public function getSpecialSectorDistribution(Request $request)
    {
        $query = Resident::query();

        // Apply filters
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }
        if ($request->filled('streetName')) {
            $query->where('street_name', $request->streetName);
        }
        if ($request->filled('ageGroup')) {
            $today = now();
            if ($request->ageGroup === 'children') {
                $query->whereRaw('TIMESTAMPDIFF(YEAR, birth_date, ?) < 18', [$today]);
            } elseif ($request->ageGroup === 'adult') {
                $query->whereRaw('TIMESTAMPDIFF(YEAR, birth_date, ?) BETWEEN 18 AND 59', [$today]);
            } elseif ($request->ageGroup === 'senior') {
                $query->whereRaw('TIMESTAMPDIFF(YEAR, birth_date, ?) >= 60', [$today]);
            }
        }

        return response()->json([
            'seniorCitizen' => (clone $query)->where('special_sector', 'Senior Citizen')->count(),
            'pwd' => (clone $query)->where('special_sector', 'PWD')->count(),
            'soloParent' => (clone $query)->where('special_sector', 'Solo Parent')->count(),
            'lgbtq' => (clone $query)->where('special_sector', 'LGBTQ')->count(),
        ]);
    }

    /**
     * Get street distribution
     */
    public function getStreetDistribution(Request $request)
    {
        $query = Resident::query();

        // Apply filters
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }
        if ($request->filled('specialSector')) {
            $query->where('special_sector', $request->specialSector);
        }
        if ($request->filled('ageGroup')) {
            $today = now();
            if ($request->ageGroup === 'children') {
                $query->whereRaw('TIMESTAMPDIFF(YEAR, birth_date, ?) < 18', [$today]);
            } elseif ($request->ageGroup === 'adult') {
                $query->whereRaw('TIMESTAMPDIFF(YEAR, birth_date, ?) BETWEEN 18 AND 59', [$today]);
            } elseif ($request->ageGroup === 'senior') {
                $query->whereRaw('TIMESTAMPDIFF(YEAR, birth_date, ?) >= 60', [$today]);
            }
        }

        $streetStats = $query->selectRaw('street_name, COUNT(*) as total')
            ->whereNotNull('street_name')
            ->where('street_name', '!=', '')
            ->groupBy('street_name')
            ->orderBy('street_name')
            ->get();

        return response()->json([
            'streets' => $streetStats
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
            'lgbtq' => Resident::where('special_sector', 'LGBTQ')->count(),
            'children' => Resident::whereRaw('TIMESTAMPDIFF(YEAR, birth_date, NOW()) < 18')->count(),
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
        $content .= "LGBTQ: {$data['lgbtq']}\n";
        $content .= "Children (0-17): {$data['children']}\n";
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
            ['LGBTQ', Resident::where('special_sector', 'LGBTQ')->count()],
            ['Children (0-17)', Resident::whereRaw('TIMESTAMPDIFF(YEAR, birth_date, NOW()) < 18')->count()],
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
