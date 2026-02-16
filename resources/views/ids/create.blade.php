@extends('layouts.app')

@section('title', 'ID Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 fw-bold text-dark mb-1">ID Management</h1>
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
                <div id="empty-preview" class="d-flex align-items-center justify-content-center text-muted" style="aspect-ratio: 1.586/1; background-color: #e9ecef; border-radius: 8px;">
                    <p class="small mb-0">Select a resident to generate ID</p>
                </div>

                <div id="id-preview-content" style="display: none;">
                    <!-- FRONT PREVIEW -->
                    <div class="id-card-preview mb-4 position-relative overflow-hidden shadow-sm" style="aspect-ratio: 1.586/1; background-color: #1a3a5c; border-radius: 8px; container-type: inline-size;">
                        <!-- Header -->
                        <div class="position-relative d-flex align-items-center justify-content-center text-white" style="background-color: #0f2741; height: 15cqw;">
                            <div class="position-absolute bg-white rounded-circle d-flex align-items-center justify-content-center overflow-hidden border border-2 border-white" style="left: 3cqw; width: 11cqw; height: 11cqw; padding: 0.5cqw;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="#0038A8" stroke-width="2" style="width: 100%; height: 100%;">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                                    <polyline points="9 22 9 12 15 12 15 22" />
                                    <line x1="9" y1="5" x2="9" y2="9" />
                                    <line x1="15" y1="5" x2="15" y2="9" />
                                </svg>
                            </div>
                            <div class="text-center w-100" style="line-height: 1;">
                                <h1 style="font-size: 2.5cqw; font-weight: normal; letter-spacing: 0.1em; margin: 0;">Republic of the Philippines</h1>
                                <h1 style="font-size: 2.5cqw; font-weight: normal; letter-spacing: 0.1em; margin: 0;">National Capital Region</h1>
                                <h2 style="font-size: 3.5cqw; font-weight: bold; margin: 0.5cqw 0;">CITY OF PASIG</h2>
                                <h3 style="font-size: 2.5cqw; font-weight: normal; margin: 0;">BARANGAY KALAWAAN</h3>
                            </div>
                        </div>

                        <!-- Body -->
                        <div class="d-flex gap-3 p-3" style="padding: 3cqw !important; gap: 3cqw !important;">
                            <!-- Photo -->
                            <div class="bg-secondary border border-2 border-white d-flex align-items-center justify-content-center overflow-hidden rounded flex-shrink-0" style="width: 25cqw; height: 30cqw; background-color: #ddd;">
                                <img id="preview-photo" src="" alt="Photo" style="width: 100%; height: 100%; object-fit: cover; display: none;">
                                <span id="preview-no-photo" style="font-size: 2.5cqw; color: #666;">NO PHOTO</span>
                            </div>

                            <!-- Details -->
                            <div class="flex-grow-1 d-flex flex-column justify-content-center text-white">
                                <div id="preview-name" style="font-size: 3.8cqw; font-weight: bold; text-transform: uppercase; border-bottom: 0.5cqw solid #fbbf24; padding-bottom: 0.5cqw; margin-bottom: 1cqw;">
                                    RESIDENT NAME
                                </div>
                                
                                <div class="d-flex align-items-baseline mb-1" style="font-size: 2.2cqw; margin-bottom: 0.5cqw !important;">
                                    <span style="color: #fcd34d; font-weight: bold; width: 16cqw;">Date of Birth</span>
                                    <span id="preview-dob" style="font-weight: 600;">-</span>
                                </div>
                                <div class="d-flex align-items-baseline mb-1" style="font-size: 2.2cqw; margin-bottom: 0.5cqw !important;">
                                    <span style="color: #fcd34d; font-weight: bold; width: 16cqw;">Sex</span>
                                    <span id="preview-sex" style="font-weight: 600;">-</span>
                                </div>
                                <div class="d-flex align-items-baseline mb-1" style="font-size: 2.2cqw; margin-bottom: 0.5cqw !important;">
                                    <span style="color: #fcd34d; font-weight: bold; width: 16cqw;">Nationality</span>
                                    <span id="preview-nationality" style="font-weight: 600;">FILIPINO</span>
                                </div>
                                <div class="d-flex align-items-baseline mb-1" style="font-size: 2.2cqw; margin-bottom: 0.5cqw !important;">
                                    <span style="color: #fcd34d; font-weight: bold; width: 16cqw;">Status</span>
                                    <span id="preview-status" style="font-weight: 600;">-</span>
                                </div>
                                <div class="d-flex align-items-baseline mb-1" style="font-size: 2.2cqw; margin-bottom: 0.5cqw !important;">
                                    <span style="color: #fcd34d; font-weight: bold; width: 16cqw;">Blood Type</span>
                                    <span id="preview-blood" style="font-weight: 600;">-</span>
                                </div>
                                <div class="d-flex align-items-baseline mb-1" style="font-size: 2.2cqw; margin-bottom: 0.5cqw !important;">
                                    <span style="color: #fcd34d; font-weight: bold; width: 16cqw;">Address</span>
                                    <span id="preview-address" style="font-weight: 600; font-size: 1.8cqw; line-height: 1.2;">-</span>
                                </div>
                                <div class="d-flex align-items-baseline mt-auto" style="font-size: 2.5cqw;">
                                    <span style="color: #fcd34d; font-weight: bold; margin-right: 1cqw;">ID No:</span>
                                    <span id="preview-id-no" style="font-weight: bold;">PENDING</span>
                                </div>
                            </div>

                            <!-- Barangay Chairman Signature -->
                            <div class="d-flex flex-column align-items-center justify-content-center" style="width: 25cqw; gap: 2cqw;">
                                <div class="text-center w-100 mt-auto">
                                    <img src="{{ asset('storage/signatures/chairman.jpg') }}" alt="Signature" style="max-width: 22cqw; max-height: 5cqw; object-fit: contain; margin-bottom: 0.5cqw; display: block; margin-left: auto; margin-right: auto;">
                                    <div style="border-top: 1px solid white; margin: 1cqw auto; width: 80%;"></div>
                                    <div style="font-size: 2cqw; font-weight: bold; color: white;">BARANGAY<br>CHAIRMAN</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- BACK PREVIEW -->
                    <div class="id-card-preview position-relative overflow-hidden shadow-sm" style="aspect-ratio: 1.586/1; background-color: #f8f9fa; border-radius: 8px; container-type: inline-size;">
                        <!-- Top Section: Emergency Contact Info -->
                        <div style="padding: 3.5cqw 4cqw; position: relative; z-index: 1;">
                            <div style="text-align: center; font-weight: bold; color: #CE1126; font-size: 2cqw; letter-spacing: 0.1em; margin-bottom: 2.5cqw; line-height: 1.2;">IN CASE OF EMERGENCY,<br>KINDLY NOTIFY:</div>
                            
                            <table style="width: 100%; font-size: 1.8cqw; border-collapse: collapse; margin-bottom: 1.5cqw;">
                                <tr style="line-height: 1.6;">
                                    <td style="font-weight: bold; color: #000; width: 18cqw; padding: 0 0.5cqw 0.8cqw 0;">NAME:</td>
                                    <td style="color: #000; font-weight: bold; padding: 0 0 0.8cqw 0;" id="preview-ec-name">_________________</td>
                                </tr>
                                <tr style="line-height: 1.6;">
                                    <td style="font-weight: bold; color: #000; width: 18cqw; padding: 0 0.5cqw 0.8cqw 0;">RELATION:</td>
                                    <td style="color: #000; font-weight: bold; padding: 0 0 0.8cqw 0;" id="preview-ec-relation">_________________</td>
                                </tr>
                                <tr style="line-height: 1.6;">
                                    <td style="font-weight: bold; color: #000; width: 18cqw; padding: 0 0.5cqw 0.8cqw 0;">ADDRESS:</td>
                                    <td style="color: #000; font-weight: bold; padding: 0 0 0.8cqw 0;" id="preview-ec-address">_________________</td>
                                </tr>
                                <tr style="line-height: 1.6;">
                                    <td style="font-weight: bold; color: #000; width: 18cqw; padding: 0 0.5cqw 0 0;">CONTACT NO.:</td>
                                    <td style="color: #000; font-weight: bold; padding: 0 0 0 0;" id="preview-ec-no">_________________</td>
                                </tr>
                            </table>

                            <!-- Emergency Hotline Section -->
                            <div style="text-align: center; font-weight: bold; color: #CE1126; font-size: 2cqw; letter-spacing: 0.1em; margin-top: 1.5cqw; margin-bottom: 1.5cqw; line-height: 1.2;">EMERGENCY HOTLINE</div>
                            
                            <div style="font-size: 1.6cqw; line-height: 1.5; text-align: center; color: #000; margin-bottom: 1.5cqw;">
                                <div style="font-weight: bold;">BARANGAY: (02) 874-26641</div>
                                <div style="font-weight: bold;">PASIG CITY: 643-0000</div>
                                <div style="font-weight: bold;">PNP: 911</div>
                                <div style="font-weight: bold;">BFP: 0932-779-8621</div>
                                <div style="font-weight: bold;">MERALCO: 16211</div>
                            </div>

                            <div style="text-align: center; font-size: 1.4cqw; color: #666;">
                                IF FOUND, PLEASE RETURN TO<br>KALAWAAN BARANGAY HALL
                            </div>
                        </div>

                        <!-- QR Code Section -->
                        <div style="position: absolute; bottom: 3cqw; right: 3cqw; text-align: center;">
                            <div class="bg-white p-1 rounded" style="width: 20cqw; height: 20cqw; display: flex; align-items: center; justify-content: center; border: 0.3cqw solid #000;">
                                <img id="preview-qr" alt="QR Code" style="width: 100%; height: 100%; object-fit: contain;">
                            </div>
                            <div id="preview-id-no-back" class="font-monospace fw-bold text-center" style="font-size: 1.2cqw; letter-spacing: 0.1em; color: #212529; width: 20cqw; margin-top: 0.5cqw;">QR CODE</div>
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
        currentResident = resident;
        searchInput.value = `${resident.first_name} ${resident.last_name}`;
        searchResults.style.display = 'none';
        
        // Update UI
        selectedResidentInfo.style.display = 'block';
        selectedNameDisplay.textContent = `${resident.first_name} ${resident.last_name}`;
        generatedInfo.style.display = 'none';
        
        // Update Preview
        emptyPreview.style.display = 'none';
        idPreviewContent.style.display = 'block';
        
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
        
        // Handle emergency contact relation
        const previewEcRelation = document.getElementById('preview-ec-relation');
        if (previewEcRelation) {
            previewEcRelation.textContent = resident.emergency_contact_relationship || '_____________________';
        }

        if (resident.profile_image) {
            previewPhoto.src = `/storage/${resident.profile_image}`;
            previewPhoto.style.display = 'block';
            previewNoPhoto.style.display = 'none';
        } else {
            previewPhoto.style.display = 'none';
            previewNoPhoto.style.display = 'block';
        }

        if (idData) {
            previewIdNo.textContent = idData.id_number;
            if (idData.qr_code) {
                previewQr.src = idData.qr_code;
            }
            previewValidity.textContent = idData.expiration_date;
        } else {
            previewIdNo.textContent = 'PENDING';
            previewQr.src = '';
            previewValidity.textContent = 'N/A';
        }
    }

    function generateID(resident) {
        generatingLoader.style.display = 'block';
        
        const issuedDate = new Date().toISOString().split('T')[0];
        
        // Calculate expiration date: resident created_at + 3 years
        const residentCreatedDate = new Date(resident.created_at);
        const year = residentCreatedDate.getFullYear() + 3;
        const month = residentCreatedDate.getMonth();
        const date = residentCreatedDate.getDate();
        const expirationDate = new Date(year, month, date).toISOString().split('T')[0];

        fetch('/api/ids/generate', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                resident_id: resident.id,
                issued_date: issuedDate,
                expiration_date: expirationDate
            })
        })
        .then(res => res.json())
        .then(data => {
            generatingLoader.style.display = 'none';
            if (data.success) {
                currentID = data.id;
                generatedInfo.style.display = 'block';
                generatedIdNo.textContent = data.id.id_number;
                updatePreview(resident, data.id);
            } else {
                alert('Failed to generate ID');
            }
        })
        .catch(err => {
            console.error(err);
            generatingLoader.style.display = 'none';
            alert('Error generating ID');
        });
    }

    // Print Handler
    printBtn.addEventListener('click', function() {
        if (!currentResident || !currentID) return;

        const printWindow = window.open('', '_blank');
        if (!printWindow) return;

        const idCardHTML = `
          <!DOCTYPE html>
          <html>
            <head>
              <meta charset="UTF-8">
              <title>Barangay ID Card - ${currentResident.first_name} ${currentResident.last_name}</title>
              <style>
                * { margin: 0; padding: 0; box-sizing: border-box; }
                body { font-family: Arial, sans-serif; background: #f0f0f0; display: flex; flex-direction: column; align-items: center; padding: 20px; }
                .page-container { display: flex; flex-direction: column; gap: 30px; margin-bottom: 20px; }
                .id-card { position: relative; width: 3.375in; height: 2.125in; background-color: #1a3a5c; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.2); display: flex; flex-direction: column; }
                
                /* FRONT SIDE STYLES */
                .front-header { background-color: #0f2741; color: white; padding: 8px 10px; position: relative; display: flex; align-items: center; justify-content: center; height: 50px; }
                .logo-placeholder { position: absolute; left: 10px; width: 35px; height: 35px; background-color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; overflow: hidden; border: 2px solid white; }
                .logo-placeholder img { width: 100%; height: 100%; object-fit: cover; }
                .header-text { text-align: center; line-height: 1.1; }
                .header-text h1 { font-size: 9px; font-weight: normal; letter-spacing: 1px; color: white; }
                .header-text h2 { font-size: 12px; font-weight: bold; margin: 2px 0; color: white; }
                .header-text h3 { font-size: 9px; font-weight: normal; color: white; }

                .front-body { flex: 1; padding: 10px 12px; display: flex; gap: 12px; background-color: #1a3a5c; }
                .photo-box { width: 85px; height: 110px; background-color: #ddd; border: 2px solid white; overflow: hidden; display: flex; align-items: center; justify-content: center; border-radius: 4px; }
                .photo-box img { width: 100%; height: 100%; object-fit: cover; }
                .details-col { flex: 1; display: flex; flex-direction: column; justify-content: center; }
                .resident-name { font-size: 13px; font-weight: bold; color: white; text-transform: uppercase; margin-bottom: 4px; border-bottom: 2px solid #fbbf24; padding-bottom: 3px; }
                .detail-row { display: flex; margin-bottom: 2px; font-size: 8px; align-items: baseline; }
                .detail-label { color: #fcd34d; font-weight: bold; margin-right: 6px; min-width: 55px; white-space: nowrap; }
                .detail-value { flex: 1; font-weight: 600; color: white; }
                .signature-area { margin-top: 6px; text-align: center; }
                .signature-line { border-top: 1px solid white; width: 90%; margin: 8px auto 2px; }
                .signature-label { font-size: 7px; color: white; }

                /* BACK SIDE STYLES */
                .back-header { background-color: #0f2741; color: white; padding: 8px; text-align: center; font-size: 11px; font-weight: bold; letter-spacing: 1px; }
                .back-body { flex: 1; padding: 12px 14px; display: flex; gap: 14px; background-color: #1a3a5c; }
                .emergency-col { flex: 1; display: flex; flex-direction: column; gap: 6px; }
                .emergency-title { font-size: 8px; font-weight: bold; color: #fcd34d; margin-bottom: 1px; }
                .emergency-value { font-size: 8px; color: white; font-weight: bold; min-height: 12px; }
                .qr-col { width: 80px; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 6px; }
                .qr-box { width: 75px; height: 75px; border: 2px solid white; padding: 2px; background-color: white; border-radius: 4px; }
                .qr-box img { width: 100%; height: 100%; }
                .validity-text { font-size: 7px; text-align: center; color: #fcd34d; font-weight: bold; line-height: 1.2; }
                .chairman-sig { text-align: center; width: 100%; margin-top: auto; }
                .chairman-line { border-top: 1px solid white; margin: 4px auto; width: 75%; }
                .chairman-label { font-size: 7px; font-weight: bold; color: white; margin-top: 1px; }
                .disclaimer { font-size: 6px; color: white; text-align: center; line-height: 1.1; margin-top: auto; }

                @media print {
                  @page { size: 3.375in 2.125in; margin: 0; }
                  html, body { margin: 0; padding: 0; width: 100%; height: 100%; }
                  body { display: block; background: white; }
                  .page-container { margin: 0; gap: 0; display: block; width: 100%; height: 100%; }
                  .id-card { margin: 0; border-radius: 0; box-shadow: none; page-break-after: always; width: 100%; height: 100%; max-width: none; max-height: none; overflow: hidden; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
                  .id-card:last-child { page-break-after: auto; }
                }
              </style>
            </head>
            <body>
              <div class="page-container">
                <!-- FRONT CARD -->
                <div class="id-card">
                  <div class="front-header">
                    <div class="logo-placeholder" style="padding: 4px; display: flex; align-items: center; justify-content: center; background: white;">
                      <img src="data:image/svg+xml;base64,PHN2ZyB2aWV3Qm94PSIwIDAgMjQgMjQiIGZpbGw9Im5vbmUiIHN0cm9rZT0iIzAwMzhBOCIgc3Ryb2tlLXdpZHRoPSIyIj48cGF0aCBkPSJNMyA5bDktNyA5IDd2MTFhMiAyIDAgMDEtMiAySDVhMiAyIDAgMDEtMiAySDVhMiAyIDAgMDEtMi0yeiIgLz48cG9seWxpbmUgcG9pbnRzPSI5IDIyIDkgMTIgMTUgMTIgMTUgMjIiIC8+PGxpbmUgeDE9IjkiIHkxPSI1IiB4Mj0iOSIgeTI9IjkiIC8+PGxpbmUgeDE9IjE1IiB5MT0iNSIgeDI9IjE1IiB5Mj0iOSIgLz48L3N2Zz4=" alt="Logo" style="width: 100%; height: 100%;" />
                    </div>
                    <div class="header-text">
                      <h1>Republic of the Philippines</h1>
                      <h1>National Capital Region</h1>
                      <h2>CITY OF PASIG</h2>
                      <h3>BARANGAY KALAWAAN</h3>
                    </div>
                  </div>
                  <div class="front-body">
                    <div class="photo-box">
                      ${currentResident.profile_image ? `<img src="/storage/${currentResident.profile_image}" alt="Photo" />` : '<span style="font-size: 9px; color: #999;">NO PHOTO</span>'}
                    </div>
                    <div class="details-col">
                      <div class="resident-name">
                        ${currentResident.first_name} ${currentResident.middle_name ? currentResident.middle_name[0] + '.' : ''} ${currentResident.last_name}
                      </div>
                      
                      <div class="detail-row">
                        <span class="detail-label">Date of Birth</span>
                        <span class="detail-value">${currentResident.birth_date || '-'}</span>
                      </div>
                      <div class="detail-row">
                        <span class="detail-label">Sex</span>
                        <span class="detail-value">${currentResident.gender || '-'}</span>
                      </div>
                      <div class="detail-row">
                        <span class="detail-label">Nationality</span>
                        <span class="detail-value">${currentResident.nationality || 'FILIPINO'}</span>
                      </div>
                      <div class="detail-row">
                        <span class="detail-label">Status</span>
                        <span class="detail-value">${currentResident.civil_status || '-'}</span>
                      </div>
                      <div class="detail-row">
                        <span class="detail-label">Blood Type</span>
                        <span class="detail-value">${currentResident.blood_type || '-'}</span>
                      </div>
                      <div class="detail-row">
                        <span class="detail-label">Address</span>
                        <span class="detail-value" style="font-size: 7px; line-height: 1.2;">
                          ${currentResident.address || '-'}
                        </span>
                      </div>
                      <div class="detail-row">
                        <span class="detail-label">ID No:</span>
                        <span class="detail-value" style="color: white; font-size: 9px;">${currentID.id_number}</span>
                      </div>

                      <div class="signature-area">
                        <div class="signature-line"></div>
                        <div class="signature-label">Signature of Resident</div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- BACK CARD -->
                <div class="id-card">
                  <div class="back-header">EMERGENCY CONTACT</div>
                  <div class="back-body">
                    <div class="emergency-col">
                      <div>
                        <div class="emergency-title">NAME</div>
                        <div class="emergency-value">${currentResident.emergency_contact_name || '_____________________'}</div>
                      </div>
                      <div>
                        <div class="emergency-title">ADDRESS</div>
                        <div class="emergency-value" style="min-height: 24px; line-height: 1.2;">${currentResident.emergency_contact_address || '_____________________'}</div>
                      </div>
                      <div>
                        <div class="emergency-title">CONTACT NO.</div>
                        <div class="emergency-value">${currentResident.emergency_contact_no || '_____________________'}</div>
                      </div>
                      
                      <div class="disclaimer">
                        This card is non-transferable.<br>Please report lost or found cards<br>to the Barangay Hall immediately.
                      </div>
                    </div>
                    
                    <div class="qr-col">
                      <div class="qr-box">
                        <img src="${currentID.qr_code}" alt="QR Code" />
                      </div>
                      
                      <div class="validity-text">
                        Valid Until<br>
                        <span style="color: white">${currentID.expiration_date || 'N/A'}</span>
                      </div>

                      <div class="chairman-sig">
                        <img src="{{ asset('storage/signatures/chairman.jpg') }}" alt="Signature" style="max-width: 75px; max-height: 35px; object-fit: contain; display: block; margin: 0 auto 4px;">
                        <div class="chairman-line"></div>
                        <div class="chairman-label">BARANGAY<br>CHAIRMAN</div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div style="text-align: center; color: white; margin-top: 20px; font-size: 10px;">
                QR Code Generated and Stored Permanently
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
</script>
@endsection
