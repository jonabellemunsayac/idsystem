@extends('layouts.app')

@section('title', 'IDs')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 fw-bold text-dark mb-1">Barangay IDs</h1>
        <p class="text-muted mb-0">Manage all resident identification cards</p>
    </div>
    <a href="{{ route('ids.create') }}" class="btn btn-success-custom d-flex align-items-center gap-2">
        <i class="bi bi-plus-lg"></i> Generate ID
    </a>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center bg-white py-3">
        <h5 class="card-title mb-0">ID Records</h5>
        <div class="d-flex gap-2">
            <form method="GET" action="{{ route('ids.index') }}" class="d-flex gap-2">
                <div class="position-relative">
                    <i class="bi bi-search position-absolute text-muted" style="left: 10px; top: 50%; transform: translateY(-50%); font-size: 0.875rem;"></i>
                    <input type="text" name="search" class="form-control ps-4" placeholder="Search IDs..." value="{{ request('search') }}" style="width: 250px;">
                </div>
            </form>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>ID Number</th>
                        <th>Resident Name</th>
                        <th>Type</th>
                        <th>Issued Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ids as $id)
                    <tr>
                        <td>
                            <span class="font-monospace bg-light px-2 py-1 rounded border">{{ $id['id_number'] }}</span>
                        </td>
                        <td class="fw-medium text-primary">{{ $id['resident']['first_name'] }} {{ $id['resident']['last_name'] }}</td>
                        <td>{{ $id['type'] ?? 'Regular' }}</td>
                        <td>{{ \Carbon\Carbon::parse($id['issued_at'])->format('M d, Y') }}</td>
                        <td>
                            @if($id['status'] === 'active')
                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2">Active</span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill px-2">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('ids.show', $id['id']) }}" class="btn btn-sm btn-primary" title="View">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                <a href="{{ route('ids.edit', $id['id']) }}" class="btn btn-sm btn-secondary" title="Edit">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('ids.destroy', $id['id']) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this ID?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            No IDs found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($ids->hasPages())
    <div class="card-footer bg-white border-top-0 py-3">
        {{ $ids->links() }}
    </div>
    @endif
</div>
@endsection