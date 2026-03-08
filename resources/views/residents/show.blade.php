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
                            <img src="{{ asset('storage/' . $resident['profile_image']) }}?t={{ $resident['updated_at'] }}&v={{ time() }}" alt="Profile" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <div class="w-100 h-100 d-flex align-items-center justify-content-center text-secondary" style="font-size: 4rem;">
                                <i class="bi bi-person"></i>
                            </div>
                        @endif
                    </div>

                    <!-- Name -->
                    <h2 class="fw-bold mb-1" style="font-size: 1.1rem;">{{ $resident['first_name'] }} {{ $resident['middle_name'] ?? '' }} {{ $resident['last_name'] }}{{ $resident['suffix'] ? ' ' . $resident['suffix'] : '' }}</h2>
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

        <!-- Details and Tabs Card -->
        <div class="col-md-9">
            <!-- Personal Information Card -->
            <div class="card border-0 shadow-sm mb-4">
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
                        <div class="col-md-6">
                            <div>
                                <p class="text-muted d-flex align-items-center gap-2 mb-1" style="font-size: 0.75rem;">
                                    <i class="bi bi-people"></i> Sector
                                </p>
                                <p class="fw-medium mb-0" style="font-size: 0.9rem;">{{ $resident['special_sector'] ?? '-' }}</p>
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

            <!-- Print Certificates Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header border-bottom py-2 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0" style="font-size: 0.95rem;">Print Certificates</h5>
                    <small class="text-muted">Auto-filled with resident details</small>
                </div>
                <div class="card-body p-3">
                    <div class="row g-2">
                        @php
                            $certificateTypes = [
                                'clearance' => 'Barangay Clearance',
                                'residency' => 'Certificate of Residency',
                                'indigency' => 'Certificate of Indigency',
                                'low_income' => 'Certificate of Low Income',
                                'no_income' => 'Certification of No Income',
                            ];
                        @endphp
                        @foreach($certificateTypes as $certificateTypeKey => $certificateTypeLabel)
                            <div class="col-md-6 col-lg-4">
                                <a href="{{ route('certificates.editor', ['type' => $certificateTypeKey, 'resident_id' => $resident['id']]) }}"
                                   class="btn btn-outline-primary w-100 d-flex align-items-center justify-content-center gap-2"
                                   style="font-size: 0.8rem;">
                                    <i class="bi bi-printer"></i>
                                    <span>{{ $certificateTypeLabel }}</span>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Tabs for Blotter Record and Request History -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-2 bg-light rounded">
                    <ul class="nav nav-pills nav-fill" role="tablist" style="gap: 0.5rem;">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active fw-bold text-dark bg-white shadow-sm py-2" id="blotter-tab" data-bs-toggle="tab" data-bs-target="#blotter" type="button" role="tab" aria-selected="true">Blotter Record</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link text-muted py-2" id="history-tab" data-bs-toggle="tab" data-bs-target="#history" type="button" role="tab" aria-selected="false">Request History</button>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Tab Content -->
            <div class="tab-content" id="residentTabContent" style="margin-top: 1rem;">
                <!-- Blotter Record Tab -->
                <div class="tab-pane fade show active" id="blotter" role="tabpanel" aria-labelledby="blotter-tab">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-file-text text-primary fs-5"></i>
                                <h5 class="fw-bold mb-0 text-dark">Blotter Records</h5>
                            </div>
                            <span class="text-muted">Total: {{ $blotterRecords->count() }}</span>
                        </div>
                        <div class="card-body p-4">
                            @if($blotterRecords->count() > 0)
                                <div class="d-flex flex-column gap-3">
                                    @foreach($blotterRecords as $blotter)
                                        <div class="card border rounded-3 p-3">
                                            <div class="d-flex justify-content-between align-items-start gap-3">
                                                <div style="flex: 1;">
                                                    <div class="d-flex align-items-center gap-2 mb-2">
                                                        <h6 class="fw-bold mb-0 text-dark fs-6">{{ $blotter->incident_type ?? 'Blotter Record' }}</h6>
                                                        <span class="badge rounded-pill px-3 bg-secondary">
                                                            {{ ucfirst($blotter->status ?? 'ongoing') }}
                                                        </span>
                                                    </div>
                                                    <div class="d-flex align-items-center gap-2 text-muted mb-1">
                                                        <i class="bi bi-person"></i>
                                                        <span>Respondent: {{ $blotter->respondent_name ?? 'N/A' }}</span>
                                                    </div>
                                                    <div class="d-flex align-items-center gap-2 text-muted mb-1">
                                                        <i class="bi bi-exclamation-circle"></i>
                                                        <span>Type: {{ $blotter->incident_type ?? 'N/A' }}</span>
                                                    </div>
                                                    <div class="d-flex align-items-center gap-2 text-muted mb-1">
                                                        <i class="bi bi-geo-alt"></i>
                                                        <span>Location: {{ $blotter->incident_location ?? 'N/A' }}</span>
                                                    </div>
                                                    <div class="d-flex align-items-center gap-2 text-muted">
                                                        <i class="bi bi-calendar"></i>
                                                        <span>Date: {{ $blotter->incident_date ? \Carbon\Carbon::parse($blotter->incident_date)->format('M d, Y') : 'N/A' }}</span>
                                                    </div>
                                                    @if($blotter->case_number)
                                                        <div class="text-primary mt-2 small">
                                                            Case #: {{ $blotter->case_number }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="d-flex flex-column gap-2" style="white-space: nowrap;">
                                                    <button class="btn btn-outline-secondary btn-sm">View</button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center text-muted py-5">
                                    <i class="bi bi-inbox fs-1 text-muted mb-2 d-block"></i>
                                    <p class="mb-0">No blotter records found.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Request History Tab -->
                <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-clock-history text-primary fs-5"></i>
                                <h5 class="fw-bold mb-0 text-dark">Request History</h5>
                            </div>
                            <span class="text-muted">Total: 0</span>
                        </div>
                        <div class="card-body p-4">
                            <div class="d-flex flex-column gap-3">
                                @forelse($appointments as $appointment)
                                    <div class="card border rounded-3 p-3">
                                        <div class="d-flex justify-content-between align-items-start gap-3">
                                            <div style="flex: 1;">
                                                <div class="d-flex align-items-center gap-2 mb-2">
                                                    <h6 class="fw-bold mb-0 text-dark fs-6">{{ $appointment->service_type ?? 'Request' }}</h6>
                                                    <span class="badge rounded-pill px-3 
                                                        {{ $appointment->status === 'approved' ? 'bg-success' : ($appointment->status === 'pending' ? 'bg-warning text-dark' : ($appointment->status === 'rejected' ? 'bg-danger' : 'bg-secondary')) }}">
                                                        {{ ucfirst($appointment->status ?? 'pending') }}
                                                    </span>
                                                </div>
                                                <div class="d-flex align-items-center gap-2 text-muted mb-1">
                                                    <i class="bi bi-file-earmark"></i>
                                                    <span>Service Type: {{ $appointment->service_type ?? 'N/A' }}</span>
                                                </div>
                                                <div class="d-flex align-items-center gap-2 text-muted mb-1">
                                                    <i class="bi bi-calendar"></i>
                                                    <span>Scheduled: {{ $appointment->scheduled_time ? \Carbon\Carbon::parse($appointment->scheduled_time)->format('M d, Y h:i A') : 'N/A' }}</span>
                                                </div>
                                                @if($appointment->status === 'approved')
                                                    <div class="d-flex align-items-center gap-2 text-muted">
                                                        <i class="bi bi-check-circle"></i>
                                                        <span>Request Approved</span>
                                                    </div>
                                                @elseif($appointment->status === 'pending')
                                                    <div class="d-flex align-items-center gap-2 text-muted">
                                                        <i class="bi bi-hourglass-split"></i>
                                                        <span>Awaiting Approval</span>
                                                    </div>
                                                @elseif($appointment->status === 'rejected')
                                                    <div class="d-flex align-items-center gap-2 text-muted">
                                                        <i class="bi bi-x-circle"></i>
                                                        <span>Request Rejected</span>
                                                    </div>
                                                @endif
                                                @if($appointment->reference_number)
                                                    <div class="text-primary mt-2 small">
                                                        Ref: {{ $appointment->reference_number }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="d-flex flex-column gap-2" style="white-space: nowrap;">
                                                <button class="btn btn-outline-secondary btn-sm">View</button>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="alert alert-info rounded-3 p-4 text-center mb-0">
                                        <i class="bi bi-info-circle fs-5 mb-2 d-block"></i>
                                        <p class="mb-0">No request history found for this resident.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
