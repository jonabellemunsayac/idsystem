@extends('layouts.app')

@section('title', 'Clans')

@section('extra-styles')
    <link rel="stylesheet" href="{{ asset('css/clans.css') }}">
@endsection

@section('content')
@php
    $sort = $sort ?? 'clan_name';
    $direction = $direction ?? 'asc';

    $sortLink = function ($column) use ($sort, $direction) {
        return route('clans.index', array_merge(request()->except('page'), [
            'sort' => $column,
            'direction' => $sort === $column && $direction === 'asc' ? 'desc' : 'asc',
        ]));
    };

    $sortIcon = function ($column) use ($sort, $direction) {
        if ($sort !== $column) {
            return 'bi-arrow-down-up';
        }

        return $direction === 'asc' ? 'bi-sort-alpha-down' : 'bi-sort-alpha-up';
    };
@endphp

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
                    <h6 class="fw-bold mb-0 text-dark" style="font-size: 1.1rem;">{{ $stats['total_clans'] }}</h6>
                </div>
                <div class="bg-light rounded p-2 text-primary" style="font-size: 0.75rem;">
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
                    <h6 class="fw-bold mb-0 text-dark" style="font-size: 1.1rem;">{{ $stats['total_members'] }}</h6>
                </div>
                <div class="bg-light rounded p-2 text-success" style="font-size: 0.75rem;">
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
                    <h6 class="fw-bold mb-0 text-dark" style="font-size: 1.1rem;">{{ $stats['average_size'] }}</h6>
                </div>
                <div class="bg-light rounded p-2 text-warning" style="font-size: 0.75rem;">
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
                    <h6 class="fw-bold mb-0 text-dark" style="font-size: 1.1rem;">{{ $stats['largest_clan'] }}</h6>
                </div>
                <div class="bg-light rounded p-2 text-info" style="font-size: 0.75rem;">
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
                        <th class="border-0 text-secondary text-uppercase fw-bold ps-2" style="font-size: 0.65rem; width: 40px;"></th>
                        <th class="border-0 text-secondary text-uppercase fw-bold" style="font-size: 0.65rem;">
                            <a href="{{ $sortLink('clan_name') }}" class="sort-link">
                                Clan Name <i class="bi {{ $sortIcon('clan_name') }}"></i>
                            </a>
                        </th>
                        <th class="border-0 text-secondary text-uppercase fw-bold" style="font-size: 0.65rem;">
                            <a href="{{ $sortLink('head_of_family') }}" class="sort-link">
                                Head of Family <i class="bi {{ $sortIcon('head_of_family') }}"></i>
                            </a>
                        </th>
                        <th class="border-0 text-secondary text-uppercase fw-bold" style="font-size: 0.65rem;">
                            <a href="{{ $sortLink('address') }}" class="sort-link">
                                Address <i class="bi {{ $sortIcon('address') }}"></i>
                            </a>
                        </th>
                        <th class="border-0 text-secondary text-uppercase fw-bold" style="font-size: 0.65rem;">
                            <a href="{{ $sortLink('contact') }}" class="sort-link">
                                Contact <i class="bi {{ $sortIcon('contact') }}"></i>
                            </a>
                        </th>
                        <th class="border-0 text-secondary text-uppercase fw-bold text-center" style="font-size: 0.65rem;">
                            <a href="{{ $sortLink('members') }}" class="sort-link justify-content-center">
                                Members <i class="bi {{ $sortIcon('members') }}"></i>
                            </a>
                        </th>
                        <!-- <th class="border-0 text-secondary text-uppercase fw-bold text-end pe-2" style="font-size: 0.65rem;">Actions</th> -->
                    </tr>
                </thead>
                <tbody>
                    @forelse($clans as $clan)
                    <tr class="clan-row" data-clan-id="{{ $clan['id'] }}">
                        <td class="ps-2">
                            <button class="btn btn-sm btn-link p-0 expand-btn" data-clan-id="{{ $clan['id'] }}" title="Expand to see members">
                                <i class="bi bi-chevron-right text-primary"></i>
                            </button>
                        </td>
                        <td class="fw-medium text-dark" style="font-size: 0.75rem;">{{ $clan['clan_name'] }}</td>
                        <td style="font-size: 0.75rem;">{{ $clan['head_of_family'] }}</td>
                        <td style="font-size: 0.75rem;">{{ $clan['address'] }}</td>
                        <td style="font-size: 0.75rem;">{{ $clan['head_contacts'] ?: $clan['contact_number'] }}</td>
                        <td class="text-center" style="font-size: 0.75rem;">
                            <span class="badge bg-primary">{{ $clan['members_count'] }}</span>
                        </td>
                        <!-- <td class="text-end pe-2">
                            <a href="{{ route('clans.show', $clan['id']) }}" class="btn btn-link text-primary p-0 me-1" style="font-size: 0.7rem;">View</a>
                            <form action="{{ route('clans.destroy', $clan['id']) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-link text-danger p-0" style="font-size: 0.7rem;">Delete</button>
                            </form>
                        </td> -->
                    </tr>
                    <tr class="members-row" id="members-{{ $clan['id'] }}" style="display: none;">
                        <td colspan="6" class="bg-light p-0">
                            <div class="p-3">
                                <h6 class="fw-bold mb-3" style="font-size: 0.75rem;">
                                    <i class="bi bi-people-fill text-primary"></i> Clan Members
                                </h6>
                                <div class="members-list" id="members-list-{{ $clan['id'] }}">
                                    <div class="text-center text-muted py-2" style="font-size: 0.75rem;">
                                        <div class="spinner-border spinner-border-sm" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        Loading members...
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-3 text-muted" style="font-size: 0.75rem;">
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
        <div style="font-size: 0.875rem;">
            {{ $clans->links('vendor.pagination.custom') }}
        </div>
    </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle expand/collapse
    document.querySelectorAll('.expand-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const clanId = this.dataset.clanId;
            const membersRow = document.getElementById(`members-${clanId}`);
            const icon = this.querySelector('i');
            
            if (membersRow.style.display === 'none') {
                // Expand
                membersRow.style.display = 'table-row';
                icon.classList.remove('bi-chevron-right');
                icon.classList.add('bi-chevron-down');
                
                // Load members if not already loaded
                const membersList = document.getElementById(`members-list-${clanId}`);
                if (membersList.querySelector('.spinner-border')) {
                    loadClanMembers(clanId);
                }
            } else {
                // Collapse
                membersRow.style.display = 'none';
                icon.classList.remove('bi-chevron-down');
                icon.classList.add('bi-chevron-right');
            }
        });
    });
    
    function loadClanMembers(clanId) {
        fetch(`/clans/${clanId}/members`)
            .then(response => response.json())
            .then(data => {
                const membersList = document.getElementById(`members-list-${clanId}`);
                
                if (data.members && data.members.length > 0) {
                    let html = '<div class="row g-2">';
                    data.members.forEach(member => {
                        html += `
                            <div class="col-md-6">
                                <div class="card border">
                                    <div class="card-body p-2">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-2" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">
                                                <i class="bi bi-person text-primary" style="font-size: 0.9rem;"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold mb-0" style="font-size: 0.75rem;">${member.name}</div>
                                                <small class="text-muted" style="font-size: 0.65rem;">${member.relationship || 'Member'}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    html += '</div>';
                    membersList.innerHTML = html;
                } else {
                    membersList.innerHTML = '<div class="text-center text-muted py-2" style="font-size: 0.75rem;">No members found in this clan</div>';
                }
            })
            .catch(error => {
                console.error('Error loading members:', error);
                const membersList = document.getElementById(`members-list-${clanId}`);
                membersList.innerHTML = '<div class="text-center text-danger py-2" style="font-size: 0.75rem;">Failed to load members</div>';
            });
    }
});
</script>

<style>
.expand-btn {
    transition: all 0.2s ease;
}
.expand-btn:hover i {
    transform: scale(1.2);
}
.members-row td {
    border-top: none !important;
}
.clan-row:hover {
    background-color: rgba(0, 56, 168, 0.02);
}
.sort-link {
    align-items: center;
    color: inherit;
    display: inline-flex;
    gap: 0.25rem;
    text-decoration: none;
}
.sort-link:hover {
    color: #0038A8;
}
</style>
@endsection
