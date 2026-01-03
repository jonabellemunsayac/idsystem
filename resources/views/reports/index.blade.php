@extends('layouts.app')

@section('title', 'Reports & Analytics')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h4 fw-bold text-dark mb-1">Reports & Analytics</h1>
        <p class="text-muted mb-0">View statistics and generate reports</p>
    </div>
    <button class="btn btn-primary" style="background-color: #0038A8; border-color: #0038A8; padding: 0.5rem 1rem; font-size: 0.95rem;">
        <i class="bi bi-download me-2"></i> Export Report
    </button>
</div>

<div class="row g-4">
    <!-- Resident Demographics -->
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-2 mb-4">
                    <i class="bi bi-bar-chart text-primary"></i>
                    <h5 class="fw-bold mb-0 text-dark">Resident Demographics</h5>
                </div>
                <div class="d-flex align-items-center justify-content-center" style="height: 300px; background-color: #f8f9fa; border-radius: 8px;">
                    <p class="text-muted">Demographics chart placeholder</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Appointments -->
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-2 mb-4">
                    <i class="bi bi-graph-up text-primary"></i>
                    <h5 class="fw-bold mb-0 text-dark">Monthly Appointments</h5>
                </div>
                <div class="d-flex align-items-center justify-content-center" style="height: 300px; background-color: #f8f9fa; border-radius: 8px;">
                    <p class="text-muted">Appointments trend placeholder</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Blotter Case Statistics -->
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-2 mb-4">
                    <i class="bi bi-bar-chart text-primary"></i>
                    <h5 class="fw-bold mb-0 text-dark">Blotter Case Statistics</h5>
                </div>
                <div class="d-flex align-items-center justify-content-center" style="height: 300px; background-color: #f8f9fa; border-radius: 8px;">
                    <p class="text-muted">Case statistics chart placeholder</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Asset Utilization -->
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-2 mb-4">
                    <i class="bi bi-graph-up text-primary"></i>
                    <h5 class="fw-bold mb-0 text-dark">Asset Utilization</h5>
                </div>
                <div class="d-flex align-items-center justify-content-center" style="height: 300px; background-color: #f8f9fa; border-radius: 8px;">
                    <p class="text-muted">Asset utilization chart placeholder</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection