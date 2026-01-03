@extends('layouts.app')

@section('title', 'Add Resident')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-2">
    <h1 class="h6 fw-bold text-dark mb-0" style="font-size: 0.9rem;">Add Resident</h1>
    <a href="{{ route('residents.index') }}" class="btn btn-success btn-sm d-flex align-items-center gap-1" style="background-color: #198754; border-color: #198754; padding: 0.3rem 0.6rem; font-size: 0.75rem;">
        <i class="bi bi-arrow-left"></i> Back
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-2">
        <form action="{{ route('residents.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row g-2 mb-2">
                <div class="col-md-4">
                    <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">First Name</label>
                    <input type="text" class="form-control form-control-sm" name="first_name" required style="font-size: 0.8rem;">
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Middle Name</label>
                    <input type="text" class="form-control form-control-sm" name="middle_name" style="font-size: 0.8rem;">
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Last Name</label>
                    <input type="text" class="form-control form-control-sm" name="last_name" required style="font-size: 0.8rem;">
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Birth Date</label>
                    <input type="date" class="form-control form-control-sm" name="birth_date" required style="font-size: 0.8rem;">
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Gender</label>
                    <select class="form-select form-select-sm" name="gender" required style="font-size: 0.8rem;">
                        <option value="">Select...</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Civil Status</label>
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
                    <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Special Sector</label>
                    <select class="form-select form-select-sm" name="special_sector" style="font-size: 0.8rem;">
                        <option value="">Select...</option>
                        <option value="Senior Citizen">Senior Citizen</option>
                        <option value="PWD">PWD</option>
                        <option value="Solo Parent">Solo Parent</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Barangay</label>
                    <input type="text" class="form-control form-control-sm" name="barangay" value="Kalawaan" readonly style="font-size: 0.8rem;">
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Blood Type</label>
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
            </div>

            <h6 class="fw-bold mb-2 mt-2" style="font-size: 0.8rem;">Address</h6>
            <div class="row g-2 mb-2">
                <div class="col-md-6">
                    <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">House No.</label>
                    <input type="text" class="form-control form-control-sm" name="house_no" placeholder="e.g., #45 or 12" style="font-size: 0.8rem;">
                </div>
                <div class="col-md-6">
                    <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Street Name</label>
                    <select class="form-select form-select-sm" name="street_name" style="font-size: 0.8rem;">
                        <option value="">Select Street...</option>
                        <option value="Roxas St.">Roxas St.</option>
                        <option value="Osmena St.">Osmena St.</option>
                        <option value="Del Pilar St.">Del Pilar St.</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Purok</label>
                    <select class="form-select form-select-sm" name="purok" style="font-size: 0.8rem;">
                        <option value="">Select Purok...</option>
                        <option value="Purok 1">Purok 1</option>
                        <option value="Purok 2">Purok 2</option>
                        <option value="Purok 3">Purok 3</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Province</label>
                    <select class="form-select form-select-sm" name="province" style="font-size: 0.8rem;">
                        <option value="">Select Province...</option>
                        <option value="Metro Manila">Metro Manila</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Zip Code</label>
                    <input type="text" class="form-control form-control-sm" name="zip_code" placeholder="e.g., 3022" style="font-size: 0.8rem;">
                </div>
            </div>

            <h6 class="fw-bold mb-2 mt-2" style="font-size: 0.8rem;">Contact Information</h6>
            <div class="row g-2 mb-2">
                <div class="col-md-6">
                    <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Mobile Number</label>
                    <input type="text" class="form-control form-control-sm" name="contact_number" placeholder="e.g., 09123456789" style="font-size: 0.8rem;">
                    @if ($errors->has('contact_number'))
                        <div class="text-danger small mt-1" style="font-size: 0.65rem;">{{ $errors->first('contact_number') }}</div>
                    @endif
                </div>
                <div class="col-md-6">
                    <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Telephone No</label>
                    <input type="text" class="form-control form-control-sm" name="telephone_no" placeholder="Optional" style="font-size: 0.8rem;">
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
                        <option value="Mother">Mother</option>
                        <option value="Father">Father</option>
                        <option value="Spouse">Spouse</option>
                        <option value="Child">Child</option>
                        <option value="Sibling">Sibling</option>
                        <option value="Grandparent">Grandparent</option>
                        <option value="Grandchild">Grandchild</option>
                        <option value="Aunt/Uncle">Aunt/Uncle</option>
                        <option value="Cousin">Cousin</option>
                        <option value="Friend">Friend</option>
                        <option value="Neighbor">Neighbor</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Contact Number</label>
                    <input type="text" class="form-control form-control-sm" name="emergency_contact_no" placeholder="e.g., 09123456789" style="font-size: 0.8rem;">
                </div>
                <div class="col-md-12">
                    <label class="form-label text-muted small text-uppercase fw-bold" style="font-size: 0.6rem;">Address</label>
                    <textarea class="form-control form-control-sm" name="emergency_contact_address" rows="2" style="font-size: 0.8rem;"></textarea>
                </div>
            </div>

            <h6 class="fw-bold mb-2 mt-2" style="font-size: 0.8rem;">Profile Picture</h6>
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

            <div class="text-end">
                <button type="submit" class="btn btn-primary btn-sm px-3" style="background-color: #0038A8; border-color: #0038A8; padding: 0.4rem 0.8rem; font-size: 0.8rem;">Save</button>
            </div>
        </form>
    </div>
</div>

<!-- Cropper.js -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

<script>
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
                aspectRatio: 1,
                viewMode: 1,
                autoCropArea: 1,
                responsive: true,
                background: false,
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
</script>

@endsection
