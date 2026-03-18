@extends('layouts.resident')

@section('title', 'Family Information - Resident Portal')

@section('content')
<div class="row">
    <div class="col-md-12">
        {{-- Clan Information --}}
        @if($clan && $clan['clan_name'])
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-people me-2"></i>{{ $clan['clan_name'] }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <small class="text-muted d-block">Head of Family</small>
                                <strong>{{ $clan['head_of_family'] ?? 'N/A' }}</strong>
                            </div>
                            <div class="mb-3">
                                <small class="text-muted d-block">Address</small>
                                <strong>{{ $clan['address'] ?? 'N/A' }}</strong>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <small class="text-muted d-block">Contact Number</small>
                                <strong>{{ $clan['contact_number'] ?? 'N/A' }}</strong>
                            </div>
                            <div class="mb-3">
                                <small class="text-muted d-block">Email</small>
                                <strong>{{ $clan['email'] ?? 'N/A' }}</strong>
                            </div>
                        </div>
                    </div>
                    @if($clan['notes'])
                        <div class="mt-3">
                            <small class="text-muted d-block">Notes</small>
                            <p>{{ $clan['notes'] }}</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Family Members --}}
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-people-fill me-2"></i>Family Members ({{ count($familyMembers) }})
                    </h5>
                </div>
                <div class="card-body">
                    @if($familyMembers && count($familyMembers) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Name</th>
                                        <th>Gender</th>
                                        <th>Age</th>
                                        <th>Civil Status</th>
                                        <th>Contact</th>
                                        <th>Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($familyMembers as $member)
                                        <tr class="{{ $member['id'] === $resident['id'] ? 'table-info' : '' }}">
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($member['profile_image'])
                                                        <img src="{{ asset('storage/' . $member['profile_image']) }}" 
                                                             alt="{{ $member['first_name'] }}" 
                                                             class="rounded-circle me-2" 
                                                             width="32" 
                                                             height="32"
                                                             style="object-fit: cover;">
                                                    @else
                                                        <div class="rounded-circle bg-secondary me-2 d-flex align-items-center justify-content-center" 
                                                             style="width: 32px; height: 32px;">
                                                            <i class="bi bi-person text-white"></i>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <strong>{{ $member['display_name'] }}</strong>
                                                        @if($member['id'] === $resident['id'])
                                                            <br><small class="badge bg-info">You</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @if($member['gender'] === 'Male')
                                                    <span class="badge bg-primary">{{ $member['gender'] }}</span>
                                                @elseif($member['gender'] === 'Female')
                                                    <span class="badge bg-danger">{{ $member['gender'] }}</span>
                                                @else
                                                    {{ $member['gender'] ?? 'N/A' }}
                                                @endif
                                            </td>
                                            <td>{{ $member['age'] ?? 'N/A' }}</td>
                                            <td>{{ $member['civil_status'] ?? 'N/A' }}</td>
                                            <td>
                                                @if($member['contact_number'])
                                                    <a href="tel:{{ $member['contact_number'] }}" class="text-decoration-none">
                                                        {{ $member['contact_number'] }}
                                                    </a>
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($member['email'])
                                                    <a href="mailto:{{ $member['email'] }}" class="text-decoration-none">
                                                        {{ $member['email'] }}
                                                    </a>
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">
                                                <i class="bi bi-inbox"></i> No family members found
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                            <p class="mt-2">No family members found in this clan</p>
                        </div>
                    @endif
                </div>
            </div>
        @else
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="bi bi-info-circle" style="font-size: 2rem; color: #6c757d;"></i>
                    <p class="text-muted mt-3">You are not assigned to a clan yet. Please contact administration for assistance.</p>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
