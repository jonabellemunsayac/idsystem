@extends('layouts.app')

@section('title', 'Certificates')

@section('extra-styles')
<style>
    .certificates-header { margin-bottom: 40px; }
    .cert-template-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px; margin-bottom: 40px; }
    
    .cert-template-card {
        display: flex;
        flex-direction: column;
        background: linear-gradient(135deg, #0038A8 0%, #003A9E 100%);
        border-radius: 12px;
        padding: 32px 24px;
        min-height: 380px;
        color: white;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(0, 56, 168, 0.15);
        border: 2px solid transparent;
        position: relative;
        overflow: hidden;
    }
    
    .cert-template-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 24px rgba(0, 56, 168, 0.25);
        border-color: rgba(255, 255, 255, 0.3);
    }
    
    .cert-template-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="1" fill="white" opacity="0.1"/><circle cx="80" cy="80" r="1" fill="white" opacity="0.1"/></svg>');
        pointer-events: none;
    }
    
    .cert-template-content {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%;
        position: relative;
        z-index: 1;
    }
    
    .cert-icon {
        font-size: 48px;
        margin-bottom: 16px;
        display: block;
    }
    
    .cert-template-name {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 8px;
        line-height: 1.3;
    }
    
    .cert-template-desc {
        font-size: 13px;
        opacity: 0.9;
        margin-bottom: 24px;
        line-height: 1.5;
    }
    
    .cert-template-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: auto;
        padding-top: 16px;
        border-top: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .cert-count {
        font-size: 12px;
        opacity: 0.8;
    }
    
    .cert-btn {
        background: rgba(255, 255, 255, 0.25);
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }
    
    .cert-btn:hover {
        background: rgba(255, 255, 255, 0.35);
        color: white;
    }
    
    .search-card { background: white; padding: 24px; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 32px; }
    .search-card h5 { font-weight: 600; margin-bottom: 16px; color: #1f2937; font-size: 14px; }
    
    .recent-certs { margin-top: 40px; }
    .recent-certs h5 { font-weight: 600; margin-bottom: 20px; color: #1f2937; }
    
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
    .empty-recent { padding: 40px 20px; text-align: center; color: #6b7280; }
    .download-template-btn { 
        background: rgba(255, 255, 255, 0.2); 
        color: white; 
        border: 1px solid rgba(255, 255, 255, 0.4); 
        padding: 6px 12px; 
        border-radius: 6px; 
        font-size: 11px; 
        font-weight: 600; 
        cursor: pointer; 
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }
    .download-template-btn:hover {
        background: rgba(255, 255, 255, 0.35);
        color: white;
        transform: scale(1.05);
    }
    .download-template-btn i {
        margin-right: 4px;
    }
    .modal-overlay { position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); display: none; align-items: center; justify-content: center; z-index: 9999; }
    .modal-overlay.active { display: flex; }
    .modal-content { background: white; border-radius: 12px; padding: 32px; max-width: 500px; width: 90%; max-height: 80vh; overflow-y: auto; }
    .modal-header { margin-bottom: 24px; }
    .modal-title { font-size: 20px; font-weight: 700; color: #1f2937; margin: 0 0 8px 0; }
    .modal-subtitle { color: #6b7280; font-size: 14px; margin: 0; }
    .modal-body { margin-bottom: 24px; }
    .modal-footer { display: flex; gap: 12px; justify-content: flex-end; }
    .btn-modal { padding: 10px 20px; border-radius: 6px; font-weight: 600; cursor: pointer; border: none; transition: all 0.3s ease; }
    .btn-modal-primary { background-color: #0038A8; color: white; }
    .btn-modal-primary:hover { background-color: #002B88; }
    .btn-modal-secondary { background-color: #e5e7eb; color: #374151; }
    .btn-modal-secondary:hover { background-color: #d1d5db; }

    /* ===== Mobile Responsive ===== */
    @media (max-width: 768px) {
        .certificates-header { margin-bottom: 24px; }
        .certificates-header .h4 { font-size: 18px; }
        .cert-template-grid { grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 14px; margin-bottom: 24px; }
        .cert-template-card { padding: 20px 16px; min-height: 280px; }
        .cert-icon { font-size: 32px; }
        .cert-template-name { font-size: 16px; }
        .cert-template-desc { font-size: 12px; margin-bottom: 16px; }
        .cert-btn { padding: 8px 14px; font-size: 12px; }
        .download-template-btn { padding: 6px 10px; font-size: 10px; }
        .recent-certs { margin-top: 24px; }
        .recent-certs h5 { font-size: 15px; margin-bottom: 12px; }
        .table thead th { padding: 10px 8px; font-size: 11px; }
        .table tbody td { padding: 10px 8px; font-size: 13px; }
        .cert-id { font-size: 10px; padding: 3px 6px; }
        .action-btn { padding: 5px 8px; font-size: 11px; }
        .modal-content { padding: 20px; width: 95%; }
        .modal-title { font-size: 18px; }
        .modal-footer { flex-direction: column; }
        .modal-footer .btn-modal { width: 100%; text-align: center; }
        .search-card { padding: 16px; }
    }

    @media (max-width: 480px) {
        .cert-template-grid { grid-template-columns: 1fr; gap: 12px; }
        .cert-template-card { min-height: auto; padding: 16px; }
        .cert-template-card:hover { transform: none; }
        .table-responsive { margin: 0 -8px; }
    }
</style>
@endsection

@section('content')
<div class="certificates-header">
    <h1 class="h4 fw-bold text-dark mb-1">Certificates</h1>
    <p class="text-muted mb-0">Issue and manage resident certificates</p>
</div>

<!-- Certificate Templates -->
<div class="cert-template-grid">
    <!-- Certificate of Indigency -->
    <div class="cert-template-card" style="cursor: default;">
        <div class="cert-template-content">
            <div>
                <span class="cert-icon">📄</span>
                <div class="cert-template-name">Certificate of<br>Indigency</div>
                <div class="cert-template-desc">For individuals with low income status</div>
            </div>
            <div class="cert-template-footer" style="flex-direction: column; gap: 8px; align-items: stretch;">
                <span class="cert-count">Issued: {{ $certificateCounts['indigency'] ?? 0 }}</span>
                <a href="{{ route('certificates.editor') }}?type=indigency" class="cert-btn" style="text-align: center; border: none; text-decoration: none; display: block;">
                    <i class="bi bi-pencil-square me-1"></i> Edit & Print
                </a>
                <a href="{{ route('certificates.template.download', 'indigency') }}" class="download-template-btn" style="text-align: center;">
                    <i class="bi bi-download"></i> Download Template
                </a>
            </div>
        </div>
    </div>
    
    <!-- Certificate of Residency -->
    <div class="cert-template-card" style="cursor: default;">
        <div class="cert-template-content">
            <div>
                <span class="cert-icon">🏠</span>
                <div class="cert-template-name">Certificate of<br>Residency</div>
                <div class="cert-template-desc">Proof of residential address</div>
            </div>
            <div class="cert-template-footer" style="flex-direction: column; gap: 8px; align-items: stretch;">
                <span class="cert-count">Issued: {{ $certificateCounts['residency'] ?? 0 }}</span>
                <a href="{{ route('certificates.editor') }}?type=residency" class="cert-btn" style="text-align: center; border: none; text-decoration: none; display: block;">
                    <i class="bi bi-pencil-square me-1"></i> Edit & Print
                </a>
                <a href="{{ route('certificates.template.download', 'residency') }}" class="download-template-btn" style="text-align: center;">
                    <i class="bi bi-download"></i> Download Template
                </a>
            </div>
        </div>
    </div>
    
    <!-- Certificate of Clearance -->
    <div class="cert-template-card" style="cursor: default;">
        <div class="cert-template-content">
            <div>
                <span class="cert-icon">✅</span>
                <div class="cert-template-name">Certificate of<br>Clearance</div>
                <div class="cert-template-desc">Barangay clearance certificate</div>
            </div>
            <div class="cert-template-footer" style="flex-direction: column; gap: 8px; align-items: stretch;">
                <span class="cert-count">Issued: {{ $certificateCounts['clearance'] ?? 0 }}</span>
                <a href="{{ route('certificates.editor') }}?type=clearance" class="cert-btn" style="text-align: center; border: none; text-decoration: none; display: block;">
                    <i class="bi bi-pencil-square me-1"></i> Edit & Print
                </a>
                <a href="{{ route('certificates.template.download', 'clearance') }}" class="download-template-btn" style="text-align: center;">
                    <i class="bi bi-download"></i> Download Template
                </a>
            </div>
        </div>
    </div>
    
    <!-- Certificate of Low Income -->
    <div class="cert-template-card" style="cursor: default;">
        <div class="cert-template-content">
            <div>
                <span class="cert-icon">💰</span>
                <div class="cert-template-name">Certificate of<br>Low Income</div>
                <div class="cert-template-desc">Income assistance and benefits</div>
            </div>
            <div class="cert-template-footer" style="flex-direction: column; gap: 8px; align-items: stretch;">
                <span class="cert-count">Issued: {{ $certificateCounts['low_income'] ?? 0 }}</span>
                <a href="{{ route('certificates.editor') }}?type=low_income" class="cert-btn" style="text-align: center; border: none; text-decoration: none; display: block;">
                    <i class="bi bi-pencil-square me-1"></i> Edit & Print
                </a>
                <a href="{{ route('certificates.template.download', 'low_income') }}" class="download-template-btn" style="text-align: center;">
                    <i class="bi bi-download"></i> Download Template
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Search Filter -->
<div class="search-card" style="display: none;" id="searchSection">
    <h5>Search Recent Certificates</h5>
    <form method="GET" action="{{ route('certificates.index') }}" class="row g-3 align-items-end">
        <div class="col-md-6">
            <label class="form-label" style="font-weight: 500; font-size: 13px; color: #1f2937;">Search</label>
            <input type="text" name="search" class="form-control" placeholder="Search by resident name or certificate type..." value="{{ request('search') }}" style="border-radius: 6px; border: 1px solid #e5e7eb;">
        </div>
        <div class="col-md-6">
            <button type="submit" class="btn btn-primary w-100" style="background-color: #0038A8; border: none; font-weight: 500;">
                <i class="bi bi-search me-2"></i> Search
            </button>
        </div>
    </form>
</div>

<!-- Recently Issued Certificates -->
@if($certificates->count() > 0)
    <div class="recent-certs">
        <h5><i class="bi bi-clock-history me-2"></i>Recently Issued Certificates</h5>
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
                            <td style="font-size: 14px;">{{ ucfirst(str_replace('_', ' ', $cert['type'])) }}</td>
                            <td style="font-size: 14px;">{{ $cert['approved_date'] ? \Carbon\Carbon::parse($cert['approved_date'])->format('M d, Y') : 'N/A' }}</td>
                            <td>
                                <span class="status-badge status-{{ $cert['status'] === 'approved' || $cert['status'] === 'released' || $cert['status'] === 'ready' ? 'active' : 'inactive' }}">
                                    {{ ucfirst(str_replace('_', ' ', $cert['status'])) }}
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
    </div>
@else
    <div class="recent-certs empty-recent">
        <p><i class="bi bi-inbox" style="font-size: 24px; display: block; margin-bottom: 8px;"></i></p>
        <p>No certificates issued yet. Create one by selecting a certificate type above.</p>
    </div>
@endif



@endsection
