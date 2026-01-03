@extends('layouts.app')

@section('title', 'Clan Details')

@section('content')
<div class="mb-2">
    <a href="{{ route('clans.index') }}" class="btn btn-secondary btn-sm mb-2" style="font-size: 0.75rem; padding: 0.3rem 0.6rem;">
        <i class="bi bi-arrow-left me-1"></i> Back
    </a>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-2">
            <h6 class="fw-bold" style="font-size: 0.9rem; margin-bottom: 0.5rem;">{{ $clan['name'] }}</h6>
            <p style="font-size: 0.75rem; margin-bottom: 1rem; color: #666;">{{ $clan['description'] }}</p>

            <form action="{{ route('clans.destroy', $clan['id']) }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')" style="font-size: 0.75rem; padding: 0.3rem 0.6rem;">
                    <i class="bi bi-trash me-1"></i> Delete
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
