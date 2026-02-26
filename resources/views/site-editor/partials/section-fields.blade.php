@php
    $data = $section['data'] ?? [];
    $type = $section['type'];
@endphp

@switch($type)
    @case('hero')
        <div class="field-group">
            <label>Badge Text</label>
            <input type="text" data-field="badge" value="{{ $data['badge'] ?? '' }}" placeholder="e.g. Welcome to Pasig City">
        </div>
        <div class="field-group">
            <label>Heading</label>
            <input type="text" data-field="heading" value="{{ $data['heading'] ?? '' }}" placeholder="Main heading">
        </div>
        <div class="field-group">
            <label>Subheading</label>
            <textarea data-field="subheading" placeholder="Supporting description" rows="3">{{ $data['subheading'] ?? '' }}</textarea>
        </div>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
            <div class="field-group">
                <label>Button 1 Text</label>
                <input type="text" data-field="button_text" value="{{ $data['button_text'] ?? '' }}" placeholder="Button text">
            </div>
            <div class="field-group">
                <label>Button 1 Link</label>
                <input type="text" data-field="button_link" value="{{ $data['button_link'] ?? '' }}" placeholder="/services">
            </div>
            <div class="field-group">
                <label>Button 2 Text</label>
                <input type="text" data-field="button2_text" value="{{ $data['button2_text'] ?? '' }}" placeholder="Optional">
            </div>
            <div class="field-group">
                <label>Button 2 Link</label>
                <input type="text" data-field="button2_link" value="{{ $data['button2_link'] ?? '' }}" placeholder="/about">
            </div>
        </div>
        @break

    @case('page_header')
        <div class="field-group">
            <label>Heading</label>
            <input type="text" data-field="heading" value="{{ $data['heading'] ?? '' }}" placeholder="Page title">
        </div>
        <div class="field-group" style="margin-bottom: 0;">
            <label>Subheading</label>
            <input type="text" data-field="subheading" value="{{ $data['subheading'] ?? '' }}" placeholder="Brief description">
        </div>
        @break

    @case('text_block')
        <div class="field-group">
            <label>Heading</label>
            <input type="text" data-field="heading" value="{{ $data['heading'] ?? '' }}" placeholder="Section title">
        </div>
        <div class="field-group" style="margin-bottom: 0;">
            <label>Content</label>
            <textarea data-field="content" placeholder="Section content..." rows="6">{{ $data['content'] ?? '' }}</textarea>
        </div>
        @break

    @case('services_grid')
    @case('services_list')
        <div class="field-group">
            <label>Section Label</label>
            <input type="text" data-field="label" value="{{ $data['label'] ?? '' }}" placeholder="e.g. Our Services">
        </div>
        <div class="field-group">
            <label>Heading</label>
            <input type="text" data-field="heading" value="{{ $data['heading'] ?? '' }}" placeholder="Section heading">
        </div>
        <div class="field-group">
            <label>Subheading</label>
            <input type="text" data-field="subheading" value="{{ $data['subheading'] ?? '' }}" placeholder="Brief description">
        </div>
        <div class="field-group" style="margin-bottom: 0;">
            <label>Service Items</label>
            <div class="items-editor">
                @foreach(($data['items'] ?? []) as $itemIdx => $item)
                <div class="item-entry">
                    <div class="item-header">
                        <span>Service #{{ $itemIdx + 1 }}</span>
                        <button type="button" class="item-remove" onclick="this.closest('.item-entry').remove()"><i class="bi bi-x-lg"></i></button>
                    </div>
                    <div class="field-group">
                        <label>Icon (Bootstrap Icon class)</label>
                        <input type="text" data-item-field="icon" value="{{ $item['icon'] ?? '' }}" placeholder="bi-star">
                    </div>
                    <div class="field-group">
                        <label>Title</label>
                        <input type="text" data-item-field="title" value="{{ $item['title'] ?? '' }}" placeholder="Service name">
                    </div>
                    <div class="field-group" style="margin-bottom: 0;">
                        <label>Description</label>
                        <input type="text" data-item-field="description" value="{{ $item['description'] ?? '' }}" placeholder="Brief description">
                    </div>
                </div>
                @endforeach
                <button type="button" class="btn-add-item" onclick="addItem(this, 'service')">
                    <i class="bi bi-plus me-1"></i> Add Service Item
                </button>
            </div>
        </div>
        @break

    @case('news_list')
        <div class="field-group" style="margin-bottom: 0;">
            <label>News Items</label>
            <div class="items-editor">
                @foreach(($data['items'] ?? []) as $itemIdx => $item)
                <div class="item-entry">
                    <div class="item-header">
                        <span>News #{{ $itemIdx + 1 }}</span>
                        <button type="button" class="item-remove" onclick="this.closest('.item-entry').remove()"><i class="bi bi-x-lg"></i></button>
                    </div>
                    <div class="field-group">
                        <label>Date</label>
                        <input type="text" data-item-field="date" value="{{ $item['date'] ?? '' }}" placeholder="Month DD, YYYY">
                    </div>
                    <div class="field-group">
                        <label>Title</label>
                        <input type="text" data-item-field="title" value="{{ $item['title'] ?? '' }}" placeholder="News title">
                    </div>
                    <div class="field-group">
                        <label>Excerpt</label>
                        <textarea data-item-field="excerpt" placeholder="Brief excerpt..." rows="2">{{ $item['excerpt'] ?? '' }}</textarea>
                    </div>
                    <div class="field-group" style="margin-bottom: 0;">
                        <label style="display: flex; align-items: center; gap: 8px; text-transform: none; letter-spacing: 0;">
                            <input type="checkbox" data-item-field="featured" style="width: auto;" {{ !empty($item['featured']) ? 'checked' : '' }}>
                            Featured
                        </label>
                    </div>
                </div>
                @endforeach
                <button type="button" class="btn-add-item" onclick="addItem(this, 'news')">
                    <i class="bi bi-plus me-1"></i> Add News Item
                </button>
            </div>
        </div>
        @break

    @case('about_preview')
        <div class="field-group">
            <label>Section Label</label>
            <input type="text" data-field="label" value="{{ $data['label'] ?? '' }}" placeholder="e.g. About Us">
        </div>
        <div class="field-group">
            <label>Heading</label>
            <input type="text" data-field="heading" value="{{ $data['heading'] ?? '' }}" placeholder="Section heading">
        </div>
        <div class="field-group">
            <label>Description</label>
            <textarea data-field="description" placeholder="About text..." rows="5">{{ $data['description'] ?? '' }}</textarea>
        </div>
        <div class="field-group">
            <label>Image</label>
            <div class="ve-img-upload" id="about-img-upload">
                @if(!empty($data['image']))
                    <img src="/{{ ltrim($data['image'], '/') }}" alt="">
                    <button class="ve-img-remove" type="button" onclick="clearFieldImage('image','about-img-upload')"><i class="bi bi-x"></i></button>
                @else
                    <div class="ve-img-placeholder"><i class="bi bi-cloud-arrow-up" style="font-size:24px;display:block;margin-bottom:4px;"></i><div>Click to upload</div></div>
                @endif
                <input type="file" accept="image/*" onchange="uploadFieldImage(this,'image','about-img-upload')">
            </div>
        </div>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
            <div class="field-group" style="margin-bottom: 0;">
                <label>Location</label>
                <input type="text" data-field="location" value="{{ $data['location'] ?? '' }}" placeholder="Pasig City">
            </div>
            <div class="field-group" style="margin-bottom: 0;">
                <label>Land Area</label>
                <input type="text" data-field="land_area" value="{{ $data['land_area'] ?? '' }}" placeholder="200+ hectares">
            </div>
        </div>
        @break

    @case('contact_info')
        <div class="field-group">
            <label>Address</label>
            <input type="text" data-field="address" value="{{ $data['address'] ?? '' }}" placeholder="Full address">
        </div>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
            <div class="field-group">
                <label>Phone</label>
                <input type="text" data-field="phone" value="{{ $data['phone'] ?? '' }}" placeholder="(02) 8643-1111">
            </div>
            <div class="field-group">
                <label>Email</label>
                <input type="text" data-field="email" value="{{ $data['email'] ?? '' }}" placeholder="email@example.com">
            </div>
        </div>
        <div class="field-group">
            <label>Office Hours</label>
            <input type="text" data-field="office_hours" value="{{ $data['office_hours'] ?? '' }}" placeholder="Monday - Friday, 8:00 AM - 5:00 PM">
        </div>
        <div class="field-group" style="margin-bottom: 0;">
            <label>Facebook URL</label>
            <input type="text" data-field="facebook" value="{{ $data['facebook'] ?? '' }}" placeholder="https://www.facebook.com/...">
        </div>
        @break

    @default
        <div class="text-muted" style="font-size: 13px;">
            <i class="bi bi-exclamation-circle me-1"></i>
            Unknown section type: <code>{{ $type }}</code>. Edit the raw data if needed.
        </div>
        @foreach($data as $key => $value)
            <div class="field-group">
                <label>{{ ucfirst(str_replace('_', ' ', $key)) }}</label>
                @if(is_array($value))
                    <textarea data-field="{{ $key }}" rows="3">{{ json_encode($value, JSON_PRETTY_PRINT) }}</textarea>
                @else
                    <input type="text" data-field="{{ $key }}" value="{{ $value }}">
                @endif
            </div>
        @endforeach
@endswitch
