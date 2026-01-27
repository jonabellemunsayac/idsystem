@extends('layouts.app')

@section('title', 'Edit Resident')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-2">
    <h1 class="h6 fw-bold text-dark mb-0" style="font-size: 0.9rem;">Edit Resident</h1>
    <a href="{{ route('residents.index') }}" class="btn btn-success btn-sm d-flex align-items-center gap-1" style="background-color: #198754; border-color: #198754; padding: 0.3rem 0.6rem; font-size: 0.75rem;">
        <i class="bi bi-arrow-left"></i> Back
    </a>
</div>

            <form action="{{ route('residents.update', $resident['id']) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Personal Information -->
                <h6 class="fw-bold text-dark mt-2 mb-1" style="font-size: 0.8rem;">Personal Information</h6>
                <div class="row g-2 mb-2">
                    <div class="col-md-4">
                        <label for="first_name" class="form-label required-field" style="font-size: 0.65rem;">First Name</label>
                        <input type="text" class="form-control form-control-sm @error('first_name') is-invalid @enderror" id="first_name" name="first_name" value="{{ old('first_name', $resident['first_name']) }}" required style="font-size: 0.8rem;">
                        @error('first_name') <div class="invalid-feedback" style="font-size: 0.65rem;">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="middle_name" class="form-label" style="font-size: 0.65rem;">Middle Name</label>
                        <input type="text" class="form-control form-control-sm @error('middle_name') is-invalid @enderror" id="middle_name" name="middle_name" value="{{ old('middle_name', $resident['middle_name']) }}" style="font-size: 0.8rem;">
                        @error('middle_name') <div class="invalid-feedback" style="font-size: 0.65rem;">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="last_name" class="form-label required-field" style="font-size: 0.65rem;">Last Name</label>
                        <input type="text" class="form-control form-control-sm @error('last_name') is-invalid @enderror" id="last_name" name="last_name" value="{{ old('last_name', $resident['last_name']) }}" required style="font-size: 0.8rem;">
                        @error('last_name') <div class="invalid-feedback" style="font-size: 0.65rem;">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="birth_date" class="form-label required-field" style="font-size: 0.65rem;">Birth Date</label>
                        <input type="date" class="form-control form-control-sm @error('birth_date') is-invalid @enderror" id="birth_date" name="birth_date" value="{{ old('birth_date', $resident['birth_date']) }}" required style="font-size: 0.8rem;">
                        @error('birth_date') <div class="invalid-feedback" style="font-size: 0.65rem;">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="gender" class="form-label required-field" style="font-size: 0.65rem;">Gender</label>
                        <select class="form-select form-select-sm @error('gender') is-invalid @enderror" id="gender" name="gender" required style="font-size: 0.8rem;">
                            <option value="">Select Gender</option>
                            <option value="Male" @selected(old('gender', $resident['gender']) == 'Male')>Male</option>
                            <option value="Female" @selected(old('gender', $resident['gender']) == 'Female')>Female</option>
                        </select>
                        @error('gender') <div class="invalid-feedback" style="font-size: 0.65rem;">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="civil_status" class="form-label required-field" style="font-size: 0.65rem;">Civil Status</label>
                        <select class="form-select form-select-sm @error('civil_status') is-invalid @enderror" id="civil_status" name="civil_status" required style="font-size: 0.8rem;">
                            <option value="">Select Civil Status</option>
                            <option value="Single" @selected(old('civil_status', $resident['civil_status']) == 'Single')>Single</option>
                            <option value="Married" @selected(old('civil_status', $resident['civil_status']) == 'Married')>Married</option>
                            <option value="Divorced" @selected(old('civil_status', $resident['civil_status']) == 'Divorced')>Divorced</option>
                            <option value="Widowed" @selected(old('civil_status', $resident['civil_status']) == 'Widowed')>Widowed</option>
                        </select>
                        @error('civil_status') <div class="invalid-feedback" style="font-size: 0.65rem;">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Nationality</label>
                        <select class="form-select form-select-sm" name="nationality" style="font-size: 0.8rem;">
                            <option value="Filipino" {{ old('nationality', $resident['nationality']) === 'Filipino' ? 'selected' : '' }}>Filipino</option>
                            <option value="Other" {{ old('nationality', $resident['nationality']) === 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="blood_type" class="form-label" style="font-size: 0.65rem;">Blood Type</label>
                        <select class="form-select form-select-sm @error('blood_type') is-invalid @enderror" id="blood_type" name="blood_type" style="font-size: 0.8rem;">
                            <option value="">Select Blood Type</option>
                            <option value="O+" @selected(old('blood_type', $resident['blood_type']) == 'O+')>O+</option>
                            <option value="O-" @selected(old('blood_type', $resident['blood_type']) == 'O-')>O-</option>
                            <option value="A+" @selected(old('blood_type', $resident['blood_type']) == 'A+')>A+</option>
                            <option value="A-" @selected(old('blood_type', $resident['blood_type']) == 'A-')>A-</option>
                            <option value="B+" @selected(old('blood_type', $resident['blood_type']) == 'B+')>B+</option>
                            <option value="B-" @selected(old('blood_type', $resident['blood_type']) == 'B-')>B-</option>
                            <option value="AB+" @selected(old('blood_type', $resident['blood_type']) == 'AB+')>AB+</option>
                            <option value="AB-" @selected(old('blood_type', $resident['blood_type']) == 'AB-')>AB-</option>
                        </select>
                        @error('blood_type') <div class="invalid-feedback" style="font-size: 0.65rem;">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Special Sector</label>
                        <select class="form-select form-select-sm" name="special_sector" style="font-size: 0.8rem;">
                            <option value="" {{ old('special_sector', $resident['special_sector']) === '' ? 'selected' : '' }}>Select...</option>
                            <option value="None" {{ old('special_sector', $resident['special_sector']) === 'None' ? 'selected' : '' }}>None</option>
                            <option value="Senior Citizen" {{ old('special_sector', $resident['special_sector']) === 'Senior Citizen' ? 'selected' : '' }}>Senior Citizen</option>
                            <option value="PWD" {{ old('special_sector', $resident['special_sector']) === 'PWD' ? 'selected' : '' }}>PWD</option>
                            <option value="Solo Parent" {{ old('special_sector', $resident['special_sector']) === 'Solo Parent' ? 'selected' : '' }}>Solo Parent</option>
                            <option value="LGBTQ" {{ old('special_sector', $resident['special_sector']) === 'LGBTQ' ? 'selected' : '' }}>LGBTQ</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <div class="form-check mt-4">
                            <input class="form-check-input" type="checkbox" name="is_head_of_family" id="is_head_of_family" value="1" @checked(old('is_head_of_family', $resident['is_head_of_family'] ?? false)) style="font-size: 0.8rem;">
                            <label class="form-check-label text-muted small fw-bold" for="is_head_of_family" style="font-size: 0.65rem;">Head of Family</label>
                            <small class="text-muted d-block mt-1" style="font-size: 0.65rem;">Check if this person is the head of the family</small>
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <h6 class="fw-bold mb-2 mt-2" style="font-size: 0.8rem;">Contact Information</h6>
                <div class="row g-2 mb-2">
                    <div class="col-md-6">
                        <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Mobile Number</label>
                        <input type="text" class="form-control form-control-sm mobile-number @error('contact_number') is-invalid @enderror" name="contact_number" value="{{ old('contact_number', $resident['contact_number']) }}" placeholder="e.g., 09123456789" inputmode="numeric" maxlength="11" pattern="[0-9]{11}" style="font-size: 0.8rem;">
                        <small class="text-muted d-block mt-1" style="font-size: 0.65rem;">Must be exactly 11 digits</small>
                        @error('contact_number')<div class="text-danger small" style="font-size: 0.65rem;">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Telephone No</label>
                        <input type="text" class="form-control form-control-sm telephone-number" name="telephone_no" value="{{ old('telephone_no', $resident['telephone_no']) }}" placeholder="Optional" style="font-size: 0.8rem;">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Email</label>
                        <input type="email" class="form-control form-control-sm @error('email') is-invalid @enderror" name="email" value="{{ old('email', $resident['email']) }}" placeholder="Optional" style="font-size: 0.8rem;">
                        @error('email')<div class="text-danger small" style="font-size: 0.65rem;">{{ $message }}</div>@enderror
                    </div>
                </div>

                <h6 class="fw-bold mb-2 mt-2" style="font-size: 0.8rem;">Address</h6>
                <div class="row g-2 mb-2">
                    <div class="col-md-6">
                        <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Street Name</label>
                        <select class="form-select form-select-sm address-field" name="street_name" style="font-size: 0.8rem;">
                            <option value="" {{ old('street_name', $resident['street_name']) === '' ? 'selected' : '' }}>Select Street...</option>
                            <option value="Roxas St." {{ old('street_name', $resident['street_name']) === 'Roxas St.' ? 'selected' : '' }}>Roxas St.</option>
                            <option value="Osmena St." {{ old('street_name', $resident['street_name']) === 'Osmena St.' ? 'selected' : '' }}>Osmena St.</option>
                            <option value="Del Pilar St." {{ old('street_name', $resident['street_name']) === 'Del Pilar St.' ? 'selected' : '' }}>Del Pilar St.</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Province</label>
                        <select class="form-select form-select-sm address-field" name="province" style="font-size: 0.8rem;">
                            <option value="Metro Manila" {{ old('province', $resident['province']) === 'Metro Manila' ? 'selected' : '' }}>Metro Manila</option>
                        </select>
                        <small class="text-muted d-block mt-1" style="font-size: 0.65rem;">Fixed to Metro Manila</small>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Zip Code</label>
                        <input type="text" class="form-control form-control-sm address-field" name="zip_code" value="1600" readonly style="font-size: 0.8rem;">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Full Address</label>
                        <textarea class="form-control form-control-sm" id="full_address_display" rows="2" readonly style="font-size: 0.8rem; background-color: #f8f9fa;"></textarea>
                        <small class="text-muted d-block mt-1" style="font-size: 0.65rem;">Auto-filled from street name and province above</small>
                    </div>
                </div>

                <!-- Emergency Contact -->
                <h6 class="fw-bold mb-2 mt-2" style="font-size: 0.8rem;">Emergency Contact</h6>
                <div class="row g-2 mb-2">
                    <div class="col-md-6">
                        <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Name</label>
                        <input type="text" class="form-control form-control-sm" name="emergency_contact_name" value="{{ old('emergency_contact_name', $resident['emergency_contact_name']) }}" style="font-size: 0.8rem;">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Relationship</label>
                        <select class="form-select form-select-sm" name="emergency_contact_relationship" style="font-size: 0.8rem;">
                            <option value="" {{ old('emergency_contact_relationship', $resident['emergency_contact_relationship']) === '' ? 'selected' : '' }}>Select...</option>
                            <option value="Mother" {{ old('emergency_contact_relationship', $resident['emergency_contact_relationship']) === 'Mother' ? 'selected' : '' }}>Mother</option>
                            <option value="Father" {{ old('emergency_contact_relationship', $resident['emergency_contact_relationship']) === 'Father' ? 'selected' : '' }}>Father</option>
                            <option value="Sibling" {{ old('emergency_contact_relationship', $resident['emergency_contact_relationship']) === 'Sibling' ? 'selected' : '' }}>Sibling</option>
                            <option value="Grandparent" {{ old('emergency_contact_relationship', $resident['emergency_contact_relationship']) === 'Grandparent' ? 'selected' : '' }}>Grandparent</option>
                            <option value="Cousin" {{ old('emergency_contact_relationship', $resident['emergency_contact_relationship']) === 'Cousin' ? 'selected' : '' }}>Cousin</option>
                            <option value="Other" {{ old('emergency_contact_relationship', $resident['emergency_contact_relationship']) === 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Contact Number</label>
                        <input type="text" class="form-control form-control-sm mobile-number" name="emergency_contact_no" value="{{ old('emergency_contact_no', $resident['emergency_contact_no']) }}" placeholder="e.g., 09123456789" inputmode="numeric" maxlength="11" pattern="[0-9]{11}" style="font-size: 0.8rem;">
                        <small class="text-muted d-block mt-1" style="font-size: 0.65rem;">Must be exactly 11 digits</small>
                    </div>
                    <div class="col-md-12">
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="same_as_above_address" name="same_as_above_address" {{ old('same_as_above_address') ? 'checked' : '' }}>
                            <label class="form-check-label text-muted" for="same_as_above_address" style="font-size: 0.75rem;">
                                Same as above (use main address)
                            </label>
                        </div>
                        <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Address</label>
                        <textarea class="form-control form-control-sm" id="emergency_address_display" name="emergency_contact_address" rows="2" style="font-size: 0.8rem;">{{ old('emergency_contact_address', $resident['emergency_contact_address']) }}</textarea>
                    </div>
                </div>

                <!-- Profile Image & Signature -->
                <h6 class="fw-bold text-dark mt-2 mb-1" style="font-size: 0.8rem;">Profile Image & Signature</h6>
                <div class="row g-2 mb-2">
                    <!-- Profile Image (Left) -->
                    <div class="col-md-6">
                        <div class="card border-light bg-light h-100">
                            <div class="card-body p-2">
                                <h6 class="fw-bold mb-2" style="font-size: 0.75rem;">Profile Image</h6>
                                @if($resident['profile_image'])
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $resident['profile_image']) }}" alt="Current Profile Image" class="img-thumbnail" style="max-height: 150px; max-width: 150px;">
                                    </div>
                                @endif
                                <label for="profile_image" class="form-label" style="font-size: 0.65rem;">Update Photo</label>
                                <input type="file" class="form-control form-control-sm @error('profile_image') is-invalid @enderror" id="profile_image" name="profile_image" accept="image/*" style="font-size: 0.8rem;">
                                <div class="form-text" style="font-size: 0.6rem;">Supported formats: JPEG, PNG, JPG. Max size: 2MB.</div>
                                @error('profile_image') <div class="invalid-feedback" style="font-size: 0.65rem;">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Signature (Right) -->
                    <div class="col-md-6">
                        <div class="card border-light bg-light h-100">
                            <div class="card-body p-2">
                                <h6 class="fw-bold mb-2" style="font-size: 0.75rem;">Signature</h6>
                                <div id="signature-section">
                                    <div class="d-flex gap-1 flex-wrap mb-2">
                                        <button type="button" class="btn btn-outline-primary btn-sm" id="upload-signature-btn" style="font-size: 0.75rem; padding: 0.3rem 0.6rem;">
                                            <i class="bi bi-cloud-upload"></i> Upload
                                        </button>
                                        <button type="button" class="btn btn-outline-info btn-sm" id="draw-signature-large-btn" style="font-size: 0.75rem; padding: 0.3rem 0.6rem;">
                                            <i class="bi bi-pencil"></i> Draw
                                        </button>
                                    </div>
                                    <input type="file" id="signature-file-input" name="signature" accept="image/*" style="display: none;">
                                    <input type="hidden" id="signature-base64" name="signature_base64" value="">
                                    
                                    @if($resident['signature'])
                                        <div id="signature-preview" class="mt-2">
                                            <p class="mb-1" style="font-size: 0.65rem; color: #6c757d;">Current Signature:</p>
                                            <img id="preview-signature" src="{{ asset('storage/' . $resident['signature']) }}" alt="Signature Preview" style="max-width: 200px; max-height: 100px; border: 2px solid #dee2e6; border-radius: 4px; background: transparent; padding: 5px;">
                                            <div class="mt-1">
                                                <button type="button" class="btn btn-sm btn-danger" id="remove-signature-btn" style="font-size: 0.7rem; padding: 0.2rem 0.4rem;">
                                                    <i class="bi bi-trash"></i> Remove
                                                </button>
                                            </div>
                                        </div>
                                    @else
                                        <div id="signature-preview" style="display: none;" class="mt-2">
                                            <img id="preview-signature" src="" alt="Signature Preview" style="max-width: 200px; max-height: 100px; border: 2px solid #dee2e6; border-radius: 4px; background: transparent; padding: 5px;">
                                            <div class="mt-1">
                                                <button type="button" class="btn btn-sm btn-danger" id="remove-signature-btn" style="font-size: 0.7rem; padding: 0.2rem 0.4rem;">
                                                    <i class="bi bi-trash"></i> Remove
                                                </button>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                @if ($errors->has('signature'))
                                    <div class="alert alert-danger mt-1 mb-0" style="font-size: 0.75rem; padding: 0.4rem 0.6rem;">{{ $errors->first('signature') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-1 mt-2 pt-2 border-top">
                    <a href="{{ route('residents.index') }}" class="btn btn-secondary btn-sm" style="font-size: 0.75rem; padding: 0.3rem 0.6rem;">Cancel</a>
                    <button type="submit" class="btn btn-primary btn-sm" style="font-size: 0.75rem; padding: 0.3rem 0.6rem;">
                        <i class="bi bi-check me-1"></i> Save
                    </button>
                </div>
            </form>
<div class="card border-0 shadow-sm">
    <div class="card-body p-2">
<div class="modal fade" id="signatureLargeModal" tabindex="-1" aria-labelledby="signatureLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="signatureLargeModalLabel">Draw Signature</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <div style="border: 2px solid #dee2e6; border-radius: 4px; background: transparent; overflow: hidden; display: inline-block;">
                        <canvas id="signature-canvas-large" width="800" height="400" style="display: block; cursor: crosshair; background: transparent;"></canvas>
                    </div>
                    <p class="text-muted mt-2 mb-0" style="font-size: 0.85rem;">
                        <i class="bi bi-info-circle"></i> Draw your signature using your mouse or touch screen
                    </p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" id="clear-signature-large-btn">
                    <i class="bi bi-arrow-counterclockwise"></i> Clear
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg"></i> Cancel
                </button>
                <button type="button" class="btn btn-success" id="save-signature-large-btn">
                    <i class="bi bi-check-lg"></i> Save Signature
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-select Senior Citizen for birthdate >= 60 years old
    const birthDateInput = document.querySelector('input[name="birth_date"]');
    const specialSectorSelect = document.querySelector('select[name="special_sector"]');
    
    function calculateAge(birthDate) {
        const today = new Date();
        let age = today.getFullYear() - birthDate.getFullYear();
        const monthDifference = today.getMonth() - birthDate.getMonth();
        
        if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        return age;
    }
    
    function checkAndSetSeniorCitizen() {
        if (birthDateInput.value) {
            const birthDate = new Date(birthDateInput.value);
            const age = calculateAge(birthDate);
            
            if (age >= 60) {
                specialSectorSelect.value = 'Senior Citizen';
            }
        }
    }
    
    birthDateInput.addEventListener('change', checkAndSetSeniorCitizen);
    
    // Auto-fill full address from address components
    const addressFields = document.querySelectorAll('.address-field');
    const fullAddressDisplay = document.getElementById('full_address_display');
    
    function updateFullAddress() {
        const streetName = document.querySelector('select[name="street_name"]').value;
        const province = document.querySelector('select[name="province"]').value;
        
        const addressParts = [];
        if (streetName) addressParts.push(streetName);
        if (province) addressParts.push(province);
        
        fullAddressDisplay.value = addressParts.join(', ') || '';
    }
    
    addressFields.forEach(field => {
        field.addEventListener('change', updateFullAddress);
        field.addEventListener('input', updateFullAddress);
    });
    
    // Initialize on page load
    updateFullAddress();
    
    // Handle "Same as above" checkbox for emergency contact address
    const sameAsAboveCheckbox = document.getElementById('same_as_above_address');
    const emergencyAddressDisplay = document.getElementById('emergency_address_display');
    
    if (sameAsAboveCheckbox) {
        sameAsAboveCheckbox.addEventListener('change', function() {
            if (this.checked) {
                emergencyAddressDisplay.value = fullAddressDisplay.value;
                emergencyAddressDisplay.readOnly = true;
                emergencyAddressDisplay.style.backgroundColor = '#f8f9fa';
                emergencyAddressDisplay.style.cursor = 'default';
            } else {
                emergencyAddressDisplay.value = '';
                emergencyAddressDisplay.readOnly = false;
                emergencyAddressDisplay.style.backgroundColor = 'white';
                emergencyAddressDisplay.style.cursor = 'auto';
            }
        });
    }
    
    // Ensure emergency_contact_address is populated on form submit if checkbox is checked
    document.querySelector('form').addEventListener('submit', function() {
        if (sameAsAboveCheckbox && sameAsAboveCheckbox.checked) {
            emergencyAddressDisplay.value = fullAddressDisplay.value;
        }
    });
    
    // Mobile number validation - only numbers and 11 digits
    document.querySelectorAll('.mobile-number').forEach(field => {
        field.addEventListener('input', function(e) {
            // Remove any non-numeric characters
            this.value = this.value.replace(/[^0-9]/g, '');
            
            // Limit to 11 digits
            if (this.value.length > 11) {
                this.value = this.value.slice(0, 11);
            }
        });
        
        field.addEventListener('blur', function() {
            // Validate on blur
            if (this.value && this.value.length !== 11) {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        });
        
        field.addEventListener('focus', function() {
            this.classList.remove('is-invalid');
        });
    });

    // Telephone number validation - only numbers
    document.querySelectorAll('.telephone-number').forEach(field => {
        field.addEventListener('input', function(e) {
            // Remove any non-numeric characters
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    });

    // Signature functionality
    const uploadSignatureBtn = document.getElementById('upload-signature-btn');
    const signatureFileInput = document.getElementById('signature-file-input');
    const signaturePreview = document.getElementById('signature-preview');
    const previewSignature = document.getElementById('preview-signature');
    const removeSignatureBtn = document.getElementById('remove-signature-btn');
    
    // Upload signature functionality
    uploadSignatureBtn.addEventListener('click', function() {
        signatureFileInput.click();
    });
    
    signatureFileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewSignature.src = e.target.result;
                signaturePreview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });
    
    removeSignatureBtn.addEventListener('click', function() {
        signatureFileInput.value = '';
        previewSignature.src = '';
        signaturePreview.style.display = 'none';
        document.getElementById('signature-base64').value = '';
    });
    
    // Large Canvas Modal Functionality
    const drawSignatureLargeBtn = document.getElementById('draw-signature-large-btn');
    const signatureLargeModal = new bootstrap.Modal(document.getElementById('signatureLargeModal'));
    const signatureCanvasLarge = document.getElementById('signature-canvas-large');
    const saveSignatureLargeBtn = document.getElementById('save-signature-large-btn');
    const clearSignatureLargeBtn = document.getElementById('clear-signature-large-btn');
    
    let isDrawingLarge = false;
    let ctxLarge = signatureCanvasLarge.getContext('2d');
    
    // Initialize large canvas
    ctxLarge.clearRect(0, 0, signatureCanvasLarge.width, signatureCanvasLarge.height);
    
    // Open large canvas modal
    drawSignatureLargeBtn.addEventListener('click', function() {
        signatureLargeModal.show();
        ctxLarge.clearRect(0, 0, signatureCanvasLarge.width, signatureCanvasLarge.height);
    });
    
    // Mouse events for large canvas
    signatureCanvasLarge.addEventListener('mousedown', function(e) {
        isDrawingLarge = true;
        const rect = signatureCanvasLarge.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        ctxLarge.beginPath();
        ctxLarge.moveTo(x, y);
    });
    
    signatureCanvasLarge.addEventListener('mousemove', function(e) {
        if (!isDrawingLarge) return;
        const rect = signatureCanvasLarge.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        ctxLarge.lineTo(x, y);
        ctxLarge.strokeStyle = '#000000';
        ctxLarge.lineWidth = 2;
        ctxLarge.lineCap = 'round';
        ctxLarge.lineJoin = 'round';
        ctxLarge.stroke();
    });
    
    signatureCanvasLarge.addEventListener('mouseup', function() {
        isDrawingLarge = false;
    });
    
    signatureCanvasLarge.addEventListener('mouseleave', function() {
        isDrawingLarge = false;
    });
    
    // Touch events for large canvas (mobile)
    signatureCanvasLarge.addEventListener('touchstart', function(e) {
        e.preventDefault();
        isDrawingLarge = true;
        const rect = signatureCanvasLarge.getBoundingClientRect();
        const touch = e.touches[0];
        const x = touch.clientX - rect.left;
        const y = touch.clientY - rect.top;
        ctxLarge.beginPath();
        ctxLarge.moveTo(x, y);
    });
    
    signatureCanvasLarge.addEventListener('touchmove', function(e) {
        e.preventDefault();
        if (!isDrawingLarge) return;
        const rect = signatureCanvasLarge.getBoundingClientRect();
        const touch = e.touches[0];
        const x = touch.clientX - rect.left;
        const y = touch.clientY - rect.top;
        ctxLarge.lineTo(x, y);
        ctxLarge.strokeStyle = '#000000';
        ctxLarge.lineWidth = 2;
        ctxLarge.lineCap = 'round';
        ctxLarge.lineJoin = 'round';
        ctxLarge.stroke();
    });
    
    signatureCanvasLarge.addEventListener('touchend', function(e) {
        e.preventDefault();
        isDrawingLarge = false;
    });
    
    // Clear large canvas
    clearSignatureLargeBtn.addEventListener('click', function() {
        ctxLarge.clearRect(0, 0, signatureCanvasLarge.width, signatureCanvasLarge.height);
    });
    
    // Save large canvas signature
    saveSignatureLargeBtn.addEventListener('click', function() {
        const dataURL = signatureCanvasLarge.toDataURL('image/png');
        previewSignature.src = dataURL;
        previewSignature.style.background = 'transparent';
        
        // Store base64 in hidden input for form submission
        document.getElementById('signature-base64').value = dataURL;
        
        signaturePreview.style.display = 'block';
        
        // Close modal
        signatureLargeModal.hide();
    });
});</script>
@endsection
