@extends('layouts.resident')

@section('title', 'My Profile - Resident Portal')

@section('extra-styles')
<style>
    .profile-header {
        background: linear-gradient(135deg, #0038A8 0%, #002980 100%);
        color: white;
        padding: 2rem 1.5rem;
        border-radius: 1rem 1rem 0 0;
        position: relative;
        overflow: hidden;
    }
    .profile-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }
    .profile-image-wrapper {
        position: relative;
        width: 120px;
        height: 120px;
        margin: 0 auto 1rem;
    }
    .profile-image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    .profile-name {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    .profile-username {
        font-size: 0.875rem;
        opacity: 0.9;
        font-weight: 400;
    }
    .info-section {
        background: transparent;
        padding: 1.5rem;
        margin-bottom: 1rem;
        border-radius: 0.75rem;
    }
    .info-section-title {
        font-size: 1rem;
        font-weight: 600;
        color: #0038A8;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #e5e7eb;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .info-section-title i {
        font-size: 1.25rem;
    }
    .info-item {
        display: flex;
        padding: 0.75rem 0;
        border-bottom: 1px solid #f3f4f6;
    }
    .info-item:last-child {
        border-bottom: none;
    }
    .info-label {
        font-weight: 600;
        color: #6b7280;
        font-size: 0.875rem;
        min-width: 140px;
        flex-shrink: 0;
    }
    .info-value {
        color: #1f2937;
        font-size: 0.875rem;
        flex: 1;
    }
    .emergency-badge {
        background: #fef3c7;
        color: #92400e;
        padding: 0.25rem 0.75rem;
        border-radius: 1rem;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-block;
    }
    @media (max-width: 768px) {
        .profile-header {
            padding: 1.5rem 1rem;
        }
        .profile-name {
            font-size: 1.25rem;
        }
        .info-section {
            padding: 1rem;
        }
        .info-item {
            flex-direction: column;
            gap: 0.25rem;
        }
        .info-label {
            min-width: unset;
        }
    }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-10 offset-lg-1">
        <!-- Profile Header -->
        <div class="card border-0 shadow-sm mb-3" style="background: transparent;">
            <div class="profile-header text-center">
                <div class="profile-image-wrapper">
                    @if($resident['profile_image'])
                        <img src="{{ asset('storage/' . $resident['profile_image']) }}" alt="Profile">
                    @else
                        <div style="width: 100%; height: 100%; background: transparent; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-person-fill" style="font-size: 3rem; color: rgba(255, 255, 255, 0.9);"></i>
                        </div>
                    @endif
                </div>
                <h1 class="profile-name">{{ $resident['first_name'] }} {{ $resident['middle_name'] }} {{ $resident['last_name'] }}</h1>
                <p class="profile-username">{{ $account['username'] }}</p>
            </div>

            <!-- Personal Information -->
            <div class="info-section">
                <h6 class="info-section-title">
                    <i class="bi bi-person-badge"></i>
                    Personal Information
                </h6>
                <div class="info-item">
                    <span class="info-label">Email</span>
                    <span class="info-value">{{ $resident['email'] ?? 'Not provided' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Mobile Number</span>
                    <span class="info-value">{{ $resident['contact_number'] ?? 'Not provided' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Birth Date</span>
                    <span class="info-value">{{ $resident['birth_date'] ? \Carbon\Carbon::parse($resident['birth_date'])->format('F d, Y') : 'Not provided' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Age</span>
                    <span class="info-value">{{ $resident['age'] ?? 'N/A' }} years old</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Gender</span>
                    <span class="info-value">{{ $resident['gender'] ?? 'Not specified' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Civil Status</span>
                    <span class="info-value">{{ $resident['civil_status'] ?? 'Not specified' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Nationality</span>
                    <span class="info-value">{{ $resident['nationality'] ?? 'Not specified' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Blood Type</span>
                    <span class="info-value">{{ $resident['blood_type'] ?? 'Not specified' }}</span>
                </div>
            </div>

            <!-- Address Information -->
            <div class="info-section">
                <h6 class="info-section-title">
                    <i class="bi bi-geo-alt"></i>
                    Address Information
                </h6>
                <div class="info-item">
                    <span class="info-label">Current Address</span>
                    <span class="info-value">{{ $resident['address'] ?? 'Not provided' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Barangay</span>
                    <span class="info-value">{{ $resident['barangay'] ?? 'Not specified' }}</span>
                </div>
            </div>

            <!-- Emergency Contact -->
            @if($resident['emergency_contact_name'])
            <div class="info-section">
                <h6 class="info-section-title">
                    <i class="bi bi-telephone-forward"></i>
                    Emergency Contact
                    <span class="emergency-badge ms-2">Important</span>
                </h6>
                <div class="info-item">
                    <span class="info-label">Contact Name</span>
                    <span class="info-value">{{ $resident['emergency_contact_name'] }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Contact Number</span>
                    <span class="info-value">{{ $resident['emergency_contact_no'] ?? 'Not provided' }}</span>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection