@extends('layouts.app')

@section('title', 'User Account')

@section('content')
<div class="d-flex justify-content-center align-items-flex-start min-vh-100">
    <div style="width: 100%; max-width: 600px; padding: 2rem 1rem;">
        <div class="mb-4 text-center">
            <h2 class="mb-0">
                <i class="bi bi-person-circle me-2"></i>User Account
            </h2>
            <p class="text-muted mt-1">Manage your account settings</p>
        </div>

        <!-- User Information Card -->
        <div class="mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light border-bottom">
                    <h5 class="mb-0">
                        <i class="bi bi-info-circle me-2"></i>Your Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Full Name</p>
                            <p class="fw-500">{{ $user->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Username</p>
                            <p class="fw-500">{{ $user->username }}</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Email</p>
                            <p class="fw-500">{{ $user->email }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Role</p>
                            <p class="fw-500">
                                <span class="badge bg-primary">{{ ucfirst($user->role) }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Change Password Card -->
        <div>
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light border-bottom">
                    <h5 class="mb-0">
                        <i class="bi bi-lock me-2"></i>Change Password
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('settings.user-account.update-password') }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label for="current_password" class="form-label">
                                Current Password <span class="text-danger">*</span>
                            </label>
                            <input 
                                type="password" 
                                class="form-control @error('current_password') is-invalid @enderror" 
                                id="current_password" 
                                name="current_password"
                                placeholder="Enter your current password"
                                required
                            >
                            @error('current_password')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">
                                New Password <span class="text-danger">*</span>
                            </label>
                            <input 
                                type="password" 
                                class="form-control @error('password') is-invalid @enderror" 
                                id="password" 
                                name="password"
                                placeholder="Enter your new password"
                                required
                            >
                            <small class="form-text text-muted d-block mt-1">
                                <i class="bi bi-info-circle me-1"></i>
                                Password must be at least 8 characters long
                            </small>
                            @error('password')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label">
                                Confirm New Password <span class="text-danger">*</span>
                            </label>
                            <input 
                                type="password" 
                                class="form-control @error('password_confirmation') is-invalid @enderror" 
                                id="password_confirmation" 
                                name="password_confirmation"
                                placeholder="Confirm your new password"
                                required
                            >
                            @error('password_confirmation')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i>Update Password
                            </button>
                            <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-2"></i>Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .min-vh-100 {
        min-height: 100vh;
    }
    
    .fw-500 {
        font-weight: 500;
    }
    
    .card {
        transition: box-shadow 0.3s ease;
    }
    
    .card:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1) !important;
    }
    
    .card-header {
        background-color: #f8f9fa !important;
    }
    
    .form-control:focus {
        border-color: #0038A8;
        box-shadow: 0 0 0 0.2rem rgba(0, 56, 168, 0.25);
    }
    
    .btn-primary {
        background-color: #0038A8;
        border-color: #0038A8;
    }
    
    .btn-primary:hover {
        background-color: #002d85;
        border-color: #002d85;
    }
</style>
@endsection
