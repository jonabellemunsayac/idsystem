@extends('layouts.app')

@section('title', 'Issue Certificate')

@section('extra-styles')
<style>
    .form-card { background: white; padding: 32px; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
    .form-header { margin-bottom: 32px; }
    .form-title { font-size: 24px; font-weight: 700; color: #1f2937; margin: 0 0 8px 0; }
    .form-subtitle { color: #6b7280; margin: 0; }
    .form-section-title { font-size: 16px; font-weight: 600; color: #1f2937; margin-top: 28px; margin-bottom: 16px; }
    .form-label { font-weight: 500; color: #374151; font-size: 14px; }
    .required-field::after { content: ' *'; color: #ef4444; }
    .form-control, .form-select { border: 1px solid #e5e7eb; border-radius: 6px; padding: 10px 12px; font-size: 14px; }
    .form-control:focus, .form-select:focus { border-color: #0038A8; box-shadow: 0 0 0 3px rgba(0, 56, 168, 0.1); }
    .invalid-feedback { color: #ef4444; font-size: 12px; margin-top: 4px; }
    .form-actions { display: flex; gap: 12px; margin-top: 32px; }
    .btn-submit { background-color: #0038A8; color: white; border: none; padding: 10px 24px; border-radius: 6px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; }
    .btn-submit:hover { background-color: #002B88; }
    .btn-cancel { background-color: #e5e7eb; color: #374151; border: none; padding: 10px 24px; border-radius: 6px; font-weight: 600; cursor: pointer; text-decoration: none; transition: all 0.3s ease; display: inline-block; }
    .btn-cancel:hover { background-color: #d1d5db; }
    .back-link { color: #0038A8; text-decoration: none; font-size: 14px; margin-bottom: 24px; display: inline-flex; align-items: center; gap: 6px; }
    .back-link:hover { text-decoration: underline; }
    .cert-type-preview { background: linear-gradient(135deg, #0038A8 0%, #003A9E 100%); color: white; padding: 16px; border-radius: 8px; margin-top: 12px; font-size: 13px; text-align: center; }
    .template-info-box { background: #f0f9ff; border-left: 4px solid #0038A8; padding: 16px; border-radius: 6px; margin-bottom: 24px; }
    .template-info-box h6 { color: #0038A8; font-size: 14px; font-weight: 600; margin-bottom: 8px; }
    .template-info-box p { color: #374151; font-size: 13px; margin-bottom: 8px; line-height: 1.5; }
    .template-download-link { color: #0038A8; font-weight: 600; text-decoration: none; font-size: 13px; }
    .template-download-link:hover { text-decoration: underline; }

    /* ===== Mobile Responsive ===== */
    @media (max-width: 768px) {
        .form-card { padding: 18px; }
        .form-header { margin-bottom: 20px; }
        .form-title { font-size: 20px; }
        .form-section-title { font-size: 15px; margin-top: 20px; margin-bottom: 12px; }
        .form-actions { flex-direction: column; }
        .form-actions .btn-cancel,
        .form-actions .btn-submit { width: 100%; text-align: center; }
        .template-info-box { padding: 12px; }
    }
</style>
@endsection

@section('content')
<a href="{{ route('certificates.index') }}" class="back-link"><i class="bi bi-arrow-left"></i> Back to Certificates</a>

<div class="form-card">
    <div class="form-header">
        <h1 class="form-title">Issue New Certificate</h1>
        <p class="form-subtitle">Select a resident and certificate type to create a new certificate</p>
    </div>

    <div class="template-info-box">
        <h6><i class="bi bi-info-circle me-2"></i>Certificate Templates Available</h6>
        <p>Official certificate templates in Word format are available for download. These templates can be customized and printed for official use.</p>
        <a href="{{ route('certificates.index') }}" class="template-download-link">
            <i class="bi bi-download me-1"></i> View and download templates from certificate list
        </a>
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
                <select class="form-select @error('certificate_type') is-invalid @enderror" id="certificate_type" name="certificate_type" required>
                    <option value="">Select Certificate Type</option>
                    <option value="indigency" @selected(old('certificate_type') == 'indigency' || request('type') == 'indigency')>
                        📄 Certificate of Indigency
                    </option>
                    <option value="residency" @selected(old('certificate_type') == 'residency' || request('type') == 'residency')>
                        🏠 Certificate of Residency
                    </option>
                    <option value="clearance" @selected(old('certificate_type') == 'clearance' || request('type') == 'clearance')>
                        ✅ Certificate of Clearance
                    </option>
                    <option value="low_income" @selected(old('certificate_type') == 'low_income' || request('type') == 'low_income')>
                        💰 Certificate of Low Income
                    </option>
                    <option value="no_income" @selected(old('certificate_type') == 'no_income' || request('type') == 'no_income')>
                        🚫 Certification of No Income
                    </option>
                </select>
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
                    <option value="draft" @selected(old('status') == 'draft')>Draft</option>
                    <option value="pending" @selected(old('status') == 'pending')>Pending Review</option>
                    <option value="approved" @selected(old('status') == 'approved')>Approved</option>
                </select>
                @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <!-- Additional Information -->
        <h3 class="form-section-title">Additional Information</h3>
        <div class="row g-3">
            <div class="col-md-12">
                <label for="remarks" class="form-label">Remarks / Purpose</label>
                <textarea class="form-control @error('remarks') is-invalid @enderror" id="remarks" name="remarks" rows="4" placeholder="Enter any additional remarks or purpose for this certificate...">{{ old('remarks') }}</textarea>
                @error('remarks') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('certificates.index') }}" class="btn-cancel">Cancel</a>
            <button type="submit" class="btn-submit">
                <i class="bi bi-save me-2"></i> Issue Certificate
            </button>
        </div>
    </form>
</div>

<script>
    // Show certificate type preview
    document.getElementById('certificate_type').addEventListener('change', function() {
        const certTypes = {
            'indigency': '📄 Certificate of Indigency - For individuals with low income status',
            'residency': '🏠 Certificate of Residency - Proof of residential address',
            'clearance': '✅ Certificate of Clearance - Barangay clearance certificate',
            'low_income': '💰 Certificate of Low Income - For income assistance and benefits'
        };
        
        if (this.value && certTypes[this.value]) {
            // Update preview if needed in future
        }
    });
</script>
@endsection
