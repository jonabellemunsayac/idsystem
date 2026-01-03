@extends('layouts.resident')

@section('title', 'Certificates - Resident Portal')

@section('extra-styles')
<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    .page-header h2 {
        font-size: 1.5rem;
        font-weight: bold;
        margin: 0;
    }
    .certificate-card {
        background: white;
        border-radius: 0.75rem;
        padding: 1rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin-bottom: 1rem;
        transition: all 0.2s;
    }
    .certificate-card:hover {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }
    .certificate-header {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 0.75rem;
    }
    .certificate-title {
        font-weight: 600;
        font-size: 1rem;
        margin-bottom: 0.25rem;
    }
    .certificate-ref {
        font-size: 0.875rem;
        color: #6b7280;
    }
    .certificate-details {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }
    .certificate-detail-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
    }
    .certificate-detail-item i {
        color: #6b7280;
    }
    .certificate-actions {
        display: flex;
        gap: 0.5rem;
    }
    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
    }
    .status-pending {
        background-color: #fef3c7;
        color: #92400e;
    }
    .status-approved {
        background-color: #d1fae5;
        color: #065f46;
    }
    .status-processing {
        background-color: #dbeafe;
        color: #1e40af;
    }
    .status-ready {
        background-color: #ddd6fe;
        color: #5b21b6;
    }
    .status-released {
        background-color: #e0e7ff;
        color: #3730a3;
    }
    .status-cancelled {
        background-color: #fee2e2;
        color: #991b1b;
    }
    .empty-state {
        background: white;
        border-radius: 0.75rem;
        padding: 3rem 1rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        text-align: center;
    }
    .empty-state i {
        font-size: 3rem;
        color: #6b7280;
        margin-bottom: 1rem;
    }
    .empty-state p {
        color: #6b7280;
        margin-bottom: 1rem;
    }
</style>
@endsection

@section('content')
<div class="page-header">
    <h2>Certificates</h2>
    <a href="{{ route('resident.request-certificate') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Request
    </a>
</div>

<!-- Error State -->
<div class="alert alert-danger" id="errorState" style="display:none;" role="alert">
    <i class="bi bi-exclamation-triangle me-2"></i>
    <span id="errorMessage"></span>
</div>

<!-- Loading State -->
<div class="empty-state" id="loadingState">
    <div class="spinner-border text-primary mb-2" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
    <p>Loading certificates...</p>
</div>

<!-- Certificates List -->
<div id="certificatesList"></div>
@endsection

@section('extra-scripts')
<script>
let certificates = [];

document.addEventListener('DOMContentLoaded', function() {
    fetchCertificates();
});

async function fetchCertificates() {
    try {
        const response = await fetch('/api/resident/certificates', {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            credentials: 'same-origin',
        });
        
        if (!response.ok) {
            throw new Error('Failed to load certificates');
        }
        
        certificates = await response.json();
        
        // Hide loading
        document.getElementById('loadingState').style.display = 'none';
        
        renderCertificates();
    } catch (err) {
        console.error('Error fetching certificates:', err);
        document.getElementById('loadingState').style.display = 'none';
        document.getElementById('errorState').style.display = 'block';
        document.getElementById('errorMessage').textContent = err.message;
    }
}

function renderCertificates() {
    const container = document.getElementById('certificatesList');
    
    if (certificates.length > 0) {
        container.innerHTML = certificates.map(cert => renderCertificateCard(cert)).join('');
    } else {
        container.innerHTML = `
            <div class="empty-state">
                <i class="bi bi-file-text"></i>
                <p>No certificates yet</p>
                <a href="{{ route('resident.request-certificate') }}" class="btn btn-outline-primary">Request a Certificate</a>
            </div>
        `;
    }
}

function renderCertificateCard(cert) {
    const certName = getCertificateName(cert.type);
    const date = new Date(cert.created_at);
    const dateStr = date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
    
    return `
        <div class="certificate-card">
            <div class="certificate-header">
                <div>
                    <div class="certificate-title">${certName}</div>
                    <div class="certificate-ref">${cert.reference_number}</div>
                </div>
                <span class="status-badge status-${cert.status}">${cert.status}</span>
            </div>
            
            <div class="certificate-details">
                <div class="certificate-detail-item">
                    <i class="bi bi-file-text"></i>
                    <span>Purpose: ${cert.purpose}</span>
                </div>
                <div class="certificate-detail-item">
                    <i class="bi bi-calendar"></i>
                    <span>Requested: ${dateStr}</span>
                </div>
                <div class="certificate-detail-item">
                    <i class="bi bi-truck"></i>
                    <span class="text-capitalize">Mode: ${cert.pickup_or_delivery}</span>
                </div>
            </div>
            
            <div class="certificate-actions">
                <button class="btn btn-outline-secondary btn-sm flex-fill">View Details</button>
                ${cert.status === 'pending' ? `<button class="btn btn-danger btn-sm flex-fill" onclick="handleCancel(${cert.id})">Cancel</button>` : ''}
            </div>
        </div>
    `;
}

function getCertificateName(type) {
    const names = {
        barangay_clearance: 'Barangay Clearance',
        certificate_of_indigency: 'Certificate of Indigency',
        certificate_of_residency: 'Certificate of Residency',
        business_permit: 'Business Permit',
        community_tax_certificate: 'Community Tax Certificate',
        other: 'Other Certificate'
    };
    return names[type] || type;
}

async function handleCancel(id) {
    if (!confirm('Are you sure you want to cancel this certificate request?')) {
        return;
    }
    
    try {
        const response = await fetch(`/api/resident/certificates/${id}/cancel`, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest',
            },
            credentials: 'same-origin',
        });
        
        if (!response.ok) {
            throw new Error('Failed to cancel certificate');
        }
        
        // Refresh the list
        fetchCertificates();
    } catch (err) {
        alert('Failed to cancel certificate: ' + err.message);
        console.error(err);
    }
}
</script>
@endsection
