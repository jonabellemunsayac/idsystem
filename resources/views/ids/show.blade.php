@extends('layouts.app')

@section('title', 'ID Details')

@section('content')
<div class="mb-4">
    <a href="{{ route('ids.index') }}" class="btn btn-secondary mb-3">
        <i class="bi bi-arrow-left me-2"></i> Back to IDs
    </a>

    <div class="card">
        <div class="card-body">
            <h3 class="mb-4">ID Details</h3>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <p><strong>ID Number:</strong></p>
                    <p><code>{{ $id['id_number'] }}</code></p>
                </div>

                <div class="col-md-6 mb-3">
                    <p><strong>Resident:</strong></p>
                    <p>{{ $id['resident_name'] }}</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <p><strong>Issued Date:</strong></p>
                    <p>{{ \Carbon\Carbon::parse($id['issued_date'])->format('M d, Y') }}</p>
                </div>

                <div class="col-md-6 mb-3">
                    <p><strong>Status:</strong></p>
                    <p>
                        <span class="badge bg-{{ $id['status'] === 'active' ? 'success' : 'secondary' }}">
                            {{ ucfirst($id['status']) }}
                        </span>
                    </p>
                </div>
            </div>

            <hr>

            <div class="mt-4">
                <form action="{{ route('ids.destroy', $id['id']) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">
                        <i class="bi bi-trash me-2"></i> Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
