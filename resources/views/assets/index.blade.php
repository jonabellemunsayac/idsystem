@extends('layouts.app')

@section('title', 'Assets Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h4 fw-bold text-dark mb-1">Assets Management</h1>
        <p class="text-muted mb-0">Track and manage barangay assets</p>
    </div>
    <button class="btn btn-primary" style="background-color: #0038A8; border-color: #0038A8; padding: 0.5rem 1rem; font-size: 0.95rem;">
        <i class="bi bi-plus-lg"></i> Add
    </button>
</div>

<!-- Metrics Grid -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted small mb-1">Total Assets</p>
                        <h2 class="fw-bold mb-0 text-dark">142</h2>
                    </div>
                    <div class="text-primary">
                        <i class="bi bi-box-seam fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted small mb-1">Working</p>
                        <h2 class="fw-bold mb-0 text-dark">128</h2>
                    </div>
                    <div class="text-success">
                        <i class="bi bi-check-circle fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted small mb-1">Under Maintenance</p>
                        <h2 class="fw-bold mb-0 text-dark">10</h2>
                    </div>
                    <div class="text-warning">
                        <i class="bi bi-tools fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted small mb-1">For Disposal</p>
                        <h2 class="fw-bold mb-0 text-dark">4</h2>
                    </div>
                    <div class="text-danger">
                        <i class="bi bi-trash fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Asset Inventory Table -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0 py-2 px-3">
        <h5 class="fw-bold mb-0 text-dark">Asset Inventory</h5>
    </div>
    <div class="card-body px-0 pb-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="px-3 py-2 text-muted small fw-bold text-uppercase">Asset ID</th>
                        <th class="px-3 py-2 text-muted small fw-bold text-uppercase">Name</th>
                        <th class="px-3 py-2 text-muted small fw-bold text-uppercase">Category</th>
                        <th class="px-3 py-2 text-muted small fw-bold text-uppercase">Quantity</th>
                        <th class="px-3 py-2 text-muted small fw-bold text-uppercase">Last Maintenance</th>
                        <th class="px-3 py-2 text-muted small fw-bold text-uppercase">Status</th>
                        <th class="px-3 py-2 text-muted small fw-bold text-uppercase text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="px-3 py-2 fw-bold text-dark">AST-001</td>
                        <td class="px-3 py-2">Community Hall Chairs</td>
                        <td class="px-3 py-2">Furniture</td>
                        <td class="px-3 py-2">50</td>
                        <td class="px-3 py-2">2024-01-10</td>
                        <td class="px-3 py-2"><span class="badge bg-success rounded-pill px-3">working</span></td>
                        <td class="px-3 py-2 text-end">
                            <button class="btn btn-outline-secondary btn-sm">View Details</button>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-3 py-2 fw-bold text-dark">AST-002</td>
                        <td class="px-3 py-2">Sound System</td>
                        <td class="px-3 py-2">Equipment</td>
                        <td class="px-3 py-2">1</td>
                        <td class="px-3 py-2">2024-01-05</td>
                        <td class="px-3 py-2"><span class="badge bg-success rounded-pill px-3">working</span></td>
                        <td class="px-3 py-2 text-end">
                            <button class="btn btn-outline-secondary btn-sm">View Details</button>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-3 py-2 fw-bold text-dark">AST-003</td>
                        <td class="px-3 py-2">Basketball Equipment</td>
                        <td class="px-3 py-2">Sports</td>
                        <td class="px-3 py-2">10</td>
                        <td class="px-3 py-2">2024-01-15</td>
                        <td class="px-3 py-2"><span class="badge bg-warning text-dark rounded-pill px-3">maintenance</span></td>
                        <td class="px-3 py-2 text-end">
                            <button class="btn btn-outline-secondary btn-sm">View Details</button>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-3 py-2 fw-bold text-dark">AST-004</td>
                        <td class="px-3 py-2">Office Computers</td>
                        <td class="px-3 py-2">Electronics</td>
                        <td class="px-3 py-2">5</td>
                        <td class="px-3 py-2">2023-12-20</td>
                        <td class="px-3 py-2"><span class="badge bg-success rounded-pill px-3">working</span></td>
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