@extends('layouts.app')

@section('title', 'Certification of No Income')

@section('extra-styles')
<style>
    /* ===== Layout ===== */
    .editor-wrapper { display: flex; gap: 24px; align-items: flex-start; }
    .editor-sidebar { width: 300px; min-width: 300px; position: sticky; top: 20px; max-height: calc(100vh - 40px); overflow-y: auto; }
    .editor-main { flex: 1; display: flex; flex-direction: column; align-items: center; min-width: 0; }

    /* ===== Sidebar ===== */
    .sidebar-card { background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); padding: 20px; margin-bottom: 14px; }
    .sidebar-card h3 { font-size: 14px; font-weight: 700; color: #1f2937; margin: 0 0 14px 0; display: flex; align-items: center; gap: 8px; }
    .sidebar-card h3 i { color: #0038A8; }
    .action-buttons { display: flex; flex-direction: column; gap: 10px; }
    .btn-action { display: flex; align-items: center; justify-content: center; gap: 8px; padding: 11px 16px; border-radius: 8px; font-weight: 600; font-size: 14px; cursor: pointer; border: none; transition: all 0.2s; text-decoration: none; color: white; }
    .btn-action:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
    .btn-print  { background: #0038A8; }
    .btn-print:hover  { background: #002B88; color: white; }
    .btn-back-action { background: #6b7280; }
    .btn-back-action:hover { background: #4b5563; color: white; }
    .btn-download { background: #8b5cf6; }
    .btn-download:hover { background: #7c3aed; color: white; }
    .tip-box { background: #f0f9ff; border-left: 3px solid #0038A8; padding: 11px 13px; border-radius: 0 6px 6px 0; font-size: 12px; color: #374151; line-height: 1.5; }
    .tip-box strong { color: #0038A8; }
    .back-link { color: #0038A8; text-decoration: none; font-size: 14px; margin-bottom: 16px; display: inline-flex; align-items: center; gap: 6px; }
    .back-link:hover { text-decoration: underline; }

    /* ===== Paper wrapper ===== */
    .cert-paper-wrap { display: flex; flex-direction: column; align-items: center; width: 100%; }
    .cert-paper-bg { background: #c9cdd4; padding: 28px 28px 36px 28px; border-radius: 10px; display: flex; justify-content: center; width: 100%; box-sizing: border-box; overflow-x: auto; }

    /* ===== Certificate Paper ===== */
    .cert-paper { width: 8.5in; min-height: 11in; background: white; box-shadow: 0 4px 24px rgba(0,0,0,0.18); padding: 0 1in 1.5in 1in; font-family: 'Times New Roman', Times, serif; color: #000; box-sizing: border-box; position: relative; flex-shrink: 0; }

    /* ===== Header ===== */
    .cert-header { text-align: center; margin: 0 -1in; padding: 0 1in 12px 1in; border-bottom: 2px solid #000; }
    .cert-header-logos { display: flex; align-items: center; justify-content: center; gap: 16px; }
    .cert-header-logo { width: 95px; height: 95px; object-fit: contain; flex-shrink: 0; }
    .cert-header-text { text-align: center; flex: 1; }
    .cert-header-text .republic,
    .cert-header-text .city    { font-size: 11pt; margin: 0; letter-spacing: 0.5px; }
    .cert-header-text .barangay { font-size: 18pt; font-weight: bold; margin: 4px 0; letter-spacing: 1px; }
    .cert-header-text .phone   { font-size: 10pt; margin: 0; }

    /* ===== ID Row with photo ===== */
    .cert-id-row { display: flex; justify-content: space-between; align-items: center; margin-top: 120px; margin-bottom: 24px; }
    .cert-id-label { font-size: 14pt; }

    /* ===== Photo Box ===== */
    .cert-photo-box { width: 1.3in; height: 1.6in; border: 1px solid #000; flex-shrink: 0; position: relative; overflow: hidden; cursor: pointer; display: flex; align-items: center; justify-content: center; background: #f9f9f9; }
    .cert-photo-box img { width: 100%; height: 100%; object-fit: cover; display: block; position: absolute; top: 0; left: 0; }
    .cert-photo-hint { display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 4px; color: #9ca3af; font-size: 8pt; font-family: sans-serif; text-align: center; pointer-events: none; line-height: 1.3; padding: 4px; position: relative; z-index: 1; }
    .cert-photo-hint i { font-size: 18px; }
    .cert-photo-box:hover .cert-photo-hint { color: #6b7280; }
    .cert-photo-box input[type="file"] { display: none; }

    /* ===== Title ===== */
    .cert-title { text-align: center; margin: 4px 0 18px 0; }
    .cert-title h1 { font-size: 16pt; font-weight: bold; margin: 0; letter-spacing: 2px; }

    /* ===== Body ===== */
    .cert-body { font-size: 14pt; line-height: 2; text-align: justify; outline: none; }
    .cert-body p { margin: 0; text-indent: 48px; }
    .cert-body p.no-indent { text-indent: 0; }
    .cert-body p + p { margin-top: 0; }

    /* ===== Editable blanks ===== */
    .blank { display: inline; font-weight: bold; border-bottom: 1px solid #000; min-width: 80px; outline: none; color: #1a1aff; cursor: text; white-space: nowrap; }
    .blank:focus { background: #eef4ff; }

    /* ===== Signatory ===== */
    .cert-signatory { margin-top: 56px; text-align: center; }
    .cert-signatory .name    { font-size: 16pt; font-weight: bold; margin: 0; text-decoration: underline; }
    .cert-signatory .position { font-size: 14pt; margin: 4px 0 0 0; }

    /* ===== Note ===== */
    .cert-note { position: absolute; bottom: 1in; left: 1in; right: 1in; margin: 0; font-size: 12pt; font-style: italic; text-align: center; }

    /* ===== Responsive ===== */
    @media (max-width: 1300px) {
        .editor-wrapper { flex-direction: column; }
        .editor-sidebar { width: 100%; min-width: unset; position: static; max-height: none; overflow-y: visible; }
        .cert-paper-bg { padding: 16px 16px 24px 16px; }
    }
    @media (max-width: 768px) {
        .cert-paper-bg { padding: 10px 8px 18px 8px; }
        .cert-paper { padding: 0 14px 28px 14px; }
        .cert-header { margin: 0 -14px; padding: 14px 14px 8px 14px; }
        .cert-header-logo { width: 52px; height: 52px; }
        .cert-header-logos { gap: 8px; }
        .cert-header-text .republic, .cert-header-text .city { font-size: 7.5pt; }
        .cert-header-text .barangay { font-size: 11pt; }
        .cert-title h1 { font-size: 11pt; }
        .cert-body { font-size: 10pt; line-height: 1.8; }
        .cert-body p { text-indent: 24px; }
        .cert-signatory { margin-top: 32px; }
        .cert-signatory .name { font-size: 11pt; }
        .cert-note { position: static; font-size: 8.5pt; margin-top: 20px; }
        .btn-action { padding: 10px 14px; font-size: 13px; }
    }
    @media (max-width: 480px) {
        .cert-paper { padding: 0 10px 20px 10px; }
        .cert-header { margin: 0 -10px; padding: 10px 10px 8px 10px; }
        .cert-header-logo { width: 38px; height: 38px; }
        .cert-header-text .barangay { font-size: 9pt; }
        .cert-title h1 { font-size: 9pt; letter-spacing: 1px; }
        .cert-body { font-size: 9pt; }
    }
</style>
@endsection

@section('content')
<a href="#" class="back-link" id="backBtn"><i class="bi bi-arrow-left"></i> Back to Certificates</a>

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
                <a href="{{ route('certificates.word.template', ['type' => 'no_income']) }}" class="btn-action btn-download">
                    <i class="bi bi-file-earmark-word-fill"></i> Download Word Template
                </a>
                <button class="btn-action btn-back-action" id="backBtnAction">
                    <i class="bi bi-arrow-left"></i> Back to Certificates
                </button>
            </div>
        </div>
    </div>

    <!-- ===== Certificate Preview ===== -->
    <div class="editor-main">
        <div class="cert-paper-wrap">
            <div class="cert-paper-bg">
                <div class="cert-paper" id="certificatePaper">

                    <!-- Header -->
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

                    <!-- ID row with photo box -->
                    <div class="cert-id-row">
                        <div class="cert-id-label">Barangay I.D. No.: <span class="blank" contenteditable="true" spellcheck="false">___________</span></div>
                        <div class="cert-photo-box" id="photoBox" onclick="document.getElementById('photoInput').click()" title="Click to upload photo">
                            <input type="file" id="photoInput" accept="image/*">
                            <img id="photoPreview" src="" alt="" style="display:none;">
                            <div class="cert-photo-hint" id="photoHint">
                                <i class="bi bi-camera-fill"></i>
                                <span>Click to<br>upload photo</span>
                            </div>
                        </div>
                    </div>

                    <!-- Title -->
                    <div class="cert-title">
                        <h1>CERTIFICATION &nbsp; OF &nbsp; NO INCOME</h1>
                    </div>

                    <!-- Body -->
                    <div class="cert-body">
                        <p>This is to certify that <span class="blank" contenteditable="true" spellcheck="false">Full Name</span>,
                        of legal age, (<span class="blank" contenteditable="true" spellcheck="false">Single/Married/Widow/Widower</span>),
                        Filipino, is a resident of <span class="blank" contenteditable="true" spellcheck="false">Street / Purok, Barangay Kalawaan, Pasig City</span>.</p>

                        <p>Based on the verification of this Barangay, the aforementioned individual is
                        unemployed and has no regular income and belongs to one of the indigent
                        families in this Barangay.</p>

                        <p>This certification is being issued upon the request of the above-named
                        individual for the purpose of <span class="blank" contenteditable="true" spellcheck="false">state purpose here</span>
                        and is valid for <strong>SIXTY (60) DAYS</strong> from the date of issuance and shall be
                        used solely for the purpose stated above.</p>

                        <p class="no-indent">Issued this <strong>{{ $issueDay ?? date('j') }}</strong> day of
                        <strong>{{ $issueMonth ?? date('F') }}</strong>,
                        <strong>{{ $issueYear ?? date('Y') }}</strong> at the Barangay Hall,
                        Kalawaan, Pasig City, Metro Manila, Philippines.</p>
                    </div>

                    <!-- Signatory -->
                    <div class="cert-signatory">
                        <p class="name">JESSIE B. GAVIOLA</p>
                        <p class="position">Barangay Chairman</p>
                    </div>

                    <!-- Note -->
                    <div class="cert-note">
                        <em>Note: This certificate is not valid without the Official Barangay Dry Seal.</em>
                    </div>

                </div><!-- /.cert-paper -->
            </div><!-- /.cert-paper-bg -->
        </div><!-- /.cert-paper-wrap -->
    </div><!-- /.editor-main -->

</div><!-- /.editor-wrapper -->
@endsection

@section('extra-scripts')
<script>
(function () {
    function goBack(e) { e.preventDefault(); window.location.href = '{{ route("certificates.index") }}'; }
    document.addEventListener('DOMContentLoaded', function () {
        var b1 = document.getElementById('backBtn');
        var b2 = document.getElementById('backBtnAction');
        if (b1) b1.addEventListener('click', goBack);
        if (b2) b2.addEventListener('click', goBack);

        /* Photo upload */
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

        document.querySelectorAll('.blank').forEach(function (el) {
            el.addEventListener('focus', function () {
                var range = document.createRange();
                range.selectNodeContents(el);
                var sel = window.getSelection();
                sel.removeAllRanges();
                sel.addRange(range);
            });
            el.addEventListener('keydown', function (e) {
                if (e.key === 'Enter') { e.preventDefault(); el.blur(); }
            });
        });
    });

    function printCertificate() {
        var paper = document.getElementById('certificatePaper');
        if (!paper) return;
        var clone = paper.cloneNode(true);
        clone.querySelectorAll('[contenteditable]').forEach(function (el) { el.removeAttribute('contenteditable'); });
        clone.querySelectorAll('.blank').forEach(function (el) { el.style.color = '#000'; el.style.borderBottomColor = '#000'; });
        var styleLinks  = Array.from(document.querySelectorAll('link[rel="stylesheet"]')).map(function (l) { return l.outerHTML; }).join('\n');
        var styleBlocks = Array.from(document.querySelectorAll('style')).map(function (s) { return '<style>' + s.textContent + '</style>'; }).join('\n');
        var win = window.open('', '_blank', 'width=950,height=1250');
        if (!win) { alert('Pop-up blocked. Please allow pop-ups for this site.'); return; }
        win.document.write(
            '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>Certification of No Income</title>'
            + styleLinks + styleBlocks
            + '<style>'
            + '@page{size:letter portrait;margin:0;}'
            + '*,*::before,*::after{-webkit-print-color-adjust:exact!important;print-color-adjust:exact!important;box-sizing:border-box;}'
            + 'html,body{margin:0;padding:0;background:white;}'
            + '.cert-paper{width:8.5in!important;min-height:11in!important;padding:0 1in 1.5in 1in!important;margin:0 auto!important;box-shadow:none!important;border:none!important;background:white!important;position:relative!important;}'
            + '.cert-header{margin:0 -1in!important;padding:0.2in 1in 12px 1in!important;}'
            + '.cert-note{position:absolute!important;bottom:1in!important;left:1in!important;right:1in!important;margin:0!important;}'
            + '.blank{color:#000!important;border-bottom-color:#000!important;}'
            + '</style>'
            + '</head><body>' + clone.outerHTML
            + '<script>window.onload=function(){window.focus();window.print();window.onafterprint=function(){window.close();};setTimeout(function(){window.close();},8000);};<\/script>'
            + '</body></html>'
        );
        win.document.close();
    }
    window.printCertificate = printCertificate;
}());
</script>
@endsection
