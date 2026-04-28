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
                    <div class="id-card-preview mb-4 position-relative overflow-hidden shadow-sm" style="aspect-ratio: 1.586/1; border-radius: 8px; background-color: #f4f4f4;">
                      <img src="{{ asset('images/id-template-blank.png') }}" alt="ID Template" style="width: 100%; height: 100%; object-fit: cover; display: block;">

                      <!-- Photo -->
                      <div style="position: absolute; left: 6.2%; top: 29.5%; width: 19.5%; height: 40%; overflow: hidden; border-radius: 14px;">
                        <img id="preview-photo" src="" alt="Photo" style="width: 100%; height: 100%; object-fit: cover; display: none;">
                        <div id="preview-no-photo" style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #6c757d; font-size: 1.2cqw; font-weight: 600; background: rgba(220,220,220,0.55);">NO PHOTO</div>
                      </div>

                      <div style="position: absolute; left: 6.7%; top: 71.6%; width: 18.8%; text-align: center; font-size: 1.42cqw; font-weight: 900; color: #111; letter-spacing: 0.05em; white-space: nowrap; overflow: hidden; text-overflow: clip;">
                        <span id="preview-id-no">PENDING</span>
                      </div>

                      <div style="position: absolute; left: 7%; top: 78.8%; width: 18.5%; display: flex; justify-content: center; align-items: center;">
                        <div style="position: relative; width: 100%; height: 7cqw;">
                            <div style="position: absolute; left: 0; right: 0; bottom: 0.55cqw; border-top: 0.16cqw solid #111;"></div>
                            <img id="preview-signature" src="" alt="Signature" style="position: absolute; left: 50%; bottom: 0.95cqw; transform: translateX(-50%); z-index: 1; max-width: 100%; max-height: 5.1cqw; object-fit: contain; display: none; margin: 0 auto; background: transparent;">
                        </div>
                      </div>

                      <!-- Dynamic text overlays -->
                      <div id="preview-name" style="position: absolute; left: 29%; top: 32.3%; width: 65%; font-size: 3.08cqw; font-weight: 900; line-height: 1.03; text-transform: uppercase; color: #111; white-space: nowrap; overflow: hidden; text-overflow: clip;">-</div>
                      <div id="preview-address" style="position: absolute; left: 29.4%; top: 47.7%; width: 64.5%; height: 11.3%; font-size: 1.72cqw; font-weight: 900; line-height: 1.03; color: #111; text-transform: uppercase; white-space: normal; overflow: hidden; overflow-wrap: anywhere; word-break: break-word;">-</div>

                      <div id="preview-dob" style="position: absolute; left: 29.6%; top: 60.1%; width: 12.8%; height: 4.4%; display: flex; align-items: flex-end; justify-content: flex-start; font-size: 1.36cqw; font-weight: 800; line-height: 1; color: #111; white-space: nowrap; overflow: hidden; text-overflow: clip;">-</div>
                      <div id="preview-pob" style="position: absolute; left: 43%; top: 60.1%; width: 15.5%; height: 4.4%; display: flex; align-items: flex-end; justify-content: center; font-size: 1.28cqw; font-weight: 800; line-height: 1; color: #111; text-align: center; white-space: nowrap; overflow: hidden; text-overflow: clip;">-</div>
                      <div id="preview-status" style="position: absolute; left: 59.4%; top: 60.1%; width: 13.9%; height: 4.4%; display: flex; align-items: flex-end; justify-content: center; font-size: 1.24cqw; font-weight: 800; line-height: 1; color: #111; text-align: center; white-space: nowrap; overflow: hidden; text-overflow: clip;">-</div>
                      <div id="preview-nationality" style="position: absolute; left: 74%; top: 60.1%; width: 8.8%; height: 4.4%; display: flex; align-items: flex-end; justify-content: center; font-size: 1.2cqw; font-weight: 800; line-height: 1; color: #111; text-align: center; white-space: nowrap; overflow: hidden; text-overflow: clip;">-</div>
                      <div id="preview-sex" style="position: absolute; left: 84%; top: 60.1%; width: 9.2%; height: 4.4%; display: flex; align-items: flex-end; justify-content: center; font-size: 1.2cqw; font-weight: 800; line-height: 1; color: #111; text-align: center; white-space: nowrap; overflow: hidden; text-overflow: clip;">-</div>

                      <div id="preview-sector" style="position: absolute; left: 29%; top: 67.2%; width: 18%; height: 4.4%; display: flex; align-items: flex-end; justify-content: flex-start; font-size: 1.34cqw; font-weight: 800; color: #111; white-space: nowrap; overflow: hidden; text-overflow: clip;">-</div>
                    </div>

                    <!-- BACK PREVIEW -->
                    <div class="id-card-preview position-relative overflow-hidden shadow-sm" style="aspect-ratio: 1.586/1; background-color: #f8f9fa; border-radius: 8px; container-type: inline-size;">
                        <img src="{{ asset('images/back-id.png') }}" alt="ID Back Template" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; display: block;">
                        <!-- Top Section: Emergency Contact Info -->
                        <div style="padding: 3.5cqw 4cqw; position: relative; z-index: 1;">
                            <div style="text-align: center; font-weight: bold; color: #CE1126; font-size: 2cqw; letter-spacing: 0.1em; margin-bottom: 2.5cqw; line-height: 1.2;">IN CASE OF EMERGENCY,<br>KINDLY NOTIFY:</div>
                            
                            <table style="width: 100%; font-size: 1.8cqw; border-collapse: collapse; margin-bottom: 1.5cqw;">
                                <tr style="line-height: 1.6;">
                                    <td style="font-weight: bold; color: #000; width: 18cqw; padding: 0 0.5cqw 0.8cqw 0; text-align: right;">NAME:</td>
                                    <td style="color: #000; font-weight: bold; padding: 0 0 0.8cqw 1cqw;" id="preview-ec-name">_________________</td>
                                </tr>
                                <tr style="line-height: 1.6;">
                                    <td style="font-weight: bold; color: #000; width: 18cqw; padding: 0 0.5cqw 0.8cqw 0; text-align: right;">RELATION:</td>
                                    <td style="color: #000; font-weight: bold; padding: 0 0 0.8cqw 1cqw;" id="preview-ec-relation">_________________</td>
                                </tr>
                                <tr style="line-height: 1.6;">
                                    <td style="font-weight: bold; color: #000; width: 18cqw; padding: 0 0.5cqw 0.8cqw 0; text-align: right;">ADDRESS:</td>
                                    <td style="color: #000; font-weight: bold; padding: 0 0 0.8cqw 1cqw;" id="preview-ec-address">_________________</td>
                                </tr>
                                <tr style="line-height: 1.6;">
                                    <td style="font-weight: bold; color: #000; width: 18cqw; padding: 0 0.5cqw 0 0; text-align: right;">CONTACT NO.:</td>
                                    <td style="color: #000; font-weight: bold; padding: 0 0 0 1cqw;" id="preview-ec-no">_________________</td>
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
                            <div id="preview-validity" class="fw-bold text-center" style="font-size: 1.45cqw; line-height: 1.15; color: #212529; width: 20cqw; margin-top: 0.9cqw; white-space: normal;">VALID UNTIL</div>
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
    const previewPob = document.getElementById('preview-pob');
    const previewSex = document.getElementById('preview-sex');
    const previewNationality = document.getElementById('preview-nationality');
    const previewStatus = document.getElementById('preview-status');
    const previewSector = document.getElementById('preview-sector');
    const previewAddress = document.getElementById('preview-address');
    const previewIdNo = document.getElementById('preview-id-no');
    const previewSignature = document.getElementById('preview-signature');
    const previewEcName = document.getElementById('preview-ec-name');
    const previewEcAddress = document.getElementById('preview-ec-address');
    const previewEcNo = document.getElementById('preview-ec-no');
    const previewQr = document.getElementById('preview-qr');
    const previewValidity = document.getElementById('preview-validity');

    let currentResident = null;
    let currentID = null;
    let debounceTimer;

    function normalizeStreetAbbreviation(value) {
        if (!value) return '';
        return String(value)
            .replace(/\bST\b\.?/gi, 'ST.')
            .replace(/\bST\.\s*,\s*/gi, 'ST. ');
    }

    function formatAddressForCard(address) {
        if (!address) return '';

        let clean = String(address).trim();
        clean = clean.replace(/\bBRGY\.?\s*/gi, '');
        clean = clean.replace(/\bBARANGAY\s*/gi, '');
        clean = normalizeStreetAbbreviation(clean);
        clean = clean.replace(/^(\s*#?\s*\d+[A-Z0-9\-\/]*)\s*,\s*/i, '$1 ');
        clean = clean.replace(/\s*,\s*/g, ', ');
        clean = clean.replace(/\s+/g, ' ');
        clean = clean.replace(/,\s*,+/g, ', ');

        return clean.trim().replace(/^,|,$/g, '').trim();
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
      const suffix = resident.suffix ? ` ${resident.suffix}` : '';
      previewName.textContent = `${resident.last_name || ''}, ${resident.first_name || ''} ${resident.middle_name || ''}${suffix}`.trim();
      previewDob.textContent = resident.birth_date || '-';
      previewPob.textContent = resident.birth_place || resident.place_of_birth || '-';
        previewSex.textContent = resident.gender ? resident.gender.toUpperCase() : '-';
        previewNationality.textContent = resident.nationality || 'FILIPINO';
        previewStatus.textContent = resident.civil_status || '-';
      previewSector.textContent = resident.special_sector || '-';
        previewAddress.textContent = resident.address || '-';
        
        previewEcName.textContent = resident.emergency_contact_name || '_____________________';
        previewEcAddress.textContent = formatAddressForCard(resident.emergency_contact_address) || '_____________________';
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
          previewNoPhoto.style.display = 'flex';
        }

        if (resident.signature) {
            previewSignature.src = `/storage/${resident.signature}`;
            previewSignature.style.display = 'block';
        } else {
            previewSignature.src = '';
            previewSignature.style.display = 'none';
        }

        if (idData) {
            previewIdNo.textContent = idData.id_number;
            if (idData.qr_code) {
                previewQr.src = idData.qr_code;
            }
            previewValidity.textContent = `VALID UNTIL ${idData.expiration_date}`;
        } else {
            previewIdNo.textContent = 'PENDING';
            previewQr.src = '';
            previewValidity.textContent = 'VALID UNTIL -';
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

        const fullName = `${currentResident.last_name || ''}, ${currentResident.first_name || ''} ${currentResident.middle_name || ''} ${currentResident.suffix || ''}`.trim();
        const placeOfBirth = currentResident.birth_place || currentResident.place_of_birth || '-';
        const sector = currentResident.special_sector || '-';
        const templateImage = @json(asset('images/id-template-blank.png'));
        const backTemplateImage = @json(asset('images/back-id.png'));

        async function getImageBase64(url) {
            if (!url) return '';
            try {
                const response = await fetch(url);
                const blob = await response.blob();
                return await new Promise((resolve) => {
                    const reader = new FileReader();
                    reader.onloadend = () => resolve(reader.result);
                    reader.readAsDataURL(blob);
                });
            } catch (error) {
                console.error('Error loading image for print:', error);
                return url;
            }
        }

        Promise.all([
            getImageBase64(templateImage),
            getImageBase64(backTemplateImage),
            getImageBase64(currentResident.profile_image ? `/storage/${currentResident.profile_image}` : ''),
            getImageBase64(currentResident.signature ? `/storage/${currentResident.signature}` : ''),
            getImageBase64(currentID.qr_code || '')
        ]).then(([frontTemplateSrc, backTemplateSrc, photoSrc, signatureSrc, qrSrc]) => {
        const frontAddress = formatAddressForCard(currentResident.address) || '-';
        const emergencyAddress = formatAddressForCard(currentResident.emergency_contact_address) || '_____________________';

        const idCardHTML = `
          <!DOCTYPE html>
          <html>
            <head>
              <meta charset="UTF-8">
              <title>Barangay ID Card - ${currentResident.first_name} ${currentResident.last_name}</title>
              <style>
                * { margin: 0; padding: 0; box-sizing: border-box; }
                html, body { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; color-adjust: exact !important; }
                body { font-family: Arial, sans-serif; background: #f0f0f0; display: flex; flex-direction: column; align-items: center; padding: 20px; }
                .page-container { display: flex; flex-direction: column; gap: 30px; margin-bottom: 20px; }
                .id-card { position: relative; width: 3.375in; height: 2.125in; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.2); display: flex; flex-direction: column; }

                .front-card { background: #f4f4f4; }
                .front-bg { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; }
                .front-photo { position: absolute; left: 6.2%; top: 29.5%; width: 19.5%; height: 40%; object-fit: cover; border-radius: 8px; background: #d8d8d8; }
                .front-text { position: absolute; color: #111; font-weight: 800; line-height: 1.05; overflow: hidden; }
                .f-name { left: 29%; top: 32.3%; width: 65%; font-size: 13.5px; font-weight: 900; text-transform: uppercase; white-space: nowrap; }
                .f-address { left: 29.4%; top: 47.7%; width: 64.5%; height: 11.3%; font-size: 8.8px; font-weight: 900; text-transform: uppercase; white-space: normal; overflow-wrap: anywhere; word-break: break-word; }
                .f-dob { left: 29.6%; top: 60.1%; width: 12.8%; height: 4.4%; display: flex; align-items: flex-end; justify-content: flex-start; font-size: 7.8px; white-space: nowrap; }
                .f-pob { left: 43%; top: 60.1%; width: 15.5%; height: 4.4%; display: flex; align-items: flex-end; justify-content: center; font-size: 7.2px; text-align: center; white-space: nowrap; }
                .f-status { left: 59.4%; top: 60.1%; width: 13.9%; height: 4.4%; display: flex; align-items: flex-end; justify-content: center; font-size: 7px; text-align: center; white-space: nowrap; }
                .f-nationality { left: 74%; top: 60.1%; width: 8.8%; height: 4.4%; display: flex; align-items: flex-end; justify-content: center; font-size: 6.8px; text-align: center; white-space: nowrap; }
                .f-sex { left: 84%; top: 60.1%; width: 9.2%; height: 4.4%; display: flex; align-items: flex-end; justify-content: center; font-size: 6.8px; text-align: center; white-space: nowrap; }
                .f-sector { left: 29%; top: 67.2%; width: 18%; height: 4.4%; display: flex; align-items: flex-end; justify-content: flex-start; font-size: 7.6px; white-space: nowrap; }
                .f-id { left: 6.7%; top: 71.6%; width: 18.8%; text-align: center; font-size: 8px; font-weight: 900; letter-spacing: 0.05em; white-space: nowrap; }
                .f-signature-wrap { position: absolute; left: 7%; top: 78.8%; width: 18.5%; display: flex; justify-content: center; align-items: center; }
                .f-signature-line { position: relative; width: 100%; height: 18px; }
                .f-signature-line::after { content: ''; position: absolute; left: 0; right: 0; bottom: 2px; border-top: 1px solid #111; }
                .f-signature { position: absolute; left: 50%; bottom: 4px; transform: translateX(-50%); z-index: 1; max-width: 100%; max-height: 13px; object-fit: contain; display: block; margin: 0 auto; }

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
                .chairman-label { font-size: 7px; font-weight: bold; color: white; margin-top: 1px; }
                .disclaimer { font-size: 6px; color: white; text-align: center; line-height: 1.1; margin-top: auto; }

                @media print {
                  @page { size: 3.375in 2.125in; margin: 0; }
                  html, body { margin: 0; padding: 0; width: 100%; height: 100%; }
                  body { display: block; background: white; }
                  .page-container { margin: 0; gap: 0; display: block; width: 100%; height: 100%; }
                  .id-card { margin: 0; border-radius: 0; box-shadow: none; page-break-after: always; width: 100%; height: 100%; -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; color-adjust: exact !important; }
                  .id-card:last-child { page-break-after: auto; }
                }
              </style>
            </head>
            <body>
              <div class="page-container">
                <div class="id-card front-card">
                  <img class="front-bg" src="${frontTemplateSrc}" alt="ID Template" />
                  ${photoSrc ? `<img class="front-photo" src="${photoSrc}" alt="Photo" />` : ''}

                  <div class="front-text f-name">${fullName || '-'}</div>
                  <div class="front-text f-address">${frontAddress}</div>
                  <div class="front-text f-dob">${currentResident.birth_date || '-'}</div>
                  <div class="front-text f-pob">${placeOfBirth}</div>
                  <div class="front-text f-status">${currentResident.civil_status || '-'}</div>
                  <div class="front-text f-nationality">${currentResident.nationality || 'FILIPINO'}</div>
                  <div class="front-text f-sex">${(currentResident.gender || '-').toUpperCase()}</div>
                  <div class="front-text f-sector">${sector}</div>
                  <div class="front-text f-id">${currentID.id_number || '-'}</div>
                  <div class="f-signature-wrap">
                    <div class="f-signature-line">
                      ${signatureSrc ? `<img class="f-signature" src="${signatureSrc}" alt="Signature" />` : ''}
                    </div>
                  </div>
                </div>

                <div class="id-card">
                  <img class="front-bg" src="${backTemplateSrc}" alt="ID Back Template" />
                  <div class="back-header">EMERGENCY CONTACT</div>
                  <div class="back-body">
                    <div class="emergency-col">
                      <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                          <td class="emergency-title" style="text-align: right; padding-right: 6px; white-space: nowrap; vertical-align: top;">NAME:</td>
                          <td class="emergency-value">${currentResident.emergency_contact_name || '_____________________'}</td>
                        </tr>
                        <tr>
                          <td class="emergency-title" style="text-align: right; padding-right: 6px; white-space: nowrap; vertical-align: top;">RELATION:</td>
                          <td class="emergency-value">${currentResident.emergency_contact_relationship || '_____________________'}</td>
                        </tr>
                        <tr>
                          <td class="emergency-title" style="text-align: right; padding-right: 6px; white-space: nowrap; vertical-align: top;">ADDRESS:</td>
                          <td class="emergency-value" style="min-height: 24px; line-height: 1.2;">${emergencyAddress}</td>
                        </tr>
                        <tr>
                          <td class="emergency-title" style="text-align: right; padding-right: 6px; white-space: nowrap; vertical-align: top;">CONTACT NO.:</td>
                          <td class="emergency-value">${currentResident.emergency_contact_no || '_____________________'}</td>
                        </tr>
                      </table>

                      <div class="disclaimer">
                        This card is non-transferable.<br>Please report lost or found cards<br>to the Barangay Hall immediately.
                      </div>
                    </div>

                    <div class="qr-col">
                      <div class="qr-box">
                        ${qrSrc ? `<img src="${qrSrc}" alt="QR Code" />` : ''}
                      </div>

                      <div class="validity-text" style="font-size: 9px;">
                        VALID UNTIL<br>
                        <span style="color: white; font-size: 9px;">${currentID.expiration_date || 'N/A'}</span>
                      </div>

                      <div class="chairman-sig">
                        <div class="chairman-label">BARANGAY<br>KALAWAAN</div>
                      </div>
                    </div>
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
