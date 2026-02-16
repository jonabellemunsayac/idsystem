@extends('layouts.app')

@section('title', 'Site Editor')

@section('extra-styles')
<style>
    .site-editor-header { margin-bottom: 32px; }
    .site-editor-header h1 { font-size: 1.5rem; font-weight: 700; color: #1f2937; margin-bottom: 4px; }
    .site-editor-header p { color: #6b7280; margin: 0; font-size: 14px; }
    
    .pages-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 20px;
    }
    
    .page-card {
        background: white;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 1px 3px rgba(0,0,0,0.06);
    }
    .page-card:hover {
        box-shadow: 0 8px 24px rgba(0,0,0,0.1);
        transform: translateY(-2px);
    }
    
    .page-card-preview {
        height: 140px;
        background: linear-gradient(135deg, #0038A8 0%, #003A9E 60%, #CE1126 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }
    .page-card-preview::after {
        content: '';
        position: absolute;
        inset: 0;
        background: repeating-linear-gradient(
            0deg,
            transparent,
            transparent 20px,
            rgba(255,255,255,0.03) 20px,
            rgba(255,255,255,0.03) 21px
        );
    }
    .page-card-preview .page-icon {
        font-size: 40px;
        color: white;
        opacity: 0.9;
        z-index: 1;
    }
    
    .page-card-body {
        padding: 20px;
    }
    .page-card-body h3 {
        font-size: 16px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 4px;
    }
    .page-card-body .page-slug {
        font-size: 12px;
        color: #9ca3af;
        font-family: monospace;
        margin-bottom: 12px;
    }
    .page-card-body .page-meta {
        display: flex;
        align-items: center;
        gap: 16px;
        font-size: 12px;
        color: #6b7280;
        margin-bottom: 16px;
    }
    .page-card-body .page-meta i {
        margin-right: 4px;
    }
    
    .page-card-actions {
        display: flex;
        gap: 8px;
    }
    .page-card-actions .btn {
        font-size: 12px;
        font-weight: 600;
        padding: 6px 14px;
        border-radius: 6px;
    }
    .btn-edit-page {
        background-color: #0038A8;
        color: white;
        border: none;
    }
    .btn-edit-page:hover {
        background-color: #002B88;
        color: white;
    }
    .btn-preview-page {
        background-color: #f3f4f6;
        color: #374151;
        border: 1px solid #e5e7eb;
    }
    .btn-preview-page:hover {
        background-color: #e5e7eb;
        color: #1f2937;
    }
    .btn-view-live {
        background: none;
        color: #0038A8;
        border: none;
        padding: 6px 8px;
    }
    .btn-view-live:hover {
        color: #002B88;
        text-decoration: underline;
    }
    
    .status-dot {
        display: inline-block;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        margin-right: 6px;
    }
    .status-dot.published { background-color: #10b981; }
    .status-dot.draft { background-color: #f59e0b; }
    
    .info-banner {
        background: linear-gradient(135deg, #eff6ff 0%, #f0f9ff 100%);
        border: 1px solid #bfdbfe;
        border-radius: 12px;
        padding: 20px 24px;
        margin-bottom: 32px;
        display: flex;
        align-items: center;
        gap: 16px;
    }
    .info-banner i {
        font-size: 24px;
        color: #0038A8;
        flex-shrink: 0;
    }
    .info-banner p {
        margin: 0;
        font-size: 14px;
        color: #374151;
        line-height: 1.5;
    }
</style>
@endsection

@section('content')
<div class="site-editor-header">
    <h1><i class="bi bi-brush me-2"></i>Site Editor</h1>
    <p>Manage and customize your public website pages</p>
</div>

<div class="info-banner">
    <i class="bi bi-info-circle-fill"></i>
    <p>
        Edit the content of your public-facing website pages below. Changes will be reflected on the live site immediately after saving.
        Each page is made up of editable sections — click <strong>Edit Page</strong> to modify content.
    </p>
</div>

<div class="pages-grid">
    @foreach($pages as $page)
    @php
        $pageIcons = [
            'home' => 'bi-house-fill',
            'about' => 'bi-info-circle-fill',
            'services' => 'bi-gear-fill',
            'news' => 'bi-newspaper',
            'contact' => 'bi-envelope-fill',
        ];
        $icon = $pageIcons[$page->slug] ?? 'bi-file-earmark-fill';
        $sectionCount = is_array($page->sections) ? count($page->sections) : 0;
    @endphp
    <div class="page-card">
        <div class="page-card-preview">
            <i class="bi {{ $icon }} page-icon"></i>
        </div>
        <div class="page-card-body">
            <h3>{{ $page->title }}</h3>
            <div class="page-slug">/{{ $page->slug === 'home' ? '' : $page->slug }}</div>
            <div class="page-meta">
                <span>
                    <span class="status-dot {{ $page->is_published ? 'published' : 'draft' }}"></span>
                    {{ $page->is_published ? 'Published' : 'Draft' }}
                </span>
                <span><i class="bi bi-layers"></i> {{ $sectionCount }} section{{ $sectionCount !== 1 ? 's' : '' }}</span>
                @if($page->updated_at)
                <span><i class="bi bi-clock"></i> {{ $page->updated_at->diffForHumans() }}</span>
                @endif
            </div>
            <div class="page-card-actions">
                <a href="{{ route('site-editor.edit', $page) }}" class="btn btn-edit-page">
                    <i class="bi bi-pencil-square me-1"></i> Edit Page
                </a>
                <a href="{{ url($page->slug === 'home' ? '/' : '/' . $page->slug) }}" target="_blank" class="btn btn-view-live">
                    <i class="bi bi-box-arrow-up-right me-1"></i> View Live
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
