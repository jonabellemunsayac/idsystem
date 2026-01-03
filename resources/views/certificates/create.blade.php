@extends('layouts.app')

@section('title', 'Issue Certificate')

@section('content')
<div class="form-card">
    <div class="form-header">
        <h1 class="form-title">Issue New Certificate</h1>
        <p class="form-subtitle">Create a new certificate record</p>
    </div>

    <form action="{{ route('certificates.store') }}" method="POST">
        @csrf

        <!-- Certificate Details -->
        <h3 class="form-section-title">Certificate Details</h3>
        <div class="row g-3">
            <div class="col-md-6">
                <label for="resident_id" class="form-label required-field">Resident</label>
                <select class="form-select @error('resident_id') is-invalid @enderror" id="resident_id" name="resident_id" required>
                    <option value="">Select Resident</option>
                    @foreach($residents as $resident)
                        <option value="{{ $resident['id'] }}" @selected(old('resident_id') == $resident['id'])>
                            {{ $resident['first_name'] }} {{ $resident['last_name'] }}
                        </option>
                    @endforeach
                </select>
                @error('resident_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label for="certificate_type" class="form-label required-field">Certificate Type</label>
                <input type="text" class="form-control @error('certificate_type') is-invalid @enderror" id="certificate_type" name="certificate_type" value="{{ old('certificate_type') }}" placeholder="e.g., Barangay Clearance, Residency, etc." required>
                @error('certificate_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label for="issued_date" class="form-label required-field">Issued Date</label>
                <input type="date" class="form-control @error('issued_date') is-invalid @enderror" id="issued_date" name="issued_date" value="{{ old('issued_date', date('Y-m-d')) }}" required>
                @error('issued_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label for="status" class="form-label required-field">Status</label>
                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                    <option value="active" @selected(old('status') == 'active')>Active</option>
                    <option value="inactive" @selected(old('status') == 'inactive')>Inactive</option>
                </select>
                @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <!-- Additional Information -->
        <h3 class="form-section-title">Additional Information</h3>
        <div class="row g-3">
            <div class="col-md-12">
                <label for="remarks" class="form-label">Remarks</label>
                <textarea class="form-control @error('remarks') is-invalid @enderror" id="remarks" name="remarks" rows="4">{{ old('remarks') }}</textarea>
                @error('remarks') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('certificates.index') }}" class="btn-cancel">Cancel</a>
            <button type="submit" class="btn-submit">
                <i class="bi bi-save"></i> Issue Certificate
            </button>
        </div>
    </form>
</div>
@endsection
