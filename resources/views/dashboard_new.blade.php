@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="mb-4">
    <h1 class="h3 fw-bold text-dark mb-1">Dashboard</h1>
    <p class="text-muted mb-0">Welcome back! Here's what's happening today.</p>
</div>

<div class="row g-4 mb-4">
    <!-- Total Residents -->
    <div class="col-md-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted fw-medium mb-1 small text-uppercase">Total Residents</p>
                        <h3 class="fw-bold mb-2">{{ $stats['residents_count'] ?? 0 }}</h3>
                        <p class="text-success small mb-0">
                            <i class="bi bi-arrow-up"></i> +12% from last month
                        </p>
                    </div>
                    <div class="rounded-3 bg-primary bg-opacity-10 p-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="bi bi-people text-primary fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Requests -->
    <div class="col-md-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted fw-medium mb-1 small text-uppercase">Pending Requests</p>
                        <h3 class="fw-bold mb-2">{{ $stats['appointments_count'] ?? 0 }}</h3>
                        <p class="text-success small mb-0">
                            <i class="bi bi-arrow-up"></i> -5% from last week
                        </p>
                    </div>
                    <div class="rounded-3 bg-warning bg-opacity-10 p-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="bi bi-person-check text-warning fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Blotter Cases -->
    <div class="col-md-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted fw-medium mb-1 small text-uppercase">Blotter Cases</p>
                        <h3 class="fw-bold mb-2">{{ $stats['certificates_count'] ?? 0 }}</h3>
                        <p class="text-success small mb-0">
                            3 resolved today
                        </p>
                    </div>
                    <div class="rounded-3 bg-danger bg-opacity-10 p-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="bi bi-file-text text-danger fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Barangay Assets -->
    <div class="col-md-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted fw-medium mb-1 small text-uppercase">Barangay Assets</p>
                        <h3 class="fw-bold mb-2">{{ $stats['ids_count'] ?? 0 }}</h3>
                        <p class="text-muted small mb-0">
                            &nbsp;
                        </p>
                    </div>
                    <div class="rounded-3 bg-success bg-opacity-10 p-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="bi bi-box-seam text-success fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Recent Appointments -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3">
                <h5 class="card-title mb-0 fw-bold">Recent Appointments</h5>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @forelse($recent_appointments as $apt)
                    <div class="list-group-item p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1 fw-bold">{{ $apt['resident_name'] }}</h6>
                                <p class="mb-0 text-muted small">Appointment</p>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-warning text-dark mb-1">Pending</span>
                                <p class="mb-0 text-muted small">{{ \Carbon\Carbon::parse($apt['appointment_date'])->format('h:i A') }}</p>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="p-4 text-center text-muted">
                        <i class="bi bi-calendar-x fs-4 d-block mb-2"></i>
                        No recent appointments
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Blotters -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3">
                <h5 class="card-title mb-0 fw-bold">Recent Blotter Cases</h5>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    <!-- Placeholder for blotter cases since I don't have the variable yet -->
                    <div class="p-4 text-center text-muted">
                        <i class="bi bi-clipboard-x fs-4 d-block mb-2"></i>
                        No recent cases
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection