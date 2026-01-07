<?php

/**
 * EXAMPLE: How to Integrate Activity Logging in Your Controllers
 * 
 * This file shows practical examples of how to use the ActivityLogger
 * in your existing controllers. Copy these patterns to your own code.
 */

// ============================================================
// EXAMPLE 1: BlotterController - Already Tracked by Observer
// ============================================================

namespace App\Http\Controllers;

use App\Models\BlotterRecord;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;

class BlotterControllerExample extends Controller
{
    /**
     * Store a newly created blotter record in storage.
     * Model creation is AUTOMATICALLY logged by the observer
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'case_number' => 'required|string|unique:blotter_records',
            'complainant_name' => 'required|string',
            // ... validation rules
        ]);

        // This will automatically trigger the observer and log:
        // "Created BlotterRecord (ID: 123)"
        $blotter = BlotterRecord::create($validated);

        return redirect()->route('blotter.show', $blotter)->with('success', 'Case recorded successfully');
    }

    /**
     * Display the specified blotter record.
     */
    public function show(BlotterRecord $blotter)
    {
        // Manually log that user viewed this record
        ActivityLogger::logViewed('BlotterRecord', $blotter->id);

        return view('blotter.show', compact('blotter'));
    }

    /**
     * Update the specified blotter record in storage.
     * Model update is AUTOMATICALLY logged by the observer
     */
    public function update(Request $request, BlotterRecord $blotter)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,investigating,resolved',
            'notes' => 'nullable|string',
        ]);

        // This automatically triggers the observer and logs:
        // "Updated BlotterRecord (ID: 123) - Modified: status, notes"
        $blotter->update($validated);

        return redirect()->route('blotter.show', $blotter)->with('success', 'Case updated');
    }

    /**
     * Remove the specified blotter record from storage.
     * Model deletion is AUTOMATICALLY logged by the observer
     */
    public function destroy(BlotterRecord $blotter)
    {
        // This automatically triggers the observer and logs:
        // "Deleted BlotterRecord (ID: 123)"
        $blotter->delete();

        return redirect()->route('blotter.index')->with('success', 'Case deleted');
    }

    /**
     * Export blotter records - CUSTOM ACTION (manual logging)
     */
    public function export(Request $request)
    {
        $filters = $request->only('status', 'severity', 'start_date', 'end_date');
        $records = BlotterRecord::query();

        // Apply filters...
        $count = $records->count();

        // Manually log this custom action
        ActivityLogger::log('export', "Exported {$count} blotter records with filters: " . json_encode($filters));

        // Return export file...
        return response()->download($file);
    }

    /**
     * Bulk update status - CUSTOM ACTION (manual logging)
     */
    public function bulkUpdateStatus(Request $request)
    {
        $ids = $request->input('ids', []);
        $status = $request->input('status');

        $count = BlotterRecord::whereIn('id', $ids)->update(['status' => $status]);

        // Manually log this bulk action
        ActivityLogger::log('bulk_update', "Updated status to '{$status}' for {$count} records");

        return response()->json(['message' => "Updated {$count} records"]);
    }
}

// ============================================================
// EXAMPLE 2: AssetController - Already Tracked by Observer
// ============================================================

class AssetControllerExample extends Controller
{
    /**
     * Store a new asset.
     * Automatically logged by observer
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'category' => 'required|string',
            'status' => 'required|in:working,maintenance,disposal,inactive',
        ]);

        // Observer logs: "Created Asset (ID: 45)"
        $asset = Asset::create($validated);

        return redirect()->route('assets.show', $asset)->with('success', 'Asset added');
    }

    /**
     * Perform maintenance on asset - CUSTOM ACTION
     */
    public function performMaintenance(Asset $asset, Request $request)
    {
        $asset->update([
            'status' => 'maintenance',
            'last_maintenance_date' => now(),
            'description' => $request->input('maintenance_notes'),
        ]);

        // Observer logs update automatically, but we can add a custom note:
        ActivityLogger::log('maintenance', "Performed maintenance on Asset #{$asset->id} ({$asset->name})");

        return response()->json(['message' => 'Maintenance logged']);
    }

