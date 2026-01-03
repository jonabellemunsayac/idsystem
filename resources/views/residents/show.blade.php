@extends('layouts.app')

@section('title', 'Resident Details')

@section('content')
<div class="mb-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('residents.index') }}" class="btn btn-secondary btn-sm" style="font-size: 0.75rem; padding: 0.3rem 0.6rem;">
                <i class="bi bi-arrow-left me-1"></i> Back
            </a>
            <div>
                <h1 class="fw-bold mb-0" style="font-size: 1.5rem;">Resident Details</h1>
                <p class="text-muted mb-0" style="font-size: 0.85rem;">View complete resident information</p>
            </div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('residents.edit', $resident['id']) }}" class="btn btn-primary btn-sm" style="font-size: 0.75rem; padding: 0.3rem 0.6rem;">
                <i class="bi bi-pencil me-1"></i> Edit
            </a>
            <form action="{{ route('residents.destroy', $resident['id']) }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm" style="font-size: 0.75rem; padding: 0.3rem 0.6rem;" onclick="return confirm('Are you sure?');">
                    <i class="bi bi-trash me-1"></i> Delete
                </button>
            </form>
        </div>
    </div>

    <!-- Content Grid -->
    <div class="row g-4">
        <!-- Profile Card -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex flex-column align-items-center text-center p-3">
                    <!-- Profile Image -->
                    <div style="width: 180px; height: 180px; border-radius: 50%; overflow: hidden; background-color: #f0f0f0; margin-bottom: 1rem; border: 3px solid #fff; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                        @if($resident['profile_image'])
                            <img src="{{ asset('storage/' . $resident['profile_image']) }}" alt="Profile" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <div class="w-100 h-100 d-flex align-items-center justify-content-center text-secondary" style="font-size: 4rem;">
                                <i class="bi bi-person"></i>
                            </div>
                        @endif
                    </div>

                    <!-- Name -->
                    <h2 class="fw-bold mb-1" style="font-size: 1.1rem;">{{ $resident['first_name'] }} {{ $resident['middle_name'] ?? '' }} {{ $resident['last_name'] }}</h2>
                    <p class="text-muted mb-3" style="font-size: 0.85rem;">{{ $resident['barangay'] ?? 'Barangay' }}</p>

                    <!-- Status Badge -->
                    <span class="badge bg-success mb-3" style="font-size: 0.75rem;">{{ $resident['status'] ?? 'Active' }}</span>

                    <!-- Divider -->
                    <hr class="w-100 my-2">

                    <!-- Account Info -->
                    <div class="w-100 text-start" style="font-size: 0.85rem;">
                        <div class="mb-3">
                            <p class="text-muted mb-1" style="font-size: 0.75rem;">Account Username</p>
                            <p class="fw-medium mb-0">{{ $account['username'] ?? 'No account' }}</p>
                        </div>
                        <div>
                            <p class="text-muted mb-1" style="font-size: 0.75rem;">Registration Date</p>
                            <p class="fw-medium mb-0">{{ \Carbon\Carbon::parse($resident['created_at'])->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Details Card -->
        <div class="col-md-9">
            <div class="card border-0 shadow-sm">
                <div class="card-header border-bottom py-2">
                    <h5 class="fw-bold mb-0" style="font-size: 0.95rem;">Personal Information</h5>
                </div>
                <div class="card-body p-3">
                    <!-- Personal Details Grid -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div>
                                <p class="text-muted d-flex align-items-center gap-2 mb-1" style="font-size: 0.75rem;">
                                    <i class="bi bi-calendar"></i> Birth Date
                                </p>
                                <p class="fw-medium mb-0" style="font-size: 0.9rem;">{{ \Carbon\Carbon::parse($resident['birth_date'])->format('M d, Y') }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div>
                                <p class="text-muted d-flex align-items-center gap-2 mb-1" style="font-size: 0.75rem;">
                                    <i class="bi bi-person"></i> Age
                                </p>
                                <p class="fw-medium mb-0" style="font-size: 0.9rem;">{{ $resident['age'] ?? 'N/A' }} years old</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div>
                                <p class="text-muted d-flex align-items-center gap-2 mb-1" style="font-size: 0.75rem;">
                                    <i class="bi bi-person"></i> Gender
                                </p>
                                <p class="fw-medium mb-0" style="font-size: 0.9rem;">{{ $resident['gender'] }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div>
                                <p class="text-muted d-flex align-items-center gap-2 mb-1" style="font-size: 0.75rem;">
                                    <i class="bi bi-heart"></i> Civil Status
                                </p>
                                <p class="fw-medium mb-0" style="font-size: 0.9rem;">{{ $resident['civil_status'] }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div>
                                <p class="text-muted d-flex align-items-center gap-2 mb-1" style="font-size: 0.75rem;">
                                    <i class="bi bi-flag"></i> Nationality
                                </p>
                                <p class="fw-medium mb-0" style="font-size: 0.9rem;">{{ $resident['nationality'] ?? 'Filipino' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Divider -->
                    <hr class="my-3">

                    <!-- Contact Information Section -->
                    <h6 class="fw-bold mb-3" style="font-size: 0.9rem;">Contact Information</h6>
                    <div class="row g-3">
                        <div class="col-12">
                            <div>
                                <p class="text-muted d-flex align-items-center gap-2 mb-1" style="font-size: 0.75rem;">
                                    <i class="bi bi-geo-alt"></i> Address
                                </p>
                                <p class="fw-medium mb-0" style="font-size: 0.9rem;">{{ $resident['address'] ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div>
                                <p class="text-muted d-flex align-items-center gap-2 mb-1" style="font-size: 0.75rem;">
                                    <i class="bi bi-telephone"></i> Contact Number
                                </p>
                                <p class="fw-medium mb-0" style="font-size: 0.9rem;">{{ $resident['contact_number'] }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div>
                                <p class="text-muted d-flex align-items-center gap-2 mb-1" style="font-size: 0.75rem;">
                                    <i class="bi bi-envelope"></i> Email Address
                                </p>
                                <p class="fw-medium mb-0" style="font-size: 0.9rem;">{{ $resident['email'] ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    @if($resident['emergency_contact_name'])
                    <!-- Divider -->
                    <hr class="my-3">

                    <!-- Emergency Contact Section -->
                    <h6 class="fw-bold mb-3" style="font-size: 0.9rem;"><i class="bi bi-exclamation-circle me-1"></i> Emergency Contact</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div>
                                <p class="text-muted mb-1" style="font-size: 0.75rem;">Name</p>
                                <p class="fw-medium mb-0" style="font-size: 0.9rem;">{{ $resident['emergency_contact_name'] }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div>
                                <p class="text-muted mb-1" style="font-size: 0.75rem;">Relationship</p>
                                <p class="fw-medium mb-0" style="font-size: 0.9rem;">{{ $resident['emergency_contact_relationship'] ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div>
                                <p class="text-muted mb-1" style="font-size: 0.75rem;">Contact Number</p>
                                <p class="fw-medium mb-0" style="font-size: 0.9rem;">{{ $resident['emergency_contact_no'] ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div>
                                <p class="text-muted mb-1" style="font-size: 0.75rem;">Address</p>
                                <p class="fw-medium mb-0" style="font-size: 0.9rem;">{{ $resident['emergency_contact_address'] ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
