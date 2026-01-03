<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Public Registration - Barangay Management System</title>
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
<div class="registration-container">
            <div class="card border-0 shadow-0">
                <div class="card-body p-5" style="overflow-y: auto; max-height: 100vh;">
                    <div class="text-center mb-4">
                        <h1 class="h3 fw-bold text-dark mb-0">Resident Registration</h1>
                        <p class="text-muted small mt-1">Create your account in the Barangay Management System</p>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert" style="font-size: 0.75rem; padding: 0.6rem 0.8rem;">
                            <i class="bi bi-check-circle-fill"></i>
                            <strong>{{ session('success') }}</strong>
                            @if (session('generated_account'))
                                <hr class="my-2">
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
                                    <p class="small text-success mt-2 mb-0" style="font-size: 0.7rem;"><i class="bi bi-info-circle"></i> Please save these credentials securely. You can use them to log in.</p>
                                </div>
                            @endif
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('public.register.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <h6 class="fw-bold mb-2 mt-0" style="font-size: 0.8rem;">Personal Information</h6>
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
                                <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Birth Date</label>
                                <input type="date" class="form-control form-control-sm @error('birth_date') is-invalid @enderror" name="birth_date" value="{{ old('birth_date') }}" required style="font-size: 0.8rem;">
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
                                    <option value="Filipino" {{ old('nationality') === 'Filipino' ? 'selected' : '' }}>Filipino</option>
                                    <option value="Other" {{ old('nationality') === 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Blood Type</label>
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
                                <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Special Sector</label>
                                <select class="form-select form-select-sm" name="special_sector" style="font-size: 0.8rem;">
                                    <option value="">Select...</option>
                                    <option value="Senior Citizen" {{ old('special_sector') === 'Senior Citizen' ? 'selected' : '' }}>Senior Citizen</option>
                                    <option value="PWD" {{ old('special_sector') === 'PWD' ? 'selected' : '' }}>PWD</option>
                                    <option value="Solo Parent" {{ old('special_sector') === 'Solo Parent' ? 'selected' : '' }}>Solo Parent</option>
                                </select>
                            </div>
                        </div>

                        <h6 class="fw-bold mb-2 mt-2" style="font-size: 0.8rem;">Address</h6>
                        <div class="row g-2 mb-2">
                            <div class="col-md-6">
                                <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">House No.</label>
                                <input type="text" class="form-control form-control-sm" name="house_no" value="{{ old('house_no') }}" placeholder="e.g., #45 or 12" style="font-size: 0.8rem;">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Street Name</label>
                                <select class="form-select form-select-sm" name="street_name" style="font-size: 0.8rem;">
                                    <option value="">Select Street...</option>
                                    <option value="Roxas St." {{ old('street_name') === 'Roxas St.' ? 'selected' : '' }}>Roxas St.</option>
                                    <option value="Osmena St." {{ old('street_name') === 'Osmena St.' ? 'selected' : '' }}>Osmena St.</option>
                                    <option value="Del Pilar St." {{ old('street_name') === 'Del Pilar St.' ? 'selected' : '' }}>Del Pilar St.</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Purok</label>
                                <select class="form-select form-select-sm" name="purok" style="font-size: 0.8rem;">
                                    <option value="">Select Purok...</option>
                                    <option value="Purok 1" {{ old('purok') === 'Purok 1' ? 'selected' : '' }}>Purok 1</option>
                                    <option value="Purok 2" {{ old('purok') === 'Purok 2' ? 'selected' : '' }}>Purok 2</option>
                                    <option value="Purok 3" {{ old('purok') === 'Purok 3' ? 'selected' : '' }}>Purok 3</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Province</label>
                                <select class="form-select form-select-sm" name="province" style="font-size: 0.8rem;">
                                    <option value="">Select Province...</option>
                                    <option value="Metro Manila" {{ old('province') === 'Metro Manila' ? 'selected' : '' }}>Metro Manila</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">City/Municipality</label>
                                <select class="form-select form-select-sm" name="municipality" style="font-size: 0.8rem;">
                                    <option value="">Select City...</option>
                                    <option value="Pasig City" {{ old('municipality') === 'Pasig City' ? 'selected' : '' }}>Pasig City</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Zip Code</label>
                                <input type="text" class="form-control form-control-sm" name="zip_code" value="{{ old('zip_code') }}" placeholder="e.g., 1600" style="font-size: 0.8rem;">
                            </div>
                        </div>

                        <h6 class="fw-bold mb-2 mt-2" style="font-size: 0.8rem;">Contact Information</h6>
                        <div class="row g-2 mb-2">
                            <div class="col-md-6">
                                <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Mobile Number</label>
                                <input type="text" class="form-control form-control-sm @error('contact_number') is-invalid @enderror" name="contact_number" value="{{ old('contact_number') }}" placeholder="e.g., 09123456789" style="font-size: 0.8rem;">
                                @error('contact_number')<div class="text-danger small" style="font-size: 0.65rem;">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Telephone No</label>
                                <input type="text" class="form-control form-control-sm" name="telephone_no" value="{{ old('telephone_no') }}" placeholder="Optional" style="font-size: 0.8rem;">
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
                                    <option value="Mother" {{ old('emergency_contact_relationship') === 'Mother' ? 'selected' : '' }}>Mother</option>
                                    <option value="Father" {{ old('emergency_contact_relationship') === 'Father' ? 'selected' : '' }}>Father</option>
                                    <option value="Spouse" {{ old('emergency_contact_relationship') === 'Spouse' ? 'selected' : '' }}>Spouse</option>
                                    <option value="Child" {{ old('emergency_contact_relationship') === 'Child' ? 'selected' : '' }}>Child</option>
                                    <option value="Sibling" {{ old('emergency_contact_relationship') === 'Sibling' ? 'selected' : '' }}>Sibling</option>
                                    <option value="Friend" {{ old('emergency_contact_relationship') === 'Friend' ? 'selected' : '' }}>Friend</option>
                                    <option value="Other" {{ old('emergency_contact_relationship') === 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Contact Number</label>
                                <input type="text" class="form-control form-control-sm" name="emergency_contact_no" value="{{ old('emergency_contact_no') }}" placeholder="e.g., 09123456789" style="font-size: 0.8rem;">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Address</label>
                                <textarea class="form-control form-control-sm" name="emergency_contact_address" rows="2" style="font-size: 0.8rem;">{{ old('emergency_contact_address') }}</textarea>
                            </div>
                        </div>

                        <h6 class="fw-bold mb-2 mt-2" style="font-size: 0.8rem;">Profile Picture (Optional)</h6>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <div class="card border-light bg-light">
                                    <div class="card-body p-2">
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
                                            
                                            <div id="image-preview" style="display: none;" class="mt-2">
                                                <img id="preview-img" src="" alt="Preview" style="max-width: 150px; max-height: 150px; border-radius: 6px; border: 2px solid #dee2e6;">
                                                <div class="mt-1 d-flex gap-1">
                                                    <button type="button" class="btn btn-sm btn-warning" id="crop-btn" style="font-size: 0.7rem; padding: 0.2rem 0.4rem;">
                                                        <i class="bi bi-crop"></i> Crop
                                                    </button>
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
                        </div>

                        <hr class="my-2">

                        <div class="text-end d-flex gap-2 justify-content-end">
                            <a href="{{ route('login') }}" class="btn btn-secondary btn-sm" style="padding: 0.4rem 0.8rem; font-size: 0.8rem;">Back</a>
                            <button type="submit" class="btn btn-primary btn-sm px-3" style="background-color: #0038A8; border-color: #0038A8; padding: 0.4rem 0.8rem; font-size: 0.8rem;">Register</button>
                        </div>
                    </form>

                    <div class="alert alert-info mt-3 mb-0" role="alert" style="font-size: 0.75rem; padding: 0.4rem 0.6rem;">
                        <i class="bi bi-info-circle"></i> After registration, system will auto-generate your username and password.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>

<script>
// Photo Upload/Capture Script
document.addEventListener('DOMContentLoaded', function() {
    // Copy to clipboard functionality
    document.querySelectorAll('.btn-copy').forEach(btn => {
        btn.addEventListener('click', function() {
            const fieldId = this.getAttribute('data-field');
            const field = document.getElementById(fieldId);
            
            navigator.clipboard.writeText(field.value).then(() => {
                const originalIcon = this.innerHTML;
                this.innerHTML = '<i class="bi bi-check"></i>';
                this.classList.add('btn-success');
                this.classList.remove('btn-outline-secondary');
                
                setTimeout(() => {
                    this.innerHTML = originalIcon;
                    this.classList.remove('btn-success');
                    this.classList.add('btn-outline-secondary');
                }, 2000);
            });
        });
    });

    // Toggle password visibility
    document.querySelectorAll('.btn-toggle-password').forEach(btn => {
        btn.addEventListener('click', function() {
            const fieldId = this.getAttribute('data-field');
            const field = document.getElementById(fieldId);
            const isPassword = field.type === 'password';
            
            field.type = isPassword ? 'text' : 'password';
            this.innerHTML = isPassword ? '<i class="bi bi-eye-slash"></i>' : '<i class="bi bi-eye"></i>';
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
    const cropBtn = document.getElementById('crop-btn');
    let currentStream = null;
    let originalFile = null;

    // Upload Photo Handler
    uploadBtn.addEventListener('click', function() {
        photoFileInput.click();
    });

    photoFileInput.addEventListener('change', function(e) {
        if (e.target.files && e.target.files.length > 0) {
            const file = e.target.files[0];
            originalFile = file;
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
                    originalFile = file;
                    
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

    // Crop Button Handler
    cropBtn.addEventListener('click', function() {
        if (originalFile) {
            openCropModal(originalFile);
        }
    });

    // Remove Photo
    removePhotoBtn.addEventListener('click', function() {
        previewImg.src = '';
        imagePreview.style.display = 'none';
        photoFileInput.value = '';
        originalFile = null;
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
                aspectRatio: 1,
                viewMode: 1,
                dragMode: 'move',
                autoCropArea: 1,
                restore: false,
                guides: false,
                center: true,
                highlight: false,
                cropBoxMovable: false,
                cropBoxResizable: false,
                toggleDragModeOnDblclick: false,
            });

            // Handle Apply
            const cropApply = modal.querySelector('#crop-apply');
            cropApply.addEventListener('click', function() {
                cropper.getCroppedCanvas({
                    width: 400,
                    height: 400,
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
                if (photoFileInput.files.length === 0) {
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
        modal.style.zIndex = '9999';
        modal.innerHTML = `
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Adjust Image</h5>
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
</script>
</body>
</html>
