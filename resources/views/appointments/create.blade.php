@extends('layouts.app')

@section('title', 'Schedule New Appointment')

@section('extra-styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .step-indicator {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 2rem;
        max-width: 500px;
        margin-left: auto;
        margin-right: auto;
        flex-wrap: wrap;
        gap: 0.5rem;
    }
    
    .step-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.875rem;
        font-weight: 600;
        background-color: #e5e7eb;
        color: #6b7280;
        transition: all 0.3s;
    }
    
    .step-circle.active {
        background-color: #0038A8;
        color: white;
        box-shadow: 0 2px 8px rgba(0, 56, 168, 0.3);
    }
    
    .step-circle.completed {
        background-color: #10b981;
        color: white;
    }
    
    .step-line {
        width: 40px;
        height: 3px;
        background-color: #e5e7eb;
        transition: all 0.3s;
    }
    
    .step-line.active {
        background-color: #0038A8;
    }
    
    .form-step {
        display: none;
        animation: fadeIn 0.3s ease-in;
    }
    
    .form-step.active {
        display: block;
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }
    
    .time-slot-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(80px, 1fr));
        gap: 0.5rem;
        margin-bottom: 1rem;
    }
    
    .time-slot-btn {
        padding: 0.5rem;
        text-align: center;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        background: white;
        cursor: pointer;
        font-size: 0.75rem;
        font-weight: 500;
        transition: all 0.2s;
        color: #374151;
    }
    
    .time-slot-btn:hover:not(:disabled) {
        background-color: #f3f4f6;
        border-color: #9ca3af;
    }
    
    .time-slot-btn.selected {
        background-color: #0038A8;
        color: white;
        border-color: #0038A8;
        box-shadow: 0 2px 4px rgba(0, 56, 168, 0.2);
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
    
    .review-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .review-item:last-child {
        border-bottom: none;
    }
    
    .review-label {
        color: #6b7280;
        font-size: 0.875rem;
    }
    
    .review-value {
        font-weight: 600;
        color: #1f2937;
    }
    
    .btn-action {
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
    }
    
    .select2-container--default .select2-selection--single {
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        height: 38px;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 36px;
        color: #374151;
    }
    
    .select2-container--default.select2-container--focus .select2-selection--single {
        border-color: #0038A8;
        box-shadow: 0 0 0 3px rgba(0, 56, 168, 0.1);
    }
    
    @media (max-width: 768px) {
        .step-indicator {
            gap: 0.25rem;
        }
        
        .step-circle {
            width: 32px;
            height: 32px;
            font-size: 0.75rem;
        }
        
        .step-line {
            width: 20px;
        }
        
        .time-slot-grid {
            grid-template-columns: repeat(auto-fit, minmax(70px, 1fr));
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <div class="mb-4">
                <a href="{{ route('appointments.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Back
                </a>
            </div>

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

            <!-- Error Alert -->
            <div id="error-alert" class="alert alert-danger d-none mb-3" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i>
                <span id="error-message"></span>
            </div>

            <!-- Step 1: Select Resident -->
            <div class="card form-step active" id="step-1">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 fw-bold">Select Resident</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="resident_id" class="form-label fw-bold">Resident <span class="text-danger">*</span></label>
                        <select class="form-select select2" id="resident_id" required>
                            <option value="">-- Search and Select Resident --</option>
                            @foreach($residents as $resident)
                                <option value="{{ $resident['id'] }}">
                                    {{ $resident['first_name'] }} {{ $resident['last_name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-secondary flex-fill btn-action" onclick="window.location.href='{{ route('appointments.index') }}'">Cancel</button>
                        <button type="button" class="btn btn-primary flex-fill btn-action" onclick="goToStep(2)">Next</button>
                    </div>
                </div>
            </div>

            <!-- Step 2: Service Type & Date/Time -->
            <div class="card form-step" id="step-2">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 fw-bold">Service & Schedule</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="service_type" class="form-label fw-bold">Service Type <span class="text-danger">*</span></label>
                        <select class="form-select" id="service_type" required>
                            <option value="">-- Select a Service --</option>
                            <option value="Barangay Clearance">Barangay Clearance</option>
                            <option value="Certificate of Indigency">Certificate of Indigency</option>
                            <option value="Certificate of Residency">Certificate of Residency</option>
                            <option value="Business Permit">Business Permit</option>
                            <option value="Community Tax Certificate">Community Tax Certificate</option>
                            <option value="Other Services">Other Services</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="appointment_date" class="form-label fw-bold">Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="appointment_date" required>
                        <small class="text-muted">Select a future date</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Time Slot <span class="text-danger">*</span></label>
                        <div class="time-slot-grid" id="timeSlots">
                            <button type="button" class="time-slot-btn" data-time="09:00" onclick="selectTime('09:00')">9:00 AM</button>
                            <button type="button" class="time-slot-btn" data-time="10:00" onclick="selectTime('10:00')">10:00 AM</button>
                            <button type="button" class="time-slot-btn" data-time="11:00" onclick="selectTime('11:00')">11:00 AM</button>
                            <button type="button" class="time-slot-btn" data-time="13:00" onclick="selectTime('13:00')">1:00 PM</button>
                            <button type="button" class="time-slot-btn" data-time="14:00" onclick="selectTime('14:00')">2:00 PM</button>
                            <button type="button" class="time-slot-btn" data-time="15:00" onclick="selectTime('15:00')">3:00 PM</button>
                            <button type="button" class="time-slot-btn" data-time="16:00" onclick="selectTime('16:00')">4:00 PM</button>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-secondary flex-fill btn-action" onclick="goToStep(1)">Back</button>
                        <button type="button" class="btn btn-primary flex-fill btn-action" onclick="goToStep(3)">Next</button>
                    </div>
                </div>
            </div>

            <!-- Step 3: Status & Notes -->
            <div class="card form-step" id="step-3">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 fw-bold">Status & Notes</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="status" class="form-label fw-bold">Status <span class="text-danger">*</span></label>
                        <select class="form-select" id="status" required>
                            <option value="pending" selected>Pending</option>
                            <option value="confirmed">Confirmed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label fw-bold">Additional Notes</label>
                        <textarea class="form-control" id="notes" rows="3" placeholder="Any special requirements or notes..."></textarea>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-secondary flex-fill btn-action" onclick="goToStep(2)">Back</button>
                        <button type="button" class="btn btn-primary flex-fill btn-action" onclick="goToStep(4)">Review</button>
                    </div>
                </div>
            </div>

            <!-- Step 4: Review & Confirm -->
            <div class="card form-step" id="step-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 fw-bold">Review Appointment</h5>
                </div>
                <div class="card-body">
                    <div class="review-item">
                        <span class="review-label">Resident</span>
                        <span class="review-value" id="review-resident">-</span>
                    </div>
                    <div class="review-item">
                        <span class="review-label">Service Type</span>
                        <span class="review-value" id="review-service">-</span>
                    </div>
                    <div class="review-item">
                        <span class="review-label">Date & Time</span>
                        <span class="review-value" id="review-datetime">-</span>
                    </div>
                    <div class="review-item">
                        <span class="review-label">Status</span>
                        <span class="review-value" id="review-status">-</span>
                    </div>
                    <div class="review-item">
                        <span class="review-label">Notes</span>
                        <span class="review-value" id="review-notes" style="max-width: 300px; text-align: right;">-</span>
                    </div>
                    <div class="d-flex gap-2 mt-4">
                        <button type="button" class="btn btn-outline-secondary flex-fill btn-action" onclick="goToStep(3)">Back</button>
                        <button type="button" class="btn btn-success flex-fill btn-action" onclick="submitAppointment()">
                            <i class="bi bi-check-circle me-1"></i>Confirm
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Hidden Form for Submission -->
<form id="appointmentForm" action="{{ route('appointments.store') }}" method="POST" style="display: none;">
    @csrf
    <input type="hidden" id="hidden_resident_id" name="resident_id">
    <input type="hidden" id="hidden_service_type" name="service_type">
    <input type="hidden" id="hidden_appointment_date" name="appointment_date">
    <input type="hidden" id="hidden_status" name="status">
    <input type="hidden" id="hidden_notes" name="notes">
</form>

<script>
let currentStep = 1;
let selectedTime = '';
const residents = @json($residents);

function showError(message) {
    const errorAlert = document.getElementById('error-alert');
    document.getElementById('error-message').textContent = message;
    errorAlert.classList.remove('d-none');
    window.scrollTo(0, 0);
}

function hideError() {
    document.getElementById('error-alert').classList.add('d-none');
}

function goToStep(step) {
    // Validation
    if (step === 2 && !document.getElementById('resident_id').value) {
        showError('Please select a resident');
        return;
    }
    
    if (step === 3 && (!document.getElementById('service_type').value || !document.getElementById('appointment_date').value || !selectedTime)) {
        showError('Please fill in service type, date, and select a time slot');
        return;
    }
    
    if (step === 4 && !document.getElementById('status').value) {
        showError('Please select a status');
        return;
    }
    
    hideError();
    
    // Hide all steps
    document.querySelectorAll('.form-step').forEach(s => s.classList.remove('active'));
    document.getElementById('step-' + step).classList.add('active');
    
    // Update step circles
    for (let i = 1; i <= 4; i++) {
        const circle = document.getElementById('step-circle-' + i);
        const line = document.getElementById('step-line-' + i);
        
        if (i < step) {
            circle.classList.add('completed');
            circle.classList.remove('active');
            if (line) line.classList.add('active');
        } else if (i === step) {
            circle.classList.add('active');
            circle.classList.remove('completed');
        } else {
            circle.classList.remove('active', 'completed');
            if (line) line.classList.remove('active');
        }
    }
    
    // Update review if on step 4
    if (step === 4) {
        updateReview();
    }
    
    currentStep = step;
    window.scrollTo(0, 0);
}

function selectTime(time) {
    const btn = event.target;
    if (btn.disabled) {
        showError('This time slot is already booked.');
        return;
    }
    
    document.querySelectorAll('.time-slot-btn').forEach(b => b.classList.remove('selected'));
    btn.classList.add('selected');
    selectedTime = time;
    
    // Check slot availability after time is selected
    checkTimeSlotAvailability();
}

function loadBookedSlots() {
    const dateInput = document.getElementById('appointment_date').value;
    
    if (!dateInput) {
        return;
    }
    
    console.log('Loading booked slots for date:', dateInput);
    
    // Reset all buttons to enabled state
    document.querySelectorAll('.time-slot-btn').forEach(btn => {
        btn.disabled = false;
        btn.classList.remove('selected');
    });
    
    selectedTime = '';
    
    // Fetch booked slots for this date
    fetch(`/appointments/booked-slots/${dateInput}`, {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
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

function updateReview() {
    const residentId = parseInt(document.getElementById('resident_id').value);
    const resident = residents.find(r => r.id == residentId);
    
    document.getElementById('review-resident').textContent = resident ? 
        `${resident.first_name} ${resident.last_name}` : '-';
    document.getElementById('review-service').textContent = 
        document.getElementById('service_type').value || '-';
    
    const date = new Date(document.getElementById('appointment_date').value);
    const dateStr = date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
    document.getElementById('review-datetime').textContent = 
        `${dateStr} at ${selectedTime || '-'}`;
    document.getElementById('review-status').textContent = 
        document.getElementById('status').options[document.getElementById('status').selectedIndex].text;
    document.getElementById('review-notes').textContent = 
        document.getElementById('notes').value || 'None';
}

function submitAppointment() {
    const form = document.getElementById('appointmentForm');
    document.getElementById('hidden_resident_id').value = document.getElementById('resident_id').value;
    document.getElementById('hidden_service_type').value = document.getElementById('service_type').value;
    
    const dateInput = document.getElementById('appointment_date').value;
    const timeInput = selectedTime;
    const dateTime = `${dateInput}T${timeInput}`;
    document.getElementById('hidden_appointment_date').value = dateTime;
    document.getElementById('hidden_status').value = document.getElementById('status').value;
    
    // Final check before submission
    checkTimeSlotAvailability(() => {
        form.submit();
    });
}

function checkTimeSlotAvailability(callback = null) {
    const dateInput = document.getElementById('appointment_date').value;
    const timeInput = selectedTime;
    
    if (!dateInput || !timeInput) {
        return;
    }
    
    const dateTime = `${dateInput}T${timeInput}`;
    
    fetch('{{ route("appointments.checkSlotAvailability") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: JSON.stringify({
            appointment_date: dateTime
        })
    })
    .then(response => response.json())
    .then(data => {
        if (!data.available) {
            showError('This time slot is already booked. Please select a different date or time.');
        } else {
            hideError();
            if (callback) callback();
        }
    })
    .catch(error => {
        console.error('Error checking slot availability:', error);
    });
}

document.addEventListener('DOMContentLoaded', function () {
    const appointmentDateInput = document.getElementById('appointment_date');
    if (!appointmentDateInput) return;

    const today = new Date();
    const year = today.getFullYear();
    const month = String(today.getMonth() + 1).padStart(2, '0');
    const day = String(today.getDate()).padStart(2, '0');
    const minDate = `${year}-${month}-${day}`;
    appointmentDateInput.setAttribute('min', minDate);

    appointmentDateInput.addEventListener('change', function() {
        if (!this.value) return;

        const selectedDate = new Date(this.value + 'T00:00:00');
        const todayStart = new Date();
        todayStart.setHours(0, 0, 0, 0);

        if (selectedDate < todayStart) {
            showError('Past dates are not available. Please select today or a future date.');
            this.value = '';
            return;
        }

        const selectedDay = selectedDate.getDay();
        if (selectedDay === 0 || selectedDay === 6) {
            showError('Weekends are not available. Please select a weekday.');
            this.value = '';
            return;
        }

        hideError();
        loadBookedSlots();
    });
});
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('#resident_id').select2({
        placeholder: '-- Search and Select Resident --',
        allowClear: true,
        width: '100%',
        language: {
            noResults: function() {
                return 'No residents found';
            }
        }
    });
});
</script>
@endsection
