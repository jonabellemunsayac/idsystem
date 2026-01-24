@extends('layouts.app')

@section('title', 'Blotter Records')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h4 fw-bold text-dark mb-1">Blotter Records</h1>
        <p class="text-muted mb-0">Track and manage incident reports</p>
    </div>
    <button class="btn btn-primary d-flex align-items-center gap-1" style="background-color: #0038A8; border-color: #0038A8; padding: 0.5rem 1rem; font-size: 0.95rem;" data-bs-toggle="modal" data-bs-target="#newCaseModal">
        <i class="bi bi-plus-lg"></i> Case
    </button>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-1 border-bottom-0">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-1">
            <h6 class="card-title mb-0 fw-bold small" style="font-size: 0.8rem;">Blotter Cases</h6>
            <div class="d-flex gap-1 flex-wrap">
                <form method="GET" action="{{ route('blotter.index') }}" class="d-flex gap-1">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-white border-end-0" style="font-size: 0.8rem;">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" name="search" class="form-control form-control-sm border-start-0 ps-0" placeholder="Search..." value="{{ request('search') }}" style="width: 150px; font-size: 0.8rem;">
                        <button class="btn btn-light btn-sm border" type="submit" style="font-size: 0.75rem;">Search</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size: 0.75rem;">
                <thead class="bg-light">
                    <tr>
                        <th class="border-0 text-secondary text-uppercase fw-bold ps-2" style="font-size: 0.65rem;">Case ID</th>
                        <th class="border-0 text-secondary text-uppercase fw-bold" style="font-size: 0.65rem;">Type</th>
                        <th class="border-0 text-secondary text-uppercase fw-bold" style="font-size: 0.65rem;">Complainant</th>
                        <th class="border-0 text-secondary text-uppercase fw-bold" style="font-size: 0.65rem;">Location</th>
                        <th class="border-0 text-secondary text-uppercase fw-bold" style="font-size: 0.65rem;">Date</th>
                        <th class="border-0 text-secondary text-uppercase fw-bold" style="font-size: 0.65rem;">Severity</th>
                        <th class="border-0 text-secondary text-uppercase fw-bold" style="font-size: 0.65rem;">Status</th>
                        <th class="border-0 text-secondary text-uppercase fw-bold text-end pe-2" style="font-size: 0.65rem;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cases as $case)
                    <tr style="font-size: 0.75rem;">
                        <td class="ps-2">
                            <div class="fw-medium text-dark" style="font-size: 0.75rem;">{{ $case->case_number }}</div>
                        </td>
                        <td style="font-size: 0.7rem;">{{ ucfirst(str_replace('-', ' ', $case->incident_type ?? '')) }}</td>
                        <td style="font-size: 0.7rem;">{{ $case->complainant_name ?? '-' }}</td>
                        <td style="font-size: 0.7rem; max-width: 120px;">{{ $case->location ?? '-' }}</td>
                        <td style="font-size: 0.7rem;">{{ $case->incident_date ? $case->incident_date->format('m/d/Y') : '-' }}</td>
                        <td style="font-size: 0.7rem;">
                            @if($case->severity === 'low')
                                <span class="badge bg-info text-dark" style="font-size: 0.65rem;">Low</span>
                            @elseif($case->severity === 'medium')
                                <span class="badge bg-warning text-dark" style="font-size: 0.65rem;">Medium</span>
                            @elseif($case->severity === 'high')
                                <span class="badge bg-danger" style="font-size: 0.65rem;">High</span>
                            @elseif($case->severity === 'critical')
                                <span class="badge bg-danger" style="font-size: 0.65rem;">Critical</span>
                            @endif
                        </td>
                        <td style="font-size: 0.7rem;">
                            @if($case->status === 'pending')
                                <span class="badge bg-warning text-dark" style="font-size: 0.65rem;">Pending</span>
                            @elseif($case->status === 'investigating')
                                <span class="badge bg-primary" style="font-size: 0.65rem;">Investigating</span>
                            @elseif($case->status === 'resolved')
                                <span class="badge bg-success" style="font-size: 0.65rem;">Resolved</span>
                            @endif
                        </td>
                        <td class="text-end pe-2">
                            <div class="dropdown">
                                <button class="btn btn-light btn-sm border dropdown-toggle" type="button" data-bs-toggle="dropdown" style="font-size: 0.65rem; padding: 0.2rem 0.4rem;">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><button class="dropdown-item" onclick="viewCaseDetails({{ $case->id }})" style="font-size: 0.75rem;">View Details</button></li>
                                    <li><hr class="dropdown-divider m-1"></li>
                                    <li><button class="dropdown-item text-danger" onclick="deleteCase({{ $case->id }})" style="font-size: 0.75rem;">Delete</button></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-2 text-muted">
                            <i class="bi bi-inbox" style="font-size: 1.5rem; opacity: 0.5;"></i>
                            <p class="mt-1 small" style="font-size: 0.75rem;">No cases found.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($cases->hasPages())
    <div class="card-footer bg-white border-top-0 py-2">
        <div style="font-size: 0.875rem;">
            {{ $cases->links('vendor.pagination.custom') }}
        </div>
    </div>
    @endif
