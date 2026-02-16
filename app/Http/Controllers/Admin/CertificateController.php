<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class CertificateController extends Controller
{
    /**
     * Download certificate template
     */
    public function downloadTemplate($type)
    {
        $templates = [
            'indigency' => '2026 - CERTIFICATE OF INDIGENCY.docx',
            'residency' => '2026 - CERTIFICATE OF RESIDENCY.docx',
            'clearance' => '2026 - BARANGAY CLEARANCE.docx',
            'low_income' => '2026 - CERTIFICATON OF LOW INCOME.docx',
            'no_income' => '2026 - CERTIFICATION OF NO INCOME.docx',
        ];

        if (!isset($templates[$type])) {
            abort(404, 'Template not found');
        }

        $filename = $templates[$type];
        $path = public_path('templates/' . $filename);

        if (!file_exists($path)) {
            abort(404, 'Template file not found');
        }

        return response()->download($path, $filename);
    }
}
