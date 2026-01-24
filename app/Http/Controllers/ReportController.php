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
            if ($request->gender === 'None') {
                $residentsQuery->where(function($q) {
                    $q->whereNull('gender')
                      ->orWhere('gender', '')
                      ->orWhere('gender', 'None');
                });
            } else {
                $residentsQuery->where('gender', $request->gender);
            }
        }
        if ($request->filled('specialSector')) {
            if ($request->specialSector === 'None') {
                $residentsQuery->where(function($q) {
                    $q->whereNull('special_sector')
                      ->orWhere('special_sector', '')
                      ->orWhere('special_sector', 'None');
                });
            } else {
                $residentsQuery->where('special_sector', $request->specialSector);
            }
        }
        if ($request->filled('streetName')) {
            if ($request->streetName === 'None') {
                $residentsQuery->where(function($q) {
                    $q->whereNull('street_name')
                      ->orWhere('street_name', '')
                      ->orWhere('street_name', 'None');
                });
            } else {
                $residentsQuery->where('street_name', $request->streetName);
            }
        }
        if ($request->filled('ageGroup')) {
            $today = now();
            if ($request->ageGroup === 'None') {
                $residentsQuery->whereNull('birth_date');
            } elseif ($request->ageGroup === 'children') {
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
            if ($request->gender === 'None') {
                $query->where(function($q) {
                    $q->whereNull('gender')
                      ->orWhere('gender', '')
                      ->orWhere('gender', 'None');
                });
            } else {
                $query->where('gender', $request->gender);
            }
        }
        if ($request->filled('specialSector')) {
            if ($request->specialSector === 'None') {
                $query->where(function($q) {
                    $q->whereNull('special_sector')
                      ->orWhere('special_sector', '')
                      ->orWhere('special_sector', 'None');
                });
            } else {
                $query->where('special_sector', $request->specialSector);
            }
        }
        if ($request->filled('streetName')) {
            if ($request->streetName === 'None') {
                $query->where(function($q) {
                    $q->whereNull('street_name')
                      ->orWhere('street_name', '')
                      ->orWhere('street_name', 'None');
                });
            } else {
                $query->where('street_name', $request->streetName);
            }
        }
        if ($request->filled('ageGroup')) {
            $today = now();
            if ($request->ageGroup === 'None') {
                $query->whereNull('birth_date');
            } elseif ($request->ageGroup === 'children') {
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
            if ($request->specialSector === 'None') {
                $query->where(function($q) {
                    $q->whereNull('special_sector')
                      ->orWhere('special_sector', '')
                      ->orWhere('special_sector', 'None');
                });
            } else {
                $query->where('special_sector', $request->specialSector);
            }
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

        // Apply filters (exclude gender to show all genders in the chart)
        if ($request->filled('specialSector')) {
            if ($request->specialSector === 'None') {
                $query->where(function($q) {
                    $q->whereNull('special_sector')
                      ->orWhere('special_sector', '')
                      ->orWhere('special_sector', 'None');
                });
            } else {
                $query->where('special_sector', $request->specialSector);
            }
        }
        if ($request->filled('streetName')) {
            if ($request->streetName === 'None') {
                $query->where(function($q) {
                    $q->whereNull('street_name')
                      ->orWhere('street_name', '')
                      ->orWhere('street_name', 'None');
                });
            } else {
                $query->where('street_name', $request->streetName);
            }
        }
        if ($request->filled('ageGroup')) {
            $today = now();
            if ($request->ageGroup === 'None') {
                $query->whereNull('birth_date');
            } elseif ($request->ageGroup === 'children') {
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

        // Apply filters (exclude age group to show all age groups in the chart)
        if ($request->filled('gender')) {
            if ($request->gender === 'None') {
                $query->where(function($q) {
                    $q->whereNull('gender')
                      ->orWhere('gender', '')
                      ->orWhere('gender', 'None');
                });
            } else {
                $query->where('gender', $request->gender);
            }
        }
        if ($request->filled('specialSector')) {
            if ($request->specialSector === 'None') {
                $query->where(function($q) {
                    $q->whereNull('special_sector')
                      ->orWhere('special_sector', '')
                      ->orWhere('special_sector', 'None');
                });
            } else {
                $query->where('special_sector', $request->specialSector);
            }
        }
        if ($request->filled('streetName')) {
            if ($request->streetName === 'None') {
                $query->where(function($q) {
                    $q->whereNull('street_name')
                      ->orWhere('street_name', '')
                      ->orWhere('street_name', 'None');
                });
            } else {
                $query->where('street_name', $request->streetName);
            }
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

        // Apply filters (exclude special sector to show all special sectors in the chart)
        if ($request->filled('gender')) {
            if ($request->gender === 'None') {
                $query->where(function($q) {
                    $q->whereNull('gender')
                      ->orWhere('gender', '')
                      ->orWhere('gender', 'None');
                });
            } else {
                $query->where('gender', $request->gender);
            }
        }
        if ($request->filled('streetName')) {
            if ($request->streetName === 'None') {
                $query->where(function($q) {
                    $q->whereNull('street_name')
                      ->orWhere('street_name', '')
                      ->orWhere('street_name', 'None');
                });
            } else {
                $query->where('street_name', $request->streetName);
            }
        }
        if ($request->filled('ageGroup')) {
            $today = now();
            if ($request->ageGroup === 'None') {
                $query->whereNull('birth_date');
            } elseif ($request->ageGroup === 'children') {
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
            'none' => (clone $query)->where(function($q) {
                $q->whereNull('special_sector')
                  ->orWhere('special_sector', '')
                  ->orWhere('special_sector', 'None');
            })->count(),
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
            if ($request->specialSector === 'None') {
                $query->where(function($q) {
                    $q->whereNull('special_sector')
                      ->orWhere('special_sector', '')
                      ->orWhere('special_sector', 'None');
                });
            } else {
                $query->where('special_sector', $request->specialSector);
            }
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
        if ($request->filled('streetName')) {
            $query->where('street_name', $request->streetName);
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
        // Get all statistics
        $statistics = [
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
            'adult' => Resident::whereRaw('TIMESTAMPDIFF(YEAR, birth_date, NOW()) BETWEEN 18 AND 59')->count(),
            'senior' => Resident::whereRaw('TIMESTAMPDIFF(YEAR, birth_date, NOW()) >= 60')->count(),
            'female' => Resident::where('gender', 'Female')->count(),
            'male' => Resident::where('gender', 'Male')->count(),
        ];

        // Get civil status distribution
        $civilStatusData = Resident::selectRaw('civil_status, count(*) as count')
            ->groupBy('civil_status')
            ->where('civil_status', '!=', null)
            ->get();

        $civilStatusArray = [];
        foreach ($civilStatusData as $item) {
            $civilStatusArray[$item->civil_status] = $item->count;
        }
        $statistics['civilStatus'] = $civilStatusArray;

        // Log the export action
        \App\Services\ActivityLogger::logExport('Reports Dashboard', 'PDF');

        // Render the view as HTML
        $html = view('reports.pdf', ['statistics' => $statistics])->render();

        // Return as HTML to display in browser (JavaScript will handle PDF generation and download)
        return response($html)
            ->header('Content-Type', 'text/html; charset=utf-8');
    }

    /**
     * Export reports to Excel (CSV format)
     */
    public function exportExcel()
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
        \App\Services\ActivityLogger::logExport('Reports Dashboard', 'XLS');

        // Create CSV content
        $csv = "BARANGAY MANAGEMENT SYSTEM - REPORTS DASHBOARD\n";
        $csv .= "Generated: " . \Carbon\Carbon::now()->format('F d, Y h:i A') . "\n\n";
        
        $csv .= "GENERAL STATISTICS\n";
        $csv .= "Metric,Count\n";
        $csv .= "Total Residents," . $data['residents'] . "\n";
        $csv .= "Total Blotter Cases," . $data['blotterCases'] . "\n";
        $csv .= "Total Appointments," . $data['appointments'] . "\n";
        $csv .= "Total Assets," . $data['assets'] . "\n";
        $csv .= "Total Certificates," . $data['certificates'] . "\n\n";
        
        $csv .= "DEMOGRAPHIC STATISTICS\n";
        $csv .= "Category,Count\n";
        $csv .= "PWD," . $data['pwd'] . "\n";
        $csv .= "Senior Citizen," . $data['seniorCitizen'] . "\n";
        $csv .= "Solo Parent," . $data['soloParent'] . "\n";
        $csv .= "LGBTQ," . $data['lgbtq'] . "\n";
        $csv .= "Children (0-17)," . $data['children'] . "\n\n";
        
        $csv .= "GENDER DISTRIBUTION\n";
        $csv .= "Gender,Count\n";
        $csv .= "Female," . $data['female'] . "\n";
        $csv .= "Male," . $data['male'] . "\n";

        return response($csv)
            ->header('Content-Type', 'text/csv; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename="reports-' . \Carbon\Carbon::now()->format('Y-m-d') . '.csv"');
    }
}
