<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Public Registration - Barangay E-Services System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            background: white;
            min-height: 100vh;
            padding: 0;
            margin: 0;
        }
        .registration-container {
            width: 100%;
            min-height: 100vh;
        }
        .card {
            border-radius: 0 !important;
            height: 100%;
        }
    </style>
</head>
<body>
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

<div class="registration-container">
            <div class="card border-0 shadow-0">
                <div class="card-body p-5" style="overflow-y: auto; max-height: 100vh;">
                    <div class="text-center mb-4">
                        <h1 class="h3 fw-bold text-dark mb-0">Resident Registration</h1>
                        <p class="text-muted small mt-1">Create your account in the Barangay E-Services System</p>
                    </div>

                    @if (session('success'))
                        <!-- Success Message Page -->
                        <div class="text-center py-4">
                            <div class="mb-4">
                                <i class="bi bi-check-circle-fill text-success" style="font-size: 3rem;"></i>
                            </div>
                            <h4 class="fw-bold text-success mb-1">Registration Successful!</h4>
                            <p class="text-muted mb-3" style="font-size: 0.9rem;">{{ session('success') }}</p>
                            
                            @if (session('generated_account'))
                                <div class="alert alert-info mb-3 text-start" role="alert" style="font-size: 0.8rem; max-width: 500px; margin: 0 auto;">
                                    <div class="mb-2">
                                        <h6 class="fw-bold mb-2">Account Credentials</h6>
                                        <p class="mb-2 text-muted">Save these credentials securely. You can use them to log in to your account.</p>
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
                                <a href="{{ route('public.register') }}" class="btn btn-primary btn-sm" style="background-color: #0038A8; border-color: #0038A8; padding: 0.4rem 0.8rem; font-size: 0.8rem;">
                                    <i class="bi bi-plus-circle"></i> Register Another
                                </a>
                            </div>
                        </div>
                    @else
                        <!-- Registration Form -->
                        <form action="{{ route('public.register.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-2 mb-2">
                            <div class="col-md-4">
                                <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">First Name</label>
                                <input type="text" class="form-control form-control-sm @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required style="font-size: 0.8rem;">
                                @error('first_name')<div class="text-danger small" style="font-size: 0.65rem;">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Middle Name</label>
                                <input type="text" class="form-control form-control-sm" name="middle_name" value="{{ old('middle_name') }}" style="font-size: 0.8rem;">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Last Name</label>
                                <input type="text" class="form-control form-control-sm @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required style="font-size: 0.8rem;">
                                @error('last_name')<div class="text-danger small" style="font-size: 0.65rem;">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Suffix <span class="text-muted">(Optional)</span></label>
                                <select class="form-select form-select-sm" name="suffix" style="font-size: 0.8rem;">
                                    <option value="">None</option>
                                    <option value="Jr." {{ old('suffix') === 'Jr.' ? 'selected' : '' }}>Jr.</option>
                                    <option value="Sr." {{ old('suffix') === 'Sr.' ? 'selected' : '' }}>Sr.</option>
                                    <option value="II" {{ old('suffix') === 'II' ? 'selected' : '' }}>II</option>
                                    <option value="III" {{ old('suffix') === 'III' ? 'selected' : '' }}>III</option>
                                    <option value="IV" {{ old('suffix') === 'IV' ? 'selected' : '' }}>IV</option>
                                    <option value="V" {{ old('suffix') === 'V' ? 'selected' : '' }}>V</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Birth Date</label>
                                <input type="date" class="form-control form-control-sm @error('birth_date') is-invalid @enderror" name="birth_date" value="{{ old('birth_date') }}" required max="{{ date('Y-m-d') }}" style="font-size: 0.8rem;">
                                @error('birth_date')<div class="text-danger small" style="font-size: 0.65rem;">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Gender</label>
                                <select class="form-select form-select-sm @error('gender') is-invalid @enderror" name="gender" required style="font-size: 0.8rem;">
                                    <option value="">Select...</option>
                                    <option value="Male" {{ old('gender') === 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender') === 'Female' ? 'selected' : '' }}>Female</option>
                                </select>
                                @error('gender')<div class="text-danger small" style="font-size: 0.65rem;">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Civil Status</label>
                                <select class="form-select form-select-sm @error('civil_status') is-invalid @enderror" name="civil_status" required style="font-size: 0.8rem;">
                                    <option value="">Select...</option>
                                    <option value="Single" {{ old('civil_status') === 'Single' ? 'selected' : '' }}>Single</option>
                                    <option value="Married" {{ old('civil_status') === 'Married' ? 'selected' : '' }}>Married</option>
                                    <option value="Widowed" {{ old('civil_status') === 'Widowed' ? 'selected' : '' }}>Widowed</option>
                                    <option value="Separated" {{ old('civil_status') === 'Separated' ? 'selected' : '' }}>Separated</option>
                                </select>
                                @error('civil_status')<div class="text-danger small" style="font-size: 0.65rem;">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Nationality</label>
                                <select class="form-select form-select-sm" name="nationality" style="font-size: 0.8rem;">
                                    <option value="Filipino" {{ old('nationality', 'Filipino') === 'Filipino' ? 'selected' : '' }}>Filipino</option>
                                    <option value="Other" {{ old('nationality') === 'Other' ? 'selected' : '' }}>Other</option>
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
                                    <option value="A+" {{ old('blood_type') === 'A+' ? 'selected' : '' }}>A+</option>
                                    <option value="A-" {{ old('blood_type') === 'A-' ? 'selected' : '' }}>A-</option>
                                    <option value="B+" {{ old('blood_type') === 'B+' ? 'selected' : '' }}>B+</option>
                                    <option value="B-" {{ old('blood_type') === 'B-' ? 'selected' : '' }}>B-</option>
                                    <option value="AB+" {{ old('blood_type') === 'AB+' ? 'selected' : '' }}>AB+</option>
                                    <option value="AB-" {{ old('blood_type') === 'AB-' ? 'selected' : '' }}>AB-</option>
                                    <option value="O+" {{ old('blood_type') === 'O+' ? 'selected' : '' }}>O+</option>
                                    <option value="O-" {{ old('blood_type') === 'O-' ? 'selected' : '' }}>O-</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check mt-4">
                                    <input class="form-check-input" type="checkbox" name="is_head_of_family" id="is_head_of_family" value="1" {{ old('is_head_of_family') ? 'checked' : '' }} style="font-size: 0.8rem;">
                                    <label class="form-check-label text-muted small fw-bold" for="is_head_of_family" style="font-size: 0.65rem;">Head of Family</label>
                                    <small class="text-muted d-block mt-1" style="font-size: 0.65rem;">Check if this person is the head of the family</small>
                                </div>
                            </div>
                        </div>

                        <h6 class="fw-bold mb-2 mt-2" style="font-size: 0.8rem;">Address</h6>
                        <div class="row g-2 mb-2">
                            <div class="col-md-6">
                                <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">House No</label>
                                <input type="text" class="form-control form-control-sm address-field" name="house_no" value="{{ old('house_no') }}" placeholder="Optional" style="font-size: 0.8rem;">
                                <small class="text-muted d-block mt-1" style="font-size: 0.65rem;">Optional</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Street Name</label>
                                <select class="form-select form-select-sm address-field" name="street_name" style="font-size: 0.8rem;">
                                    <option value="">Select Street...</option>
                                    <option value="A.V Jimenez St" {{ old('street_name') === 'A.V Jimenez St' ? 'selected' : '' }}>A.V Jimenez St</option>
                                    <option value="Acacia St" {{ old('street_name') === 'Acacia St' ? 'selected' : '' }}>Acacia St</option>
                                    <option value="Alley 1 St" {{ old('street_name') === 'Alley 1 St' ? 'selected' : '' }}>Alley 1 St</option>
                                    <option value="Alley 2 St" {{ old('street_name') === 'Alley 2 St' ? 'selected' : '' }}>Alley 2 St</option>
                                    <option value="Anonas St" {{ old('street_name') === 'Anonas St' ? 'selected' : '' }}>Anonas St</option>
                                    <option value="Atis St" {{ old('street_name') === 'Atis St' ? 'selected' : '' }}>Atis St</option>
                                    <option value="Avocado St" {{ old('street_name') === 'Avocado St' ? 'selected' : '' }}>Avocado St</option>
                                    <option value="Axis Road" {{ old('street_name') === 'Axis Road' ? 'selected' : '' }}>Axis Road</option>
                                    <option value="Balimbing St" {{ old('street_name') === 'Balimbing St' ? 'selected' : '' }}>Balimbing St</option>
                                    <option value="Bayabas St" {{ old('street_name') === 'Bayabas St' ? 'selected' : '' }}>Bayabas St</option>
                                    <option value="Bornay Hoa" {{ old('street_name') === 'Bornay Hoa' ? 'selected' : '' }}>Bornay Hoa</option>
                                    <option value="C. Bornay St" {{ old('street_name') === 'C. Bornay St' ? 'selected' : '' }}>C. Bornay St</option>
                                    <option value="Calachuchi St" {{ old('street_name') === 'Calachuchi St' ? 'selected' : '' }}>Calachuchi St</option>
                                    <option value="Camachile St" {{ old('street_name') === 'Camachile St' ? 'selected' : '' }}>Camachile St</option>
                                    <option value="Camia St" {{ old('street_name') === 'Camia St' ? 'selected' : '' }}>Camia St</option>
                                    <option value="Carnation St" {{ old('street_name') === 'Carnation St' ? 'selected' : '' }}>Carnation St</option>
                                    <option value="Casoy St" {{ old('street_name') === 'Casoy St' ? 'selected' : '' }}>Casoy St</option>
                                    <option value="Castillo St" {{ old('street_name') === 'Castillo St' ? 'selected' : '' }}>Castillo St</option>
                                    <option value="Chico St" {{ old('street_name') === 'Chico St' ? 'selected' : '' }}>Chico St</option>
                                    <option value="D.M Tuazon St" {{ old('street_name') === 'D.M Tuazon St' ? 'selected' : '' }}>D.M Tuazon St</option>
                                    <option value="Dalandan St" {{ old('street_name') === 'Dalandan St' ? 'selected' : '' }}>Dalandan St</option>
                                    <option value="Dhalia St" {{ old('street_name') === 'Dhalia St' ? 'selected' : '' }}>Dhalia St</option>
                                    <option value="Dolmar Subd." {{ old('street_name') === 'Dolmar Subd.' ? 'selected' : '' }}>Dolmar Subd.</option>
                                    <option value="Duhat St" {{ old('street_name') === 'Duhat St' ? 'selected' : '' }}>Duhat St</option>
                                    <option value="Durian St" {{ old('street_name') === 'Durian St' ? 'selected' : '' }}>Durian St</option>
                                    <option value="Elisco Road" {{ old('street_name') === 'Elisco Road' ? 'selected' : '' }}>Elisco Road</option>
                                    <option value="Gumamela St" {{ old('street_name') === 'Gumamela St' ? 'selected' : '' }}>Gumamela St</option>
                                    <option value="Guyabano St" {{ old('street_name') === 'Guyabano St' ? 'selected' : '' }}>Guyabano St</option>
                                    <option value="Ilang Ilang St" {{ old('street_name') === 'Ilang Ilang St' ? 'selected' : '' }}>Ilang Ilang St</option>
                                    <option value="Ipil St" {{ old('street_name') === 'Ipil St' ? 'selected' : '' }}>Ipil St</option>
                                    <option value="Ismar" {{ old('street_name') === 'Ismar' ? 'selected' : '' }}>Ismar</option>
                                    <option value="Jabson1" {{ old('street_name') === 'Jabson1' ? 'selected' : '' }}>Jabson1</option>
                                    <option value="Jabson2" {{ old('street_name') === 'Jabson2' ? 'selected' : '' }}>Jabson2</option>
                                    <option value="Javier Comp St" {{ old('street_name') === 'Javier Comp St' ? 'selected' : '' }}>Javier Comp St</option>
                                    <option value="Kamias St" {{ old('street_name') === 'Kamias St' ? 'selected' : '' }}>Kamias St</option>
                                    <option value="Kamagong St" {{ old('street_name') === 'Kamagong St' ? 'selected' : '' }}>Kamagong St</option>
                                    <option value="Kayumito St" {{ old('street_name') === 'Kayumito St' ? 'selected' : '' }}>Kayumito St</option>
                                    <option value="Langka St" {{ old('street_name') === 'Langka St' ? 'selected' : '' }}>Langka St</option>
                                    <option value="Lansones St" {{ old('street_name') === 'Lansones St' ? 'selected' : '' }}>Lansones St</option>
                                    <option value="M. Castillo St" {{ old('street_name') === 'M. Castillo St' ? 'selected' : '' }}>M. Castillo St</option>
                                    <option value="M. Jimenez St" {{ old('street_name') === 'M. Jimenez St' ? 'selected' : '' }}>M. Jimenez St</option>
                                    <option value="Maasikaso St" {{ old('street_name') === 'Maasikaso St' ? 'selected' : '' }}>Maasikaso St</option>
                                    <option value="Maayos St" {{ old('street_name') === 'Maayos St' ? 'selected' : '' }}>Maayos St</option>
                                    <option value="Macopa St" {{ old('street_name') === 'Macopa St' ? 'selected' : '' }}>Macopa St</option>
                                    <option value="Mahogany St" {{ old('street_name') === 'Mahogany St' ? 'selected' : '' }}>Mahogany St</option>
                                    <option value="Mangga Ave St" {{ old('street_name') === 'Mangga Ave St' ? 'selected' : '' }}>Mangga Ave St</option>
                                    <option value="Mansanas St" {{ old('street_name') === 'Mansanas St' ? 'selected' : '' }}>Mansanas St</option>
                                    <option value="Mapag Mahal St" {{ old('street_name') === 'Mapag Mahal St' ? 'selected' : '' }}>Mapag Mahal St</option>
                                    <option value="Masipag St" {{ old('street_name') === 'Masipag St' ? 'selected' : '' }}>Masipag St</option>
                                    <option value="Masunurin St" {{ old('street_name') === 'Masunurin St' ? 'selected' : '' }}>Masunurin St</option>
                                    <option value="Maunawain St" {{ old('street_name') === 'Maunawain St' ? 'selected' : '' }}>Maunawain St</option>
                                    <option value="Melon St" {{ old('street_name') === 'Melon St' ? 'selected' : '' }}>Melon St</option>
                                    <option value="N. Cuevas St" {{ old('street_name') === 'N. Cuevas St' ? 'selected' : '' }}>N. Cuevas St</option>
                                    <option value="Nara St" {{ old('street_name') === 'Nara St' ? 'selected' : '' }}>Nara St</option>
                                    <option value="Orchids St" {{ old('street_name') === 'Orchids St' ? 'selected' : '' }}>Orchids St</option>
                                    <option value="Pag Asa St" {{ old('street_name') === 'Pag Asa St' ? 'selected' : '' }}>Pag Asa St</option>
                                    <option value="Papaya St" {{ old('street_name') === 'Papaya St' ? 'selected' : '' }}>Papaya St</option>
                                    <option value="Paulino St" {{ old('street_name') === 'Paulino St' ? 'selected' : '' }}>Paulino St</option>
                                    <option value="Pinya St" {{ old('street_name') === 'Pinya St' ? 'selected' : '' }}>Pinya St</option>
                                    <option value="R. Castillo St" {{ old('street_name') === 'R. Castillo St' ? 'selected' : '' }}>R. Castillo St</option>
                                    <option value="R.Tatco St" {{ old('street_name') === 'R.Tatco St' ? 'selected' : '' }}>R.Tatco St</option>
                                    <option value="Rambutan St" {{ old('street_name') === 'Rambutan St' ? 'selected' : '' }}>Rambutan St</option>
                                    <option value="Rose St" {{ old('street_name') === 'Rose St' ? 'selected' : '' }}>Rose St</option>
                                    <option value="S. Cuevas St" {{ old('street_name') === 'S. Cuevas St' ? 'selected' : '' }}>S. Cuevas St</option>
                                    <option value="Sampaloc St" {{ old('street_name') === 'Sampaloc St' ? 'selected' : '' }}>Sampaloc St</option>
                                    <option value="Sampaguita St" {{ old('street_name') === 'Sampaguita St' ? 'selected' : '' }}>Sampaguita St</option>
                                    <option value="San Agustin Road" {{ old('street_name') === 'San Agustin Road' ? 'selected' : '' }}>San Agustin Road</option>
                                    <option value="San Flower St" {{ old('street_name') === 'San Flower St' ? 'selected' : '' }}>San Flower St</option>
                                    <option value="San Pedro St" {{ old('street_name') === 'San Pedro St' ? 'selected' : '' }}>San Pedro St</option>
                                    <option value="Santan St" {{ old('street_name') === 'Santan St' ? 'selected' : '' }}>Santan St</option>
                                    <option value="Santol St" {{ old('street_name') === 'Santol St' ? 'selected' : '' }}>Santol St</option>
                                    <option value="Sikap Compound St" {{ old('street_name') === 'Sikap Compound St' ? 'selected' : '' }}>Sikap Compound St</option>
                                    <option value="Suha St" {{ old('street_name') === 'Suha St' ? 'selected' : '' }}>Suha St</option>
                                    <option value="Talisay St" {{ old('street_name') === 'Talisay St' ? 'selected' : '' }}>Talisay St</option>
                                    <option value="Tanguile St" {{ old('street_name') === 'Tanguile St' ? 'selected' : '' }}>Tanguile St</option>
                                    <option value="Ubas St" {{ old('street_name') === 'Ubas St' ? 'selected' : '' }}>Ubas St</option>
                                    <option value="Ugong St" {{ old('street_name') === 'Ugong St' ? 'selected' : '' }}>Ugong St</option>
                                    <option value="Uyvico St" {{ old('street_name') === 'Uyvico St' ? 'selected' : '' }}>Uyvico St</option>
                                    <option value="Visitacion St" {{ old('street_name') === 'Visitacion St' ? 'selected' : '' }}>Visitacion St</option>
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
                                <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Mobile Number</label>
                                <input type="text" class="form-control form-control-sm mobile-number @error('contact_number') is-invalid @enderror" name="contact_number" value="{{ old('contact_number') }}" placeholder="e.g., 09123456789" inputmode="numeric" maxlength="11" pattern="[0-9]{11}" style="font-size: 0.8rem;">
                                <small class="text-muted d-block mt-1" style="font-size: 0.65rem;">Must be exactly 11 digits</small>
                                @error('contact_number')<div class="text-danger small" style="font-size: 0.65rem;">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Telephone No</label>
                                <input type="text" class="form-control form-control-sm telephone-number" name="telephone_no" value="{{ old('telephone_no') }}" placeholder="Optional" style="font-size: 0.8rem;">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Email</label>
                                <input type="email" class="form-control form-control-sm @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Optional" style="font-size: 0.8rem;">
                                @error('email')<div class="text-danger small" style="font-size: 0.65rem;">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <h6 class="fw-bold mb-2 mt-2" style="font-size: 0.8rem;">Emergency Contact</h6>
                        <div class="row g-2 mb-2">
                            <div class="col-md-6">
                                <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Name</label>
                                <input type="text" class="form-control form-control-sm" name="emergency_contact_name" value="{{ old('emergency_contact_name') }}" style="font-size: 0.8rem;">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Relationship</label>
                                <select class="form-select form-select-sm" name="emergency_contact_relationship" style="font-size: 0.8rem;">
                                    <option value="">Select...</option>
                                    <option value="Husband" {{ old('emergency_contact_relationship') === 'Husband' ? 'selected' : '' }}>Husband</option>
                                    <option value="Wife" {{ old('emergency_contact_relationship') === 'Wife' ? 'selected' : '' }}>Wife</option>
                                    <option value="Partner" {{ old('emergency_contact_relationship') === 'Partner' ? 'selected' : '' }}>Partner</option>
                                    <option value="Mother" {{ old('emergency_contact_relationship') === 'Mother' ? 'selected' : '' }}>Mother</option>
                                    <option value="Father" {{ old('emergency_contact_relationship') === 'Father' ? 'selected' : '' }}>Father</option>
                                    <option value="Sibling" {{ old('emergency_contact_relationship') === 'Sibling' ? 'selected' : '' }}>Sibling</option>
                                    <option value="Grandparent" {{ old('emergency_contact_relationship') === 'Grandparent' ? 'selected' : '' }}>Grandparent</option>
                                    <option value="Cousin" {{ old('emergency_contact_relationship') === 'Cousin' ? 'selected' : '' }}>Cousin</option>
                                    <option value="Other" {{ old('emergency_contact_relationship') === 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Contact Number</label>
                                <input type="text" class="form-control form-control-sm mobile-number" name="emergency_contact_no" value="{{ old('emergency_contact_no') }}" placeholder="e.g., 09123456789" inputmode="numeric" maxlength="11" pattern="[0-9]{11}" style="font-size: 0.8rem;">
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
                                <textarea class="form-control form-control-sm" id="emergency_address_display" name="emergency_contact_address" rows="2" style="font-size: 0.8rem;">{{ old('emergency_contact_address') }}</textarea>
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
                                @error('profile_image')
                                    <div class="alert alert-danger mt-1 mb-0" style="font-size: 0.75rem; padding: 0.4rem 0.6rem;">{{ $message }}</div>
                                @enderror
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
                                @error('signature')
                                    <div class="alert alert-danger mt-1 mb-0" style="font-size: 0.75rem; padding: 0.4rem 0.6rem;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-2">

                        <div class="alert alert-info mb-2" role="alert" style="font-size: 0.75rem; padding: 0.4rem 0.6rem;">
                            <i class="bi bi-info-circle"></i> After registration, system will auto-generate your username and password.
                        </div>

                        <div class="text-end d-flex gap-2 justify-content-end">
                            <a href="{{ route('login') }}" class="btn btn-secondary btn-sm" style="padding: 0.4rem 0.8rem; font-size: 0.8rem;">Back</a>
                            <button type="submit" class="btn btn-primary btn-sm px-3" style="background-color: #0038A8; border-color: #0038A8; padding: 0.4rem 0.8rem; font-size: 0.8rem;">Register</button>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
        </div>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

<script>
// Data Privacy Modal Handler
window.addEventListener('load', function() {
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
    const birthDateInput = document.querySelector('input[name="birth_date"]');
    
    // Add input validation to restrict birth date input length
    birthDateInput.addEventListener('input', function(e) {
        // Ensure the input doesn't exceed 10 characters (YYYY-MM-DD format)
        if (this.value.length > 10) {
            this.value = this.value.slice(0, 10);
        }
    });
    
    function calculateAge(birthDate) {
        const today = new Date();
        let age = today.getFullYear() - birthDate.getFullYear();
        const monthDifference = today.getMonth() - birthDate.getMonth();
        
        if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        return age;
    }
    
    // Trigger validation on both change and blur events for better responsiveness
    birthDateInput.addEventListener('change', function() {});
    birthDateInput.addEventListener('blur', function() {});
    
    // Auto-fill full address from address components
    const addressFields = document.querySelectorAll('.address-field');
    const fullAddressDisplay = document.getElementById('full_address_display');
    
    function updateFullAddress() {
        const houseNo = document.querySelector('input[name="house_no"]').value;
        const streetName = document.querySelector('select[name="street_name"]').value;
        const province = document.querySelector('select[name="province"]').value;
        
        const addressParts = [];
        if (houseNo) addressParts.push(houseNo);
        if (streetName) addressParts.push(streetName);
        if (province) addressParts.push(province);
        
        fullAddressDisplay.value = addressParts.join(', ') || '';
    }
    
    addressFields.forEach(field => {
        field.addEventListener('change', updateFullAddress);
        field.addEventListener('input', updateFullAddress);
    });
    
    // Handle "Same as above" checkbox for emergency contact address
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
            const cropper = new Cropper(image, {
                aspectRatio: 5 / 6,
                viewMode: 1,
                autoCropArea: 1,
                responsive: true,
                background: false,
            });

            // Handle Apply
            const cropApply = modal.querySelector('#crop-apply');
            cropApply.addEventListener('click', function() {
                cropper.getCroppedCanvas({
                    width: 300,
                    height: 360,
                    imageSmoothingQuality: 'high',
                }).toBlob((blob) => {
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
</script>
</body>
</html>
