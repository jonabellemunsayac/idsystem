@extends('layouts.app')

@section('title', 'Certificate Editor - ' . ucfirst(str_replace('_', ' ', $certificateType)))

@section('extra-styles')
<style>
    /* ===== Layout ===== */
    .editor-wrapper {
        display: flex;
        gap: 24px;
        align-items: flex-start;
    }

    .editor-sidebar {
        width: 300px;
        min-width: 300px;
        position: sticky;
        top: 20px;
        max-height: calc(100vh - 40px);
        overflow-y: auto;
    }

    .editor-main {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        min-width: 0;
    }

    /* ===== Sidebar Cards ===== */
    .sidebar-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        padding: 20px;
        margin-bottom: 14px;
    }

    .sidebar-card h3 {
        font-size: 14px;
        font-weight: 700;
        color: #1f2937;
        margin: 0 0 14px 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .sidebar-card h3 i { color: #0038A8; }



    /* ===== Action Buttons ===== */
    .action-buttons { display: flex; flex-direction: column; gap: 10px; }

    .btn-action {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 11px 16px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        border: none;
        transition: all 0.2s;
        text-decoration: none;
        color: white;
    }

    .btn-action:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
    .btn-print  { background: #0038A8; }
    .btn-print:hover  { background: #002B88; color: white; }
    .btn-back-action { background: #6b7280; }
    .btn-back-action:hover { background: #4b5563; color: white; }
    .btn-download { background: #8b5cf6; }
    .btn-download:hover { background: #7c3aed; color: white; }

    /* ===== Tip Box ===== */
    .tip-box {
        background: #f0f9ff;
        border-left: 3px solid #0038A8;
        padding: 11px 13px;
        border-radius: 0 6px 6px 0;
        font-size: 12px;
        color: #374151;
        line-height: 1.5;
    }
    .tip-box strong { color: #0038A8; }

    .back-link {
        color: #0038A8;
        text-decoration: none;
        font-size: 14px;
        margin-bottom: 16px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .back-link:hover { text-decoration: underline; }

    /* ===== Paper wrapper ===== */
    .cert-paper-wrap { display: flex; flex-direction: column; align-items: center; width: 100%; }

    .cert-paper-bg {
        background: #c9cdd4;
        padding: 28px 28px 36px 28px;
        border-radius: 10px;
        display: flex;
        justify-content: center;
        width: 100%;
        box-sizing: border-box;
    }

    /* ===== Certificate Paper ===== */
    .cert-paper {
        width: 8.5in;
        min-height: 11in;
        background: white;
        box-shadow: 0 4px 24px rgba(0,0,0,0.18);
        padding: 1in;
        font-family: 'Times New Roman', Times, serif;
        color: #000;
        box-sizing: border-box;
        position: relative;
    }

    /* ===== Header ===== */
    .cert-header { text-align: center; padding-bottom: 10px; border-bottom: 2px solid #000; margin-bottom: 18px; }
    .cert-header-logos { display: flex; align-items: center; justify-content: center; gap: 16px; }
    .cert-header-logo { width: 85px; height: 85px; object-fit: contain; flex-shrink: 0; }
    .cert-header-text { text-align: center; flex: 1; }
    .cert-header-text .republic,
    .cert-header-text .city    { font-size: 11pt; margin: 0; letter-spacing: 0.5px; }
    .cert-header-text .barangay { font-size: 18pt; font-weight: bold; margin: 4px 0; letter-spacing: 1px; }
    .cert-header-text .phone   { font-size: 10pt; margin: 0; }

    /* ===== ID Row ===== */
    .cert-id-row { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 14px; }
    .cert-id-label { font-size: 12pt; }

    /* ===== Photo Box ===== */
    .cert-photo-box {
        width: 1in;
        height: 1in;
        border: 1px solid #000;
        flex-shrink: 0;
        position: relative;
        overflow: hidden;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f9f9f9;
    }
    .cert-photo-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        position: absolute;
        top: 0; left: 0;
    }
    .cert-photo-hint {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 4px;
        color: #9ca3af;
        font-size: 8pt;
        font-family: sans-serif;
        text-align: center;
        pointer-events: none;
        line-height: 1.3;
        padding: 4px;
        position: relative;
        z-index: 1;
    }
    .cert-photo-hint i { font-size: 18px; }
    .cert-photo-box:hover .cert-photo-hint { color: #6b7280; }
    .cert-photo-box input[type="file"] { display: none; }

    /* ===== Title ===== */
    .cert-title { text-align: center; margin: 20px 0 18px 0; }
    .cert-title h1 { font-size: 14pt; font-weight: bold; margin: 0; letter-spacing: 2px; }

    /* ===== Body ===== */
    .cert-body { font-size: 12pt; line-height: 2; text-align: justify; outline: none; }
    .cert-body p { margin: 0; text-indent: 48px; }
    .cert-body p.no-indent { text-indent: 0; }
    .cert-body p + p { margin-top: 0; }

    /* ===== Editable blanks ===== */
    .blank {
        display: inline;
        font-weight: bold;
        border-bottom: 1px solid #000;
        min-width: 80px;
        outline: none;
        color: #1a1aff;
        cursor: text;
        white-space: nowrap;
    }
    .blank:focus { background: #eef4ff; }

    /* ===== Signatory ===== */
    .cert-signatory { margin-top: 56px; text-align: center; }
    .cert-signatory .name    { font-size: 14pt; font-weight: bold; margin: 0; text-decoration: underline; }
    .cert-signatory .position { font-size: 12pt; margin: 4px 0 0 0; }

    /* ===== Note ===== */
    .cert-note { margin-top: 36px; font-size: 10pt; font-style: italic; text-align: center; }

    /* ===== Responsive ===== */
    @media (max-width: 1300px) {
        .editor-wrapper { flex-direction: column; }
        .editor-sidebar { width: 100%; min-width: unset; position: static; max-height: none; overflow-y: visible; }
        .cert-paper-bg { padding: 16px 16px 24px 16px; }
        .cert-paper { width: 100%; min-height: auto; padding: 0.7in; }
    }

    @media (max-width: 768px) {
        .cert-paper-bg { padding: 10px 8px 18px 8px; }
        .cert-paper { padding: 18px 14px 28px 14px; }
        .cert-header-logo { width: 52px; height: 52px; }
        .cert-header-logos { gap: 8px; }
        .cert-header-text .republic, .cert-header-text .city { font-size: 7.5pt; }
        .cert-header-text .barangay { font-size: 11pt; }
        .cert-title h1 { font-size: 11pt; }
        .cert-body { font-size: 10pt; line-height: 1.8; }
        .cert-body p { text-indent: 24px; }
        .cert-signatory { margin-top: 32px; }
        .cert-signatory .name { font-size: 11pt; }
        .cert-note { font-size: 8.5pt; margin-top: 20px; }
        .btn-action { padding: 10px 14px; font-size: 13px; }
    }

    @media (max-width: 480px) {
        .cert-paper { padding: 12px 10px 20px 10px; }
        .cert-header-logo { width: 38px; height: 38px; }
        .cert-header-text .barangay { font-size: 9pt; }
        .cert-title h1 { font-size: 9pt; letter-spacing: 1px; }
        .cert-body { font-size: 9pt; }
    }
</style>
@endsection

@section('content')
@php
    $isEncoder = auth()->check() && auth()->user()->role === 'encoder';
    $selectedResidentId = $residentPrefill['resident_id'] ?? request('resident_id');
    $backUrl = $isEncoder
        ? ($selectedResidentId ? route('residents.show', $selectedResidentId) : route('residents.index'))
        : route('certificates.index');
    $backLabel = $isEncoder
        ? ($selectedResidentId ? 'Back to Resident' : 'Back to Residents')
        : 'Back to Certificates';
@endphp

<a href="#" class="back-link" id="backBtn"><i class="bi bi-arrow-left"></i> {{ $backLabel }}</a>

<div class="editor-wrapper">

    <!-- ===== Sidebar ===== -->
    <div class="editor-sidebar">

        <div class="sidebar-card" style="padding:0;overflow:hidden;">
            <div class="tip-box">
                <strong><i class="bi bi-pencil-square me-1"></i> Direct Editing</strong><br>
                Click on any <span style="color:#1a1aff;font-weight:bold;border-bottom:1px solid #1a1aff;">blue underlined</span> text on the certificate to edit it directly.
            </div>
        </div>

        <div class="sidebar-card">
            <h3><i class="bi bi-lightning-fill"></i> Actions</h3>
            <div class="action-buttons">
                <button class="btn-action btn-print" onclick="printCertificate()">
                    <i class="bi bi-printer-fill"></i> Print Certificate
                </button>
                <a href="{{ route('certificates.word.template', ['type' => $certificateType, 'resident' => $residentPrefill['resident_id'] ?? null]) }}" class="btn-action btn-download">
                    <i class="bi bi-file-earmark-word-fill"></i> Download Word Template
                </a>
                <button class="btn-action btn-back-action" id="backBtnAction">
                    <i class="bi bi-arrow-left"></i> {{ $backLabel }}
                </button>
            </div>
        </div>

    </div>

    <!-- ===== Certificate Preview ===== -->
    <div class="editor-main">
        <div class="cert-paper-wrap">
            <div class="cert-paper-bg">
                <div class="cert-paper" id="certificatePaper">

                    <div class="cert-header">
                        <div class="cert-header-logos">
                            <img src="{{ asset('images/cert/image2.png') }}" alt="Barangay Kalawaan Logo" class="cert-header-logo">
                            <div class="cert-header-text">
                                <p class="republic">REPUBLIC OF THE PHILIPPINES</p>
                                <p class="city">CITY GOVERNMENT OF PASIG</p>
                                <p class="barangay">BARANGAY KALAWAAN</p>
                                <p class="phone">Telephone No. (028) 742-6653</p>
                            </div>
                            <img src="{{ asset('images/cert/image1.jpeg') }}" alt="Pasig City Seal" class="cert-header-logo">
                        </div>
                    </div>

                    @if(in_array($certificateType, ['clearance','residency']))
                    <div class="cert-id-row">
                        <div class="cert-id-label">Barangay I.D. No.: <span class="blank" data-field="barangay_id" contenteditable="true" spellcheck="false">___________</span></div>
                        <div class="cert-photo-box" id="photoBox" onclick="document.getElementById('photoInput').click()" title="Click to upload photo">
                            <input type="file" id="photoInput" accept="image/*">
                            <img id="photoPreview" src="" alt="" style="display:none;">
                            <div class="cert-photo-hint" id="photoHint">
                                <i class="bi bi-camera-fill"></i>
                                <span>Click to<br>upload photo</span>
                            </div>
                        </div>
                    </div>
                    @else
                    <div style="margin-bottom:14px;">
                        <span class="cert-id-label">Barangay I.D. No.: <span class="blank" data-field="barangay_id" contenteditable="true" spellcheck="false">___________</span></span>
                    </div>
                    @endif

                    <div class="cert-title">
                        <h1>
                            @if($certificateType === 'clearance')     BARANGAY CLEARANCE
                            @elseif($certificateType === 'indigency')  CERTIFICATE OF INDIGENCY
                            @elseif($certificateType === 'residency')  CERTIFICATE OF RESIDENCY
                            @elseif($certificateType === 'no_income')  CERTIFICATION OF NO INCOME
                            @elseif($certificateType === 'low_income') CERTIFICATE OF LOW INCOME
                            @endif
                        </h1>
                    </div>

                    <div class="cert-body">

                        @if($certificateType === 'clearance')
                        <p>This is to certify that <span class="blank" data-field="full_name" contenteditable="true" spellcheck="false">Full Name</span>,
                        of legal age, (<span class="blank" data-field="civil_status" contenteditable="true" spellcheck="false">Single</span>),
                        Filipino, is a resident of <span class="blank" data-field="address" contenteditable="true" spellcheck="false">Street / Purok Address</span>,
                        Barangay Kalawaan, Pasig City, and is known to be of good moral character and has no
                        derogatory record on file in this barangay as of this date.</p>

                        <p>This certification is being issued upon the request of the above-named person for the
                        purpose of <span class="blank" data-field="purpose" contenteditable="true" spellcheck="false">state purpose here</span>.</p>

                        @elseif($certificateType === 'indigency')
                        <p>This is to certify that <span class="blank" data-field="full_name" contenteditable="true" spellcheck="false">Full Name</span>,
                        of legal age, (<span class="blank" data-field="civil_status" contenteditable="true" spellcheck="false">Single</span>),
                        Filipino, is a bona-fide resident of <span class="blank" data-field="address" contenteditable="true" spellcheck="false">Street / Purok Address</span>,
                        Barangay Kalawaan, Pasig City since <span class="blank" data-field="resident_since_year" contenteditable="true" spellcheck="false">year</span>
                        up to the present, and belongs to one of the indigent families of this barangay.</p>

                        <p>This certification is being issued upon the request of the above-named person for the
                        purpose of <span class="blank" data-field="purpose" contenteditable="true" spellcheck="false">state purpose here</span>.</p>

                        @elseif($certificateType === 'residency')
                        <p>This is to certify that <span class="blank" data-field="full_name" contenteditable="true" spellcheck="false">Full Name</span>,
                        of legal age, (<span class="blank" data-field="civil_status" contenteditable="true" spellcheck="false">Single</span>),
                        Filipino, is a bona fide resident of <span class="blank" data-field="address" contenteditable="true" spellcheck="false">Street / Purok Address</span>,
                        Barangay Kalawaan, Pasig City since <span class="blank" data-field="resident_since_year" contenteditable="true" spellcheck="false">year</span>
                        up to the present.</p>

                        <p>This certification is being issued upon the request of the above-named person for the
                        purpose of <span class="blank" data-field="purpose" contenteditable="true" spellcheck="false">state purpose here</span>.</p>

                        @elseif($certificateType === 'no_income')
                        <p>This is to certify that <span class="blank" data-field="full_name" contenteditable="true" spellcheck="false">Full Name</span>,
                        of legal age, (<span class="blank" data-field="civil_status" contenteditable="true" spellcheck="false">Single</span>),
                        Filipino, is a resident of <span class="blank" data-field="address" contenteditable="true" spellcheck="false">Street / Purok Address</span>,
                        Barangay Kalawaan, Pasig City.</p>

                        <p>Based on the verification of this Barangay, the aforementioned individual is unemployed
                        and has no regular source of income with an estimated monthly earnings amount of
                        <span class="blank" data-field="monthly_income" contenteditable="true" spellcheck="false">0.00</span>
                        and belongs to one of the indigent families in this
                        Barangay.</p>

                        <p>This certification is being issued upon the request of the above-named person for the
                        purpose of <span class="blank" data-field="purpose" contenteditable="true" spellcheck="false">state purpose here</span>.</p>

                        @elseif($certificateType === 'low_income')
                        <p>This is to certify that <span class="blank" data-field="full_name" contenteditable="true" spellcheck="false">Full Name</span>,
                        of legal age, (<span class="blank" data-field="civil_status" contenteditable="true" spellcheck="false">Single</span>),
                        Filipino, is a resident of <span class="blank" data-field="address" contenteditable="true" spellcheck="false">Street / Purok Address</span>,
                        Barangay Kalawaan, Pasig City.</p>

                        <p>Based on the assessment of this Barangay, the aforementioned individual is a low-income
                        earner and has an estimated monthly income of
                        <span class="blank" data-field="monthly_income" contenteditable="true" spellcheck="false">amount</span>
                        which falls below the minimum wage requirements.</p>

                        <p>This certification is being issued upon the request of the above-named person for the
                        purpose of <span class="blank" data-field="purpose" contenteditable="true" spellcheck="false">state purpose here</span>.</p>

                        @endif

                        <p class="no-indent">This certificate is valid for
                        @if($certificateType === 'indigency') <strong>NINETY (90)</strong>
                        @else <strong>SIXTY (60)</strong>
                        @endif
                        days from the date of its issuance.</p>

                        <p class="no-indent">Issued this <strong>{{ $issueDay }}</strong> day of <strong>{{ $issueMonth }}</strong>,
                        <strong>{{ $issueYear }}</strong> at the Barangay Hall, Kalawaan, Pasig City, Philippines.</p>

                    </div>

                    <div class="cert-signatory">
                        <p class="name">JESSIE B. GAVIOLA</p>
                        <p class="position">Barangay Chairman</p>
                    </div>

                    <div class="cert-note">
                        <em>Note: This certificate is not valid without the Official Barangay Dry Seal.</em>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>

<div class="modal fade" id="printDetailsModal" tabindex="-1" aria-labelledby="printDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="printDetailsForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="printDetailsModalLabel">Print Certificate Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="modalPurposeInput" class="form-label">Purpose</label>
                        <input type="text" class="form-control" id="modalPurposeInput" maxlength="255" required>
                    </div>
                    <div class="mb-3 d-none" id="modalAmountGroup">
                        <label for="modalAmountInput" class="form-label">Amount</label>
                        <input type="text" class="form-control" id="modalAmountInput" maxlength="100" placeholder="e.g. 0.00">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Continue to Print</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('extra-scripts')
<script>
(function () {

    /* ---------- Back button ---------- */
    function goBack(e) {
        e.preventDefault();
        window.location.href = @json($backUrl);
    }

    var residentPrefill = @json($residentPrefill ?? null);
    var certificateType = @json($certificateType ?? null);
    var printLogUrl = @json(route('certificates.print-log'));
    var csrfMeta = document.querySelector('meta[name="csrf-token"]');
    var csrfToken = csrfMeta ? csrfMeta.getAttribute('content') : '';
    var pendingPrintLogPayload = null;

    function applyResidentPrefill() {
        if (!residentPrefill) return;

        Object.keys(residentPrefill).forEach(function (key) {
            var target = document.querySelector('.blank[data-field="' + key + '"]');
            if (!target) return;

            var value = residentPrefill[key];
            if (value === null || value === undefined || value === '') return;
            target.textContent = value;
        });

        applyResidentPhotoPrefill();
    }

    function applyResidentPhotoPrefill() {
        if (!residentPrefill || !residentPrefill.photo_url) return;

        var photoPreview = document.getElementById('photoPreview');
        var photoHint = document.getElementById('photoHint');
        if (!photoPreview) return;

        photoPreview.src = residentPrefill.photo_url;
        photoPreview.style.display = 'block';
        if (photoHint) photoHint.style.display = 'none';
    }

    function getBlankValue(fieldName) {
        var target = document.querySelector('.blank[data-field="' + fieldName + '"]');
        if (!target) return '';
        return (target.textContent || '').trim();
    }

    function setBlankValue(fieldName, value) {
        var target = document.querySelector('.blank[data-field="' + fieldName + '"]');
        if (!target) return;
        target.textContent = value;
    }

    function requiresPrePrintModal() {
        return ['clearance', 'residency', 'indigency', 'no_income', 'low_income'].indexOf(certificateType) !== -1;
    }

    function requiresAmountInput() {
        return ['no_income', 'low_income'].indexOf(certificateType) !== -1;
    }

    function buildPrintLogPayload() {
        var paper = document.getElementById('certificatePaper');
        return {
            resident_id: residentPrefill && residentPrefill.resident_id ? residentPrefill.resident_id : null,
            certificate_type: certificateType,
            purpose: getBlankValue('purpose'),
            amount: requiresAmountInput() ? getBlankValue('monthly_income') : null,
            content: paper ? paper.innerText.trim() : null,
        };
    }

    async function logPrintedCertificate(payload) {
        if (!payload || !payload.certificate_type || !payload.purpose) return;

        try {
            await fetch(printLogUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify(payload),
            });
        } catch (error) {
            console.error('Failed to log printed certificate:', error);
        }
    }

    function openPrePrintModal() {
        var modalEl = document.getElementById('printDetailsModal');
        var purposeInput = document.getElementById('modalPurposeInput');
        var amountInput = document.getElementById('modalAmountInput');
        var amountGroup = document.getElementById('modalAmountGroup');

        if (!modalEl || !purposeInput) {
            // Fallback when modal dependencies are unavailable.
            var promptedPurpose = window.prompt('Enter purpose before printing:');
            if (!promptedPurpose) return;
            setBlankValue('purpose', promptedPurpose);

            if (requiresAmountInput()) {
                var promptedAmount = window.prompt('Enter amount:');
                if (!promptedAmount) return;
                setBlankValue('monthly_income', promptedAmount);
            }

            printCertificate();
            return;
        }

        purposeInput.value = getBlankValue('purpose');
        purposeInput.focus();

        if (requiresAmountInput()) {
            amountGroup.classList.remove('d-none');
            amountInput.value = getBlankValue('monthly_income');
            amountInput.required = true;
        } else {
            amountGroup.classList.add('d-none');
            amountInput.required = false;
            amountInput.value = '';
        }

        if (window.bootstrap && window.bootstrap.Modal) {
            window.bootstrap.Modal.getOrCreateInstance(modalEl).show();
            return;
        }

        // Fallback when Bootstrap modal JS is not available.
        var fallbackPurpose = window.prompt('Enter purpose before printing:', purposeInput.value || '');
        if (!fallbackPurpose) return;
        setBlankValue('purpose', fallbackPurpose);
        if (requiresAmountInput()) {
            var fallbackAmount = window.prompt('Enter amount:', amountInput.value || '');
            if (!fallbackAmount) return;
            setBlankValue('monthly_income', fallbackAmount);
        }
        printCertificate();
    }

    function handlePrintAction() {
        if (requiresPrePrintModal()) {
            openPrePrintModal();
            return;
        }

        printCertificate();
    }

    document.addEventListener('DOMContentLoaded', function () {
        var b1 = document.getElementById('backBtn');
        var b2 = document.getElementById('backBtnAction');
        if (b1) b1.addEventListener('click', goBack);
        if (b2) b2.addEventListener('click', goBack);

        var printBtn = document.querySelector('.btn-action.btn-print');
        if (printBtn) {
            printBtn.removeAttribute('onclick');
            printBtn.addEventListener('click', handlePrintAction);
        }

        var printDetailsForm = document.getElementById('printDetailsForm');
        if (printDetailsForm) {
            printDetailsForm.addEventListener('submit', function (e) {
                e.preventDefault();

                var purposeInput = document.getElementById('modalPurposeInput');
                var amountInput = document.getElementById('modalAmountInput');
                var purpose = (purposeInput && purposeInput.value ? purposeInput.value : '').trim();
                var amount = (amountInput && amountInput.value ? amountInput.value : '').trim();

                if (!purpose) return;
                if (requiresAmountInput() && !amount) return;

                setBlankValue('purpose', purpose);
                if (requiresAmountInput()) {
                    setBlankValue('monthly_income', amount);
                }

                var modalEl = document.getElementById('printDetailsModal');
                if (modalEl && window.bootstrap && window.bootstrap.Modal) {
                    window.bootstrap.Modal.getOrCreateInstance(modalEl).hide();
                }

                printCertificate();
            });
        }

        window.addEventListener('message', function (event) {
            if (!event.data || event.data.type !== 'certificate-printed') return;
            if (!pendingPrintLogPayload) return;

            logPrintedCertificate(pendingPrintLogPayload);
            pendingPrintLogPayload = null;
        });

        /* ---------- Photo upload ---------- */
        var photoInput   = document.getElementById('photoInput');
        var photoPreview = document.getElementById('photoPreview');
        var photoHint    = document.getElementById('photoHint');
        if (photoInput) {
            photoInput.addEventListener('change', function () {
                var file = photoInput.files[0];
                if (!file) return;
                var reader = new FileReader();
                reader.onload = function (e) {
                    photoPreview.src = e.target.result;
                    photoPreview.style.display = 'block';
                    if (photoHint) photoHint.style.display = 'none';
                };
                reader.readAsDataURL(file);
            });
        }

        if (photoPreview) {
            photoPreview.addEventListener('error', function () {
                photoPreview.style.display = 'none';
                if (photoHint) photoHint.style.display = 'flex';
            });
        }

        applyResidentPrefill();

        /* Select-all on blank focus for easy replacement */
        document.querySelectorAll('.blank').forEach(function (el) {
            el.addEventListener('focus', function () {
                var range = document.createRange();
                range.selectNodeContents(el);
                var sel = window.getSelection();
                sel.removeAllRanges();
                sel.addRange(range);
            });
            /* Prevent Enter key from inserting line breaks */
            el.addEventListener('keydown', function (e) {
                if (e.key === 'Enter') { e.preventDefault(); el.blur(); }
            });
        });
    });

    /* ---------- Print ---------- */
    function printCertificate() {
        var paper = document.getElementById('certificatePaper');
        if (!paper) return;
        pendingPrintLogPayload = buildPrintLogPayload();

        var clone = paper.cloneNode(true);
        /* Remove contenteditable and turn blue blanks black */
        clone.querySelectorAll('[contenteditable]').forEach(function (el) {
            el.removeAttribute('contenteditable');
        });
        clone.querySelectorAll('.blank').forEach(function (el) {
            el.style.color = '#000';
            el.style.borderBottomColor = '#000';
        });

        var styleLinks  = Array.from(document.querySelectorAll('link[rel="stylesheet"]'))
                               .map(function (l) { return l.outerHTML; }).join('\n');
        var styleBlocks = Array.from(document.querySelectorAll('style'))
                               .map(function (s) { return '<style>' + s.textContent + '</style>'; }).join('\n');

        var win = window.open('', '_blank', 'width=950,height=1250');
        if (!win) { alert('Pop-up blocked. Please allow pop-ups for this site.'); return; }

        win.document.write(
            '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>Certificate</title>'
            + styleLinks + styleBlocks
            + '<style>'
            + '@page{size:letter portrait;margin:0;}'
            + '*,*::before,*::after{-webkit-print-color-adjust:exact!important;print-color-adjust:exact!important;box-sizing:border-box;}'
            + 'html,body{margin:0;padding:0;background:white;}'
            + '.cert-paper{width:8.5in!important;min-height:11in!important;padding:1in!important;margin:0 auto!important;box-shadow:none!important;border:none!important;background:white!important;}'
            + '.blank{color:#000!important;border-bottom-color:#000!important;}'
            + '</style>'
            + '</head><body>'
            + clone.outerHTML
            + '<script>window.onload=function(){window.focus();window.print();window.onafterprint=function(){if(window.opener){window.opener.postMessage({type:\"certificate-printed\"},\"*\");}window.close();};setTimeout(function(){window.close();},8000);};<\/script>'
            + '</body></html>'
        );
        win.document.close();
    }

    window.printCertificate = printCertificate;

}());
</script>
@endsection
