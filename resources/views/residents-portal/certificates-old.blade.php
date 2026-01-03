@extends('layouts.resident')

@section('title', 'My Certificates - Resident Portal')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">My Certificates</h5>
                <a href="{{ route('resident.request-certificate') }}" class="btn btn-sm btn-primary">
                    <i class="bi bi-plus-lg me-1"></i>Request New
                </a>
            </div>
            <div class="card-body">
                <p class="text-muted">Your issued certificates will appear here. Request a new certificate if needed.</p>
            </div>
        </div>
    </div>
</div>
@endsection