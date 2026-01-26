@extends('layouts.resident')

@section('title', 'Book an Appointment - Resident Portal')

@section('extra-styles')
<style>
    .step-indicator {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 2rem;
        max-width: 400px;
        margin-left: auto;
        margin-right: auto;
    }
    
    .step-circle {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.875rem;
        font-weight: 500;
        background-color: #e5e7eb;
        color: #6b7280;
    }
    
    .step-circle.active {
        background-color: var(--pasig-blue);
        color: white;
    }
    
    .step-line {
        width: 64px;
        height: 4px;
        background-color: #e5e7eb;
        margin: 0 0.25rem;
    }
    
    .step-line.active {
        background-color: var(--pasig-blue);
    }
    
    .time-slot-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.5rem;
    }
    
    .time-slot-btn {
        padding: 0.5rem;
        text-align: center;
        border: 1px solid #e5e7eb;
        border-radius: 0.375rem;
        background: white;
        cursor: pointer;
        font-size: 0.75rem;
        transition: all 0.2s;
    }
    
    .time-slot-btn:hover:not(:disabled) {
        background-color: #f3f4f6;
    }
    
    .time-slot-btn.selected {
        background-color: var(--pasig-blue);
        color: white;
        border-color: var(--pasig-blue);
    }
    
    .time-slot-btn:disabled {
        background-color: #f3f4f6;
        color: #d1d5db;
        border-color: #d1d5db;
        cursor: not-allowed;
        opacity: 0.6;
        text-decoration: line-through;
    }
    
    .time-slot-btn:disabled::after {
        content: ' (Booked)';
        font-size: 0.65rem;
    }
    
    .form-step {
        display: none;
    }
    
    .form-step.active {
        display: block;
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
    
    .countdown-circle {
        position: relative;
        width: 80px;
        height: 80px;
        margin: 1rem auto;
    }
    
    .countdown-number {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 2rem;
        font-weight: bold;
        color: var(--pasig-blue);
    }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <!-- Step Indicator -->
        <div class="step-indicator">
            <div class="step-circle active" id="step-circle-1">1</div>
            <div class="step-line" id="step-line-1"></div>
            <div class="step-circle" id="step-circle-2">2</div>
            <div class="step-line" id="step-line-2"></div>
            <div class="step-circle" id="step-circle-3">3</div>
            <div class="step-line" id="step-line-3"></div>
            <div class="step-circle" id="step-circle-4">4</div>
        </div>

        <!-- Error Display -->
        <div id="error-alert" class="alert alert-danger d-none mb-3">
            <i class="bi bi-exclamation-circle me-2"></i>
            <span id="error-message"></span>
        </div>

        <!-- Step 1: Service Type -->
        <div class="card form-step active" id="step-1">
            <div class="card-header">
                <h5 class="mb-0">Select Service Type</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <select class="form-select" id="serviceType">
                        <option value="">Choose a service</option>
                        <option value="Barangay Clearance">Barangay Clearance</option>
                        <option value="Certificate of Indigency">Certificate of Indigency</option>
                        <option value="Certificate of Residency">Certificate of Residency</option>
                        <option value="Business Permit">Business Permit</option>
                        <option value="Community Tax Certificate">Community Tax Certificate</option>
                        <option value="Other Services">Other Services</option>
                    </select>
                </div>
                <button type="button" class="btn btn-primary w-100" onclick="goToStep(2)">Next</button>
            </div>
        </div>

        <!-- Step 2: Date & Time -->
        <div class="card form-step" id="step-2">
            <div class="card-header">
                <h5 class="mb-0">Select Date & Time</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Date</label>
                    <input type="date" class="form-control" id="appointmentDate" min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                    <small class="text-muted">Weekends are not available for appointments</small>
                </div>
                <div class="mb-3">
                    <label class="form-label">Time Slot</label>
                    <div class="time-slot-grid" id="timeSlots">
                        <button type="button" class="time-slot-btn" data-time="09:00" onclick="selectTime('9:00 AM')">9:00 AM</button>
                        <button type="button" class="time-slot-btn" data-time="10:00" onclick="selectTime('10:00 AM')">10:00 AM</button>
                        <button type="button" class="time-slot-btn" data-time="11:00" onclick="selectTime('11:00 AM')">11:00 AM</button>
                        <button type="button" class="time-slot-btn" data-time="13:00" onclick="selectTime('1:00 PM')">1:00 PM</button>
                        <button type="button" class="time-slot-btn" data-time="14:00" onclick="selectTime('2:00 PM')">2:00 PM</button>
                        <button type="button" class="time-slot-btn" data-time="15:00" onclick="selectTime('3:00 PM')">3:00 PM</button>
                        <button type="button" class="time-slot-btn" data-time="16:00" onclick="selectTime('4:00 PM')">4:00 PM</button>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-secondary flex-fill" onclick="goToStep(1)">Back</button>
                    <button type="button" class="btn btn-primary flex-fill" onclick="goToStep(3)">Next</button>
                </div>
            </div>
        </div>

        <!-- Step 3: Purpose & Details -->
        <div class="card form-step" id="step-3">
            <div class="card-header">
                <h5 class="mb-0">Purpose & Details</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Purpose</label>
                    <input type="text" class="form-control" id="purpose" placeholder="e.g., Employment, Medical Assistance">
                </div>
                <div class="mb-3">
                    <label class="form-label">Additional Details (Optional)</label>
                    <textarea class="form-control" id="details" rows="3" placeholder="Any specific requirements or notes..."></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Document Collection</label>
                    <div class="p-3 bg-light rounded">Pick up at Barangay Hall</div>
                </div>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-secondary flex-fill" onclick="goToStep(2)">Back</button>
                    <button type="button" class="btn btn-primary flex-fill" onclick="goToStep(4)">Review</button>
                </div>
            </div>
        </div>

        <!-- Step 4: Review -->
        <div class="card form-step" id="step-4">
            <div class="card-header">
                <h5 class="mb-0">Review Appointment</h5>
            </div>
            <div class="card-body">
                <div class="mb-3 pb-3 border-bottom d-flex justify-content-between">
                    <span class="text-muted">Service</span>
                    <span class="fw-medium" id="review-service"></span>
                </div>
                <div class="mb-3 pb-3 border-bottom d-flex justify-content-between">
                    <span class="text-muted">Date & Time</span>
                    <span class="fw-medium" id="review-datetime"></span>
                </div>
                <div class="mb-3 pb-3 border-bottom d-flex justify-content-between">
                    <span class="text-muted">Purpose</span>
                    <span class="fw-medium" id="review-purpose"></span>
                </div>
                <div class="mb-3 pb-3 border-bottom d-flex justify-content-between">
                    <span class="text-muted">Collection</span>
                    <span class="fw-medium">Pickup</span>
                </div>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-secondary flex-fill" onclick="goToStep(3)">Back</button>
                    <button type="button" class="btn btn-primary flex-fill" onclick="submitAppointment()">
                        <i class="bi bi-check-circle me-1"></i>Confirm
                    </button>
                </div>
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
        <h4 class="mb-3">Appointment Confirmed!</h4>
        <p class="text-muted mb-4">Your appointment has been successfully booked.</p>
        
        <div class="bg-light p-3 rounded mb-4 text-start">
            <div class="mb-3">
                <small class="text-muted d-block">Reference Number</small>
                <strong class="text-primary" id="ref-number" style="font-family: monospace;"></strong>
            </div>
            <hr>
            <div class="row g-3">
                <div class="col-6">
                    <small class="text-muted d-block">Service</small>
                    <strong id="success-service"></strong>
                </div>
                <div class="col-6">
                    <small class="text-muted d-block">Date</small>
                    <strong id="success-date"></strong>
                </div>
                <div class="col-12">
                    <small class="text-muted d-block">Time</small>
                    <strong id="success-time"></strong>
                </div>
            </div>
        </div>
        
        <div class="countdown-circle">
            <svg width="80" height="80">
                <circle cx="40" cy="40" r="36" fill="none" stroke="#e5e7eb" stroke-width="3"></circle>
                <circle id="countdown-progress" cx="40" cy="40" r="36" fill="none" stroke="var(--pasig-blue)" stroke-width="3" 
                        stroke-dasharray="226" stroke-dashoffset="0" transform="rotate(-90 40 40)"></circle>
            </svg>
            <div class="countdown-number" id="countdown">5</div>
        </div>
        <p class="text-muted mb-3">Redirecting in <span id="countdown-text">5</span> seconds...</p>
        
        <button type="button" class="btn btn-primary w-100" onclick="window.location.href='{{ route('resident.appointments') }}'">
            Go Now
        </button>
    </div>
</div>
@endsection

@section('extra-scripts')
<script>
let currentStep = 1;
let selectedTime = '';
let submitting = false;
let lastSelectedDate = '';  // Track the last selected date

function goToStep(step) {
    // Allow back button to work even if submitting
    if (step < currentStep) {
        submitting = false;
    }
    
    const serviceTypeElem = document.getElementById('serviceType');
    const appointmentDateElem = document.getElementById('appointmentDate');
    const purposeElem = document.getElementById('purpose');
    
    if (!serviceTypeElem || !appointmentDateElem || !purposeElem) {
        console.error('Required form elements not found');
        return;
    }
    
    const serviceType = serviceTypeElem.value;
    const appointmentDate = appointmentDateElem.value;
    const purpose = purposeElem.value;
    
    // Validation
    if (step === 2 && !serviceType) {
        showError('Please select a service type');
        return;
    }
    
    if (step === 3 && (!appointmentDate || !selectedTime)) {
        showError('Please select date and time');
        return;
    }
    
    if (step === 3 && appointmentDate) {
        const date = new Date(appointmentDate);
        const day = date.getDay();
        if (day === 0 || day === 6) {
            showError('Weekends are not available. Please select a weekday (Monday to Friday)');
            return;
        }
        // Load booked slots for selected date
        loadBookedSlots();
    }
    
    if (step === 4 && !purpose) {
        showError('Please enter the purpose of your appointment');
        return;
    }
    
    hideError();
    
    // Update step circles
    document.querySelectorAll('.form-step').forEach(s => s.classList.remove('active'));
    const currentStepElem = document.getElementById('step-' + step);
    if (currentStepElem) {
        currentStepElem.classList.add('active');
    }
    
    for (let i = 1; i <= 4; i++) {
        const circle = document.getElementById('step-circle-' + i);
        const line = document.getElementById('step-line-' + i);
        
        if (circle) {
            if (i <= step) {
                circle.classList.add('active');
            } else {
                circle.classList.remove('active');
            }
        }
        
        if (line) {
            if (i <= step && i < step) {
                line.classList.add('active');
            } else {
                line.classList.remove('active');
            }
        }
    }
    
    // Update review section
    if (step === 4) {
        const reviewService = document.getElementById('review-service');
        const reviewDatetime = document.getElementById('review-datetime');
        const reviewPurpose = document.getElementById('review-purpose');
        
        if (reviewService) reviewService.textContent = serviceType;
        if (reviewDatetime) {
            const dateObj = new Date(appointmentDate);
            const formattedDate = dateObj.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
            reviewDatetime.textContent = formattedDate + ' at ' + selectedTime;
        }
        if (reviewPurpose) reviewPurpose.textContent = purpose;
    }
    
    currentStep = step;
}

function selectTime(time) {
    const btn = event.target;
    if (btn.disabled) {
        showError('This time slot is already booked.');
        return;
    }
    selectedTime = time;
    document.querySelectorAll('.time-slot-btn').forEach(b => b.classList.remove('selected'));
    btn.classList.add('selected');
}

function loadBookedSlots() {
    const appointmentDateElem = document.getElementById('appointmentDate');
    
    if (!appointmentDateElem) {
        console.error('Appointment date input not found');
        return;
    }
    
    const dateInput = appointmentDateElem.value;
    
    console.log('Loading booked slots for date:', dateInput);
    
    // Reset all buttons to enabled state (but preserve selected state if date hasn't changed)
    document.querySelectorAll('.time-slot-btn').forEach(btn => {
        btn.disabled = false;
        // Don't remove selected class here - let the user keep their selection
    });
    
    // Get CSRF token safely
    const csrfTokenElement = document.querySelector('meta[name="csrf-token"]');
    const csrfToken = csrfTokenElement ? csrfTokenElement.content : '';
    
    // Fetch booked slots for this date
    fetch(`/api/appointments/booked-slots/${dateInput}`, {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
        }
    })
    .then(response => {
        console.log('Response status:', response.status);
        return response.json();
    })
    .then(data => {
        console.log('Booked slots data:', data);
        const bookedSlots = data.booked_slots || [];
        console.log('Booked times:', bookedSlots);
        
        // Disable booked time slots
        document.querySelectorAll('.time-slot-btn').forEach(btn => {
            const time = btn.getAttribute('data-time');
            if (bookedSlots.includes(time)) {
                console.log('Disabling slot:', time);
                btn.disabled = true;
            }
        });
    })
    .catch(error => {
        console.error('Error loading booked slots:', error);
    });
}

