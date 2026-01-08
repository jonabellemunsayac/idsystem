@extends('layouts.app')

@section('title', 'Clans')

@section('extra-styles')
    <link rel="stylesheet" href="{{ asset('css/clans.css') }}">
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h4 fw-bold text-dark mb-1">Clan Management</h1>
        <p class="text-muted mb-0">Manage family clans and households</p>
    </div>
    <!-- <a href="{{ route('clans.create') }}" class="btn btn-primary d-flex align-items-center gap-1" style="background-color: #0038A8; border-color: #0038A8; padding: 0.5rem 1rem; font-size: 0.95rem;">
        <i class="bi bi-plus-lg"></i> Add
    </a> -->
</div>

<!-- Metrics -->
<div class="row g-2 mb-2">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-2 d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted small text-uppercase fw-bold mb-0" style="font-size: 0.6rem;">Total Clans</p>
                    <h6 class="fw-bold mb-0 text-dark" style="font-size: 1.1rem;">{{ $clans->total() }}</h6>
                </div>
                <div class="bg-light rounded p-2 text-primary" style="font-size: 0.95rem;">
                    <i class="bi bi-people"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-2 d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted small text-uppercase fw-bold mb-0" style="font-size: 0.6rem;">Total Members</p>
                    <h6 class="fw-bold mb-0 text-dark" style="font-size: 1.1rem;">387</h6>
                </div>
                <div class="bg-light rounded p-2 text-success" style="font-size: 0.95rem;">
                    <i class="bi bi-person-check"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-2 d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted small text-uppercase fw-bold mb-0" style="font-size: 0.6rem;">Average Size</p>
                    <h6 class="fw-bold mb-0 text-dark" style="font-size: 1.1rem;">8.6</h6>
                </div>
                <div class="bg-light rounded p-2 text-warning" style="font-size: 0.95rem;">
                    <i class="bi bi-people-fill"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-2 d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted small text-uppercase fw-bold mb-0" style="font-size: 0.6rem;">Largest Clan</p>
                    <h6 class="fw-bold mb-0 text-dark" style="font-size: 1.1rem;">22</h6>
                </div>
                <div class="bg-light rounded p-2 text-info" style="font-size: 0.95rem;">
                    <i class="bi bi-trophy"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-2 border-bottom-0">
        <h6 class="card-title mb-0 fw-bold" style="font-size: 0.8rem;">Registered Clans</h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size: 0.75rem;">
                <thead class="bg-light">
                    <tr>
                        <th class="border-0 text-secondary text-uppercase fw-bold ps-2" style="font-size: 0.65rem;">Clan Name</th>
                        <th class="border-0 text-secondary text-uppercase fw-bold" style="font-size: 0.65rem;">Head of Family</th>
                        <th class="border-0 text-secondary text-uppercase fw-bold" style="font-size: 0.65rem;">Address</th>
                        <th class="border-0 text-secondary text-uppercase fw-bold" style="font-size: 0.65rem;">Contact</th>
                        <!-- <th class="border-0 text-secondary text-uppercase fw-bold text-end pe-2" style="font-size: 0.65rem;">Actions</th> -->
                    </tr>
                </thead>
                <tbody>
                    @forelse($clans as $clan)
                    <tr>
                        <td class="ps-2 fw-medium text-dark" style="font-size: 0.75rem;">{{ $clan['clan_name'] }}</td>
                        <td style="font-size: 0.75rem;">{{ $clan['head_of_family'] }}</td>
                        <td style="font-size: 0.75rem;">{{ $clan['address'] }}</td>
                        <td style="font-size: 0.75rem;">{{ $clan['contact_number'] }}</td>
                        <!-- <td class="text-end pe-2">
                            <a href="{{ route('clans.show', $clan['id']) }}" class="btn btn-link text-primary p-0 me-1" style="font-size: 0.7rem;">View</a>
                            <form action="{{ route('clans.destroy', $clan['id']) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-link text-danger p-0" style="font-size: 0.7rem;">Delete</button>
                            </form>
                        </td> -->
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-3 text-muted" style="font-size: 0.75rem;">
                            No clans registered yet
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($clans->hasPages())
    <div class="card-footer bg-white border-top-0 py-2">
        {{ $clans->links() }}
    </div>
    @endif
</div>
@endsection
