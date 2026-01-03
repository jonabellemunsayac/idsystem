@extends('layouts.app')

@section('title', 'Appointment Details')

@section('content')
<div class="mb-4">
    <a href="{{ route('appointments.index') }}" class="btn btn-secondary mb-3">
        <i class="bi bi-arrow-left me-2"></i> Back to Appointments
    </a>

    <div class="card">
        <div class="card-body">
            <h3 class="mb-4">Appointment Details</h3>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <p><strong>Resident:</strong></p>
                    <p>{{ $appointment['resident_name'] }}</p>
                </div>

                <div class="col-md-6 mb-3">
                    <p><strong>Date & Time:</strong></p>
                    <p>{{ \Carbon\Carbon::parse($appointment['appointment_date'])->format('M d, Y H:i A') }}</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <p><strong>Status:</strong></p>
                    <p>
                        <span class="badge bg-{{ $appointment['status'] === 'confirmed' ? 'success' : ($appointment['status'] === 'pending' ? 'warning' : 'danger') }}">
                            {{ ucfirst($appointment['status']) }}
                        </span>
                    </p>
                </div>

                <div class="col-md-6 mb-3">
                    <p><strong>Created:</strong></p>
                    <p>{{ \Carbon\Carbon::parse($appointment['created_at'])->format('M d, Y H:i A') }}</p>
                </div>
            </div>

            @if($appointment['notes'])
            <div class="mb-3">
                <p><strong>Notes:</strong></p>
                <p>{{ $appointment['notes'] }}</p>
            </div>
            @endif

            <hr>

            <div class="mt-4">
                <a href="{{ route('appointments.edit', $appointment['id']) }}" class="btn btn-warning me-2">
                    <i class="bi bi-pencil me-2"></i> Edit
                </a>
                <form action="{{ route('appointments.destroy', $appointment['id']) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">
                        <i class="bi bi-trash me-2"></i> Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
