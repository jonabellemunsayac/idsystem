@extends('layouts.app')

@section('title', 'Blotter Records')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h4 fw-bold text-dark mb-1">Blotter Records</h1>
        <p class="text-muted mb-0">Track and manage incident reports</p>
    </div>
    <button class="btn btn-primary" style="background-color: #0038A8; border-color: #0038A8; padding: 0.5rem 1rem; font-size: 0.95rem;">
        <i class="bi bi-plus-lg"></i> Case
    </button>
</div>

<!-- Metrics Grid -->
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted small mb-1">Total Cases</p>
                        <h2 class="fw-bold mb-0 text-dark">127</h2>
                    </div>
                    <div class="text-primary">
                        <i class="bi bi-exclamation-circle fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted small mb-1">Pending</p>
                        <h2 class="fw-bold mb-0 text-dark">24</h2>
                    </div>
                    <div class="text-warning">
                        <i class="bi bi-exclamation-circle fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted small mb-1">Resolved</p>
                        <h2 class="fw-bold mb-0 text-dark">89</h2>
                    </div>
                    <div class="text-success">
                        <i class="bi bi-exclamation-circle fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Cases Table -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0 py-2 px-3 d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0 text-dark">Recent Cases</h5>
        <button class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-funnel me-2"></i> Filter
        </button>
    </div>
    <div class="card-body px-0 pb-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="px-3 py-2 text-muted small fw-bold text-uppercase">Case ID</th>
                        <th class="px-3 py-2 text-muted small fw-bold text-uppercase">Type</th>
                        <th class="px-3 py-2 text-muted small fw-bold text-uppercase">Complainant</th>
                        <th class="px-3 py-2 text-muted small fw-bold text-uppercase">Date</th>
                        <th class="px-3 py-2 text-muted small fw-bold text-uppercase">Severity</th>
                        <th class="px-3 py-2 text-muted small fw-bold text-uppercase">Status</th>
                        <th class="px-3 py-2 text-muted small fw-bold text-uppercase text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="px-3 py-2 fw-bold text-dark">BLT-001</td>
                        <td class="px-3 py-2">Noise Complaint</td>
                        <td class="px-3 py-2">Juan Dela Cruz</td>
                        <td class="px-3 py-2">2024-01-15</td>
                        <td class="px-3 py-2"><span class="badge bg-light text-dark border rounded-pill px-3">low</span></td>
                        <td class="px-3 py-2"><span class="badge bg-warning text-dark rounded-pill px-3">pending</span></td>
                        <td class="px-3 py-2 text-end">
                            <button class="btn btn-outline-secondary btn-sm">View Details</button>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-3 py-2 fw-bold text-dark">BLT-002</td>
                        <td class="px-3 py-2">Property Dispute</td>
                        <td class="px-3 py-2">Maria Santos</td>
                        <td class="px-3 py-2">2024-01-14</td>
                        <td class="px-3 py-2"><span class="badge bg-warning text-dark rounded-pill px-3">medium</span></td>
                        <td class="px-3 py-2"><span class="badge bg-success rounded-pill px-3">resolved</span></td>
                        <td class="px-3 py-2 text-end">
                            <button class="btn btn-outline-secondary btn-sm">View Details</button>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-3 py-2 fw-bold text-dark">BLT-003</td>
                        <td class="px-3 py-2">Theft</td>
                        <td class="px-3 py-2">Pedro Reyes</td>
                        <td class="px-3 py-2">2024-01-13</td>
                        <td class="px-3 py-2"><span class="badge bg-danger rounded-pill px-3">high</span></td>
                        <td class="px-3 py-2"><span class="badge bg-primary rounded-pill px-3">investigating</span></td>
                        <td class="px-3 py-2 text-end">
                            <button class="btn btn-outline-secondary btn-sm">View Details</button>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-3 py-2 fw-bold text-dark">BLT-004</td>
                        <td class="px-3 py-2">Vandalism</td>
                        <td class="px-3 py-2">Ana Garcia</td>
                        <td class="px-3 py-2">2024-01-12</td>
                        <td class="px-3 py-2"><span class="badge bg-warning text-dark rounded-pill px-3">medium</span></td>
                        <td class="px-3 py-2"><span class="badge bg-warning text-dark rounded-pill px-3">pending</span></td>
                        <td class="px-3 py-2 text-end">
                            <button class="btn btn-outline-secondary btn-sm">View Details</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection