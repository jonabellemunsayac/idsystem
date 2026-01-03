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

        $certificates = $query->orderBy('issued_date', 'desc')
            ->paginate(10)
            ->through(fn($cert) => [
                'id' => $cert->id,
                'resident_id' => $cert->resident_id,
                'resident_name' => $cert->resident->first_name . ' ' . $cert->resident->last_name,
                'certificate_type' => $cert->certificate_type,
                'issued_date' => $cert->issued_date,
                'status' => $cert->status,
                'created_at' => $cert->created_at,
            ])
            ->withQueryString();

        return view('certificates.index', ['certificates' => $certificates]);
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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'resident_id' => ['required', 'exists:residents,id'],
            'certificate_type' => ['required', 'string', 'max:255'],
            'issued_date' => ['required', 'date'],
            'status' => ['required', 'in:active,inactive'],
            'remarks' => ['nullable', 'string', 'max:500'],
        ]);

        Certificate::create($validated);

        return redirect()->route('certificates.index')->with('success', 'Certificate issued successfully!');
    }

    public function show(Certificate $certificate)
    {
        return view('certificates.show', [
            'certificate' => [
                'id' => $certificate->id,
                'resident_id' => $certificate->resident_id,
                'resident_name' => $certificate->resident->first_name . ' ' . $certificate->resident->last_name,
                'certificate_type' => $certificate->certificate_type,
                'issued_date' => $certificate->issued_date,
                'status' => $certificate->status,
                'remarks' => $certificate->remarks,
                'created_at' => $certificate->created_at,
            ]
        ]);
    }

    public function destroy(Certificate $certificate)
    {
        $certificate->delete();

        return redirect()->route('certificates.index')->with('success', 'Certificate deleted successfully!');
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
}
