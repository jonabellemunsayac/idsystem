@extends('layouts.app')

@section('title', 'Certificate Editor - ' . ucfirst(str_replace('_', ' ', $certificateType)))

@section('extra-styles')
<style>
    /* ===== Editor Layout ===== */
    .editor-wrapper {
        display: flex;
        gap: 24px;
        align-items: flex-start;
    }

    .editor-sidebar {
        width: 280px;
        min-width: 280px;
        position: sticky;
        top: 20px;
    }

    .editor-main {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    /* ===== Rich Text Toolbar ===== */
    .rich-toolbar {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 12px;
        margin-bottom: 20px;
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        width: 8.5in;
    }

    .toolbar-group {
        display: flex;
        gap: 4px;
        padding-right: 8px;
        border-right: 1px solid #e5e7eb;
    }

    .toolbar-group:last-child {
        border-right: none;
    }

    .toolbar-btn-format {
        width: 32px;
        height: 32px;
        border: 1px solid #d1d5db;
        background: white;
        border-radius: 4px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.15s;
        font-size: 14px;
        color: #374151;
    }

    .toolbar-btn-format:hover {
        background: #f3f4f6;
        border-color: #0038A8;
    }

    .toolbar-btn-format.active {
        background: #0038A8;
        color: white;
        border-color: #0038A8;
    }

    .toolbar-select {
        height: 32px;
        border: 1px solid #d1d5db;
        border-radius: 4px;
        padding: 0 8px;
        font-size: 13px;
        cursor: pointer;
        background: white;
    }

    .toolbar-select:focus {
        outline: none;
        border-color: #0038A8;
    }

    /* Number input styling */
    input[type="number"].toolbar-select {
        -moz-appearance: textfield;
    }

    input[type="number"].toolbar-select::-webkit-outer-spin-button,
    input[type="number"].toolbar-select::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .sidebar-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        padding: 24px;
        margin-bottom: 16px;
    }

    .sidebar-card h3 {
        font-size: 15px;
        font-weight: 700;
        color: #1f2937;
        margin: 0 0 16px 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .sidebar-card h3 i { color: #0038A8; }

    .field-group {
        margin-bottom: 14px;
    }

    .field-group label {
        display: block;
        font-size: 12px;
        font-weight: 600;
        color: #6b7280;
        margin-bottom: 4px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .field-group input,
    .field-group select,
    .field-group textarea {
        width: 100%;
        padding: 8px 10px;
        border: 1px solid #e5e7eb;
        border-radius: 6px;
        font-size: 13px;
        color: #1f2937;
        transition: border-color 0.2s;
        box-sizing: border-box;
    }

    .field-group input:focus,
    .field-group select:focus,
    .field-group textarea:focus {
        outline: none;
        border-color: #0038A8;
        box-shadow: 0 0 0 3px rgba(0, 56, 168, 0.1);
    }

    .field-group textarea {
        resize: vertical;
        min-height: 60px;
    }

    .action-buttons {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .btn-action {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 12px 16px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        border: none;
        transition: all 0.2s;
        text-decoration: none;
        color: white;
    }

    .btn-action:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .btn-print { background: #0038A8; }
    .btn-print:hover { background: #002B88; color: white; }
    .btn-save { background: #10b981; }
    .btn-save:hover { background: #059669; color: white; }
    .btn-back-action { background: #6b7280; }
    .btn-back-action:hover { background: #4b5563; color: white; }
    .btn-download { background: #8b5cf6; }
    .btn-download:hover { background: #7c3aed; color: white; }

    /* ===== Certificate Paper ===== */
    .cert-paper-container {
        background: #e5e7eb;
        padding: 32px;
        border-radius: 12px;
        display: flex;
        justify-content: center;
        width: 100%;
    }

    .cert-paper {
        width: 8.5in;
        min-height: 11in;
        background: white;
        box-shadow: 0 4px 24px rgba(0,0,0,0.15);
        padding: 0.5in 0.9in 0.8in 0.9in;
        position: relative;
        font-family: 'Times New Roman', Times, serif;
        color: #000;
        line-height: 1.4;
    }

    /* ===== Header Section ===== */
    .cert-header {
        text-align: center;
        position: relative;
        padding-bottom: 10px;
        border-bottom: 2px solid #000;
        margin-bottom: 16px;
    }

    .cert-header-logos {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 16px;
        margin-bottom: 4px;
    }

    .cert-header-logo {
        width: 85px;
        height: 85px;
        object-fit: contain;
    }

    .cert-header-text {
        text-align: center;
        flex: 1;
    }

    .cert-header-text .republic {
        font-size: 11pt;
        font-family: 'Times New Roman', Times, serif;
        margin: 0;
        letter-spacing: 0.5px;
    }

    .cert-header-text .city {
        font-size: 11pt;
        font-family: 'Times New Roman', Times, serif;
        margin: 0;
        letter-spacing: 0.5px;
    }

    .cert-header-text .barangay {
        font-size: 18pt;
        font-weight: bold;
        font-family: 'Times New Roman', Times, serif;
        margin: 4px 0;
        letter-spacing: 1px;
    }

    .cert-header-text .phone {
        font-size: 10pt;
        font-family: 'Times New Roman', Times, serif;
        margin: 0;
    }

    /* ===== Certificate Title ===== */
    .cert-title {
        text-align: center;
        margin: 24px 0 20px 0;
    }

    .cert-title h1 {
        font-size: 28pt;
        font-weight: bold;
        margin: 0;
        letter-spacing: 1px;
    }

    .cert-title-clearance h1,
    .cert-title-low_income h1 {
        font-family: 'Times New Roman', Times, serif;
    }

    .cert-title-indigency h1,
    .cert-title-residency h1,
    .cert-title-no_income h1 {
        font-family: Arial, Helvetica, sans-serif;
    }

    /* ===== ID Number ===== */
    .cert-id-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 12px;
    }

    .cert-id-label {
        font-size: 12pt;
    }

    .cert-photo-box {
        width: 1in;
        height: 1in;
        border: 1px solid #000;
        flex-shrink: 0;
    }

    .cert-photo-box-filled {
        background: white;
    }

    /* ===== Body Text ===== */
    .cert-body {
        font-size: 12pt;
        line-height: 2;
        text-align: justify;
        margin-bottom: 10px;
    }

    .cert-body p {
        margin: 0 0 14px 0;
        text-indent: 40px;
    }

    .cert-editable {
        display: inline;
        padding: 1px 2px;
        min-width: 80px;
        outline: none;
        color: #000;
        font-weight: normal;
        cursor: text;
        transition: background 0.15s;
    }

    .cert-editable:hover {
        background: rgba(0, 56, 168, 0.04);
    }

    .cert-editable:focus {
        background: rgba(0, 56, 168, 0.06);
    }

    .cert-editable-long {
        min-width: 200px;
    }

    /* ===== Signatory ===== */
    .cert-signatory {
        margin-top: 50px;
        text-align: center;
    }

    .cert-signatory .name {
        font-size: 14pt;
        font-weight: bold;
        margin: 0;
        text-decoration: underline;
    }

    .cert-signatory .position {
        font-size: 12pt;
        margin: 4px 0 0 0;
    }

    /* ===== Note ===== */
    .cert-note {
        margin-top: 36px;
        font-size: 10pt;
        font-style: italic;
        text-align: center;
    }

    /* ===== Editable Section Hover Effects ===== */
    [contenteditable="true"] {
        outline: none;
        transition: background-color 0.2s, box-shadow 0.2s;
    }

    [contenteditable="true"]:hover {
        background-color: rgba(0, 56, 168, 0.03);
        box-shadow: 0 0 0 2px rgba(0, 56, 168, 0.1);
        cursor: text;
    }

    [contenteditable="true"]:focus {
        background-color: rgba(0, 56, 168, 0.05);
        box-shadow: 0 0 0 2px rgba(0, 56, 168, 0.2);
    }

    /* ===== Print Styles ===== */
    @media print {
        /* Hide everything */
        body * {
            visibility: hidden;
        }

        /* Show only the certificate */
        .cert-paper,
        .cert-paper * {
            visibility: visible;
        }

        .cert-paper {
            position: absolute;
            left: 0;
            top: 0;
            width: 8.5in;
            min-height: 11in;
            padding: 0.5in 0.9in 0.8in 0.9in;
            box-shadow: none;
            margin: 0;
            border: none;
        }

        /* Remove editable styling for print */
        [contenteditable="true"] {
            background: transparent !important;
            box-shadow: none !important;
        }

        /* Hide sidebar, toolbar, rich toolbar, and wrapper backgrounds */
        .editor-sidebar,
        .back-link,
        .editor-toolbar,
        .rich-toolbar {
            display: none !important;
        }

        .cert-paper-container {
            background: transparent !important;
            padding: 0 !important;
            border-radius: 0 !important;
        }

        .editor-wrapper,
        .editor-main {
            display: block !important;
        }

        @page {
            size: letter;
            margin: 0;
        }
    }

    /* ===== Toolbar ===== */
    .editor-toolbar {
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        padding: 12px 20px;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
    }

    .toolbar-info {
        font-size: 13px;
        color: #6b7280;
    }

    .toolbar-info strong {
        color: #1f2937;
    }

    .toolbar-actions {
        display: flex;
        gap: 8px;
    }

    .toolbar-btn {
        padding: 6px 14px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        border: none;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 6px;
        color: white;
    }

    .toolbar-btn-print {
        background: #0038A8;
    }

    .toolbar-btn-print:hover {
        background: #002B88;
    }

    .toolbar-btn-save {
        background: #10b981;
    }

    .toolbar-btn-save:hover {
        background: #059669;
    }

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

    /* ===== Tip Box ===== */
    .tip-box {
        background: #f0f9ff;
        border-left: 3px solid #0038A8;
        padding: 12px 14px;
        border-radius: 0 6px 6px 0;
        font-size: 12px;
        color: #374151;
        line-height: 1.5;
    }

    .tip-box strong {
        color: #0038A8;
    }

    /* ===== Auto-save indicator ===== */
    .autosave-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 11px;
        color: #10b981;
        font-weight: 500;
        padding: 3px 8px;
        background: #ecfdf5;
        border-radius: 4px;
        margin-left: 8px;
        transition: opacity 0.3s;
    }

    .autosave-badge.saving {
        color: #f59e0b;
        background: #fffbeb;
    }

    /* ===== Responsive: Tablet ===== */
    @media (max-width: 1200px) {
        .editor-wrapper { flex-direction: column; }
        .editor-sidebar { width: 100%; min-width: unset; position: static; }
        .cert-paper-container { padding: 16px; }
        .cert-paper { width: 100%; min-height: auto; padding: 0.4in 0.6in 0.6in 0.6in; }
    }

    /* ===== Responsive: Mobile ===== */
    @media (max-width: 768px) {
        .editor-wrapper { gap: 12px; }
        .sidebar-card { padding: 16px; margin-bottom: 10px; }
        .sidebar-card h3 { font-size: 14px; margin-bottom: 12px; }
        .field-group { margin-bottom: 10px; }
        .field-group label { font-size: 11px; }
        .field-group input,
        .field-group select,
        .field-group textarea { font-size: 14px; padding: 10px; }
        .cert-paper-container { padding: 8px; border-radius: 8px; }
        .cert-paper {
            width: 100%;
            min-height: auto;
            padding: 20px 16px 24px 16px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.1);
        }
        .cert-header-logo { width: 50px; height: 50px; }
        .cert-header-logos { gap: 8px; }
        .cert-header-text .republic,
        .cert-header-text .city { font-size: 8pt; }
        .cert-header-text .barangay { font-size: 12pt; }
        .cert-header-text .phone { font-size: 8pt; }
        .cert-title h1 { font-size: 16pt; }
        .cert-title { margin: 14px 0 12px 0; }
        .cert-body { font-size: 10pt; line-height: 1.8; }
        .cert-body p { text-indent: 20px; margin-bottom: 10px; }
        .cert-id-label { font-size: 10pt; }
        .cert-photo-box { width: 0.7in; height: 0.7in; }
        .cert-signatory { margin-top: 30px; }
        .cert-signatory .name { font-size: 11pt; }
        .cert-signatory .position { font-size: 10pt; }
        .cert-note { font-size: 8pt; margin-top: 20px; }
        .cert-editable { padding: 1px 2px; }
        .cert-editable-long { min-width: 120px; }
        .editor-toolbar { flex-direction: column; gap: 8px; padding: 10px 14px; }
        .toolbar-info { font-size: 12px; text-align: center; }
        .toolbar-actions { width: 100%; }
        .toolbar-actions .toolbar-btn { flex: 1; justify-content: center; }
        .btn-action { padding: 10px 14px; font-size: 13px; }
        .action-buttons { gap: 8px; }
        .tip-box { font-size: 11px; padding: 10px 12px; }
    }

    @media (max-width: 480px) {
        .cert-paper { padding: 14px 12px 18px 12px; }
        .cert-header-logo { width: 40px; height: 40px; }
        .cert-header-text .barangay { font-size: 10pt; }
        .cert-title h1 { font-size: 13pt; letter-spacing: 0; }
        .cert-body { font-size: 9pt; line-height: 1.7; }
        .cert-body p { text-indent: 14px; }
    }
</style>
@endsection

@section('content')
<a href="{{ route('certificates.index') }}" class="back-link"><i class="bi bi-arrow-left"></i> Back to Certificates</a>

<div class="editor-wrapper">
    <!-- ===== Sidebar ===== -->
    <div class="editor-sidebar">
        <!-- Tip -->
        <div class="sidebar-card" style="padding: 0; overflow: hidden;">
            <div class="tip-box">
                <strong><i class="bi bi-lightbulb me-1"></i> Tip:</strong> Click anywhere on the certificate to edit text directly. Use the formatting toolbar to adjust fonts, alignment, and styling like Microsoft Word. Press <strong>Ctrl+P</strong> to print. All changes are auto-saved.
            </div>
        </div>

        <!-- Actions -->
        <div class="sidebar-card">
            <h3><i class="bi bi-lightning-fill"></i> Actions</h3>
            <div class="action-buttons">
                <button class="btn-action btn-print" onclick="printCertificate()">
                    <i class="bi bi-printer-fill"></i> Print Certificate
                </button>
                <button class="btn-action btn-save" onclick="markAsIssued()">
                    <i class="bi bi-check-circle-fill"></i> Save & Mark Issued
                </button>
                <a href="{{ route('certificates.word.template', ['type' => $certificateType]) }}" class="btn-action btn-download">
                    <i class="bi bi-file-earmark-word-fill"></i> Download Word File
                </a>
                <a href="{{ route('certificates.index') }}" class="btn-action btn-back-action">
                    <i class="bi bi-arrow-left"></i> Back to Certificates
                </a>
            </div>
        </div>
    </div>

    <!-- ===== Main Editor Area ===== -->
    <div class="editor-main">
        <!-- Toolbar -->
        <div class="editor-toolbar">
            <div class="toolbar-info">
                <i class="bi bi-pencil-square me-1"></i>
                Editing: <strong>{{ ucfirst(str_replace('_', ' ', $certificateType)) }}</strong>
                <span class="autosave-badge" id="autosaveBadge" style="display: none;"><i class="bi bi-check-circle-fill"></i> Saved</span>
            </div>
            <div class="toolbar-actions">
                <button class="toolbar-btn toolbar-btn-print" onclick="printCertificate()" title="Print certificate (Ctrl+P)">
                    <i class="bi bi-printer"></i> Print
                </button>
                <button class="toolbar-btn toolbar-btn-save" onclick="markAsIssued()" title="Save and mark as issued">
                    <i class="bi bi-check-circle"></i> Issue
                </button>
            </div>
        </div>

        <!-- ===== Rich Text Formatting Toolbar ===== -->
        <div class="rich-toolbar">
            <!-- Font Size -->
            <div class="toolbar-group">
                <input type="number" 
                       class="toolbar-select" 
                       id="fontSizeInput" 
                       placeholder="Font size" 
                       min="8" 
                       max="72" 
                       style="width: 90px;"
                       title="Enter font size (8-72pt)"
                       onkeypress="if(event.key === 'Enter') { applyFontSize(); return false; }">
                <button class="toolbar-btn-format" onclick="applyFontSize()" title="Apply Font Size">
                    <i class="bi bi-check2"></i>
                </button>
            </div>

            <!-- Text Formatting -->
            <div class="toolbar-group">
                <button class="toolbar-btn-format" onclick="formatText('bold')" title="Bold (Ctrl+B)">
                    <i class="bi bi-type-bold"></i>
                </button>
                <button class="toolbar-btn-format" onclick="formatText('italic')" title="Italic (Ctrl+I)">
                    <i class="bi bi-type-italic"></i>
                </button>
                <button class="toolbar-btn-format" onclick="formatText('underline')" title="Underline (Ctrl+U)">
                    <i class="bi bi-type-underline"></i>
                </button>
                <button class="toolbar-btn-format" onclick="formatText('strikethrough')" title="Strikethrough">
                    <i class="bi bi-type-strikethrough"></i>
                </button>
            </div>

            <!-- Alignment -->
            <div class="toolbar-group">
                <button class="toolbar-btn-format" onclick="formatText('justifyLeft')" title="Align Left">
                    <i class="bi bi-text-left"></i>
                </button>
                <button class="toolbar-btn-format" onclick="formatText('justifyCenter')" title="Align Center">
                    <i class="bi bi-text-center"></i>
                </button>
                <button class="toolbar-btn-format" onclick="formatText('justifyRight')" title="Align Right">
                    <i class="bi bi-text-right"></i>
                </button>
                <button class="toolbar-btn-format" onclick="formatText('justifyFull')" title="Justify">
                    <i class="bi bi-justify"></i>
                </button>
            </div>

            <!-- Lists -->
            <div class="toolbar-group">
                <button class="toolbar-btn-format" onclick="formatText('insertUnorderedList')" title="Bullet List">
                    <i class="bi bi-list-ul"></i>
                </button>
                <button class="toolbar-btn-format" onclick="formatText('insertOrderedList')" title="Numbered List">
                    <i class="bi bi-list-ol"></i>
                </button>
                <button class="toolbar-btn-format" onclick="adjustIndent('increase')" title="Increase Indent">
                    <i class="bi bi-indent"></i>
                </button>
                <button class="toolbar-btn-format" onclick="adjustIndent('decrease')" title="Decrease Indent">
                    <i class="bi bi-arrow-bar-left"></i>
                </button>
            </div>

            <!-- Spacing Controls -->
            <div class="toolbar-group">
                <select class="toolbar-select" id="lineSpacingSelect" onchange="applyLineSpacing()" title="Line Spacing" style="width: 90px;">
                    <option value="">Line Spacing</option>
                    <option value="1.0">1.0</option>
                    <option value="1.15">1.15</option>
                    <option value="1.5">1.5</option>
                    <option value="2.0">2.0</option>
                    <option value="2.5">2.5</option>
                    <option value="3.0">3.0</option>
                </select>
            </div>

            <div class="toolbar-group">
                <input type="number" 
                       class="toolbar-select" 
                       id="letterSpacingInput" 
                       placeholder="Letter spacing" 
                       min="-5" 
                       max="20" 
                       step="0.5"
                       style="width: 100px;"
                       title="Letter spacing in px"
                       onkeypress="if(event.key === 'Enter') { applyLetterSpacing(); return false; }">
                <button class="toolbar-btn-format" id="letterSpacingBtn" title="Apply Letter Spacing">
                    <i class="bi bi-check2"></i>
                </button>
            </div>

            <div class="toolbar-group">
                <input type="number" 
                       class="toolbar-select" 
                       id="wordSpacingInput" 
                       placeholder="Word spacing" 
                       min="-10" 
                       max="50" 
                       step="1"
                       style="width: 100px;"
                       title="Word spacing in px"
                       onkeypress="if(event.key === 'Enter') { applyWordSpacing(); return false; }">
                <button class="toolbar-btn-format" id="wordSpacingBtn" title="Apply Word Spacing">
                    <i class="bi bi-check2"></i>
                </button>
            </div>

            <!-- Clear Formatting -->
            <div class="toolbar-group">
                <button class="toolbar-btn-format" onclick="formatText('removeFormat')" title="Clear Formatting">
                    <i class="bi bi-eraser"></i>
                </button>
            </div>
        </div>

        <!-- Certificate Paper -->
        <div class="cert-paper-container">
            <div class="cert-paper" id="certificatePaper">

                <!-- ===== HEADER ===== -->
                <div class="cert-header">
                    <div class="cert-header-logos">
                        <img src="{{ asset('images/cert/image2.png') }}" alt="Barangay Kalawaan Logo" class="cert-header-logo">
                        <div class="cert-header-text" contenteditable="true" id="cert-header-text">
                            <p class="republic">REPUBLIC OF THE PHILIPPINES</p>
                            <p class="city">CITY GOVERNMENT OF PASIG</p>
                            <p class="barangay">BARANGAY KALAWAAN</p>
                            <p class="phone">Telephone No. (028) 742-6653</p>
                        </div>
                        <img src="{{ asset('images/cert/image1.jpeg') }}" alt="Pasig City Seal" class="cert-header-logo">
                    </div>
                </div>

                @if(in_array($certificateType, ['clearance', 'residency']))
                <!-- ID Number + Photo Box row -->
                <div class="cert-id-row" contenteditable="true" id="cert-idno-section">
                    <div class="cert-id-label">
                        Barangay I.D. No.: <strong>___</strong>
                    </div>
                    <div class="cert-photo-box {{ $certificateType === 'clearance' ? 'cert-photo-box-filled' : '' }}"></div>
                </div>
                @else
                <!-- ID Number only row -->
                <div style="margin-bottom: 12px;" contenteditable="true" id="cert-idno-section">
                    <span class="cert-id-label">Barangay I.D. No.: <strong>___</strong></span>
                </div>
                @endif

                <!-- ===== TITLE ===== -->
                <div class="cert-title cert-title-{{ $certificateType }}" contenteditable="true" id="cert-title">
                    @if($certificateType === 'clearance')
                        <h1>BARANGAY CLEARANCE</h1>
                    @elseif($certificateType === 'indigency')
                        <h1>CERTIFICATE OF INDIGENCY</h1>
                    @elseif($certificateType === 'residency')
                        <h1>CERTIFICATE OF RESIDENCY</h1>
                    @elseif($certificateType === 'no_income')
                        <h1>CERTIFICATION OF NO INCOME</h1>
                    @elseif($certificateType === 'low_income')
                        <h1>CERTIFICATON OF LOW INCOME</h1>
                    @endif
                </div>

                <!-- ===== BODY ===== -->
                <div class="cert-body" contenteditable="true" id="cert-body">
                    @if($certificateType === 'clearance')
                        <p>
                            This is to certify that <strong>_______________</strong>,
                            of legal age, (<strong>Single</strong>),
                            Filipino, is a resident of <strong>_______________</strong>,
                            and is known to be of good moral character and has no derogatory record on file in this barangay as of this date.
                        </p>
                    @elseif($certificateType === 'indigency')
                        <p>
                            This is to certify that <strong>_______________</strong>,
                            of legal age, (<strong>Single</strong>),
                            Filipino, is a resident of <strong>_______________</strong>
                            since <strong>________</strong> up to the present.
                        </p>
                    @elseif($certificateType === 'residency')
                        <p>
                            This is to certify that <strong>_______________</strong>,
                            of legal age, (<strong>Single</strong>),
                            Filipino, is a resident of <strong>_______________</strong>
                            since <strong>________</strong> up to the present.
                        </p>
                    @elseif($certificateType === 'no_income')
                        <p>
                            This is to certify that <strong>_______________</strong>,
                            of legal age, (<strong>Single</strong>),
                            Filipino, is a resident of <strong>_______________</strong>.
                        </p>
                        <p>
                            Based on the verification of this Barangay, the aforementioned individual is unemployed and has no regular income and belongs to one of the indigent families in this Barangay.
                        </p>
                    @elseif($certificateType === 'low_income')
                        <p>
                            This is to certify that <strong>_______________</strong>,
                            of legal age, (<strong>Single</strong>),
                            Filipino, is a resident of <strong>_______________</strong>.
                        </p>
                        <p>
                            Based on the assessment of this Barangay, the aforementioned individual is a low-income earner and has an estimated monthly income of
                            <strong>____________</strong>
                            which falls below the minimum wage requirements.
                        </p>
                    @endif

                    <!-- Purpose -->
                    <p>
                        This certification is being issued upon the request of the above-named person for the purpose of:
                        <strong>_______________</strong>.
                    </p>

                    <!-- Validity -->
                    <p>
                        @if($certificateType === 'indigency')
                            This certificate is valid for <strong>NINETY (90)</strong> days from the date of its issuance.
                        @else
                            This certificate is valid for <strong>SIXTY DAYS (60)</strong> from the date of its issuance.
                        @endif
                    </p>

                    <!-- Issuance -->
                    <p>
                        Issued this <strong>{{ $issueDay }}</strong>
                        day of <strong>{{ $issueMonth }}</strong>,
                        <strong>{{ $issueYear }}</strong>
                        at the Barangay Hall, Kalawaan, Pasig City, Philippines.
                    </p>
                </div>

                <!-- ===== SIGNATORY ===== -->
                <div class="cert-signatory" contenteditable="true" id="cert-signatory">
                    <p class="name">JESSIE B. GAVIOLA</p>
                    <p class="position">Barangay Chairman</p>
                </div>

                <!-- ===== NOTE ===== -->
                <div class="cert-note" contenteditable="true" id="cert-note">
                    Note: This certificate is not valid without the Official Barangay Dry Seal.
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Hidden form for saving -->
<form id="issueCertificateForm" action="{{ route('certificates.store') }}" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="resident_id" value="">
    <input type="hidden" name="certificate_type" value="{{ $certificateType }}">
    <input type="hidden" name="issued_date" value="{{ date('Y-m-d') }}">
    <input type="hidden" name="status" value="approved">
    <input type="hidden" name="certificate_content" id="certificateContentInput" value="">
    <input type="hidden" name="remarks" id="certificateRemarks" value="">
</form>

@endsection

@section('extra-scripts')
<script>
    // Global variable to store the last selection
    let savedSelection = null;

    // Save the current selection
    function saveSelection() {
        const selection = window.getSelection();
        if (selection.rangeCount > 0) {
            const paper = document.getElementById('certificatePaper');
            const range = selection.getRangeAt(0);
            // Only save if selection is within the certificate
            if (paper.contains(range.commonAncestorContainer)) {
                savedSelection = range.cloneRange();
            }
        }
    }

    // Restore the saved selection
    function restoreSelection() {
        if (savedSelection) {
            const selection = window.getSelection();
            selection.removeAllRanges();
            selection.addRange(savedSelection);
            return true;
        }
        return false;
    }

    // ===== Rich Text Formatting =====
    function formatText(command, value = null) {
        // Restore selection if it was saved
        restoreSelection();

        // Focus on the certificate paper if not focused
        const paper = document.getElementById('certificatePaper');
        if (!document.activeElement || !paper.contains(document.activeElement)) {
            paper.focus();
        }

        // Execute the formatting command
        document.execCommand(command, false, value);

        // Trigger auto-save
        autoSave();

        // Update toolbar button states
        updateToolbarState();
    }

    // Custom indent/outdent that works on specific elements
    function adjustIndent(direction) {
        const selection = window.getSelection();
        if (!selection.rangeCount) return;

        const range = selection.getRangeAt(0);
        let element = range.startContainer;

        // Find the nearest block-level element
        while (element && element.nodeType !== 1) {
            element = element.parentNode;
        }

        // Find the closest block element (p, div, li, etc.)
        while (element && !['P', 'DIV', 'LI', 'H1', 'H2', 'H3', 'H4', 'H5', 'H6'].includes(element.tagName)) {
            element = element.parentNode;
        }

        if (!element) return;

        // Get current margin and text-indent
        const currentMargin = parseInt(window.getComputedStyle(element).marginLeft) || 0;
        const currentTextIndent = parseInt(window.getComputedStyle(element).textIndent) || 0;
        const indentAmount = 40; // pixels

        if (direction === 'increase') {
            element.style.marginLeft = (currentMargin + indentAmount) + 'px';
        } else if (direction === 'decrease') {
            // First try to remove text-indent if it exists
            if (currentTextIndent > 0) {
                const newTextIndent = Math.max(0, currentTextIndent - indentAmount);
                element.style.textIndent = newTextIndent + 'px';
            } else if (currentMargin > 0) {
                // Then remove margin-left
                const newMargin = Math.max(0, currentMargin - indentAmount);
                element.style.marginLeft = newMargin + 'px';
            }
        }

        // Trigger auto-save
        autoSave();
        updateToolbarState();
    }

    // Apply custom font size
    function applyFontSize() {
        const input = document.getElementById('fontSizeInput');
        const size = parseInt(input.value);
        
        if (!size || size < 8 || size > 72) {
            alert('Please enter a valid font size between 8 and 72pt');
            return;
        }

        // Restore the saved selection
        if (!restoreSelection()) {
            alert('Please select some text first');
            return;
        }

        const selection = window.getSelection();
        if (!selection.rangeCount) {
            alert('Please select some text first');
            return;
        }

        const range = selection.getRangeAt(0);
        const span = document.createElement('span');
        span.style.fontSize = size + 'pt';
        
        try {
            range.surroundContents(span);
        } catch(e) {
            // If surroundContents fails (e.g., partial element selection), use execCommand
            document.execCommand('fontSize', false, '7');
            // Then manually set the size
            const fontElements = document.querySelectorAll('font[size="7"]');
            fontElements.forEach(el => {
                el.removeAttribute('size');
                el.style.fontSize = size + 'pt';
            });
        }

        // Clear input and trigger auto-save
        input.value = '';
        autoSave();
    }

    // Change font size by relative amount (for keyboard shortcuts)
    function changeFontSize(delta) {
        // Save selection first
        saveSelection();
        
        const selection = window.getSelection();
        if (!selection.rangeCount) return;

        // Restore selection if needed
        restoreSelection();

        const range = selection.getRangeAt(0);
        let element = range.startContainer;

        // Get the parent element if text node
        if (element.nodeType === 3) {
            element = element.parentElement;
        }

        // Get current font size
        const currentSize = parseInt(window.getComputedStyle(element).fontSize);
        const newSize = Math.max(8, Math.min(72, currentSize + delta));

        // Apply new size to selection
        const span = document.createElement('span');
        span.style.fontSize = newSize + 'px';
        
        try {
            if (selection.toString().length > 0) {
                range.surroundContents(span);
            } else {
                // If no selection, apply to current element
                element.style.fontSize = newSize + 'px';
            }
        } catch (e) {
            // If surroundContents fails, extract and wrap contents
            const contents = range.extractContents();
            span.appendChild(contents);
            range.insertNode(span);
        }

        // Trigger auto-save
        autoSave();
    }

    // Apply line spacing to current paragraph/block
    function applyLineSpacing() {
        const select = document.getElementById('lineSpacingSelect');
        const spacing = select.value;
        
        if (!spacing) {
            return;
        }

        const selection = window.getSelection();
        if (!selection.rangeCount) {
            alert('Please place your cursor in a paragraph');
            return;
        }

        const range = selection.getRangeAt(0);
        let element = range.startContainer;

        // Find the nearest block-level element
        while (element && element.nodeType !== 1) {
            element = element.parentNode;
        }

        // Find the closest block element (p, div, etc.)
        while (element && !['P', 'DIV', 'H1', 'H2', 'H3', 'H4', 'H5', 'H6', 'SECTION'].includes(element.tagName)) {
            element = element.parentNode;
        }

        if (element) {
            element.style.lineHeight = spacing;
        }

        // Reset select
        select.value = '';
        autoSave();
    }

    // Apply line spacing directly (for keyboard shortcuts)
    function applyLineSpacingDirect(spacing) {
        const selection = window.getSelection();
        if (!selection.rangeCount) return;

        const range = selection.getRangeAt(0);
        let element = range.startContainer;

        // Find the nearest block-level element
        while (element && element.nodeType !== 1) {
            element = element.parentNode;
        }

        // Find the closest block element (p, div, etc.)
        while (element && !['P', 'DIV', 'H1', 'H2', 'H3', 'H4', 'H5', 'H6', 'SECTION'].includes(element.tagName)) {
            element = element.parentNode;
        }

        if (element) {
            element.style.lineHeight = spacing;
        }

        autoSave();
    }

    // Apply letter spacing to selection or current element
    function applyLetterSpacing() {
        const input = document.getElementById('letterSpacingInput');
        const spacing = parseFloat(input.value);
        
        if (isNaN(spacing)) {
            alert('Please enter a valid letter spacing value');
            return;
        }

        // Restore the saved selection
        if (!restoreSelection()) {
            alert('Please select some text or place cursor in a paragraph');
            return;
        }

        const selection = window.getSelection();
        if (!selection.rangeCount) {
            alert('Please select some text or place cursor in a paragraph');
            return;
        }

        const range = selection.getRangeAt(0);
        
        if (selection.toString().length > 0) {
            // Apply to selection
            const span = document.createElement('span');
            span.style.letterSpacing = spacing + 'px';
            
            try {
                range.surroundContents(span);
            } catch (e) {
                const contents = range.extractContents();
                span.appendChild(contents);
                range.insertNode(span);
            }
        } else {
            // Apply to current block element
            let element = range.startContainer;
            while (element && element.nodeType !== 1) {
                element = element.parentNode;
            }
            while (element && !['P', 'DIV', 'H1', 'H2', 'H3', 'H4', 'H5', 'H6', 'SECTION', 'SPAN'].includes(element.tagName)) {
                element = element.parentNode;
            }
            if (element) {
                element.style.letterSpacing = spacing + 'px';
            }
        }

        input.value = '';
        autoSave();
    }

    // Apply word spacing to selection or current element
    function applyWordSpacing() {
        const input = document.getElementById('wordSpacingInput');
        const spacing = parseFloat(input.value);
        
        if (isNaN(spacing)) {
            alert('Please enter a valid word spacing value');
            return;
        }

        // Restore the saved selection
        if (!restoreSelection()) {
            alert('Please select some text or place cursor in a paragraph');
            return;
        }

        const selection = window.getSelection();
        if (!selection.rangeCount) {
            alert('Please select some text or place cursor in a paragraph');
            return;
        }

        const range = selection.getRangeAt(0);
        
        if (selection.toString().length > 0) {
            // Apply to selection
            const span = document.createElement('span');
            span.style.wordSpacing = spacing + 'px';
            
            try {
                range.surroundContents(span);
            } catch (e) {
                const contents = range.extractContents();
                span.appendChild(contents);
                range.insertNode(span);
            }
        } else {
            // Apply to current block element
            let element = range.startContainer;
            while (element && element.nodeType !== 1) {
                element = element.parentNode;
            }
            while (element && !['P', 'DIV', 'H1', 'H2', 'H3', 'H4', 'H5', 'H6', 'SECTION', 'SPAN'].includes(element.tagName)) {
                element = element.parentNode;
            }
            if (element) {
                element.style.wordSpacing = spacing + 'px';
            }
        }

        input.value = '';
        autoSave();
    }

    // Update toolbar button active states based on current selection
    function updateToolbarState() {
        const commands = ['bold', 'italic', 'underline', 'strikethrough'];
        const buttons = document.querySelectorAll('.toolbar-btn-format');
        
        buttons.forEach(btn => {
            const icon = btn.querySelector('i');
            if (!icon) return;

            // Check which command this button represents
            if (icon.classList.contains('bi-type-bold') && document.queryCommandState('bold')) {
                btn.classList.add('active');
            } else if (icon.classList.contains('bi-type-italic') && document.queryCommandState('italic')) {
                btn.classList.add('active');
            } else if (icon.classList.contains('bi-type-underline') && document.queryCommandState('underline')) {
                btn.classList.add('active');
            } else if (icon.classList.contains('bi-type-strikethrough') && document.queryCommandState('strikethrough')) {
                btn.classList.add('active');
            } else {
                btn.classList.remove('active');
            }
        });
    }

    // ===== Sidebar Field Updates (Optional Helper) =====
    function updateField(field) {
        // This is now a simple helper that can manually update text
        // Users can type directly in the certificate for full control
        autoSave();
    }

    // ===== Print =====
    function printCertificate() {
        window.print();
    }

    // ===== Save / Mark as Issued =====
    function markAsIssued() {
        Swal.fire({
            title: 'Issue Certificate?',
            html: 'This will save the certificate and mark it as <strong>issued</strong>.<br><br>Make sure you have printed the certificate first.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: '<i class="bi bi-check-circle me-1"></i> Yes, Issue Certificate',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#10b981',
            cancelButtonColor: '#6b7280',
        }).then((result) => {
            if (result.isConfirmed) {
                // Capture the certificate content
                const paper = document.getElementById('certificatePaper');
                document.getElementById('certificateContentInput').value = paper.innerHTML;

                const purpose = document.getElementById('field-purpose')?.value || '';
                document.getElementById('certificateRemarks').value = purpose ? 'Purpose: ' + purpose : '';

                // Clear saved state after successful issue
                clearSavedState();
                document.getElementById('issueCertificateForm').submit();
            }
        });
    }

    // ===== Auto-save to localStorage =====
    const STORAGE_KEY = 'cert_editor_{{ $certificateType }}';
    let saveTimeout = null;

    function getFormState() {
        const state = {};
        
        // Save entire editable sections
        const editableSections = [
            'cert-header-text',
            'cert-idno-section',
            'cert-title', 
            'cert-body',
            'cert-signatory',
            'cert-note'
        ];
        
        editableSections.forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                state[id] = el.innerHTML;
            }
        });

        // Save sidebar fields
        document.querySelectorAll('.editor-sidebar input, .editor-sidebar select, .editor-sidebar textarea').forEach(el => {
            if (el.id) state['sidebar_' + el.id] = el.value;
        });
        
        return state;
    }

    function restoreFormState() {
        try {
            const saved = localStorage.getItem(STORAGE_KEY);
            if (!saved) return;
            const state = JSON.parse(saved);

            // Restore editable sections
            Object.entries(state).forEach(([key, value]) => {
                if (key.startsWith('sidebar_')) {
                    const el = document.getElementById(key.replace('sidebar_', ''));
                    if (el) el.value = value;
                } else {
                    const el = document.getElementById(key);
                    if (el && value) el.innerHTML = value;
                }
            });

            showSaveBadge('Restored');
        } catch(e) {
            console.warn('Could not restore saved state:', e);
        }
    }

    function autoSave() {
        clearTimeout(saveTimeout);
        saveTimeout = setTimeout(() => {
            try {
                localStorage.setItem(STORAGE_KEY, JSON.stringify(getFormState()));
                showSaveBadge('Saved');
            } catch(e) {
                console.warn('Auto-save failed:', e);
            }
        }, 500);
    }

    function showSaveBadge(text) {
        const badge = document.getElementById('autosaveBadge');
        if (!badge) return;
        badge.innerHTML = '<i class="bi bi-check-circle-fill"></i> ' + text;
        badge.style.display = 'inline-flex';
        badge.classList.remove('saving');
        clearTimeout(badge._hideTimer);
        badge._hideTimer = setTimeout(() => { badge.style.display = 'none'; }, 2500);
    }

    function clearSavedState() {
        localStorage.removeItem(STORAGE_KEY);
    }

    function setupAutoSave() {
        // Listen to all editable certificate sections
        const editableSections = document.querySelectorAll('[contenteditable="true"]');
        editableSections.forEach(el => {
            el.addEventListener('input', autoSave);
            el.addEventListener('paste', autoSave);
        });

        // Listen to sidebar inputs
        document.querySelectorAll('.editor-sidebar input, .editor-sidebar select, .editor-sidebar textarea').forEach(el => {
            el.addEventListener('input', autoSave);
            el.addEventListener('change', autoSave);
        });

        // Update toolbar state on selection change
        document.addEventListener('selectionchange', updateToolbarState);
    }

    // ===== Keyboard Shortcuts =====
    function setupKeyboardShortcuts() {
        document.addEventListener('keydown', (e) => {
            // Ctrl/Cmd + B = Bold
            if ((e.ctrlKey || e.metaKey) && e.key === 'b') {
                e.preventDefault();
                formatText('bold');
            }
            // Ctrl/Cmd + I = Italic
            if ((e.ctrlKey || e.metaKey) && e.key === 'i') {
                e.preventDefault();
                formatText('italic');
            }
            // Ctrl/Cmd + U = Underline
            if ((e.ctrlKey || e.metaKey) && e.key === 'u') {
                e.preventDefault();
                formatText('underline');
            }
            // Ctrl/Cmd + L = Align Left
            if ((e.ctrlKey || e.metaKey) && e.key === 'l') {
                e.preventDefault();
                formatText('justifyLeft');
            }
            // Ctrl/Cmd + E = Align Center
            if ((e.ctrlKey || e.metaKey) && e.key === 'e') {
                e.preventDefault();
                formatText('justifyCenter');
            }
            // Ctrl/Cmd + R = Align Right
            if ((e.ctrlKey || e.metaKey) && e.key === 'r') {
                e.preventDefault();
                formatText('justifyRight');
            }
            // Ctrl/Cmd + J = Justify
            if ((e.ctrlKey || e.metaKey) && e.key === 'j') {
                e.preventDefault();
                formatText('justifyFull');
            }
            // Ctrl/Cmd + Shift + L = Bullet List
            if ((e.ctrlKey || e.metaKey) && e.shiftKey && e.key === 'L') {
                e.preventDefault();
                formatText('insertUnorderedList');
            }
            // Ctrl/Cmd + ] = Increase Font Size
            if ((e.ctrlKey || e.metaKey) && e.key === ']') {
                e.preventDefault();
                changeFontSize(2);
            }
            // Ctrl/Cmd + [ = Decrease Font Size
            if ((e.ctrlKey || e.metaKey) && e.key === '[') {
                e.preventDefault();
                changeFontSize(-2);
            }
            // Ctrl/Cmd + Shift + > = Increase Font Size (Alternative)
            if ((e.ctrlKey || e.metaKey) && e.shiftKey && e.key === '>') {
                e.preventDefault();
                changeFontSize(2);
            }
            // Ctrl/Cmd + Shift + < = Decrease Font Size (Alternative)
            if ((e.ctrlKey || e.metaKey) && e.shiftKey && e.key === '<') {
                e.preventDefault();
                changeFontSize(-2);
            }
            // Ctrl/Cmd + 1 = Single Line Spacing
            if ((e.ctrlKey || e.metaKey) && e.key === '1') {
                e.preventDefault();
                applyLineSpacingDirect('1.0');
            }
            // Ctrl/Cmd + 5 = 1.5 Line Spacing
            if ((e.ctrlKey || e.metaKey) && e.key === '5') {
                e.preventDefault();
                applyLineSpacingDirect('1.5');
            }
            // Ctrl/Cmd + 2 = Double Line Spacing
            if ((e.ctrlKey || e.metaKey) && e.key === '2') {
                e.preventDefault();
                applyLineSpacingDirect('2.0');
            }
            // Ctrl/Cmd + P = Print
            if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
                e.preventDefault();
                printCertificate();
            }
        });
    }

    // ===== Setup Selection Preservation =====
    function setupSelectionPreservation() {
        const paper = document.getElementById('certificatePaper');
        const fontSizeInput = document.getElementById('fontSizeInput');
        const letterSpacingInput = document.getElementById('letterSpacingInput');
        const wordSpacingInput = document.getElementById('wordSpacingInput');
        const letterSpacingBtn = document.getElementById('letterSpacingBtn');
        const wordSpacingBtn = document.getElementById('wordSpacingBtn');
        
        // Save selection when user selects text in the certificate
        paper.addEventListener('mouseup', saveSelection);
        paper.addEventListener('keyup', saveSelection);
        
        // Prevent inputs from clearing selection on click/mousedown
        function preventSelectionLoss(input) {
            input.addEventListener('mousedown', function(e) {
                e.preventDefault();
                saveSelection();
                setTimeout(() => {
                    input.focus();
                }, 0);
            });
            
            input.addEventListener('click', function(e) {
                e.preventDefault();
            });
        }
        
        // Apply to all inputs
        preventSelectionLoss(fontSizeInput);
        preventSelectionLoss(letterSpacingInput);
        preventSelectionLoss(wordSpacingInput);

        // Save selection before buttons are clicked
        letterSpacingBtn.addEventListener('mousedown', function(e) {
            e.preventDefault();
            saveSelection();
        });
        
        letterSpacingBtn.addEventListener('click', function(e) {
            applyLetterSpacing();
        });

        wordSpacingBtn.addEventListener('mousedown', function(e) {
            e.preventDefault();
            saveSelection();
        });
        
        wordSpacingBtn.addEventListener('click', function(e) {
            applyWordSpacing();
        });
    }

    // ===== Initialize =====
    document.addEventListener('DOMContentLoaded', function() {
        restoreFormState();
        setupAutoSave();
        setupKeyboardShortcuts();
        setupSelectionPreservation();
        updateToolbarState();
    });
</script>
@endsection