function showError(message) {
    const errorMessage = document.getElementById('error-message');
    const errorAlert = document.getElementById('error-alert');
    
    if (!errorMessage || !errorAlert) {
        console.error('Error elements not found:', {errorMessage, errorAlert});
        return;
    }
    
    errorMessage.textContent = message;
    errorAlert.classList.remove('d-none');
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function hideError() {
    const errorAlert = document.getElementById('error-alert');
    if (errorAlert) {
        errorAlert.classList.add('d-none');
    }
}

async function submitAppointment() {
    if (submitting) return;
    submitting = true;
    
    const serviceTypeElem = document.getElementById('serviceType');
    const appointmentDateElem = document.getElementById('appointmentDate');
    const purposeElem = document.getElementById('purpose');
    
    if (!serviceTypeElem || !appointmentDateElem || !purposeElem) {
        showError('Required form elements not found');
        submitting = false;
        return;
    }
    
    const serviceType = serviceTypeElem.value;
    const appointmentDate = appointmentDateElem.value;
    const purpose = purposeElem.value;
    
    // Validate inputs
    if (!selectedTime) {
        showError('Please select a time slot');
        submitting = false;
        return;
    }
    
    // Parse date components directly from the date string (YYYY-MM-DD format)
    const [year, month, day] = appointmentDate.split('-');
    
    if (!year || !month || !day) {
        showError('Invalid date selected');
        submitting = false;
        return;
    }
    
    // Parse time components (e.g., "9:00 AM" -> "09" hours and "00" minutes)
    const [timePart, period] = selectedTime.split(' ');
    if (!timePart || !period) {
        showError('Invalid time format');
        submitting = false;
        return;
    }
    
    const [hours, minutes] = timePart.split(':').map(Number);
    if (isNaN(hours) || isNaN(minutes)) {
        showError('Invalid time selected');
        submitting = false;
        return;
    }
    
    // Convert to 24-hour format
    let adjustedHours = hours;
    if (period === 'PM' && hours !== 12) {
        adjustedHours = hours + 12;
    } else if (period === 'AM' && hours === 12) {
        adjustedHours = 0;
    }
    
    // Format as YYYY-MM-DD HH:MM (with space, not T)
    const hrs = String(adjustedHours).padStart(2, '0');
    const mins = String(minutes).padStart(2, '0');
    const formattedDateTime = `${year}-${month}-${day} ${hrs}:${mins}`;
    
    console.log('Formatted date/time:', formattedDateTime);
    
    // Get CSRF token safely
    const csrfTokenElement = document.querySelector('meta[name="csrf-token"]');
    const csrfToken = csrfTokenElement ? csrfTokenElement.content : '';
    
    // Check slot availability first
    try {
        console.log('Checking slot availability for:', formattedDateTime);
        const availabilityResponse = await fetch('/api/appointments/check-slot-availability', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify({
                appointment_date: formattedDateTime
            })
        });
        
        console.log('Availability response status:', availabilityResponse.status);
        const availabilityData = await availabilityResponse.json();
        console.log('Availability response data:', availabilityData);
        
        if (!availabilityResponse.ok || !availabilityData.available) {
            showError(availabilityData.message || 'This time slot is already booked. Please select a different date or time.');
            submitting = false;
            return;
        }
    } catch (error) {
        console.error('Error checking slot availability:', error);
        showError('Error checking slot availability. Please try again.');
        submitting = false;
        return;
    }
    
    try {
        const response = await fetch('/api/resident/appointments', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                service_type: serviceType,
                scheduled_time: formattedDateTime,
            })
        });
        
        const data = await response.json();
        
        console.log('Appointment response status:', response.status);
        console.log('Appointment response data:', data);
        
        if (!response.ok) {
            // Log validation errors if present
            if (data.errors) {
                console.error('Validation errors:', data.errors);
                const errorMessages = Object.values(data.errors).flat().join(', ');
                throw new Error(errorMessages || data.message || 'Failed to book appointment');
            }
            throw new Error(data.message || 'Failed to book appointment');
        }
        
        // Show success modal with null checks
        const refNumber = document.getElementById('ref-number');
        const successService = document.getElementById('success-service');
        const successDate = document.getElementById('success-date');
        const successTime = document.getElementById('success-time');
        const successModal = document.getElementById('successModal');
        
        if (refNumber) refNumber.textContent = data.reference_number;
        if (successService) successService.textContent = serviceType;
        
        const formattedDate = new Date(appointmentDate).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
        if (successDate) successDate.textContent = formattedDate;
        if (successTime) successTime.textContent = selectedTime;
        if (successModal) successModal.classList.add('show');
        
        // Start countdown
        let countdown = 5;
        const interval = setInterval(() => {
            countdown--;
            const countdownElem = document.getElementById('countdown');
            const countdownText = document.getElementById('countdown-text');
            const countdownProgress = document.getElementById('countdown-progress');
            
            if (countdownElem) countdownElem.textContent = countdown;
            if (countdownText) countdownText.textContent = countdown;
            
            const offset = 226 * (1 - countdown / 5);
            if (countdownProgress) countdownProgress.style.strokeDashoffset = offset;
            
            if (countdown <= 0) {
                clearInterval(interval);
                window.location.href = '{{ route("resident.appointments") }}';
            }
        }, 1000);
        
    } catch (error) {
        showError(error.message);
        submitting = false;
    }
}

// Add event listener for appointment date to load booked slots
document.addEventListener('DOMContentLoaded', function() {
    const appointmentDateInput = document.getElementById('appointmentDate');
    if (appointmentDateInput) {
        appointmentDateInput.addEventListener('change', function() {
            if (this.value) {
                // Only reset selectedTime if the date actually changed
                if (lastSelectedDate !== this.value) {
                    selectedTime = '';
                    // Remove selected class from all buttons
                    document.querySelectorAll('.time-slot-btn').forEach(b => b.classList.remove('selected'));
                    lastSelectedDate = this.value;
                }
                loadBookedSlots();
            }
        });
    }
});
</script>
@endsection