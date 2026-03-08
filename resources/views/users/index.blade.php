@extends('layouts.app')

@section('title', 'User Management')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h4 fw-bold text-dark mb-1">User Management</h1>
        <p class="text-muted mb-0">Manage staff accounts and their access roles</p>
    </div>
    <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-person-plus-fill me-1"></i> Add User
    </a>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
    <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
    <i class="bi bi-exclamation-circle me-2"></i> {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0 text-dark">Staff Accounts</h5>
        <span class="badge bg-secondary">{{ $users->count() }} users</span>
    </div>
    <div class="card-body px-0 pb-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="px-4 py-2 text-muted small fw-bold text-uppercase">Name</th>
                        <th class="px-4 py-2 text-muted small fw-bold text-uppercase">Username</th>
                        <th class="px-4 py-2 text-muted small fw-bold text-uppercase">Email</th>
                        <th class="px-4 py-2 text-muted small fw-bold text-uppercase">Role</th>
                        <th class="px-4 py-2 text-muted small fw-bold text-uppercase">Created</th>
                        <th class="px-4 py-2 text-muted small fw-bold text-uppercase text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td class="px-4 py-3">
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center"
                                     style="width:34px;height:34px;flex-shrink:0;">
                                    <i class="bi bi-person-fill text-primary" style="font-size:1rem;"></i>
                                </div>
                                <span class="fw-semibold text-dark">{{ $user->name }}</span>
                                @if($user->id === auth()->id())
                                    <span class="badge bg-secondary" style="font-size:0.65rem;">You</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-3 text-muted small">{{ $user->username }}</td>
                        <td class="px-4 py-3 text-muted small">{{ $user->email }}</td>
                        <td class="px-4 py-3">
                            @php
                                $roleColors = [
                                    'superadmin'  => 'danger',
                                    'admin'       => 'primary',
                                    'encoder'     => 'success',
                                    'site_editor' => 'warning',
                                ];
                                $roleLabels = [
                                    'superadmin'  => 'Superadmin',
                                    'admin'       => 'Admin',
                                    'encoder'     => 'Encoder',
                                    'site_editor' => 'Site Editor',
                                ];
                            @endphp
                            <span class="badge bg-{{ $roleColors[$user->role] ?? 'secondary' }}">
                                {{ $roleLabels[$user->role] ?? ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-muted small">{{ $user->created_at->format('M d, Y') }}</td>
                        <td class="px-4 py-3 text-end">
                            <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-outline-secondary me-1">
                                <i class="bi bi-pencil-fill"></i>
                            </a>
                            @if($user->id !== auth()->id())
                            <button type="button" class="btn btn-sm btn-outline-danger"
                                    onclick="confirmDelete({{ $user->id }}, '{{ addslashes($user->name) }}')">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                            <form id="delete-form-{{ $user->id }}"
                                  action="{{ route('users.destroy', $user) }}" method="POST" class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-5">
                            <i class="bi bi-people fs-1 d-block mb-2 opacity-25"></i>
                            No staff users found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Role Reference Card -->
<div class="card border-0 shadow-sm mt-4">
    <div class="card-header bg-white border-0 py-3 px-4">
        <h5 class="fw-bold mb-0 text-dark">Role Permissions Reference</h5>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-3">
                <div class="p-3 rounded border border-success-subtle bg-success-subtle">
                    <span class="badge bg-success mb-2">Encoder</span>
                    <ul class="list-unstyled small mb-0 text-success-emphasis">
                        <li><i class="bi bi-check2 me-1"></i>Resident Records</li>
                        <li><i class="bi bi-check2 me-1"></i>Clan Module</li>
                        <li><i class="bi bi-check2 me-1"></i>ID Management</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3 rounded border border-warning-subtle bg-warning-subtle">
                    <span class="badge bg-warning text-dark mb-2">Site Editor</span>
                    <ul class="list-unstyled small mb-0 text-warning-emphasis">
                        <li><i class="bi bi-check2 me-1"></i>Site Editor</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3 rounded border border-primary-subtle bg-primary-subtle">
                    <span class="badge bg-primary mb-2">Admin</span>
                    <ul class="list-unstyled small mb-0 text-primary-emphasis">
                        <li><i class="bi bi-check2 me-1"></i>All sections</li>
                        <li><i class="bi bi-x me-1"></i>Audit Logs</li>
                        <li><i class="bi bi-x me-1"></i>User Management</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3 rounded border border-danger-subtle bg-danger-subtle">
                    <span class="badge bg-danger mb-2">Superadmin</span>
                    <ul class="list-unstyled small mb-0 text-danger-emphasis">
                        <li><i class="bi bi-check2 me-1"></i>Full access</li>
                        <li><i class="bi bi-check2 me-1"></i>Audit Logs</li>
                        <li><i class="bi bi-check2 me-1"></i>User Management</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
function confirmDelete(userId, userName) {
    Swal.fire({
        title: 'Delete User?',
        html: `Are you sure you want to delete <strong>${userName}</strong>?<br>This action cannot be undone.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete',
        cancelButtonText: 'Cancel',
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + userId).submit();
        }
    });
}
</script>
@endsection
