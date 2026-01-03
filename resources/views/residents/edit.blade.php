@extends('layouts.app')

@section('title', 'Edit Resident')

@section('content')
<div class="mb-2">
    <a href="{{ route('residents.index') }}" class="btn btn-secondary btn-sm mb-2" style="font-size: 0.75rem; padding: 0.3rem 0.6rem;">
        <i class="bi bi-arrow-left me-1"></i> Back
    </a>
    <div class="card border-0 shadow-sm">
        <div class="card-body p-2">
            <div class="mb-2">
                <h6 class="fw-bold mb-0" style="font-size: 0.9rem;">Edit Resident</h6>
                <p class="text-muted mb-0" style="font-size: 0.7rem;">Update resident information</p>
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
                        <label for="nationality" class="form-label" style="font-size: 0.65rem;">Nationality</label>
                        <input type="text" class="form-control form-control-sm @error('nationality') is-invalid @enderror" id="nationality" name="nationality" value="{{ old('nationality', $resident['nationality']) }}" style="font-size: 0.8rem;">
                        @error('nationality') <div class="invalid-feedback" style="font-size: 0.65rem;">{{ $message }}</div> @enderror
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
                        <label for="special_sector" class="form-label" style="font-size: 0.65rem;">Special Sector</label>
                        <input type="text" class="form-control form-control-sm @error('special_sector') is-invalid @enderror" id="special_sector" name="special_sector" value="{{ old('special_sector', $resident['special_sector']) }}" style="font-size: 0.8rem;">
                        @error('special_sector') <div class="invalid-feedback" style="font-size: 0.65rem;">{{ $message }}</div> @enderror
                    </div>
                </div>

                <!-- Contact Information -->
                <h6 class="fw-bold text-dark mt-2 mb-1" style="font-size: 0.8rem;">Contact Information</h6>
                <div class="row g-2 mb-2">
                    <div class="col-md-4">
                        <label for="contact_number" class="form-label required-field" style="font-size: 0.65rem;">Mobile Number</label>
                        <input type="tel" class="form-control form-control-sm @error('contact_number') is-invalid @enderror" id="contact_number" name="contact_number" value="{{ old('contact_number', $resident['contact_number']) }}" required style="font-size: 0.8rem;">
                        @error('contact_number') <div class="invalid-feedback" style="font-size: 0.65rem;">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="telephone_no" class="form-label" style="font-size: 0.65rem;">Telephone Number</label>
                        <input type="tel" class="form-control form-control-sm @error('telephone_no') is-invalid @enderror" id="telephone_no" name="telephone_no" value="{{ old('telephone_no', $resident['telephone_no']) }}" style="font-size: 0.8rem;">
                        @error('telephone_no') <div class="invalid-feedback" style="font-size: 0.65rem;">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="email" class="form-label" style="font-size: 0.65rem;">Email Address</label>
                        <input type="email" class="form-control form-control-sm @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $resident['email']) }}" style="font-size: 0.8rem;">
                        @error('email') <div class="invalid-feedback" style="font-size: 0.65rem;">{{ $message }}</div> @enderror
                    </div>
                </div>

                <!-- Address Information -->
                <h6 class="fw-bold text-dark mt-2 mb-1" style="font-size: 0.8rem;">Address Information</h6>
                <div class="row g-2 mb-2">
                    <div class="col-md-4">
                        <label for="house_no" class="form-label" style="font-size: 0.65rem;">House Number</label>
                        <input type="text" class="form-control form-control-sm @error('house_no') is-invalid @enderror" id="house_no" name="house_no" value="{{ old('house_no', $resident['house_no']) }}" style="font-size: 0.8rem;">
                        @error('house_no') <div class="invalid-feedback" style="font-size: 0.65rem;">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="street_name" class="form-label" style="font-size: 0.65rem;">Street Name</label>
                        <input type="text" class="form-control form-control-sm @error('street_name') is-invalid @enderror" id="street_name" name="street_name" value="{{ old('street_name', $resident['street_name']) }}" style="font-size: 0.8rem;">
                        @error('street_name') <div class="invalid-feedback" style="font-size: 0.65rem;">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="purok" class="form-label" style="font-size: 0.65rem;">Purok</label>
                        <input type="text" class="form-control form-control-sm @error('purok') is-invalid @enderror" id="purok" name="purok" value="{{ old('purok', $resident['purok']) }}" style="font-size: 0.8rem;">
                        @error('purok') <div class="invalid-feedback" style="font-size: 0.65rem;">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="barangay" class="form-label" style="font-size: 0.65rem;">Barangay</label>
                        <input type="text" class="form-control form-control-sm @error('barangay') is-invalid @enderror" id="barangay" name="barangay" value="{{ old('barangay', $resident['barangay']) }}" style="font-size: 0.8rem;">
                        @error('barangay') <div class="invalid-feedback" style="font-size: 0.65rem;">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="province" class="form-label" style="font-size: 0.65rem;">Province</label>
                        <input type="text" class="form-control form-control-sm @error('province') is-invalid @enderror" id="province" name="province" value="{{ old('province', $resident['province']) }}" style="font-size: 0.8rem;">
                        @error('province') <div class="invalid-feedback" style="font-size: 0.65rem;">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="zip_code" class="form-label" style="font-size: 0.65rem;">ZIP Code</label>
                        <input type="text" class="form-control form-control-sm @error('zip_code') is-invalid @enderror" id="zip_code" name="zip_code" value="{{ old('zip_code', $resident['zip_code']) }}" style="font-size: 0.8rem;">
                        @error('zip_code') <div class="invalid-feedback" style="font-size: 0.65rem;">{{ $message }}</div> @enderror
                    </div>
                </div>

                <!-- Emergency Contact -->
                <h6 class="fw-bold text-dark mt-2 mb-1" style="font-size: 0.8rem;">Emergency Contact</h6>
                <div class="row g-2 mb-2">
                    <div class="col-md-6">
                        <label for="emergency_contact_name" class="form-label" style="font-size: 0.65rem;">Contact Name</label>
                        <input type="text" class="form-control form-control-sm @error('emergency_contact_name') is-invalid @enderror" id="emergency_contact_name" name="emergency_contact_name" value="{{ old('emergency_contact_name', $resident['emergency_contact_name']) }}" style="font-size: 0.8rem;">
                        @error('emergency_contact_name') <div class="invalid-feedback" style="font-size: 0.65rem;">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="emergency_contact_relationship" class="form-label" style="font-size: 0.65rem;">Relationship</label>
                        <input type="text" class="form-control form-control-sm @error('emergency_contact_relationship') is-invalid @enderror" id="emergency_contact_relationship" name="emergency_contact_relationship" value="{{ old('emergency_contact_relationship', $resident['emergency_contact_relationship']) }}" style="font-size: 0.8rem;">
                        @error('emergency_contact_relationship') <div class="invalid-feedback" style="font-size: 0.65rem;">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="emergency_contact_no" class="form-label" style="font-size: 0.65rem;">Contact Number</label>
                        <input type="tel" class="form-control form-control-sm @error('emergency_contact_no') is-invalid @enderror" id="emergency_contact_no" name="emergency_contact_no" value="{{ old('emergency_contact_no', $resident['emergency_contact_no']) }}" style="font-size: 0.8rem;">
                        @error('emergency_contact_no') <div class="invalid-feedback" style="font-size: 0.65rem;">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="emergency_contact_address" class="form-label" style="font-size: 0.65rem;">Address</label>
                        <input type="text" class="form-control form-control-sm @error('emergency_contact_address') is-invalid @enderror" id="emergency_contact_address" name="emergency_contact_address" value="{{ old('emergency_contact_address', $resident['emergency_contact_address']) }}" style="font-size: 0.8rem;">
                        @error('emergency_contact_address') <div class="invalid-feedback" style="font-size: 0.65rem;">{{ $message }}</div> @enderror
                    </div>
                </div>

                <!-- Profile Image -->
                <h6 class="fw-bold text-dark mt-2 mb-1" style="font-size: 0.8rem;">Profile Image</h6>
                <div class="row g-2 mb-2">
                    <div class="col-md-12">
                        @if($resident['profile_image'])
                            <div class="mb-1">
                                <img src="{{ asset('storage/' . $resident['profile_image']) }}" alt="Current Profile Image" class="img-thumbnail" style="max-height: 100px; max-width: 100px;">
                            </div>
                        @endif
                        <label for="profile_image" class="form-label" style="font-size: 0.65rem;">Update Photo</label>
                        <input type="file" class="form-control form-control-sm @error('profile_image') is-invalid @enderror" id="profile_image" name="profile_image" accept="image/*" style="font-size: 0.8rem;">
                        <div class="form-text" style="font-size: 0.6rem;">Supported formats: JPEG, PNG, JPG. Max size: 2MB.</div>
                        @error('profile_image') <div class="invalid-feedback" style="font-size: 0.65rem;">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="d-flex gap-1 mt-2 pt-2 border-top">
                    <a href="{{ route('residents.index') }}" class="btn btn-secondary btn-sm" style="font-size: 0.75rem; padding: 0.3rem 0.6rem;">Cancel</a>
                    <button type="submit" class="btn btn-primary btn-sm" style="font-size: 0.75rem; padding: 0.3rem 0.6rem;">
                        <i class="bi bi-check me-1"></i> Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
