<?php

namespace App\Http\Controllers;

use App\Models\ID;
use App\Models\Resident;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class IDController extends Controller
{
    public function index(Request $request)
    {
        $query = ID::with('resident');

        $ids = $query->orderBy('issued_date', 'desc')
            ->paginate(10)
            ->through(fn($id) => [
                'id' => $id->id,
                'resident_id' => $id->resident_id,
                'resident_name' => $id->resident->first_name . ' ' . $id->resident->last_name,
                'id_number' => $id->id_number,
                'issued_date' => $id->issued_date,
            ]);

        return view('ids.index', ['ids' => $ids]);
    }

    public function create()
    {
        return view('ids.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'resident_id' => ['required', 'exists:residents,id'],
            'id_number' => ['required', 'string', 'unique:ids'],
            'issued_date' => ['required', 'date'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        ID::create($validated);

        return redirect()->route('ids.index')->with('success', 'ID generated successfully!');
    }

    public function show(ID $id)
    {
        return view('ids.show', [
            'id' => [
                'id' => $id->id,
                'resident_id' => $id->resident_id,
                'resident_name' => $id->resident->first_name . ' ' . $id->resident->last_name,
                'id_number' => $id->id_number,
                'issued_date' => $id->issued_date,
                'created_at' => $id->created_at,
            ]
        ]);
    }

    public function destroy(ID $id)
    {
        $id->delete();

        return redirect()->route('ids.index')->with('success', 'ID deleted successfully!');
    }

    public function searchResidents(Request $request)
    {
        $query = $request->input('q');
        
        if (strlen($query) < 2) {
            return response()->json(['residents' => []]);
        }

        $residents = Resident::where('first_name', 'like', "%{$query}%")
            ->orWhere('last_name', 'like', "%{$query}%")
            ->orWhere('middle_name', 'like', "%{$query}%")
            ->limit(10)
            ->get()
            ->map(fn($r) => [
                'id' => $r->id,
                'first_name' => $r->first_name,
                'middle_name' => $r->middle_name,
                'last_name' => $r->last_name,
                'address' => $this->formatAddress($r),
                'profile_image' => $r->profile_image,
                'gender' => $r->gender,
                'birth_date' => $r->birth_date,
                'civil_status' => $r->civil_status,
                'nationality' => $r->nationality,
                'contact_number' => $r->contact_number,
                'special_sector' => $r->special_sector,
                'blood_type' => $r->blood_type,
                'telephone_no' => $r->telephone_no,
                'emergency_contact_name' => $r->emergency_contact_name,
                'emergency_contact_no' => $r->emergency_contact_no,
                'emergency_contact_relationship' => $r->emergency_contact_relationship,
                'emergency_contact_address' => $r->emergency_contact_address,
            ]);

        return response()->json(['residents' => $residents]);
    }

    public function generateID(Request $request)
    {
        $request->validate([
            'resident_id' => 'required|exists:residents,id',
            'issued_date' => 'required|date',
            'expiration_date' => 'required|date',
        ]);

        $resident = Resident::find($request->resident_id);
        
        // Get or create the resident account
        $residentAccount = $resident->residentAccount;
        if (!$residentAccount) {
            $residentAccount = $resident->residentAccount()->create([
                'username' => strtolower($resident->first_name . '.' . $resident->last_name),
                'email' => $request->input('email', $resident->first_name . '.' . $resident->last_name . '@barangay.local'),
            ]);
        }
        
        // Generate or get QR token
        $qrToken = $residentAccount->generateQRToken();
        
        // Generate ID Number: BRGY-YEAR-RANDOM
        $idNumber = 'BRGY-' . date('Y') . '-' . strtoupper(Str::random(6));
        
        // Create QR code URL using the qr.authenticate route
        $qrUrl = route('qr.authenticate', ['token' => $qrToken]);
        $qrCodeImage = 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=' . urlencode($qrUrl);

        $id = ID::create([
            'resident_id' => $resident->id,
            'id_type' => 'barangay',
            'id_number' => $idNumber,
            'issued_date' => $request->issued_date,
            'expiration_date' => $request->expiration_date ?? null,
            'qr_code' => $qrCodeImage
        ]);

        return response()->json([
            'success' => true,
            'id' => [
                'id' => $id->id,
                'id_number' => $id->id_number,
                'qr_code' => $qrCodeImage,
                'issued_date' => $id->issued_date,
                'expiration_date' => $request->expiration_date,
            ]
        ]);
    }

    private function formatAddress($resident)
    {
        $parts = [];
        if ($resident->house_no) $parts[] = '#' . $resident->house_no;
        if ($resident->street_name) $parts[] = $resident->street_name;
        if ($resident->purok) $parts[] = 'Purok ' . $resident->purok;
        if ($resident->barangay) $parts[] = 'Brgy. ' . $resident->barangay;
        if ($resident->municipality) $parts[] = $resident->municipality;
        if ($resident->province) $parts[] = $resident->province;
        
        return implode(', ', $parts) ?: $resident->address;
    }
}
