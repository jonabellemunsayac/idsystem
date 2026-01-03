@extends('layouts.resident')

@section('title', 'Dashboard - Resident Portal')

@section('extra-styles')
<style>
    .welcome-card {
        background: linear-gradient(135deg, var(--pasig-blue) 0%, #002980 100%);
        color: white;
        border-radius: 1rem;
        padding: 1.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin-bottom: 1.5rem;
    }
    .welcome-card h2 {
        font-size: 1.5rem;
        font-weight: bold;
        margin-bottom: 0.25rem;
    }
    .welcome-card p {
        opacity: 0.9;
        margin-bottom: 0.25rem;
    }
    .quick-actions-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0.75rem;
        margin-bottom: 1.5rem;
    }
    .quick-action-card {
        background: white;
        border-radius: 0.75rem;
        padding: 1.25rem;
        text-align: center;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        color: inherit;
        display: block;
    }
    .quick-action-card:hover {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        transform: translateY(-2px);
    }
    .quick-action-card i {
        font-size: 2rem;
        color: var(--pasig-blue);
        margin-bottom: 0.5rem;
        display: block;
    }
    .quick-action-card span {
        font-weight: 500;
        font-size: 0.875rem;
    }
    .info-card {
        background: white;
        border-radius: 0.75rem;
        padding: 1rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin-bottom: 1.5rem;
    }
    .info-card-header {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #e5e7eb;
    }
    .info-card-header i {
        color: var(--pasig-blue);
    }
    .info-card-header h6 {
        font-size: 1rem;
        font-weight: 600;
        margin: 0;
    }
    .appointment-item {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 1rem;
    }
    .appointment-item:last-child {
        margin-bottom: 0;
    }
    .cert-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 0.75rem;
        margin-bottom: 0.75rem;
        border-bottom: 1px solid #e5e7eb;
    }
    .cert-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
        margin-bottom: 0;
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
    .view-all-link {
        color: var(--pasig-blue);
        font-size: 0.875rem;
        font-weight: 500;
        text-decoration: none;
        padding-top: 0.5rem;
        display: inline-block;
    }
    .view-all-link:hover {
        text-decoration: underline;
    }
    @media (min-width: 768px) {
        .quick-actions-grid {
            grid-template-columns: repeat(4, 1fr);
        }
    }
</style>
@endsection

@section('content')
<!-- Welcome Section -->
<div class="welcome-card">
    <h2>Welcome back!</h2>
    <p>{{ $resident['first_name'] }} {{ $resident['last_name'] }}</p>
    <p class="small">ID: BRG-2024-001</p>
</div>

<!-- Quick Actions -->
<section>
    <h3 class="h5 fw-semibold mb-3">Quick Actions</h3>
    <div class="quick-actions-grid">
        <a href="{{ route('resident.book-appointment') }}" class="quick-action-card">
            <i class="bi bi-calendar-check"></i>
            <span>Book Appointment</span>
        </a>
        <a href="{{ route('resident.request-certificate') }}" class="quick-action-card">
            <i class="bi bi-file-text"></i>
            <span>Request Certificate</span>
        </a>
        <a href="{{ route('resident.profile') }}" class="quick-action-card">
            <i class="bi bi-person"></i>
            <span>My Profile</span>
        </a>
        <a href="{{ route('resident.family') }}" class="quick-action-card">
            <i class="bi bi-people"></i>
            <span>Family Info</span>
        </a>
    </div>
</section>

<!-- Next Appointment Card -->
<div class="info-card" id="nextAppointmentCard" style="display:none;">
    <div class="info-card-header">
        <i class="bi bi-clock fs-5"></i>
        <h6>Next Appointment</h6>
    </div>
    <div class="appointment-item">
        <div>
            <p class="fw-semibold mb-1" id="nextAppointmentService"></p>
            <p class="text-muted small mb-1" id="nextAppointmentDate"></p>
            <p class="text-muted small" id="nextAppointmentTime"></p>
        </div>
        <span class="status-badge" id="nextAppointmentStatus"></span>
    </div>
    <a href="{{ route('resident.appointments') }}" class="view-all-link">View Details →</a>
</div>

<!-- Pending Certificates Card -->
<div class="info-card" id="pendingCertificatesCard" style="display:none;">
    <div class="info-card-header">
        <i class="bi bi-exclamation-triangle fs-5 text-warning"></i>
        <h6>Pending Certificates</h6>
    </div>
    <div id="pendingCertificatesList"></div>
    <a href="{{ route('resident.certificates') }}" class="view-all-link">View All Requests →</a>
</div>

<!-- Loading State -->
<div class="info-card text-center" id="loadingCard">
    <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
    <p class="text-muted mt-2 mb-0">Loading dashboard...</p>
</div>
@endsection

@section('extra-scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    fetchDashboardData();
});

async function fetchDashboardData() {
    try {
        const [appointmentsRes, certificatesRes] = await Promise.all([
            fetch('/api/resident/appointments', {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                credentials: 'same-origin',
            }),
            fetch('/api/resident/certificates', {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                credentials: 'same-origin',
            })
        ]);

        const appointments = await appointmentsRes.json();
        const certificates = await certificatesRes.json();

        // Hide loading
        document.getElementById('loadingCard').style.display = 'none';

        // Show next appointment
        const nextAppointment = appointments.find(apt => apt.status === 'approved');
        if (nextAppointment) {
            document.getElementById('nextAppointmentCard').style.display = 'block';
            document.getElementById('nextAppointmentService').textContent = nextAppointment.service_type;
            
            const date = new Date(nextAppointment.date);
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            document.getElementById('nextAppointmentDate').textContent = date.toLocaleDateString('en-US', options);
            document.getElementById('nextAppointmentTime').textContent = nextAppointment.time;
            
            const statusBadge = document.getElementById('nextAppointmentStatus');
            statusBadge.textContent = nextAppointment.status;
            statusBadge.className = 'status-badge status-' + nextAppointment.status;
        }

        // Show pending certificates
        const pendingCertificates = certificates.filter(cert => 
            cert.status === 'pending' || cert.status === 'processing'
        );
        
        if (pendingCertificates.length > 0) {
            document.getElementById('pendingCertificatesCard').style.display = 'block';
            const certList = document.getElementById('pendingCertificatesList');
            certList.innerHTML = pendingCertificates.map(cert => {
                const certName = getCertificateName(cert.type);
                const requestDate = new Date(cert.created_at).toLocaleDateString();
                return `
                    <div class="cert-item">
                        <div>
                            <p class="fw-medium small mb-1">${certName}</p>
                            <p class="text-muted" style="font-size: 0.75rem; margin: 0;">Requested: ${requestDate}</p>
                        </div>
                        <span class="status-badge status-${cert.status}">${cert.status}</span>
                    </div>
                `;
            }).join('');
        }
    } catch (err) {
        console.error('Failed to fetch dashboard data:', err);
        document.getElementById('loadingCard').innerHTML = `
            <p class="text-danger mb-0">Failed to load dashboard data</p>
        `;
    }
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
</script>
@endsection
