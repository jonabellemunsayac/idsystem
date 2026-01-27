<?php

namespace App\Http\Controllers;

use App\Models\ID;
use App\Models\Resident;
use App\Services\ActivityLogger;
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
                'signature' => $r->signature,
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
            // Generate unique username with counter for duplicate first names
            $firstName = strtolower(str_replace(' ', '', $resident->first_name));
            $lastName = strtolower($resident->last_name);
            
            // Check if this first name already exists (with or without counter)
            $firstNamePattern = $firstName . '\\d*\\.';
            $existingCount = \App\Models\ResidentAccount::where('username', 'regexp', $firstNamePattern)->count();
            
            if ($existingCount > 0) {
                // Find the highest counter for this first name
                $maxCounter = 0;
                $accounts = \App\Models\ResidentAccount::whereRaw("username REGEXP ?", [$firstNamePattern])->get();
                foreach ($accounts as $account) {
                    if (preg_match("/^{$firstName}(\d+)\./", $account->username, $matches)) {
                        $maxCounter = max($maxCounter, (int)$matches[1]);
                    }
                }
                $baseUsername = $firstName . ($maxCounter + 1) . '.' . $lastName;
            } else {
                $baseUsername = $firstName . '.' . $lastName;
            }
            
            $username = $baseUsername;
            $counter = 1;
            
            // Check if username already exists and make it unique
            while (\App\Models\ResidentAccount::where('username', $username)->exists()) {
                $username = $baseUsername . $counter;
                $counter++;
            }
            
            $residentAccount = $resident->residentAccount()->create([
                'username' => $username,
                'email' => $request->input('email', $resident->first_name . '.' . $resident->last_name . '@barangay.local'),
                'password_hash' => bcrypt('temporary_password_' . Str::random(8)),
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

    /**
     * Log ID print action
     */
    public function logPrint(Request $request)
    {
        $validated = $request->validate([
            'resident_id' => 'required|exists:residents,id',
            'print_type' => 'required|in:front,back,both',
        ]);

        $resident = Resident::findOrFail($validated['resident_id']);
        $residentName = "{$resident->first_name} {$resident->last_name}";

        ActivityLogger::logPrint($validated['print_type'], $resident->id, $residentName);

        return response()->json(['success' => true]);
    }

    /**
     * Get chairman signature image
     */
    public function getChairmanSignature()
    {
        $path = storage_path('app/public/signatures/chairman-signature.png');
        
        if (!file_exists($path)) {
            abort(404, 'Chairman signature not found');
        }

        return response()->file($path, [
            'Content-Type' => 'image/png',
            'Cache-Control' => 'public, max-age=31536000',
        ]);
    }
}