</div>

<!-- New Case Modal -->
<div class="modal fade" id="newCaseModal" tabindex="-1" aria-labelledby="newCaseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-white border-bottom" style="border-color: #dee2e6 !important;">
                <div>
                    <h5 class="modal-title fw-bold text-dark" id="newCaseModalLabel">Create New Case</h5>
                    <p class="text-muted small mb-0">Record a new incident or complaint</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="newCaseForm">
                    <!-- Case ID (Auto-generated) -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="caseId" class="form-label fw-bold text-dark">Case ID</label>
                            <input type="text" class="form-control" id="caseId" placeholder="Auto-generated" disabled style="background-color: #f8f9fa;">
                        </div>
                        <div class="col-md-6">
                            <label for="caseDate" class="form-label fw-bold text-dark">Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="caseDate" required>
                        </div>
                    </div>

                    <!-- Case Type -->
                    <div class="mb-3">
                        <label for="caseType" class="form-label fw-bold text-dark">Incident Type <span class="text-danger">*</span></label>
                        <select class="form-select" id="caseType" required>
                            <option value="">-- Select Incident Type --</option>
                            <option value="noise-complaint">Noise Complaint</option>
                            <option value="property-dispute">Property Dispute</option>
                            <option value="theft">Theft</option>
                            <option value="vandalism">Vandalism</option>
                            <option value="assault">Assault</option>
                            <option value="trespassing">Trespassing</option>
                            <option value="disturbance">Disturbance</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <!-- Complainant Information -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="complainantName" class="form-label fw-bold text-dark">Complainant Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="complainantName" placeholder="Full name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="complainantContact" class="form-label fw-bold text-dark">Contact Number</label>
                            <input type="tel" class="form-control" id="complainantContact" placeholder="(+63) XXX-XXX-XXXX">
                        </div>
                    </div>

                    <!-- Respondent/Accused Information -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="respondentName" class="form-label fw-bold text-dark">Respondent/Accused</label>
                            <input type="text" class="form-control" id="respondentName" placeholder="Full name or description">
                        </div>
                        <div class="col-md-6">
                            <label for="respondentContact" class="form-label fw-bold text-dark">Respondent Contact</label>
                            <input type="tel" class="form-control" id="respondentContact" placeholder="(+63) XXX-XXX-XXXX">
                        </div>
                    </div>

                    <!-- Incident Details -->
                    <div class="mb-3">
                        <label for="incidentLocation" class="form-label fw-bold text-dark">Location of Incident <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="incidentLocation" placeholder="e.g., Barangay Kalawaan, Pasig City" required>
                    </div>

                    <!-- Incident Description -->
                    <div class="mb-3">
                        <label for="incidentDescription" class="form-label fw-bold text-dark">Incident Description <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="incidentDescription" rows="4" placeholder="Detailed account of the incident" required></textarea>
                    </div>

                    <!-- Severity Level -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="severityLevel" class="form-label fw-bold text-dark">Severity Level <span class="text-danger">*</span></label>
                            <select class="form-select" id="severityLevel" required>
                                <option value="">-- Select Severity --</option>
                                <option value="low">Low</option>
                                <option value="medium">Medium</option>
                                <option value="high">High</option>
                                <option value="critical">Critical</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="witnesses" class="form-label fw-bold text-dark">Number of Witnesses</label>
                            <input type="number" class="form-control" id="witnesses" placeholder="0" min="0">
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="mb-3">
                        <label for="caseStatus" class="form-label fw-bold text-dark">Initial Status <span class="text-danger">*</span></label>
                        <select class="form-select" id="caseStatus" required>
                            <option value="pending">Pending</option>
                            <option value="investigating">Investigating</option>
                            <option value="resolved">Resolved</option>
                        </select>
                    </div>

                    <!-- Notes -->
                    <div class="mb-3">
                        <label for="additionalNotes" class="form-label fw-bold text-dark">Additional Notes</label>
                        <textarea class="form-control" id="additionalNotes" rows="3" placeholder="Any additional information..."></textarea>
                    </div>

                    <!-- Form Actions in Modal Footer -->
                </form>
            </div>
            <div class="modal-footer bg-light border-top p-3">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" style="background-color: #0038A8; border-color: #0038A8;" id="submitCaseBtn">
                    <i class="bi bi-plus-circle me-2"></i>Create Case
                </button>
            </div>
        </div>
    </div>
