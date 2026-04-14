@extends('layouts.resident')

@section('title', 'My Profile - Resident Portal')

@section('content')
<div class="mb-4">
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h1 class="fw-bold mb-0" style="font-size: 1.5rem;">My Profile</h1>
            <p class="text-muted mb-0" style="font-size: 0.85rem;">View your resident information in the same structure used by the admin records.</p>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex flex-column align-items-center text-center p-3">
                    <div style="width: 180px; height: 180px; border-radius: 50%; overflow: hidden; background-color: #f0f0f0; margin-bottom: 1rem; border: 3px solid #fff; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                        @if($resident['profile_image'])
                            <img src="{{ asset('storage/' . $resident['profile_image']) }}" alt="Profile" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <div class="w-100 h-100 d-flex align-items-center justify-content-center text-secondary" style="font-size: 4rem;">
                                <i class="bi bi-person"></i>
                            </div>
                        @endif
                    </div>

                    <h2 class="fw-bold mb-1" style="font-size: 1.1rem;">{{ $resident['display_name'] }}</h2>
                    <p class="text-muted mb-3" style="font-size: 0.85rem;">{{ $resident['barangay'] ?? 'Barangay' }}</p>

                    <span class="badge bg-success mb-3" style="font-size: 0.75rem;">Active</span>

                    <hr class="w-100 my-2">

                    <div class="w-100 text-start" style="font-size: 0.85rem;">
                        <div class="mb-3">
                            <p class="text-muted mb-1" style="font-size: 0.75rem;">Account Username</p>
                            <p class="fw-medium mb-0">{{ $account['username'] ?? 'No account' }}</p>
                        </div>
                        <div class="mb-3">
                            <p class="text-muted mb-1" style="font-size: 0.75rem;">Account Email</p>
                            <p class="fw-medium mb-0">{{ $account['email'] ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-muted mb-1" style="font-size: 0.75rem;">Registration Date</p>
                            <p class="fw-medium mb-0">{{ \Carbon\Carbon::parse($resident['created_at'])->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header border-bottom py-2">
                    <h5 class="fw-bold mb-0" style="font-size: 0.95rem;">Personal Information</h5>
                </div>
                <div class="card-body p-3">
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <p class="text-muted d-flex align-items-center gap-2 mb-1" style="font-size: 0.75rem;"><i class="bi bi-calendar"></i> Birth Date</p>
                            <p class="fw-medium mb-0" style="font-size: 0.9rem;">{{ $resident['birth_date'] ? \Carbon\Carbon::parse($resident['birth_date'])->format('M d, Y') : '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted d-flex align-items-center gap-2 mb-1" style="font-size: 0.75rem;"><i class="bi bi-person"></i> Age</p>
                            <p class="fw-medium mb-0" style="font-size: 0.9rem;">{{ $resident['age'] ?? 'N/A' }} years old</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted d-flex align-items-center gap-2 mb-1" style="font-size: 0.75rem;"><i class="bi bi-gender-ambiguous"></i> Gender</p>
                            <p class="fw-medium mb-0" style="font-size: 0.9rem;">{{ $resident['gender'] ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted d-flex align-items-center gap-2 mb-1" style="font-size: 0.75rem;"><i class="bi bi-heart"></i> Civil Status</p>
                            <p class="fw-medium mb-0" style="font-size: 0.9rem;">{{ $resident['civil_status'] ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted d-flex align-items-center gap-2 mb-1" style="font-size: 0.75rem;"><i class="bi bi-flag"></i> Nationality</p>
                            <p class="fw-medium mb-0" style="font-size: 0.9rem;">{{ $resident['nationality'] ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted d-flex align-items-center gap-2 mb-1" style="font-size: 0.75rem;"><i class="bi bi-people"></i> Sector</p>
                            <p class="fw-medium mb-0" style="font-size: 0.9rem;">{{ $resident['special_sector'] ?? '-' }}</p>
                        </div>
                    </div>

                    <hr class="my-3">

                    <h6 class="fw-bold mb-3" style="font-size: 0.9rem;">Contact Information</h6>
                    <div class="row g-3">
                        <div class="col-12">
                            <p class="text-muted d-flex align-items-center gap-2 mb-1" style="font-size: 0.75rem;"><i class="bi bi-geo-alt"></i> Address</p>
                            <p class="fw-medium mb-0" style="font-size: 0.9rem;">{{ $resident['address'] ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted d-flex align-items-center gap-2 mb-1" style="font-size: 0.75rem;"><i class="bi bi-telephone"></i> Mobile Number</p>
                            <p class="fw-medium mb-0" style="font-size: 0.9rem;">{{ $resident['contact_number'] ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted d-flex align-items-center gap-2 mb-1" style="font-size: 0.75rem;"><i class="bi bi-telephone-inbound"></i> Telephone No</p>
                            <p class="fw-medium mb-0" style="font-size: 0.9rem;">{{ $resident['telephone_no'] ?? '-' }}</p>
                        </div>
                        <div class="col-md-12">
                            <p class="text-muted d-flex align-items-center gap-2 mb-1" style="font-size: 0.75rem;"><i class="bi bi-envelope"></i> Email Address</p>
                            <p class="fw-medium mb-0" style="font-size: 0.9rem;">{{ $resident['email'] ?? '-' }}</p>
                        </div>
                    </div>

                    <hr class="my-3">

                    <h6 class="fw-bold mb-3" style="font-size: 0.9rem;">Additional Information</h6>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <p class="text-muted mb-1" style="font-size: 0.75rem;">Blood Type</p>
                            <p class="fw-medium mb-0" style="font-size: 0.9rem;">{{ $resident['blood_type'] ?? '-' }}</p>
                        </div>
                        <div class="col-md-4">
                            <p class="text-muted mb-1" style="font-size: 0.75rem;">Household Composition</p>
                            <p class="fw-medium mb-0" style="font-size: 0.9rem;">{{ $resident['household_composition'] ?? '-' }}</p>
                        </div>
                        <div class="col-md-4">
                            <p class="text-muted mb-1" style="font-size: 0.75rem;">Religion</p>
                            <p class="fw-medium mb-0" style="font-size: 0.9rem;">{{ $resident['religion'] ?? '-' }}</p>
                        </div>
                        <div class="col-md-4">
                            <p class="text-muted mb-1" style="font-size: 0.75rem;">Height</p>
                            <p class="fw-medium mb-0" style="font-size: 0.9rem;">{{ $resident['height_cm'] ? $resident['height_cm'] . ' cm' : '-' }}</p>
                        </div>
                        <div class="col-md-4">
                            <p class="text-muted mb-1" style="font-size: 0.75rem;">Weight</p>
                            <p class="fw-medium mb-0" style="font-size: 0.9rem;">{{ $resident['weight_kg'] ? $resident['weight_kg'] . ' kgs' : '-' }}</p>
                        </div>
                        <div class="col-md-4">
                            <p class="text-muted mb-1" style="font-size: 0.75rem;">Occupation</p>
                            <p class="fw-medium mb-0" style="font-size: 0.9rem;">{{ $resident['occupation'] ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-1" style="font-size: 0.75rem;">Father's Name</p>
                            <p class="fw-medium mb-0" style="font-size: 0.9rem;">{{ $resident['father_name'] ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-1" style="font-size: 0.75rem;">Mother's Maiden Name</p>
                            <p class="fw-medium mb-0" style="font-size: 0.9rem;">{{ $resident['mother_maiden_name'] ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-1" style="font-size: 0.75rem;">Spouse</p>
                            <p class="fw-medium mb-0" style="font-size: 0.9rem;">{{ $resident['spouse_name'] ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-1" style="font-size: 0.75rem;">Name/s of Children</p>
                            <p class="fw-medium mb-0" style="font-size: 0.9rem;">{{ $resident['children_names'] ?? '-' }}</p>
                        </div>
                        <div class="col-md-4">
                            <p class="text-muted mb-1" style="font-size: 0.75rem;">Employment Type</p>
                            <p class="fw-medium mb-0" style="font-size: 0.9rem;">{{ $resident['employment_type'] ?? '-' }}</p>
                        </div>
                        <div class="col-md-4">
                            <p class="text-muted mb-1" style="font-size: 0.75rem;">Economic Status</p>
                            <p class="fw-medium mb-0" style="font-size: 0.9rem;">{{ $resident['economic_status'] ?? '-' }}</p>
                        </div>
                        <div class="col-md-4">
                            <p class="text-muted mb-1" style="font-size: 0.75rem;">Residency Type</p>
                            <p class="fw-medium mb-0" style="font-size: 0.9rem;">{{ $resident['residency_type'] ?? '-' }}</p>
                        </div>
                        <div class="col-md-4">
                            <p class="text-muted mb-1" style="font-size: 0.75rem;">Tenure Status</p>
                            <p class="fw-medium mb-0" style="font-size: 0.9rem;">{{ $resident['tenure_status'] ?? '-' }}</p>
                        </div>
                        <div class="col-md-4">
                            <p class="text-muted mb-1" style="font-size: 0.75rem;">Length of Stay</p>
                            <p class="fw-medium mb-0" style="font-size: 0.9rem;">{{ $resident['length_of_stay'] ?? '-' }}</p>
                        </div>
                        <div class="col-md-4">
                            <p class="text-muted mb-1" style="font-size: 0.75rem;">Registered Voter</p>
                            <p class="fw-medium mb-0" style="font-size: 0.9rem;">{{ $resident['registered_voter'] ?? '-' }}</p>
                        </div>
                        <div class="col-md-4">
                            <p class="text-muted mb-1" style="font-size: 0.75rem;">Precinct No.</p>
                            <p class="fw-medium mb-0" style="font-size: 0.9rem;">{{ $resident['precinct_no'] ?? '-' }}</p>
                        </div>
                    </div>

                    <hr class="my-3">

                    <h6 class="fw-bold mb-3" style="font-size: 0.9rem;">Address Details</h6>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <p class="text-muted mb-1" style="font-size: 0.75rem;">House No./Unit/Bldg</p>
                            <p class="fw-medium mb-0" style="font-size: 0.9rem;">{{ $resident['house_no'] ?? '-' }}</p>
                        </div>
                        <div class="col-md-4">
                            <p class="text-muted mb-1" style="font-size: 0.75rem;">Street Name</p>
                            <p class="fw-medium mb-0" style="font-size: 0.9rem;">{{ $resident['street_name'] ?? '-' }}</p>
                        </div>
                        <div class="col-md-4">
                            <p class="text-muted mb-1" style="font-size: 0.75rem;">Purok</p>
                            <p class="fw-medium mb-0" style="font-size: 0.9rem;">{{ $resident['purok'] ?? '-' }}</p>
                        </div>
                        <div class="col-md-4">
                            <p class="text-muted mb-1" style="font-size: 0.75rem;">Barangay</p>
                            <p class="fw-medium mb-0" style="font-size: 0.9rem;">{{ $resident['barangay'] ?? '-' }}</p>
                        </div>
                        <div class="col-md-4">
                            <p class="text-muted mb-1" style="font-size: 0.75rem;">City / Municipality</p>
                            <p class="fw-medium mb-0" style="font-size: 0.9rem;">{{ $resident['municipality'] ?? '-' }}</p>
                        </div>
                        <div class="col-md-4">
                            <p class="text-muted mb-1" style="font-size: 0.75rem;">Province</p>
                            <p class="fw-medium mb-0" style="font-size: 0.9rem;">{{ $resident['province'] ?? '-' }}</p>
                        </div>
                        <div class="col-md-4">
                            <p class="text-muted mb-1" style="font-size: 0.75rem;">Zip Code</p>
                            <p class="fw-medium mb-0" style="font-size: 0.9rem;">{{ $resident['zip_code'] ?? '-' }}</p>
                        </div>
                    </div>

                    @if($resident['emergency_contact_name'] || $resident['emergency_contact_no'] || $resident['emergency_contact_address'])
                        <hr class="my-3">

                        <h6 class="fw-bold mb-3" style="font-size: 0.9rem;"><i class="bi bi-exclamation-circle me-1"></i> Emergency Contact</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <p class="text-muted mb-1" style="font-size: 0.75rem;">Name</p>
                                <p class="fw-medium mb-0" style="font-size: 0.9rem;">{{ $resident['emergency_contact_name'] ?? '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="text-muted mb-1" style="font-size: 0.75rem;">Relationship</p>
                                <p class="fw-medium mb-0" style="font-size: 0.9rem;">{{ $resident['emergency_contact_relationship'] ?? '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="text-muted mb-1" style="font-size: 0.75rem;">Contact Number</p>
                                <p class="fw-medium mb-0" style="font-size: 0.9rem;">{{ $resident['emergency_contact_no'] ?? '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="text-muted mb-1" style="font-size: 0.75rem;">Address</p>
                                <p class="fw-medium mb-0" style="font-size: 0.9rem;">{{ $resident['emergency_contact_address'] ?? '-' }}</p>
                            </div>
                        </div>
                    @endif

                    @if($resident['signature'])
                        <hr class="my-3">

                        <h6 class="fw-bold mb-3" style="font-size: 0.9rem;">Signature</h6>
                        <div class="border rounded p-3 bg-light d-inline-block">
                            <img src="{{ asset('storage/' . $resident['signature']) }}" alt="Signature" style="max-width: 220px; max-height: 100px; background: transparent;">
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
