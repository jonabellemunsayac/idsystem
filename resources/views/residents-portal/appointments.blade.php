@extends('layouts.resident')

@section('title', 'Appointments - Resident Portal')

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
    .appointment-card {
        background: white;
        border-radius: 0.75rem;
        padding: 1rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin-bottom: 1rem;
        transition: all 0.2s;
    }
    .appointment-card:hover {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }
    .appointment-header {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 0.75rem;
    }
    .appointment-title {
        font-weight: 600;
        font-size: 1rem;
        margin-bottom: 0.25rem;
    }
    .appointment-ref {
        font-size: 0.875rem;
        color: #6b7280;
    }
    .appointment-details {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }
    .appointment-detail-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
    }
    .appointment-detail-item i {
        color: #6b7280;
    }
    .appointment-actions {
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
    .status-completed {
        background-color: #e0e7ff;
        color: #3730a3;
    }
    .status-cancelled, .status-released, .status-ready {
        background-color: #f3f4f6;
        color: #374151;
    }
    .tabs {
        display: flex;
        gap: 0;
        background: #f3f4f6;
        border-radius: 0.5rem;
        padding: 0.25rem;
        margin-bottom: 1rem;
    }
    .tab-button {
        flex: 1;
        padding: 0.5rem 1rem;
        border: none;
        background: transparent;
        border-radius: 0.375rem;
        font-weight: 500;
        font-size: 0.875rem;
        color: #6b7280;
        cursor: pointer;
        transition: all 0.2s;
    }
    .tab-button.active {
        background: white;
        color: #111827;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }
    .tab-content {
        display: none;
    }
    .tab-content.active {
        display: block;
    }
    .empty-state {
        background: white;
        border-radius: 0.75rem;
        padding: 3rem 1rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        text-align: center;
    }
    .empty-state p {
        color: #6b7280;
        margin: 0;
    }
</style>
@endsection

@section('content')
<div class="page-header">
    <h2>Appointments</h2>
    <a href="{{ route('resident.book-appointment') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Book New
    </a>
</div>

<!-- Loading State -->
<div class="empty-state" id="loadingState">
    <div class="spinner-border text-primary mb-2" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
    <p>Loading appointments...</p>
</div>

<!-- Error State -->
<div class="alert alert-danger" id="errorState" style="display:none;" role="alert"></div>

<!-- Tabs -->
<div class="tabs" id="appointmentTabs" style="display:none;">
    <button class="tab-button active" onclick="switchTab('upcoming')">Upcoming</button>
    <button class="tab-button" onclick="switchTab('past')">Past</button>
</div>

<!-- Upcoming Appointments -->
<div class="tab-content active" id="upcoming-tab">
    <div id="upcomingAppointments"></div>
</div>

<!-- Past Appointments -->
<div class="tab-content" id="past-tab">
    <div id="pastAppointments"></div>
</div>
@endsection

@section('extra-scripts')
<script>
let appointments = [];

document.addEventListener('DOMContentLoaded', function() {
    fetchAppointments();
});

function switchTab(tab) {
    // Update tab buttons
    document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');
    
    // Update tab content
    document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
    document.getElementById(tab + '-tab').classList.add('active');
}

async function fetchAppointments() {
    try {
        const response = await fetch('/api/resident/appointments', {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            credentials: 'same-origin',
        });
        
        if (!response.ok) {
            throw new Error(`Failed to fetch appointments: ${response.status}`);
        }
        
        appointments = await response.json();
        
        // Hide loading, show tabs
        document.getElementById('loadingState').style.display = 'none';
        document.getElementById('appointmentTabs').style.display = 'flex';
        
        renderAppointments();
    } catch (err) {
        console.error('Error fetching appointments:', err);
        document.getElementById('loadingState').style.display = 'none';
        document.getElementById('errorState').style.display = 'block';
        document.getElementById('errorState').textContent = err.message;
    }
}

function renderAppointments() {
    const upcomingAppointments = appointments.filter(apt => 
        apt.status === 'approved' || apt.status === 'pending' || apt.status === 'processing'
    );
    const pastAppointments = appointments.filter(apt => 
        apt.status === 'completed' || apt.status === 'cancelled' || apt.status === 'ready' || apt.status === 'released'
    );
    
    // Render upcoming
    const upcomingContainer = document.getElementById('upcomingAppointments');
    if (upcomingAppointments.length > 0) {
        upcomingContainer.innerHTML = upcomingAppointments.map(apt => renderAppointmentCard(apt)).join('');
    } else {
        upcomingContainer.innerHTML = '<div class="empty-state"><p>No upcoming appointments</p></div>';
    }
    
    // Render past
    const pastContainer = document.getElementById('pastAppointments');
    if (pastAppointments.length > 0) {
        pastContainer.innerHTML = pastAppointments.map(apt => renderAppointmentCard(apt)).join('');
    } else {
        pastContainer.innerHTML = '<div class="empty-state"><p>No past appointments</p></div>';
    }
}

function renderAppointmentCard(apt) {
    const date = new Date(apt.date);
    const dateStr = date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
    
    return `
        <div class="appointment-card">
            <div class="appointment-header">
                <div>
                    <div class="appointment-title">${apt.service_type}</div>
                    <div class="appointment-ref">${apt.reference_number}</div>
                </div>
                <span class="status-badge status-${apt.status}">${apt.status}</span>
            </div>
            
            <div class="appointment-details">
                <div class="appointment-detail-item">
                    <i class="bi bi-calendar"></i>
                    <span>${dateStr}</span>
                </div>
                <div class="appointment-detail-item">
                    <i class="bi bi-clock"></i>
                    <span>${apt.time}</span>
                </div>
            </div>
            
            <div class="appointment-actions">
                <button class="btn btn-outline-secondary btn-sm flex-fill">View Details</button>
                ${apt.status === 'approved' ? '<button class="btn btn-outline-secondary btn-sm">Reschedule</button>' : ''}
            </div>
        </div>
    `;
}
</script>
@endsection
