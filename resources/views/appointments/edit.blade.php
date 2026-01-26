@extends('layouts.app')

@section('title', 'Edit Appointment')

@section('content')
<div class="form-card">
    <div class="form-header">
        <h1 class="form-title">Edit Appointment</h1>
        <p class="form-subtitle">Update appointment details</p>
    </div>

    <form action="{{ route('appointments.update', $appointment['id']) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Appointment Details -->
        <h3 class="form-section-title">Appointment Details</h3>
        <div class="row g-3">
            <div class="col-md-6">
                <label for="resident_id" class="form-label required-field">Resident</label>
                <select class="form-select @error('resident_id') is-invalid @enderror" id="resident_id" name="resident_id" required>
                    <option value="">Select Resident</option>
                    @foreach($residents as $resident)
                        <option value="{{ $resident['id'] }}" @selected(old('resident_id', $appointment['resident_id']) == $resident['id'])>
                            {{ $resident['first_name'] }} {{ $resident['last_name'] }}
                        </option>
                    @endforeach
                </select>
                @error('resident_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label for="service_type" class="form-label required-field">Service Type</label>
                <input type="text" class="form-control @error('service_type') is-invalid @enderror" id="service_type" name="service_type" placeholder="e.g., Certificate Request, General Inquiry" value="{{ old('service_type', $appointment['service_type'] ?? '') }}" required>
                @error('service_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label for="appointment_date" class="form-label required-field">Date & Time</label>
                <input type="datetime-local" class="form-control @error('appointment_date') is-invalid @enderror" id="appointment_date" name="appointment_date" value="{{ old('appointment_date', $appointment['appointment_date']) }}" required>
                @error('appointment_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label for="status" class="form-label required-field">Status</label>
                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                    <option value="pending" @selected(old('status', $appointment['status']) == 'pending')>Pending</option>
                    <option value="confirmed" @selected(old('status', $appointment['status']) == 'confirmed')>Confirmed</option>
                    <option value="cancelled" @selected(old('status', $appointment['status']) == 'cancelled')>Cancelled</option>
                </select>
                @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <!-- Additional Information -->
        <h3 class="form-section-title">Additional Information</h3>
        <div class="row g-3">
            <div class="col-md-12">
                <label for="notes" class="form-label">Notes</label>
                <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="4">{{ old('notes', $appointment['notes']) }}</textarea>
                @error('notes') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('appointments.index') }}" class="btn-cancel">Cancel</a>
            <button type="submit" class="btn-submit">
                <i class="bi bi-save"></i> Update Appointment
            </button>
        </div>
    </form>
</div>
@endsection
