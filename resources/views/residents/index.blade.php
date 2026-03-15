@extends('layouts.app')

@section('title', 'Residents')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h4 fw-bold text-dark mb-1">Resident Management</h1>
        <p class="text-muted mb-0">Manage and view all resident records</p>
    </div>
    <a href="{{ route('residents.create') }}" class="btn btn-primary d-flex align-items-center gap-1" style="background-color: #0038A8; border-color: #0038A8; padding: 0.5rem 1rem; font-size: 0.95rem;">
        <i class="bi bi-plus-lg"></i> Add
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-1 border-bottom-0">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-1">
            <h6 class="card-title mb-0 fw-bold small" style="font-size: 0.8rem;">Resident Records</h6>
                    <div class="d-flex gap-1 flex-wrap">
                <div class="d-flex gap-1">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-white border-end-0" style="font-size: 0.8rem;">
                            <span id="resident-search-icon"><i class="bi bi-search text-muted"></i></span>
                        </span>
                        <input type="text" id="resident-search" class="form-control form-control-sm border-start-0 ps-0" placeholder="Search..." autocomplete="off" style="width: 150px; font-size: 0.8rem;">
                    </div>
                </div>
                <a href="{{ route('residents.export') }}" class="btn btn-light btn-sm border" style="font-size: 0.75rem;" title="Export to Excel"><i class="bi bi-download"></i> Export</a>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size: 0.75rem;">
                <thead class="bg-light">
                    <tr>
                        <th class="border-0 text-secondary text-uppercase fw-bold ps-2" style="font-size: 0.65rem;">Name</th>
                        <th class="border-0 text-secondary text-uppercase fw-bold" style="font-size: 0.65rem;">Address</th>
                        <th class="border-0 text-secondary text-uppercase fw-bold" style="font-size: 0.65rem;">Contact</th>
                        <th class="border-0 text-secondary text-uppercase fw-bold" style="font-size: 0.65rem;">Email</th>
                        <th class="border-0 text-secondary text-uppercase fw-bold" style="font-size: 0.65rem;">DOB</th>
                        <th class="border-0 text-secondary text-uppercase fw-bold" style="font-size: 0.65rem;">Age</th>
                        <th class="border-0 text-secondary text-uppercase fw-bold" style="font-size: 0.65rem;">Gender</th>
                        <th class="border-0 text-secondary text-uppercase fw-bold" style="font-size: 0.65rem;">Status</th>
                        <th class="border-0 text-secondary text-uppercase fw-bold text-end pe-2" style="font-size: 0.65rem;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($residents as $resident)
                    <tr style="font-size: 0.75rem;">
                        <td class="ps-2">
                            <div class="fw-medium text-dark" style="font-size: 0.75rem;">{{ $resident['first_name'] }} {{ $resident['last_name'] }}</div>
                        </td>
                        <td class="text-muted" style="max-width: 150px; font-size: 0.7rem;">
                            {{ isset($resident['address']) && !empty($resident['address']) ? $resident['address'] : '-' }}
                        </td>
                        <td style="font-size: 0.7rem;">{{ substr($resident['contact_number'], 0, 10) ?? '-' }}</td>
                        <td style="font-size: 0.7rem;">{{ $resident['email'] ? substr($resident['email'], 0, 18) . '...' : '-' }}</td>
                        <td style="font-size: 0.7rem;">{{ \Carbon\Carbon::parse($resident['birth_date'])->format('m/d/Y') }}</td>
                        <td style="font-size: 0.7rem;">{{ \Carbon\Carbon::parse($resident['birth_date'])->age }}</td>
                        <td style="font-size: 0.7rem;">{{ substr($resident['gender'], 0, 1) }}</td>
                        <td style="font-size: 0.7rem;">{{ $resident['civil_status'] }}</td>
                        <td class="text-end pe-2">
                            <div class="dropdown">
                                <button class="btn btn-light btn-sm border dropdown-toggle" type="button" data-bs-toggle="dropdown" style="font-size: 0.65rem; padding: 0.2rem 0.4rem;">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="{{ route('residents.show', $resident['id']) }}" style="font-size: 0.75rem;">View Details</a></li>
                                    <li><a class="dropdown-item" href="{{ route('residents.edit', $resident['id']) }}" style="font-size: 0.75rem;">Edit Record</a></li>
                                    <li><hr class="dropdown-divider m-1"></li>
                                    <li>
                                        <form action="{{ route('residents.destroy', $resident['id']) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger" style="font-size: 0.75rem;">Delete</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-2 text-muted">
                            <i class="bi bi-people" style="font-size: 1.5rem; opacity: 0.5;"></i>
                            <p class="mt-1 small" style="font-size: 0.75rem;">No residents found.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($residents->hasPages())
    <div class="card-footer bg-white border-top-0 py-2">
        <div style="font-size: 0.875rem;">
            {{ $residents->links('vendor.pagination.custom') }}
        </div>
    </div>
    @endif
