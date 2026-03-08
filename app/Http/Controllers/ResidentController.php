<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\BlotterRecord;
use App\Models\Clan;
use App\Models\Resident;
use App\Models\ResidentAccount;
use App\Services\ActivityLogger;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Str;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ResidentController extends Controller
{
    /**
     * Format resident address from structured fields
     */
    private function formatAddress(Resident $resident): string
    {
        $addressParts = [];
        
        if ($resident->house_no) $addressParts[] = '#' . $resident->house_no;
        if ($resident->street_name) $addressParts[] = $resident->street_name;
        if ($resident->purok) $addressParts[] = 'Purok ' . $resident->purok;
        if ($resident->barangay) $addressParts[] = 'Barangay ' . $resident->barangay;
        if ($resident->municipality) $addressParts[] = $resident->municipality;
        if ($resident->province) $addressParts[] = $resident->province;
        if ($resident->zip_code) $addressParts[] = $resident->zip_code;
        
        $formatted = implode(', ', array_filter($addressParts));
        return $formatted ?: ($resident->address ?? '');
    }

    public function index(Request $request)
    {
        $query = Resident::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('barangay', 'like', "%{$search}%")
                  // Allow searching by full name, e.g. "Test Ito"
                  ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"]);
            });
        }

        $residents = $query->orderByDesc('id')
            ->paginate(5)
            ->through(fn($resident) => [
                'id' => $resident->id,
                'first_name' => $resident->first_name,
                'last_name' => $resident->last_name,
                'age' => $resident->birth_date ? Carbon::parse($resident->birth_date)->age : null,
                'gender' => $resident->gender,
                'address' => $this->formatAddress($resident),
                'status' => $resident->status ?? 'active',
                'barangay' => $resident->barangay,
                'contact_number' => $resident->contact_number,
                'email' => $resident->email,
                'birth_date' => $resident->birth_date,
                'civil_status' => $resident->civil_status,
                'profile_image' => $resident->profile_image,
            ])
            ->withQueryString();

        return view('residents.index', [
            'residents' => $residents,
            'filters' => $request->only('search'),
        ]);
    }

    /**
     * JSON search endpoint for real-time resident search in the management table.
     */
    public function searchJson(Request $request)
    {
        $q = trim($request->input('q', ''));

        $query = Resident::query();

        if ($q !== '') {
            $query->where(function ($clause) use ($q) {
                $clause->where('first_name', 'like', "%{$q}%")
                       ->orWhere('last_name', 'like', "%{$q}%")
                       ->orWhere('middle_name', 'like', "%{$q}%")
                       ->orWhere('barangay', 'like', "%{$q}%")
                       ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$q}%"])
                       ->orWhereRaw("CONCAT(first_name, ' ', middle_name, ' ', last_name) LIKE ?", ["%{$q}%"]);
            });
        }

        $residents = $query->orderByDesc('id')
            ->limit(50)
            ->get()
            ->map(fn($r) => [
                'id'             => $r->id,
                'first_name'     => $r->first_name,
                'last_name'      => $r->last_name,
                'address'        => $this->formatAddress($r),
                'contact_number' => $r->contact_number,
                'email'          => $r->email,
                'birth_date'     => $r->birth_date,
                'gender'         => $r->gender,
                'civil_status'   => $r->civil_status,
            ]);

        return response()->json(['residents' => $residents]);
    }

    public function create()
    {
        return view('residents.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'suffix' => ['nullable', 'string', 'max:20'],
            'gender' => ['required', 'in:Male,Female'],
            'birth_date' => ['required', 'date'],
            'civil_status' => ['required', 'string', 'max:255'],
            'nationality' => ['nullable', 'string', 'max:255'],
            'barangay' => ['nullable', 'string', 'max:255'],
            'house_no' => ['nullable', 'string', 'max:255'],
            'street_name' => ['nullable', 'string', 'max:255'],
            'purok' => ['nullable', 'string', 'max:255'],
            'province' => ['nullable', 'string', 'max:255'],
            'municipality' => ['nullable', 'string', 'max:255'],
            'zip_code' => ['nullable', 'string', 'max:10'],
            'address' => ['nullable', 'string', 'max:500'],
            'contact_number' => ['required', 'string', 'max:20'],
            'telephone_no' => ['nullable', 'string', 'max:20'],
            'blood_type' => ['nullable', 'string', 'max:10'],
            'emergency_contact_name' => ['nullable', 'string', 'max:255'],
            'emergency_contact_no' => ['nullable', 'string', 'max:20'],
            'emergency_contact_relationship' => ['nullable', 'string', 'max:255'],
            'emergency_contact_address' => ['nullable', 'string', 'max:500'],
            'email' => ['nullable', 'email', 'max:255'],
            'is_head_of_family' => ['nullable', 'boolean'],
            'profile_image' => ['nullable', 'image', 'max:10240'],
            'profile_image_base64' => ['nullable', 'string', 'max:10485760'],
            'signature' => ['nullable', 'image', 'max:1024'],
            'signature_base64' => ['nullable', 'string', 'max:1048576'],
        ]);

        $profileImagePath = null;
        if ($request->hasFile('profile_image')) {
            try {
                $file = $request->file('profile_image');
                
                // Validate file is actually an image
                if (!$file->isValid()) {
                    return redirect()->back()
                        ->withErrors(['profile_image' => 'The uploaded file is invalid or corrupted.'])
                        ->withInput();
                }
                
                // Validate MIME type
                $mimeType = $file->getMimeType();
                $allowedMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                if (!in_array($mimeType, $allowedMimes)) {
                    return redirect()->back()
                        ->withErrors(['profile_image' => 'Profile image must be a JPEG, PNG, GIF, or WebP file.'])
                        ->withInput();
                }
                
                // Validate file size (max 10MB)
                if ($file->getSize() > 10485760) {
                    return redirect()->back()
                        ->withErrors(['profile_image' => 'Profile image must be less than 10MB.'])
                        ->withInput();
                }
                
                // Generate safe filename
                $filename = strtolower($validated['first_name'] . '.' . $validated['last_name'] . '.' . $file->getClientOriginalExtension());
                
                // Ensure storage directory exists and is writable
                if (!Storage::disk('public')->exists('profile_images')) {
                    Storage::disk('public')->makeDirectory('profile_images', 0755, true);
                }
                
                $profileImagePath = $file->storeAs('profile_images', $filename, 'public');
                
                if (!$profileImagePath) {
                    Log::error('Failed to store profile image: path is null');
                    return redirect()->back()
                        ->withErrors(['profile_image' => 'Failed to save profile image. Please check server storage.'])
                        ->withInput();
                }
            } catch (\Throwable $e) {
                Log::error('Profile image upload error: ' . $e->getMessage(), [
                    'file' => $request->file('profile_image')?->getClientOriginalName(),
                    'exception' => get_class($e),
                ]);
                return redirect()->back()
                    ->withErrors(['profile_image' => 'Error uploading profile image: ' . $e->getMessage()])
                    ->withInput();
            }
        } elseif (!empty($validated['profile_image_base64'])) {
            try {
                $base64Data = $validated['profile_image_base64'];
                if (strpos($base64Data, ',') !== false) {
                    list($header, $base64Data) = explode(',', $base64Data);
                }
                
                // Validate base64 string
                $imageData = base64_decode($base64Data, true);
                if ($imageData === false) {
                    return redirect()->back()
                        ->withErrors(['profile_image' => 'Invalid image data format.'])
                        ->withInput();
                }
                
                // Validate size after decode (max 10MB)
                if (strlen($imageData) > 10485760) {
                    return redirect()->back()
                        ->withErrors(['profile_image' => 'Profile image must be less than 10MB.'])
                        ->withInput();
                }
                
                // Verify it's actually an image
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mimeType = finfo_buffer($finfo, $imageData);
                finfo_close($finfo);
                
                $allowedMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                if (!in_array($mimeType, $allowedMimes)) {
                    return redirect()->back()
                        ->withErrors(['profile_image' => 'Profile image must be a valid image file (JPEG, PNG, GIF, or WebP).'])
                        ->withInput();
                }
                
                $filename = strtolower($validated['first_name'] . '.' . $validated['last_name'] . '.png');
                $profileImagePath = 'profile_images/' . $filename;
                
                // Ensure storage directory exists
                if (!Storage::disk('public')->exists('profile_images')) {
                    Storage::disk('public')->makeDirectory('profile_images', 0755, true);
                }
                
                Storage::disk('public')->put($profileImagePath, $imageData);
            } catch (\Throwable $e) {
                Log::error('Profile image base64 processing error: ' . $e->getMessage(), [
                    'exception' => get_class($e),
                    'size' => strlen($validated['profile_image_base64'] ?? ''),
                ]);
                return redirect()->back()
                    ->withErrors(['profile_image' => 'Error processing captured image: ' . $e->getMessage()])
                    ->withInput();
            }
        }

        $signaturePath = null;
        if ($request->hasFile('signature')) {
            try {
                $file = $request->file('signature');
                
                // Validate file is actually an image
                if (!$file->isValid()) {
                    return redirect()->back()
                        ->withErrors(['signature' => 'The uploaded signature file is invalid or corrupted.'])
                        ->withInput();
                }
                
                // Validate MIME type
                $mimeType = $file->getMimeType();
                $allowedMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                if (!in_array($mimeType, $allowedMimes)) {
                    return redirect()->back()
                        ->withErrors(['signature' => 'Signature must be a JPEG, PNG, GIF, or WebP file.'])
                        ->withInput();
                }
                
                // Validate file size (max 1MB)
                if ($file->getSize() > 1048576) {
                    return redirect()->back()
                        ->withErrors(['signature' => 'Signature file must be less than 1MB.'])
                        ->withInput();
                }
                
                // Generate safe filename
                $filename = strtolower($validated['first_name'] . '.' . $validated['last_name'] . '_signature.' . $file->getClientOriginalExtension());
                
                // Ensure storage directory exists and is writable
                if (!Storage::disk('public')->exists('signatures')) {
                    Storage::disk('public')->makeDirectory('signatures', 0755, true);
                }
                
                $signaturePath = $file->storeAs('signatures', $filename, 'public');
                
                if (!$signaturePath) {
                    Log::error('Failed to store signature: path is null');
                    return redirect()->back()
                        ->withErrors(['signature' => 'Failed to save signature. Please check server storage.'])
                        ->withInput();
                }
            } catch (\Throwable $e) {
                Log::error('Signature upload error: ' . $e->getMessage(), [
                    'file' => $request->file('signature')?->getClientOriginalName(),
                    'exception' => get_class($e),
                ]);
                return redirect()->back()
                    ->withErrors(['signature' => 'Error uploading signature: ' . $e->getMessage()])
                    ->withInput();
            }
        } elseif (!empty($validated['signature_base64'])) {
            try {
                $base64Data = $validated['signature_base64'];
                if (strpos($base64Data, ',') !== false) {
                    list($header, $base64Data) = explode(',', $base64Data);
                }
                
                // Validate base64 string
                $imageData = base64_decode($base64Data, true);
                if ($imageData === false) {
                    return redirect()->back()
                        ->withErrors(['signature' => 'Invalid signature data format.'])
                        ->withInput();
                }
                
                // Validate size after decode (max 1MB)
                if (strlen($imageData) > 1048576) {
                    return redirect()->back()
                        ->withErrors(['signature' => 'Signature file must be less than 1MB.'])
                        ->withInput();
                }
                
                // Verify it's actually an image
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mimeType = finfo_buffer($finfo, $imageData);
                finfo_close($finfo);
                
                $allowedMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                if (!in_array($mimeType, $allowedMimes)) {
                    return redirect()->back()
                        ->withErrors(['signature' => 'Signature must be a valid image file (JPEG, PNG, GIF, or WebP).'])
                        ->withInput();
                }
                
                $filename = strtolower($validated['first_name'] . '.' . $validated['last_name'] . '_signature.png');
                $signaturePath = 'signatures/' . $filename;
                
                // Ensure storage directory exists
                if (!Storage::disk('public')->exists('signatures')) {
                    Storage::disk('public')->makeDirectory('signatures', 0755, true);
                }
                
                Storage::disk('public')->put($signaturePath, $imageData);
            } catch (\Throwable $e) {
                Log::error('Signature base64 processing error: ' . $e->getMessage(), [
                    'exception' => get_class($e),
                    'size' => strlen($validated['signature_base64'] ?? ''),
                ]);
                return redirect()->back()
                    ->withErrors(['signature' => 'Error processing signature: ' . $e->getMessage()])
                    ->withInput();
            }
        }

        $addressParts = [];
        if (!empty($validated['house_no'])) $addressParts[] = '#' . $validated['house_no'];
        if (!empty($validated['street_name'])) $addressParts[] = $validated['street_name'];
        if (!empty($validated['purok'])) $addressParts[] = 'Purok ' . $validated['purok'];
        if (!empty($validated['barangay'])) $addressParts[] = 'Barangay ' . $validated['barangay'];
        if (!empty($validated['municipality'])) $addressParts[] = $validated['municipality'];
        if (!empty($validated['province'])) $addressParts[] = $validated['province'];
        if (!empty($validated['zip_code'])) $addressParts[] = $validated['zip_code'];
        $formattedAddress = implode(', ', array_filter($addressParts));

        // Auto-create or reuse clan (lastname only - same last name = same clan)
        // Normalize clan_name: trim whitespace for consistency
        $clanName = trim($validated['last_name']);
        $clan = Clan::where('clan_name', $clanName)->first();
        
        if (!$clan) {
            $clan = Clan::create(['clan_name' => $clanName]);
        }
        
        // Update clan address if this is the first resident or address was empty
        if (empty($clan->address)) {
            $clan->update(['address' => $formattedAddress]);
        }

        $resident = Resident::create([
            'first_name' => $validated['first_name'],
            'middle_name' => $validated['middle_name'] ?? null,
            'last_name' => $validated['last_name'],
            'suffix' => $validated['suffix'] ?? null,
            'gender' => $validated['gender'] ?? null,
            'birth_date' => $validated['birth_date'] ?? null,
            'civil_status' => $validated['civil_status'] ?? null,
            'nationality' => $validated['nationality'] ?? null,
            'barangay' => $validated['barangay'] ?? null,
            'house_no' => $validated['house_no'] ?? null,
            'street_name' => $validated['street_name'] ?? null,
            'purok' => $validated['purok'] ?? null,
            'province' => $validated['province'] ?? null,
            'municipality' => $validated['municipality'] ?? null,
            'zip_code' => $validated['zip_code'] ?? null,
            'address' => $formattedAddress ?: null,
            'clan_id' => $clan->id,
            'contact_number' => $validated['contact_number'] ?? null,
            'telephone_no' => $validated['telephone_no'] ?? null,
            'blood_type' => $validated['blood_type'] ?? null,
            'emergency_contact_name' => $validated['emergency_contact_name'] ?? null,
            'emergency_contact_no' => $validated['emergency_contact_no'] ?? null,
            'emergency_contact_relationship' => $validated['emergency_contact_relationship'] ?? null,
            'emergency_contact_address' => $validated['emergency_contact_address'] ?? null,
            'email' => $validated['email'] ?? null,
            'profile_image' => $profileImagePath,
            'signature' => $signaturePath,
        ]);

        // If marked as head of family, update the clan with resident_id and head_of_family name
        if ($validated['is_head_of_family'] ?? false) {
            $clan->update([
                'resident_id' => $resident->id,
                'head_of_family' => $resident->first_name . ' ' . $resident->last_name,
            ]);
        }

        // Generate username with counter for duplicate first names
        $firstName = strtolower(trim(str_replace(' ', '', $resident->first_name)));
        $lastName = strtolower(trim($resident->last_name));
        
        // Check if this first name already exists (with or without counter)
        $firstNamePattern = $firstName . '\\d*\\.';
        $existingCount = ResidentAccount::where('username', 'regexp', $firstNamePattern)->count();
        
        if ($existingCount > 0) {
            // Find the highest counter for this first name
            $maxCounter = 0;
            $accounts = ResidentAccount::whereRaw("username REGEXP ?", [$firstNamePattern])->get();
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
        while (ResidentAccount::where('username', $username)->exists()) {
            $username = $baseUsername . $counter;
            $counter++;
        }

        $password = Str::random(8);
        
        try {
            ResidentAccount::create([
                'resident_id' => $resident->id,
                'username' => $username,
                'password_hash' => Hash::make($password),
                'email' => $validated['email'] ?? null,
            ]);

            // Log the resident creation
            $residentName = "{$resident->first_name} {$resident->last_name}";
            ActivityLogger::logResidentAccount('created', $residentName, $resident->id);
            
        } catch (\Exception $e) {
            Log::error('Failed to create resident account: ' . $e->getMessage(), [
                'resident_id' => $resident->id,
                'username' => $username,
            ]);
            return redirect()->route('residents.create')->with([
                'error' => 'Resident added but failed to create account: ' . $e->getMessage()
            ]);
        }

        return redirect()->route('residents.create')->with([
            'success' => 'Resident added successfully!',
            'generated_account' => [
                'username' => $username,
                'password' => $password,
            ]
        ]);
    }

    public function show(Resident $resident)
    {
        $account = ResidentAccount::where('resident_id', $resident->id)->first();
        
        // Fetch appointments/request history for this resident
        $appointments = Appointment::where('resident_id', $resident->id)
            ->orderBy('scheduled_time', 'desc')
            ->get();
        
        // Fetch blotter records where resident is respondent/accused
        $blotterRecords = BlotterRecord::where('respondent_name', 'LIKE', '%' . $resident->first_name . '%')
            ->where('respondent_name', 'LIKE', '%' . $resident->last_name . '%')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('residents.show', [
            'resident' => [
                'id' => $resident->id,
                'first_name' => $resident->first_name,
                'middle_name' => $resident->middle_name,
                'last_name' => $resident->last_name,
                'suffix' => $resident->suffix,
                'gender' => $resident->gender,
                'birth_date' => $resident->birth_date,
                'age' => $resident->birth_date ? Carbon::parse($resident->birth_date)->age : null,
                'civil_status' => $resident->civil_status,
                'nationality' => $resident->nationality,
                'barangay' => $resident->barangay,
                'house_no' => $resident->house_no,
                'street_name' => $resident->street_name,
                'purok' => $resident->purok,
                'province' => $resident->province,
                'municipality' => $resident->municipality,
                'zip_code' => $resident->zip_code,
                'address' => $this->formatAddress($resident),
                'contact_number' => $resident->contact_number,
                'telephone_no' => $resident->telephone_no,
                'email' => $resident->email,
                'profile_image' => $resident->profile_image,
                'special_sector' => $resident->special_sector,
                'blood_type' => $resident->blood_type,
                'emergency_contact_name' => $resident->emergency_contact_name,
                'emergency_contact_no' => $resident->emergency_contact_no,
                'emergency_contact_relationship' => $resident->emergency_contact_relationship,
                'emergency_contact_address' => $resident->emergency_contact_address,
                'status' => $resident->status ?? 'active',
                'created_at' => $resident->created_at,
                'updated_at' => $resident->updated_at->timestamp,
            ],
            'account' => $account ? [
                'username' => $account->username,
                'created_at' => $account->created_at,
            ] : null,
            'appointments' => $appointments,
            'blotterRecords' => $blotterRecords,
        ]);
    }

    public function edit(Resident $resident)
    {
        $account = ResidentAccount::where('resident_id', $resident->id)->first();

        return view('residents.edit', [
            'resident' => [
                'id' => $resident->id,
                'first_name' => $resident->first_name,
                'middle_name' => $resident->middle_name,
                'last_name' => $resident->last_name,
                'suffix' => $resident->suffix,
                'gender' => $resident->gender,
                'birth_date' => $resident->birth_date,
                'civil_status' => $resident->civil_status,
                'nationality' => $resident->nationality,
                'barangay' => $resident->barangay,
                'house_no' => $resident->house_no,
                'street_name' => $resident->street_name,
                'purok' => $resident->purok,
                'province' => $resident->province,
                'municipality' => $resident->municipality,
                'zip_code' => $resident->zip_code,
                'address' => $resident->address,
                'contact_number' => $resident->contact_number,
                'telephone_no' => $resident->telephone_no,
                'email' => $resident->email,
                'profile_image' => $resident->profile_image,
                'signature' => $resident->signature,
                'special_sector' => $resident->special_sector,
                'blood_type' => $resident->blood_type,
                'is_head_of_family' => $resident->clan && $resident->clan->resident_id === $resident->id,
                'emergency_contact_name' => $resident->emergency_contact_name,
                'emergency_contact_no' => $resident->emergency_contact_no,
                'emergency_contact_relationship' => $resident->emergency_contact_relationship,
                'emergency_contact_address' => $resident->emergency_contact_address,
                'updated_at' => $resident->updated_at->timestamp,
            ],
            'account' => $account ? [
                'username' => $account->username,
                'created_at' => $account->created_at,
            ] : null
        ]);
    }

    public function update(Request $request, Resident $resident)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'suffix' => ['nullable', 'string', 'max:20'],
            'gender' => ['required', 'in:Male,Female'],
            'birth_date' => ['required', 'date'],
            'civil_status' => ['required', 'string', 'max:255'],
            'nationality' => ['nullable', 'string', 'max:255'],
            'barangay' => ['nullable', 'string', 'max:255'],
            'house_no' => ['nullable', 'string', 'max:255'],
            'street_name' => ['nullable', 'string', 'max:255'],
            'purok' => ['nullable', 'string', 'max:255'],
            'province' => ['nullable', 'string', 'max:255'],
            'municipality' => ['nullable', 'string', 'max:255'],
            'zip_code' => ['nullable', 'string', 'max:10'],
            'address' => ['nullable', 'string', 'max:500'],
            'contact_number' => ['required', 'string', 'max:20'],
            'telephone_no' => ['nullable', 'string', 'max:20'],
            'blood_type' => ['nullable', 'string', 'max:10'],
            'emergency_contact_name' => ['nullable', 'string', 'max:255'],
            'emergency_contact_no' => ['nullable', 'string', 'max:20'],
            'emergency_contact_relationship' => ['nullable', 'string', 'max:255'],
            'emergency_contact_address' => ['nullable', 'string', 'max:500'],
            'email' => ['nullable', 'email', 'max:255'],
            'is_head_of_family' => ['nullable', 'in:0,1'],
            'profile_image' => ['nullable', 'image', 'max:10240'],
            'profile_image_base64' => ['nullable', 'string', 'max:10485760'],
            'signature' => ['nullable', 'image', 'max:1024'],
            'signature_base64' => ['nullable', 'string', 'max:1048576'],
            'new_password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        if ($request->hasFile('profile_image')) {
            try {
                $file = $request->file('profile_image');
                
                if (!$file->isValid()) {
                    return redirect()->back()
                        ->withErrors(['profile_image' => 'The uploaded file is invalid or corrupted.'])
                        ->withInput();
                }
                
                $mimeType = $file->getMimeType();
                $allowedMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                if (!in_array($mimeType, $allowedMimes)) {
                    return redirect()->back()
                        ->withErrors(['profile_image' => 'Profile image must be a JPEG, PNG, GIF, or WebP file.'])
                        ->withInput();
                }
                
                if ($file->getSize() > 10485760) {
                    return redirect()->back()
                        ->withErrors(['profile_image' => 'Profile image must be less than 10MB.'])
                        ->withInput();
                }
                
                $filename = strtolower($validated['first_name'] . '.' . $validated['last_name'] . '.' . $file->getClientOriginalExtension());
                
                if (!Storage::disk('public')->exists('profile_images')) {
                    Storage::disk('public')->makeDirectory('profile_images', 0755, true);
                }
                
                $validated['profile_image'] = $file->storeAs('profile_images', $filename, 'public');
            } catch (\Throwable $e) {
                Log::error('Profile image update error: ' . $e->getMessage(), [
                    'file' => $request->file('profile_image')?->getClientOriginalName(),
                    'exception' => get_class($e),
                ]);
                return redirect()->back()
                    ->withErrors(['profile_image' => 'Error uploading profile image: ' . $e->getMessage()])
                    ->withInput();
            }
        } elseif (!empty($validated['profile_image_base64'])) {
            try {
                $base64Data = $validated['profile_image_base64'];
                if (strpos($base64Data, ',') !== false) {
                    list($header, $base64Data) = explode(',', $base64Data);
                }
                
                $imageData = base64_decode($base64Data, true);
                if ($imageData === false) {
                    return redirect()->back()
                        ->withErrors(['profile_image' => 'Invalid image data format.'])
                        ->withInput();
                }
                
                if (strlen($imageData) > 10485760) {
                    return redirect()->back()
                        ->withErrors(['profile_image' => 'Profile image must be less than 10MB.'])
                        ->withInput();
                }
                
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mimeType = finfo_buffer($finfo, $imageData);
                finfo_close($finfo);
                
                $allowedMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                if (!in_array($mimeType, $allowedMimes)) {
                    return redirect()->back()
                        ->withErrors(['profile_image' => 'Profile image must be a valid image file (JPEG, PNG, GIF, or WebP).'])
                        ->withInput();
                }
                
                $filename = strtolower($validated['first_name'] . '.' . $validated['last_name'] . '.png');
                $validated['profile_image'] = 'profile_images/' . $filename;
                
                if (!Storage::disk('public')->exists('profile_images')) {
                    Storage::disk('public')->makeDirectory('profile_images', 0755, true);
                }
                
                Storage::disk('public')->put($validated['profile_image'], $imageData);
            } catch (\Throwable $e) {
                Log::error('Profile image base64 update error: ' . $e->getMessage(), [
                    'exception' => get_class($e),
                    'size' => strlen($validated['profile_image_base64'] ?? ''),
                ]);
                return redirect()->back()
                    ->withErrors(['profile_image' => 'Error processing captured image: ' . $e->getMessage()])
                    ->withInput();
            }
        } else {
            unset($validated['profile_image']);
        }

        if ($request->hasFile('signature')) {
            try {
                $file = $request->file('signature');
                
                if (!$file->isValid()) {
                    return redirect()->back()
                        ->withErrors(['signature' => 'The uploaded signature file is invalid or corrupted.'])
                        ->withInput();
                }
                
                $mimeType = $file->getMimeType();
                $allowedMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                if (!in_array($mimeType, $allowedMimes)) {
                    return redirect()->back()
                        ->withErrors(['signature' => 'Signature must be a JPEG, PNG, GIF, or WebP file.'])
                        ->withInput();
                }
                
                if ($file->getSize() > 1048576) {
                    return redirect()->back()
                        ->withErrors(['signature' => 'Signature file must be less than 1MB.'])
                        ->withInput();
                }
                
                $filename = strtolower($validated['first_name'] . '.' . $validated['last_name'] . '_signature.' . $file->getClientOriginalExtension());
                
                if (!Storage::disk('public')->exists('signatures')) {
                    Storage::disk('public')->makeDirectory('signatures', 0755, true);
                }
                
                $validated['signature'] = $file->storeAs('signatures', $filename, 'public');
            } catch (\Throwable $e) {
                Log::error('Signature update error: ' . $e->getMessage(), [
                    'file' => $request->file('signature')?->getClientOriginalName(),
                    'exception' => get_class($e),
                ]);
                return redirect()->back()
                    ->withErrors(['signature' => 'Error uploading signature: ' . $e->getMessage()])
                    ->withInput();
            }
        } elseif (!empty($validated['signature_base64'])) {
            try {
                $base64Data = $validated['signature_base64'];
                if (strpos($base64Data, ',') !== false) {
                    list($header, $base64Data) = explode(',', $base64Data);
                }
                
                $imageData = base64_decode($base64Data, true);
                if ($imageData === false) {
                    return redirect()->back()
                        ->withErrors(['signature' => 'Invalid signature data format.'])
                        ->withInput();
                }
                
                if (strlen($imageData) > 1048576) {
                    return redirect()->back()
                        ->withErrors(['signature' => 'Signature file must be less than 1MB.'])
                        ->withInput();
                }
                
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mimeType = finfo_buffer($finfo, $imageData);
                finfo_close($finfo);
                
                $allowedMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                if (!in_array($mimeType, $allowedMimes)) {
                    return redirect()->back()
                        ->withErrors(['signature' => 'Signature must be a valid image file (JPEG, PNG, GIF, or WebP).'])
                        ->withInput();
                }
                
                $filename = strtolower($validated['first_name'] . '.' . $validated['last_name'] . '_signature.png');
                $validated['signature'] = 'signatures/' . $filename;
                
                if (!Storage::disk('public')->exists('signatures')) {
                    Storage::disk('public')->makeDirectory('signatures', 0755, true);
                }
                
                Storage::disk('public')->put($validated['signature'], $imageData);
            } catch (\Throwable $e) {
                Log::error('Signature base64 update error: ' . $e->getMessage(), [
                    'exception' => get_class($e),
                    'size' => strlen($validated['signature_base64'] ?? ''),
                ]);
                return redirect()->back()
                    ->withErrors(['signature' => 'Error processing signature: ' . $e->getMessage()])
                    ->withInput();
            }
        } else {
            unset($validated['signature']);
        }

        $validated['is_head_of_family'] = $validated['is_head_of_family'] ?? false;

        $resident->update($validated);

        // If marked as head of family, update the clan with resident_id and head_of_family name
        if ($validated['is_head_of_family'] && $resident->clan_id) {
            $resident->clan->update([
                'resident_id' => $resident->id,
                'head_of_family' => $resident->first_name . ' ' . $resident->last_name,
            ]);
        }

        // Update password if new password is provided
        if (!empty($validated['new_password'])) {
            $account = ResidentAccount::where('resident_id', $resident->id)->first();
            if ($account) {
                $account->update([
                    'password_hash' => bcrypt($validated['new_password']),
                ]);
                return redirect()->route('residents.show', $resident)->with('success', 'Resident and password updated successfully!');
            }
        }

        return redirect()->route('residents.show', $resident)->with('success', 'Resident updated successfully!');
    }

    public function destroy(Resident $resident)
    {
        // Delete profile image if exists
        if ($resident->profile_image) {
            $imagePath = storage_path('app/public/' . $resident->profile_image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $residentName = "{$resident->first_name} {$resident->last_name}";
        $residentId = $resident->id;

        ResidentAccount::where('resident_id', $resident->id)->delete();
        $resident->delete();

        // Log the deletion
        ActivityLogger::logResidentAccount('deleted', $residentName, $residentId);

        return redirect()->route('residents.index')->with('success', 'Resident deleted successfully!');
    }

    /**
     * Show public registration form
     */
    public function publicRegisterForm()
    {
        return view('auth.public-register');
    }

    /**
     * Store public resident registration
     */
    public function publicRegisterStore(Request $request)
    {

        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'middle_name' => 'nullable|string|max:100',
            'last_name' => 'required|string|max:100',
            'suffix' => 'nullable|string|max:20',
            'birth_date' => 'required|date|before:today',
            'gender' => 'required|in:Male,Female',
            'civil_status' => 'required|in:Single,Married,Widowed,Separated',
            'nationality' => 'nullable|string|max:50',
            'blood_type' => 'nullable|string|max:10',
            'house_no' => 'nullable|string|max:50',
            'street_name' => 'nullable|string|max:100',
            'purok' => 'nullable|string|max:50',
            'municipality' => 'nullable|string|max:100',
            'province' => 'nullable|string|max:100',
            'zip_code' => 'nullable|string|max:10',
            'contact_number' => 'nullable|string|max:20',
            'telephone_no' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'emergency_contact_name' => 'nullable|string|max:100',
            'emergency_contact_relationship' => 'nullable|string|max:50',
            'emergency_contact_no' => 'nullable|string|max:20',
            'emergency_contact_address' => 'nullable|string|max:255',
            'profile_image' => 'nullable|image|max:2048',
            'signature' => 'nullable|image|max:1024',
            'is_head_of_family' => 'nullable|boolean',
        ]);

        // Handle profile image upload
        $profileImagePath = null;
        if ($request->hasFile('profile_image')) {
            try {
                $file = $request->file('profile_image');
                
                if (!$file->isValid()) {
                    return redirect()->back()
                        ->withErrors(['profile_image' => 'The uploaded file is invalid or corrupted.'])
                        ->withInput();
                }
                
                $mimeType = $file->getMimeType();
                $allowedMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                if (!in_array($mimeType, $allowedMimes)) {
                    return redirect()->back()
                        ->withErrors(['profile_image' => 'Profile image must be a JPEG, PNG, GIF, or WebP file.'])
                        ->withInput();
                }
                
                if ($file->getSize() > 2097152) {
                    return redirect()->back()
                        ->withErrors(['profile_image' => 'Profile image must be less than 2MB.'])
                        ->withInput();
                }
                
                $filename = strtolower($validated['first_name'] . '.' . $validated['last_name'] . '.' . $file->getClientOriginalExtension());
                
                if (!Storage::disk('public')->exists('profile_images')) {
                    Storage::disk('public')->makeDirectory('profile_images', 0755, true);
                }
                
                $profileImagePath = $file->storeAs('profile_images', $filename, 'public');
            } catch (\Throwable $e) {
                Log::error('Public registration profile image error: ' . $e->getMessage(), [
                    'file' => $request->file('profile_image')?->getClientOriginalName(),
                    'exception' => get_class($e),
                ]);
                return redirect()->back()
                    ->withErrors(['profile_image' => 'Error uploading profile image: ' . $e->getMessage()])
                    ->withInput();
            }
        }

        // Handle signature upload
        $signaturePath = null;
        if ($request->hasFile('signature')) {
            try {
                $file = $request->file('signature');
                
                if (!$file->isValid()) {
                    return redirect()->back()
                        ->withErrors(['signature' => 'The uploaded signature file is invalid or corrupted.'])
                        ->withInput();
                }
                
                $mimeType = $file->getMimeType();
                $allowedMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                if (!in_array($mimeType, $allowedMimes)) {
                    return redirect()->back()
                        ->withErrors(['signature' => 'Signature must be a JPEG, PNG, GIF, or WebP file.'])
                        ->withInput();
                }
                
                if ($file->getSize() > 1048576) {
                    return redirect()->back()
                        ->withErrors(['signature' => 'Signature file must be less than 1MB.'])
                        ->withInput();
                }
                
                $filename = strtolower($validated['first_name'] . '.' . $validated['last_name'] . '_signature.' . $file->getClientOriginalExtension());
                
                if (!Storage::disk('public')->exists('signatures')) {
                    Storage::disk('public')->makeDirectory('signatures', 0755, true);
                }
                
                $signaturePath = $file->storeAs('signatures', $filename, 'public');
            } catch (\Throwable $e) {
                Log::error('Public registration signature error: ' . $e->getMessage(), [
                    'file' => $request->file('signature')?->getClientOriginalName(),
                    'exception' => get_class($e),
                ]);
                return redirect()->back()
                    ->withErrors(['signature' => 'Error uploading signature: ' . $e->getMessage()])
                    ->withInput();
            }
        }

        // Build address from parts
        $addressParts = [];
        if (!empty($validated['house_no'])) $addressParts[] = '#' . $validated['house_no'];
        if (!empty($validated['street_name'])) $addressParts[] = $validated['street_name'];
        if (!empty($validated['purok'])) $addressParts[] = 'Purok ' . $validated['purok'];
        $addressParts[] = 'Barangay Kalawaan';
        if (!empty($validated['municipality'])) $addressParts[] = $validated['municipality'];
        if (!empty($validated['province'])) $addressParts[] = $validated['province'];
        if (!empty($validated['zip_code'])) $addressParts[] = $validated['zip_code'];
        
        $fullAddress = implode(', ', array_filter($addressParts));

        // Auto-create or reuse clan (lastname only - same last name = same clan)
        // Normalize clan_name: trim whitespace for consistency
        $clanName = trim($validated['last_name']);
        $clan = Clan::where('clan_name', $clanName)->first();
        
        if (!$clan) {
            $clan = Clan::create(['clan_name' => $clanName]);
        }
        
        // Update clan address if this is the first resident or address was empty
        if (empty($clan->address)) {
            $clan->update(['address' => $fullAddress]);
        }

        // Create resident
        $resident = Resident::create([
            'first_name' => $validated['first_name'],
            'middle_name' => $validated['middle_name'] ?? null,
            'last_name' => $validated['last_name'],
            'suffix' => $validated['suffix'] ?? null,
            'birth_date' => $validated['birth_date'],
            'gender' => $validated['gender'],
            'civil_status' => $validated['civil_status'],
            'nationality' => $validated['nationality'] ?? 'Filipino',
            'blood_type' => $validated['blood_type'] ?? null,
            'house_no' => $validated['house_no'] ?? null,
            'street_name' => $validated['street_name'] ?? null,
            'purok' => $validated['purok'] ?? null,
            'barangay' => 'Kalawaan',
            'municipality' => $validated['municipality'] ?? 'Pasig City',
            'province' => $validated['province'] ?? 'Metro Manila',
            'zip_code' => $validated['zip_code'] ?? null,
            'address' => $fullAddress,
            'clan_id' => $clan->id,
            'contact_number' => $validated['contact_number'] ?? null,
            'telephone_no' => $validated['telephone_no'] ?? null,
            'email' => $validated['email'] ?? null,
            'profile_image' => $profileImagePath,
            'signature' => $signaturePath,
            'emergency_contact_name' => $validated['emergency_contact_name'] ?? null,
            'emergency_contact_relationship' => $validated['emergency_contact_relationship'] ?? null,
            'emergency_contact_no' => $validated['emergency_contact_no'] ?? null,
            'emergency_contact_address' => $validated['emergency_contact_address'] ?? null,
            'status' => 'pending_verification',
        ]);

        // If marked as head of family, update the clan with resident_id and head_of_family name
        if ($request->input('is_head_of_family')) {
            $clan->update([
                'resident_id' => $resident->id,
                'head_of_family' => $resident->first_name . ' ' . $resident->last_name,
            ]);
        }

        // Generate username with counter for duplicate first names
        $firstName = strtolower(trim(str_replace(' ', '', $resident->first_name)));
        $lastName = strtolower(trim($resident->last_name));
        
        // Check if this first name already exists (with or without counter)
        $firstNamePattern = $firstName . '\\d*\\.';
        $existingCount = ResidentAccount::where('username', 'regexp', $firstNamePattern)->count();
        
        if ($existingCount > 0) {
            // Find the highest counter for this first name
            $maxCounter = 0;
            $accounts = ResidentAccount::whereRaw("username REGEXP ?", [$firstNamePattern])->get();
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
        while (ResidentAccount::where('username', $username)->exists()) {
            $username = $baseUsername . $counter;
            $counter++;
        }

        $password = Str::random(8);
        
        // Create resident account
        ResidentAccount::create([
            'resident_id' => $resident->id,
            'username' => $username,
            'password_hash' => Hash::make($password),
            'email' => $validated['email'] ?? null,
        ]);

        return redirect()->route('public.register')
            ->with('success', 'Registration successful! Your account has been created.')
            ->with('generated_account', [
                'username' => $username,
                'password' => $password,
            ]);
    }

    public function export()
    {
        try {
            $residents = Resident::orderBy('last_name')->get();

            // Create a new spreadsheet
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('Residents');

            // Set headers - comprehensive with all form fields
            $headers = [
                'First Name', 'Middle Name', 'Last Name', 'Birth Date', 'Age', 'Gender', 
                'Civil Status', 'Nationality', 'Special Sector', 'Blood Type', 'Head of Family',
                'Barangay', 'House No.', 'Street Name', 'Purok', 'Province', 'Zip Code',
                'Contact Number', 'Telephone No', 'Email',
                'Emergency Contact Name', 'Emergency Contact Relationship', 'Emergency Contact No', 'Emergency Contact Address'
            ];
            
            foreach ($headers as $col => $header) {
                $sheet->setCellValueByColumnAndRow($col + 1, 1, $header);
            }

            // Style headers
            $headerStyle = $sheet->getStyle('A1:' . chr(64 + count($headers)) . '1');
            $headerStyle->getFont()->setBold(true)->getColor()->setARGB('FFFFFFFF');
            $headerStyle->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
            $headerStyle->getFill()->getStartColor()->setARGB('FF0038A8');
            $headerStyle->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $headerStyle->getAlignment()->setWrapText(true);

            // Add data rows
            $row = 2;
            foreach ($residents as $resident) {
                $sheet->setCellValueByColumnAndRow(1, $row, $resident->first_name);
                $sheet->setCellValueByColumnAndRow(2, $row, $resident->middle_name);
                $sheet->setCellValueByColumnAndRow(3, $row, $resident->last_name);
                $sheet->setCellValueByColumnAndRow(4, $row, Carbon::parse($resident->birth_date)->format('m/d/Y'));
                $sheet->setCellValueByColumnAndRow(5, $row, Carbon::parse($resident->birth_date)->age);
                $sheet->setCellValueByColumnAndRow(6, $row, substr($resident->gender, 0, 1) ?? '');
                $sheet->setCellValueByColumnAndRow(7, $row, $resident->civil_status);
                $sheet->setCellValueByColumnAndRow(8, $row, $resident->nationality ?? 'Filipino');
                $sheet->setCellValueByColumnAndRow(9, $row, $resident->special_sector ?? '');
                $sheet->setCellValueByColumnAndRow(10, $row, $resident->blood_type ?? '');
                $sheet->setCellValueByColumnAndRow(11, $row, isset($resident->is_head_of_family) && $resident->is_head_of_family ? 'Yes' : 'No');
                $sheet->setCellValueByColumnAndRow(12, $row, $resident->barangay);
                $sheet->setCellValueByColumnAndRow(13, $row, $resident->house_no ?? '');
                $sheet->setCellValueByColumnAndRow(14, $row, $resident->street_name ?? '');
                $sheet->setCellValueByColumnAndRow(15, $row, $resident->purok ?? '');
                $sheet->setCellValueByColumnAndRow(16, $row, $resident->province ?? 'Metro Manila');
                $sheet->setCellValueByColumnAndRow(17, $row, $resident->zip_code ?? '1600');
                $sheet->setCellValueByColumnAndRow(18, $row, $resident->contact_number);
                $sheet->setCellValueByColumnAndRow(19, $row, $resident->telephone_no ?? '');
                $sheet->setCellValueByColumnAndRow(20, $row, $resident->email ?? '');
                $sheet->setCellValueByColumnAndRow(21, $row, $resident->emergency_contact_name ?? '');
                $sheet->setCellValueByColumnAndRow(22, $row, $resident->emergency_contact_relationship ?? '');
                $sheet->setCellValueByColumnAndRow(23, $row, $resident->emergency_contact_no ?? '');
                $sheet->setCellValueByColumnAndRow(24, $row, $resident->emergency_contact_address ?? '');
                $row++;
            }

            // Adjust column widths
            $sheet->getColumnDimensionByColumn(1)->setWidth(12);
            $sheet->getColumnDimensionByColumn(2)->setWidth(12);
            $sheet->getColumnDimensionByColumn(3)->setWidth(12);
            $sheet->getColumnDimensionByColumn(4)->setWidth(12);
            $sheet->getColumnDimensionByColumn(5)->setWidth(8);
            $sheet->getColumnDimensionByColumn(6)->setWidth(8);
            $sheet->getColumnDimensionByColumn(7)->setWidth(12);
            $sheet->getColumnDimensionByColumn(8)->setWidth(12);
            $sheet->getColumnDimensionByColumn(9)->setWidth(15);
            $sheet->getColumnDimensionByColumn(10)->setWidth(10);
            $sheet->getColumnDimensionByColumn(11)->setWidth(10);
            $sheet->getColumnDimensionByColumn(12)->setWidth(12);
            $sheet->getColumnDimensionByColumn(13)->setWidth(10);
            $sheet->getColumnDimensionByColumn(14)->setWidth(12);
            $sheet->getColumnDimensionByColumn(15)->setWidth(10);
            $sheet->getColumnDimensionByColumn(16)->setWidth(12);
            $sheet->getColumnDimensionByColumn(17)->setWidth(10);
            $sheet->getColumnDimensionByColumn(18)->setWidth(15);
            $sheet->getColumnDimensionByColumn(19)->setWidth(15);
            $sheet->getColumnDimensionByColumn(20)->setWidth(20);
            $sheet->getColumnDimensionByColumn(21)->setWidth(20);
            $sheet->getColumnDimensionByColumn(22)->setWidth(15);
            $sheet->getColumnDimensionByColumn(23)->setWidth(15);
            $sheet->getColumnDimensionByColumn(24)->setWidth(25);

            // Freeze header row
            $sheet->freezePane('A2');

            // Save and return as download
            $writer = new Xlsx($spreadsheet);
            $filename = 'resident_records_' . now()->format('Y-m-d_H-i-s') . '.xlsx';

            return response()->stream(
                function () use ($writer) {
                    $writer->save('php://output');
                },
                200,
                [
                    'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                    'Cache-Control' => 'max-age=0',
                ]
            );
        } catch (\Exception $e) {
            Log::error('Export Error: ' . $e->getMessage());
            return redirect()->route('residents.index')->with('error', 'Failed to export file: ' . $e->getMessage());
        }
    }
}

