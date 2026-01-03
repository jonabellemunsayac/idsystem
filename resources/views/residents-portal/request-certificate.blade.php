@extends('layouts.resident')

@section('title', 'Request a Certificate - Resident Portal')

@section('extra-styles')
<style>
    .delivery-option {
        padding: 1rem;
        border: 2px solid #e5e7eb;
        border-radius: 0.5rem;
        cursor: pointer;
        transition: all 0.2s;
        margin-bottom: 0.75rem;
    }
    
    .delivery-option:hover {
        background-color: #f9fafb;
    }
    
    .delivery-option.selected {
        border-color: var(--pasig-blue);
        background-color: rgba(0, 56, 168, 0.05);
    }
    
    .delivery-option input[type="radio"] {
        margin-right: 0.75rem;
    }
    
    .success-modal {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 1000;
    }
    
    .success-modal.show {
        display: flex;
    }
    
    .success-content {
        background: white;
        padding: 2rem;
        border-radius: 0.5rem;
        max-width: 400px;
        width: 90%;
        text-align: center;
    }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <!-- Error Display -->
        <div id="error-alert" class="alert alert-danger d-none mb-3">
            <i class="bi bi-exclamation-circle me-2"></i>
            <span id="error-message"></span>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Certificate Request Form</h5>
            </div>
            <div class="card-body">
                <form id="certificateForm" onsubmit="submitCertificate(event)">
                    <!-- Certificate Type -->
                    <div class="mb-3">
                        <label class="form-label">Certificate Type <span class="text-danger">*</span></label>
                        <select class="form-select" id="certificateType" required>
                            <option value="">Select certificate type</option>
                            <option value="barangay_clearance">Barangay Clearance</option>
                            <option value="certificate_of_indigency">Certificate of Indigency</option>
                            <option value="certificate_of_residency">Certificate of Residency</option>
                            <option value="business_permit">Business Permit</option>
                            <option value="community_tax_certificate">Community Tax Certificate</option>
                            <option value="other">Other Certificate</option>
                        </select>
                    </div>

                    <!-- Purpose -->
                    <div class="mb-3">
                        <label class="form-label">Purpose <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="purpose" 
                               placeholder="e.g., Employment, Medical Assistance, Business" required>
                    </div>

                    <!-- Additional Details -->
                    <div class="mb-3">
                        <label class="form-label">Additional Details (Optional)</label>
                        <textarea class="form-control" id="purposeDetails" rows="3" 
                                  placeholder="Provide more information about your request..."></textarea>
                    </div>

                    <!-- Document Collection -->
                    <div class="mb-3">
                        <label class="form-label">Document Collection <span class="text-danger">*</span></label>
                        <div class="delivery-option selected" onclick="selectDelivery('pickup')">
                            <input type="radio" name="delivery" id="pickup" value="pickup" checked>
                            <label for="pickup" class="mb-0">Pick up at Barangay Hall</label>
                        </div>
                        <div class="delivery-option" onclick="selectDelivery('delivery')">
                            <input type="radio" name="delivery" id="delivery" value="delivery">
                            <label for="delivery" class="mb-0">Home Delivery</label>
                        </div>
                    </div>

                    <!-- Delivery Address (shown only when delivery is selected) -->
                    <div class="mb-3 d-none" id="deliveryAddressSection">
                        <label class="form-label">Delivery Address <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="deliveryAddress" rows="3" 
                                  placeholder="Enter your complete delivery address"></textarea>
                    </div>

                    <!-- Processing Time Notice -->
                    <div class="alert alert-info mb-4">
                        <i class="bi bi-info-circle me-2"></i>
                        <small>Processing time: 3-5 business days. You will be notified once your certificate is ready.</small>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary w-100" id="submitBtn">
                        <i class="bi bi-check-circle me-1"></i>Submit Request
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div class="success-modal" id="successModal">
    <div class="success-content">
        <div class="mb-3">
            <i class="bi bi-check-circle-fill text-success" style="font-size: 3rem;"></i>
        </div>
        <h4 class="mb-3">Request Submitted!</h4>
        <p class="text-muted mb-4">Your certificate request has been successfully submitted.</p>
        
        <div class="bg-light p-3 rounded mb-4 text-start">
            <div class="mb-2">
                <small class="text-muted d-block">Reference Number</small>
                <strong class="text-primary" id="ref-number" style="font-family: monospace;"></strong>
            </div>
            <hr class="my-2">
            <div class="mb-2">
                <small class="text-muted d-block">Certificate Type</small>
                <strong id="success-type"></strong>
            </div>
            <div>
                <small class="text-muted d-block">Purpose</small>
                <strong id="success-purpose"></strong>
            </div>
        </div>
        
        <button type="button" class="btn btn-primary w-100" onclick="window.location.href='{{ route('resident.certificates') }}'">
            View My Certificates
        </button>
    </div>
</div>
@endsection

@section('extra-scripts')
<script>
let submitting = false;

function selectDelivery(type) {
    document.querySelectorAll('.delivery-option').forEach(opt => opt.classList.remove('selected'));
    event.currentTarget.classList.add('selected');
    document.getElementById(type).checked = true;
    
    const deliverySection = document.getElementById('deliveryAddressSection');
    if (type === 'delivery') {
        deliverySection.classList.remove('d-none');
        document.getElementById('deliveryAddress').required = true;
    } else {
        deliverySection.classList.add('d-none');
        document.getElementById('deliveryAddress').required = false;
    }
}

function showError(message) {
    document.getElementById('error-message').textContent = message;
    document.getElementById('error-alert').classList.remove('d-none');
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function hideError() {
    document.getElementById('error-alert').classList.add('d-none');
}

async function submitCertificate(event) {
    event.preventDefault();
    
    if (submitting) return;
    submitting = true;
    
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Submitting...';
    
    hideError();
    
    const certificateType = document.getElementById('certificateType').value;
    const purpose = document.getElementById('purpose').value;
    const purposeDetails = document.getElementById('purposeDetails').value;
    const pickupOrDelivery = document.querySelector('input[name="delivery"]:checked').value;
    const deliveryAddress = document.getElementById('deliveryAddress').value;
    
    // Validation
    if (pickupOrDelivery === 'delivery' && !deliveryAddress) {
        showError('Please provide a delivery address');
        submitting = false;
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<i class="bi bi-check-circle me-1"></i>Submit Request';
        return;
    }
    
    try {
        const response = await fetch('/api/resident/certificates', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                type: certificateType,
                purpose: purpose,
                purpose_details: purposeDetails || null,
                pickup_or_delivery: pickupOrDelivery,
                delivery_address: pickupOrDelivery === 'delivery' ? deliveryAddress : null
            })
        });
        
        const data = await response.json();
        
        if (!response.ok) {
            throw new Error(data.message || 'Failed to submit certificate request');
        }
        
        // Show success modal
        document.getElementById('ref-number').textContent = data.certificate.reference_number;
        const typeLabel = document.querySelector(`#certificateType option[value="${certificateType}"]`).textContent;
        document.getElementById('success-type').textContent = typeLabel;
        document.getElementById('success-purpose').textContent = purpose;
        document.getElementById('successModal').classList.add('show');
        
    } catch (error) {
        showError(error.message);
        submitting = false;
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<i class="bi bi-check-circle me-1"></i>Submit Request';
    }
}
</script>
@endsection