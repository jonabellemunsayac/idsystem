<?php

namespace App\Http\Controllers;

use App\Models\ID;
use App\Models\Resident;
use App\Services\ActivityLogger;
use App\Services\QRCodeGenerator;
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
            ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$query}%"])
            ->orWhereRaw("CONCAT(last_name, ', ', first_name) LIKE ?", ["%{$query}%"])
            ->orWhereRaw("CONCAT(first_name, ' ', middle_name, ' ', last_name) LIKE ?", ["%{$query}%"])
            ->limit(10)
            ->get()
            ->map(fn($r) => [
                'id' => $r->id,
                'first_name' => $r->first_name,
                'middle_name' => $r->middle_name,
                'last_name' => $r->last_name,
                'suffix' => $r->suffix,
                'address' => $this->formatAddress($r),
                'profile_image' => $r->profile_image,
                'signature' => $r->signature,
                'gender' => $r->gender,
                'birth_date' => $r->birth_date,
                'birth_place' => $r->birth_place,
                'place_of_birth' => $r->place_of_birth,
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
            'expiration_date' => 'nullable|date',
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
        
        $issuedDate = Carbon::parse($request->issued_date);
        $fixedExpirationDate = Carbon::create(2029, 12, 31)->toDateString();

        // Generate sequential ID Number: BKPC-YYYY-00001
        $idNumber = $this->generateBarangayIdNumber((int) $issuedDate->format('Y'));
        
        // Create QR code URL using the qr.authenticate route with QRCodeGenerator service
        $qrUrl = route('qr.authenticate', ['token' => $qrToken]);
        $qrCodeImage = QRCodeGenerator::generateQRCode($qrUrl);

        $id = ID::create([
            'resident_id' => $resident->id,
            'id_type' => 'barangay',
            'id_number' => $idNumber,
            'issued_date' => $request->issued_date,
            'expiration_date' => $fixedExpirationDate,
            'qr_code' => $qrCodeImage
        ]);

        return response()->json([
            'success' => true,
            'id' => [
                'id' => $id->id,
                'id_number' => $id->id_number,
                'qr_code' => $qrCodeImage,
                'issued_date' => $id->issued_date,
                'expiration_date' => $fixedExpirationDate,
            ]
        ]);
    }

    private function generateBarangayIdNumber(int $year): string
    {
        $prefix = "BKPC-{$year}-";

        $maxSequence = ID::query()
            ->where('id_number', 'like', $prefix . '%')
            ->pluck('id_number')
            ->map(function ($idNumber) {
                if (preg_match('/^BKPC-\d{4}-(\d{5})$/', (string) $idNumber, $matches)) {
                    return (int) $matches[1];
                }

                return 0;
            })
            ->max() ?? 0;

        return $prefix . str_pad((string) ($maxSequence + 1), 5, '0', STR_PAD_LEFT);
    }

    private function formatAddress($resident)
    {
        $parts = [];

        $streetSegment = trim(implode(' ', array_filter([
            $resident->house_no ? trim((string) $resident->house_no) : null,
            $this->normalizeStreetName($resident->street_name),
        ])));

        if ($streetSegment !== '') $parts[] = $streetSegment;
        if ($resident->purok) $parts[] = 'Purok ' . trim((string) $resident->purok);
        if ($resident->barangay) $parts[] = trim((string) $resident->barangay);
        if ($resident->municipality) $parts[] = trim((string) $resident->municipality);
        if ($resident->province) $parts[] = trim((string) $resident->province);

        if (!empty($parts)) {
            return implode(', ', $parts);
        }

        return $this->sanitizeAddressString($resident->address);
    }

    private function normalizeStreetName(?string $streetName): string
    {
        if (!$streetName) {
            return '';
        }

        $normalized = preg_replace('/\bST\b\.?/i', 'ST.', trim($streetName));
        $normalized = preg_replace('/\s+/', ' ', $normalized ?? '');

        return trim($normalized ?? '');
    }

    private function sanitizeAddressString(?string $address): string
    {
        if (!$address) {
            return '';
        }

        $clean = trim($address);
        $clean = preg_replace('/\bBRGY\.?\s*/i', '', $clean);
        $clean = preg_replace('/\bBARANGAY\s*/i', '', $clean ?? '');
        $clean = preg_replace('/\bST\b\.?/i', 'ST.', $clean ?? '');
        $clean = preg_replace('/^(\s*#?\s*\d+[A-Z0-9\-\/]*)\s*,\s*/i', '$1 ', $clean ?? '');
        $clean = preg_replace('/\s*,\s*/', ', ', $clean ?? '');
        $clean = preg_replace('/\s+/', ' ', $clean ?? '');

        return trim((string) ($clean ?? ''), " ,");
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
