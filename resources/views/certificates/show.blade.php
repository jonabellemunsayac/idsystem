@extends('layouts.app')

@section('title', 'Certificate Details')

@section('content')
<div class="mb-4">
    <a href="{{ route('certificates.index') }}" class="btn btn-secondary mb-3">
        <i class="bi bi-arrow-left me-2"></i> Back to Certificates
    </a>

    <div class="card">
        <div class="card-body">
            <h3 class="mb-4">{{ $certificate['certificate_type'] }} Certificate</h3>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <p><strong>Certificate ID:</strong></p>
                    <p><code>{{ $certificate['id'] }}</code></p>
                </div>

                <div class="col-md-6 mb-3">
                    <p><strong>Resident:</strong></p>
                    <p>{{ $certificate['resident_name'] }}</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <p><strong>Issued Date:</strong></p>
                    <p>{{ \Carbon\Carbon::parse($certificate['issued_date'])->format('M d, Y') }}</p>
                </div>

                <div class="col-md-6 mb-3">
                    <p><strong>Status:</strong></p>
                    <p>
                        <span class="badge bg-{{ $certificate['status'] === 'active' ? 'success' : 'secondary' }}">
                            {{ ucfirst($certificate['status']) }}
                        </span>
                    </p>
                </div>
            </div>

            @if($certificate['remarks'])
            <div class="mb-3">
                <p><strong>Remarks:</strong></p>
                <p>{{ $certificate['remarks'] }}</p>
            </div>
            @endif

            <div class="mb-3">
                <p><strong>Created:</strong></p>
                <p>{{ \Carbon\Carbon::parse($certificate['created_at'])->format('M d, Y H:i A') }}</p>
            </div>

            <hr>

            <div class="mt-4">
                <form action="{{ route('certificates.destroy', $certificate['id']) }}" method="POST" style="display: inline;">
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
