@extends('layouts.app')

@section('title', 'Add Clan')

@section('content')
<div class="form-card">
    <div class="form-header mb-2">
        <h1 class="form-title h6" style="font-size: 0.9rem; margin-bottom: 0.3rem;">Add New Clan</h1>
        <p class="form-subtitle" style="font-size: 0.7rem; margin-bottom: 0;">Create a new clan record</p>
    </div>

    <form action="{{ route('clans.store') }}" method="POST">
        @csrf

        <!-- Clan Details -->
        <h6 class="form-section-title fw-bold" style="font-size: 0.8rem; margin-bottom: 0.8rem; margin-top: 0.5rem;">Clan Details</h6>
        <div class="row g-2">
            <div class="col-md-12">
                <label for="name" class="form-label required-field" style="font-size: 0.65rem;">Clan Name</label>
                <input type="text" class="form-control form-control-sm @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required style="font-size: 0.8rem;">
                @error('name') <div class="invalid-feedback" style="font-size: 0.65rem;">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-12">
                <label for="description" class="form-label" style="font-size: 0.65rem;">Description</label>
                <textarea class="form-control form-control-sm @error('description') is-invalid @enderror" id="description" name="description" rows="2" style="font-size: 0.8rem;">{{ old('description') }}</textarea>
                @error('description') <div class="invalid-feedback" style="font-size: 0.65rem;">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="form-actions d-flex gap-1 mt-2">
            <a href="{{ route('clans.index') }}" class="btn btn-secondary btn-sm" style="font-size: 0.75rem; padding: 0.3rem 0.6rem;">Cancel</a>
            <button type="submit" class="btn btn-primary btn-sm" style="font-size: 0.75rem; padding: 0.3rem 0.6rem;">
                <i class="bi bi-save"></i> Save
            </button>
        </div>
    </form>
</div>
@endsection
