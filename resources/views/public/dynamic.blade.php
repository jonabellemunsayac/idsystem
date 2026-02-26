@extends('public.layout')

@section('title', $page->title . ' | Barangay Kalawaan')

@section('content')

@foreach($page->sections ?? [] as $section)
    @php $d = $section['data'] ?? []; $type = $section['type'] ?? ''; @endphp

    @switch($type)

        @case('hero')
            <section class="hero-section">      
                <div class="hero-overlay"></div>
                <div class="hero-content">
                    @if(!empty($d['badge']))
                        <span class="badge bg-warning text-dark mb-3 mb-md-4 px-3 py-2 rounded-pill fw-bold text-uppercase ls-1" style="font-size: clamp(0.65rem, 2vw, 0.875rem);">{{ $d['badge'] }}</span>
                    @endif
                    <h1 class="hero-title text-white">{{ $d['heading'] ?? '' }}</h1>
                    <p class="hero-subtitle">{{ $d['subheading'] ?? '' }}</p>
                    <div class="d-flex gap-2 gap-md-3 justify-content-center flex-wrap">
                        @if(!empty($d['button_text']))
                            <a href="{{ $d['button_link'] ?? '#' }}" class="btn btn-pasig" style="font-size: clamp(0.875rem, 2.5vw, 1rem); padding: clamp(0.5rem, 2vw, 0.75rem) clamp(1rem, 3vw, 1.5rem);">{{ $d['button_text'] }}</a>
                        @endif
                        @if(!empty($d['button2_text']))
                            <a href="{{ $d['button2_link'] ?? '#' }}" class="btn btn-outline-pasig" style="font-size: clamp(0.875rem, 2.5vw, 1rem); padding: clamp(0.5rem, 2vw, 0.75rem) clamp(1rem, 3vw, 1.5rem);">{{ $d['button2_text'] }}</a>
                        @endif
                    </div>
                </div>
            </section>
        @break

        @case('page_header')
            <header class="page-header py-5 bg-light mt-5">
                <div class="container pt-5">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h1 class="display-5 fw-bold text-blue">{{ $d['heading'] ?? '' }}</h1>
                            @if(!empty($d['subheading']))
                                <p class="text-muted lead mb-0">{{ $d['subheading'] }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </header>
        @break

        @case('text_block')
            <section class="section-padding">
                <div class="container">
                    @if(!empty($d['heading']))
                        <h2 class="display-6 fw-bold text-blue mb-4">{{ $d['heading'] }}</h2>
                    @endif
                    <div class="text-muted" style="white-space: pre-wrap; line-height: 1.8;">{{ $d['content'] ?? '' }}</div>
                </div>
            </section>
        @break

        @case('image_text')
            <section class="section-padding">
                <div class="container">
                    <div class="row g-5 align-items-center">
                        @php $imgLeft = ($d['image_position'] ?? 'left') === 'left'; @endphp
                        <div class="col-lg-6 {{ $imgLeft ? '' : 'order-lg-2' }}">
                            @if(!empty($d['image']))
                                <img src="{{ str_starts_with($d['image'], 'http') ? $d['image'] : asset(ltrim($d['image'], '/')) }}" alt="{{ $d['heading'] ?? '' }}" class="img-fluid rounded-4 shadow w-100">
                            @else
                                <div class="bg-light rounded-4 d-flex align-items-center justify-content-center" style="height: 350px;">
                                    <i class="bi bi-image text-muted" style="font-size: 4rem;"></i>
                                </div>
                            @endif
                        </div>
                        <div class="col-lg-6 {{ $imgLeft ? '' : 'order-lg-1' }}">
                            @if(!empty($d['label']))
                                <span class="section-label">{{ $d['label'] }}</span>
                            @endif
                            @if(!empty($d['heading']))
                                <h2 class="display-6 fw-bold text-blue mb-4">{{ $d['heading'] }}</h2>
                            @endif
                            <div class="text-muted" style="white-space: pre-wrap; line-height: 1.8;">{{ $d['content'] ?? '' }}</div>
                        </div>
                    </div>
                </div>
            </section>
        @break

        @case('services_grid')
            <section class="section-padding bg-light">
                <div class="container">
                    <div class="row mb-5 align-items-end">
                        <div class="col-lg-8">
                            @if(!empty($d['label']))
                                <span class="section-label">{{ $d['label'] }}</span>
                            @endif
                            <h2 class="display-5 fw-bold text-blue">{{ $d['heading'] ?? 'Services' }}</h2>
                            @if(!empty($d['subheading']))
                                <p class="text-muted lead">{{ $d['subheading'] }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="row g-4">
                        @foreach($d['items'] ?? [] as $item)
                            <div class="col-md-6 col-lg-3">
                                <a href="{{ route('public.services') }}" class="text-decoration-none">
                                    <div class="feature-card">
                                        <div class="icon-wrapper">
                                            <i class="bi {{ $item['icon'] ?? 'bi-star' }}"></i>
                                        </div>
                                        <h4 class="mb-3">{{ $item['title'] ?? '' }}</h4>
                                        <p class="text-muted small mb-0">{{ $item['description'] ?? '' }}</p>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @break

        @case('services_list')
            <section class="section-padding">
                <div class="container">
                    @if(!empty($d['label']))
                        <div class="text-center section-header mx-auto mb-5">
                            <span class="section-label">{{ $d['label'] ?? 'What We Offer' }}</span>
                            <h2 class="display-5 fw-bold text-blue">{{ $d['heading'] ?? 'Public Services' }}</h2>
                            @if(!empty($d['subheading']))
                                <p class="text-muted">{{ $d['subheading'] }}</p>
                            @endif
                        </div>
                    @endif
                    <div class="row g-4">
                        @foreach($d['items'] ?? [] as $item)
                            <div class="col-lg-4 col-md-6">
                                <div class="card h-100 border-0 shadow-sm hover-elevate">
                                    <div class="card-body p-4 text-center">
                                        <div class="icon-wrapper bg-blue-subtle text-blue mx-auto mb-4" style="width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem;">
                                            <i class="bi {{ $item['icon'] ?? 'bi-star' }}"></i>
                                        </div>
                                        <h4 class="card-title fw-bold mb-3">{{ $item['title'] ?? '' }}</h4>
                                        <p class="card-text text-muted mb-4">{{ $item['description'] ?? '' }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @break

        @case('news_list')
            <section class="section-padding">
                <div class="container">
                    @php
                        $items = $d['items'] ?? [];
                        $featured = collect($items)->firstWhere('featured', true);
                        $regular = collect($items)->where('featured', '!=', true)->values();
                    @endphp

                    {{-- Featured story --}}
                    @if($featured)
                        <div class="card border-0 shadow-sm overflow-hidden mb-5">
                            <div class="row g-0">
                                <div class="col-lg-7">
                                    @if(!empty($featured['image']))
                                        <img src="{{ asset($featured['image']) }}" class="img-fluid h-100 object-fit-cover" alt="{{ $featured['title'] ?? '' }}" style="min-height: 350px;">
                                    @else
                                        <div class="bg-light h-100 d-flex align-items-center justify-content-center" style="min-height: 350px;">
                                            <i class="bi bi-newspaper text-muted" style="font-size: 4rem;"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-lg-5 p-4 p-lg-5 d-flex flex-column justify-content-center">
                                    <span class="badge bg-warning text-dark align-self-start mb-3">Featured Story</span>
                                    <div class="news-meta text-muted small mb-2">
                                        <i class="bi bi-calendar3 me-2"></i> {{ $featured['date'] ?? '' }}
                                    </div>
                                    <h2 class="card-title fw-bold text-blue mb-3">{{ $featured['title'] ?? '' }}</h2>
                                    <p class="card-text text-muted mb-4">{{ $featured['excerpt'] ?? '' }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- News grid --}}
                    @if($regular->count() > 0 || (!$featured && count($items) > 0))
                        @php $gridItems = $featured ? $regular : collect($items); @endphp
                        <div class="row g-4">
                            @foreach($gridItems as $item)
                                <div class="col-lg-4 col-md-6">
                                    <div class="news-card">
                                        <div class="position-relative">
                                            @if(!empty($item['image']))
                                                <img src="{{ asset($item['image']) }}" alt="{{ $item['title'] ?? '' }}" class="news-img">
                                            @else
                                                <div class="news-img bg-light d-flex align-items-center justify-content-center">
                                                    <i class="bi bi-newspaper text-muted" style="font-size: 2rem;"></i>
                                                </div>
                                            @endif
                                            @if(!empty($item['featured']))
                                                <span class="badge bg-danger position-absolute top-0 start-0 m-3">Featured</span>
                                            @endif
                                        </div>
                                        <div class="news-body">
                                            <span class="news-date">{{ $item['date'] ?? '' }}</span>
                                            <h3 class="news-title">{{ $item['title'] ?? '' }}</h3>
                                            <p class="text-muted small mb-4">{{ $item['excerpt'] ?? '' }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </section>
        @break

        @case('about_preview')
            <section class="section-padding bg-light">
                <div class="container">
                    <div class="row align-items-center g-5">
                        <div class="col-lg-6">
                            @if(!empty($d['image']))
                                <img src="{{ asset($d['image']) }}" alt="{{ $d['heading'] ?? '' }}" class="img-fluid rounded-4 shadow-lg w-100">
                            @else
                                <div class="bg-white rounded-4 shadow-lg d-flex align-items-center justify-content-center" style="height: 350px;">
                                    <i class="bi bi-image text-muted" style="font-size: 4rem;"></i>
                                </div>
                            @endif
                        </div>
                        <div class="col-lg-6">
                            @if(!empty($d['label']))
                                <span class="section-label">{{ $d['label'] }}</span>
                            @endif
                            <h2 class="display-5 fw-bold text-blue mb-4">{{ $d['heading'] ?? '' }}</h2>
                            <p class="text-muted mb-4">{{ $d['description'] ?? '' }}</p>

                            <div class="row g-3">
                                @if(!empty($d['location']))
                                    <div class="col-sm-6">
                                        <div class="quick-link-item">
                                            <div class="quick-link-icon"><i class="bi bi-geo-alt"></i></div>
                                            <div>
                                                <small class="text-muted d-block">Location</small>
                                                <span class="fw-bold text-dark">{{ $d['location'] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if(!empty($d['land_area']))
                                    <div class="col-sm-6">
                                        <div class="quick-link-item">
                                            <div class="quick-link-icon"><i class="bi bi-map"></i></div>
                                            <div>
                                                <small class="text-muted d-block">Land Area</small>
                                                <span class="fw-bold text-dark">{{ $d['land_area'] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @break

        @case('mission_vision')
            <section class="section-padding bg-blue text-white">
                <div class="container">
                    <div class="row g-5 text-center">
                        <div class="col-md-6">
                            <div class="p-4 border border-light rounded-4 h-100">
                                <div class="display-4 text-warning mb-3"><i class="bi bi-flag"></i></div>
                                <h3 class="fw-bold mb-3">Mission</h3>
                                <p class="lead opacity-75">{{ $d['mission'] ?? '' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-4 border border-light rounded-4 h-100">
                                <div class="display-4 text-warning mb-3"><i class="bi bi-eye"></i></div>
                                <h3 class="fw-bold mb-3">Vision</h3>
                                <p class="lead opacity-75">{{ $d['vision'] ?? '' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @break

        @case('council_grid')
            <section class="section-padding">
                <div class="container">
                    <div class="text-center section-header mx-auto mb-5">
                        @if(!empty($d['label']))
                            <span class="section-label">{{ $d['label'] }}</span>
                        @endif
                        <h2 class="display-5 fw-bold text-blue">{{ $d['heading'] ?? 'Barangay Council' }}</h2>
                        @if(!empty($d['subheading']))
                            <p class="text-muted">{{ $d['subheading'] }}</p>
                        @endif
                    </div>

                    {{-- Captain --}}
                    @if(!empty($d['captain']))
                        <div class="row justify-content-center mb-5">
                            <div class="col-lg-4 col-md-6">
                                <div class="text-center">
                                    <div class="mb-3">
                                        @if(!empty($d['captain']['image']))
                                            <img src="{{ asset($d['captain']['image']) }}" alt="{{ $d['captain']['name'] ?? '' }}" class="rounded-circle shadow-lg" width="200" height="200" style="object-fit: cover;">
                                        @else
                                            <div class="rounded-circle shadow-lg bg-light d-inline-flex align-items-center justify-content-center" style="width: 200px; height: 200px;">
                                                <i class="bi bi-person text-muted" style="font-size: 4rem;"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <h3 class="h4 fw-bold text-blue">{{ $d['captain']['name'] ?? '' }}</h3>
                                    <p class="text-muted text-uppercase small ls-1 fw-bold">{{ $d['captain']['title'] ?? 'Punong Barangay' }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Members --}}
                    @if(!empty($d['members']))
                        <div class="row g-4 justify-content-center">
                            @foreach($d['members'] as $member)
                                <div class="col-lg-3 col-md-4 col-sm-6">
                                    <div class="text-center">
                                        <div class="mb-3">
                                            @if(!empty($member['image']))
                                                <img src="{{ asset($member['image']) }}" alt="{{ $member['name'] ?? '' }}" class="rounded-circle shadow-sm" width="120" height="120" style="object-fit: cover;">
                                            @else
                                                <div class="rounded-circle shadow-sm bg-light d-inline-flex align-items-center justify-content-center" style="width: 120px; height: 120px;">
                                                    <i class="bi bi-person text-muted" style="font-size: 2.5rem;"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <h5 class="fw-bold text-dark">{{ $member['name'] ?? '' }}</h5>
                                        <p class="text-muted small">{{ $member['title'] ?? '' }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </section>
        @break

        @case('contact_info')
            <section class="section-padding pb-0">
                <div class="container">
                    <div class="row g-4 justify-content-center">
                        @if(!empty($d['address']))
                            <div class="col-lg-4 col-md-6">
                                <div class="card h-100 border-0 shadow-sm text-center p-4">
                                    <div class="icon-wrapper bg-blue-subtle text-blue mx-auto mb-4" style="width: 70px; height: 70px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.8rem;">
                                        <i class="bi bi-geo-alt-fill"></i>
                                    </div>
                                    <h5 class="fw-bold mb-3">Visit Us</h5>
                                    <p class="text-muted mb-0">{{ $d['address'] }}</p>
                                </div>
                            </div>
                        @endif
                        @if(!empty($d['phone']))
                            <div class="col-lg-4 col-md-6">
                                <div class="card h-100 border-0 shadow-sm text-center p-4">
                                    <div class="icon-wrapper bg-blue-subtle text-blue mx-auto mb-4" style="width: 70px; height: 70px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.8rem;">
                                        <i class="bi bi-telephone-fill"></i>
                                    </div>
                                    <h5 class="fw-bold mb-3">Call Us</h5>
                                    <p class="text-muted mb-0">{{ $d['phone'] }}</p>
                                </div>
                            </div>
                        @endif
                        @if(!empty($d['email']))
                            <div class="col-lg-4 col-md-6">
                                <div class="card h-100 border-0 shadow-sm text-center p-4">
                                    <div class="icon-wrapper bg-blue-subtle text-blue mx-auto mb-4" style="width: 70px; height: 70px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.8rem;">
                                        <i class="bi bi-envelope-fill"></i>
                                    </div>
                                    <h5 class="fw-bold mb-3">Email Us</h5>
                                    <p class="text-muted mb-0">{{ $d['email'] }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </section>

            {{-- Office hours & social --}}
            @if(!empty($d['office_hours']) || !empty($d['facebook']))
                <section class="section-padding pt-4">
                    <div class="container">
                        <div class="row justify-content-center">
                            @if(!empty($d['office_hours']))
                                <div class="col-auto">
                                    <p class="text-muted"><i class="bi bi-clock me-2"></i>{{ $d['office_hours'] }}</p>
                                </div>
                            @endif
                            @if(!empty($d['facebook']))
                                <div class="col-auto">
                                    <a href="{{ $d['facebook'] }}" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-light">
                                        <i class="bi bi-facebook"></i> Facebook
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </section>
            @endif
        @break

    @endswitch
@endforeach

@endsection
