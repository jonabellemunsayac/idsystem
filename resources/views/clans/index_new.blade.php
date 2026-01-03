@extends('layouts.app')

@section('title', 'Clans')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-2">
    <div>
        <h1 class="h6 fw-bold text-dark mb-0" style="font-size: 0.9rem;">Clans</h1>
        <p class="text-muted mb-0" style="font-size: 0.7rem;">Manage all barangay clans</p>
    </div>
    <a href="{{ route('clans.create') }}" class="btn btn-success btn-sm d-flex align-items-center gap-1" style="background-color: #198754; border-color: #198754; padding: 0.3rem 0.6rem; font-size: 0.75rem;">
        <i class="bi bi-plus-lg"></i> Add
    </a>
</div>

@if($clans->count() > 0)
    <div class="row g-2">
        @foreach($clans as $clan)
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-header bg-primary text-white" style="padding: 0.6rem 0.8rem;">
                    <h6 class="card-title mb-0 fw-bold" style="font-size: 0.8rem;">{{ $clan['name'] }}</h6>
                    <p class="card-subtitle text-white-50 mb-0" style="font-size: 0.65rem;">{{ $clan['clan_code'] ?? 'No code' }}</p>
                </div>
                <div class="card-body" style="padding: 0.6rem;">
                    <p class="card-text text-muted" style="font-size: 0.75rem; margin-bottom: 0.5rem;">{{ Str::limit($clan['description'] ?? 'No description provided', 80) }}</p>
                </div>
                <div class="card-footer bg-white border-top-0" style="padding: 0.5rem 0.6rem;">
                    <div class="d-flex gap-1">
                        <a href="{{ route('clans.show', $clan['id']) }}" class="btn btn-sm btn-primary" style="font-size: 0.7rem; padding: 0.2rem 0.4rem;">
                            <i class="bi bi-eye"></i> View
                        </a>
                        <a href="{{ route('clans.edit', $clan['id']) }}" class="btn btn-sm btn-secondary" style="font-size: 0.7rem; padding: 0.2rem 0.4rem;">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <form action="{{ route('clans.destroy', $clan['id']) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this clan?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" style="font-size: 0.7rem; padding: 0.2rem 0.4rem;">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
    <div class="mt-2">
        {{ $clans->links() }}
    </div>
@else
    <div class="card border-0 shadow-sm">
        <div class="card-body text-center" style="padding: 1.5rem;">
            <div class="mb-2 text-muted">
                <i class="bi bi-people" style="font-size: 1.5rem;"></i>
            </div>
            <h6 class="fw-bold" style="font-size: 0.85rem;">No clans found</h6>
            <p class="text-muted mb-2" style="font-size: 0.75rem;">Get started by creating a new clan.</p>
            <a href="{{ route('clans.create') }}" class="btn btn-primary btn-sm" style="font-size: 0.75rem; padding: 0.3rem 0.6rem;">
                <i class="bi bi-plus-lg"></i> Create
            </a>
        </div>
    </div>
@endif
@endsection