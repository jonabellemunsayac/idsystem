<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use App\Models\Appointment;
use App\Models\Certificate;
use App\Models\ID;
use App\Models\BlotterRecord;
use App\Models\Asset;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Response;

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

        // Get recent appointments (3 latest by creation)
        $recent_appointments = Appointment::with('resident')
            ->latest('created_at')
            ->limit(3)
            ->get()
            ->filter(fn($apt) => $apt->resident !== null)
            ->map(fn($apt) => [
                'id' => $apt->id,
                'resident_name' => $apt->resident->first_name . ' ' . $apt->resident->last_name,
                'service_type' => $apt->service_type ?? 'N/A',
                'scheduled_time' => $apt->scheduled_time,
                'status' => $apt->status ?? 'pending',
            ])
            ->values()
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

    /**
     * Export comprehensive dashboard summary to CSV
     */
    public function exportSummaryCSV()
    {
        $spreadsheet = new Spreadsheet();
        
        // Sheet 1: Dashboard Overview
        $sheet1 = $spreadsheet->getActiveSheet();
        $sheet1->setTitle('Dashboard Summary');
        
        $sheet1->setCellValue('A1', 'DASHBOARD SUMMARY REPORT');
        $sheet1->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet1->setCellValue('A2', 'Generated: ' . now()->format('Y-m-d H:i:s'));
        
        $row = 4;
        $sheet1->setCellValue('A' . $row, 'STATISTICS');
        $sheet1->getStyle('A' . $row)->getFont()->setBold(true)->setSize(12);
        
        $row++;
        $sheet1->setCellValue('A' . $row, 'Metric');
        $sheet1->setCellValue('B' . $row, 'Count');
        $headerStyle = $sheet1->getStyle('A' . $row . ':B' . $row);
        $headerStyle->getFont()->setBold(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FFFFFFFF'));
        $headerStyle->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF0038A8');
        
        $stats = [
            'residents_count' => Resident::count(),
            'appointments_count' => Appointment::where('status', 'pending')->count(),
            'blotter_count' => BlotterRecord::where('status', 'pending')->count(),
            'assets_count' => Asset::count(),
        ];
        
        $metrics = [
            'Total Residents' => $stats['residents_count'],
            'Pending Appointments' => $stats['appointments_count'],
            'Pending Blotter Cases' => $stats['blotter_count'],
            'Total Assets' => $stats['assets_count'],
        ];
        
        $row++;
        foreach ($metrics as $metric => $count) {
            $sheet1->setCellValue('A' . $row, $metric);
            $sheet1->setCellValue('B' . $row, $count);
            $row++;
        }
        
        // Sheet 2: Residents
        $sheet2 = $spreadsheet->createSheet();
        $sheet2->setTitle('Residents');
        
        $residents = Resident::all(['id', 'first_name', 'last_name', 'email', 'contact_number', 'address']);
        
        $sheet2->setCellValue('A1', 'ID');
        $sheet2->setCellValue('B1', 'First Name');
        $sheet2->setCellValue('C1', 'Last Name');
        $sheet2->setCellValue('D1', 'Email');
        $sheet2->setCellValue('E1', 'Contact Number');
        $sheet2->setCellValue('F1', 'Address');
        
        $headerStyle = $sheet2->getStyle('A1:F1');
        $headerStyle->getFont()->setBold(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FFFFFFFF'));
        $headerStyle->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF0038A8');
        
        $row = 2;
        foreach ($residents as $resident) {
            $sheet2->setCellValue('A' . $row, $resident->id);
            $sheet2->setCellValue('B' . $row, $resident->first_name);
            $sheet2->setCellValue('C' . $row, $resident->last_name);
            $sheet2->setCellValue('D' . $row, $resident->email);
            $sheet2->setCellValue('E' . $row, $resident->contact_number);
            $sheet2->setCellValue('F' . $row, $resident->address);
            $row++;
        }
        
        foreach (range('A', 'F') as $column) {
            $sheet2->getColumnDimension($column)->setAutoSize(true);
        }
        
        // Sheet 3: Assets
        $sheet3 = $spreadsheet->createSheet();
        $sheet3->setTitle('Assets');
        
        $assets = Asset::all(['id', 'asset_name', 'category', 'quantity', 'status', 'location']);
        
        $sheet3->setCellValue('A1', 'ID');
        $sheet3->setCellValue('B1', 'Asset Name');
        $sheet3->setCellValue('C1', 'Category');
        $sheet3->setCellValue('D1', 'Quantity');
        $sheet3->setCellValue('E1', 'Status');
        $sheet3->setCellValue('F1', 'Location');
        
        $headerStyle = $sheet3->getStyle('A1:F1');
        $headerStyle->getFont()->setBold(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FFFFFFFF'));
        $headerStyle->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF0038A8');
        
        $row = 2;
        foreach ($assets as $asset) {
            $sheet3->setCellValue('A' . $row, $asset->id);
            $sheet3->setCellValue('B' . $row, $asset->asset_name);
            $sheet3->setCellValue('C' . $row, $asset->category);
            $sheet3->setCellValue('D' . $row, $asset->quantity);
            $sheet3->setCellValue('E' . $row, $asset->status);
            $sheet3->setCellValue('F' . $row, $asset->location ?? '');
            $row++;
        }
        
        foreach (range('A', 'F') as $column) {
            $sheet3->getColumnDimension($column)->setAutoSize(true);
        }
        
        // Sheet 4: Weekly Statistics
        $sheet4 = $spreadsheet->createSheet();
        $sheet4->setTitle('Weekly Statistics');
        
        $weeklyAppointments = Appointment::selectRaw('DAYNAME(scheduled_time) as day, COUNT(*) as count')
            ->whereRaw('WEEK(scheduled_time) = WEEK(NOW())')
            ->groupByRaw('DAYNAME(scheduled_time), DAYOFWEEK(scheduled_time)')
            ->orderByRaw('DAYOFWEEK(scheduled_time)')
            ->get();

        $weeklyBlotterCases = BlotterRecord::selectRaw('DAYNAME(incident_date) as day, COUNT(*) as count')
            ->whereRaw('WEEK(incident_date) = WEEK(NOW())')
            ->groupByRaw('DAYNAME(incident_date), DAYOFWEEK(incident_date)')
            ->orderByRaw('DAYOFWEEK(incident_date)')
            ->get();
        
        $sheet4->setCellValue('A1', 'Weekly Appointments');
        $sheet4->getStyle('A1')->getFont()->setBold(true)->setSize(12);
        
        $sheet4->setCellValue('A2', 'Day');
        $sheet4->setCellValue('B2', 'Count');
        $headerStyle = $sheet4->getStyle('A2:B2');
        $headerStyle->getFont()->setBold(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FFFFFFFF'));
        $headerStyle->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF0038A8');
        
        $row = 3;
        foreach ($weeklyAppointments as $data) {
            $sheet4->setCellValue('A' . $row, $data->day);
            $sheet4->setCellValue('B' . $row, $data->count);
            $row++;
        }
        
        $row += 2;
        $sheet4->setCellValue('A' . $row, 'Weekly Blotter Cases');
        $sheet4->getStyle('A' . $row)->getFont()->setBold(true)->setSize(12);
        
        $row++;
        $sheet4->setCellValue('A' . $row, 'Day');
        $sheet4->setCellValue('B' . $row, 'Count');
        $headerStyle = $sheet4->getStyle('A' . $row . ':B' . $row);
        $headerStyle->getFont()->setBold(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FFFFFFFF'));
        $headerStyle->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFCE1126');
        
        $row++;
        foreach ($weeklyBlotterCases as $data) {
            $sheet4->setCellValue('A' . $row, $data->day);
            $sheet4->setCellValue('B' . $row, $data->count);
            $row++;
        }
        
        $sheet4->getColumnDimension('A')->setAutoSize(true);
        $sheet4->getColumnDimension('B')->setAutoSize(true);
        
        $writer = new Csv($spreadsheet);
        $fileName = 'dashboard_summary_' . now()->format('Y-m-d_H-i-s') . '.csv';
        
        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $fileName);
    }

    /**
     * Export dashboard summary to PDF (weekly statistics report)
     */
    public function exportSummaryPDF()
    {
        $stats = [
            'residents_count' => Resident::count(),
            'appointments_count' => Appointment::where('status', 'pending')->count(),
            'blotter_count' => BlotterRecord::where('status', 'pending')->count(),
            'assets_count' => Asset::count(),
        ];

        $weeklyAppointments = Appointment::selectRaw('DAYNAME(scheduled_time) as day, COUNT(*) as count')
            ->whereRaw('WEEK(scheduled_time) = WEEK(NOW())')
            ->groupByRaw('DAYNAME(scheduled_time), DAYOFWEEK(scheduled_time)')
            ->orderByRaw('DAYOFWEEK(scheduled_time)')
            ->get();

        $weeklyBlotterCases = BlotterRecord::selectRaw('DAYNAME(incident_date) as day, COUNT(*) as count')
            ->whereRaw('WEEK(incident_date) = WEEK(NOW())')
            ->groupByRaw('DAYNAME(incident_date), DAYOFWEEK(incident_date)')
            ->orderByRaw('DAYOFWEEK(incident_date)')
            ->get();

        // Format date in a user-friendly way
        $generatedDate = now()->format('F d, Y');
        $generatedTime = now()->format('g:i A');

        // Create PDF content
        $pdfContent = "%PDF-1.4\n";
        $pdfContent .= "1 0 obj\n<</Type /Catalog /Pages 2 0 R>>\nendobj\n";
        $pdfContent .= "2 0 obj\n<</Type /Pages /Kids [3 0 R] /Count 1>>\nendobj\n";
        $pdfContent .= "3 0 obj\n<</Type /Page /Parent 2 0 R /Resources 4 0 R /MediaBox [0 0 612 792] /Contents 5 0 R>>\nendobj\n";
        $pdfContent .= "4 0 obj\n<</Font <</F1 <</Type /Font /Subtype /Type1 /BaseFont /Helvetica>>>>>>\nendobj\n";
        
        // PDF stream content
        $stream = "BT\n";
        $stream .= "/F1 24 Tf\n";
        $stream .= "50 720 Td\n";
        $stream .= "(WEEKLY STATISTICS REPORT) Tj\n";
        $stream .= "0 -40 Td\n";
        $stream .= "/F1 12 Tf\n";
        $stream .= "(Generated: " . $generatedDate . " at " . $generatedTime . ") Tj\n";
        $stream .= "0 -60 Td\n";
        $stream .= "/F1 14 Tf\n";
        $stream .= "(Total Residents: " . $stats['residents_count'] . ") Tj\n";
        $stream .= "0 -30 Td\n";
        $stream .= "(Barangay Assets: " . $stats['assets_count'] . ") Tj\n";
        $stream .= "0 -60 Td\n";
        $stream .= "/F1 12 Tf\n";
        $stream .= "(Weekly Appointments) Tj\n";
        $stream .= "0 -25 Td\n";
        
        foreach ($weeklyAppointments as $data) {
            $stream .= "(" . $data->day . ": " . $data->count . ") Tj\n";
            $stream .= "0 -20 Td\n";
        }
        
        $stream .= "0 -20 Td\n";
        $stream .= "/F1 12 Tf\n";
        $stream .= "(Weekly Blotter Cases) Tj\n";
        $stream .= "0 -25 Td\n";
        
        foreach ($weeklyBlotterCases as $data) {
            $stream .= "(" . $data->day . ": " . $data->count . ") Tj\n";
            $stream .= "0 -20 Td\n";
        }
        
        $stream .= "ET\n";
        
        $pdfContent .= "5 0 obj\n<</Length " . strlen($stream) . ">>\nstream\n" . $stream . "\nendstream\nendobj\n";
        $pdfContent .= "xref\n0 6\n0000000000 65535 f\n0000000009 00000 n\n0000000058 00000 n\n0000000115 00000 n\n0000000206 00000 n\n0000000302 00000 n\n";
        $pdfContent .= "trailer\n<</Size 6 /Root 1 0 R>>\n";
        $pdfContent .= "startxref\n" . (strlen($pdfContent) - 50) . "\n";
        $pdfContent .= "%%EOF\n";
        
        $fileName = 'weekly_statistics_' . now()->format('Y-m-d_H-i-s') . '.pdf';
        
        return response()->streamDownload(function () use ($pdfContent) {
            echo $pdfContent;
        }, $fileName, ['Content-Type' => 'application/pdf']);
    }
}
