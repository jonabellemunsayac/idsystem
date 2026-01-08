<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use App\Models\ResidentAccount;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Str;

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
                  ->orWhere('barangay', 'like', "%{$search}%");
            });
        }

        $residents = $query->orderBy('last_name')
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
            'gender' => ['required', 'in:Male,Female'],
            'birth_date' => ['required', 'date'],
            'civil_status' => ['required', 'string', 'max:255'],
            'nationality' => ['nullable', 'string', 'max:255'],
            'special_sector' => ['nullable', 'string', 'max:255'],
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
            'profile_image' => ['nullable', 'image', 'max:2048'],
        ]);

        $profileImagePath = null;
        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $filename = strtolower($validated['first_name'] . '.' . $validated['last_name'] . '.' . $file->getClientOriginalExtension());
            $profileImagePath = $file->storeAs('profile_images', $filename, 'public');
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

        $resident = Resident::create([
            'first_name' => $validated['first_name'],
            'middle_name' => $validated['middle_name'] ?? null,
            'last_name' => $validated['last_name'],
            'gender' => $validated['gender'] ?? null,
            'birth_date' => $validated['birth_date'] ?? null,
            'civil_status' => $validated['civil_status'] ?? null,
            'nationality' => $validated['nationality'] ?? null,
            'special_sector' => $validated['special_sector'] ?? null,
            'barangay' => $validated['barangay'] ?? null,
            'house_no' => $validated['house_no'] ?? null,
            'street_name' => $validated['street_name'] ?? null,
            'purok' => $validated['purok'] ?? null,
            'province' => $validated['province'] ?? null,
            'municipality' => $validated['municipality'] ?? null,
            'zip_code' => $validated['zip_code'] ?? null,
            'address' => $formattedAddress ?: null,
            'contact_number' => $validated['contact_number'] ?? null,
            'telephone_no' => $validated['telephone_no'] ?? null,
            'blood_type' => $validated['blood_type'] ?? null,
            'emergency_contact_name' => $validated['emergency_contact_name'] ?? null,
            'emergency_contact_no' => $validated['emergency_contact_no'] ?? null,
            'emergency_contact_relationship' => $validated['emergency_contact_relationship'] ?? null,
            'emergency_contact_address' => $validated['emergency_contact_address'] ?? null,
            'email' => $validated['email'] ?? null,
            'profile_image' => $profileImagePath,
        ]);

        // Generate username
        $firstName = strtolower(trim($resident->first_name));
        $lastName = strtolower(trim($resident->last_name));
        $baseUsername = $firstName . '.' . $lastName;

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

        return view('residents.show', [
            'resident' => [
                'id' => $resident->id,
                'first_name' => $resident->first_name,
                'middle_name' => $resident->middle_name,
                'last_name' => $resident->last_name,
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
            ],
            'account' => $account ? [
                'username' => $account->username,
                'created_at' => $account->created_at,
            ] : null,
        ]);
    }

    public function edit(Resident $resident)
    {
        return view('residents.edit', [
            'resident' => [
                'id' => $resident->id,
                'first_name' => $resident->first_name,
                'middle_name' => $resident->middle_name,
                'last_name' => $resident->last_name,
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
                'special_sector' => $resident->special_sector,
                'blood_type' => $resident->blood_type,
                'emergency_contact_name' => $resident->emergency_contact_name,
                'emergency_contact_no' => $resident->emergency_contact_no,
                'emergency_contact_relationship' => $resident->emergency_contact_relationship,
                'emergency_contact_address' => $resident->emergency_contact_address,
            ]
        ]);
    }

    public function update(Request $request, Resident $resident)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
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
            'profile_image' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $filename = strtolower($validated['first_name'] . '.' . $validated['last_name'] . '.' . $file->getClientOriginalExtension());
            $validated['profile_image'] = $file->storeAs('profile_images', $filename, 'public');
        } else {
            unset($validated['profile_image']);
        }

        $resident->update($validated);

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

        ResidentAccount::where('resident_id', $resident->id)->delete();
        $resident->delete();

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
            'birth_date' => 'required|date|before:today',
            'gender' => 'required|in:Male,Female',
            'civil_status' => 'required|in:Single,Married,Widowed,Separated',
            'nationality' => 'nullable|string|max:50',
            'special_sector' => 'nullable|string|max:50',
            'blood_type' => 'nullable|string|max:10',
            'house_no' => 'nullable|string|max:50',
            'street_name' => 'nullable|string|max:100',
            'purok' => 'nullable|string|max:50',
            'municipality' => 'nullable|string|max:100',
            'province' => 'nullable|string|max:100',
            'zip_code' => 'nullable|string|max:10',
            'contact_number' => 'nullable|string|max:20|unique:residents,contact_number',
            'telephone_no' => 'nullable|string|max:20',
            'email' => 'nullable|email|unique:residents,email',
            'emergency_contact_name' => 'nullable|string|max:100',
            'emergency_contact_relationship' => 'nullable|string|max:50',
            'emergency_contact_no' => 'nullable|string|max:20',
            'emergency_contact_address' => 'nullable|string|max:255',
            'profile_image' => 'nullable|image|max:2048',
        ]);

        // Handle profile image upload
        $profileImagePath = null;
        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $filename = strtolower($validated['first_name'] . '.' . $validated['last_name'] . '.' . $file->getClientOriginalExtension());
            $profileImagePath = $file->storeAs('profile_images', $filename, 'public');
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

        // Create resident
        $resident = Resident::create([
            'first_name' => $validated['first_name'],
            'middle_name' => $validated['middle_name'] ?? null,
            'last_name' => $validated['last_name'],
            'birth_date' => $validated['birth_date'],
            'gender' => $validated['gender'],
            'civil_status' => $validated['civil_status'],
            'nationality' => $validated['nationality'] ?? 'Filipino',
            'special_sector' => $validated['special_sector'] ?? null,
            'blood_type' => $validated['blood_type'] ?? null,
            'house_no' => $validated['house_no'] ?? null,
            'street_name' => $validated['street_name'] ?? null,
            'purok' => $validated['purok'] ?? null,
            'barangay' => 'Kalawaan',
            'municipality' => $validated['municipality'] ?? 'Pasig City',
            'province' => $validated['province'] ?? 'Metro Manila',
            'zip_code' => $validated['zip_code'] ?? null,
            'address' => $fullAddress,
            'contact_number' => $validated['contact_number'] ?? null,
            'telephone_no' => $validated['telephone_no'] ?? null,
            'email' => $validated['email'] ?? null,
            'profile_image' => $profileImagePath,
            'emergency_contact_name' => $validated['emergency_contact_name'] ?? null,
            'emergency_contact_relationship' => $validated['emergency_contact_relationship'] ?? null,
            'emergency_contact_no' => $validated['emergency_contact_no'] ?? null,
            'emergency_contact_address' => $validated['emergency_contact_address'] ?? null,
            'status' => 'pending_verification',
        ]);

        // Generate username
        $baseUsername = Str::of($resident->first_name)
            ->lower()
            ->trim()
            ->append('.')
            ->append(Str::of($resident->last_name)->lower()->trim());

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
}

