@extends('layouts.resident')

@section('title', 'Dashboard - Resident Portal')

@section('content')
<div class="resident-header">
    <h1 class="mb-0">Welcome, {{ $resident['first_name'] }}!</h1>
    <p>Barangay Kalawaan Resident Portal</p>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Dashboard</h5>
            </div>
            <div class="card-body">
                <p class="text-muted mb-4">Welcome to your resident portal. Here you can manage your information, view appointments and certificates, and access various services.</p>
                
                <div class="resident-menu">
                    <a href="{{ route('resident.profile') }}" class="btn btn-outline-primary">
                        <i class="bi bi-person me-2"></i>My Profile
                    </a>
                    <a href="{{ route('resident.appointments') }}" class="btn btn-outline-primary">
                        <i class="bi bi-calendar-check me-2"></i>Appointments
                    </a>
                    <a href="{{ route('resident.certificates') }}" class="btn btn-outline-primary">
                        <i class="bi bi-file-text me-2"></i>Certificates
                    </a>
                    <a href="{{ route('resident.family') }}" class="btn btn-outline-primary">
                        <i class="bi bi-people me-2"></i>Family
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="sidebar-resident">
            <h5>Quick Actions</h5>
            <a href="{{ route('resident.book-appointment') }}" class="text-decoration-none">
                <i class="bi bi-calendar-plus me-2"></i>Book an Appointment
            </a>
            <a href="{{ route('resident.request-certificate') }}" class="text-decoration-none">
                <i class="bi bi-file-earmark-plus me-2"></i>Request a Certificate
            </a>
        </div>

        <div class="sidebar-resident">
            <h5>Personal Info</h5>
            <p class="mb-2" style="font-size: 0.9rem;">
                <strong>Email:</strong> {{ $account['email'] ?? 'N/A' }}
            </p>
            <p class="mb-2" style="font-size: 0.9rem;">
                <strong>Phone:</strong> {{ $resident['contact_number'] ?? 'N/A' }}
            </p>
            <p style="font-size: 0.9rem;">
                <strong>Age:</strong> {{ $resident['age'] ?? 'N/A' }}
            </p>
        </div>
    </div>
</div>
@endsection