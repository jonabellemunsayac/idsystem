@extends('layouts.app')

@section('title', 'Edit: ' . $sitePage->title)

@section('extra-styles')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    .ve-toolbar {
        position: sticky; top: 0; z-index: 100; background: white;
        border-bottom: 1px solid #e5e7eb; padding: 10px 16px;
        display: flex; align-items: center; justify-content: space-between;
        margin: -1rem -1rem 0 -1rem; gap: 10px;
    }
    .ve-toolbar-left { display: flex; align-items: center; gap: 12px; }
    .ve-toolbar-left .back-link {
        color: #6b7280; text-decoration: none; font-size: 18px;
        display: flex; align-items: center; padding: 4px; border-radius: 6px; transition: all 0.2s;
    }
    .ve-toolbar-left .back-link:hover { color: #0038A8; background: #eff6ff; }
    .ve-toolbar-left .page-name { font-size: 15px; font-weight: 700; color: #1f2937; }
    .ve-toolbar-left .page-slug-label {
        font-size: 11px; color: #9ca3af; font-family: monospace;
        background: #f3f4f6; padding: 2px 8px; border-radius: 4px;
    }
    .ve-toolbar-right { display: flex; align-items: center; gap: 8px; }
    .ve-toolbar-right .btn { font-size: 12px; font-weight: 600; padding: 7px 16px; border-radius: 6px; }
    .ve-btn-save { background: #0038A8; color: white; border: none; }
    .ve-btn-save:hover { background: #002B88; color: white; }
    .ve-btn-save:disabled { background: #93c5fd; cursor: not-allowed; }
    .ve-btn-outline { background: white; color: #374151; border: 1px solid #d1d5db; }
    .ve-btn-outline:hover { background: #f3f4f6; color: #1f2937; }
    .ve-unsaved-dot { width: 8px; height: 8px; background: #f59e0b; border-radius: 50%; display: none; flex-shrink: 0; }
    .ve-unsaved-dot.show { display: inline-block; }

    .ve-workspace { display: flex; gap: 0; margin: 0 -1rem -1rem -1rem; height: calc(100vh - 120px); overflow: hidden; }
    .ve-canvas { flex: 1; overflow-y: auto; background: #e5e7eb; position: relative; }
    .ve-canvas-inner { max-width: 100%; margin: 0 auto; background: white; min-height: 100%; position: relative; }

    .ve-section {
        position: relative; cursor: pointer; transition: outline 0.15s, box-shadow 0.15s;
        outline: 2px solid transparent; outline-offset: -2px;
    }
    .ve-section:hover { outline: 2px dashed #93c5fd; }
    .ve-section.ve-selected { outline: 2px solid #0038A8; box-shadow: 0 0 0 4px rgba(0,56,168,0.1); }
    .ve-section-tag {
        position: absolute; top: 0; left: 0; background: #0038A8; color: white;
        font-size: 10px; font-weight: 700; padding: 3px 10px; border-radius: 0 0 6px 0;
        z-index: 10; opacity: 0; transition: opacity 0.15s; pointer-events: none;
        text-transform: uppercase; letter-spacing: 0.5px;
    }
    .ve-section:hover .ve-section-tag, .ve-section.ve-selected .ve-section-tag { opacity: 1; }
    .ve-section-actions { position: absolute; top: 0; right: 0; display: none; gap: 2px; z-index: 10; padding: 4px; }
    .ve-section.ve-selected .ve-section-actions { display: flex; }
    .ve-section-actions button {
        width: 28px; height: 28px; border: none; border-radius: 4px;
        display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: 13px; transition: all 0.15s;
    }
    .ve-act-move { background: #0038A8; color: white; }
    .ve-act-move:hover { background: #002B88; }
    .ve-act-move:disabled { background: #93c5fd; cursor: not-allowed; }
    .ve-act-delete { background: #ef4444; color: white; }
    .ve-act-delete:hover { background: #dc2626; }

    .ve-drop-zone {
        padding: 24px; text-align: center; color: #9ca3af; font-size: 13px;
        border: 2px dashed #d1d5db; margin: 16px; border-radius: 8px; transition: all 0.2s; cursor: pointer;
    }
    .ve-drop-zone:hover { border-color: #0038A8; color: #0038A8; background: #eff6ff; }

    .ve-panel { width: 360px; min-width: 360px; background: white; border-left: 1px solid #e5e7eb; display: flex; flex-direction: column; overflow: hidden; }
    @media (max-width: 900px) { .ve-panel { width: 280px; min-width: 280px; } }
    .ve-panel-tabs { display: flex; border-bottom: 1px solid #e5e7eb; flex-shrink: 0; }
    .ve-panel-tab {
        flex: 1; padding: 10px 8px; text-align: center; font-size: 12px; font-weight: 600;
        color: #6b7280; cursor: pointer; border-bottom: 2px solid transparent;
        transition: all 0.2s; background: none; border-top: none; border-left: none; border-right: none;
    }
    .ve-panel-tab:hover { color: #374151; background: #f9fafb; }
    .ve-panel-tab.active { color: #0038A8; border-bottom-color: #0038A8; background: #eff6ff; }
    .ve-panel-body { flex: 1; overflow-y: auto; padding: 16px; }

    .ve-components-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
    .ve-component-btn {
        display: flex; flex-direction: column; align-items: center; gap: 6px;
        padding: 14px 8px; background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px;
        cursor: pointer; transition: all 0.2s; font-size: 11px; font-weight: 600; color: #374151; text-align: center;
    }
    .ve-component-btn:hover {
        border-color: #0038A8; background: #eff6ff; color: #0038A8;
        transform: translateY(-1px); box-shadow: 0 2px 8px rgba(0,56,168,0.1);
    }
    .ve-component-btn i { font-size: 20px; }

    .ve-props-empty { text-align: center; padding: 40px 16px; color: #9ca3af; }
    .ve-props-empty i { font-size: 32px; display: block; margin-bottom: 12px; }
    .ve-props-header {
        display: flex; align-items: center; gap: 8px; margin-bottom: 16px;
        padding-bottom: 12px; border-bottom: 1px solid #e5e7eb;
    }
    .ve-props-header i { color: #0038A8; font-size: 16px; }
    .ve-props-header span { font-size: 14px; font-weight: 700; color: #1f2937; }

    .ve-field { margin-bottom: 14px; }
    .ve-field label {
        display: block; font-size: 11px; font-weight: 600; color: #6b7280;
        margin-bottom: 5px; text-transform: uppercase; letter-spacing: 0.3px;
    }
    .ve-field input, .ve-field textarea, .ve-field select {
        width: 100%; padding: 7px 10px; border: 1px solid #d1d5db; border-radius: 6px;
        font-size: 13px; font-family: 'Inter', sans-serif; transition: border-color 0.2s;
    }
    .ve-field input:focus, .ve-field textarea:focus { outline: none; border-color: #0038A8; box-shadow: 0 0 0 3px rgba(0,56,168,0.1); }
    .ve-field textarea { min-height: 60px; resize: vertical; }
    .ve-field .ve-field-row { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }

    /* Image upload */
    .ve-img-upload {
        border: 2px dashed #d1d5db; border-radius: 8px; padding: 12px; text-align: center;
        cursor: pointer; transition: all 0.2s; position: relative; overflow: hidden;
    }
    .ve-img-upload:hover { border-color: #0038A8; background: #eff6ff; }
    .ve-img-upload.has-image { border-style: solid; padding: 4px; }
    .ve-img-upload img { max-width: 100%; max-height: 120px; border-radius: 6px; display: block; margin: 0 auto; }
    .ve-img-upload .ve-img-placeholder { color: #9ca3af; font-size: 12px; }
    .ve-img-upload .ve-img-placeholder i { font-size: 24px; display: block; margin-bottom: 4px; }
    .ve-img-upload input[type="file"] { position: absolute; inset: 0; opacity: 0; cursor: pointer; }
    .ve-img-upload .ve-img-remove {
        position: absolute; top: 6px; right: 6px; background: #ef4444; color: white;
        width: 22px; height: 22px; border-radius: 50%; display: flex; align-items: center;
        justify-content: center; font-size: 11px; cursor: pointer; border: none; z-index: 5;
    }
    .ve-img-uploading { position: absolute; inset: 0; background: rgba(255,255,255,0.8); display: flex; align-items: center; justify-content: center; }
    .ve-img-uploading i { animation: spin 1s linear infinite; font-size: 20px; color: #0038A8; }

    .ve-items-list { display: flex; flex-direction: column; gap: 8px; }
    .ve-item-card { background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 6px; padding: 10px; position: relative; }
    .ve-item-card .ve-item-head { display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px; }
    .ve-item-card .ve-item-head span { font-size: 11px; font-weight: 700; color: #6b7280; text-transform: uppercase; }
    .ve-item-card .ve-item-remove {
        background: none; border: none; color: #ef4444; cursor: pointer;
        font-size: 13px; padding: 2px 4px; border-radius: 4px;
    }
    .ve-item-card .ve-item-remove:hover { background: #fef2f2; }
    .ve-btn-add-item {
        background: none; border: 1px dashed #d1d5db; color: #6b7280;
        width: 100%; padding: 8px; border-radius: 6px; cursor: pointer;
        font-size: 11px; font-weight: 600; transition: all 0.2s;
    }
    .ve-btn-add-item:hover { border-color: #0038A8; color: #0038A8; background: #eff6ff; }

    .ve-settings-section { margin-bottom: 20px; padding-bottom: 16px; border-bottom: 1px solid #f3f4f6; }
    .ve-settings-section:last-child { border-bottom: none; }
    .ve-settings-section h5 { font-size: 12px; font-weight: 700; color: #374151; margin-bottom: 12px; text-transform: uppercase; letter-spacing: 0.3px; }
    .ve-toggle { display: flex; align-items: center; gap: 10px; }
    .ve-toggle input[type="checkbox"] {
        width: 36px; height: 20px; appearance: none; background: #d1d5db; border-radius: 10px;
        position: relative; cursor: pointer; transition: background 0.2s; flex-shrink: 0;
    }
    .ve-toggle input[type="checkbox"]:checked { background: #0038A8; }
    .ve-toggle input[type="checkbox"]::after {
        content: ''; position: absolute; width: 16px; height: 16px; border-radius: 50%;
        background: white; top: 2px; left: 2px; transition: transform 0.2s;
    }
    .ve-toggle input[type="checkbox"]:checked::after { transform: translateX(16px); }
    .ve-toggle label { font-size: 13px; font-weight: 500; color: #374151; cursor: pointer; }

    /* ===== PREVIEW RENDERINGS ===== */
    .vp-hero {
        position: relative; min-height: 280px;
        background: linear-gradient(135deg, rgba(0,56,168,0.85) 0%, rgba(0,38,117,0.9) 100%),
                    url('/images/city.jpg') center/cover no-repeat;
        display: flex; align-items: center; justify-content: center;
        color: white; text-align: center; padding: 40px 24px;
    }
    .vp-hero .vp-badge {
        display: inline-block; background: #FDB913; color: #1f2937;
        font-size: 10px; font-weight: 700; padding: 4px 12px; border-radius: 50px; margin-bottom: 12px; text-transform: uppercase;
    }
    .vp-hero h2 { font-size: 24px; font-weight: 800; margin-bottom: 10px; color: white; line-height: 1.2; }
    .vp-hero p { font-size: 13px; opacity: 0.9; max-width: 500px; margin: 0 auto 16px; line-height: 1.5; }
    .vp-hero .vp-hero-btns { display: flex; gap: 8px; justify-content: center; flex-wrap: wrap; }
    .vp-hero .vp-hero-btns a { padding: 6px 16px; border-radius: 50px; font-size: 12px; font-weight: 600; text-decoration: none; }
    .vp-hero .vp-btn-primary { background: #0038A8; color: white; border: 2px solid #0038A8; }
    .vp-hero .vp-btn-outline { background: transparent; color: white; border: 2px solid white; }

    .vp-page-header { background: linear-gradient(135deg, #0038A8, #002B88); color: white; text-align: center; padding: 50px 24px 35px; }
    .vp-page-header h2 { font-size: 24px; font-weight: 800; margin-bottom: 6px; color: white; }
    .vp-page-header p { font-size: 13px; opacity: 0.85; margin: 0; }

    .vp-text-block { padding: 28px 24px; }
    .vp-text-block h3 { font-size: 18px; font-weight: 700; color: #1f2937; margin-bottom: 10px; }
    .vp-text-block p { font-size: 13px; color: #4b5563; line-height: 1.7; margin: 0; white-space: pre-wrap; }

    .vp-image-text { padding: 28px 24px; display: flex; gap: 20px; align-items: center; flex-wrap: wrap; }
    .vp-image-text .vp-it-img {
        width: 200px; height: 140px; border-radius: 10px; flex-shrink: 0;
        background: linear-gradient(135deg, #dbeafe, #e0e7ff);
        display: flex; align-items: center; justify-content: center; overflow: hidden;
    }
    .vp-image-text .vp-it-img img { width: 100%; height: 100%; object-fit: cover; border-radius: 10px; }
    .vp-image-text .vp-it-img i { font-size: 32px; color: #6366f1; }
    .vp-image-text .vp-it-text { flex: 1; min-width: 200px; }
    .vp-image-text .vp-section-label { color: #0038A8; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; font-size: 11px; margin-bottom: 4px; }
    .vp-image-text h3 { font-size: 18px; font-weight: 800; color: #1f2937; margin-bottom: 8px; }
    .vp-image-text p { font-size: 12px; color: #4b5563; line-height: 1.6; margin: 0; white-space: pre-wrap; }

    .vp-services-grid { padding: 28px 24px; background: #f9fafb; }
    .vp-services-grid .vp-section-label { color: #0038A8; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; font-size: 11px; margin-bottom: 4px; }
    .vp-services-grid h3 { font-size: 20px; font-weight: 800; color: #1f2937; margin-bottom: 4px; }
    .vp-services-grid > p { font-size: 13px; color: #6b7280; margin-bottom: 16px; }
    .vp-services-items { display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 12px; }
    .vp-service-card { background: white; border-radius: 10px; padding: 14px; border: 1px solid #e5e7eb; }
    .vp-service-card .vp-svc-icon {
        width: 36px; height: 36px; background: #eff6ff; border-radius: 8px;
        display: flex; align-items: center; justify-content: center; color: #0038A8; font-size: 16px; margin-bottom: 8px;
    }
    .vp-service-card h5 { font-size: 13px; font-weight: 700; margin-bottom: 3px; color: #1f2937; }
    .vp-service-card p { font-size: 11px; color: #6b7280; margin: 0; line-height: 1.4; }

    .vp-news-list { padding: 28px 24px; }
    .vp-news-list h3 { font-size: 20px; font-weight: 800; color: #1f2937; margin-bottom: 16px; }
    .vp-news-items { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 12px; }
    .vp-news-card { background: white; border-radius: 10px; border: 1px solid #e5e7eb; overflow: hidden; }
    .vp-news-card .vp-news-img {
        height: 100px; background: linear-gradient(135deg, #e0e7ff, #dbeafe);
        display: flex; align-items: center; justify-content: center; color: #6366f1; font-size: 20px; position: relative; overflow: hidden;
    }
    .vp-news-card .vp-news-img img { width: 100%; height: 100%; object-fit: cover; }
    .vp-news-card .vp-news-img .vp-featured-badge {
        position: absolute; top: 6px; left: 6px; background: #ef4444; color: white;
        font-size: 8px; font-weight: 700; padding: 2px 6px; border-radius: 3px; text-transform: uppercase;
    }
    .vp-news-card .vp-news-body { padding: 10px; }
    .vp-news-card .vp-news-date { font-size: 10px; color: #0038A8; font-weight: 600; margin-bottom: 2px; display: block; }
    .vp-news-card .vp-news-title { font-size: 13px; font-weight: 700; margin-bottom: 4px; color: #1f2937; }
    .vp-news-card .vp-news-excerpt { font-size: 11px; color: #6b7280; margin: 0; line-height: 1.4; }

    .vp-about-preview { padding: 28px 24px; display: flex; gap: 20px; align-items: center; flex-wrap: wrap; }
    .vp-about-preview .vp-about-img {
        width: 200px; height: 140px; border-radius: 12px;
        background: linear-gradient(135deg, #dbeafe, #e0e7ff);
        display: flex; align-items: center; justify-content: center; color: #6366f1; font-size: 28px; flex-shrink: 0; overflow: hidden;
    }
    .vp-about-preview .vp-about-img img { width: 100%; height: 100%; object-fit: cover; }
    .vp-about-preview .vp-about-text { flex: 1; min-width: 200px; }
    .vp-about-preview .vp-section-label { color: #0038A8; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; font-size: 11px; margin-bottom: 4px; }
    .vp-about-preview h3 { font-size: 18px; font-weight: 800; color: #1f2937; margin-bottom: 8px; }
    .vp-about-preview p { font-size: 12px; color: #4b5563; line-height: 1.5; margin-bottom: 10px; }
    .vp-about-meta { display: flex; gap: 10px; flex-wrap: wrap; }
    .vp-about-meta-item { background: #f3f4f6; border-radius: 6px; padding: 6px 10px; display: flex; align-items: center; gap: 6px; font-size: 11px; }
    .vp-about-meta-item i { width: 24px; height: 24px; background: #0038A8; color: white; border-radius: 5px; display: flex; align-items: center; justify-content: center; font-size: 11px; }

    .vp-mission-vision { padding: 28px 24px; background: #0038A8; display: flex; gap: 16px; flex-wrap: wrap; }
    .vp-mv-card {
        flex: 1; min-width: 200px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);
        border-radius: 10px; padding: 16px; text-align: center; color: white;
    }
    .vp-mv-card .vp-mv-icon { font-size: 28px; color: #FDB913; margin-bottom: 8px; }
    .vp-mv-card h4 { font-size: 16px; font-weight: 700; margin-bottom: 8px; color: white; }
    .vp-mv-card p { font-size: 12px; opacity: 0.8; line-height: 1.5; margin: 0; }

    .vp-council-grid { padding: 28px 24px; }
    .vp-council-grid .vp-section-label { color: #0038A8; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; font-size: 11px; margin-bottom: 4px; text-align: center; }
    .vp-council-grid h3 { font-size: 20px; font-weight: 800; color: #1f2937; margin-bottom: 4px; text-align: center; }
    .vp-council-grid > p { font-size: 13px; color: #6b7280; margin-bottom: 16px; text-align: center; }
    .vp-captain { text-align: center; margin-bottom: 16px; }
    .vp-captain .vp-avatar {
        width: 100px; height: 100px; border-radius: 50%; background: #e5e7eb; margin: 0 auto 8px;
        display: flex; align-items: center; justify-content: center; overflow: hidden; border: 3px solid #0038A8;
    }
    .vp-captain .vp-avatar img { width: 100%; height: 100%; object-fit: cover; }
    .vp-captain .vp-avatar i { font-size: 32px; color: #9ca3af; }
    .vp-captain h5 { font-size: 14px; font-weight: 700; color: #0038A8; margin-bottom: 2px; }
    .vp-captain p { font-size: 11px; color: #6b7280; margin: 0; }
    .vp-members-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(100px, 1fr)); gap: 10px; }
    .vp-member { text-align: center; }
    .vp-member .vp-avatar {
        width: 60px; height: 60px; border-radius: 50%; background: #f3f4f6; margin: 0 auto 6px;
        display: flex; align-items: center; justify-content: center; overflow: hidden;
    }
    .vp-member .vp-avatar img { width: 100%; height: 100%; object-fit: cover; }
    .vp-member .vp-avatar i { font-size: 20px; color: #9ca3af; }
    .vp-member h6 { font-size: 11px; font-weight: 700; color: #1f2937; margin-bottom: 1px; }
    .vp-member p { font-size: 10px; color: #6b7280; margin: 0; }

    .vp-contact-info { padding: 28px 24px; background: #f9fafb; }
    .vp-contact-info h3 { font-size: 18px; font-weight: 800; color: #1f2937; margin-bottom: 14px; }
    .vp-contact-items { display: flex; flex-direction: column; gap: 8px; }
    .vp-contact-row { display: flex; align-items: center; gap: 10px; font-size: 12px; color: #374151; }
    .vp-contact-row i { width: 28px; height: 28px; background: #0038A8; color: white; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 12px; flex-shrink: 0; }

    .ve-toast {
        position: fixed; bottom: 24px; left: 50%; transform: translateX(-50%);
        background: #065f46; color: white; padding: 10px 24px; border-radius: 8px;
        font-size: 13px; font-weight: 600; z-index: 9999; box-shadow: 0 8px 24px rgba(0,0,0,0.2);
        display: none; align-items: center; gap: 8px;
    }
    .ve-toast.show { display: flex; }
    .ve-toast.error { background: #991b1b; }
    @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
</style>
@endsection

@section('content')

@php
    $sectionsJson = json_encode($sitePage->sections ?? [], JSON_HEX_APOS | JSON_HEX_QUOT);
    $sectionTypesJson = json_encode($sectionTypes, JSON_HEX_APOS | JSON_HEX_QUOT);
    $hasSuccess = session('success');
@endphp

<div class="ve-toolbar">
    <div class="ve-toolbar-left">
        <a href="{{ route('site-editor.index') }}" class="back-link" title="Back"><i class="bi bi-arrow-left"></i></a>
        <div>
            <span class="page-name">{{ $sitePage->title }}</span>
            <span class="page-slug-label">/{{ $sitePage->slug === 'home' ? '' : $sitePage->slug }}</span>
        </div>
        <span class="ve-unsaved-dot" id="unsavedDot" title="Unsaved changes"></span>
    </div>
    <div class="ve-toolbar-right">
        <a href="{{ url($sitePage->slug === 'home' ? '/' : '/' . $sitePage->slug) }}" target="_blank" class="btn ve-btn-outline">
            <i class="bi bi-box-arrow-up-right me-1"></i> View Live
        </a>
        <button type="button" class="btn ve-btn-save" id="btnSave" onclick="savePage()">
            <i class="bi bi-check-lg me-1"></i> Save
        </button>
    </div>
</div>

<div class="ve-workspace">
    <div class="ve-canvas" id="veCanvas">
        <div class="ve-canvas-inner" id="canvasInner"></div>
    </div>
    <div class="ve-panel">
        <div class="ve-panel-tabs">
            <button class="ve-panel-tab active" data-tab="properties" onclick="switchTab('properties')"><i class="bi bi-sliders me-1"></i> Properties</button>
            <button class="ve-panel-tab" data-tab="components" onclick="switchTab('components')"><i class="bi bi-plus-square me-1"></i> Components</button>
            <button class="ve-panel-tab" data-tab="settings" onclick="switchTab('settings')"><i class="bi bi-gear me-1"></i> Settings</button>
        </div>
        <div class="ve-panel-body" id="tabProperties">
            <div class="ve-props-empty" id="propsEmpty">
                <i class="bi bi-cursor"></i>
                <p style="font-size: 13px; margin: 0;">Click a section in the preview to edit its properties</p>
            </div>
            <div id="propsContent" style="display: none;"></div>
        </div>
        <div class="ve-panel-body" id="tabComponents" style="display: none;">
            <p style="font-size: 12px; color: #6b7280; margin-bottom: 14px;">Click a component to add it to the page.</p>
            <div class="ve-components-grid" id="componentsGrid"></div>
        </div>
        <div class="ve-panel-body" id="tabSettings" style="display: none;">
            <div class="ve-settings-section">
                <h5><i class="bi bi-file-earmark me-1"></i> Page Details</h5>
                <div class="ve-field">
                    <label>Page Title</label>
                    <input type="text" id="settingTitle" value="{{ $sitePage->title }}" onchange="markDirty()">
                </div>
                <div class="ve-field">
                    <label>URL</label>
                    <input type="text" value="/{{ $sitePage->slug === 'home' ? '' : $sitePage->slug }}" disabled style="background: #f3f4f6; color: #9ca3af;">
                </div>
            </div>
            <div class="ve-settings-section">
                <h5><i class="bi bi-eye me-1"></i> Visibility</h5>
                <div class="ve-toggle">
                    <input type="checkbox" id="settingPublished" {{ $sitePage->is_published ? 'checked' : '' }} onchange="markDirty()">
                    <label for="settingPublished">Published</label>
                </div>
            </div>
            <div class="ve-settings-section">
                <h5><i class="bi bi-info-circle me-1"></i> Info</h5>
                <div style="font-size: 12px; color: #6b7280; line-height: 2;">
                    <div><strong>Created:</strong> {{ $sitePage->created_at->format('M d, Y') }}</div>
                    <div><strong>Updated:</strong> {{ $sitePage->updated_at->diffForHumans() }}</div>
                    @if($sitePage->editor)
                    <div><strong>By:</strong> {{ $sitePage->editor->name ?? 'Admin' }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="ve-toast" id="veToast"></div>

<form id="saveForm" method="POST" action="{{ route('site-editor.update', $sitePage) }}" style="display: none;">
    @csrf
    @method('PUT')
    <input type="hidden" name="title" id="formTitle">
    <input type="hidden" name="sections" id="formSections">
    <input type="hidden" name="is_published" id="formPublished">
</form>

@endsection

@section('extra-scripts')
<script>
(function() {
    const UPLOAD_URL = "{{ route('site-editor.upload-image') }}";
    const CSRF = "{{ csrf_token() }}";
    let sections = {!! $sectionsJson !!};
    const sectionTypes = {!! $sectionTypesJson !!};
    let selectedIndex = -1;
    let isDirty = false;

    const canvas = document.getElementById('canvasInner');
    const propsContent = document.getElementById('propsContent');
    const propsEmpty = document.getElementById('propsEmpty');

    // Show success toast after save redirect
    @if($hasSuccess)
    setTimeout(() => showToast('{{ $hasSuccess }}'), 300);
    @endif

    renderComponentsGrid();
    renderCanvas();

    // ========== CANVAS ==========
    function renderCanvas() {
        canvas.innerHTML = '';
        if (sections.length === 0) {
            canvas.innerHTML = `<div class="ve-drop-zone" onclick="switchTab('components')"><i class="bi bi-plus-circle" style="font-size:28px;display:block;margin-bottom:8px"></i>This page is empty. Add sections from the Components panel.</div>`;
            return;
        }
        sections.forEach((section, idx) => {
            const w = document.createElement('div');
            w.className = 've-section' + (idx === selectedIndex ? ' ve-selected' : '');
            w.dataset.index = idx;
            w.onclick = (e) => { if (!e.target.closest('.ve-section-actions')) selectSection(idx); };
            const info = sectionTypes[section.type] || {label: section.type, icon: 'bi-puzzle'};
            w.innerHTML = `<div class="ve-section-tag"><i class="bi ${info.icon} me-1"></i>${info.label}</div>
                <div class="ve-section-actions">
                    <button class="ve-act-move" title="Move up" onclick="event.stopPropagation();moveSection(${idx},-1)" ${idx===0?'disabled':''}><i class="bi bi-arrow-up"></i></button>
                    <button class="ve-act-move" title="Move down" onclick="event.stopPropagation();moveSection(${idx},1)" ${idx===sections.length-1?'disabled':''}><i class="bi bi-arrow-down"></i></button>
                    <button class="ve-act-delete" title="Delete" onclick="event.stopPropagation();deleteSection(${idx})"><i class="bi bi-trash"></i></button>
                </div>
                <div>${renderPreview(section)}</div>`;
            canvas.appendChild(w);
        });
        const az = document.createElement('div');
        az.className = 've-drop-zone';
        az.onclick = () => switchTab('components');
        az.innerHTML = '<i class="bi bi-plus me-1"></i> Add Section';
        canvas.appendChild(az);
    }

    // ========== PREVIEW RENDER ==========
    function renderPreview(s) {
        const d = s.data || {};
        switch (s.type) {
            case 'hero':
                return `<div class="vp-hero"><div>
                    ${d.badge?`<div class="vp-badge">${esc(d.badge)}</div>`:''}
                    <h2>${esc(d.heading||'Hero Heading')}</h2>
                    <p>${esc(d.subheading||'')}</p>
                    <div class="vp-hero-btns">
                        ${d.button_text?`<a class="vp-btn-primary">${esc(d.button_text)}</a>`:''}
                        ${d.button2_text?`<a class="vp-btn-outline">${esc(d.button2_text)}</a>`:''}
                    </div></div></div>`;
            case 'page_header':
                return `<div class="vp-page-header"><h2>${esc(d.heading||'Page Title')}</h2><p>${esc(d.subheading||'')}</p></div>`;
            case 'text_block':
                return `<div class="vp-text-block"><h3>${esc(d.heading||'Text Block')}</h3><p>${esc(d.content||'')}</p></div>`;
            case 'image_text':
                const imgPos = d.image_position || 'left';
                return `<div class="vp-image-text" style="${imgPos==='right'?'flex-direction:row-reverse':''}">
                    <div class="vp-it-img">${d.image?`<img src="${imgSrc(d.image)}">`:'<i class="bi bi-image"></i>'}</div>
                    <div class="vp-it-text">
                        ${d.label?`<div class="vp-section-label">${esc(d.label)}</div>`:''}
                        <h3>${esc(d.heading||'')}</h3><p>${esc(d.content||'')}</p>
                    </div></div>`;
            case 'services_grid': case 'services_list':
                return `<div class="vp-services-grid">
                    ${d.label?`<div class="vp-section-label">${esc(d.label)}</div>`:''}
                    <h3>${esc(d.heading||'Services')}</h3><p>${esc(d.subheading||'')}</p>
                    <div class="vp-services-items">${(d.items||[]).map(it=>`<div class="vp-service-card">
                        <div class="vp-svc-icon"><i class="bi ${esc(it.icon||'bi-star')}"></i></div>
                        <h5>${esc(it.title||'')}</h5><p>${esc(it.description||'')}</p></div>`).join('')}</div></div>`;
            case 'news_list':
                return `<div class="vp-news-list"><h3>News & Updates</h3>
                    <div class="vp-news-items">${(d.items||[]).map(it=>`<div class="vp-news-card">
                        <div class="vp-news-img">${it.image?`<img src="${imgSrc(it.image)}">`:'<i class="bi bi-newspaper"></i>'}
                            ${it.featured?'<span class="vp-featured-badge">Featured</span>':''}</div>
                        <div class="vp-news-body"><span class="vp-news-date">${esc(it.date||'')}</span>
                        <div class="vp-news-title">${esc(it.title||'')}</div>
                        <p class="vp-news-excerpt">${esc(it.excerpt||'')}</p></div></div>`).join('')}</div></div>`;
            case 'about_preview':
                return `<div class="vp-about-preview">
                    <div class="vp-about-img">${d.image?`<img src="${imgSrc(d.image)}">`:'<i class="bi bi-image"></i>'}</div>
                    <div class="vp-about-text">
                        ${d.label?`<div class="vp-section-label">${esc(d.label)}</div>`:''}
                        <h3>${esc(d.heading||'About')}</h3><p>${esc(d.description||'')}</p>
                        <div class="vp-about-meta">
                            ${d.location?`<div class="vp-about-meta-item"><i class="bi bi-geo-alt"></i><div><small style="color:#6b7280">Location</small><br><strong>${esc(d.location)}</strong></div></div>`:''}
                            ${d.land_area?`<div class="vp-about-meta-item"><i class="bi bi-map"></i><div><small style="color:#6b7280">Land Area</small><br><strong>${esc(d.land_area)}</strong></div></div>`:''}
                        </div></div></div>`;
            case 'mission_vision':
                return `<div class="vp-mission-vision">
                    <div class="vp-mv-card"><div class="vp-mv-icon"><i class="bi bi-flag"></i></div><h4>Mission</h4><p>${esc(d.mission||'')}</p></div>
                    <div class="vp-mv-card"><div class="vp-mv-icon"><i class="bi bi-eye"></i></div><h4>Vision</h4><p>${esc(d.vision||'')}</p></div></div>`;
            case 'council_grid':
                const cap = d.captain || {};
                return `<div class="vp-council-grid">
                    ${d.label?`<div class="vp-section-label">${esc(d.label)}</div>`:''}
                    <h3>${esc(d.heading||'Council')}</h3><p>${esc(d.subheading||'')}</p>
                    <div class="vp-captain"><div class="vp-avatar">${cap.image?`<img src="${imgSrc(cap.image)}">`:'<i class="bi bi-person"></i>'}</div>
                    <h5>${esc(cap.name||'Captain')}</h5><p>${esc(cap.title||'')}</p></div>
                    <div class="vp-members-grid">${(d.members||[]).map(m=>`<div class="vp-member">
                        <div class="vp-avatar">${m.image?`<img src="${imgSrc(m.image)}">`:'<i class="bi bi-person"></i>'}</div>
                        <h6>${esc(m.name||'')}</h6><p>${esc(m.title||'')}</p></div>`).join('')}</div></div>`;
            case 'contact_info':
                return `<div class="vp-contact-info"><h3>Contact Information</h3><div class="vp-contact-items">
                    ${d.address?`<div class="vp-contact-row"><i class="bi bi-geo-alt-fill"></i><span>${esc(d.address)}</span></div>`:''}
                    ${d.phone?`<div class="vp-contact-row"><i class="bi bi-telephone-fill"></i><span>${esc(d.phone)}</span></div>`:''}
                    ${d.email?`<div class="vp-contact-row"><i class="bi bi-envelope-fill"></i><span>${esc(d.email)}</span></div>`:''}
                    ${d.office_hours?`<div class="vp-contact-row"><i class="bi bi-clock-fill"></i><span>${esc(d.office_hours)}</span></div>`:''}
                    ${d.facebook?`<div class="vp-contact-row"><i class="bi bi-facebook"></i><span>${esc(d.facebook)}</span></div>`:''}</div></div>`;
            default:
                return `<div style="padding:24px;color:#9ca3af;text-align:center"><i class="bi bi-puzzle" style="font-size:24px"></i><div style="font-size:13px;margin-top:8px">Unknown: ${esc(s.type)}</div></div>`;
        }
    }

    // ========== SELECT ==========
    function selectSection(idx) {
        selectedIndex = idx;
        document.querySelectorAll('.ve-section').forEach((el,i) => el.classList.toggle('ve-selected', i===idx));
        switchTab('properties');
        renderProperties();
    }
    window.selectSection = selectSection;

    // ========== PROPERTIES ==========
    function renderProperties() {
        if (selectedIndex < 0 || selectedIndex >= sections.length) {
            propsContent.style.display = 'none'; propsEmpty.style.display = 'block'; return;
        }
        propsEmpty.style.display = 'none'; propsContent.style.display = 'block';
        const s = sections[selectedIndex], d = s.data || {};
        const info = sectionTypes[s.type] || {label:s.type, icon:'bi-puzzle'};
        let h = `<div class="ve-props-header"><i class="bi ${info.icon}"></i><span>${info.label}</span></div>`;
        h += renderFields(s.type, d, selectedIndex);
        propsContent.innerHTML = h;
    }

    function renderFields(type, d, idx) {
        switch (type) {
            case 'hero':
                return field('Badge Text','badge',d.badge,idx)+field('Heading','heading',d.heading,idx)+
                    textarea('Subheading','subheading',d.subheading,idx)+
                    `<div class="ve-field"><div class="ve-field-row">${halfField('Btn 1 Text','button_text',d.button_text,idx)}${halfField('Btn 1 Link','button_link',d.button_link,idx)}</div></div>`+
                    `<div class="ve-field"><div class="ve-field-row">${halfField('Btn 2 Text','button2_text',d.button2_text,idx)}${halfField('Btn 2 Link','button2_link',d.button2_link,idx)}</div></div>`;
            case 'page_header':
                return field('Heading','heading',d.heading,idx)+field('Subheading','subheading',d.subheading,idx);
            case 'text_block':
                return field('Heading','heading',d.heading,idx)+textarea('Content','content',d.content,idx,6);
            case 'image_text':
                return field('Section Label','label',d.label,idx)+field('Heading','heading',d.heading,idx)+
                    textarea('Content','content',d.content,idx,5)+
                    imageField('Image','image',d.image,idx)+
                    selectField('Image Position','image_position',d.image_position,idx,[{v:'left',l:'Left'},{v:'right',l:'Right'}]);
            case 'services_grid': case 'services_list':
                return field('Section Label','label',d.label,idx)+field('Heading','heading',d.heading,idx)+
                    field('Subheading','subheading',d.subheading,idx)+itemsEditor(d.items||[],idx,'service');
            case 'news_list':
                return itemsEditor(d.items||[],idx,'news');
            case 'about_preview':
                return field('Section Label','label',d.label,idx)+field('Heading','heading',d.heading,idx)+
                    textarea('Description','description',d.description,idx,4)+
                    imageField('Image','image',d.image,idx)+
                    `<div class="ve-field"><div class="ve-field-row">${halfField('Location','location',d.location,idx)}${halfField('Land Area','land_area',d.land_area,idx)}</div></div>`;
            case 'mission_vision':
                return textarea('Mission','mission',d.mission,idx,5)+textarea('Vision','vision',d.vision,idx,5);
            case 'council_grid':
                return field('Section Label','label',d.label,idx)+field('Heading','heading',d.heading,idx)+
                    field('Subheading','subheading',d.subheading,idx)+
                    captainEditor(d.captain||{},idx)+
                    membersEditor(d.members||[],idx);
            case 'contact_info':
                return field('Address','address',d.address,idx)+
                    `<div class="ve-field"><div class="ve-field-row">${halfField('Phone','phone',d.phone,idx)}${halfField('Email','email',d.email,idx)}</div></div>`+
                    field('Office Hours','office_hours',d.office_hours,idx)+field('Facebook URL','facebook',d.facebook,idx);
            default:
                return Object.entries(d).map(([k,v])=>typeof v==='string'?field(k.replace(/_/g,' '),k,v,idx):textarea(k.replace(/_/g,' '),k,JSON.stringify(v),idx,3)).join('');
        }
    }

    // ========== FIELD HELPERS ==========
    function field(label,key,value,idx) {
        return `<div class="ve-field"><label>${esc(label)}</label><input type="text" value="${escAttr(value||'')}" oninput="liveUpdate(${idx},'${key}',this.value)"></div>`;
    }
    function halfField(label,key,value,idx) {
        return `<div><label style="display:block;font-size:11px;font-weight:600;color:#6b7280;margin-bottom:5px;text-transform:uppercase;letter-spacing:.3px">${esc(label)}</label><input type="text" value="${escAttr(value||'')}" style="width:100%;padding:7px 10px;border:1px solid #d1d5db;border-radius:6px;font-size:13px" oninput="liveUpdate(${idx},'${key}',this.value)"></div>`;
    }
    function textarea(label,key,value,idx,rows) {
        return `<div class="ve-field"><label>${esc(label)}</label><textarea rows="${rows||3}" oninput="liveUpdate(${idx},'${key}',this.value)">${esc(value||'')}</textarea></div>`;
    }
    function selectField(label,key,value,idx,opts) {
        return `<div class="ve-field"><label>${esc(label)}</label><select onchange="liveUpdate(${idx},'${key}',this.value)">${opts.map(o=>`<option value="${o.v}" ${value===o.v?'selected':''}>${o.l}</option>`).join('')}</select></div>`;
    }
    function imageField(label,key,value,idx,pathPrefix) {
        const pp = pathPrefix || '';
        const id = `img_${idx}_${key}`;
        const hasImg = !!(value);
        return `<div class="ve-field"><label>${esc(label)}</label>
            <div class="ve-img-upload ${hasImg?'has-image':''}" id="${id}">
                ${hasImg?`<img src="${imgSrc(value)}"><button class="ve-img-remove" onclick="event.stopPropagation();clearImage(${idx},'${key}','${pp}','${id}')" title="Remove"><i class="bi bi-x"></i></button>`
                :`<div class="ve-img-placeholder"><i class="bi bi-cloud-arrow-up"></i><div>Click to upload</div></div>`}
                <input type="file" accept="image/*" onchange="uploadImage(this,${idx},'${key}','${pp}','${id}')">
            </div></div>`;
    }

    // ========== IMAGE UPLOAD ==========
    window.uploadImage = function(input, sIdx, key, pathPrefix, wrapperId) {
        const file = input.files[0];
        if (!file) return;
        if (file.size > 10*1024*1024) { showToast('Image must be less than 10MB', true); return; }

        const wrapper = document.getElementById(wrapperId);
        wrapper.innerHTML += '<div class="ve-img-uploading"><i class="bi bi-arrow-repeat"></i></div>';

        const fd = new FormData();
        fd.append('image', file);
        fetch(UPLOAD_URL, { method: 'POST', headers: {'X-CSRF-TOKEN': CSRF}, body: fd })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    if (pathPrefix) {
                        // For nested paths like captain.image or members.0.image
                        setNestedValue(sIdx, pathPrefix + key, data.url);
                    } else {
                        sections[sIdx].data[key] = data.url;
                    }
                    markDirty();
                    renderCanvas();
                    renderProperties();
                    showToast('Image uploaded!');
                } else {
                    showToast('Upload failed', true);
                }
            })
            .catch(() => showToast('Upload failed', true));
    };

    window.clearImage = function(sIdx, key, pathPrefix, wrapperId) {
        if (pathPrefix) {
            setNestedValue(sIdx, pathPrefix + key, '');
        } else {
            sections[sIdx].data[key] = '';
        }
        markDirty();
        renderCanvas();
        renderProperties();
    };

    function setNestedValue(sIdx, path, value) {
        const parts = path.split('.');
        let obj = sections[sIdx].data;
        for (let i = 0; i < parts.length - 1; i++) {
            obj = obj[parts[i]];
        }
        obj[parts[parts.length - 1]] = value;
    }

    // ========== ITEMS EDITOR (Services/News) ==========
    function itemsEditor(items, sIdx, itemType) {
        const label = itemType === 'service' ? 'Service' : 'News';
        let h = `<div class="ve-field"><label>${label} Items</label><div class="ve-items-list">`;
        items.forEach((item, i) => {
            h += `<div class="ve-item-card"><div class="ve-item-head"><span>${label} #${i+1}</span>
                <button class="ve-item-remove" onclick="removeItem(${sIdx},${i})" title="Remove"><i class="bi bi-x-lg"></i></button></div>`;
            if (itemType === 'service') {
                h += itemField('Icon','icon',item.icon,sIdx,i)+itemField('Title','title',item.title,sIdx,i)+itemField('Description','description',item.description,sIdx,i);
            } else {
                const nimgId = `img_news_${sIdx}_${i}`;
                const nhasImg = !!(item.image);
                h += itemField('Date','date',item.date,sIdx,i)+itemField('Title','title',item.title,sIdx,i)+
                    itemTextarea('Excerpt','excerpt',item.excerpt,sIdx,i)+
                    `<div class="ve-field" style="margin-bottom:8px"><label style="display:block;font-size:11px;font-weight:600;color:#6b7280;margin-bottom:5px;text-transform:uppercase;letter-spacing:.3px">Image</label>
                    <div class="ve-img-upload ${nhasImg?'has-image':''}" id="${nimgId}">
                        ${nhasImg
                            ?`<img src="${imgSrc(item.image)}"><button class="ve-img-remove" onclick="event.stopPropagation();clearImage(${sIdx},'image','items.${i}.','${nimgId}')" title="Remove"><i class="bi bi-x"></i></button>`
                            :`<div class="ve-img-placeholder"><i class="bi bi-cloud-arrow-up"></i><div>Click to upload</div></div>`}
                        <input type="file" accept="image/*" onchange="uploadImage(this,${sIdx},'image','items.${i}.','${nimgId}')">
                    </div></div>`+
                    `<div class="ve-field" style="margin-bottom:0"><label style="display:flex;align-items:center;gap:6px;text-transform:none;letter-spacing:0;cursor:pointer">
                    <input type="checkbox" style="width:auto" ${item.featured?'checked':''} onchange="updateItemField(${sIdx},${i},'featured',this.checked)"> Featured</label></div>`;
            }
            h += '</div>';
        });
        h += `<button class="ve-btn-add-item" onclick="addItem(${sIdx},'${itemType}')"><i class="bi bi-plus me-1"></i> Add ${label}</button></div></div>`;
        return h;
    }

    function itemField(label,key,value,sIdx,iIdx) {
        return `<div class="ve-field" style="margin-bottom:8px"><label>${esc(label)}</label><input type="text" value="${escAttr(value||'')}" oninput="liveUpdateItem(${sIdx},${iIdx},'${key}',this.value)"></div>`;
    }
    function itemTextarea(label,key,value,sIdx,iIdx) {
        return `<div class="ve-field" style="margin-bottom:8px"><label>${esc(label)}</label><textarea rows="2" oninput="liveUpdateItem(${sIdx},${iIdx},'${key}',this.value)">${esc(value||'')}</textarea></div>`;
    }

    // ========== CAPTAIN EDITOR ==========
    function captainEditor(cap, sIdx) {
        const id = `img_captain_${sIdx}`;
        const hasImg = !!(cap.image);
        return `<div class="ve-field"><label>Barangay Captain</label>
            <div class="ve-item-card">
                <div class="ve-field" style="margin-bottom:8px"><label>Name</label>
                    <input type="text" value="${escAttr(cap.name||'')}" oninput="updateCaptain(${sIdx},'name',this.value)"></div>
                <div class="ve-field" style="margin-bottom:8px"><label>Title</label>
                    <input type="text" value="${escAttr(cap.title||'')}" oninput="updateCaptain(${sIdx},'title',this.value)"></div>
                <div class="ve-field" style="margin-bottom:0"><label>Photo</label>
                    <div class="ve-img-upload ${hasImg?'has-image':''}" id="${id}">
                        ${hasImg?`<img src="${imgSrc(cap.image)}"><button class="ve-img-remove" onclick="event.stopPropagation();clearImage(${sIdx},'image','captain.','${id}')" title="Remove"><i class="bi bi-x"></i></button>`
                        :`<div class="ve-img-placeholder"><i class="bi bi-cloud-arrow-up"></i><div>Upload photo</div></div>`}
                        <input type="file" accept="image/*" onchange="uploadImage(this,${sIdx},'image','captain.','${id}')">
                    </div></div>
            </div></div>`;
    }

    window.updateCaptain = function(sIdx, key, value) {
        if (!sections[sIdx]?.data?.captain) sections[sIdx].data.captain = {};
        sections[sIdx].data.captain[key] = value;
        markDirty();
        refreshPreview(sIdx);
    };

    // ========== MEMBERS EDITOR ==========
    function membersEditor(members, sIdx) {
        let h = `<div class="ve-field"><label>Council Members</label><div class="ve-items-list">`;
        members.forEach((m, i) => {
            const id = `img_member_${sIdx}_${i}`;
            const hasImg = !!(m.image);
            h += `<div class="ve-item-card"><div class="ve-item-head"><span>Member #${i+1}</span>
                <button class="ve-item-remove" onclick="removeMember(${sIdx},${i})" title="Remove"><i class="bi bi-x-lg"></i></button></div>
                <div class="ve-field" style="margin-bottom:8px"><label>Name</label>
                    <input type="text" value="${escAttr(m.name||'')}" oninput="updateMember(${sIdx},${i},'name',this.value)"></div>
                <div class="ve-field" style="margin-bottom:8px"><label>Title</label>
                    <input type="text" value="${escAttr(m.title||'')}" oninput="updateMember(${sIdx},${i},'title',this.value)"></div>
                <div class="ve-field" style="margin-bottom:0"><label>Photo</label>
                    <div class="ve-img-upload ${hasImg?'has-image':''}" id="${id}">
                        ${hasImg?`<img src="${imgSrc(m.image)}"><button class="ve-img-remove" onclick="event.stopPropagation();clearImage(${sIdx},'image','members.${i}.','${id}')" title="Remove"><i class="bi bi-x"></i></button>`
                        :`<div class="ve-img-placeholder"><i class="bi bi-cloud-arrow-up"></i><div>Upload</div></div>`}
                        <input type="file" accept="image/*" onchange="uploadImage(this,${sIdx},'image','members.${i}.','${id}')">
                    </div></div></div>`;
        });
        h += `<button class="ve-btn-add-item" onclick="addMember(${sIdx})"><i class="bi bi-plus me-1"></i> Add Member</button></div></div>`;
        return h;
    }

    window.updateMember = function(sIdx, mIdx, key, value) {
        if (!sections[sIdx]?.data?.members?.[mIdx]) return;
        sections[sIdx].data.members[mIdx][key] = value;
        markDirty();
        refreshPreview(sIdx);
    };

    window.addMember = function(sIdx) {
        if (!sections[sIdx]?.data?.members) sections[sIdx].data.members = [];
        sections[sIdx].data.members.push({name: 'New Member', title: 'Kagawad', image: ''});
        markDirty(); renderCanvas(); renderProperties();
    };

    window.removeMember = function(sIdx, mIdx) {
        if (!sections[sIdx]?.data?.members) return;
        sections[sIdx].data.members.splice(mIdx, 1);
        markDirty(); renderCanvas(); renderProperties();
    };

    // ========== DATA UPDATES ==========
    window.liveUpdate = function(idx, key, value) {
        if (!sections[idx]) return;
        sections[idx].data[key] = value;
        refreshPreview(idx);
        markDirty();
    };

    window.updateItemField = function(sIdx, iIdx, key, value) {
        if (!sections[sIdx]?.data?.items?.[iIdx]) return;
        sections[sIdx].data.items[iIdx][key] = value;
        markDirty();
        refreshPreview(sIdx);
    };

    window.liveUpdateItem = function(sIdx, iIdx, key, value) {
        if (!sections[sIdx]?.data?.items?.[iIdx]) return;
        sections[sIdx].data.items[iIdx][key] = value;
        refreshPreview(sIdx);
        markDirty();
    };

    window.addItem = function(sIdx, itemType) {
        if (!sections[sIdx]) return;
        if (!sections[sIdx].data.items) sections[sIdx].data.items = [];
        sections[sIdx].data.items.push(
            itemType==='service'
                ? {icon:'bi-star',title:'New Service',description:''}
                : {date:'',title:'New Item',excerpt:'',image:'',featured:false}
        );
        markDirty(); renderCanvas(); renderProperties();
    };

    window.removeItem = function(sIdx, iIdx) {
        if (!sections[sIdx]?.data?.items) return;
        sections[sIdx].data.items.splice(iIdx, 1);
        markDirty(); renderCanvas(); renderProperties();
    };

    function refreshPreview(idx) {
        const w = document.querySelectorAll('.ve-section')[idx];
        if (w) { const p = w.querySelector(':scope > div:last-child'); if (p) p.innerHTML = renderPreview(sections[idx]); }
    }

    // ========== SECTION OPS ==========
    window.moveSection = function(idx, dir) {
        const n = idx + dir;
        if (n < 0 || n >= sections.length) return;
        [sections[idx], sections[n]] = [sections[n], sections[idx]];
        if (selectedIndex === idx) selectedIndex = n;
        else if (selectedIndex === n) selectedIndex = idx;
        markDirty(); renderCanvas(); renderProperties();
    };
    window.deleteSection = function(idx) {
        if (!confirm('Delete this section?')) return;
        sections.splice(idx, 1);
        if (selectedIndex === idx) selectedIndex = -1;
        else if (selectedIndex > idx) selectedIndex--;
        markDirty(); renderCanvas(); renderProperties();
    };
    window.addSection = function(type) {
        sections.push({type, order: sections.length+1, data: getDefaultData(type)});
        markDirty(); selectedIndex = sections.length-1;
        renderCanvas(); renderProperties(); switchTab('properties');
        document.getElementById('veCanvas').scrollTop = document.getElementById('veCanvas').scrollHeight;
        showToast('Section added!');
    };

    function getDefaultData(type) {
        const d = {
            hero:{badge:'Welcome',heading:'Your Heading Here',subheading:'Your subheading text.',button_text:'Learn More',button_link:'#',button2_text:'',button2_link:''},
            page_header:{heading:'Page Title',subheading:'Page description.'},
            text_block:{heading:'Section Title',content:'Enter your content here...'},
            image_text:{label:'',heading:'Section Title',content:'Enter your content here...',image:'',image_position:'left'},
            services_grid:{label:'Our Services',heading:'What We Offer',subheading:'',items:[{icon:'bi-star',title:'Service',description:'Description.'}]},
            services_list:{label:'Our Services',heading:'What We Offer',subheading:'',items:[{icon:'bi-star',title:'Service',description:'Description.'}]},
            news_list:{items:[{date:new Date().toLocaleDateString('en-US',{year:'numeric',month:'long',day:'numeric'}),title:'News Title',excerpt:'Excerpt...',image:'',featured:false}]},
            about_preview:{label:'About Us',heading:'About Our Community',description:'Write about your community...',image:'',location:'',land_area:''},
            mission_vision:{mission:'To provide efficient, effective, and transparent public service.',vision:'A progressive, peaceful, and resilient community.'},
            council_grid:{label:'Our Leaders',heading:'Barangay Council',subheading:'Meet the dedicated officials serving our community.',captain:{name:'Hon. Captain Name',title:'Punong Barangay',image:''},members:[{name:'Hon. Member',title:'Kagawad',image:''}]},
            contact_info:{address:'',phone:'',email:'',office_hours:'',facebook:''},
        };
        return JSON.parse(JSON.stringify(d[type] || {}));
    }

    // ========== COMPONENTS GRID ==========
    function renderComponentsGrid() {
        document.getElementById('componentsGrid').innerHTML = Object.entries(sectionTypes).map(([k,info])=>
            `<button class="ve-component-btn" onclick="addSection('${k}')"><i class="bi ${info.icon}"></i>${info.label}</button>`
        ).join('');
    }

    // ========== TABS ==========
    window.switchTab = function(tab) {
        document.querySelectorAll('.ve-panel-tab').forEach(t=>t.classList.toggle('active',t.dataset.tab===tab));
        document.getElementById('tabProperties').style.display = tab==='properties'?'block':'none';
        document.getElementById('tabComponents').style.display = tab==='components'?'block':'none';
        document.getElementById('tabSettings').style.display = tab==='settings'?'block':'none';
    };

    // ========== SAVE ==========
    window.savePage = function() {
        const btn = document.getElementById('btnSave');
        btn.disabled = true;
        btn.innerHTML = '<i class="bi bi-arrow-repeat me-1" style="animation:spin 1s linear infinite"></i> Saving...';
        sections.forEach((s,i) => s.order = i+1);
        document.getElementById('formTitle').value = document.getElementById('settingTitle').value;
        document.getElementById('formSections').value = JSON.stringify(sections);
        document.getElementById('formPublished').value = document.getElementById('settingPublished').checked ? '1' : '0';
        isDirty = false;
        document.getElementById('saveForm').submit();
    };

    window.markDirty = function() {
        isDirty = true;
        document.getElementById('unsavedDot').classList.add('show');
    };
    window.addEventListener('beforeunload', function(e) { if (isDirty) { e.preventDefault(); e.returnValue = ''; } });

    function showToast(msg, isError) {
        const t = document.getElementById('veToast');
        t.className = 've-toast show' + (isError ? ' error' : '');
        t.innerHTML = `<i class="bi ${isError?'bi-exclamation-circle':'bi-check-circle'}"></i> ${msg}`;
        setTimeout(() => t.classList.remove('show'), 3000);
    }
    window.showToast = showToast;

    function esc(str) { if (!str) return ''; const d = document.createElement('div'); d.textContent = str; return d.innerHTML; }
    function escAttr(str) { return (str||'').replace(/&/g,'&amp;').replace(/"/g,'&quot;').replace(/</g,'&lt;').replace(/>/g,'&gt;'); }
    function imgSrc(url) {
        if (!url) return '';
        if (url.startsWith('http')) return url;
        // Ensure exactly one leading slash
        return '/' + url.replace(/^\/+/, '');
    }

    // ========== KEYBOARD ==========
    document.addEventListener('keydown', function(e) {
        if ((e.ctrlKey||e.metaKey) && e.key === 's') { e.preventDefault(); if (isDirty) savePage(); }
        if (e.key === 'Escape') { selectedIndex=-1; document.querySelectorAll('.ve-section').forEach(el=>el.classList.remove('ve-selected')); propsContent.style.display='none'; propsEmpty.style.display='block'; }
        if (e.key === 'Delete' && selectedIndex >= 0 && !e.target.matches('input, textarea')) deleteSection(selectedIndex);
    });
    document.getElementById('veCanvas').addEventListener('click', function(e) {
        if (e.target === this || e.target.id === 'canvasInner') {
            selectedIndex=-1; document.querySelectorAll('.ve-section').forEach(el=>el.classList.remove('ve-selected'));
            propsContent.style.display='none'; propsEmpty.style.display='block';
        }
    });
})();
</script>
@endsection
