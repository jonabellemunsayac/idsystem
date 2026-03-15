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
        $sheet1 = $spreadsheet->getActiveSheet();
        $sheet1->setTitle('Dashboard Summary');

        $generatedAt = now('Asia/Manila')->format('F j, Y g:i A');

        $sheet1->setCellValue('A1', 'DASHBOARD SUMMARY REPORT');
        $sheet1->setCellValue('A2', 'Generated On');
        $sheet1->setCellValue('B2', $generatedAt);

        $row = 4;
        $sheet1->setCellValue('A' . $row, 'STATISTICS');

        $row++;
        $sheet1->setCellValue('A' . $row, 'Metric');
        $sheet1->setCellValue('B' . $row, 'Count');

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

        $row += 2;
        $sheet1->setCellValue('A' . $row, 'RECENT APPOINTMENTS');
        $row++;
        $sheet1->setCellValue('A' . $row, 'Resident');
        $sheet1->setCellValue('B' . $row, 'Service');
        $sheet1->setCellValue('C' . $row, 'Scheduled Time');
        $sheet1->setCellValue('D' . $row, 'Status');

        $recentAppointments = Appointment::with('resident')
            ->latest('created_at')
            ->limit(10)
            ->get()
            ->filter(fn($appointment) => $appointment->resident !== null);

        $row++;
        foreach ($recentAppointments as $appointment) {
            $scheduledTime = $appointment->scheduled_time
                ? \Carbon\Carbon::parse($appointment->scheduled_time)->format('F j, Y g:i A')
                : 'N/A';

            $sheet1->setCellValue('A' . $row, trim($appointment->resident->first_name . ' ' . $appointment->resident->last_name));
            $sheet1->setCellValue('B' . $row, $appointment->service_type ?? 'N/A');
            $sheet1->setCellValue('C' . $row, $scheduledTime);
            $sheet1->setCellValue('D' . $row, ucfirst($appointment->status ?? 'pending'));
            $row++;
        }

        $row += 2;
        $sheet1->setCellValue('A' . $row, 'RECENT BLOTTER CASES');
        $row++;
        $sheet1->setCellValue('A' . $row, 'Case Number');
        $sheet1->setCellValue('B' . $row, 'Incident Type');
        $sheet1->setCellValue('C' . $row, 'Incident Date');
        $sheet1->setCellValue('D' . $row, 'Status');

        $recentBlotterCases = BlotterRecord::orderBy('incident_date', 'desc')
            ->limit(10)
            ->get();

        $row++;
        foreach ($recentBlotterCases as $case) {
            $incidentDate = $case->incident_date
                ? \Carbon\Carbon::parse($case->incident_date)->format('F j, Y')
                : 'N/A';

            $sheet1->setCellValue('A' . $row, $case->case_number ?? 'N/A');
            $sheet1->setCellValue('B' . $row, $case->incident_type ?? 'N/A');
            $sheet1->setCellValue('C' . $row, $incidentDate);
            $sheet1->setCellValue('D' . $row, ucfirst($case->status ?? 'pending'));
            $row++;
        }

        $row += 2;
        $sheet1->setCellValue('A' . $row, 'WEEKLY STATISTICS');
        $row++;
        $sheet1->setCellValue('A' . $row, 'Day');
        $sheet1->setCellValue('B' . $row, 'Appointments');
        $sheet1->setCellValue('C' . $row, 'Blotter Cases');

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

        $appointmentsByDay = $weeklyAppointments->pluck('count', 'day');
        $blotterByDay = $weeklyBlotterCases->pluck('count', 'day');
        $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

        $row++;
        foreach ($days as $day) {
            $sheet1->setCellValue('A' . $row, $day);
            $sheet1->setCellValue('B' . $row, $appointmentsByDay[$day] ?? 0);
            $sheet1->setCellValue('C' . $row, $blotterByDay[$day] ?? 0);
            $row++;
        }

        foreach (range('A', 'D') as $column) {
            $sheet1->getColumnDimension($column)->setAutoSize(true);
        }

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

        $recentAppointments = Appointment::with('resident')
            ->latest('created_at')
            ->limit(8)
            ->get()
            ->filter(fn($appointment) => $appointment->resident !== null);

        $recentBlotterCases = BlotterRecord::orderBy('incident_date', 'desc')
            ->limit(8)
            ->get();

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

        $appointmentsByDay = $weeklyAppointments->pluck('count', 'day');
        $blotterByDay = $weeklyBlotterCases->pluck('count', 'day');
        $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

        $generatedAt = now('Asia/Manila')->format('F j, Y g:i A');
        $escape = static fn(string $value): string => str_replace(
            ['\\', '(', ')'],
            ['\\\\', '\(', '\)'],
            $value
        );
        $truncate = static fn(string $value, int $limit): string => strlen($value) > $limit
            ? substr($value, 0, $limit - 1) . '~'
            : $value;

        $appointmentRows = [];
        foreach ($recentAppointments->take(6) as $appointment) {
            $appointmentRows[] = [
                $truncate(trim($appointment->resident->first_name . ' ' . $appointment->resident->last_name), 30),
                $truncate((string) ($appointment->service_type ?? 'N/A'), 20),
                $appointment->scheduled_time
                    ? \Carbon\Carbon::parse($appointment->scheduled_time)->format('M j, Y g:i A')
                    : 'N/A',
                ucfirst((string) ($appointment->status ?? 'pending')),
            ];
        }

        $blotterRows = [];
        foreach ($recentBlotterCases->take(6) as $case) {
            $blotterRows[] = [
                $truncate((string) ($case->case_number ?? 'N/A'), 18),
                $truncate((string) ($case->incident_type ?? 'N/A'), 32),
                $case->incident_date
                    ? \Carbon\Carbon::parse($case->incident_date)->format('M j, Y')
                    : 'N/A',
                ucfirst((string) ($case->status ?? 'pending')),
            ];
        }

        $weeklyRows = [];
        foreach ($days as $day) {
            $weeklyRows[] = [
                $day,
                (string) ($appointmentsByDay[$day] ?? 0),
                (string) ($blotterByDay[$day] ?? 0),
            ];
        }

        $stream = '';
        $drawText = function (string $text, float $x, float $y, int $size = 10) use (&$stream, $escape): void {
            $safeText = $escape($text);
            $stream .= "BT\n";
            $stream .= "/F1 {$size} Tf\n";
            $stream .= sprintf("1 0 0 1 %.2F %.2F Tm\n", $x, $y);
            $stream .= "({$safeText}) Tj\n";
            $stream .= "ET\n";
        };
        $drawLine = function (float $x1, float $y1, float $x2, float $y2) use (&$stream): void {
            $stream .= sprintf("%.2F %.2F m %.2F %.2F l S\n", $x1, $y1, $x2, $y2);
        };

        $renderTable = function (
            string $title,
            array $headers,
            array $rows,
            float $x,
            float $topY,
            array $colWidths,
            int $rowHeight = 16
        ) use (&$stream, $drawText, $drawLine, $truncate): float {
            $drawText($title, $x, $topY, 12);

            $tableTop = $topY - 10;
            $totalWidth = array_sum($colWidths);
            $rowCount = count($rows) + 1;
            $tableBottom = $tableTop - ($rowHeight * $rowCount);

            // Header background
            $stream .= sprintf("0.93 g %.2F %.2F %.2F %.2F re f\n", $x, $tableTop - $rowHeight, $totalWidth, $rowHeight);
            $stream .= "0 g\n";

            // Outer border + horizontal grid
            for ($i = 0; $i <= $rowCount; $i++) {
                $lineY = $tableTop - ($i * $rowHeight);
                $drawLine($x, $lineY, $x + $totalWidth, $lineY);
            }
            $drawLine($x, $tableTop, $x, $tableBottom);
            $drawLine($x + $totalWidth, $tableTop, $x + $totalWidth, $tableBottom);

            // Vertical grid
            $currentX = $x;
            foreach ($colWidths as $width) {
                $currentX += $width;
                if ($currentX < $x + $totalWidth) {
                    $drawLine($currentX, $tableTop, $currentX, $tableBottom);
                }
            }

            // Header text
            $currentX = $x;
            foreach ($headers as $index => $header) {
                $cellLimit = max(8, (int) floor(($colWidths[$index] - 8) / 5));
                $drawText($truncate((string) $header, $cellLimit), $currentX + 3, $tableTop - 12, 9);
                $currentX += $colWidths[$index];
            }

            // Body text
            foreach ($rows as $rowIndex => $row) {
                $currentX = $x;
                foreach ($row as $cellIndex => $cell) {
                    $cellLimit = max(8, (int) floor(($colWidths[$cellIndex] - 8) / 5));
                    $textY = $tableTop - (($rowIndex + 2) * $rowHeight) + 4;
                    $drawText($truncate((string) $cell, $cellLimit), $currentX + 3, $textY, 9);
                    $currentX += $colWidths[$cellIndex];
                }
            }

            return $tableBottom - 22;
        };

        $y = 770;
        $drawText('DASHBOARD SUMMARY REPORT', 40, $y, 18);
        $y -= 22;
        $drawText("Generated on: {$generatedAt}", 40, $y, 11);
        $y -= 24;
        $drawText('Statistics', 40, $y, 12);
        $y -= 16;
        $drawText("Total Residents: {$stats['residents_count']}", 50, $y, 10);
        $y -= 13;
        $drawText("Pending Appointments: {$stats['appointments_count']}", 50, $y, 10);
        $y -= 13;
        $drawText("Pending Blotter Cases: {$stats['blotter_count']}", 50, $y, 10);
        $y -= 13;
        $drawText("Total Assets: {$stats['assets_count']}", 50, $y, 10);
        $y -= 18;

        $y = $renderTable(
            'Recent Appointments',
            ['Resident', 'Service', 'Scheduled Time', 'Status'],
            $appointmentRows,
            40,
            $y,
            [170, 100, 170, 90]
        );

        $y = $renderTable(
            'Recent Blotter Cases',
            ['Case Number', 'Incident Type', 'Incident Date', 'Status'],
            $blotterRows,
            40,
            $y,
            [130, 200, 120, 80]
        );

        if ($y > 80) {
            $y = $renderTable(
                'Weekly Statistics',
                ['Day', 'Appointments', 'Blotter Cases'],
                $weeklyRows,
                40,
                $y,
                [220, 156, 154]
            );
        }

        $objects = [
            1 => '<</Type /Catalog /Pages 2 0 R>>',
            2 => '<</Type /Pages /Kids [3 0 R] /Count 1>>',
            3 => '<</Type /Page /Parent 2 0 R /Resources 4 0 R /MediaBox [0 0 612 792] /Contents 5 0 R>>',
            4 => '<</Font <</F1 <</Type /Font /Subtype /Type1 /BaseFont /Helvetica>>>>>>',
            5 => "<</Length " . strlen($stream) . ">>\nstream\n{$stream}endstream",
        ];

        $pdfContent = "%PDF-1.4\n";
        $offsets = [0];

        for ($i = 1; $i <= 5; $i++) {
            $offsets[$i] = strlen($pdfContent);
            $pdfContent .= "{$i} 0 obj\n{$objects[$i]}\nendobj\n";
        }

        $startXref = strlen($pdfContent);
        $pdfContent .= "xref\n0 6\n";
        $pdfContent .= "0000000000 65535 f \n";
        for ($i = 1; $i <= 5; $i++) {
            $pdfContent .= sprintf("%010d 00000 n \n", $offsets[$i]);
        }

        $pdfContent .= "trailer\n<</Size 6 /Root 1 0 R>>\n";
        $pdfContent .= "startxref\n{$startXref}\n";
        $pdfContent .= "%%EOF\n";

        $fileName = 'weekly_statistics_' . now()->format('Y-m-d_H-i-s') . '.pdf';

        return response()->streamDownload(function () use ($pdfContent) {
            echo $pdfContent;
        }, $fileName, ['Content-Type' => 'application/pdf']);
    }
}
