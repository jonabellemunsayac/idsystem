@extends('layouts.app')

@section('title', 'Assets Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h4 fw-bold text-dark mb-1">Assets Management</h1>
        <p class="text-muted mb-0">Track and manage barangay assets</p>
    </div>
    <button class="btn btn-primary d-flex align-items-center gap-1" style="background-color: #0038A8; border-color: #0038A8; padding: 0.5rem 1rem; font-size: 0.95rem;" data-bs-toggle="modal" data-bs-target="#newAssetModal">
        <i class="bi bi-plus-lg"></i> Add
    </button>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-1 border-bottom-0">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-1">
            <h6 class="card-title mb-0 fw-bold small" style="font-size: 0.8rem;">Asset Inventory</h6>
            <div class="d-flex gap-1 flex-wrap">
                <form method="GET" action="{{ route('assets.index') }}" class="d-flex gap-1">
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
                        <th class="border-0 text-secondary text-uppercase fw-bold ps-2" style="font-size: 0.65rem;">Asset ID</th>
                        <th class="border-0 text-secondary text-uppercase fw-bold" style="font-size: 0.65rem;">Name</th>
                        <th class="border-0 text-secondary text-uppercase fw-bold" style="font-size: 0.65rem;">Category</th>
                        <th class="border-0 text-secondary text-uppercase fw-bold" style="font-size: 0.65rem;">Quantity</th>
                        <th class="border-0 text-secondary text-uppercase fw-bold" style="font-size: 0.65rem;">Location</th>
                        <th class="border-0 text-secondary text-uppercase fw-bold" style="font-size: 0.65rem;">Status</th>
                        <th class="border-0 text-secondary text-uppercase fw-bold text-end pe-2" style="font-size: 0.65rem;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($assets as $asset)
                    <tr style="font-size: 0.75rem;">
                        <td class="ps-2">
                            <div class="fw-medium text-dark" style="font-size: 0.75rem;">AST-{{ str_pad($asset->id, 3, '0', STR_PAD_LEFT) }}</div>
                        </td>
                        <td style="font-size: 0.7rem;">{{ $asset->asset_name ?? '-' }}</td>
                        <td style="font-size: 0.7rem;">{{ $asset->category ?? '-' }}</td>
                        <td style="font-size: 0.7rem;">{{ $asset->quantity ?? '-' }}</td>
                        <td style="font-size: 0.7rem; max-width: 120px;">{{ $asset->location ?? '-' }}</td>
                        <td style="font-size: 0.7rem;">
                            @if($asset->status === 'working')
                                <span class="badge bg-success" style="font-size: 0.65rem;">Working</span>
                            @elseif($asset->status === 'maintenance')
                                <span class="badge bg-warning text-dark" style="font-size: 0.65rem;">Maintenance</span>
                            @elseif($asset->status === 'disposal')
                                <span class="badge bg-danger" style="font-size: 0.65rem;">Disposal</span>
                            @elseif($asset->status === 'inactive')
                                <span class="badge bg-secondary" style="font-size: 0.65rem;">Inactive</span>
                            @endif
                        </td>
                        <td class="text-end pe-2">
                            <div class="dropdown">
                                <button class="btn btn-light btn-sm border dropdown-toggle" type="button" data-bs-toggle="dropdown" style="font-size: 0.65rem; padding: 0.2rem 0.4rem;">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><button class="dropdown-item" onclick="viewAssetDetails({{ $asset->id }})" style="font-size: 0.75rem;">View Details</button></li>
                                    <li><hr class="dropdown-divider m-1"></li>
                                    <li><button class="dropdown-item text-danger" onclick="deleteAsset({{ $asset->id }})" style="font-size: 0.75rem;">Delete</button></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-2 text-muted">
                            <i class="bi bi-inbox" style="font-size: 1.5rem; opacity: 0.5;"></i>
                            <p class="mt-1 small" style="font-size: 0.75rem;">No assets found.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($assets->hasPages())
    <div class="card-footer bg-white border-top-0 py-2">
        <div style="font-size: 0.875rem;">
            {{ $assets->links('vendor.pagination.custom') }}
        </div>
    </div>
    @endif
</div>

<!-- New Asset Modal -->
<div class="modal fade" id="newAssetModal" tabindex="-1" aria-labelledby="newAssetModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-white border-bottom" style="border-color: #dee2e6 !important;">
                <div>
                    <h5 class="modal-title fw-bold text-dark" id="newAssetModalLabel">Add New Asset</h5>
                    <p class="text-muted small mb-0">Register a new asset to the inventory</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="newAssetForm">
                    <!-- Asset Name -->
                    <div class="mb-3">
                        <label for="assetName" class="form-label fw-bold text-dark">Asset Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="assetName" placeholder="e.g., Community Hall Chairs" required>
                    </div>

                    <!-- Category and Quantity -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="assetCategory" class="form-label fw-bold text-dark">Category <span class="text-danger">*</span></label>
                            <select class="form-select" id="assetCategory" required>
                                <option value="">-- Select Category --</option>
                                <option value="Furniture">Furniture</option>
                                <option value="Equipment">Equipment</option>
                                <option value="Electronics">Electronics</option>
                                <option value="Sports">Sports</option>
                                <option value="Tools">Tools</option>
                                <option value="Vehicles">Vehicles</option>
                                <option value="Building">Building</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="assetQuantity" class="form-label fw-bold text-dark">Quantity <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="assetQuantity" placeholder="1" min="1" required>
                        </div>
                    </div>

                    <!-- Acquisition Date and Status -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="acquisitionDate" class="form-label fw-bold text-dark">Acquisition Date</label>
                            <input type="date" class="form-control" id="acquisitionDate">
                        </div>
                        <div class="col-md-6">
                            <label for="assetStatus" class="form-label fw-bold text-dark">Status <span class="text-danger">*</span></label>
                            <select class="form-select" id="assetStatus" required>
                                <option value="working">Working</option>
                                <option value="maintenance">Under Maintenance</option>
                                <option value="disposal">For Disposal</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <!-- Last Maintenance Date -->
                    <div class="mb-3">
                        <label for="lastMaintenance" class="form-label fw-bold text-dark">Last Maintenance Date</label>
                        <input type="date" class="form-control" id="lastMaintenance">
                    </div>

                    <!-- Location -->
                    <div class="mb-3">
                        <label for="assetLocation" class="form-label fw-bold text-dark">Location</label>
                        <input type="text" class="form-control" id="assetLocation" placeholder="e.g., Community Hall, Barangay Office">
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label for="assetDescription" class="form-label fw-bold text-dark">Description</label>
                        <textarea class="form-control" id="assetDescription" rows="3" placeholder="Additional details about the asset..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light border-top p-3">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" style="background-color: #0038A8; border-color: #0038A8;" id="submitAssetBtn">
                    <i class="bi bi-plus-circle me-2"></i>Add Asset
                </button>
            </div>
        </div>
    </div>
</div>

<!-- View Asset Details Modal -->
<div class="modal fade" id="viewAssetDetailsModal" tabindex="-1" aria-labelledby="viewAssetDetailsLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-white border-bottom" style="border-color: #dee2e6 !important;">
                <div>
                    <h5 class="modal-title fw-bold text-dark" id="viewAssetDetailsLabel">Asset Details</h5>
                    <p class="text-muted small mb-0" id="assetIdDisplay"></p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4" id="assetDetailsContent">
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light border-top p-3">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" style="background-color: #0038A8; border-color: #0038A8;" id="editAssetBtn" onclick="toggleAssetEditMode()">
                    <i class="bi bi-pencil-square me-2"></i>Edit Status
                </button>
                <button type="button" class="btn btn-success" id="saveAssetBtn" style="display: none;" onclick="saveAssetStatus()">
                    <i class="bi bi-check-circle me-2"></i>Save
                </button>
                <button type="button" class="btn btn-outline-secondary" id="cancelAssetBtn" style="display: none;" onclick="toggleAssetEditMode()">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let currentAssetId = null;
    let currentAssetStatus = null;

    async function viewAssetDetails(assetId) {
        currentAssetId = assetId;
        try {
            const response = await fetch(`/api/assets/${assetId}`);
            const data = await response.json();
            
            if (data.success) {
                const asset = data.data;
                currentAssetStatus = asset.status;
                const contentDiv = document.getElementById('assetDetailsContent');
                
                let statusBadge = '';
                if (asset.status === 'working') {
                    statusBadge = '<span class="badge bg-success rounded-pill px-3">working</span>';
                } else if (asset.status === 'maintenance') {
                    statusBadge = '<span class="badge bg-warning text-dark rounded-pill px-3">maintenance</span>';
                } else if (asset.status === 'disposal') {
                    statusBadge = '<span class="badge bg-danger rounded-pill px-3">disposal</span>';
                } else {
                    statusBadge = `<span class="badge bg-secondary rounded-pill px-3">${asset.status}</span>`;
                }
                
                contentDiv.innerHTML = `
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted small fw-bold text-uppercase mb-2">Asset Name</h6>
                            <p class="fw-bold text-dark">${asset.asset_name}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted small fw-bold text-uppercase mb-2">Status</h6>
                            <div class="status-display" id="statusDisplay">
                                <p>${statusBadge}</p>
                            </div>
                            <div class="status-edit" id="statusEdit" style="display: none;">
                                <select class="form-select form-select-sm" id="assetStatusSelect">
                                    <option value="working" ${asset.status === 'working' ? 'selected' : ''}>Working</option>
                                    <option value="maintenance" ${asset.status === 'maintenance' ? 'selected' : ''}>Under Maintenance</option>
                                    <option value="disposal" ${asset.status === 'disposal' ? 'selected' : ''}>For Disposal</option>
                                    <option value="inactive" ${asset.status === 'inactive' ? 'selected' : ''}>Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted small fw-bold text-uppercase mb-2">Category</h6>
                            <p class="fw-bold text-dark">${asset.category}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted small fw-bold text-uppercase mb-2">Quantity</h6>
                            <p class="fw-bold text-dark">${asset.quantity}</p>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted small fw-bold text-uppercase mb-2">Acquisition Date</h6>
                            <p class="fw-bold text-dark">${asset.acquisition_date || 'N/A'}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted small fw-bold text-uppercase mb-2">Last Maintenance</h6>
                            <p class="fw-bold text-dark">${asset.last_maintenance_date || 'N/A'}</p>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted small fw-bold text-uppercase mb-2">Location</h6>
                            <p class="fw-bold text-dark">${asset.location || 'N/A'}</p>
                        </div>
                    </div>
                    
                    ${asset.description ? `
                    <div class="mb-4">
                        <h6 class="text-muted small fw-bold text-uppercase mb-2">Description</h6>
                        <p class="text-dark">${asset.description}</p>
                    </div>
                    ` : ''}
                `;
                
                document.getElementById('assetIdDisplay').textContent = `AST-${String(asset.id).padStart(3, '0')}`;
                
                // Reset edit mode
                document.getElementById('statusDisplay').style.display = 'block';
                document.getElementById('statusEdit').style.display = 'none';
                document.getElementById('editAssetBtn').style.display = 'block';
                document.getElementById('saveAssetBtn').style.display = 'none';
                document.getElementById('cancelAssetBtn').style.display = 'none';
                
                const modal = new bootstrap.Modal(document.getElementById('viewAssetDetailsModal'));
                modal.show();
            }
        } catch (error) {
            console.error('Error fetching asset details:', error);
            alert('Error loading asset details');
        }
    }

    function toggleAssetEditMode() {
        const statusDisplay = document.getElementById('statusDisplay');
        const statusEdit = document.getElementById('statusEdit');
        const editBtn = document.getElementById('editAssetBtn');
        const saveBtn = document.getElementById('saveAssetBtn');
        const cancelBtn = document.getElementById('cancelAssetBtn');
        
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

    async function saveAssetStatus() {
        const newStatus = document.getElementById('assetStatusSelect').value;
        const saveBtn = document.getElementById('saveAssetBtn');
        
        saveBtn.disabled = true;
        saveBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Saving...';
        
        try {
            const response = await fetch(`/assets/${currentAssetId}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ status: newStatus })
            });
            
            const data = await response.json();
            
            if (data.success) {
                currentAssetStatus = newStatus;
                
                // Show success message
                const alertDiv = document.createElement('div');
                alertDiv.className = 'alert alert-success alert-dismissible fade show';
                alertDiv.setAttribute('role', 'alert');
                alertDiv.innerHTML = `
                    <strong><i class="bi bi-check-circle me-2"></i>Success!</strong> Asset status updated successfully
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                `;
                const mainContent = document.querySelector('.main-content');
                if (mainContent) {
                    mainContent.insertBefore(alertDiv, mainContent.firstChild);
                }
                
                // Reload asset details
                viewAssetDetails(currentAssetId);
                
                // Reload page data after 2 seconds
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            } else {
                alert('Error: ' + (data.message || 'Failed to update status'));
            }
        } catch (error) {
            console.error('Error updating asset status:', error);
            alert('Error updating asset status: ' + error.message);
        } finally {
            saveBtn.disabled = false;
            saveBtn.innerHTML = '<i class="bi bi-check-circle me-2"></i>Save';
        }
    }
</script>

<script>
    // Handle form submission
    document.getElementById('submitAssetBtn').addEventListener('click', function(e) {
        e.preventDefault();
        const form = document.getElementById('newAssetForm');
        
        if (form.checkValidity() === false) {
            e.preventDefault();
            e.stopPropagation();
            form.classList.add('was-validated');
            return;
        }

        // Collect form data
        const assetData = {
            asset_name: document.getElementById('assetName').value,
            category: document.getElementById('assetCategory').value,
            quantity: document.getElementById('assetQuantity').value,
            acquisition_date: document.getElementById('acquisitionDate').value,
            status: document.getElementById('assetStatus').value,
            last_maintenance_date: document.getElementById('lastMaintenance').value,
            location: document.getElementById('assetLocation').value,
            description: document.getElementById('assetDescription').value
        };

        // Disable submit button and show loading state
        const submitBtn = this;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Adding...';

        // Send data to backend
        fetch('/assets', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(assetData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message
                const alertDiv = document.createElement('div');
                alertDiv.className = 'alert alert-success alert-dismissible fade show';
                alertDiv.setAttribute('role', 'alert');
                alertDiv.innerHTML = `
                    <strong><i class="bi bi-check-circle me-2"></i>Success!</strong> Asset added successfully - ${data.data.asset_name}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                `;
                const mainContent = document.querySelector('.main-content');
                if (mainContent) {
                    mainContent.insertBefore(alertDiv, mainContent.firstChild);
                }

                // Close modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('newAssetModal'));
                modal.hide();

                // Reset form
                form.classList.remove('was-validated');
                form.reset();

                // Reload page after 2 seconds to show new asset
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            } else {
                alert('Error: ' + (data.message || 'Failed to add asset'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error adding asset: ' + error.message);
        })
        .finally(() => {
            // Re-enable submit button
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="bi bi-plus-circle me-2"></i>Add Asset';
        });
    });
</script>
@endsection