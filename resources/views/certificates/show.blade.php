@extends('layouts.app')

@section('title', 'Certificate Details')

@section('extra-styles')
<style>
    @media print {
        body * { visibility: hidden; }
        #certificateContent, #certificateContent * { visibility: visible; }
        #certificateContent { position: absolute; left: 0; top: 0; width: 100%; }
        .no-print { display: none !important; }
        .cert-editable { color: #000; font-weight: normal; background: transparent !important; }
    }
    .certificate-display { background: white; padding: 40px; border: 1px solid #e5e7eb; border-radius: 8px; margin: 20px 0; overflow-x: auto; }
    .certificate-display .cert-editable { pointer-events: none; color: #000; font-weight: normal; }

    /* ===== Mobile Responsive ===== */
    @media (max-width: 768px) {
        .certificate-display { padding: 16px; margin: 12px 0; }
        .card-body { padding: 16px; }
        .card-body h3 { font-size: 18px; }
        .btn { font-size: 13px; padding: 8px 12px; }
    }
</style>
@endsection

@section('content')
<div class="mb-4 no-print">
    <a href="{{ route('certificates.index') }}" class="btn btn-secondary mb-3">
        <i class="bi bi-arrow-left me-2"></i> Back to Certificates
    </a>

    @if($certificate['content'])
    <button onclick="window.print()" class="btn btn-primary mb-3 ms-2">
        <i class="bi bi-printer me-2"></i> Print Certificate
    </button>
    @endif

    <div class="card">
        <div class="card-body">
            <h3 class="mb-4">{{ ucfirst(str_replace('_', ' ', $certificate['type'])) }} Certificate</h3>

            @if($certificate['content'])
            <div class="certificate-display" id="certificateContent">
                {!! $certificate['content'] !!}
            </div>
            <hr>
            @endif

            <div class="row">
                <div class="col-md-6 mb-3">
                    <p><strong>Resident:</strong></p>
                    <p>{{ $certificate['resident_name'] }}</p>
                </div>

                <div class="col-md-6 mb-3">
                    <p><strong>Status:</strong></p>
                    <p>
                        <span class="badge bg-{{ $certificate['status'] === 'approved' ? 'success' : ($certificate['status'] === 'pending' ? 'warning' : ($certificate['status'] === 'rejected' ? 'danger' : 'secondary')) }}">
                            {{ ucfirst($certificate['status']) }}
                        </span>
                    </p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <p><strong>Purpose:</strong></p>
                    <p>{{ $certificate['purpose'] }}</p>
                </div>

                <div class="col-md-6 mb-3">
                    <p><strong>Pickup/Delivery:</strong></p>
                    <p>{{ ucfirst($certificate['pickup_or_delivery']) }}</p>
                </div>
            </div>

            @if($certificate['purpose_details'])
            <div class="mb-3">
                <p><strong>Purpose Details:</strong></p>
                <p>{{ $certificate['purpose_details'] }}</p>
            </div>
            @endif

            @if($certificate['delivery_address'])
            <div class="mb-3">
                <p><strong>Delivery Address:</strong></p>
                <p>{{ $certificate['delivery_address'] }}</p>
            </div>
            @endif

            @if($certificate['notes'])
            <div class="mb-3">
                <p><strong>Notes:</strong></p>
                <p>{{ $certificate['notes'] }}</p>
            </div>
            @endif

            @if($certificate['rejection_reason'])
            <div class="mb-3">
                <p><strong>Rejection Reason:</strong></p>
                <p class="text-danger">{{ $certificate['rejection_reason'] }}</p>
            </div>
            @endif

            <div class="row">
                @if($certificate['approved_date'])
                <div class="col-md-6 mb-3">
                    <p><strong>Approved Date:</strong></p>
                    <p>{{ \Carbon\Carbon::parse($certificate['approved_date'])->format('M d, Y') }}</p>
                </div>
                @endif

                @if($certificate['released_date'])
                <div class="col-md-6 mb-3">
                    <p><strong>Released Date:</strong></p>
                    <p>{{ \Carbon\Carbon::parse($certificate['released_date'])->format('M d, Y') }}</p>
                </div>
                @endif
            </div>

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
