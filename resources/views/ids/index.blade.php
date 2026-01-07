@extends('layouts.app')

@section('title', 'ID Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h4 fw-bold text-dark mb-1">ID Management</h1>
        <p class="text-muted mb-0">Generate and manage barangay ID cards</p>
    </div>
</div>

<div class="row g-4">
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
                    <div class="id-card-preview mb-4 position-relative overflow-hidden shadow-sm" style="aspect-ratio: 1.586/1; background-color: #f8f9fa; border-radius: 12px; container-type: inline-size; font-family: sans-serif;">
                        <!-- Background Pattern (Fingerprint style simulation) -->
                        <div class="position-absolute w-100 h-100" style="opacity: 0.6; background: repeating-radial-gradient(circle at 0 100%, transparent 0, transparent 10px, rgba(0,56,168,0.03) 11px, rgba(0,56,168,0.03) 12px), repeating-radial-gradient(circle at 100% 0, transparent 0, transparent 10px, rgba(206,17,38,0.03) 11px, rgba(206,17,38,0.03) 12px); pointer-events: none;"></div>
                        
                        <!-- Header -->
                        <div class="position-relative d-flex align-items-center px-4 py-2" style="background: linear-gradient(90deg, #0038A8 0%, #CE1126 100%), repeating-radial-gradient(circle at 0 100%, transparent 0, transparent 10px, rgba(255,255,255,0.08) 11px, rgba(255,255,255,0.08) 12px), repeating-radial-gradient(circle at 100% 0, transparent 0, transparent 10px, rgba(255,255,255,0.08) 11px, rgba(255,255,255,0.08) 12px); height: 18cqw; color: white;">
                            <div class="d-flex align-items-center gap-2" style="width: 100%;">
                                <div class="d-flex align-items-center justify-content-center" style="width: 14cqw; height: 14cqw; flex-shrink: 0;">
                                    <img src="/images/kalawaan.png" alt="Barangay Logo" style="width: 100%; height: 100%; object-fit: contain; border-radius: 50%; ">
                                </div>
                                <div class="flex-grow-1 text-center" style="line-height: 1.1;">
                                    <h3 style="font-size: 2cqw; font-weight: normal; letter-spacing: 2px; margin: 0; text-transform: uppercase;">Republic of the Philippines</h3>
                                    <h2 style="font-size: 3.5cqw; font-weight: 800; margin: 0; text-transform: uppercase; letter-spacing: 1px;">Barangay Kalawaan</h2>
                                    <h3 style="font-size: 2cqw; font-weight: normal; margin: 0; text-transform: uppercase;">City of Pasig</h3>
                                </div>
                                <div class="d-flex align-items-center justify-content-center" style="width: 14cqw; height: 14cqw; flex-shrink: 0;">
                                    <img src="/images/Pasig_City_Seal_Logo.svg" alt="Pasig Logo" style="width: 90%; height: 90%; object-fit: contain;">
                                </div>
                            </div>
                        </div>

                        <!-- Body -->
                        <div class="d-flex p-3 h-100 position-relative" style="padding: 3cqw !important; gap: 3cqw;">
                            <!-- Left Column: Photo & Signature -->
                            <div class="d-flex flex-column align-items-center" style="width: 28cqw;">
                                <div class="bg-white border border-2 border-secondary d-flex align-items-center justify-content-center overflow-hidden rounded mb-2" style="width: 28cqw; height: 34cqw; background-color: #e9ecef;">
                                    <img id="preview-photo" src="" alt="Photo" style="width: 100%; height: 100%; object-fit: cover; display: none;">
                                    <span id="preview-no-photo" style="font-size: 3cqw; color: #adb5bd;">PHOTO</span>
                                </div>
                                <div class="text-center w-100" style="border-bottom: 1px solid #000; margin-bottom: 0.5cqw; height: 6cqw; display: flex; align-items: flex-end; justify-content: center;">
                                    <span style="font-family: cursive; font-size: 3cqw;">Signature</span>
                                </div>
                                <div class="text-center fw-bold" style="font-size: 2.5cqw; letter-spacing: 1px; color: #0038A8;">RESIDENT</div>
                            </div>

                            <!-- Right Column: Details -->
                            <div class="flex-grow-1 d-flex flex-column position-relative">
                                <!-- Name -->
                                <div class="mb-3">
                                    <div class="text-muted text-uppercase" style="font-size: 1.8cqw;">Last Name, First Name, Middle Name</div>
                                    <div id="preview-name" class="fw-bold text-uppercase text-dark" style="font-size: 3.8cqw; line-height: 1.1; color: #0038A8 !important;">
                                        RESIDENT NAME
                                    </div>
                                </div>

                                <!-- Grid Details -->
                                <div class="d-flex flex-wrap gap-2 mb-2" style="row-gap: 1.5cqw;">
                                    <div style="width: 20%;">
                                        <div class="text-muted text-uppercase" style="font-size: 1.5cqw;">Sex</div>
                                        <div id="preview-sex" class="fw-bold text-dark" style="font-size: 2.2cqw;">-</div>
                                    </div>
                                    <div style="width: 35%;">
                                        <div class="text-muted text-uppercase" style="font-size: 1.5cqw;">Date of Birth</div>
                                        <div id="preview-dob" class="fw-bold text-dark" style="font-size: 2.2cqw;">-</div>
                                    </div>
                                     <div style="width: 35%;">
                                        <div class="text-muted text-uppercase" style="font-size: 1.5cqw;">Civil Status</div>
                                        <div id="preview-status" class="fw-bold text-dark" style="font-size: 2.2cqw;">-</div>
                                    </div>
                                    
                                    <div style="width: 20%;">
                                        <div class="text-muted text-uppercase" style="font-size: 1.5cqw;">Blood Type</div>
                                        <div id="preview-blood" class="fw-bold text-dark" style="font-size: 2.2cqw;">-</div>
                                    </div>
                                    <div style="width: 35%;">
                                        <div class="text-muted text-uppercase" style="font-size: 1.5cqw;">Nationality</div>
                                        <div id="preview-nationality" class="fw-bold text-dark" style="font-size: 2.2cqw;">-</div>
                                    </div>
                                    <div style="width: 35%;">
                                        <div class="text-muted text-uppercase" style="font-size: 1.5cqw;">Valid Until</div>
                                        <div id="preview-validity" class="fw-bold text-dark" style="font-size: 2.2cqw;">-</div>
                                    </div>
                                </div>

                                <!-- Address -->
                                <div class="mb-2">
                                    <div class="text-muted text-uppercase" style="font-size: 1.5cqw;">Address</div>
                                    <div id="preview-address" class="fw-bold text-dark text-uppercase" style="font-size: 2.2cqw; line-height: 1.2;">
                                        -
                                    </div>
                                </div>

                                <!-- QR Code & ID No -->
                                <div class="position-absolute" style="bottom: 3cqw; right: 3cqw; text-align: center;">
                                    <div class="bg-white p-1 mb-1 border border-2 border-dark" style="width: 15cqw; height: 15cqw; display: flex; align-items: center; justify-content: center;">
                                        <img id="preview-qr" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg'/%3E" alt="QR" style="width: 100%; height: 100%; object-fit: contain;">
                                    </div>
                                    <div id="preview-id-no" class="font-monospace fw-bold" style="font-size: 1.2cqw; letter-spacing: 0.5px; color: #212529;">PENDING</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- BACK PREVIEW -->
                    <div class="id-card-preview position-relative overflow-hidden shadow-sm" style="aspect-ratio: 1.586/1; background-color: #f8f9fa; border-radius: 12px; container-type: inline-size; font-family: sans-serif;">
                        <!-- Background Pattern -->
                        <div class="position-absolute w-100 h-100" style="opacity: 0.6; background: repeating-radial-gradient(circle at 0 100%, transparent 0, transparent 10px, rgba(0,56,168,0.03) 11px, rgba(0,56,168,0.03) 12px), repeating-radial-gradient(circle at 100% 0, transparent 0, transparent 10px, rgba(206,17,38,0.03) 11px, rgba(206,17,38,0.03) 12px); pointer-events: none;"></div>

                        <div class="text-center text-white fw-bold py-2" style="background: linear-gradient(90deg, #0038A8 0%, #CE1126 100%), repeating-radial-gradient(circle at 0 100%, transparent 0, transparent 10px, rgba(255,255,255,0.08) 11px, rgba(255,255,255,0.08) 12px), repeating-radial-gradient(circle at 100% 0, transparent 0, transparent 10px, rgba(255,255,255,0.08) 11px, rgba(255,255,255,0.08) 12px); font-size: 2.8cqw; letter-spacing: 0.1em; padding: 1cqw 2cqw;">
                            EMERGENCY CONTACT
                        </div>
                        
                        <div class="d-flex gap-3 p-3 h-100 position-relative" style="padding: 4cqw !important; gap: 4cqw !important;">
                            <div class="flex-grow-1 d-flex flex-column gap-2" style="gap: 2cqw !important;">
                                <div>
                                    <div style="font-size: 2.2cqw; font-weight: bold; color: #0038A8; margin-bottom: 0.5cqw;">NAME</div>
                                    <div id="preview-ec-name" style="font-size: 2.5cqw; color: #333; font-weight: bold; border-bottom: 1px solid #ccc;">_____________________</div>
                                </div>
                                <div>
                                    <div style="font-size: 2.2cqw; font-weight: bold; color: #0038A8; margin-bottom: 0.5cqw;">ADDRESS</div>
                                    <div id="preview-ec-address" style="font-size: 2.5cqw; color: #333; font-weight: bold; line-height: 1.2; border-bottom: 1px solid #ccc;">_____________________</div>
                                </div>
                                <div>
                                    <div style="font-size: 2.2cqw; font-weight: bold; color: #0038A8; margin-bottom: 0.5cqw;">CONTACT NO.</div>
                                    <div id="preview-ec-no" style="font-size: 2.5cqw; color: #333; font-weight: bold; border-bottom: 1px solid #ccc;">_____________________</div>
                                </div>
                                
                                <div class="mt-auto text-center text-muted" style="font-size: 1.8cqw; line-height: 1.2;">
                                    This card is non-transferable.<br>Please report lost or found cards<br>to the Barangay Hall immediately.
                                </div>
                            </div>
                            
                            <div class="d-flex flex-column align-items-center justify-content-center" style="width: 25cqw; gap: 2cqw;">
                                <div class="text-center w-100 mt-auto">
                                    <div style="border-top: 1px solid #000; margin: 1cqw auto; width: 80%;"></div>
                                    <div style="font-size: 2cqw; font-weight: bold; color: #0038A8;">BARANGAY<br>CHAIRMAN</div>
                                </div>
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

                        <button type="button" id="print-btn" class="btn btn-primary w-100 py-2" style="background-color: #0038A8; border-color: #0038A8;">
                            <i class="bi bi-printer me-2"></i> Print ID Card
                        </button>
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
    const printBtn = document.getElementById('print-btn');
    
    const emptyPreview = document.getElementById('empty-preview');
    const idPreviewContent = document.getElementById('id-preview-content');

    // Preview Elements
    const previewPhoto = document.getElementById('preview-photo');
    const previewNoPhoto = document.getElementById('preview-no-photo');
    const previewName = document.getElementById('preview-name');
    const previewDob = document.getElementById('preview-dob');
    const previewSex = document.getElementById('preview-sex');
    const previewNationality = document.getElementById('preview-nationality');
    const previewStatus = document.getElementById('preview-status');
    const previewBlood = document.getElementById('preview-blood');
    const previewAddress = document.getElementById('preview-address');
    const previewIdNo = document.getElementById('preview-id-no');
    const previewEcName = document.getElementById('preview-ec-name');
    const previewEcAddress = document.getElementById('preview-ec-address');
    const previewEcNo = document.getElementById('preview-ec-no');
    const previewQr = document.getElementById('preview-qr');
    const previewValidity = document.getElementById('preview-validity');

    let currentResident = null;
    let currentID = null;
    let debounceTimer;

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
        generatedInfo.style.display = 'none';
        
        // Update Preview
        updatePreview(resident);
        
        // Auto Generate ID
        generateID(resident);
    }

    function updatePreview(resident, idData = null) {
        previewName.textContent = `${resident.first_name} ${resident.middle_name ? resident.middle_name[0] + '.' : ''} ${resident.last_name}`;
        previewDob.textContent = resident.birth_date || '-';
        previewSex.textContent = resident.gender || '-';
        previewNationality.textContent = resident.nationality || 'FILIPINO';
        previewStatus.textContent = resident.civil_status || '-';
        previewBlood.textContent = resident.blood_type || '-';
        previewAddress.textContent = resident.address || '-';
        
        previewEcName.textContent = resident.emergency_contact_name || '_____________________';
        previewEcAddress.textContent = resident.emergency_contact_address || '_____________________';
        previewEcNo.textContent = resident.emergency_contact_no || '_____________________';

        // Handle photo display
        if (resident.profile_image && resident.profile_image.trim()) {
            try {
                previewPhoto.src = `/storage/${resident.profile_image}`;
                previewPhoto.style.display = 'block';
                previewNoPhoto.style.display = 'none';
            } catch (e) {
                console.error('Error loading photo:', e);
                previewPhoto.style.display = 'none';
                previewNoPhoto.style.display = 'block';
            }
        } else {
            previewPhoto.style.display = 'none';
            previewNoPhoto.style.display = 'block';
        }

        // Handle ID data
        if (idData) {
            previewIdNo.textContent = idData.id_number || 'PENDING';
            if (idData.qr_code) {
                previewQr.src = idData.qr_code;
            }
            previewValidity.textContent = idData.expiration_date || 'N/A';
        } else {
            previewIdNo.textContent = 'PENDING';
            previewQr.src = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg'/%3E";
            previewValidity.textContent = 'N/A';
        }
    }

    function generateID(resident) {
        console.log('==== generateID START ====');
        console.log('Resident ID:', resident.id);
        console.log('Resident:', resident);
        console.log('Current Date:', new Date());
        
        generatingLoader.style.display = 'block';
        generatedInfo.style.display = 'none';
        
        const issuedDate = new Date().toISOString().split('T')[0];
        const expirationDate = new Date(new Date().setFullYear(new Date().getFullYear() + 5)).toISOString().split('T')[0];

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
            
            console.log('==== generateID SUCCESS ====');
        })
        .catch(err => {
            console.error('==== FULL ERROR ====');
            console.error('Error type:', err.name);
            console.error('Error message:', err.message);
            console.error('Error stack:', err.stack);
            console.error('====================');
            generatingLoader.style.display = 'none';
            alert('Error generating ID:\n' + err.message + '\n\nCheck console for details.');
        });
    }

    // Print Handler
    printBtn.addEventListener('click', function() {
        if (!currentResident || !currentID) return;

        const printWindow = window.open('', '_blank');
        if (!printWindow) return;

        // Get absolute image URL for print preview
        const photoUrl = currentResident.profile_image 
            ? `${window.location.protocol}//${window.location.host}/storage/${currentResident.profile_image}`
            : '';

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

        // Generate print HTML after image is ready
        getImageBase64(photoUrl).then(photoBase64 => {
            const photoSrc = photoBase64;

        const idCardHTML = `
          <!DOCTYPE html>
          <html>
            <head>
              <meta charset="UTF-8">
              <title>Barangay ID Card - ${currentResident.first_name} ${currentResident.last_name}</title>
              <style>
                * { margin: 0; padding: 0; box-sizing: border-box; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
                html, body { margin: 0; padding: 0; height: 100%; }
                body { font-family: sans-serif; background: white; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
                
                .id-card { 
                  position: relative; 
                  width: 3.375in; 
                  height: 2.125in; 
                  background-color: #f8f9fa; 
                  overflow: hidden; 
                  display: flex; 
                  flex-direction: column;
                  margin-bottom: 20px;
                  break-after: always;
                  -webkit-print-color-adjust: exact;
                  print-color-adjust: exact;
                }
                
                /* Background Pattern */
                .bg-pattern { 
                  position: absolute; 
                  top: 0; 
                  left: 0; 
                  width: 100%; 
                  height: 100%; 
                  opacity: 0.6; 
                  background: repeating-radial-gradient(circle at 0 100%, transparent 0, transparent 10px, rgba(0,56,168,0.03) 11px, rgba(0,56,168,0.03) 12px), repeating-radial-gradient(circle at 100% 0, transparent 0, transparent 10px, rgba(206,17,38,0.03) 11px, rgba(206,17,38,0.03) 12px); 
                  pointer-events: none; 
                  z-index: 0;
                  -webkit-print-color-adjust: exact;
                  print-color-adjust: exact;
                }

                /* Header */
                .header { 
                  position: relative; 
                  z-index: 1; 
                  background: linear-gradient(90deg, #0038A8 0%, #CE1126 100%), repeating-radial-gradient(circle at 0 100%, transparent 0, transparent 10px, rgba(255,255,255,0.08) 11px, rgba(255,255,255,0.08) 12px), repeating-radial-gradient(circle at 100% 0, transparent 0, transparent 10px, rgba(255,255,255,0.08) 11px, rgba(255,255,255,0.08) 12px); 
                  height: 45px; 
                  display: flex; 
                  align-items: center; 
                  padding: 0 8px; 
                  color: white;
                  flex-shrink: 0;
                  -webkit-print-color-adjust: exact;
                  print-color-adjust: exact;
                }
                .header-logo { 
                  width: 35px; 
                  height: 35px; 
                  border-radius: 50%; 
                  display: flex; 
                  align-items: center; 
                  justify-content: center;
                  flex-shrink: 0;
                  -webkit-print-color-adjust: exact;
                  print-color-adjust: exact;
                }
                .header-logo img { width: 90%; height: 90%; object-fit: contain; border-radius: 60%}
                .header-text { flex: 1; text-align: center; line-height: 1.05; text-transform: uppercase; padding: 0 5px; }
                .header-text h3 { font-size: 5px; font-weight: normal; letter-spacing: 0.5px; margin: 0; }
                .header-text h2 { font-size: 9px; font-weight: 800; margin: 0; letter-spacing: 0.5px; }

                /* Body */
                .card-body { 
                  position: relative; 
                  z-index: 1; 
                  display: flex; 
                  padding: 8px; 
                  gap: 8px; 
                  flex: 1;
                  overflow: hidden;
                }

                /* Left Col */
                .left-col { width: 80px; display: flex; flex-direction: column; align-items: center; flex-shrink: 0; }
                .photo-box { width: 80px; height: 95px; background-color: #e9ecef; border: 1px solid #adb5bd; border-radius: 3px; overflow: hidden; display: flex; align-items: center; justify-content: center; margin-bottom: 4px; flex-shrink: 0; }
                .photo-box img { width: 100%; height: 100%; object-fit: cover; }
                .signature-area { width: 100%; border-bottom: 1px solid #000; height: 18px; margin-bottom: 2px; display: flex; align-items: flex-end; justify-content: center; flex-shrink: 0; }
                .signature-text { font-family: cursive; font-size: 7px; }
                .resident-label { font-size: 8px; font-weight: bold; color: #0038A8; letter-spacing: 0.5px; }

                /* Right Col */
                .right-col { flex: 1; display: flex; flex-direction: column; position: relative; min-width: 0; }
                .field-label { font-size: 5px; color: #6c757d; text-transform: uppercase; margin-bottom: 0.5px; }
                .field-value { font-size: 8px; font-weight: bold; color: #212529; line-height: 1; }
                .name-value { font-size: 11px; color: #0038A8; text-transform: uppercase; margin-bottom: 6px; line-height: 1.1; }

                .grid-container { display: flex; flex-wrap: wrap; gap: 2px; row-gap: 4px; margin-bottom: 4px; }
                .grid-item { flex-shrink: 0; }
                
                .qr-section { position: absolute; bottom: 0; right: 0; text-align: center; padding: 4px; }
                .qr-box { width: 45px; height: 45px; background: white; border: 1px solid #999; padding: 1px; margin-bottom: 1px; display: flex; align-items: center; justify-content: center; }
                .qr-box img { width: 100%; height: 100%; object-fit: contain; }
                .id-no { font-family: monospace; font-weight: bold; font-size: 7px; letter-spacing: 0.3px; }

                /* Back Side */
                .back-header { background: linear-gradient(90deg, #0038A8 0%, #CE1126 100%); color: white; text-align: center; font-weight: bold; font-size: 9px; padding: 4px; letter-spacing: 0.5px; flex-shrink: 0; }
                .back-body { padding: 10px; display: flex; gap: 10px; flex: 1; overflow: hidden; }
                .back-left { flex: 1; display: flex; flex-direction: column; gap: 6px; min-width: 0; }
                .ec-label { font-size: 6px; font-weight: bold; color: #0038A8; margin-bottom: 0.5px; }
                .ec-value { font-size: 8px; font-weight: bold; color: #333; border-bottom: 1px solid #999; padding-bottom: 0.5px; min-height: 10px; }
                .disclaimer { margin-top: auto; font-size: 5px; color: #6c757d; text-align: center; line-height: 1.1; }
                .back-right { width: 70px; display: flex; flex-direction: column; align-items: center; justify-content: flex-end; flex-shrink: 0; }
                .chairman-line { border-top: 1px solid #000; width: 100%; margin-bottom: 1px; }
                .chairman-label { font-size: 6px; font-weight: bold; color: #0038A8; text-align: center; line-height: 1.1; }

                @media print {
                  @page { size: 3.375in 2.125in; margin: 0; }
                  html, body { margin: 0; padding: 0; }
                  body { display: block; background: white; }
                }
              </style>
            </head>
            <body>
              <!-- FRONT CARD -->
              <div class="id-card">
                <div class="bg-pattern"></div>
                <div class="header">
                  <div class="header-logo">
                      <img src="${window.location.origin}/images/kalawaan.png" alt="Logo">
                  </div>
                  <div class="header-text">
                      <h3>Republic of the Philippines</h3>
                      <h2>Barangay Kalawaan</h2>
                      <h3>City of Pasig</h3>
                  </div>
                  <div class="header-logo">
                      <img src="${window.location.origin}/images/Pasig_City_Seal_Logo.svg" alt="Logo">
                  </div>
                </div>
                
                <div class="card-body">
                  <div class="left-col">
                      <div class="photo-box">
                          ${photoSrc ? `<img src="${photoSrc}" alt="Photo">` : '<span style="font-size: 7px; color: #adb5bd;">PHOTO</span>'}
                      </div>
                      <div class="signature-area">
                          <span class="signature-text">Signature</span>
                      </div>
                      <div class="resident-label">RESIDENT</div>
                  </div>
                  
                  <div class="right-col">
                      <div class="field-label">Last Name, First Name, Middle Name</div>
                      <div class="field-value name-value">${currentResident.last_name}, ${currentResident.first_name} ${currentResident.middle_name || ''}</div>
                      
                      <div class="grid-container">
                          <div class="grid-item" style="width: 25%">
                              <div class="field-label">Sex</div>
                              <div class="field-value">${currentResident.gender || '-'}</div>
                          </div>
                          <div class="grid-item" style="width: 35%">
                              <div class="field-label">DOB</div>
                              <div class="field-value">${currentResident.birth_date || '-'}</div>
                          </div>
                          <div class="grid-item" style="width: 35%">
                              <div class="field-label">Status</div>
                              <div class="field-value">${currentResident.civil_status || '-'}</div>
                          </div>
                          <div class="grid-item" style="width: 25%">
                              <div class="field-label">Blood</div>
                              <div class="field-value">${currentResident.blood_type || '-'}</div>
                          </div>
                          <div class="grid-item" style="width: 35%">
                              <div class="field-label">Nationality</div>
                              <div class="field-value">${currentResident.nationality || 'FILIPINO'}</div>
                          </div>
                          <div class="grid-item" style="width: 35%">
                              <div class="field-label">Valid Until</div>
                              <div class="field-value">${currentID.expiration_date || '-'}</div>
                          </div>
                      </div>

                      <div class="field-label">Address</div>
                      <div class="field-value" style="font-size: 7px; line-height: 1; text-transform: uppercase;">${currentResident.address || '-'}</div>

                      <div class="qr-section">
                          <div class="qr-box">
                              <img src="${currentID.qr_code}" alt="QR">
                          </div>
                          <div class="id-no">${currentID.id_number}</div>
                      </div>
                  </div>
                </div>
              </div>

              <!-- BACK CARD -->
              <div class="id-card">
                <div class="bg-pattern"></div>
                <div class="back-header">EMERGENCY CONTACT</div>
                <div class="back-body">
                  <div class="back-left">
                      <div>
                          <div class="ec-label">NAME</div>
                          <div class="ec-value">${currentResident.emergency_contact_name || ''}</div>
                      </div>
                      <div>
                          <div class="ec-label">ADDRESS</div>
                          <div class="ec-value" style="line-height: 1;">${currentResident.emergency_contact_address || ''}</div>
                      </div>
                      <div>
                          <div class="ec-label">CONTACT NO.</div>
                          <div class="ec-value">${currentResident.emergency_contact_no || ''}</div>
                      </div>
                      <div class="disclaimer">
                          This card is non-transferable.<br>Please report lost or found cards<br>to the Barangay Hall immediately.
                      </div>
                  </div>
                  <div class="back-right">
                      <div class="chairman-line"></div>
                      <div class="chairman-label">BARANGAY<br>CHAIRMAN</div>
                  </div>
                </div>
              </div>
            </body>
          </html>
        `;

            printWindow.document.write(idCardHTML);
            printWindow.document.close();
            printWindow.onload = () => {
                printWindow.focus();
                printWindow.print();
            };
        });
    });
});
</script>
@endsection