    /**
     * Dispose of asset - CUSTOM ACTION
     */
    public function dispose(Asset $asset, Request $request)
    {
        $reason = $request->input('reason');

        $asset->update([
            'status' => 'disposal',
            'description' => "Disposed: {$reason}",
        ]);

        // Log the disposal with reason
        ActivityLogger::log('disposal', "Disposed Asset #{$asset->id} ({$asset->name}) - Reason: {$reason}");

        return response()->json(['message' => 'Asset marked for disposal']);
    }
}

// ============================================================
// EXAMPLE 3: ReportController - Custom Actions (manual logging)
// ============================================================

class ReportControllerExample extends Controller
{
    /**
     * Export monthly report
     */
    public function exportMonthlyReport(Request $request)
    {
        $month = $request->input('month');
        $year = $request->input('year');

        // Generate report...
        $stats = [
            'cases' => BlotterRecord::count(),
            'assets' => Asset::count(),
            'residents' => Resident::count(),
        ];

        ActivityLogger::log('report_export', "Generated monthly report for {$month}/{$year}");

        return response()->download($file);
    }

    /**
     * Generate dashboard analytics
     */
    public function generateAnalytics(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Run analytics...
        ActivityLogger::log('analytics_generated', "Generated analytics for {$startDate} to {$endDate}");

        return response()->json(['data' => $analytics]);
    }
}

// ============================================================
// EXAMPLE 4: Common Patterns
// ============================================================

class CommonPatternsExample extends Controller
{
    /**
     * Pattern 1: Log with Context
     */
    public function exampleWithContext()
    {
        $user = auth()->user();
        $action = 'sensitive_operation';
        $context = "User: {$user->email}, Role: {$user->role}";

        ActivityLogger::log($action, $context);
    }

    /**
     * Pattern 2: Log Before and After
     */
    public function exampleBeforeAfter($record)
    {
        // Get original state
        $originalStatus = $record->status;

        // Make changes
        $record->update(['status' => 'approved']);

        // Log the change
        ActivityLogger::log('status_change', "Changed status from '{$originalStatus}' to 'approved'");
    }

    /**
     * Pattern 3: Log Errors
     */
    public function exampleErrorLogging()
    {
        try {
            // Some operation
        } catch (\Exception $e) {
            ActivityLogger::log('error', "Operation failed: {$e->getMessage()}");
            throw $e;
        }
    }

    /**
     * Pattern 4: Log Batch Operations
     */
    public function exampleBatchOperation(Request $request)
    {
        $items = $request->input('items', []);
        $operation = $request->input('operation');

        foreach ($items as $item) {
            // Process item...
        }

        ActivityLogger::log('batch_operation', "{$operation} performed on " . count($items) . " items");
    }

    /**
     * Pattern 5: Get Activity History
     */
    public function exampleGetHistory()
    {
        $userId = auth()->id();
        $myActivities = ActivityLogger::getUserActivity($userId, 10);

        // Use in your view
        return view('activity-history', ['activities' => $myActivities]);
    }
}

// ============================================================
// SUMMARY OF AUTO-TRACKED VS MANUAL
// ============================================================

/*
AUTO-TRACKED (by Observer - no extra code needed):
- BlotterRecord::create()    ✓ Logged: "Created BlotterRecord"
- BlotterRecord::update()    ✓ Logged: "Updated BlotterRecord"
- BlotterRecord::delete()    ✓ Logged: "Deleted BlotterRecord"
- Asset::create()            ✓ Logged: "Created Asset"
- Asset::update()            ✓ Logged: "Updated Asset"
- Asset::delete()            ✓ Logged: "Deleted Asset"
- Resident::create()         ✓ Logged: "Created Resident"
- Resident::update()         ✓ Logged: "Updated Resident"
- Resident::delete()         ✓ Logged: "Deleted Resident"

MANUAL-TRACKED (add ActivityLogger in your code):
- User login/logout          → ActivityLogger::logLogin()
- Viewing records            → ActivityLogger::logViewed()
- Export operations          → ActivityLogger::log('export', ...)
- Bulk operations            → ActivityLogger::log('bulk_update', ...)
- Custom workflows           → ActivityLogger::log('custom_action', ...)
- Sensitive operations       → ActivityLogger::log('sensitive', ...)
- Error conditions           → ActivityLogger::log('error', ...)

To see all logs: Visit /audit-logs in your admin panel
*/
