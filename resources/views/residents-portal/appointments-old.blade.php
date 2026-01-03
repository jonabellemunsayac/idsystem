@extends('layouts.resident')

@section('title', 'My Appointments - Resident Portal')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">My Appointments</h5>
                <a href="{{ route('resident.book-appointment') }}" class="btn btn-sm btn-primary">
                    <i class="bi bi-plus-lg me-1"></i>Book New
                </a>
            </div>
            <div class="card-body">
                <p class="text-muted">Your appointments will appear here. Book a new appointment to get started.</p>
            </div>
        </div>
    </div>
</div>
@endsection