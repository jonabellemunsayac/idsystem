@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="mb-4">
    <h1 class="fs-3 fw-bold text-dark mb-1">Dashboard</h1>
    <p class="text-muted mb-0">Welcome back! Here's what's happening today.</p>
</div>

<!-- Metrics Grid -->
<div class="row g-4 mb-4">
    <!-- Total Residents -->
    <div class="col-12 col-md-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100 hover-shadow">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="flex-grow-1">
                        <p class="text-muted mb-2 fw-medium" style="font-size: 0.875rem;">Total Residents</p>
                        <h3 class="fs-2 fw-bold mb-2">{{ number_format($stats['residents_count'] ?? 2847) }}</h3>
                        <p class="text-success mb-0" style="font-size: 0.875rem;">
                            <i class="bi bi-arrow-up"></i> +12% from last month
                        </p>
                    </div>
                    <div class="rounded-3 bg-primary bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; flex-shrink: 0;">
                        <i class="bi bi-people text-primary" style="font-size: 1.5rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Requests -->
    <div class="col-12 col-md-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100 hover-shadow">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="flex-grow-1">
                        <p class="text-muted mb-2 fw-medium" style="font-size: 0.875rem;">Pending Requests</p>
                        <h3 class="fs-2 fw-bold mb-2">{{ number_format($stats['appointments_count'] ?? 24) }}</h3>
                        <p class="text-success mb-0" style="font-size: 0.875rem;">
                            <i class="bi bi-arrow-down"></i> -5% from last week
                        </p>
                    </div>
                    <div class="rounded-3 bg-warning bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; flex-shrink: 0;">
                        <i class="bi bi-person-check text-warning" style="font-size: 1.5rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Blotter Cases -->
    <div class="col-12 col-md-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100 hover-shadow">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="flex-grow-1">
                        <p class="text-muted mb-2 fw-medium" style="font-size: 0.875rem;">Blotter Cases</p>
                        <h3 class="fs-2 fw-bold mb-2">{{ number_format($stats['blotter_count'] ?? 15) }}</h3>
                        <p class="text-success mb-0" style="font-size: 0.875rem;">
                            <i class="bi bi-arrow-up"></i> 3 resolved today
                        </p>
                    </div>
                    <div class="rounded-3 bg-danger bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; flex-shrink: 0;">
                        <i class="bi bi-file-earmark-text text-danger" style="font-size: 1.5rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Barangay Assets -->
    <div class="col-12 col-md-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100 hover-shadow">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="flex-grow-1">
                        <p class="text-muted mb-2 fw-medium" style="font-size: 0.875rem;">Barangay Assets</p>
                        <h3 class="fs-2 fw-bold mb-2">{{ number_format($stats['assets_count'] ?? 142) }}</h3>
                        <p class="text-muted mb-0" style="font-size: 0.875rem; visibility: hidden;">Placeholder</p>
                    </div>
                    <div class="rounded-3 bg-success bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; flex-shrink: 0;">
                        <i class="bi bi-box-seam text-success" style="font-size: 1.5rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activities -->
