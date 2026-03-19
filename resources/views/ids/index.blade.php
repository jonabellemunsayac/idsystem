@extends('layouts.app')

@section('title', 'ID Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h4 fw-bold text-dark mb-1">ID Management</h1>
        <p class="text-muted mb-0">Generate and manage barangay ID cards</p>
    </div>
</div>

<div class="row g-4 align-items-start">
    <!-- ID Card Preview -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3 border-bottom-0">
                <h5 class="card-title mb-0 fw-bold">ID Card Preview</h5>
            </div>
            <div class="card-body bg-light" id="preview-container">
                <!-- Content populated by JS -->
                <div id="empty-preview" class="d-flex align-items-center justify-content-center text-muted flex-column" style="aspect-ratio: 1.586/1; background-color: #e9ecef; border-radius: 8px; display: flex !important;">
                    <p class="mb-0" style="font-size: 16px; font-weight: 500;">Select a resident to generate ID</p>
                </div>

                <div id="id-preview-content" style="display: none;">
                    <!-- FRONT PREVIEW -->
                    <div class="id-card-preview mb-4 position-relative overflow-hidden shadow-sm" style="aspect-ratio: 1.586/1; border-radius: 8px; background-color: #f4f4f4; max-width: 600px; margin: 0 auto;">
                        <img src="{{ asset('images/id-template-blank.png') }}" alt="ID Template" style="width: 100%; height: 100%; object-fit: cover; display: block;">

                        <div style="position: absolute; left: 6.2%; top: 29.5%; width: 19.5%; height: 40%; overflow: hidden; border-radius: 14px;">
                            <img id="preview-photo" src="" alt="Photo" style="width: 100%; height: 100%; object-fit: cover; display: none;">
                            <div id="preview-no-photo" style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #6c757d; font-size: 12px; font-weight: 600; background: rgba(220,220,220,0.55);">NO PHOTO</div>
                        </div>

                        <div style="position: absolute; left: 7%; top: 84.1%; width: 18.5%; height: 7.3%; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                            <img id="preview-signature" src="" alt="Signature" style="max-width: 100%; max-height: 100%; object-fit: contain; display: none;">
                        </div>

                        <div id="preview-name" style="position: absolute; left: 29%; top: 31.8%; width: 65%; font-size: 15px; font-weight: 800; line-height: 1.1; text-transform: uppercase; color: #111; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">-</div>
                        <div id="preview-address" style="position: absolute; left: 29.4%; top: 48.6%; width: 64.5%; font-size: 9px; font-weight: 700; line-height: 1.2; color: #111; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">-</div>

                        <div id="preview-dob" style="position: absolute; left: 30%; top: 60.1%; width: 17%; font-size: 8px; font-weight: 700; color: #111; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">-</div>
                        <div id="preview-pob" style="position: absolute; left: 43.5%; top: 60.1%; width: 20%; font-size: 8px; font-weight: 700; color: #111; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">-</div>
                        <div id="preview-nationality" style="position: absolute; left: 59.6%; top: 60.1%; width: 13.5%; font-size: 8px; font-weight: 700; color: #111; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">-</div>
                        <div id="preview-sex" style="position: absolute; left: 72%; top: 60.1%; width: 7%; font-size: 8px; font-weight: 700; color: #111; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">-</div>
                        <div id="preview-status" style="position: absolute; left: 79%; top: 60.1%; width: 14%; font-size: 8px; font-weight: 700; color: #111; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">-</div>

                        <div id="preview-sector" style="position: absolute; left: 30%; top: 68%; width: 18%; font-size: 8px; font-weight: 700; color: #111; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">-</div>
                        <div id="preview-id-no" style="position: absolute; left: 8%; top: 70%; width: 16.4%; font-size: 9px; font-weight: 800; text-align: center; color: #111; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">PENDING</div>

                        <div style="position: absolute; left: 79.6%; top: 68.5%; width: 14%; height: 20.8%; border: 1px solid #000; background: #fff; display: flex; align-items: center; justify-content: center; padding: 2px;">
                            <img id="preview-qr-front" alt="QR Code" style="width: 100%; height: 100%; object-fit: contain; display: none;">
                        </div>
                        <div id="preview-validity" style="position: absolute; left: 79.6%; top: 100%; width: 14%; font-size: 7px; font-weight: 800; text-align: center; color: #111; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">-</div>
                    </div>

                    <!-- BACK PREVIEW -->
                    <div class="id-card-preview position-relative overflow-hidden shadow-sm" style="width: 100%; max-width: 600px; margin: 0 auto; background-color: #f8f9fa; border-radius: 12px; font-family: sans-serif;">
                        <!-- Background Pattern -->
                        <div class="position-absolute w-100 h-100" style="opacity: 0.6; background: repeating-radial-gradient(circle at 0 100%, transparent 0, transparent 10px, rgba(0,56,168,0.03) 11px, rgba(0,56,168,0.03) 12px), repeating-radial-gradient(circle at 100% 0, transparent 0, transparent 10px, rgba(206,17,38,0.03) 11px, rgba(206,17,38,0.03) 12px); pointer-events: none;"></div>

                        <!-- Top Section: Emergency Contact Info -->
                        <div style="padding: 12px 14px; position: relative; z-index: 1;">
                            <div style="text-align: center; font-weight: bold; color: #0038A8; font-size: 1.05rem; letter-spacing: 0.5px; margin-bottom: 8px; line-height: 1.2;">IN CASE OF EMERGENCY, KINDLY NOTIFY:</div>
                            
                            <table style="width: 100%; font-size: 0.95rem; border-collapse: collapse; margin-bottom: 6px;">
                                <tr style="line-height: 1.6;">
                                    <td style="font-weight: bold; color: #000; width: 120px; padding: 0 4px 3px 0; text-align: right; white-space: nowrap;">NAME :</td>
                                    <td style="color: #000; font-weight: bold; padding: 0 0 3px 4px; text-transform: uppercase;" id="preview-ec-name">_________________</td>
                                </tr>
                                <tr style="line-height: 1.6;">
                                    <td style="font-weight: bold; color: #000; width: 120px; padding: 0 4px 3px 0; text-align: right; white-space: nowrap;">RELATION :</td>
                                    <td style="color: #000; font-weight: bold; padding: 0 0 3px 4px; text-transform: uppercase;" id="preview-ec-relation">_________________</td>
                                </tr>
                                <tr style="line-height: 1.6;">
                                    <td style="font-weight: bold; color: #000; width: 120px; padding: 0 4px 3px 0; text-align: right; white-space: nowrap;">ADDRESS :</td>
                                    <td style="color: #000; font-weight: bold; padding: 0 0 3px 4px; text-transform: uppercase;" id="preview-ec-address">_________________</td>
                                </tr>
                                <tr style="line-height: 1.6;">
                                    <td style="font-weight: bold; color: #000; width: 120px; padding: 0 4px 0 0; text-align: right; white-space: nowrap;">CONTACT NO. :</td>
                                    <td style="color: #000; font-weight: bold; padding: 0 0 0 4px; text-transform: uppercase;" id="preview-ec-no">_________________</td>
                                </tr>
                            </table>

                            <!-- Emergency Hotline Section -->
                            <div style="text-align: center; font-weight: bold; color: #0038A8; font-size: 0.95rem; letter-spacing: 0.5px; margin-top: 5px; margin-bottom: 3px; line-height: 1.1;">EMERGENCY HOTLINE</div>
                            
                            <div style="display: flex; justify-content: center;">
                                <table style="font-size: 0.75rem; border-collapse: collapse; margin-bottom: 2px;">
                                    <tr style="line-height: 1.4;">
                                        <td style="font-weight: bold; color: #000; padding: 0 4px 2px 0; text-align: right; white-space: nowrap;">BARANGAY :</td>
                                        <td style="color: #000; font-weight: bold; padding: 0 0 2px 4px;">(02) 874-26641 / 0966-007-7440</td>
                                    </tr>
                                    <tr style="line-height: 1.4;">
                                        <td style="font-weight: bold; color: #000; padding: 0 4px 2px 0; text-align: right; white-space: nowrap;">PASIG CITY HOTLINE :</td>
                                        <td style="color: #000; font-weight: bold; padding: 0 0 2px 4px;">643-0000</td>
                                    </tr>
                                    <tr style="line-height: 1.4;">
                                        <td style="font-weight: bold; color: #000; padding: 0 4px 2px 0; text-align: right; white-space: nowrap;">PNP :</td>
                                        <td style="color: #000; font-weight: bold; padding: 0 0 2px 4px;">911</td>
                                    </tr>
                                    <tr style="line-height: 1.4;">
                                        <td style="font-weight: bold; color: #000; padding: 0 4px 2px 0; text-align: right; white-space: nowrap;">BFP-PASIG HOTLINE :</td>
                                        <td style="color: #000; font-weight: bold; padding: 0 0 2px 4px;">0932-779-8621</td>
                                    </tr>
                                    <tr style="line-height: 1.4;">
                                        <td style="font-weight: bold; color: #000; padding: 0 4px 0 0; text-align: right; white-space: nowrap;">MERALCO :</td>
                                        <td style="color: #000; font-weight: bold; padding: 0 0 0 4px;">16211</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- IF FOUND Text - Bottom Section -->
                        <div style="position: absolute; bottom: 3px; left: 10px; right: 10px; text-align: center; z-index: 2;">
                            <div style="font-size: 0.5rem; color: #666; line-height: 1.2;">
                                IF FOUND, PLEASE RETURN TO KALAWAAN BARANGAY HALL INFORMATION CENTER
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ID Generation Form -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 border-bottom-0">
                <h5 class="card-title mb-0 fw-bold">ID Generation Form</h5>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <label class="form-label fw-medium small">Search Resident Name</label>
                    <div class="position-relative">
                        <i class="bi bi-search position-absolute text-muted" style="left: 12px; top: 50%; transform: translateY(-50%);"></i>
                        <input type="text" id="resident-search" class="form-control ps-5" placeholder="Search resident...">
                        
                        <!-- Search Results Dropdown -->
                        <div id="search-results" class="position-absolute w-100 bg-white border rounded shadow-sm mt-1" style="display: none; z-index: 1000; max-height: 200px; overflow-y: auto;">
                            <!-- Populated by JS -->
                        </div>
                    </div>
                    <div id="search-loading" class="text-muted small mt-1" style="display: none;">Searching...</div>
                </div>

                <div id="selected-resident-info" style="display: none;">
                    <div class="alert alert-success d-flex align-items-center gap-2 py-2 px-3 mb-4">
                        <i class="bi bi-check-circle-fill"></i>
                        <span class="fw-bold" id="selected-name-display"></span>
                    </div>

                    <div id="generated-info" style="display: none;">
                        <div class="mb-3">
                            <label class="form-label fw-medium small">ID Number</label>
                            <div class="p-3 bg-light rounded font-monospace fw-bold" id="generated-id-no"></div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-medium small">QR Code</label>
                            <div class="p-3 bg-light rounded text-center text-muted small">
                                <i class="bi bi-check-lg me-1"></i> Generated & Ready to Print
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="button" id="print-front-btn" class="btn btn-primary flex-fill py-2" style="background-color: #0038A8; border-color: #0038A8;">
                                <i class="bi bi-printer me-2"></i> Print Front
                            </button>
                            <button type="button" id="print-back-btn" class="btn btn-outline-primary flex-fill py-2" style="border-color: #0038A8; color: #0038A8;">
                                <i class="bi bi-printer me-2"></i> Print Back
                            </button>
                        </div>

                        <!-- Under-18 warning -->
                        <div id="age-warning" class="alert alert-danger d-flex align-items-center gap-2 py-2 px-3 mt-3 mb-0" style="display: none !important;">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                            <span class="small fw-bold">This resident is <strong>under 18 years old</strong>. Barangay ID printing is not allowed for minors.</span>
                        </div>
                    </div>
                    
                    <div id="generating-loader" class="alert alert-info py-2 px-3 mb-0 text-center" style="display: none;">
                        Generating ID Card...
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('resident-search');
    const searchResults = document.getElementById('search-results');
    const searchLoading = document.getElementById('search-loading');
    const selectedResidentInfo = document.getElementById('selected-resident-info');
    const selectedNameDisplay = document.getElementById('selected-name-display');
    const generatedInfo = document.getElementById('generated-info');
    const generatedIdNo = document.getElementById('generated-id-no');
    const generatingLoader = document.getElementById('generating-loader');
    const printFrontBtn = document.getElementById('print-front-btn');
    const printBackBtn = document.getElementById('print-back-btn');
    
    const emptyPreview = document.getElementById('empty-preview');
    const idPreviewContent = document.getElementById('id-preview-content');

    // Preview Elements
    const previewPhoto = document.getElementById('preview-photo');
    const previewNoPhoto = document.getElementById('preview-no-photo');
    const previewSignature = document.getElementById('preview-signature');
    const previewName = document.getElementById('preview-name');
    const previewDob = document.getElementById('preview-dob');
    const previewPob = document.getElementById('preview-pob');
    const previewSex = document.getElementById('preview-sex');
    const previewNationality = document.getElementById('preview-nationality');
    const previewStatus = document.getElementById('preview-status');
    const previewSector = document.getElementById('preview-sector');
    const previewAddress = document.getElementById('preview-address');
    const previewIdNo = document.getElementById('preview-id-no');
    const previewEcName = document.getElementById('preview-ec-name');
    const previewEcAddress = document.getElementById('preview-ec-address');
    const previewEcNo = document.getElementById('preview-ec-no');
    const previewQrFront = document.getElementById('preview-qr-front');
    const previewValidity = document.getElementById('preview-validity');

    let currentResident = null;
    let currentID = null;
    let debounceTimer;

    function isUnder18(birthDate) {
        if (!birthDate) return false;
        const today = new Date();
        const dob = new Date(birthDate + 'T00:00:00');
        let age = today.getFullYear() - dob.getFullYear();
        const m = today.getMonth() - dob.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) age--;
        return age < 18;
    }

    function applyAgeRestriction(resident) {
        const ageWarning = document.getElementById('age-warning');
        const minor = isUnder18(resident.birth_date);
        if (minor) {
            printFrontBtn.disabled = true;
            printFrontBtn.style.opacity = '0.5';
            printFrontBtn.style.cursor = 'not-allowed';
            printBackBtn.disabled = true;
            printBackBtn.style.opacity = '0.5';
            printBackBtn.style.cursor = 'not-allowed';
            ageWarning.style.cssText = 'display: flex !important;';
        } else {
            printFrontBtn.disabled = false;
            printFrontBtn.style.opacity = '';
            printFrontBtn.style.cursor = '';
            printBackBtn.disabled = false;
            printBackBtn.style.opacity = '';
            printBackBtn.style.cursor = '';
            ageWarning.style.cssText = 'display: none !important;';
        }
    }

    // Search Handler
    searchInput.addEventListener('input', function(e) {
        const query = e.target.value;
        clearTimeout(debounceTimer);
        
        if (query.length < 2) {
            searchResults.style.display = 'none';
            return;
        }

        searchLoading.style.display = 'block';
        
        debounceTimer = setTimeout(() => {
            fetch(`/api/residents/search?q=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(data => {
                    searchLoading.style.display = 'none';
                    searchResults.innerHTML = '';
                    
                    if (data.residents.length > 0) {
                        data.residents.forEach(resident => {
                            const div = document.createElement('div');
                            div.className = 'p-2 border-bottom cursor-pointer hover-bg-light';
                            div.style.cursor = 'pointer';
                            div.innerHTML = `
                                <div class="fw-bold small">${resident.first_name} ${resident.last_name}</div>
                                <div class="text-muted" style="font-size: 11px;">${resident.address || 'No address'}</div>
                            `;
                            div.addEventListener('click', () => selectResident(resident));
                            div.addEventListener('mouseover', () => div.style.backgroundColor = '#f8f9fa');
                            div.addEventListener('mouseout', () => div.style.backgroundColor = 'white');
                            searchResults.appendChild(div);
                        });
                        searchResults.style.display = 'block';
                    } else {
                        searchResults.style.display = 'none';
                    }
                })
                .catch(err => {
                    console.error(err);
                    searchLoading.style.display = 'none';
                });
        }, 300);
    });

    // Select Resident
    function selectResident(resident) {
        console.log('selectResident called with:', resident);
        console.log('Current currentID before selection:', currentID);
        
        // Reset state for new selection
        currentID = null;
        
        currentResident = resident;
        searchInput.value = `${resident.first_name} ${resident.last_name}`;
        searchResults.style.display = 'none';
        
        // Hide empty preview and show content FIRST - use !important to override Bootstrap
        emptyPreview.style.cssText = 'display: none !important;';
        idPreviewContent.style.cssText = 'display: block !important;';
        
        // Update UI
        selectedResidentInfo.style.display = 'block';
        selectedNameDisplay.textContent = `${resident.first_name} ${resident.last_name}`;
        generatedInfo.style.display = 'block';
        printFrontBtn.disabled = true;
        printBackBtn.disabled = true;
        
        // Update Preview
        updatePreview(resident);
        
        // Apply age restriction
        applyAgeRestriction(resident);
        
        // Auto Generate ID
        generateID(resident);
    }

    function formatDate(dateStr) {
        if (!dateStr) return '-';
        const d = new Date(dateStr + 'T00:00:00');
        return d.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
    }

    function formatMonthYear(dateStr) {
        if (!dateStr) return '-';
        const d = new Date(dateStr + 'T00:00:00');
        return d.toLocaleDateString('en-US', { month: 'long', year: 'numeric' });
    }

    function resolveMediaUrl(path) {
        if (!path || !String(path).trim()) return '';
        const cleanPath = String(path).trim();
        if (/^https?:\/\//i.test(cleanPath) || cleanPath.startsWith('data:')) {
            return cleanPath;
        }
        if (cleanPath.startsWith('/storage/') || cleanPath.startsWith('storage/')) {
            return cleanPath.startsWith('/') ? cleanPath : `/${cleanPath}`;
        }
        return `/storage/${cleanPath.replace(/^\/+/, '')}`;
    }

    function updatePreview(resident, idData = null) {
        const fullName = `${resident.last_name || ''}, ${resident.first_name || ''} ${resident.middle_name || ''}${resident.suffix ? ' ' + resident.suffix : ''}`.trim();
        previewName.textContent = fullName || '-';
        previewDob.textContent = formatDate(resident.birth_date);
        previewPob.textContent = resident.birth_place || resident.place_of_birth || '-';
        previewSex.textContent = resident.gender || '-';
        previewNationality.textContent = resident.nationality || 'FILIPINO';
        previewStatus.textContent = resident.civil_status || '-';
        if (previewSector) previewSector.textContent = resident.special_sector || '-';
        previewAddress.textContent = (resident.address || '-').toUpperCase();
        
        previewEcName.textContent = resident.emergency_contact_name || '_____________________';
        previewEcAddress.textContent = resident.emergency_contact_address || '_____________________';
        previewEcNo.textContent = resident.emergency_contact_no || '_____________________';
        
        // Handle emergency contact relation
        const previewEcRelation = document.getElementById('preview-ec-relation');
        if (previewEcRelation) {
            previewEcRelation.textContent = resident.emergency_contact_relationship || '_____________________';
        }

        // Handle photo display
        if (resident.profile_image && resident.profile_image.trim()) {
            try {
                previewPhoto.src = resolveMediaUrl(resident.profile_image);
                previewPhoto.style.display = 'block';
                previewNoPhoto.style.display = 'none';
            } catch (e) {
                console.error('Error loading photo:', e);
                previewPhoto.style.display = 'none';
                previewNoPhoto.style.display = 'flex';
            }
        } else {
            previewPhoto.style.display = 'none';
            previewNoPhoto.style.display = 'flex';
        }

        if (previewSignature) {
            if (resident.signature && resident.signature.trim()) {
                previewSignature.src = resolveMediaUrl(resident.signature);
                previewSignature.style.display = 'block';
            } else {
                previewSignature.src = '';
                previewSignature.style.display = 'none';
            }
        }

        // Handle ID data
        if (idData) {
            if (previewIdNo) previewIdNo.textContent = idData.id_number || 'PENDING';
            if (idData.qr_code) {
                if (previewQrFront) {
                    previewQrFront.src = idData.qr_code;
                    previewQrFront.style.display = 'block';
                }
            }
            previewValidity.textContent = formatDate(idData.expiration_date) || '-';
        } else {
            if (previewIdNo) previewIdNo.textContent = 'PENDING';
            if (previewQrFront) {
                previewQrFront.src = '';
                previewQrFront.style.display = 'none';
            }
            // Calculate validity: resident created_at + 3 years
            if (resident.created_at) {
                const createdDate = new Date(resident.created_at);
                const year = createdDate.getFullYear() + 3;
                const month = createdDate.getMonth();
                const date = createdDate.getDate();
                const validityDate = new Date(year, month, date).toISOString().split('T')[0];
                previewValidity.textContent = formatDate(validityDate);
            } else {
                previewValidity.textContent = '-';
            }
        }
    }

    function generateID(resident) {
        console.log('==== generateID START ====');
        console.log('Resident ID:', resident.id);
        console.log('Resident:', resident);
        console.log('Current Date:', new Date());
        
        generatingLoader.style.display = 'block';
        generatedInfo.style.display = 'block';
        
        const issuedDate = new Date().toISOString().split('T')[0];
        const expirationDate = new Date(new Date().setFullYear(new Date().getFullYear() + 3)).toISOString().split('T')[0];

        const requestBody = {
            resident_id: resident.id,
            issued_date: issuedDate,
            expiration_date: expirationDate
        };

        // Get CSRF token safely
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        if (!csrfToken) {
            console.error('CSRF token not found in page');
            generatingLoader.style.display = 'none';
            alert('Error: CSRF token not found. Please reload the page.');
            return;
        }

        console.log('CSRF Token found:', csrfToken.substring(0, 10) + '...');
        console.log('Sending request to /api/ids/generate:', requestBody);

        fetch('/api/ids/generate', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(requestBody)
        })
        .then(res => {
            console.log('Response received - Status:', res.status, res.statusText);
            if (!res.ok) {
                return res.text().then(text => {
                    console.error('Error response body:', text);
                    throw new Error(`HTTP ${res.status}: ${text}`);
                });
            }
            return res.json();
        })
        .then(data => {
            console.log('Full API Response:', JSON.stringify(data, null, 2));
            generatingLoader.style.display = 'none';
            
            if (!data) {
                console.error('API returned empty response');
                alert('Failed to generate ID: Empty response');
                throw new Error('API returned empty response');
            }
            
            if (data.success === false || !data.id) {
                console.error('API returned error:', data);
                alert('Failed to generate ID.\nResponse: ' + JSON.stringify(data));
                return;
            }
            
            // Safely extract ID data
            const idData = data.id;
            if (!idData) {
                console.error('No ID data in response');
                throw new Error('No ID data in response');
            }
            
            console.log('ID data extracted:', idData);
            console.log('Setting currentID to:', idData);
            currentID = idData;
            console.log('currentID is now:', currentID);
            
            updatePreview(resident, idData);
            generatedInfo.style.display = 'block';
            generatedIdNo.textContent = idData.id_number || 'PENDING';
            printFrontBtn.disabled = false;
            printBackBtn.disabled = false;
            
            console.log('==== generateID SUCCESS ====');
        })
        .catch(err => {
            console.error('==== FULL ERROR ====');
            console.error('Error type:', err.name);
            console.error('Error message:', err.message);
            console.error('Error stack:', err.stack);
            console.error('====================');
            generatingLoader.style.display = 'none';
            printFrontBtn.disabled = true;
            printBackBtn.disabled = true;
            alert('Error generating ID:\n' + err.message + '\n\nCheck console for details.');
        });
    }

    // Print Front Handler
    // Print Front Handler
    printFrontBtn.addEventListener('click', function() {
        if (!currentResident || !currentID) return;
        if (isUnder18(currentResident.birth_date)) return;
        printCard('front');
    });

    // Print Back Handler
    printBackBtn.addEventListener('click', function() {
        if (!currentResident || !currentID) return;
        if (isUnder18(currentResident.birth_date)) return;
        printCard('back');
    });

    // Print Handler
    function printCard(side = 'both') {
        if (!currentResident || !currentID) return;

        // Log the print action
        logPrintAction(side);

        const printWindow = window.open('', '_blank');
        if (!printWindow) return;

        // Resolve media URLs for print preview
        const photoUrl = resolveMediaUrl(currentResident.profile_image);
        const signatureUrl = resolveMediaUrl(currentResident.signature);

        const templateUrl = `${window.location.protocol}//${window.location.host}/images/id-template-blank.png`;

        // Function to fetch and convert image to base64
        async function getImageBase64(url) {
            if (!url) return '';
            try {
                const response = await fetch(url);
                const blob = await response.blob();
                return new Promise((resolve) => {
                    const reader = new FileReader();
                    reader.onloadend = () => resolve(reader.result);
                    reader.readAsDataURL(blob);
                });
            } catch (e) {
                console.error('Error loading image:', e);
                return '';
            }
        }

        // Generate print HTML after images are ready
        Promise.all([
            getImageBase64(photoUrl),
            getImageBase64(signatureUrl),
            getImageBase64(templateUrl)
        ]).then(([photoBase64, signatureBase64, templateBase64]) => {
            const photoSrc = photoBase64;
            const signatureSrc = signatureBase64;
            const templateSrc = templateBase64 || templateUrl;
            const fullNamePrint = `${currentResident.last_name || ''}, ${currentResident.first_name || ''} ${currentResident.middle_name || ''}${currentResident.suffix ? ' ' + currentResident.suffix : ''}`.replace(/\s+/g, ' ').trim();
            const addressPrint = (currentResident.address || '-').replace(/\s+/g, ' ').trim();
            const sectorPrint = (currentResident.special_sector || '-').replace(/\s+/g, ' ').trim();
            const idNumberPrint = (currentID.id_number || '-').replace(/\s+/g, ' ').trim();
            const validityPrint = formatDate(currentID.expiration_date);

            const fitFont = (text, base, min, maxChars) => {
                if (!text) return base;
                const ratio = Math.max(0, (text.length - maxChars) / maxChars);
                const size = base - (base - min) * Math.min(1, ratio);
                return Number(size.toFixed(2));
            };

            const nameFont = fitFont(fullNamePrint, 7, 6.1, 40);
            const addressFont = fitFont(addressPrint, 6.8, 5.1, 44);
            const sectorFont = fitFont(sectorPrint, 6.6, 5.4, 18);
            const idFont = fitFont(idNumberPrint, 6.3, 5.0, 16);
            const printNameStyle = 'font-family: "Arial Black", "Segoe UI", Arial, sans-serif; color: #0a1f4d; text-shadow: 0 0 1.2px rgba(255,255,255,0.95), 0 0 0.6px rgba(255,255,255,0.9);';
            const printValueStyle = 'font-family: "Segoe UI", Arial, sans-serif; color: #101828; text-shadow: 0 0 1px rgba(255,255,255,0.95), 0 0 0.4px rgba(255,255,255,0.9);';
            const printStrongStyle = 'font-family: "Arial Black", "Segoe UI", Arial, sans-serif; color: #07193d; text-shadow: 0 0 1.2px rgba(255,255,255,0.95), 0 0 0.6px rgba(255,255,255,0.9);';

                const frontCardHTML = `
                            <div class="id-card" style="position: relative; width: 3.375in; height: 2.125in; overflow: hidden;">
                                <img src="${templateSrc}" alt="Template" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover;">

                                <div style="position: absolute; left: 6.2%; top: 29.5%; width: 19.5%; height: 40%; overflow: hidden; border-radius: 8px; background: #d8d8d8; display: flex; align-items: center; justify-content: center;">
                                    ${photoSrc ? `<img src="${photoSrc}" alt="Photo" style="width: 100%; height: 100%; object-fit: cover;">` : '<span style="font-size: 8px; color: #666; font-weight: bold;">NO PHOTO</span>'}
                                </div>

                                <div style="position: absolute; left: 29%; top: 37%; width: 65%; font-size: ${nameFont}px; font-weight: 900; line-height: 1.05; text-transform: uppercase; white-space: nowrap; overflow: hidden; letter-spacing: 0.15px; ${printNameStyle}">${fullNamePrint || '-'}</div>
                                <div style="position: absolute; left: 29.4%; top: 49%; width: 64.5%; font-size: ${addressFont}px; font-weight: 800; line-height: 1.05; text-transform: uppercase; white-space: nowrap; overflow: hidden; letter-spacing: 0.1px; ${printValueStyle}">${addressPrint}</div>

                                <div style="position: absolute; left: 29.5%; top: 60.1%; width: 17%; font-size: 5px; font-weight: 800; white-space: normal; overflow-wrap: anywhere; word-break: break-word; line-height: 1.05; letter-spacing: 0.1px; ${printValueStyle}">${formatDate(currentResident.birth_date)}</div>
                                <div style="position: absolute; left: 43.5%; top: 60.1%; width: 20%; font-size: 5px; font-weight: 800; white-space: normal; overflow-wrap: anywhere; word-break: break-word; line-height: 1.05; letter-spacing: 0.1px; ${printValueStyle}">${currentResident.birth_place || currentResident.place_of_birth || '-'}</div>
                                <div style="position: absolute; left: 59.6%; top: 60.1%; width: 13.5%; font-size: 5px; font-weight: 800; white-space: normal; overflow-wrap: anywhere; word-break: break-word; line-height: 1.05; letter-spacing: 0.1px; ${printValueStyle}">${currentResident.nationality || 'FILIPINO'}</div>
                                <div style="position: absolute; left: 72%; top: 60.1%; width: 7%; font-size: 5px; font-weight: 800; white-space: normal; overflow-wrap: anywhere; word-break: break-word; line-height: 1.05; letter-spacing: 0.1px; ${printValueStyle}">${currentResident.gender || '-'}</div>
                                <div style="position: absolute; left: 79%; top: 60.1%; width: 14%; font-size: 5px; font-weight: 800; white-space: normal; overflow-wrap: anywhere; word-break: break-word; line-height: 1.05; letter-spacing: 0.1px; ${printValueStyle}">${currentResident.civil_status || '-'}</div>

                                <div style="position: absolute; left: 29.7%; top: 68.5%; width: 18%; font-size: 6.5px; font-weight: 800; white-space: nowrap; overflow: hidden; letter-spacing: 0.1px; ${printValueStyle}">${sectorPrint}</div>
                                <div style="position: absolute; left: 7%; top: 73.4%; width: 18.2%; text-align: center; font-size: 4px; font-weight: 900; white-space: nowrap; overflow: hidden; letter-spacing: 0.2px; ${printStrongStyle}">${idNumberPrint}</div>

                                <div style="position: absolute; left: 7%; top: 80%; width: 23%; height: 15%; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                                    ${signatureSrc ? `<img src="${signatureSrc}" alt="Signature" style="max-width: 100%; max-height: 100%; object-fit: contain;">` : ''}
                                </div>

                                <div style="position: absolute; left: 79.6%; top: 68.5%; width: 14%; height: 20.8%; background: #fff; display: flex; align-items: center; justify-content: center; padding: 2px;">
                                    ${currentID.qr_code ? `<img src="${currentID.qr_code}" alt="QR" style="width: 100%; height: 100%; object-fit: contain;">` : ''}
                                </div>
                                <div style="position: absolute; left: 78.8%; top: 93%; width: 15.6%; text-align: center; font-size: 5px; font-weight: 900; white-space: nowrap; overflow: hidden; letter-spacing: 0.1px; ${printStrongStyle}">${validityPrint}</div>
                            </div>
                `;

        const backCardHTML = `
              <div class="id-card">
                <div class="bg-pattern"></div>
                <div style="padding: 12px 14px; position: relative; z-index: 1;">
                  <div style="text-align: center; font-weight: bold; color: #0038A8; font-size: 11px; letter-spacing: 0.5px; margin-bottom: 8px; line-height: 1.2;">IN CASE OF EMERGENCY, KINDLY NOTIFY:</div>
                  
                  <table style="width: 100%; font-size: 10px; border-collapse: collapse; margin-bottom: 6px;">
                    <tr style="line-height: 1.6;">
                      <td style="font-weight: bold; color: #000; width: 85px; padding: 0 4px 3px 0; text-align: right; white-space: nowrap;">NAME :</td>
                      <td style="color: #000; font-weight: bold; padding: 0 0 3px 4px; text-transform: uppercase;">${currentResident.emergency_contact_name || '_________________'}</td>
                    </tr>
                    <tr style="line-height: 1.6;">
                      <td style="font-weight: bold; color: #000; width: 85px; padding: 0 4px 3px 0; text-align: right; white-space: nowrap;">RELATION :</td>
                      <td style="color: #000; font-weight: bold; padding: 0 0 3px 4px; text-transform: uppercase;">${currentResident.emergency_contact_relationship || '_________________'}</td>
                    </tr>
                    <tr style="line-height: 1.6;">
                      <td style="font-weight: bold; color: #000; width: 85px; padding: 0 4px 3px 0; text-align: right; white-space: nowrap;">ADDRESS :</td>
                      <td style="color: #000; font-weight: bold; padding: 0 0 3px 4px; text-transform: uppercase;">${currentResident.emergency_contact_address || '_________________'}</td>
                    </tr>
                    <tr style="line-height: 1.6;">
                      <td style="font-weight: bold; color: #000; width: 85px; padding: 0 4px 0 0; text-align: right; white-space: nowrap;">CONTACT NO. :</td>
                      <td style="color: #000; font-weight: bold; padding: 0 0 0 4px; text-transform: uppercase;">${currentResident.emergency_contact_no || '_________________'}</td>
                    </tr>
                  </table>

                  <div style="text-align: center; font-weight: bold; color: #0038A8; font-size: 10px; letter-spacing: 0.5px; margin-top: 5px; margin-bottom: 3px; line-height: 1.1;">EMERGENCY HOTLINE</div>
                  
                  <div style="display: flex; justify-content: center;">
                    <table style="font-size: 8px; border-collapse: collapse; margin-bottom: 2px;">
                      <tr style="line-height: 1.4;">
                        <td style="font-weight: bold; color: #000; padding: 0 4px 2px 0; text-align: right; white-space: nowrap;">BARANGAY :</td>
                        <td style="color: #000; font-weight: bold; padding: 0 0 2px 4px;">(02) 874-26641 / 0966-007-7440</td>
                      </tr>
                      <tr style="line-height: 1.4;">
                        <td style="font-weight: bold; color: #000; padding: 0 4px 2px 0; text-align: right; white-space: nowrap;">PASIG CITY HOTLINE :</td>
                        <td style="color: #000; font-weight: bold; padding: 0 0 2px 4px;">643-0000</td>
                      </tr>
                      <tr style="line-height: 1.4;">
                        <td style="font-weight: bold; color: #000; padding: 0 4px 2px 0; text-align: right; white-space: nowrap;">PNP :</td>
                        <td style="color: #000; font-weight: bold; padding: 0 0 2px 4px;">911</td>
                      </tr>
                      <tr style="line-height: 1.4;">
                        <td style="font-weight: bold; color: #000; padding: 0 4px 2px 0; text-align: right; white-space: nowrap;">BFP-PASIG HOTLINE :</td>
                        <td style="color: #000; font-weight: bold; padding: 0 0 2px 4px;">0932-779-8621</td>
                      </tr>
                      <tr style="line-height: 1.4;">
                        <td style="font-weight: bold; color: #000; padding: 0 4px 0 0; text-align: right; white-space: nowrap;">MERALCO :</td>
                        <td style="color: #000; font-weight: bold; padding: 0 0 0 4px;">16211</td>
                      </tr>
                    </table>
                  </div>
                </div>

                <!-- IF FOUND Text - Bottom Section -->
                <div style="position: absolute; bottom: 5px; left: 10px; right: 10px; text-align: center; z-index: 2;">
                  <div style="font-size: 5px; color: #666; line-height: 1.2;">
                    IF FOUND, PLEASE RETURN TO KALAWAAN BARANGAY HALL INFORMATION CENTER
                  </div>
                </div>

              </div>
        `;

            let finalHTML = `
          <!DOCTYPE html>
          <html>
            <head>
              <meta charset="UTF-8">
              <title>Barangay ID Card - ${currentResident.first_name} ${currentResident.last_name}</title>
              <style>
                                * { margin: 0; padding: 0; box-sizing: border-box; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
                                html, body { margin: 0; padding: 0; }
                                body { font-family: Arial, Helvetica, sans-serif; background: #f3f4f6; padding: 14px; }
                                .print-wrap { display: flex; flex-direction: column; align-items: center; gap: 16px; }
                                .id-card {
                                    position: relative;
                                    width: 3.375in;
                                    height: 2.125in;
                                    overflow: hidden;
                                    background: #fff;
                                    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
                                    border-radius: 4px;
                                }
                                @media screen and (max-width: 900px) {
                                    .id-card {
                                        width: min(95vw, 3.375in);
                                        height: auto;
                                        aspect-ratio: 1.588;
                                    }
                                }
                                .bg-pattern {
                                    position: absolute;
                                    top: 0;
                                    left: 0;
                                    width: 100%;
                                    height: 100%;
                                    opacity: 0.6;
                                    background: repeating-radial-gradient(circle at 0 100%, transparent 0, transparent 10px, rgba(0,56,168,0.03) 11px, rgba(0,56,168,0.03) 12px), repeating-radial-gradient(circle at 100% 0, transparent 0, transparent 10px, rgba(206,17,38,0.03) 11px, rgba(206,17,38,0.03) 12px);
                                    pointer-events: none;
                                }

                @media print {
                  @page { size: 3.375in 2.125in; margin: 0; }
                                    html, body { margin: 0; padding: 0; background: #fff; }
                                    body { padding: 0; }
                                    .print-wrap { gap: 0; }
                                    .id-card { margin: 0; border-radius: 0; box-shadow: none; page-break-after: always; }
                                    .id-card:last-child { page-break-after: auto; }
                }
              </style>
            </head>
                        <body>
                        <div class="print-wrap">
            `;

            if (side === 'front' || side === 'both') {
                finalHTML += frontCardHTML;
            }
            if (side === 'back' || side === 'both') {
                finalHTML += backCardHTML;
            }

            finalHTML += `
                        </div>
            </body>
          </html>
        `;

            printWindow.document.write(finalHTML);
            printWindow.document.close();
            printWindow.onload = () => {
                printWindow.focus();
                printWindow.print();
            };
        });
    }

    // Log print action to audit logs
    function logPrintAction(printType) {
        if (!currentResident) return;

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        if (!csrfToken) return;

        fetch('/api/ids/log-print', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                resident_id: currentResident.id,
                print_type: printType
            })
        }).catch(err => {
            console.error('Failed to log print action:', err);
        });
    }
});
</script>
@endsection
