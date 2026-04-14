@extends('layouts.app')

@section('title', 'Add Resident')

@section('content')
<!-- Data Privacy Act Modal -->
<div class="modal fade" id="dataPrivacyModal" tabindex="-1" aria-labelledby="dataPrivacyModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="dataPrivacyModalLabel">
                    <i class="bi bi-shield-lock"></i> Data Privacy Notice
                </h5>
            </div>
            <div class="modal-body" style="font-size: 0.85rem; max-height: 60vh; overflow-y: auto;">
                <div class="alert alert-info" role="alert">
                    <strong>Republic of the Philippines - Data Privacy Act of 2012</strong>
                </div>
                
                <h6 class="fw-bold mt-3 mb-2">Privacy Policy Notice</h6>
                <p>This Barangay E-Services System is committed to protecting your personal information and your right to privacy. If you have any questions or concerns about this privacy notice or our privacy practices, please contact us at the Barangay Office.</p>
                
                <h6 class="fw-bold mt-3 mb-2">1. Information We Collect</h6>
                <p>We collect personal information that you voluntarily provide to us when you register or use our services, including:</p>
                <ul style="font-size: 0.85rem;">
                    <li>Personal identification information (name, birthdate, gender, civil status)</li>
                    <li>Contact information (mobile number, telephone, email address)</li>
                    <li>Address and residential information</li>
                    <li>Identification documents and biometric data (profile photo, signature)</li>
                    <li>Health information (blood type)</li>
                    <li>Emergency contact information</li>
                    <li>Employment and family information</li>
                </ul>
                
                <h6 class="fw-bold mt-3 mb-2">2. How We Use Your Information</h6>
                <p>We use the collected information for:</p>
                <ul style="font-size: 0.85rem;">
                    <li>Providing barangay services and benefits</li>
                    <li>Issuance of barangay documents and certifications</li>
                    <li>Community planning and statistical purposes</li>
                    <li>Emergency response and disaster relief efforts</li>
                    <li>Law enforcement and dispute resolution</li>
                    <li>Communication regarding services and updates</li>
                </ul>
                
                <h6 class="fw-bold mt-3 mb-2">3. Data Security</h6>
                <p>We implement appropriate technical and organizational measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction. Access to personal information is restricted to authorized personnel only.</p>
                
                <h6 class="fw-bold mt-3 mb-2">4. Your Rights</h6>
                <p>Under the Data Privacy Act of 2012, you have the right to:</p>
                <ul style="font-size: 0.85rem;">
                    <li>Access your personal information</li>
                    <li>Correct inaccurate or incomplete information</li>
                    <li>Request deletion of your information (subject to legal requirements)</li>
                    <li>Object to processing of your information</li>
                    <li>Lodge complaints with the National Privacy Commission</li>
                </ul>
                
                <h6 class="fw-bold mt-3 mb-2">5. Data Retention</h6>
                <p>We retain your personal information for as long as necessary to provide our services and fulfill the purposes outlined in this notice, unless a longer retention period is required by law.</p>
                
                <h6 class="fw-bold mt-3 mb-2">6. Contact Information</h6>
                <p><strong>Barangay Office:</strong> Brgy. Kalawaan, City of Pasig, Philippines</p>
                <p><strong>For Privacy Concerns:</strong> Please visit the National Privacy Commission website or contact your local barangay office.</p>
                
                <div class="alert alert-warning mt-3" role="alert" style="font-size: 0.8rem;">
                    <strong>Important:</strong> By clicking "I Agree and Accept", you acknowledge that you have read and understood this Privacy Notice and consent to the collection, processing, and use of your personal information as described herein, in accordance with the Data Privacy Act of 2012.
                </div>
            </div>
            <div class="modal-footer">
                <div class="form-check w-100 mb-2">
                    <input class="form-check-input" type="checkbox" id="privacyAgreement" required>
                    <label class="form-check-label" for="privacyAgreement" style="font-size: 0.85rem;">
                        I have read and agree to the Data Privacy Notice
                    </label>
                </div>
                <button type="button" class="btn btn-primary" id="acceptPrivacyBtn" disabled>
                    <i class="bi bi-check-circle"></i> I Agree and Accept
                </button>
            </div>
        </div>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center mb-2">
    <h1 class="h6 fw-bold text-dark mb-0" style="font-size: 0.9rem;">Add Resident</h1>
    <a href="{{ route('residents.index') }}" class="btn btn-success btn-sm d-flex align-items-center gap-1" style="background-color: #198754; border-color: #198754; padding: 0.3rem 0.6rem; font-size: 0.75rem;" onclick="return confirm('Are you sure you want to go back? Unsaved changes will be lost.');">
        <i class="bi bi-arrow-left"></i> Back
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-2">
        @if (session('success'))
            <!-- Success Message Page -->
            <div class="text-center py-4">
                <div class="mb-4">
                    <i class="bi bi-check-circle-fill text-success" style="font-size: 3rem;"></i>
                </div>
                <h4 class="fw-bold text-success mb-1">Resident Added Successfully!</h4>
                <p class="text-muted mb-3" style="font-size: 0.9rem;">{{ session('success') }}</p>
                
                @if (session('generated_account'))
                    <div class="alert alert-info mb-3 text-start" role="alert" style="font-size: 0.8rem; max-width: 500px; margin: 0 auto;">
                        <div class="mb-2">
                            <h6 class="fw-bold mb-2">Account Credentials</h6>
                            <p class="mb-2 text-muted">Save these credentials and share with the resident. Password can be changed after login.</p>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-md-6">
                                <label class="form-label small text-muted mb-0" style="font-size: 0.7rem;">Username</label>
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control form-control-sm" id="username-field" value="{{ session('generated_account')['username'] ?? '' }}" readonly style="font-size: 0.75rem;">
                                    <button class="btn btn-outline-secondary btn-copy btn-sm" type="button" data-field="username-field" style="font-size: 0.7rem; padding: 0.2rem 0.4rem;">
                                        <i class="bi bi-clipboard"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small text-muted mb-0" style="font-size: 0.7rem;">Password</label>
                                <div class="input-group input-group-sm">
                                    <input type="password" class="form-control form-control-sm" id="password-field" value="{{ session('generated_account')['password'] ?? '' }}" readonly style="font-size: 0.75rem;">
                                    <button class="btn btn-outline-secondary btn-toggle-password btn-sm" type="button" data-field="password-field" style="font-size: 0.7rem; padding: 0.2rem 0.4rem;">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="btn btn-outline-secondary btn-copy btn-sm" type="button" data-field="password-field" style="font-size: 0.7rem; padding: 0.2rem 0.4rem;">
                                        <i class="bi bi-clipboard"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                
                <div class="d-flex gap-2 justify-content-center mt-4">
                    <a href="{{ route('residents.index') }}" class="btn btn-secondary btn-sm" style="padding: 0.4rem 0.8rem; font-size: 0.8rem;">
                        <i class="bi bi-arrow-left"></i> Back to Residents
                    </a>
                    <a href="{{ route('residents.create') }}" class="btn btn-primary btn-sm" style="background-color: #0038A8; border-color: #0038A8; padding: 0.4rem 0.8rem; font-size: 0.8rem;">
                        <i class="bi bi-plus-circle"></i> Add Another Resident
                    </a>
                </div>
            </div>
        @else
            <!-- Resident Creation Form -->
        <form action="{{ route('residents.store') }}" method="POST" enctype="multipart/form-data" onsubmit="return confirmResidentSave(this)">
            @csrf

            @if ($errors->has('first_name'))
                <div class="alert alert-danger mb-2" role="alert" style="font-size: 0.75rem; padding: 0.4rem 0.6rem;">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    {{ $errors->first('first_name') }}
                </div>
            @endif

            <div id="duplicate-resident-warning" class="alert alert-warning mb-2 d-none" role="alert" style="font-size: 0.75rem; padding: 0.4rem 0.6rem;">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <span id="duplicate-resident-message"></span>
            </div>

            <div class="row g-2 mb-2">
                <div class="col-md-4">
                    <label class="form-label text-muted small text-uppercase fw-bold required-field" style="font-size: 0.6rem;">First Name</label>
                    <input type="text" class="form-control form-control-sm @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required style="font-size: 0.8rem;">
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Middle Name</label>
                    <input type="text" class="form-control form-control-sm" name="middle_name" value="{{ old('middle_name') }}" style="font-size: 0.8rem;">
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted small text-uppercase fw-bold required-field" style="font-size: 0.6rem;">Last Name</label>
                    <input type="text" class="form-control form-control-sm" name="last_name" value="{{ old('last_name') }}" required style="font-size: 0.8rem;">
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Suffix <span class="text-muted">(Optional)</span></label>
                    <select class="form-select form-select-sm" name="suffix" style="font-size: 0.8rem;">
                        <option value="">None</option>
                        <option value="Jr.">Jr.</option>
                        <option value="Sr.">Sr.</option>
                        <option value="II">II</option>
                        <option value="III">III</option>
                        <option value="IV">IV</option>
                        <option value="V">V</option>
                    </select>
                </div>
                <div class="col-md-4">
                    @php
                        $selectedBirthDate = old('birth_date');
                        $selectedBirthYear = $selectedBirthDate ? date('Y', strtotime($selectedBirthDate)) : '';
                        $selectedBirthMonth = $selectedBirthDate ? date('n', strtotime($selectedBirthDate)) : '';
                        $selectedBirthDay = $selectedBirthDate ? date('j', strtotime($selectedBirthDate)) : '';
                        $currentYear = (int) date('Y');
                    @endphp
                    <label class="form-label text-muted small text-uppercase fw-bold required-field" style="font-size: 0.6rem;">Birth Date</label>
                    <input type="hidden" name="birth_date" id="birth_date" value="{{ old('birth_date') }}">
                    <div class="row g-1">
                        <div class="col-4">
                            <select class="form-select form-select-sm" id="birth_year" required style="font-size: 0.8rem;">
                                <option value="">Year</option>
                                @for ($year = $currentYear; $year >= 1900; $year--)
                                    <option value="{{ $year }}" {{ (string) $selectedBirthYear === (string) $year ? 'selected' : '' }}>{{ $year }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-4">
                            <select class="form-select form-select-sm" id="birth_month" required style="font-size: 0.8rem;">
                                <option value="">Month</option>
                                @foreach ([1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'] as $monthNumber => $monthName)
                                    <option value="{{ $monthNumber }}" {{ (string) $selectedBirthMonth === (string) $monthNumber ? 'selected' : '' }}>{{ $monthName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-4">
                            <select class="form-select form-select-sm" id="birth_day" required style="font-size: 0.8rem;">
                                <option value="">Day</option>
                                @for ($day = 1; $day <= 31; $day++)
                                    <option value="{{ $day }}" {{ (string) $selectedBirthDay === (string) $day ? 'selected' : '' }}>{{ $day }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <small class="text-muted d-block mt-1" style="font-size: 0.65rem;">Select year, month, and day.</small>
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted small text-uppercase fw-bold required-field" style="font-size: 0.6rem;">Gender</label>
                    <select class="form-select form-select-sm" name="gender" required style="font-size: 0.8rem;">
                        <option value="">Select...</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted small text-uppercase fw-bold required-field" style="font-size: 0.6rem;">Civil Status</label>
                    <select class="form-select form-select-sm" name="civil_status" required style="font-size: 0.8rem;">
                        <option value="">Select...</option>
                        <option value="Single">Single</option>
                        <option value="Married">Married</option>
                        <option value="Widowed">Widowed</option>
                        <option value="Separated">Separated</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Nationality</label>
                    <select class="form-select form-select-sm" name="nationality" style="font-size: 0.8rem;">
                        <option value="Filipino">Filipino</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Sector</label>
                    <select class="form-select form-select-sm" name="special_sector" style="font-size: 0.8rem;">
                        @php($selectedSector = old('special_sector', 'None'))
                        <option value="" {{ $selectedSector === '' ? 'selected' : '' }}>Select...</option>
                        <option value="Senior Citizen" {{ $selectedSector === 'Senior Citizen' ? 'selected' : '' }}>Senior Citizen</option>
                        <option value="PWD" {{ $selectedSector === 'PWD' ? 'selected' : '' }}>PWD</option>
                        <option value="LGBTQ" {{ $selectedSector === 'LGBTQ' ? 'selected' : '' }}>LGBTQ</option>
                        <option value="Solo Parent" {{ $selectedSector === 'Solo Parent' ? 'selected' : '' }}>Solo Parent</option>
                        <option value="None" {{ $selectedSector === 'None' ? 'selected' : '' }}>None</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Barangay</label>
                    <input type="text" class="form-control form-control-sm" name="barangay" value="Kalawaan" readonly style="font-size: 0.8rem;">
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Blood Type <span class="text-muted">(Optional)</span></label>
                    <select class="form-select form-select-sm" name="blood_type" style="font-size: 0.8rem;">
                        <option value="">Select...</option>
                        <option value="A+">A+</option>
                        <option value="A-">A-</option>
                        <option value="B+">B+</option>
                        <option value="B-">B-</option>
                        <option value="AB+">AB+</option>
                        <option value="AB-">AB-</option>
                        <option value="O+">O+</option>
                        <option value="O-">O-</option>
                    </select>
                </div>
                <div class="col-md-4">
                    @php($selectedHouseholdComposition = old('household_composition', old('is_head_of_family') ? 'Head of the Family' : ''))
                    <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Household Composition <span class="text-muted">(Optional)</span></label>
                    <input type="hidden" name="is_head_of_family" id="is_head_of_family" value="{{ old('is_head_of_family') ? 1 : 0 }}">
                    <select class="form-select form-select-sm" name="household_composition" id="household_composition" style="font-size: 0.8rem;">
                        <option value="">Select...</option>
                        <option value="Head of the Family" {{ $selectedHouseholdComposition === 'Head of the Family' ? 'selected' : '' }}>Head of the Family</option>
                        <option value="Spouse" {{ $selectedHouseholdComposition === 'Spouse' ? 'selected' : '' }}>Spouse</option>
                        <option value="Child" {{ $selectedHouseholdComposition === 'Child' ? 'selected' : '' }}>Child</option>
                    </select>
                    <!-- <small class="text-muted d-block mt-1" style="font-size: 0.65rem;">Selecting Head of the Family keeps the existing head-of-family logic.</small> -->
                </div>
            </div>

            <h6 class="fw-bold mb-2 mt-2" style="font-size: 0.8rem;">Additional Information</h6>
            <div class="row g-2 mb-2">
                <div class="col-md-4">
                    <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Height <span class="text-muted">(Optional)</span></label>
                    <div class="input-group input-group-sm">
                        <input type="number" step="0.01" min="0" class="form-control form-control-sm" name="height_cm" value="{{ old('height_cm') }}" style="font-size: 0.8rem;">
                        <span class="input-group-text" style="font-size: 0.75rem;">cm</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Weight <span class="text-muted">(Optional)</span></label>
                    <div class="input-group input-group-sm">
                        <input type="number" step="0.01" min="0" class="form-control form-control-sm" name="weight_kg" value="{{ old('weight_kg') }}" style="font-size: 0.8rem;">
                        <span class="input-group-text" style="font-size: 0.75rem;">kgs</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Religion <span class="text-muted">(Optional)</span></label>
                    <select class="form-select form-select-sm" name="religion" style="font-size: 0.8rem;">
                        <option value="">Select...</option>
                        <option value="Catholic" {{ old('religion') === 'Catholic' ? 'selected' : '' }}>Catholic</option>
                        <option value="Muslim" {{ old('religion') === 'Muslim' ? 'selected' : '' }}>Muslim</option>
                        <option value="Christian" {{ old('religion') === 'Christian' ? 'selected' : '' }}>Christian</option>
                        <option value="Iglesia ni Cristo" {{ old('religion') === 'Iglesia ni Cristo' ? 'selected' : '' }}>Iglesia ni Cristo</option>
                        <option value="Jesus is Lord" {{ old('religion') === 'Jesus is Lord' ? 'selected' : '' }}>Jesus is Lord</option>
                        <option value="Other" {{ old('religion') === 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Father's Name <span class="text-muted">(Optional)</span></label>
                    <input type="text" class="form-control form-control-sm" name="father_name" value="{{ old('father_name') }}" style="font-size: 0.8rem;">
                </div>
                <div class="col-md-6">
                    <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Mother's Maiden Name <span class="text-muted">(Optional)</span></label>
                    <input type="text" class="form-control form-control-sm" name="mother_maiden_name" value="{{ old('mother_maiden_name') }}" style="font-size: 0.8rem;">
                </div>
                <div class="col-md-6 married-fields">
                    <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Spouse <span class="text-muted">(If Married)</span></label>
                    <input type="text" class="form-control form-control-sm" id="spouse_name" name="spouse_name" value="{{ old('spouse_name') }}" style="font-size: 0.8rem;">
                </div>
                <div class="col-md-6 married-fields">
                    <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Name/s of Children <span class="text-muted">(If Married)</span></label>
                    <textarea class="form-control form-control-sm" id="children_names" name="children_names" rows="2" style="font-size: 0.8rem;">{{ old('children_names') }}</textarea>
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Residency Type <span class="text-muted">(Optional)</span></label>
                    <select class="form-select form-select-sm" name="residency_type" style="font-size: 0.8rem;">
                        <option value="">Select...</option>
                        <option value="Owner" {{ old('residency_type') === 'Owner' ? 'selected' : '' }}>Owner</option>
                        <option value="Rentee" {{ old('residency_type') === 'Rentee' ? 'selected' : '' }}>Rentee</option>
                        <option value="Informal Settler" {{ old('residency_type') === 'Informal Settler' ? 'selected' : '' }}>Informal Settler</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Tenure Status <span class="text-muted">(Optional)</span></label>
                    <select class="form-select form-select-sm" name="tenure_status" style="font-size: 0.8rem;">
                        <option value="">Select...</option>
                        <option value="Permanent" {{ old('tenure_status') === 'Permanent' ? 'selected' : '' }}>Permanent</option>
                        <option value="Temporary" {{ old('tenure_status') === 'Temporary' ? 'selected' : '' }}>Temporary</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Length of Stay <span class="text-muted">(Optional)</span></label>
                    <input type="text" class="form-control form-control-sm" name="length_of_stay" value="{{ old('length_of_stay') }}" placeholder="e.g., 10 years" style="font-size: 0.8rem;">
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Registered Voter <span class="text-muted">(Optional)</span></label>
                    <select class="form-select form-select-sm" id="registered_voter" name="registered_voter" style="font-size: 0.8rem;">
                        <option value="">Select...</option>
                        <option value="Yes" {{ old('registered_voter') === 'Yes' ? 'selected' : '' }}>Yes</option>
                        <option value="No" {{ old('registered_voter') === 'No' ? 'selected' : '' }}>No</option>
                    </select>
                </div>
                <div class="col-md-4 voter-fields">
                    <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Precinct No. <span class="text-muted">(If Voter)</span></label>
                    <input type="text" class="form-control form-control-sm" id="precinct_no" name="precinct_no" value="{{ old('precinct_no') }}" style="font-size: 0.8rem;">
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Occupation <span class="text-muted">(Optional)</span></label>
                    <input type="text" class="form-control form-control-sm" name="occupation" value="{{ old('occupation') }}" style="font-size: 0.8rem;">
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Employment Type <span class="text-muted">(Optional)</span></label>
                    <select class="form-select form-select-sm" name="employment_type" style="font-size: 0.8rem;">
                        <option value="">Select...</option>
                        <option value="Government" {{ old('employment_type') === 'Government' ? 'selected' : '' }}>Government</option>
                        <option value="Private" {{ old('employment_type') === 'Private' ? 'selected' : '' }}>Private</option>
                    </select>
                </div>
                <div class="col-md-8">
                    <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Economic Status <span class="text-muted">(Optional)</span></label>
                    <select class="form-select form-select-sm" name="economic_status" style="font-size: 0.8rem;">
                        <option value="">Select...</option>
                        <option value="Low-income/Poor" {{ old('economic_status') === 'Low-income/Poor' ? 'selected' : '' }}>Low-income/Poor</option>
                        <option value="Low-Income but Not Poor" {{ old('economic_status') === 'Low-Income but Not Poor' ? 'selected' : '' }}>Low-Income but Not Poor</option>
                        <option value="Lower Middle Income" {{ old('economic_status') === 'Lower Middle Income' ? 'selected' : '' }}>Lower Middle Income</option>
                        <option value="Middle Income/Independent" {{ old('economic_status') === 'Middle Income/Independent' ? 'selected' : '' }}>Middle Income/Independent</option>
                        <option value="High Income/Rich" {{ old('economic_status') === 'High Income/Rich' ? 'selected' : '' }}>High Income/Rich</option>
                    </select>
                </div>
            </div>

            <h6 class="fw-bold mb-2 mt-2" style="font-size: 0.8rem;">Address</h6>
            <div class="row g-2 mb-2">
                <div class="col-md-6">
                    <label class="form-label text-muted small text-uppercase fw-bold required-field" style="font-size: 0.6rem;">House No./Unit/Bldg</label>
                    <input type="text" class="form-control form-control-sm address-field" name="house_no" required style="font-size: 0.8rem;">
                </div>
                <div class="col-md-6">
                    <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Street Name</label>
                    <select class="form-select form-select-sm address-field" name="street_name" style="font-size: 0.8rem;">
                        <option value="">Select Street...</option>
                        <option value="A.V Jimenez St">A.V Jimenez St</option>
                        <option value="AB. Kamagong">AB. Kamagong</option>
                        <option value="Acacia St">Acacia St</option>
                        <option value="Alley 1 St">Alley 1 St</option>
                        <option value="Alley 2 St">Alley 2 St</option>
                        <option value="Anonas St">Anonas St</option>
                        <option value="Atis St">Atis St</option>
                        <option value="Avocado St">Avocado St</option>
                        <option value="Axis Road">Axis Road</option>
                        <option value="Balimbing St">Balimbing St</option>
                        <option value="Bayabas St">Bayabas St</option>
                        <option value="Bornay Hoa">Bornay Hoa</option>
                        <option value="C. Bornay St">C. Bornay St</option>
                        <option value="Calachuchi St">Calachuchi St</option>
                        <option value="Camachile St">Camachile St</option>
                        <option value="Camia St">Camia St</option>
                        <option value="Carnation St">Carnation St</option>
                        <option value="Casoy St">Casoy St</option>
                        <option value="Castillo St">Castillo St</option>
                        <option value="Chico St">Chico St</option>
                        <option value="Christian-Muslim Sarinas Comp.">Christian-Muslim Sarinas Comp.</option>
                        <option value="D.M Tuazon St">D.M Tuazon St</option>
                        <option value="Dalandan St">Dalandan St</option>
                        <option value="Dhalia St">Dhalia St</option>
                        <option value="Dolmar Subd.">Dolmar Subd.</option>
                        <option value="Duhat St">Duhat St</option>
                        <option value="Durian St">Durian St</option>
                        <option value="Elisco Road">Elisco Road</option>
                        <option value="Gumamela St">Gumamela St</option>
                        <option value="Guyabano St">Guyabano St</option>
                        <option value="Ilang Ilang St">Ilang Ilang St</option>
                        <option value="Ipil St">Ipil St</option>
                        <option value="Ismar">Ismar</option>
                        <option value="Jabson1">Jabson1</option>
                        <option value="Jabson2">Jabson2</option>
                        <option value="Javier Comp St">Javier Comp St</option>
                        <option value="Kamias St">Kamias St</option>
                        <option value="Kamagong St">Kamagong St</option>
                        <option value="Kayumito St">Kayumito St</option>
                        <option value="Krovha Phase 1">Krovha Phase 1</option>
                        <option value="Krovha Phase 2">Krovha Phase 2</option>
                        <option value="Krovha Phase 3">Krovha Phase 3</option>
                        <option value="Langka St">Langka St</option>
                        <option value="Lansones St">Lansones St</option>
                        <option value="M. Castillo St">M. Castillo St</option>
                        <option value="M. Jimenez St">M. Jimenez St</option>
                        <option value="Maasikaso St">Maasikaso St</option>
                        <option value="Maayos St">Maayos St</option>
                        <option value="Macopa St">Macopa St</option>
                        <option value="Mahogany St">Mahogany St</option>
                        <option value="Mangga Ave St">Mangga Ave St</option>
                        <option value="Mansanas St">Mansanas St</option>
                        <option value="Mapag Mahal St">Mapag Mahal St</option>
                        <option value="Masipag St">Masipag St</option>
                        <option value="Masunurin St">Masunurin St</option>
                        <option value="Maunawain St">Maunawain St</option>
                        <option value="Melon St">Melon St</option>
                        <option value="N. Cuevas St">N. Cuevas St</option>
                        <option value="Nabsala St. Sarinas Comp.">Nabsala St. Sarinas Comp.</option>
                        <option value="Nara St">Nara St</option>
                        <option value="Orchids St">Orchids St</option>
                        <option value="Pag Asa St">Pag Asa St</option>
                        <option value="Papaya St">Papaya St</option>
                        <option value="Paulino St">Paulino St</option>
                        <option value="Pinya St">Pinya St</option>
                        <option value="R. Castillo St">R. Castillo St</option>
                        <option value="R.Tatco St">R.Tatco St</option>
                        <option value="Rambutan St">Rambutan St</option>
                        <option value="Rose St">Rose St</option>
                        <option value="S. Cuevas St">S. Cuevas St</option>
                        <option value="Sampaloc St">Sampaloc St</option>
                        <option value="Sampaguita St">Sampaguita St</option>
                        <option value="Sampaguita Street Dolmar Subdivision">Sampaguita Street Dolmar Subdivision</option>
                        <option value="Sampaguita Street Ismar">Sampaguita Street Ismar</option>
                        <option value="San Agustin Road">San Agustin Road</option>
                        <option value="San Flower St">San Flower St</option>
                        <option value="San Pedro St">San Pedro St</option>
                        <option value="Santan St">Santan St</option>
                        <option value="Santol St">Santol St</option>
                        <option value="Sikap Compound St">Sikap Compound St</option>
                        <option value="Suha St">Suha St</option>
                        <option value="Sunflower St">Sunflower St</option>
                        <option value="Talisay St">Talisay St</option>
                        <option value="Tanguile St">Tanguile St</option>
                        <option value="Ubas St">Ubas St</option>
                        <option value="Ugong St">Ugong St</option>
                        <option value="Uyvico St">Uyvico St</option>
                        <option value="Visitacion St">Visitacion St</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">City</label>
                    <select class="form-select form-select-sm address-field" name="province" style="font-size: 0.8rem;">
                        <option value="Pasig City" selected>Pasig City</option>
                    </select>
                    <small class="text-muted d-block mt-1" style="font-size: 0.65rem;">Fixed to Pasig City</small>
                </div>
                <div class="col-md-6">
                    <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Zip Code</label>
                    <input type="text" class="form-control form-control-sm address-field" name="zip_code" value="1600" readonly style="font-size: 0.8rem;">
                </div>
                <div class="col-md-12">
                    <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Full Address</label>
                    <textarea class="form-control form-control-sm" id="full_address_display" rows="2" readonly style="font-size: 0.8rem; background-color: #f8f9fa;"></textarea>
                    <small class="text-muted d-block mt-1" style="font-size: 0.65rem;">Auto-filled from house no, street name and city above</small>
                </div>
            </div>

            <h6 class="fw-bold mb-2 mt-2" style="font-size: 0.8rem;">Contact Information</h6>
            <div class="row g-2 mb-2">
                <div class="col-md-6">
                    <label class="form-label text-muted small text-uppercase fw-bold required-field" style="font-size: 0.6rem;">Mobile Number</label>
                    <input type="text" class="form-control form-control-sm mobile-number" name="contact_number" placeholder="e.g., 09123456789" inputmode="numeric" maxlength="11" pattern="[0-9]{11}" required style="font-size: 0.8rem;">
                    <small class="text-muted d-block mt-1" style="font-size: 0.65rem;">Must be exactly 11 digits</small>
                    @if ($errors->has('contact_number'))
                        <div class="text-danger small mt-1" style="font-size: 0.65rem;">{{ $errors->first('contact_number') }}</div>
                    @endif
                </div>
                <div class="col-md-6">
                    <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Telephone No</label>
                    <input type="text" class="form-control form-control-sm telephone-number" name="telephone_no" placeholder="Optional" style="font-size: 0.8rem;">
                </div>
                <div class="col-md-12">
                    <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Email</label>
                    <input type="email" class="form-control form-control-sm" name="email" placeholder="Optional" style="font-size: 0.8rem;">
                    @if ($errors->has('email'))
                        <div class="text-danger small mt-1" style="font-size: 0.65rem;">{{ $errors->first('email') }}</div>
                    @endif
                </div>
            </div>

            <h6 class="fw-bold mb-2 mt-2" style="font-size: 0.8rem;">Emergency Contact</h6>
            <div class="row g-2 mb-2">
                <div class="col-md-6">
                    <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Name</label>
                    <input type="text" class="form-control form-control-sm" name="emergency_contact_name" style="font-size: 0.8rem;">
                </div>
                <div class="col-md-6">
                    <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Relationship</label>
                    <select class="form-select form-select-sm" name="emergency_contact_relationship" style="font-size: 0.8rem;">
                        <option value="">Select...</option>
                        <option value="Husband">Husband</option>
                        <option value="Wife">Wife</option>
                        <option value="Partner">Partner</option>
                        <option value="Mother">Mother</option>
                        <option value="Father">Father</option>
                        <option value="Son">Son</option>
                        <option value="Daughter">Daughter</option>
                        <option value="Sibling">Sibling</option>
                        <option value="Grandparent">Grandparent</option>
                        <option value="Cousin">Cousin</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Contact Number</label>
                    <input type="text" class="form-control form-control-sm mobile-number" name="emergency_contact_no" placeholder="e.g., 09123456789" inputmode="numeric" maxlength="11" pattern="[0-9]{11}" style="font-size: 0.8rem;">
                    <small class="text-muted d-block mt-1" style="font-size: 0.65rem;">Must be exactly 11 digits</small>
                </div>
                <div class="col-md-12">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="same_as_above_address" name="same_as_above_address">
                        <label class="form-check-label text-muted" for="same_as_above_address" style="font-size: 0.75rem;">
                            Same as above (use main address)
                        </label>
                    </div>
                    <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Address</label>
                    <textarea class="form-control form-control-sm" id="emergency_address_display" name="emergency_contact_address" rows="2" style="font-size: 0.8rem;"></textarea>
                </div>
            </div>

            <h6 class="fw-bold mb-2 mt-2" style="font-size: 0.8rem;">Profile Picture & Signature</h6>
            <div class="row g-2 mb-2">
                <!-- Profile Picture (Left) -->
                <div class="col-md-6">
                    <div class="card border-light bg-light h-100">
                        <div class="card-body p-2">
                            <h6 class="fw-bold mb-2" style="font-size: 0.75rem;">Profile Picture</h6>
                            <div id="profile-image-section">
                                <div class="d-flex gap-1 flex-wrap mb-2">
                                    <button type="button" class="btn btn-outline-primary btn-sm" id="upload-btn" style="font-size: 0.75rem; padding: 0.3rem 0.6rem;">
                                        <i class="bi bi-cloud-upload"></i> Upload
                                    </button>
                                    <button type="button" class="btn btn-outline-info btn-sm" id="capture-btn" style="font-size: 0.75rem; padding: 0.3rem 0.6rem;">
                                        <i class="bi bi-camera"></i> Capture
                                    </button>
                                </div>
                                <input type="file" id="photo-file-input" name="profile_image" accept="image/*" style="display: none;">
                                <input type="hidden" id="profile-image-base64" name="profile_image_base64" value="{{ old('profile_image_base64') }}">
                                
                                <div id="image-preview" style="display: none;" class="mt-2">
                                    <img id="preview-img" src="" alt="Preview" style="max-width: 150px; max-height: 150px; border-radius: 6px; border: 2px solid #dee2e6;">
                                    <div class="mt-1">
                                        <button type="button" class="btn btn-sm btn-danger" id="remove-photo-btn" style="font-size: 0.7rem; padding: 0.2rem 0.4rem;">
                                            <i class="bi bi-trash"></i> Remove
                                        </button>
                                    </div>
                                </div>

                                <div id="camera-section" style="display: none;" class="mt-2">
                                    <div class="position-relative d-inline-block">
                                        <video id="video-stream" width="300" height="300" style="border-radius: 6px; background: #000; object-fit: cover;" autoplay></video>
                                    </div>
                                    <canvas id="capture-canvas" style="display: none;"></canvas>
                                    <div class="mt-1 d-flex gap-1">
                                        <button type="button" class="btn btn-sm btn-success" id="capture-photo-btn" style="font-size: 0.7rem; padding: 0.2rem 0.4rem;">
                                            <i class="bi bi-camera-fill"></i> Capture
                                        </button>
                                        <button type="button" class="btn btn-sm btn-secondary" id="close-camera-btn" style="font-size: 0.7rem; padding: 0.2rem 0.4rem;">
                                            <i class="bi bi-x-lg"></i> Close
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($errors->has('profile_image'))
                        <div class="alert alert-danger mt-1 mb-0" style="font-size: 0.75rem; padding: 0.4rem 0.6rem;">{{ $errors->first('profile_image') }}</div>
                    @endif
                </div>

                <!-- Signature (Right) -->
                <div class="col-md-6">
                    <div class="card border-light bg-light h-100">
                        <div class="card-body p-2">
                            <h6 class="fw-bold mb-2" style="font-size: 0.75rem;">Signature</h6>
                            <div id="signature-section">
                                <div class="d-flex gap-1 flex-wrap mb-2">
                            
                                    <button type="button" class="btn btn-outline-info btn-sm" id="draw-signature-large-btn" style="font-size: 0.75rem; padding: 0.3rem 0.6rem;">
                                        <i class="bi bi-pencil"></i> Draw
                                    </button>
                                </div>
                                <input type="file" id="signature-file-input" name="signature" accept="image/*" style="display: none;">
                                <input type="hidden" id="signature-base64" name="signature_base64" value="{{ old('signature_base64') }}">
                                
                                <div id="signature-preview" style="display: none;" class="mt-2">
                                    <img id="preview-signature" src="" alt="Signature Preview" style="max-width: 200px; max-height: 100px; border: 2px solid #dee2e6; border-radius: 4px; background: transparent; padding: 5px;">
                                    <div class="mt-1">
                                        <button type="button" class="btn btn-sm btn-danger" id="remove-signature-btn" style="font-size: 0.7rem; padding: 0.2rem 0.4rem;">
                                            <i class="bi bi-trash"></i> Remove
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($errors->has('signature'))
                        <div class="alert alert-danger mt-1 mb-0" style="font-size: 0.75rem; padding: 0.4rem 0.6rem;">{{ $errors->first('signature') }}</div>
                    @endif
                </div>
            </div>

            <hr class="my-2">

            <h6 class="fw-bold mb-2" style="font-size: 0.8rem;">Account Information</h6>
            <div class="alert alert-info mb-2" role="alert" style="font-size: 0.75rem; padding: 0.4rem 0.6rem;">
                <i class="bi bi-info-circle"></i> System will auto-generate username and password.
            </div>

            @if (session('success'))
                <div class="alert alert-success mb-2" role="alert" style="font-size: 0.75rem; padding: 0.4rem 0.6rem;">
                    <div class="d-flex align-items-center gap-1 mb-1">
                        <i class="bi bi-check-circle-fill"></i>
                        <strong>{{ session('success') }}</strong>
                    </div>
                    @if (session('generated_account'))
                        <hr class="my-1">
                        <div class="mt-2 p-2 bg-white rounded border border-success-subtle">
                            <h6 class="fw-bold mb-2" style="font-size: 0.75rem;">Account Credentials</h6>
                            <div class="row g-1">
                                <div class="col-md-6">
                                    <label class="form-label small text-muted mb-0" style="font-size: 0.65rem;">Username</label>
                                    <div class="input-group input-group-sm">
                                        <input type="text" class="form-control form-control-sm" id="username-field" value="{{ session('generated_account')['username'] ?? '' }}" readonly style="font-size: 0.7rem;">
                                        <button class="btn btn-outline-secondary btn-copy btn-sm" type="button" data-field="username-field" style="font-size: 0.7rem; padding: 0.2rem 0.4rem;">
                                            <i class="bi bi-clipboard"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-muted mb-0" style="font-size: 0.65rem;">Password</label>
                                    <div class="input-group input-group-sm">
                                        <input type="password" class="form-control form-control-sm" id="password-field" value="{{ session('generated_account')['password'] ?? '' }}" readonly style="font-size: 0.7rem;">
                                        <button class="btn btn-outline-secondary btn-toggle-password btn-sm" type="button" data-field="password-field" style="font-size: 0.7rem; padding: 0.2rem 0.4rem;">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button class="btn btn-outline-secondary btn-copy btn-sm" type="button" data-field="password-field" style="font-size: 0.7rem; padding: 0.2rem 0.4rem;">
                                            <i class="bi bi-clipboard"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <p class="small text-muted mt-1 mb-0" style="font-size: 0.65rem;">Share with resident. Can change after login.</p>
                        </div>
                    @endif
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger mb-2" role="alert" style="font-size: 0.75rem; padding: 0.4rem 0.6rem;">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    {{ session('error') }}
                </div>
            @endif

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('residents.index') }}" class="btn btn-secondary btn-sm px-3" style="padding: 0.4rem 0.8rem; font-size: 0.8rem;" onclick="return confirm('Are you sure you want to cancel? Unsaved changes will be lost.');">Cancel</a>
                <button type="submit" id="save-resident-btn" class="btn btn-primary btn-sm px-3" style="background-color: #0038A8; border-color: #0038A8; padding: 0.4rem 0.8rem; font-size: 0.8rem;">Save</button>
            </div>
        </form>
        @endif
    </div>
</div>

<!-- Signature Large Canvas Modal -->
<div class="modal fade" id="signatureLargeModal" tabindex="-1" aria-labelledby="signatureLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="signatureLargeModalLabel">Draw Signature</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-2 p-md-3">
                <div class="text-center">
                    <div style="border: 2px solid #dee2e6; border-radius: 4px; background: transparent; overflow: hidden; display: inline-block; width: 100%; max-width: 800px;">
                        <canvas id="signature-canvas-large" style="display: block; cursor: crosshair; background: transparent; width: 100%; height: auto; max-width: 100%; touch-action: none;"></canvas>
                    </div>
                    <p class="text-muted mt-2 mb-0" style="font-size: 0.85rem;">
                        <i class="bi bi-info-circle"></i> Draw your signature using your mouse or touch screen
                    </p>
                </div>
            </div>
            <div class="modal-footer flex-wrap gap-2">
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

<!-- Cropper.js -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Restore profile image and signature from old() values if present
    const profileImageBase64 = document.getElementById('profile-image-base64').value;
    const signatureBase64 = document.getElementById('signature-base64').value;
    
    if (profileImageBase64) {
        const previewImg = document.getElementById('preview-img');
        const imagePreview = document.getElementById('image-preview');
        previewImg.src = profileImageBase64;
        imagePreview.style.display = 'block';
    }
    
    if (signatureBase64) {
        const previewSignature = document.getElementById('preview-signature');
        const signaturePreview = document.getElementById('signature-preview');
        previewSignature.src = signatureBase64;
        signaturePreview.style.display = 'block';
    }
    
    // Auto-select Senior Citizen for birthdate >= 60 years old
    const birthDateInput = document.getElementById('birth_date');
    const birthYearSelect = document.getElementById('birth_year');
    const birthMonthSelect = document.getElementById('birth_month');
    const birthDaySelect = document.getElementById('birth_day');
    const specialSectorSelect = document.querySelector('select[name="special_sector"]');

    function syncBirthDate() {
        if (!birthDateInput || !birthYearSelect || !birthMonthSelect || !birthDaySelect) {
            return;
        }

        const year = birthYearSelect.value;
        const month = birthMonthSelect.value;
        const day = birthDaySelect.value;

        birthDaySelect.setCustomValidity('');

        if (!year || !month || !day) {
            birthDateInput.value = '';
            return;
        }

        const formattedMonth = month.padStart(2, '0');
        const formattedDay = day.padStart(2, '0');
        const formattedDate = `${year}-${formattedMonth}-${formattedDay}`;
        const birthDate = new Date(`${formattedDate}T00:00:00`);
        const isValidDate =
            !isNaN(birthDate.getTime()) &&
            birthDate.getFullYear() === Number(year) &&
            birthDate.getMonth() + 1 === Number(month) &&
            birthDate.getDate() === Number(day);

        if (!isValidDate || birthDate > new Date()) {
            birthDateInput.value = '';
            birthDaySelect.setCustomValidity('Select a valid birth date.');
            return;
        }

        birthDateInput.value = formattedDate;
    }
    
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
        // Only proceed if we have a complete date (10 characters in YYYY-MM-DD format)
        if (birthDateInput.value && birthDateInput.value.length === 10) {
            const birthDate = new Date(`${birthDateInput.value}T00:00:00`);
            
            // Validate that the date is valid and not in the future
            if (isNaN(birthDate.getTime()) || birthDate > new Date()) {
                return;
            }
            
            const age = calculateAge(birthDate);
            
            // Automatically set or clear Senior Citizen based on age
            if (age >= 60) {
                specialSectorSelect.value = 'Senior Citizen';
            } else {
                // Reset to default if not a senior citizen
                if (specialSectorSelect.value === 'Senior Citizen') {
                    specialSectorSelect.value = '';
                }
            }
        }
    }

    [birthYearSelect, birthMonthSelect, birthDaySelect].forEach(field => {
        if (!field) {
            return;
        }

        field.addEventListener('change', function() {
            syncBirthDate();
            checkAndSetSeniorCitizen();
        });
    });

    syncBirthDate();
    checkAndSetSeniorCitizen();

    const civilStatusSelect = document.querySelector('select[name="civil_status"]');
    const marriedFieldGroups = document.querySelectorAll('.married-fields');
    const spouseNameInput = document.getElementById('spouse_name');
    const childrenNamesInput = document.getElementById('children_names');
    const registeredVoterSelect = document.getElementById('registered_voter');
    const voterFieldGroups = document.querySelectorAll('.voter-fields');
    const precinctNoInput = document.getElementById('precinct_no');
    const householdCompositionSelect = document.getElementById('household_composition');
    const isHeadOfFamilyInput = document.getElementById('is_head_of_family');

    function toggleConditionalFields(groups, shouldShow) {
        groups.forEach(group => {
            group.style.display = shouldShow ? '' : 'none';
        });
    }

    function updateMarriedFields() {
        const isMarried = civilStatusSelect && civilStatusSelect.value === 'Married';
        toggleConditionalFields(marriedFieldGroups, isMarried);

        if (spouseNameInput) spouseNameInput.required = isMarried;
        if (childrenNamesInput) childrenNamesInput.required = isMarried;

        if (!isMarried) {
            if (spouseNameInput) spouseNameInput.value = '';
            if (childrenNamesInput) childrenNamesInput.value = '';
        }
    }

    function updateVoterFields() {
        const isRegisteredVoter = registeredVoterSelect && registeredVoterSelect.value === 'Yes';
        toggleConditionalFields(voterFieldGroups, isRegisteredVoter);

        if (precinctNoInput) precinctNoInput.required = isRegisteredVoter;

        if (!isRegisteredVoter && precinctNoInput) {
            precinctNoInput.value = '';
        }
    }

    function syncHeadOfFamilySelection() {
        if (!householdCompositionSelect || !isHeadOfFamilyInput) {
            return;
        }

        isHeadOfFamilyInput.value = householdCompositionSelect.value === 'Head of the Family' ? '1' : '0';
    }

    if (civilStatusSelect) {
        civilStatusSelect.addEventListener('change', updateMarriedFields);
    }

    if (registeredVoterSelect) {
        registeredVoterSelect.addEventListener('change', updateVoterFields);
    }

    if (householdCompositionSelect) {
        householdCompositionSelect.addEventListener('change', syncHeadOfFamilySelection);
    }

    updateMarriedFields();
    updateVoterFields();
    syncHeadOfFamilySelection();

    const residentForm = document.querySelector('form[action="{{ route('residents.store') }}"]');
    const saveResidentBtn = document.getElementById('save-resident-btn');
    const duplicateWarning = document.getElementById('duplicate-resident-warning');
    const duplicateMessage = document.getElementById('duplicate-resident-message');
    const duplicateCheckUrl = "{{ route('residents.check-duplicate') }}";
    const firstNameField = residentForm?.querySelector('input[name="first_name"]');
    const middleNameField = residentForm?.querySelector('input[name="middle_name"]');
    const lastNameField = residentForm?.querySelector('input[name="last_name"]');
    const suffixField = residentForm?.querySelector('select[name="suffix"]');
    let duplicateCheckToken = 0;

    if (residentForm && saveResidentBtn) {
        saveResidentBtn.addEventListener('click', function() {
            residentForm.classList.add('was-validated');
        });

        residentForm.querySelectorAll('input, select, textarea').forEach(field => {
            field.addEventListener('input', function() {
                if (this.checkValidity()) {
                    this.classList.remove('is-invalid');
                }
            });

            field.addEventListener('change', function() {
                if (this.checkValidity()) {
                    this.classList.remove('is-invalid');
                }
            });
        });

        function setDuplicateWarningState(hasDuplicate, message = '') {
            if (!duplicateWarning || !duplicateMessage) {
                return;
            }

            duplicateWarning.classList.toggle('d-none', !hasDuplicate);
            duplicateMessage.textContent = hasDuplicate ? message : '';
            saveResidentBtn.disabled = hasDuplicate;
            saveResidentBtn.title = hasDuplicate ? 'Resolve duplicate resident warning before saving.' : '';
        }

        function getDuplicatePayload() {
            return {
                first_name: firstNameField?.value.trim() ?? '',
                middle_name: middleNameField?.value.trim() ?? '',
                last_name: lastNameField?.value.trim() ?? '',
                suffix: suffixField?.value ?? '',
                birth_date: birthDateInput?.value ?? '',
            };
        }

        function isDuplicateCheckReady(payload) {
            return payload.first_name !== '' && payload.last_name !== '' && payload.birth_date !== '';
        }

        async function checkResidentDuplicate() {
            const payload = getDuplicatePayload();

            if (!isDuplicateCheckReady(payload)) {
                setDuplicateWarningState(false);
                return;
            }

            const requestToken = ++duplicateCheckToken;
            const query = new URLSearchParams(payload);

            try {
                const response = await fetch(`${duplicateCheckUrl}?${query.toString()}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                });

                if (!response.ok) {
                    throw new Error('Duplicate check request failed.');
                }

                const data = await response.json();

                if (requestToken !== duplicateCheckToken) {
                    return;
                }

                if (data.exists && data.resident) {
                    const message = `${data.resident.display_name} with birth date ${data.resident.birth_date} already exists. Please review the existing record before saving.`;
                    setDuplicateWarningState(true, message);
                    firstNameField?.classList.add('is-invalid');
                } else {
                    setDuplicateWarningState(false);
                    firstNameField?.classList.remove('is-invalid');
                }
            } catch (error) {
                if (requestToken !== duplicateCheckToken) {
                    return;
                }

                setDuplicateWarningState(false);
            }
        }

        [firstNameField, middleNameField, lastNameField].forEach(field => {
            field?.addEventListener('blur', checkResidentDuplicate);
            field?.addEventListener('mouseup', checkResidentDuplicate);
        });

        [suffixField, birthYearSelect, birthMonthSelect, birthDaySelect].forEach(field => {
            field?.addEventListener('change', checkResidentDuplicate);
            field?.addEventListener('blur', checkResidentDuplicate);
        });

        residentForm.addEventListener('submit', function(event) {
            if (saveResidentBtn.disabled) {
                event.preventDefault();
            }
        });

        checkResidentDuplicate();
    }
    
    // Auto-fill full address from address components
    const addressFields = document.querySelectorAll('.address-field');
    const fullAddressDisplay = document.getElementById('full_address_display');

    function formatStreetName(streetName) {
        return streetName ? streetName.replace(/\bSt\.?$/iu, 'St') : '';
    }
    
    function updateFullAddress() {
        const houseNo = document.querySelector('input[name="house_no"]').value;
        const streetName = formatStreetName(document.querySelector('select[name="street_name"]').value);
        const province = document.querySelector('select[name="province"]').value;
        
        const addressParts = [];
        const streetAddress = [houseNo, streetName].filter(Boolean).join(' ');
        if (streetAddress) addressParts.push(streetAddress);
        if (province) addressParts.push(province);
        
        fullAddressDisplay.value = addressParts.join(', ') || '';
    }
    
    addressFields.forEach(field => {
        field.addEventListener('change', updateFullAddress);
        field.addEventListener('input', updateFullAddress);
    });
    
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

    // Telephone number validation - only numbers allowed
    document.querySelectorAll('.telephone-number').forEach(field => {
        field.addEventListener('input', function(e) {
            // Remove any non-numeric characters
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    });

    // Toggle password visibility using event delegation
    document.addEventListener('click', function(e) {
        if (e.target.closest('.btn-toggle-password')) {
            e.preventDefault();
            e.stopPropagation();
            
            const btn = e.target.closest('.btn-toggle-password');
            const fieldId = btn.getAttribute('data-field');
            const field = document.getElementById(fieldId);
            
            if (field) {
                const isPassword = field.type === 'password';
                field.type = isPassword ? 'text' : 'password';
                btn.innerHTML = isPassword ? '<i class="bi bi-eye-slash"></i>' : '<i class="bi bi-eye"></i>';
            }
        }
    }, false);

    const uploadBtn = document.getElementById('upload-btn');
    const captureBtn = document.getElementById('capture-btn');
    const photoFileInput = document.getElementById('photo-file-input');
    const imagePreview = document.getElementById('image-preview');
    const previewImg = document.getElementById('preview-img');
    const cameraSection = document.getElementById('camera-section');
    const videoStream = document.getElementById('video-stream');
    const captureCanvas = document.getElementById('capture-canvas');
    const capturePhotoBtn = document.getElementById('capture-photo-btn');
    const closeCameraBtn = document.getElementById('close-camera-btn');
    const removePhotoBtn = document.getElementById('remove-photo-btn');
    
    let currentStream = null;

    // Upload Photo Handler
    uploadBtn.addEventListener('click', function() {
        photoFileInput.click();
    });

    photoFileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            openCropModal(file);
        }
    });

    // Capture Photo Handler
    captureBtn.addEventListener('click', async function() {
        try {
            currentStream = await navigator.mediaDevices.getUserMedia({ 
                video: { facingMode: 'user' } 
            });
            videoStream.srcObject = currentStream;
            cameraSection.style.display = 'block';
            imagePreview.style.display = 'none';
        } catch (error) {
            alert('Unable to access camera: ' + error.message);
        }
    });

    // Capture Photo from Camera
    capturePhotoBtn.addEventListener('click', function() {
        captureCanvas.width = videoStream.videoWidth;
        captureCanvas.height = videoStream.videoHeight;
        
        const context = captureCanvas.getContext('2d');
        if (context) {
            context.drawImage(videoStream, 0, 0);
            captureCanvas.toBlob(function(blob) {
                if (blob) {
                    const file = new File([blob], "captured-photo.jpg", { type: "image/jpeg" });
                    if (currentStream) {
                        currentStream.getTracks().forEach(track => track.stop());
                        currentStream = null;
                    }
                    cameraSection.style.display = 'none';
                    openCropModal(file);
                }
            }, 'image/jpeg', 0.95);
        }
    });

    // Close Camera
    closeCameraBtn.addEventListener('click', function() {
        if (currentStream) {
            currentStream.getTracks().forEach(track => track.stop());
            currentStream = null;
        }
        cameraSection.style.display = 'none';
    });

    // Remove Photo
    removePhotoBtn.addEventListener('click', function() {
        previewImg.src = '';
        imagePreview.style.display = 'none';
        photoFileInput.value = '';
        cameraSection.style.display = 'none';
    });

    // Crop Modal Functions
    function openCropModal(file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const modal = createCropModal(e.target.result);
            document.body.appendChild(modal);
            
            // Initialize Cropper
            const image = modal.querySelector('#crop-image');
            const brightnessSlider = modal.querySelector('#crop-brightness');
            const brightnessValue = modal.querySelector('#crop-brightness-value');
            const cropper = new Cropper(image, {
                aspectRatio: 5 / 6,
                viewMode: 1,
                autoCropArea: 1,
                responsive: true,
                background: false,
            });

            function applyBrightnessToCropperPreview(brightness) {
                modal.querySelectorAll('.cropper-container img').forEach((cropperImage) => {
                    cropperImage.style.filter = `brightness(${brightness}%)`;
                });
            }

            function updateBrightnessPreview() {
                const brightness = Number(brightnessSlider.value || 100);
                image.style.filter = `brightness(${brightness}%)`;
                applyBrightnessToCropperPreview(brightness);
                brightnessValue.textContent = `${brightness}%`;
            }

            brightnessSlider.addEventListener('input', updateBrightnessPreview);

            image.addEventListener('ready', updateBrightnessPreview, { once: true });

            function applyBrightnessToCanvas(sourceCanvas, brightness) {
                if (brightness === 100) {
                    return sourceCanvas;
                }

                const adjustedCanvas = document.createElement('canvas');
                adjustedCanvas.width = sourceCanvas.width;
                adjustedCanvas.height = sourceCanvas.height;

                const adjustedContext = adjustedCanvas.getContext('2d');
                adjustedContext.drawImage(sourceCanvas, 0, 0);

                const imageData = adjustedContext.getImageData(0, 0, adjustedCanvas.width, adjustedCanvas.height);
                const factor = brightness / 100;
                const data = imageData.data;

                for (let index = 0; index < data.length; index += 4) {
                    data[index] = Math.min(255, Math.round(data[index] * factor));
                    data[index + 1] = Math.min(255, Math.round(data[index + 1] * factor));
                    data[index + 2] = Math.min(255, Math.round(data[index + 2] * factor));
                }

                adjustedContext.putImageData(imageData, 0, 0);

                return adjustedCanvas;
            }

            setTimeout(updateBrightnessPreview, 50);

            // Handle Apply
            const cropApply = modal.querySelector('#crop-apply');
            cropApply.addEventListener('click', function() {
                const brightness = Number(brightnessSlider.value || 100);
                const croppedCanvas = cropper.getCroppedCanvas({
                    width: 300,
                    height: 360,
                    imageSmoothingQuality: 'high',
                });
                const outputCanvas = applyBrightnessToCanvas(croppedCanvas, brightness);

                outputCanvas.toBlob((blob) => {
                    // Create a new file from the blob
                    const croppedFile = new File([blob], "profile_photo.jpg", { type: "image/jpeg" });
                    
                    // Update the file input with the cropped file
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(croppedFile);
                    photoFileInput.files = dataTransfer.files;

                    // Update preview
                    previewImg.src = URL.createObjectURL(croppedFile);
                    imagePreview.style.display = 'block';
                    
                    // Cleanup
                    modal.remove();
                }, 'image/jpeg', 0.95);
            });

            // Handle Cancel
            const cropCancel = modal.querySelector('#crop-cancel');
            const closeBtn = modal.querySelector('.btn-close');
            const closeModal = () => {
                modal.remove();
                if (photoFileInput.files.length === 0 || photoFileInput.files[0] === file) {
                     photoFileInput.value = '';
                }
            };
            
            cropCancel.addEventListener('click', closeModal);
            closeBtn.addEventListener('click', closeModal);
        };
        reader.readAsDataURL(file);
    }

    function createCropModal(imageSrc) {
        const modal = document.createElement('div');
        modal.className = 'modal fade show';
        modal.style.display = 'block';
        modal.style.backgroundColor = 'rgba(0,0,0,0.5)';
        modal.setAttribute('role', 'dialog');
        modal.innerHTML = `
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Preview & Crop Image</h5>
                        <button type="button" class="btn-close" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="img-container" style="max-height: 60vh; overflow: hidden;">
                            <img id="crop-image" src="${imageSrc}" style="max-width: 100%; display: block;">
                        </div>
                        <div class="mt-3">
                            <label for="crop-brightness" class="form-label fw-semibold mb-1">Brightness</label>
                            <div class="d-flex align-items-center gap-2">
                                <input type="range" class="form-range m-0" id="crop-brightness" min="50" max="150" value="100" step="1">
                                <span id="crop-brightness-value" class="text-muted small" style="min-width: 48px;">100%</span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="crop-cancel">Cancel</button>
                        <button type="button" class="btn btn-success" id="crop-apply">Apply Crop</button>
                    </div>
                </div>
            </div>
        `;
        return modal;
    }
});

// Data Privacy Modal Handler
document.addEventListener('DOMContentLoaded', function() {
    const dataPrivacyModal = new bootstrap.Modal(document.getElementById('dataPrivacyModal'), {
        backdrop: 'static',
        keyboard: false
    });
    const privacyAgreement = document.getElementById('privacyAgreement');
    const acceptPrivacyBtn = document.getElementById('acceptPrivacyBtn');
    
    // Always show the modal on page load, except when success message is displayed
    @if (!session('success'))
        dataPrivacyModal.show();
    @endif
    
    // Toggle accept button based on checkbox
    privacyAgreement.addEventListener('change', function() {
        acceptPrivacyBtn.disabled = !this.checked;
    });
    
    // Handle accept button
    acceptPrivacyBtn.addEventListener('click', function() {
        if (privacyAgreement.checked) {
            dataPrivacyModal.hide();
        }
    });
});

// Signature functionality
document.addEventListener('DOMContentLoaded', function() {
    const signaturePreview = document.getElementById('signature-preview');
    const previewSignature = document.getElementById('preview-signature');
    const removeSignatureBtn = document.getElementById('remove-signature-btn');
    
    removeSignatureBtn.addEventListener('click', function() {
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
    
    // Function to resize canvas for responsive design
    function resizeSignatureCanvas() {
        const container = signatureCanvasLarge.parentElement;
        const width = Math.min(container.clientWidth - 4, 800); // 4px for border
        const height = Math.min(width * 0.5, 400); // Maintain aspect ratio
        
        if (signatureCanvasLarge.width !== width || signatureCanvasLarge.height !== height) {
            signatureCanvasLarge.width = width;
            signatureCanvasLarge.height = height;
            ctxLarge.clearRect(0, 0, signatureCanvasLarge.width, signatureCanvasLarge.height);
        }
    }
    
    // Initialize large canvas
    resizeSignatureCanvas();
    window.addEventListener('resize', resizeSignatureCanvas);
    
    // Resize canvas when modal is shown
    document.getElementById('signatureLargeModal').addEventListener('shown.bs.modal', function() {
        resizeSignatureCanvas();
        ctxLarge.clearRect(0, 0, signatureCanvasLarge.width, signatureCanvasLarge.height);
    });
    
    // Open large canvas modal
    drawSignatureLargeBtn.addEventListener('click', function() {
        signatureLargeModal.show();
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
        signatureCanvasLarge.toBlob(function(blob) {
            if (blob) {
                const file = new File([blob], "signature.png", { type: "image/png" });
                
                // Set the file in the file input
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                document.getElementById('signature-file-input').files = dataTransfer.files;
                
                // Update preview
                const dataURL = signatureCanvasLarge.toDataURL('image/png');
                previewSignature.src = dataURL;
                previewSignature.style.background = 'transparent';
                document.getElementById('signature-base64').value = dataURL;
                
                signaturePreview.style.display = 'block';
            }
        }, 'image/png');
        
        // Close modal
        signatureLargeModal.hide();
    });
});

// Event delegation for copy buttons - attached OUTSIDE DOMContentLoaded for immediate activation
document.addEventListener('click', function(e) {
    if (e.target.closest('.btn-copy')) {
        e.preventDefault();
        e.stopPropagation();
        
        const btn = e.target.closest('.btn-copy');
        const fieldId = btn.getAttribute('data-field');
        const field = document.getElementById(fieldId);
        
        if (field && field.value) {
            navigator.clipboard.writeText(field.value).then(() => {
                const originalIcon = btn.innerHTML;
                btn.innerHTML = '<i class="bi bi-check"></i>';
                btn.classList.add('btn-success');
                btn.classList.remove('btn-outline-secondary');
                
                setTimeout(() => {
                    btn.innerHTML = originalIcon;
                    btn.classList.remove('btn-success');
                    btn.classList.add('btn-outline-secondary');
                }, 2000);
            }).catch(err => console.error('Copy failed:', err));
        }
    }
}, false);

// Event delegation for toggle password buttons - attached OUTSIDE DOMContentLoaded for immediate activation
document.addEventListener('click', function(e) {
    if (e.target.closest('.btn-toggle-password')) {
        e.preventDefault();
        e.stopPropagation();
        
        const btn = e.target.closest('.btn-toggle-password');
        const fieldId = btn.getAttribute('data-field');
        const field = document.getElementById(fieldId);
        
        if (field) {
            const isPassword = field.type === 'password';
            field.type = isPassword ? 'text' : 'password';
            btn.innerHTML = isPassword ? '<i class="bi bi-eye-slash"></i>' : '<i class="bi bi-eye"></i>';
        }
    }
}, false);

// Refresh CSRF token every 30 minutes to prevent 419 on long form sessions
setInterval(function () {
    fetch('/csrf-refresh')
        .then(r => r.json())
        .then(data => {
            document.querySelectorAll('input[name="_token"]').forEach(el => el.value = data.token);
            const meta = document.querySelector('meta[name="csrf-token"]');
            if (meta) meta.setAttribute('content', data.token);
        })
        .catch(() => {});
}, 30 * 60 * 1000);

function confirmResidentSave(form) {
    form.classList.add('was-validated');

    if (!form.checkValidity()) {
        return false;
    }

    try {
        const sameAsAboveCheckbox = document.getElementById('same_as_above_address');
        const emergencyAddressDisplay = document.getElementById('emergency_address_display');
        const fullAddressDisplay = document.getElementById('full_address_display');

        if (sameAsAboveCheckbox && sameAsAboveCheckbox.checked && emergencyAddressDisplay && fullAddressDisplay) {
            emergencyAddressDisplay.value = fullAddressDisplay.value;
        }
    } catch (err) {
        console.warn('Save confirmation pre-submit error:', err);
    }

    return window.confirm('Are you sure you want to save this resident record?');
}
</script>

@endsection
