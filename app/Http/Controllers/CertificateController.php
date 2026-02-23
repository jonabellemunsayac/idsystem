<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Resident;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function index(Request $request)
    {
        $query = Certificate::with('resident');

        if ($search = $request->input('search')) {
            $query->whereHas('resident', function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%");
            });
        }

        $certificates = $query->orderBy('approved_date', 'desc')
            ->paginate(10)
            ->through(fn($cert) => [
                'id' => $cert->id,
                'resident_id' => $cert->resident_id,
                'resident_name' => $cert->resident->first_name . ' ' . $cert->resident->last_name,
                'type' => $cert->type,
                'approved_date' => $cert->approved_date,
                'status' => $cert->status,
                'created_at' => $cert->created_at,
            ])
            ->withQueryString();

        // Get certificate counts by type
        $certificateCounts = [
            'indigency' => Certificate::where('type', 'indigency')->count(),
            'residency' => Certificate::where('type', 'residency')->count(),
            'clearance' => Certificate::where('type', 'clearance')->count(),
            'low_income' => Certificate::where('type', 'low_income')->count(),
        ];

        // Get all residents for the modal
        $residents = Resident::all()->map(fn($r) => [
            'id' => $r->id,
            'first_name' => $r->first_name,
            'last_name' => $r->last_name,
        ])->toArray();

        return view('certificates.index', [
            'certificates' => $certificates,
            'certificateCounts' => $certificateCounts,
            'residents' => $residents,
        ]);
    }

    public function create()
    {
        $residents = Resident::all()->map(fn($r) => [
            'id' => $r->id,
            'first_name' => $r->first_name,
            'last_name' => $r->last_name,
        ])->toArray();

        return view('certificates.create', ['residents' => $residents]);
    }

    public function editor(Request $request)
    {
        $certificateType = $request->input('type');

        // Validate certificate type
        $validTypes = ['indigency', 'residency', 'clearance', 'low_income', 'no_income'];
        if (!$certificateType || !in_array($certificateType, $validTypes)) {
            return redirect()->route('certificates.index')->with('error', 'Invalid certificate type.');
        }

        // Get current date parts for the issuance line
        $issueDay = date('jS');
        $issueMonth = date('F');
        $issueYear = date('Y');

        // Return blank editor - user will fill in everything manually
        return view('certificates.editor', [
            'certificateType' => $certificateType,
            'issueDay' => $issueDay,
            'issueMonth' => $issueMonth,
            'issueYear' => $issueYear,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'resident_id' => ['nullable', 'exists:residents,id'],
            'certificate_type' => ['required', 'in:indigency,residency,clearance,low_income,no_income'],
            'issued_date' => ['required', 'date'],
            'status' => ['required', 'in:active,inactive,draft,pending,approved'],
            'remarks' => ['nullable', 'string', 'max:500'],
            'certificate_content' => ['nullable', 'string'],
        ]);

        // Map certificate_type to type field
        $data = [
            'resident_id' => $validated['resident_id'] ?? null,
            'type' => $validated['certificate_type'],
            'approved_date' => $validated['issued_date'],
            'status' => $validated['status'],
            'notes' => $validated['remarks'] ?? null,
            'content' => $validated['certificate_content'] ?? null,
        ];

        Certificate::create($data);

        return redirect()->route('certificates.index')->with('success', 'Certificate issued successfully!');
    }

    public function show(Certificate $certificate)
    {
        return view('certificates.show', [
            'certificate' => [
                'id' => $certificate->id,
                'resident_id' => $certificate->resident_id,
                'resident_name' => $certificate->resident 
                    ? $certificate->resident->first_name . ' ' . $certificate->resident->last_name 
                    : 'N/A',
                'type' => $certificate->type,
                'purpose' => $certificate->purpose,
                'purpose_details' => $certificate->purpose_details,
                'status' => $certificate->status,
                'pickup_or_delivery' => $certificate->pickup_or_delivery,
                'delivery_address' => $certificate->delivery_address,
                'approved_date' => $certificate->approved_date,
                'released_date' => $certificate->released_date,
                'rejection_reason' => $certificate->rejection_reason,
                'notes' => $certificate->notes,
                'content' => $certificate->content,
                'reference_number' => $certificate->reference_number,
                'created_at' => $certificate->created_at,
            ]
        ]);
    }

    public function destroy(Certificate $certificate)
    {
        $certificate->delete();

        return redirect()->route('certificates.index')->with('success', 'Certificate deleted successfully!');
    }

    public function approve(Certificate $certificate)
    {
        $certificate->update(['status' => 'approved']);

        return response()->json([
            'success' => true,
            'message' => 'Certificate approved successfully!'
        ]);
    }

    /**
     * API: Get all certificates for the authenticated resident
     */
    public function apiIndex()
    {
        $residentAccount = \Illuminate\Support\Facades\Auth::guard('resident')->user();
        $resident = $residentAccount->resident;

        if (!$resident) {
            return response()->json(['error' => 'Resident not found'], 404);
        }

        $certificates = Certificate::where('resident_id', $resident->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($certificates);
    }

    /**
     * API: Store a new certificate request
     */
    public function apiStore(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:barangay_clearance,certificate_of_indigency,certificate_of_residency,business_permit,community_tax_certificate,other',
            'purpose' => 'required|string|max:255',
            'purpose_details' => 'nullable|string',
            'pickup_or_delivery' => 'required|in:pickup,delivery',
            'delivery_address' => 'required_if:pickup_or_delivery,delivery|nullable|string',
        ]);

        $residentAccount = \Illuminate\Support\Facades\Auth::guard('resident')->user();
        $resident = $residentAccount->resident;

        if (!$resident) {
            return response()->json(['error' => 'Resident not found'], 404);
        }

        $certificate = Certificate::create([
            'resident_id' => $resident->id,
            'reference_number' => Certificate::generateReferenceNumber($validated['type']),
            'type' => $validated['type'],
            'purpose' => $validated['purpose'],
            'purpose_details' => $validated['purpose_details'] ?? null,
            'pickup_or_delivery' => $validated['pickup_or_delivery'],
            'delivery_address' => $validated['delivery_address'] ?? null,
            'status' => 'pending',
        ]);

        return response()->json([
            'message' => 'Certificate request submitted successfully',
            'certificate' => $certificate,
        ], 201);
    }

    /**
     * API: Get a specific certificate
     */
    public function apiShow($id)
    {
        $certificate = Certificate::findOrFail($id);

        $residentAccount = \Illuminate\Support\Facades\Auth::guard('resident')->user();
        
        // Verify ownership
        if ($certificate->resident_id !== $residentAccount->resident->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json($certificate);
    }

    /**
     * API: Cancel a certificate request (only if pending)
     */
    public function apiCancel($id)
    {
        $certificate = Certificate::findOrFail($id);

        $residentAccount = \Illuminate\Support\Facades\Auth::guard('resident')->user();
        
        // Verify ownership
        if ($certificate->resident_id !== $residentAccount->resident->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if ($certificate->status !== 'pending') {
            return response()->json(['error' => 'Only pending certificates can be cancelled'], 400);
        }

        $certificate->update(['status' => 'cancelled']);

        return response()->json(['message' => 'Certificate request cancelled']);
    }

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

    /**
     * Get template file for zero-download solution (serves raw file)
     */
    public function getTemplateFile($type)
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

        // Serve the file with proper headers for in-memory loading
        return response()->file($path, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'Cache-Control' => 'public, max-age=3600', // Cache for 1 hour
            'Access-Control-Allow-Origin' => '*', // Allow fetch from same origin
        ]);
    }

    /**
     * Serve Word template for opening in Word (not downloading)
     */
    public function wordTemplate($type, $residentId = null)
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

        // Generate a descriptive filename
        $certTypeName = ucfirst(str_replace('_', ' ', $type));
        
        if ($residentId) {
            $resident = Resident::findOrFail($residentId);
            $residentName = $resident->last_name . '_' . $resident->first_name;
            $tempFilename = 'Certificate_' . str_replace(' ', '_', $certTypeName) . '_' . $residentName . '_' . date('Ymd') . '.docx';
        } else {
            $tempFilename = 'Certificate_' . str_replace(' ', '_', $certTypeName) . '_' . date('Ymd') . '.docx';
        }
        
        // Clean filename
        $tempFilename = preg_replace('/[^A-Za-z0-9_\-\.]/', '', $tempFilename);

        // Return the file for download - browser will open it with default .docx application
        return response()->download($path, $tempFilename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ]);
    }
}