</div>
@endsection

@section('extra-scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput  = document.getElementById('resident-search');
    const searchIcon   = document.getElementById('resident-search-icon');
    const tbody        = document.querySelector('.table tbody');
    const pagination   = document.querySelector('.card-footer');
    const searchUrl    = '{{ route('residents.search') }}';

    // Row builders ─ mirrors the Blade table columns exactly
    function buildRows(residents) {
        if (residents.length === 0) {
            return `<tr>
                <td colspan="9" class="text-center py-2 text-muted">
                    <i class="bi bi-people" style="font-size:1.5rem;opacity:0.5;"></i>
                    <p class="mt-1 small" style="font-size:0.75rem;">No residents found.</p>
                </td>
            </tr>`;
        }

        return residents.map(r => {
            const dob     = r.birth_date ? new Date(r.birth_date) : null;
            const dobFmt  = dob ? (dob.getMonth()+1).toString().padStart(2,'0') + '/' +
                                  dob.getDate().toString().padStart(2,'0') + '/' +
                                  dob.getFullYear() : '-';
            const age     = dob ? (new Date().getFullYear() - dob.getFullYear() -
                            (new Date() < new Date(new Date().getFullYear(), dob.getMonth(), dob.getDate()) ? 1 : 0)) : '-';
            const email   = r.email ? (r.email.length > 18 ? r.email.substring(0, 18) + '...' : r.email) : '-';
            const contact = r.contact_number ? r.contact_number.substring(0, 10) : '-';
            const address = r.address || '-';
            const gender  = r.gender ? r.gender.charAt(0) : '-';
            const status  = r.civil_status || '-';
            const editUrl = `/residents/${r.id}/edit`;
            const showUrl = `/residents/${r.id}`;

            return `<tr style="font-size:0.75rem;">
                <td class="ps-2">
                    <div class="fw-medium text-dark" style="font-size:0.75rem;">${r.first_name} ${r.last_name}</div>
                </td>
                <td class="text-muted" style="max-width:150px;font-size:0.7rem;">${address}</td>
                <td style="font-size:0.7rem;">${contact}</td>
                <td style="font-size:0.7rem;">${email}</td>
                <td style="font-size:0.7rem;">${dobFmt}</td>
                <td style="font-size:0.7rem;">${age}</td>
                <td style="font-size:0.7rem;">${gender}</td>
                <td style="font-size:0.7rem;">${status}</td>
                <td class="text-end pe-2">
                    <div class="dropdown">
                        <button class="btn btn-light btn-sm border dropdown-toggle" type="button"
                                data-bs-toggle="dropdown" style="font-size:0.65rem;padding:0.2rem 0.4rem;">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="${showUrl}" style="font-size:0.75rem;">View Details</a></li>
                            <li><a class="dropdown-item" href="${editUrl}" style="font-size:0.75rem;">Edit Record</a></li>
                            <li><hr class="dropdown-divider m-1"></li>
                            <li>
                                <form action="/residents/${r.id}" method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item text-danger"
                                            style="font-size:0.75rem;">Delete</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>`;
        }).join('');
    }

    let debounceTimer;

    searchInput.addEventListener('input', function () {
        const q = this.value.trim();
        clearTimeout(debounceTimer);

        // If cleared, reload page to restore paginated full list
        if (q === '') {
            window.location.href = '{{ route('residents.index') }}';
            return;
        }

        // Show spinner
        searchIcon.innerHTML = '<span class="spinner-border spinner-border-sm text-muted" role="status" style="width:0.75rem;height:0.75rem;"></span>';

        debounceTimer = setTimeout(() => {
            fetch(`${searchUrl}?q=${encodeURIComponent(q)}`)
                .then(res => res.json())
                .then(data => {
                    tbody.innerHTML = buildRows(data.residents);
                    // Hide pagination while searching
                    if (pagination) pagination.style.display = 'none';
                })
                .catch(() => {})
                .finally(() => {
                    searchIcon.innerHTML = '<i class="bi bi-search text-muted"></i>';
                });
        }, 300);
    });
});
</script>
@endsection