<div class="row g-4 mb-4">
    <!-- Recent Appointments -->
    <div class="col-12 col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0 py-3 px-4">
                <h5 class="mb-0 fw-bold d-flex align-items-center gap-2" style="font-size: 1.125rem;">
                    <i class="bi bi-calendar-event text-primary" style="font-size: 1.25rem;"></i>
                    Recent Appointments
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="d-flex flex-column gap-3">
                    <!-- Item 1 -->
                    <div class="p-3 rounded-3 border hover-bg-light">
                        <div class="d-flex justify-content-between align-items-center gap-3">
                            <div class="flex-grow-1">
                                <p class="mb-1 fw-medium" style="font-size: 1rem;">Juan Dela Cruz</p>
                                <p class="text-muted mb-0" style="font-size: 0.875rem;">Barangay Clearance</p>
                            </div>
                            <div class="d-flex align-items-center gap-2 flex-shrink-0">
                                <span class="text-muted" style="font-size: 0.875rem;">10:00 AM</span>
                                <span class="badge rounded-pill px-3 py-2" style="background-color: #ffc107; color: #000; font-size: 0.75rem;">pending</span>
                            </div>
                        </div>
                    </div>
                    <!-- Item 2 -->
                    <div class="p-3 rounded-3 border hover-bg-light">
                        <div class="d-flex justify-content-between align-items-center gap-3">
                            <div class="flex-grow-1">
                                <p class="mb-1 fw-medium" style="font-size: 1rem;">Maria Santos</p>
                                <p class="text-muted mb-0" style="font-size: 0.875rem;">Business Permit</p>
                            </div>
                            <div class="d-flex align-items-center gap-2 flex-shrink-0">
                                <span class="text-muted" style="font-size: 0.875rem;">11:30 AM</span>
                                <span class="badge rounded-pill px-3 py-2 bg-success" style="font-size: 0.75rem;">approved</span>
                            </div>
                        </div>
                    </div>
                    <!-- Item 3 -->
                    <div class="p-3 rounded-3 border hover-bg-light">
                        <div class="d-flex justify-content-between align-items-center gap-3">
                            <div class="flex-grow-1">
                                <p class="mb-1 fw-medium" style="font-size: 1rem;">Pedro Reyes</p>
                                <p class="text-muted mb-0" style="font-size: 0.875rem;">Residency Certificate</p>
                            </div>
                            <div class="d-flex align-items-center gap-2 flex-shrink-0">
                                <span class="text-muted" style="font-size: 0.875rem;">2:00 PM</span>
                                <span class="badge rounded-pill px-3 py-2 bg-primary" style="font-size: 0.75rem;">completed</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Blotter Cases -->
    <div class="col-12 col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0 py-3 px-4">
                <h5 class="mb-0 fw-bold d-flex align-items-center gap-2" style="font-size: 1.125rem;">
                    <i class="bi bi-file-text text-primary" style="font-size: 1.25rem;"></i>
                    Recent Blotter Cases
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="d-flex flex-column gap-3">
                    <!-- Item 1 -->
                    <div class="p-3 rounded-3 border hover-bg-light">
                        <div class="d-flex justify-content-between align-items-center gap-3">
                            <div class="flex-grow-1">
                                <p class="mb-1 fw-medium" style="font-size: 1rem;">Noise Complaint</p>
                                <p class="text-muted mb-0" style="font-size: 0.875rem;">2024-01-15</p>
                            </div>
                            <span class="badge rounded-pill px-3 py-2 flex-shrink-0" style="background-color: #ffc107; color: #000; font-size: 0.75rem;">pending</span>
                        </div>
                    </div>
                    <!-- Item 2 -->
                    <div class="p-3 rounded-3 border hover-bg-light">
                        <div class="d-flex justify-content-between align-items-center gap-3">
                            <div class="flex-grow-1">
                                <p class="mb-1 fw-medium" style="font-size: 1rem;">Property Dispute</p>
                                <p class="text-muted mb-0" style="font-size: 0.875rem;">2024-01-14</p>
                            </div>
                            <span class="badge rounded-pill px-3 py-2 bg-success flex-shrink-0" style="font-size: 0.75rem;">resolved</span>
                        </div>
                    </div>
                    <!-- Item 3 -->
                    <div class="p-3 rounded-3 border hover-bg-light">
                        <div class="d-flex justify-content-between align-items-center gap-3">
                            <div class="flex-grow-1">
                                <p class="mb-1 fw-medium" style="font-size: 1rem;">Lost ID</p>
                                <p class="text-muted mb-0" style="font-size: 0.875rem;">2024-01-13</p>
                            </div>
                            <span class="badge rounded-pill px-3 py-2 flex-shrink-0" style="background-color: #ffc107; color: #000; font-size: 0.75rem;">pending</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Weekly Statistics -->
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3 px-4">
                <h5 class="mb-0 fw-bold d-flex align-items-center gap-2" style="font-size: 1.125rem;">
                    <i class="bi bi-graph-up text-primary" style="font-size: 1.25rem;"></i>
                    Weekly Statistics
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-center rounded-3 bg-light" style="height: 256px;">
                    <p class="text-muted mb-0" style="font-size: 0.875rem;">Chart placeholder - Integration ready</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-shadow {
        transition: box-shadow 0.2s ease-in-out;
    }
    
    .hover-shadow:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }
    
    .hover-bg-light {
        transition: background-color 0.2s ease-in-out;
    }
    
    .hover-bg-light:hover {
        background-color: rgba(0, 0, 0, 0.02);
    }
</style>
@endsection