</div>

<!-- View Case Details Modal -->
<div class="modal fade" id="viewCaseDetailsModal" tabindex="-1" aria-labelledby="viewCaseDetailsLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-white border-bottom" style="border-color: #dee2e6 !important;">
                <div>
                    <h5 class="modal-title fw-bold text-dark" id="viewCaseDetailsLabel">Case Details</h5>
                    <p class="text-muted small mb-0" id="caseIdDisplay"></p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4" id="caseDetailsContent">
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light border-top p-3">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" style="background-color: #0038A8; border-color: #0038A8;" id="editCaseBtn" onclick="toggleCaseEditMode()">
                    <i class="bi bi-pencil-square me-2"></i>Edit Status
                </button>
                <button type="button" class="btn btn-success" id="saveCaseBtn" style="display: none;" onclick="saveCaseStatus()">
                    <i class="bi bi-check-circle me-2"></i>Save
                </button>
                <button type="button" class="btn btn-outline-secondary" id="cancelCaseBtn" style="display: none;" onclick="toggleCaseEditMode()">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    async function viewCaseDetails(caseId) {
        currentCaseId = caseId;
        try {
            const response = await fetch(`/api/blotter/${caseId}`);
            const data = await response.json();
            
            if (data.success) {
                const caseData = data.data;
                currentCaseStatus = caseData.status;
                const contentDiv = document.getElementById('caseDetailsContent');
                
                let severityBadge = '';
                if (caseData.severity === 'low') {
                    severityBadge = '<span class="badge bg-light text-dark border rounded-pill px-3">low</span>';
                } else if (caseData.severity === 'medium') {
                    severityBadge = '<span class="badge bg-warning text-dark rounded-pill px-3">medium</span>';
                } else if (caseData.severity === 'high') {
                    severityBadge = '<span class="badge bg-danger rounded-pill px-3">high</span>';
                } else if (caseData.severity === 'critical') {
                    severityBadge = '<span class="badge bg-danger rounded-pill px-3">critical</span>';
                } else {
                    severityBadge = `<span class="badge bg-secondary rounded-pill px-3">${caseData.severity}</span>`;
                }
                
                let statusBadge = '';
                if (caseData.status === 'pending') {
                    statusBadge = '<span class="badge bg-warning text-dark rounded-pill px-3">pending</span>';
                } else if (caseData.status === 'investigating') {
                    statusBadge = '<span class="badge bg-primary rounded-pill px-3">investigating</span>';
                } else if (caseData.status === 'resolved') {
                    statusBadge = '<span class="badge bg-success rounded-pill px-3">resolved</span>';
                } else {
                    statusBadge = `<span class="badge bg-secondary rounded-pill px-3">${caseData.status}</span>`;
                }
                
                contentDiv.innerHTML = `
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted small fw-bold text-uppercase mb-2">Incident Type</h6>
                            <p class="fw-bold text-dark">${caseData.incident_type.replace(/-/g, ' ').toUpperCase()}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted small fw-bold text-uppercase mb-2">Severity</h6>
                            <p>${severityBadge}</p>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted small fw-bold text-uppercase mb-2">Status</h6>
                            <div class="status-display" id="statusDisplay">
                                <p>${statusBadge}</p>
                            </div>
                            <div class="status-edit" id="statusEdit" style="display: none;">
                                <select class="form-select form-select-sm" id="caseStatusSelect">
                                    <option value="pending" ${caseData.status === 'pending' ? 'selected' : ''}>Pending</option>
                                    <option value="investigating" ${caseData.status === 'investigating' ? 'selected' : ''}>Investigating</option>
                                    <option value="resolved" ${caseData.status === 'resolved' ? 'selected' : ''}>Resolved</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted small fw-bold text-uppercase mb-2">Incident Date</h6>
                            <p class="fw-bold text-dark">${caseData.incident_date.split('T')[0]}</p>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted small fw-bold text-uppercase mb-2">Complainant</h6>
                            <p class="fw-bold text-dark">${caseData.complainant_name}</p>
                            ${caseData.complainant_contact ? `<p class="text-muted small">${caseData.complainant_contact}</p>` : ''}
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted small fw-bold text-uppercase mb-2">Respondent/Accused</h6>
                            <p class="fw-bold text-dark">${caseData.respondent_name || 'N/A'}</p>
                            ${caseData.respondent_contact ? `<p class="text-muted small">${caseData.respondent_contact}</p>` : ''}
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <h6 class="text-muted small fw-bold text-uppercase mb-2">Location</h6>
                        <p class="fw-bold text-dark">${caseData.incident_location}</p>
                    </div>
                    
                    <div class="mb-4">
                        <h6 class="text-muted small fw-bold text-uppercase mb-2">Details</h6>
                        <p class="text-dark">${caseData.details}</p>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted small fw-bold text-uppercase mb-2">Witnesses</h6>
                            <p class="fw-bold text-dark">${caseData.witnesses || 0}</p>
                        </div>
                    </div>
                    
                    ${caseData.notes ? `
                    <div class="mb-4">
                        <h6 class="text-muted small fw-bold text-uppercase mb-2">Notes</h6>
                        <p class="text-dark">${caseData.notes}</p>
                    </div>
                    ` : ''}
                `;
                
                document.getElementById('caseIdDisplay').textContent = caseData.case_number;
                
                // Reset edit mode
                document.getElementById('statusDisplay').style.display = 'block';
                document.getElementById('statusEdit').style.display = 'none';
                document.getElementById('editCaseBtn').style.display = 'block';
                document.getElementById('saveCaseBtn').style.display = 'none';
                document.getElementById('cancelCaseBtn').style.display = 'none';
                
                const modal = new bootstrap.Modal(document.getElementById('viewCaseDetailsModal'));
                modal.show();
            }
        } catch (error) {
            console.error('Error fetching case details:', error);
            alert('Error loading case details');
        }
    }

    function toggleCaseEditMode() {
        const statusDisplay = document.getElementById('statusDisplay');
        const statusEdit = document.getElementById('statusEdit');
        const editBtn = document.getElementById('editCaseBtn');
        const saveBtn = document.getElementById('saveCaseBtn');
        const cancelBtn = document.getElementById('cancelCaseBtn');
        
        if (statusDisplay.style.display === 'none') {
            // Switching to view mode
            statusDisplay.style.display = 'block';
            statusEdit.style.display = 'none';
            editBtn.style.display = 'block';
            saveBtn.style.display = 'none';
            cancelBtn.style.display = 'none';
        } else {
            // Switching to edit mode
            statusDisplay.style.display = 'none';
            statusEdit.style.display = 'block';
            editBtn.style.display = 'none';
            saveBtn.style.display = 'block';
            cancelBtn.style.display = 'block';
        }
    }

    let currentCaseId = null;
    let currentCaseStatus = null;

    async function saveCaseStatus() {
        const newStatus = document.getElementById('caseStatusSelect').value;
        const saveBtn = document.getElementById('saveCaseBtn');
        
        saveBtn.disabled = true;
        saveBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Saving...';
        
        try {
            const response = await fetch(`/blotter/${currentCaseId}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ status: newStatus })
            });
            
            const data = await response.json();
            
            if (data.success) {
                currentCaseStatus = newStatus;
                
                // Show success message
                const alertDiv = document.createElement('div');
                alertDiv.className = 'alert alert-success alert-dismissible fade show';
                alertDiv.setAttribute('role', 'alert');
                alertDiv.innerHTML = `
                    <strong><i class="bi bi-check-circle me-2"></i>Success!</strong> Case status updated successfully
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                `;
                const mainContent = document.querySelector('.main-content');
                if (mainContent) {
                    mainContent.insertBefore(alertDiv, mainContent.firstChild);
                }
                
                // Reload case details
                viewCaseDetails(currentCaseId);
                
                // Reload page data after 2 seconds
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            } else {
                alert('Error: ' + (data.message || 'Failed to update status'));
            }
        } catch (error) {
            console.error('Error updating case status:', error);
            alert('Error updating case status: ' + error.message);
        } finally {
            saveBtn.disabled = false;
            saveBtn.innerHTML = '<i class="bi bi-check-circle me-2"></i>Save';
        }
    }
</script>

<script>
    // Set today's date as default
    document.addEventListener('DOMContentLoaded', function() {
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('caseDate').value = today;
        
        // Generate sample Case ID
        const caseNumber = String(Math.floor(Math.random() * 1000000)).padStart(6, '0');
        document.getElementById('caseId').value = 'BLT-' + caseNumber;
    });

    // Handle form submission
    document.getElementById('submitCaseBtn').addEventListener('click', function(e) {
        e.preventDefault();
        const form = document.getElementById('newCaseForm');
        
        if (form.checkValidity() === false) {
            e.preventDefault();
            e.stopPropagation();
            form.classList.add('was-validated');
            return;
        }

        // Collect form data
        const caseData = {
            case_id: document.getElementById('caseId').value,
            date: document.getElementById('caseDate').value,
            type: document.getElementById('caseType').value,
            complainant_name: document.getElementById('complainantName').value,
            complainant_contact: document.getElementById('complainantContact').value,
            respondent_name: document.getElementById('respondentName').value,
            respondent_contact: document.getElementById('respondentContact').value,
            location: document.getElementById('incidentLocation').value,
            description: document.getElementById('incidentDescription').value,
            severity: document.getElementById('severityLevel').value,
            witnesses: document.getElementById('witnesses').value,
            status: document.getElementById('caseStatus').value,
            notes: document.getElementById('additionalNotes').value
        };

        // Disable submit button and show loading state
        const submitBtn = this;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Creating...';

        // Send data to backend
        fetch('/blotter', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(caseData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message
                const alertDiv = document.createElement('div');
                alertDiv.className = 'alert alert-success alert-dismissible fade show';
                alertDiv.setAttribute('role', 'alert');
                alertDiv.innerHTML = `
                    <strong><i class="bi bi-check-circle me-2"></i>Success!</strong> Case created successfully - ${data.data.case_number}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                `;
                const mainContent = document.querySelector('.main-content');
                if (mainContent) {
                    mainContent.insertBefore(alertDiv, mainContent.firstChild);
                }

                // Close modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('newCaseModal'));
                modal.hide();

                // Reset form
                form.classList.remove('was-validated');
                form.reset();

                // Reload page after 2 seconds to show new case
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            } else {
                alert('Error: ' + (data.message || 'Failed to create case'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error creating case: ' + error.message);
        })
        .finally(() => {
            // Re-enable submit button
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="bi bi-plus-circle me-2"></i>Create Case';
        });
    });
</script>
@endsection