@extends('layouts.app')

@section('title', 'Audit Logs')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h4 fw-bold text-dark mb-1">Audit Logs</h1>
        <p class="text-muted mb-0">System activity and administrative changes</p>
    </div>
    <button class="btn btn-primary" style="background-color: #0038A8; border-color: #0038A8; padding: 0.5rem 1rem; font-size: 0.95rem;" onclick="exportLogs()">
        <i class="bi bi-download me-2"></i> Export
    </button>
</div>

<!-- Filters -->
@if(!($viewingUserActivities ?? false))
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <div class="alert alert-info mb-0">
            <i class="bi bi-info-circle me-2"></i>
            <strong>Showing latest activity per user.</strong> Click "View All" to see complete activity history for each user.
        </div>
    </div>
</div>
@else
<div class="mb-4">
    <a href="/audit-logs" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i> Back to Users
    </a>
</div>
@endif

<!-- Audit Logs Table -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0 text-dark">
            @if($viewingUserActivities ?? false)
                Activity History for {{ $logs->first()?->user->name ?? 'User' }}
            @else
                User Activity Summary
            @endif
        </h5>
        <span class="badge bg-secondary">{{ count($logs) }} {{ ($viewingUserActivities ?? false) ? 'entries' : 'users' }}</span>
    </div>
    <div class="card-body px-0 pb-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="px-3 py-2 text-muted small fw-bold text-uppercase">@if($viewingUserActivities ?? false) Timestamp @else User @endif</th>
                        <th class="px-3 py-2 text-muted small fw-bold text-uppercase">Latest Action</th>
                        <th class="px-3 py-2 text-muted small fw-bold text-uppercase">Details</th>
                        <th class="px-3 py-2 text-muted small fw-bold text-uppercase">@if($viewingUserActivities ?? false) Time @else Activity Count @endif</th>
                        <th class="px-3 py-2 text-muted small fw-bold text-uppercase text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                    @php
                        if (!$log) continue;
                        
                        $actionColor = match($log->action) {
                            'created' => 'success',
                            'updated' => 'info',
                            'deleted' => 'danger',
                            'viewed' => 'secondary',
                            'login' => 'primary',
                            'logout' => 'warning',
                            default => 'secondary'
                        };
                        $actionIcon = match($log->action) {
                            'created' => 'plus-circle',
                            'updated' => 'pencil-square',
                            'deleted' => 'trash',
                            'viewed' => 'eye',
                            'login' => 'box-arrow-in-right',
                            'logout' => 'box-arrow-right',
                            default => 'info-circle'
                        };
                    @endphp
                    <tr>
                        @if($viewingUserActivities ?? false)
                        <!-- Viewing individual user activities -->
                        <td class="px-3 py-2 text-dark" style="font-size: 0.9rem;">
                            <span class="fw-bold">{{ $log->created_at->format('M d, Y') }}</span><br>
                            <span class="text-muted" style="font-size: 0.85rem;">{{ $log->created_at->format('h:i A') }}</span>
                        </td>
                        @else
                        <!-- Showing one per user -->
                        <td class="px-3 py-2">
                            @if($log->user)
                            <div class="d-flex align-items-center gap-2">
                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; flex-shrink: 0;">
                                    <i class="bi bi-person-fill" style="font-size: 0.9rem; color: #0038A8;"></i>
                                </div>
                                <div>
                                    <p class="mb-0 fw-bold text-dark" style="font-size: 0.9rem;">{{ $log->user->name ?? 'System' }}</p>
                                    <p class="mb-0 text-muted" style="font-size: 0.8rem;">{{ $log->user->email ?? 'N/A' }}</p>
                                </div>
                            </div>
                            @else
                            <span class="text-muted">Unknown User</span>
                            @endif
                        </td>
                        @endif
                        
                        <td class="px-3 py-2">
                            <span class="badge bg-{{ $actionColor }} rounded-pill px-3" style="font-size: 0.8rem;">
                                <i class="bi bi-{{ $actionIcon }} me-1"></i>{{ ucfirst($log->action) }}
                            </span>
                        </td>
                        <td class="px-3 py-2">
                            <p class="mb-0 text-muted" style="font-size: 0.9rem; max-width: 250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                {{ $log->details ?? 'No details' }}
                            </p>
                        </td>
                        <td class="px-3 py-2">
                            @if($viewingUserActivities ?? false)
                                <span class="text-muted" style="font-size: 0.85rem;">{{ $log->created_at->diffForHumans() }}</span>
                            @else
                                @php
                                    $totalActivities = \App\Models\AuditLog::where('user_id', $log->user_id)->count();
                                @endphp
                                <span class="badge bg-light text-dark">{{ $totalActivities }} activities</span>
                            @endif
                        </td>
                        <td class="px-3 py-2 text-end">
                            @if($viewingUserActivities ?? false)
                                <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#logDetailsModal{{ $log->id }}">
                                    Details
                                </button>
                            @else
                                <a href="/audit-logs?view_user={{ $log->user_id }}" class="btn btn-primary btn-sm" style="background-color: #0038A8; border-color: #0038A8;">
                                    View All
                                </a>
                            @endif
                        </td>
                    </tr>

                    <!-- Log Details Modal (only show for full history view) -->
                    @if($viewingUserActivities ?? false)
                    <div class="modal fade" id="logDetailsModal{{ $log->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content border-0">
                                <div class="modal-header bg-light border-bottom">
                                    <h5 class="modal-title fw-bold">Log Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body p-4">
                                    <div class="mb-3">
                                        <label class="form-label small text-muted fw-bold">Timestamp</label>
                                        <p class="mb-0">{{ $log->created_at->format('M d, Y h:i A') }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small text-muted fw-bold">User</label>
                                        <p class="mb-0">{{ $log->user->name ?? 'System' }} ({{ $log->user->email ?? 'N/A' }})</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small text-muted fw-bold">Action</label>
                                        <p class="mb-0">
                                            <span class="badge bg-{{ $actionColor }} rounded-pill px-3">
                                                {{ ucfirst($log->action) }}
                                            </span>
                                        </p>
                                    </div>
                                    <div class="mb-0">
                                        <label class="form-label small text-muted fw-bold">Details</label>
                                        <p class="mb-0 text-break">{{ $log->details ?? 'No additional details' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @empty
                    <tr>
                        <td colspan="5" class="px-3 py-4 text-center text-muted">
                            <i class="bi bi-inbox fs-4 d-block mb-2"></i>
                            No audit logs found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Pagination -->
@if($viewingUserActivities ?? false)
<div class="d-flex justify-content-center mt-4">
    {{ $logs->links('pagination::bootstrap-5') }}
</div>
@endif

<script>
    function exportLogs() {
        alert('Export functionality coming soon! This will export logs as CSV or PDF.');
    }
</script>
@endsection
