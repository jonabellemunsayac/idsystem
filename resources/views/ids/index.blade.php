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

                        <div style="position: absolute; left: 3.7%; top: 76.5%; width: 26.8%; height: 10.5%; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                            <img id="preview-signature" src="" alt="Signature" style="max-width: 100%; max-height: 100%; object-fit: contain; display: none;">
                        </div>

                        <div id="preview-name" style="position: absolute; left: 29.4%; top: 33.3%; width: 64.6%; height: 8.4%; font-size: 18px; font-weight: 900; line-height: 1.02; text-align: left; text-transform: uppercase; color: #111; white-space: nowrap; overflow: hidden; text-overflow: clip;">-</div>
                        <div id="preview-address" style="position: absolute; left: 29.4%; top: 46.4%; width: 64.5%; height: 11.8%; font-size: 11.6px; font-weight: 900; line-height: 1.05; color: #111; text-align: left; text-transform: uppercase; white-space: normal; overflow: hidden; text-overflow: clip; overflow-wrap: anywhere; word-break: break-word; letter-spacing: 0.08px; word-spacing: 0.35px;">-</div>

                        <div id="preview-dob" style="position: absolute; left: 29.4%; top: 59.6%; width: 13.2%; height: 4.2%; display: flex; align-items: flex-start; justify-content: flex-start; font-size: 11.6px; font-weight: 900; line-height: 1; color: #111; text-align: left; white-space: nowrap; overflow: hidden; text-overflow: clip;">-</div>
                        <div id="preview-status" style="position: absolute; left: 46.7%; top: 59.6%; width: 11.5%; height: 4.2%; display: flex; align-items: flex-start; justify-content: flex-start; font-size: 11px; font-weight: 900; line-height: 1; color: #111; text-align: left; white-space: nowrap; overflow: hidden; text-overflow: clip;">-</div>
                        <div id="preview-nationality" style="position: absolute; left: 59.1%; top: 59.6%; width: 11.4%; height: 4.2%; display: flex; align-items: flex-start; justify-content: flex-start; font-size: 11px; font-weight: 900; line-height: 1; color: #111; text-align: left; white-space: nowrap; overflow: hidden; text-overflow: clip;">-</div>
                        <div id="preview-sex" style="position: absolute; left: 72%; top: 59.6%; width: 6.4%; height: 4.2%; display: flex; align-items: flex-start; justify-content: flex-start; font-size: 11px; font-weight: 900; line-height: 1; color: #111; text-align: left; white-space: nowrap; overflow: hidden; text-overflow: clip;">-</div>
                        <div id="preview-sector" style="position: absolute; left: 78.9%; top: 59.6%; width: 14.1%; height: 4.2%; display: flex; align-items: flex-start; justify-content: flex-start; font-size: 11px; font-weight: 900; line-height: 1; color: #111; text-align: left; white-space: nowrap; overflow: hidden; text-overflow: clip;">-</div>

                        <div id="preview-id-no" style="position: absolute; left: 7%; top: 70%; width: 18.2%; font-size: 9.8px; font-weight: 900; text-align: center; color: #111; white-space: nowrap; overflow: hidden; text-overflow: clip; letter-spacing: 0.05px;">PENDING</div>

                        <div style="position: absolute; left: 79.6%; top: 68.5%; width: 14%; height: 20.8%; border: 1px solid #000; background: #fff; display: flex; align-items: center; justify-content: center; padding: 2px;">
                            <img id="preview-qr-front" alt="QR Code" style="width: 100%; height: 100%; object-fit: contain; display: none;">
                        </div>
                        <div id="preview-validity" style="position: absolute; left: 78.6%; top: 90.9%; width: 16%; font-size: 5.4px; font-weight: 900; text-align: center; color: #111; white-space: nowrap; overflow: hidden; text-overflow: clip; letter-spacing: -0.22px;">VALID UNTIL: -</div>
                    </div>

                    <!-- BACK PREVIEW -->
                    <div class="id-card-preview position-relative overflow-hidden shadow-sm" style="aspect-ratio: 1.586/1; width: 100%; max-width: 600px; margin: 0 auto; background-color: #f8f9fa; border-radius: 12px; font-family: sans-serif; container-type: inline-size;">
                        <img src="{{ asset('images/back-id.png') }}" alt="ID Back Template" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; display: block;">

                        <!-- Top Section: Emergency Contact Info -->
                        <div style="padding: 3.56cqw 4.15cqw; position: relative; z-index: 1;">
                            <div style="text-align: center; font-weight: bold; color: #fff; font-size: 3.26cqw; letter-spacing: 0.15cqw; margin-bottom: 3.56cqw; line-height: 1.2;">IN CASE OF EMERGENCY, KINDLY NOTIFY:</div>
                            
                            <table style="width: 100%; font-size: 2.67cqw; border-collapse: collapse; margin-bottom: 1.19cqw;">
                                <tr style="line-height: 1.38;">
                                    <td style="font-weight: bold; color: #000; width: 25.2cqw; padding: 0 1.19cqw 0.89cqw 0; text-align: right; white-space: nowrap;">NAME :</td>
                                    <td style="color: #000; font-weight: bold; padding: 0 0 0.89cqw 1.19cqw; text-transform: uppercase;" id="preview-ec-name">_________________</td>
                                </tr>
                                <tr style="line-height: 1.38;">
                                    <td style="font-weight: bold; color: #000; width: 25.2cqw; padding: 0 1.19cqw 0.89cqw 0; text-align: right; white-space: nowrap;">RELATION :</td>
                                    <td style="color: #000; font-weight: bold; padding: 0 0 0.89cqw 1.19cqw; text-transform: uppercase;" id="preview-ec-relation">_________________</td>
                                </tr>
                                <tr style="line-height: 1.38;">
                                    <td style="font-weight: bold; color: #000; width: 25.2cqw; padding: 0 1.19cqw 0.89cqw 0; text-align: right; white-space: nowrap;">ADDRESS :</td>
                                    <td style="color: #000; font-weight: bold; padding: 0 0 0.89cqw 1.19cqw; text-transform: uppercase; white-space: normal; overflow-wrap: anywhere; line-height: 1.18; letter-spacing: 0.08cqw; word-spacing: 0.12cqw;" id="preview-ec-address">_________________</td>
                                </tr>
                                <tr style="line-height: 1.38;">
                                    <td style="font-weight: bold; color: #000; width: 25.2cqw; padding: 0 1.19cqw 0 0; text-align: right; white-space: nowrap;">CONTACT NO. :</td>
                                    <td style="color: #000; font-weight: bold; padding: 0 0 0 1.19cqw; text-transform: uppercase;" id="preview-ec-no">_________________</td>
                                </tr>
                            </table>

                            <!-- Emergency Hotline Section -->
                            <div style="text-align: center; font-weight: bold; color: #0038A8; font-size: 2.67cqw; letter-spacing: 0.15cqw; margin-top: 1.19cqw; margin-bottom: 0.89cqw; line-height: 1.1;">EMERGENCY HOTLINE</div>
                            
                            <div style="display: flex; justify-content: center;">
                                <table style="font-size: 2.37cqw; border-collapse: collapse; margin-bottom: 0.59cqw;">
                                    <tr style="line-height: 1.4;">
                                        <td style="font-weight: bold; color: #000; padding: 0 1.19cqw 0.59cqw 0; text-align: right; white-space: nowrap;">BARANGAY :</td>
                                        <td style="color: #000; font-weight: bold; padding: 0 0 0.59cqw 1.19cqw;">(02) 874-26641 / 0966-007-7440</td>
                                    </tr>
                                    <tr style="line-height: 1.4;">
                                        <td style="font-weight: bold; color: #000; padding: 0 1.19cqw 0.59cqw 0; text-align: right; white-space: nowrap;">PASIG CITY HOTLINE :</td>
                                        <td style="color: #000; font-weight: bold; padding: 0 0 0.59cqw 1.19cqw;">643-0000</td>
                                    </tr>
                                    <tr style="line-height: 1.4;">
                                        <td style="font-weight: bold; color: #000; padding: 0 1.19cqw 0.59cqw 0; text-align: right; white-space: nowrap;">PNP :</td>
                                        <td style="color: #000; font-weight: bold; padding: 0 0 0.59cqw 1.19cqw;">911</td>
                                    </tr>
                                    <tr style="line-height: 1.4;">
                                        <td style="font-weight: bold; color: #000; padding: 0 1.19cqw 0.59cqw 0; text-align: right; white-space: nowrap;">BFP-PASIG HOTLINE :</td>
                                        <td style="color: #000; font-weight: bold; padding: 0 0 0.59cqw 1.19cqw;">0932-779-8621</td>
                                    </tr>
                                    <tr style="line-height: 1.4;">
                                        <td style="font-weight: bold; color: #000; padding: 0 1.19cqw 0 0; text-align: right; white-space: nowrap;">MERALCO :</td>
                                        <td style="color: #000; font-weight: bold; padding: 0 0 0 1.19cqw;">16211</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- IF FOUND Text - Bottom Section -->
                        <div style="position: absolute; bottom: 1.78cqw; left: 2.96cqw; right: 2.96cqw; text-align: center; z-index: 2;">
                            <div style="font-size: 1.48cqw; color: #666; line-height: 1.2;">
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
    const FIXED_VALIDITY_DATE = '2029-12-31';

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
        return d.toLocaleDateString('en-US', { month: 'short', year: 'numeric' });
    }

    function formatValidityLabel(dateStr) {
        return `VALID UNTIL: ${(formatMonthYear(dateStr) || '-').toUpperCase()}`;
    }

    function formatDisplayName(resident) {
        const last = (resident.last_name || '').trim();
        const first = (resident.first_name || '').trim();
        const suffix = String(resident.suffix || '').replace(/\./g, '').trim();
        const middle = (resident.middle_name || '').trim();

        const firstWithSuffix = [first, suffix].filter(Boolean).join(' ');
        const trailing = [firstWithSuffix, middle].filter(Boolean).join(', ');

        if (last && trailing) return `${last}, ${trailing}`;
        return last || trailing || '-';
    }

    function normalizeStreetAbbreviation(value) {
        if (!value) return '';
        return String(value)
            .replace(/\bST\b\.?/gi, 'ST.')
            .replace(/\bST\.\s*,\s*/gi, 'ST. ');
    }

    function formatAddressForCard(address) {
        if (!address) return '-';

        let clean = String(address).trim();
        clean = clean.replace(/\bBRGY\.?\s*/gi, '');
        clean = clean.replace(/\bBARANGAY\s*/gi, '');
        clean = normalizeStreetAbbreviation(clean);
        clean = clean.replace(/^(\s*#?\s*\d+[A-Z0-9\-\/]*)\s*,\s*/i, '$1 ');
        clean = clean.replace(/\s*,\s*/g, ', ');
        clean = clean.replace(/\s+/g, ' ');
        clean = clean.replace(/,\s*,+/g, ', ');
        clean = clean.trim().replace(/^,|,$/g, '').trim();

        return clean || '-';
    }

    function formatEmergencyAddressForCard(address) {
        const formatted = formatAddressForCard(address);
        return formatted === '-' ? '' : formatted;
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

    function getSectorLeftPosition(sector) {
        return '78.9%';
    }

    function formatSexShort(sex) {
        const normalized = String(sex || '').trim().toLowerCase();
        if (normalized === 'male') return 'M';
        if (normalized === 'female') return 'F';
        return sex || '-';
    }

    function fitFontSize(text, base, min, maxChars) {
        if (!text) return base;
        const ratio = Math.max(0, (text.length - maxChars) / maxChars);
        const size = base - (base - min) * Math.min(1, ratio);
        return Number(size.toFixed(2));
    }

    function applyFittedNameFont(element, text, base, min, maxChars) {
        if (!element) return;

        const normalized = String(text || '').replace(/\s+/g, ' ').trim();
        element.style.whiteSpace = normalized.length > maxChars + 8 ? 'normal' : 'nowrap';
        element.style.overflowWrap = normalized.length > maxChars + 8 ? 'break-word' : '';
        element.style.wordBreak = normalized.length > maxChars + 8 ? 'normal' : '';
        element.style.lineHeight = normalized.length > maxChars + 8 ? '1.02' : '1.08';

        const size = fitFontSize(text, base, min, maxChars);
        element.style.fontSize = `${size}px`;
        fitElementToWidth(element, min, 0.25);

        // Run a second pass once layout settles to avoid occasional clipping.
        requestAnimationFrame(() => fitElementToWidth(element, min, 0.25));
    }

    function fitElementToWidth(element, min, step = 0.2) {
        if (!element) return;

        let size = Number(parseFloat(element.style.fontSize || '0').toFixed(2));
        if (!size) return;

        while (element.scrollWidth > element.clientWidth && size > min) {
            size = Number((size - step).toFixed(2));
            element.style.fontSize = `${size}px`;
        }
    }

    function applyFittedFieldFont(element, text, base, min, maxChars) {
        if (!element) return;

        const size = fitFontSize(text, base, min, maxChars);
        element.style.fontSize = `${size}px`;
        fitElementToWidth(element, min);

        // Run a second pass once layout settles to avoid occasional clipping.
        requestAnimationFrame(() => fitElementToWidth(element, min));
    }

    function fitAddressBlock(element, text, base, min, maxChars) {
        if (!element) return;

        const normalized = String(text || '').replace(/\s+/g, ' ').trim();
        const isLong = normalized.length > maxChars;

        element.style.whiteSpace = 'normal';
        element.style.overflowWrap = 'anywhere';
        element.style.wordBreak = 'break-word';
        element.style.lineHeight = isLong ? '0.98' : '1.05';

        const size = fitFontSize(normalized, base, min, maxChars);
        element.style.fontSize = `${size}px`;

        function shrinkToFit() {
            let currentSize = Number(parseFloat(element.style.fontSize || '0').toFixed(2));
            while ((element.scrollHeight > element.clientHeight || element.scrollWidth > element.clientWidth) && currentSize > min) {
                currentSize = Number((currentSize - 0.2).toFixed(2));
                element.style.fontSize = `${currentSize}px`;
            }
        }

        shrinkToFit();
        requestAnimationFrame(shrinkToFit);
    }

    function getSectorFontSettings(forPrint = false) {
        if (forPrint) {
            return { base: 6.1, min: 4.1, maxChars: 10 };
        }

        return { base: 11, min: 6.6, maxChars: 10 };
    }

    function getNameFontSettings(forPrint = false) {
        if (forPrint) {
            return { base: 9.4, min: 5.8, maxChars: 30 };
        }

        return { base: 18, min: 9, maxChars: 30 };
    }

    function getAddressFontSettings(forPrint = false) {
        if (forPrint) {
            return { base: 7, min: 5.6, maxChars: 58 };
        }

        return { base: 11.6, min: 8.8, maxChars: 58 };
    }

    function updatePreview(resident, idData = null) {
        const fullName = formatDisplayName(resident);
        previewName.textContent = fullName || '-';
        const nameFontSettings = getNameFontSettings(false);
        applyFittedNameFont(
            previewName,
            fullName,
            nameFontSettings.base,
            nameFontSettings.min,
            nameFontSettings.maxChars
        );
        previewDob.textContent = formatDate(resident.birth_date);
        previewSex.textContent = formatSexShort(resident.gender);
        previewNationality.textContent = resident.nationality || 'FILIPINO';
        previewStatus.textContent = resident.civil_status || '-';
        applyFittedFieldFont(previewDob, previewDob.textContent, 11.6, 8, 12);
        applyFittedFieldFont(previewSex, previewSex.textContent, 11, 8, 2);
        applyFittedFieldFont(previewNationality, previewNationality.textContent, 11, 7.2, 9);
        if (previewSector) {
            previewSector.textContent = resident.special_sector || '-';
            previewSector.style.left = getSectorLeftPosition(resident.special_sector);
            const sectorFontSettings = getSectorFontSettings(false);
            applyFittedFieldFont(
                previewSector,
                previewSector.textContent,
                sectorFontSettings.base,
                sectorFontSettings.min,
                sectorFontSettings.maxChars
            );
        }
        applyFittedFieldFont(previewStatus, previewStatus.textContent, 11, 7.2, 12);

        const formattedAddress = formatAddressForCard(resident.address).toUpperCase();
        previewAddress.textContent = formattedAddress;
        previewAddress.style.fontWeight = '900';
        previewAddress.style.letterSpacing = '0.08px';
        previewAddress.style.wordSpacing = '0.35px';
        const addressFontSettings = getAddressFontSettings(false);
        fitAddressBlock(
            previewAddress,
            formattedAddress,
            addressFontSettings.base,
            addressFontSettings.min,
            addressFontSettings.maxChars
        );
        
        previewEcName.textContent = resident.emergency_contact_name || '_____________________';
        const emergencyAddress = formatEmergencyAddressForCard(resident.emergency_contact_address) || '_____________________';
        previewEcAddress.textContent = emergencyAddress;
        previewEcAddress.style.fontSize = `${fitFontSize(emergencyAddress, 15.2, 9.2, 34)}px`;
        previewEcAddress.style.whiteSpace = 'normal';
        previewEcAddress.style.overflowWrap = 'anywhere';
        previewEcAddress.style.lineHeight = '1.24';
        previewEcAddress.style.letterSpacing = '0.45px';
        previewEcAddress.style.wordSpacing = '0.75px';
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
            if (previewIdNo) {
                const idText = (idData.id_number || 'PENDING').replace(/\s+/g, ' ').trim();
                previewIdNo.textContent = idText;
                applyFittedFieldFont(previewIdNo, idText, 9.8, 6.6, 14);
            }
            if (idData.qr_code) {
                if (previewQrFront) {
                    previewQrFront.src = idData.qr_code;
                    previewQrFront.style.display = 'block';
                }
            }
            previewValidity.textContent = formatValidityLabel(idData.expiration_date);
            applyFittedFieldFont(previewValidity, previewValidity.textContent, 5.4, 3.8, 18);
        } else {
            if (previewIdNo) {
                const pendingText = 'PENDING';
                previewIdNo.textContent = pendingText;
                applyFittedFieldFont(previewIdNo, pendingText, 9.8, 6.6, 14);
            }
            if (previewQrFront) {
                previewQrFront.src = '';
                previewQrFront.style.display = 'none';
            }
            previewValidity.textContent = formatValidityLabel(FIXED_VALIDITY_DATE);
            applyFittedFieldFont(previewValidity, previewValidity.textContent, 5.4, 3.8, 18);
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
        const expirationDate = FIXED_VALIDITY_DATE;

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
        const backTemplateUrl = `${window.location.protocol}//${window.location.host}/images/back-id.png`;

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
            getImageBase64(templateUrl),
            getImageBase64(backTemplateUrl)
        ]).then(([photoBase64, signatureBase64, templateBase64, backTemplateBase64]) => {
            const photoSrc = photoBase64;
            const signatureSrc = signatureBase64;
            const templateSrc = templateBase64 || templateUrl;
            const backTemplateSrc = backTemplateBase64 || backTemplateUrl;
            const fullNamePrint = formatDisplayName(currentResident).replace(/\s+/g, ' ').trim();
            const addressPrint = formatAddressForCard(currentResident.address).replace(/\s+/g, ' ').trim();
            const sectorPrint = (currentResident.special_sector || '-').replace(/\s+/g, ' ').trim();
            const sectorLeftPrint = getSectorLeftPosition(currentResident.special_sector);
            const statusPrint = (currentResident.civil_status || '-').replace(/\s+/g, ' ').trim();
            const ecAddressPrint = (formatEmergencyAddressForCard(currentResident.emergency_contact_address) || '_________________').replace(/\s+/g, ' ').trim();
            const idNumberPrint = (currentID.id_number || '-').replace(/\s+/g, ' ').trim();
            const validityPrint = formatValidityLabel(currentID.expiration_date);

            const nameFontSettings = getNameFontSettings(true);
            const nameIsLong = fullNamePrint.length > nameFontSettings.maxChars + 8;
            const addressFontSettings = getAddressFontSettings(true);
            const nameFont = fitFontSize(fullNamePrint, nameFontSettings.base, nameFontSettings.min, nameFontSettings.maxChars);
            const addressFont = fitFontSize(addressPrint, addressFontSettings.base, addressFontSettings.min, addressFontSettings.maxChars);
            const addressIsLong = addressPrint.length > addressFontSettings.maxChars;
            const sectorFontSettings = getSectorFontSettings(true);
            const sectorFont = fitFontSize(
                sectorPrint,
                sectorFontSettings.base,
                sectorFontSettings.min,
                sectorFontSettings.maxChars
            );
            const statusFont = fitFontSize(statusPrint, 6.3, 4.6, 12);
            const ecAddressFont = fitFontSize(ecAddressPrint, 9, 6.6, 32);
            const dobFont = fitFontSize(formatDate(currentResident.birth_date), 6.3, 4.6, 12);
            const nationalityFont = fitFontSize(currentResident.nationality || 'FILIPINO', 6.1, 4.4, 9);
            const sexFont = fitFontSize(formatSexShort(currentResident.gender), 6.1, 4.8, 2);
            const validityFont = fitFontSize(validityPrint, 4.15, 3.05, 18);
            const printNameStyle = 'font-family: "Arial Black", "Segoe UI", Arial, sans-serif; color: #0a1f4d; text-shadow: 0 0 1.2px rgba(255,255,255,0.95), 0 0 0.6px rgba(255,255,255,0.9);';
            const printValueStyle = 'font-family: "Segoe UI", Arial, sans-serif; color: #101828; text-shadow: 0 0 1px rgba(255,255,255,0.95), 0 0 0.4px rgba(255,255,255,0.9);';
            const printStrongStyle = 'font-family: "Arial Black", "Segoe UI", Arial, sans-serif; color: #07193d; text-shadow: 0 0 1.2px rgba(255,255,255,0.95), 0 0 0.6px rgba(255,255,255,0.9);';

                const frontCardHTML = `
                            <div class="id-card" style="position: relative; width: 3.375in; height: 2.125in; overflow: hidden;">
                                <img src="${templateSrc}" alt="Template" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover;">

                                <div style="position: absolute; left: 6.2%; top: 29.5%; width: 19.5%; height: 40%; overflow: hidden; border-radius: 8px; background: #d8d8d8; display: flex; align-items: center; justify-content: center;">
                                    ${photoSrc ? `<img src="${photoSrc}" alt="Photo" style="width: 100%; height: 100%; object-fit: cover;">` : '<span style="font-size: 8px; color: #666; font-weight: bold;">NO PHOTO</span>'}
                                </div>

                                <div style="position: absolute; left: 29.4%; top: 33.3%; width: 64.6%; height: 8.4%; font-size: ${nameFont}px; font-weight: 900; line-height: ${nameIsLong ? '1.02' : '1.08'}; text-align: left; text-transform: uppercase; white-space: ${nameIsLong ? 'normal' : 'nowrap'}; overflow: hidden; overflow-wrap: ${nameIsLong ? 'break-word' : 'normal'}; letter-spacing: 0.08px; ${printNameStyle}">${fullNamePrint || '-'}</div>
                                <div style="position: absolute; left: 29.4%; top: 46.4%; width: 64.5%; height: 11.8%; font-size: ${addressFont}px; font-weight: 900; line-height: ${addressIsLong ? '0.98' : '1.05'}; text-align: left; text-transform: uppercase; white-space: normal; overflow: hidden; overflow-wrap: anywhere; word-break: break-word; letter-spacing: 0.08px; word-spacing: 0.35px; ${printValueStyle}">${addressPrint}</div>

                                <div style="position: absolute; left: 29.4%; top: 59.6%; width: 13.2%; height: 4.2%; display: flex; align-items: flex-start; justify-content: flex-start; font-size: ${dobFont}px; font-weight: 900; text-align: left; white-space: nowrap; overflow: hidden; text-overflow: clip; line-height: 1; letter-spacing: 0.1px; ${printValueStyle}">${formatDate(currentResident.birth_date)}</div>
                                <div style="position: absolute; left: 46.7%; top: 59.6%; width: 11.5%; height: 4.2%; display: flex; align-items: flex-start; justify-content: flex-start; font-size: ${statusFont}px; font-weight: 900; text-align: left; white-space: nowrap; overflow: hidden; text-overflow: clip; line-height: 1; letter-spacing: 0.1px; ${printValueStyle}">${statusPrint}</div>
                                <div style="position: absolute; left: 59.1%; top: 59.6%; width: 11.4%; height: 4.2%; display: flex; align-items: flex-start; justify-content: flex-start; font-size: ${nationalityFont}px; font-weight: 900; text-align: left; white-space: nowrap; overflow: hidden; text-overflow: clip; line-height: 1; letter-spacing: 0.1px; ${printValueStyle}">${currentResident.nationality || 'FILIPINO'}</div>
                                <div style="position: absolute; left: 72.2%; top: 59.6%; width: 6.4%; height: 4.2%; display: flex; align-items: flex-start; justify-content: flex-start; font-size: ${sexFont}px; font-weight: 900; text-align: left; white-space: nowrap; overflow: hidden; text-overflow: clip; line-height: 1; letter-spacing: 0.1px; ${printValueStyle}">${formatSexShort(currentResident.gender)}</div>
                                <div style="position: absolute; left: ${sectorLeftPrint}; top: 59.6%; width: 14.1%; height: 4.2%; display: flex; align-items: flex-start; justify-content: flex-start; font-size: ${sectorFont}px; font-weight: 900; text-align: left; white-space: nowrap; overflow: hidden; text-overflow: clip; line-height: 1; letter-spacing: 0.05px; ${printValueStyle}">${sectorPrint}</div>

                                <div style="position: absolute; left: 7%; top: 70%; width: 18.2%; text-align: center; font-size: 5.4px; font-weight: 900; white-space: nowrap; overflow: hidden; letter-spacing: 0.05px; ${printStrongStyle}">${idNumberPrint}</div>

                                <div style="position: absolute; left: 3.7%; top: 76.5%; width: 26.8%; height: 10.5%; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                                    ${signatureSrc ? `<img src="${signatureSrc}" alt="Signature" style="max-width: 100%; max-height: 100%; object-fit: contain;">` : ''}
                                </div>

                                <div style="position: absolute; left: 79.6%; top: 68.5%; width: 14%; height: 20.8%; border: 1px solid #000; background: #fff; display: flex; align-items: center; justify-content: center; padding: 2px;">
                                    ${currentID.qr_code ? `<img src="${currentID.qr_code}" alt="QR" style="width: 100%; height: 100%; object-fit: contain;">` : ''}
                                </div>
                                <div style="position: absolute; left: 78.6%; top: 90.9%; width: 16%; text-align: center; font-size: ${validityFont}px; font-weight: 900; white-space: nowrap; overflow: hidden; letter-spacing: -0.22px; font-family: \"Arial Narrow\", \"Segoe UI\", Arial, sans-serif; color: #111;">${validityPrint}</div>
                            </div>
                `;

        const backCardHTML = `
                            <div class="id-card">
                                <img src="${backTemplateSrc}" alt="Back Template" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover;">
                                <div style="padding: 12px 14px; position: relative; z-index: 1;">
                                    <div style="text-align: center; font-weight: bold; color: #fff; font-size: 11px; letter-spacing: 0.5px; margin-bottom: 12px; line-height: 1.2;">IN CASE OF EMERGENCY, KINDLY NOTIFY:</div>
                  
                                    <table style="width: 100%; font-size: 9px; border-collapse: collapse; margin-bottom: 4px;">
                                        <tr style="line-height: 1.38;">
                      <td style="font-weight: bold; color: #000; width: 85px; padding: 0 4px 3px 0; text-align: right; white-space: nowrap;">NAME :</td>
                      <td style="color: #000; font-weight: bold; padding: 0 0 3px 4px; text-transform: uppercase;">${currentResident.emergency_contact_name || '_________________'}</td>
                    </tr>
                                        <tr style="line-height: 1.38;">
                      <td style="font-weight: bold; color: #000; width: 85px; padding: 0 4px 3px 0; text-align: right; white-space: nowrap;">RELATION :</td>
                      <td style="color: #000; font-weight: bold; padding: 0 0 3px 4px; text-transform: uppercase;">${currentResident.emergency_contact_relationship || '_________________'}</td>
                    </tr>
                                        <tr style="line-height: 1.38;">
                      <td style="font-weight: bold; color: #000; width: 85px; padding: 0 4px 3px 0; text-align: right; white-space: nowrap;">ADDRESS :</td>
                                                                                        <td style="color: #000; font-weight: bold; padding: 0 0 3px 4px; text-transform: uppercase; font-size: ${ecAddressFont}px; white-space: normal; overflow-wrap: anywhere; line-height: 1.18; letter-spacing: 0.28px; word-spacing: 0.42px;">${ecAddressPrint || '_________________'}</td>
                    </tr>
                                        <tr style="line-height: 1.38;">
                      <td style="font-weight: bold; color: #000; width: 85px; padding: 0 4px 0 0; text-align: right; white-space: nowrap;">CONTACT NO. :</td>
                      <td style="color: #000; font-weight: bold; padding: 0 0 0 4px; text-transform: uppercase;">${currentResident.emergency_contact_no || '_________________'}</td>
                    </tr>
                  </table>

                                    <div style="text-align: center; font-weight: bold; color: #0038A8; font-size: 9px; letter-spacing: 0.5px; margin-top: 4px; margin-bottom: 3px; line-height: 1.1;">EMERGENCY HOTLINE</div>
                  
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
                                                                <div style="position: absolute; bottom: 6px; left: 10px; right: 10px; text-align: center; z-index: 2;">
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
