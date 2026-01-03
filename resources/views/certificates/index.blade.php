@extends('layouts.app')

@section('title', 'Certificates')

@section('extra-styles')
<style>
    .page-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 32px; }
    .page-title { font-size: 32px; font-weight: 700; color: #1f2937; margin: 0 0 8px 0; }
    .page-subtitle { color: #6b7280; margin: 0; }
    .search-card { background: white; padding: 24px; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 24px; }
    .table-card { background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); overflow: hidden; }
    .table { margin: 0; }
    .table thead th { background-color: #f3f4f6; font-weight: 600; font-size: 13px; text-transform: uppercase; letter-spacing: 0.3px; padding: 16px; border: none; color: #374151; }
    .table tbody td { padding: 14px 16px; border-bottom: 1px solid #e5e7eb; vertical-align: middle; }
    .table tbody tr:hover { background-color: #f9fafb; }
    .status-badge { font-size: 11px; font-weight: 600; padding: 4px 10px; border-radius: 4px; text-transform: uppercase; }
    .status-active { background-color: #d1fae5; color: #065f46; }
    .status-inactive { background-color: #e5e7eb; color: #374151; }
    .cert-id { background-color: #f3f4f6; padding: 4px 8px; border-radius: 4px; font-family: monospace; font-size: 12px; font-weight: 500; }
    .action-btn { padding: 6px 10px; font-size: 12px; border-radius: 6px; }
    .empty-state { padding: 60px 20px; text-align: center; }
    .empty-icon { font-size: 48px; margin-bottom: 16px; }
</style>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h4 fw-bold text-dark mb-1">Certificates</h1>
        <p class="text-muted mb-0">Manage all resident certificates</p>
    </div>
    <a href="{{ route('certificates.create') }}" class="btn btn-primary" style="background-color: #0038A8; border-color: #0038A8; padding: 0.5rem 1rem; font-size: 0.95rem;">
        <i class="bi bi-plus-circle me-2"></i> New Certificate
    </a>
</div>

    <!-- Search Filter -->
    <div class="search-card">
        <form method="GET" action="{{ route('certificates.index') }}" class="row g-3 align-items-end">
            <div class="col-md-6">
                <label class="form-label" style="font-weight: 500; font-size: 13px; color: #1f2937;">Search</label>
                <input type="text" name="search" class="form-control" placeholder="Search by resident name or certificate ID..." value="{{ request('search') }}" style="border-radius: 6px; border: 1px solid #e5e7eb;">
            </div>
            <div class="col-md-6">
                <button type="submit" class="btn btn-primary w-100" style="background-color: #0038A8; border: none; font-weight: 500;">
                    <i class="bi bi-search me-2"></i> Search
                </button>
            </div>
        </form>
    </div>

    <!-- Certificates Table -->
    @if($certificates->count() > 0)
        <div class="table-card">
            <div class="table-responsive" style="margin: 0;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Certificate ID</th>
                            <th>Resident</th>
                            <th>Type</th>
                            <th>Issued Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($certificates as $cert)
                        <tr>
                            <td><span class="cert-id">{{ $cert['id'] }}</span></td>
                            <td style="font-weight: 500; color: #1f2937;">{{ $cert['resident_name'] }}</td>
                            <td style="font-size: 14px;">{{ $cert['certificate_type'] }}</td>
                            <td style="font-size: 14px;">{{ \Carbon\Carbon::parse($cert['issued_date'])->format('M d, Y') }}</td>
                            <td>
                                <span class="status-badge status-{{ $cert['status'] === 'active' ? 'active' : 'inactive' }}">
                                    {{ ucfirst($cert['status']) }}
                                </span>
                            </td>
                            <td>
                                <div style="display: flex; gap: 8px;">
                                    <a href="{{ route('certificates.show', $cert['id']) }}" class="btn action-btn" style="background-color: #0038A8; color: white; border: none; text-decoration: none;">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                    <form action="{{ route('certificates.destroy', $cert['id']) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn action-btn" style="background-color: #ef4444; color: white; border: none;" onclick="return confirm('Are you sure?')">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4" style="display: flex; justify-content: center;">
            {{ $certificates->links() }}
        </div>
    @else
        <div class="table-card empty-state">
            <div class="empty-icon">📜</div>
            <h5 style="color: #1f2937; margin: 0;">No certificates found</h5>
            <p style="color: #6b7280; margin: 8px 0;">Create the first certificate for a resident</p>
            <a href="{{ route('certificates.create') }}" class="btn btn-primary" style="background-color: #0038A8; border: none; margin-top: 16px;">
                <i class="bi bi-plus-circle me-2"></i> Create Certificate
            </a>
        </div>
    @endif
    @else
        <div class="alert alert-info" role="alert">
            <i class="bi bi-info-circle me-2"></i> No certificates found. <a href="{{ route('certificates.create') }}">Issue one now</a>
        </div>
    @endif
</div>
@endsection
