@extends('layouts.app')

@section('title', 'Appointments')

@section('extra-styles')
    {{-- Styles are loaded from list-views.css --}}
    <style>
        .nav-tabs .nav-link {
            color: #6b7280;
            border: none;
            border-bottom: 2px solid transparent;
            padding: 0.75rem 1.5rem;
            transition: all 0.3s;
        }
        
        .nav-tabs .nav-link:hover {
            color: #0038A8;
            border-bottom-color: #0038A8;
        }
        
        .nav-tabs .nav-link.active {
            color: #0038A8;
            background-color: transparent;
            border-bottom-color: #0038A8;
            font-weight: 600;
        }
        
        .tab-content .tab-pane {
            animation: fadeIn 0.3s ease-in;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
    </style>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h4 fw-bold text-dark mb-1">Appointments</h1>
        <p class="text-muted mb-0">Manage and schedule resident appointments</p>
    </div>
    <a href="{{ route('appointments.create') }}" class="btn btn-primary" style="background-color: #0038A8; border-color: #0038A8; padding: 0.5rem 1rem; font-size: 0.95rem;">
        <i class="bi bi-plus-lg me-1"></i> New Appointment
    </a>
</div>

<!-- Appointments Tabs -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0 py-0 px-4">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="schedule-tab" data-bs-toggle="tab" data-bs-target="#schedule-pane" type="button" role="tab" aria-controls="schedule-pane" aria-selected="true">
                    <i class="bi bi-calendar-check me-2"></i>Appointment Schedule
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="logs-tab" data-bs-toggle="tab" data-bs-target="#logs-pane" type="button" role="tab" aria-controls="logs-pane" aria-selected="false">
                    <i class="bi bi-clock-history me-2"></i>Appointment Logs
                </button>
            </li>
        </ul>
    </div>

    <div class="card-body p-4">
        <div class="tab-content">
            <!-- Tab 1: Appointment Schedule -->
            <div class="tab-pane fade show active" id="schedule-pane" role="tabpanel" aria-labelledby="schedule-tab">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <h5 class="fw-bold mb-0 text-dark">Active Appointments</h5>
                    <span class="text-muted">({{ $appointments->count() }} total)</span>
                </div>
                
                <!-- Search Bar -->
                <form method="GET" action="{{ route('appointments.index') }}" class="mb-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" placeholder="Search by resident name..." name="search" value="{{ request('search') }}">
                        @if(request('search'))
                            <a href="{{ route('appointments.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x"></i>
                            </a>
                        @endif
                    </div>
                </form>

                <div class="d-flex flex-column gap-3" style="min-height: 400px;">
                    @if($appointments->total() == 0)
                        <div class="text-center py-5">
                            <i class="bi bi-inbox fs-1 text-muted d-block mb-3"></i>
                            <p class="text-muted mb-0">No appointments found</p>
                        </div>
                    @else
                        @foreach($appointments as $appointment)
                        <div class="card border rounded-3 p-3">
                            <div class="d-flex justify-content-between align-items-start gap-3">
                                <div style="flex: 1;">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <h6 class="fw-bold mb-0 text-dark fs-6">{{ $appointment['resident_name'] ?? 'Resident Name' }}</h6>
                                        @if($appointment['status'] == 'pending')
                                            <span class="badge bg-danger rounded-pill px-3" style="font-weight: 600;">⚠ PENDING</span>
                                        @elseif($appointment['status'] == 'confirmed')
                                            <span class="badge bg-success rounded-pill px-3">Confirmed</span>
                                        @elseif($appointment['status'] == 'completed')
                                            <span class="badge bg-info rounded-pill px-3">Completed</span>
                                        @elseif($appointment['status'] == 'cancelled')
                                            <span class="badge bg-secondary rounded-pill px-3">Cancelled</span>
                                        @else
                                            <span class="badge bg-secondary rounded-pill px-3">{{ ucfirst($appointment['status']) }}</span>
                                        @endif
                                    </div>
                                    <div class="d-flex align-items-center gap-2 text-muted mb-1">
                                        <i class="bi bi-file-text"></i>
                                        <span>{{ $appointment['purpose'] ?? 'Certificate Request' }}</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2 text-muted mb-1">
                                        <i class="bi bi-calendar"></i>
                                        <span>{{ \Carbon\Carbon::parse($appointment['appointment_date'])->format('Y-m-d') }}</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2 text-muted">
                                        <i class="bi bi-clock"></i>
                                        <span>{{ \Carbon\Carbon::parse($appointment['appointment_date'])->format('h:i A') }}</span>
                                    </div>
                                    <div class="text-primary mt-2 small">
                                        Ref: APT_{{ strtoupper(substr($appointment['resident_name'] ?? 'RES', 0, 3)) }}_{{ \Carbon\Carbon::parse($appointment['appointment_date'])->format('mdy') }}_0{{ $loop->iteration }}
                                    </div>
                                </div>
                                <div class="d-flex flex-column gap-2" style="white-space: nowrap;">
                                    <a href="{{ route('appointments.show', $appointment['id']) }}" class="btn btn-outline-secondary btn-sm">Details</a>
                                    @if($appointment['status'] == 'pending')
                                        <button class="btn btn-success btn-sm text-white approve-btn" data-appointment-id="{{ $appointment['id'] }}" style="background-color: #198754;">Approve</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
                
                <!-- Pagination -->
                @if($appointments->total() > 0)
                <div class="mt-4 pt-3 border-top">
                    <div style="font-size: 0.875rem;">
                        {{ $appointments->links('vendor.pagination.custom') }}
                    </div>
                </div>
                @endif
            </div>

            <!-- Tab 2: Appointment Logs -->
            <div class="tab-pane fade" id="logs-pane" role="tabpanel" aria-labelledby="logs-tab">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <h5 class="fw-bold mb-0 text-dark">Appointment History</h5>
                    <span class="text-muted">({{ $appointmentsLog->count() }} total)</span>
                </div>
                
                <!-- Search Bar -->
                <form method="GET" action="{{ route('appointments.index') }}" class="mb-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" placeholder="Search by resident name..." name="search" value="{{ request('search') }}">
                        @if(request('search'))
                            <a href="{{ route('appointments.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x"></i>
                            </a>
                        @endif
                    </div>
                </form>

                <div class="d-flex flex-column gap-3" style="min-height: 400px;">
                    @if($appointmentsLog->total() == 0)
                        <div class="text-center py-5">
                            <i class="bi bi-inbox fs-1 text-muted d-block mb-3"></i>
                            <p class="text-muted mb-0">No appointment logs found</p>
                        </div>
                    @else
                        @foreach($appointmentsLog as $appointment)
                        <div class="card border rounded-3 p-3">
                            <div class="d-flex justify-content-between align-items-start gap-3">
                                <div style="flex: 1;">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <h6 class="fw-bold mb-0 text-dark fs-6">{{ $appointment['resident_name'] ?? 'Resident Name' }}</h6>
                                        @if($appointment['status'] == 'confirmed')
                                            <span class="badge bg-success rounded-pill px-3">Confirmed</span>
                                        @elseif($appointment['status'] == 'cancelled')
                                            <span class="badge bg-secondary rounded-pill px-3">Cancelled</span>
                                        @else
                                            <span class="badge bg-secondary rounded-pill px-3">{{ ucfirst($appointment['status']) }}</span>
                                        @endif
                                    </div>
                                    <div class="d-flex align-items-center gap-2 text-muted mb-1">
                                        <i class="bi bi-file-text"></i>
                                        <span>{{ $appointment['purpose'] ?? 'Certificate Request' }}</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2 text-muted mb-1">
                                        <i class="bi bi-calendar"></i>
                                        <span>{{ \Carbon\Carbon::parse($appointment['appointment_date'])->format('Y-m-d') }}</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2 text-muted">
                                        <i class="bi bi-clock"></i>
                                        <span>{{ \Carbon\Carbon::parse($appointment['appointment_date'])->format('h:i A') }}</span>
                                    </div>
                                    <div class="text-primary mt-2 small">
                                        Ref: APT_{{ strtoupper(substr($appointment['resident_name'] ?? 'RES', 0, 3)) }}_{{ \Carbon\Carbon::parse($appointment['appointment_date'])->format('mdy') }}_0{{ $loop->iteration }}
                                    </div>
                                </div>
                                <div class="d-flex flex-column gap-2" style="white-space: nowrap;">
                                    <a href="{{ route('appointments.show', $appointment['id']) }}" class="btn btn-outline-secondary btn-sm">Details</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
                
                <!-- Pagination -->
                @if($appointmentsLog->total() > 0)
                <div class="mt-4 pt-3 border-top">
                    <div style="font-size: 0.875rem;">
                        {{ $appointmentsLog->links('vendor.pagination.custom') }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Handle appointment approval
    document.querySelectorAll('.approve-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const appointmentId = this.getAttribute('data-appointment-id');
            
            Swal.fire({
                title: 'Confirm Approval',
                text: 'Are you sure you want to approve this appointment?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#0038A8',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, Approve',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/appointments/${appointmentId}/approve`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: 'Success!',
                                text: 'Appointment has been approved successfully.',
                                icon: 'success',
                                confirmButtonColor: '#0038A8'
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error', data.message || 'Failed to approve appointment.', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Error', 'An error occurred while approving the appointment. Please try again.', 'error');
                    });
                }
            });
        });
    });

    // Handle certificate approval
    document.querySelectorAll('.approve-cert-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const certId = this.getAttribute('data-cert-id');
            
            Swal.fire({
                title: 'Confirm Approval',
                text: 'Are you sure you want to approve this certificate request?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#198754',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, Approve',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/certificates/${certId}/approve`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: 'Success!',
                                text: data.message || 'Certificate has been approved successfully.',
                                icon: 'success',
                                confirmButtonColor: '#198754'
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error', data.message || 'Failed to approve certificate.', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Error', 'An error occurred while approving the certificate. Please try again.', 'error');
                    });
                }
            });
        });
    });
</script>
@endsection
