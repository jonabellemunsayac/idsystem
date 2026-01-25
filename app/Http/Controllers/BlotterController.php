<?php

namespace App\Http\Controllers;

use App\Models\BlotterRecord;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;

class BlotterController extends Controller
{
    /**
     * Display a listing of the blotter records.
     */
    public function index(Request $request)
    {
        $query = BlotterRecord::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('case_number', 'like', "%{$search}%")
                  ->orWhere('complainant_name', 'like', "%{$search}%")
                  ->orWhere('respondent_name', 'like', "%{$search}%")
                  ->orWhere('incident_location', 'like', "%{$search}%");
            });
        }

        // Prioritize pending status first, then by most recent (created_at)
        $cases = $query->orderByRaw("FIELD(status, 'pending', 'investigating', 'resolved')")
            ->orderBy('created_at', 'desc')
            ->paginate(5);
        return view('blotter.index', compact('cases'));
    }

    /**
     * Debug: Check if records exist with data
     */
    public function debug()
    {
        $cases = BlotterRecord::all();
        return response()->json([
            'total_records' => $cases->count(),
            'sample_records' => $cases->take(3),
            'first_record_attributes' => $cases->first()?->getAttributes(),
        ]);
    }

    /**
     * Store a newly created blotter record in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'case_id' => 'nullable|string',
            'date' => 'required|date',
            'type' => 'required|string',
            'complainant_name' => 'required|string|max:255',
            'complainant_contact' => 'nullable|string|max:20',
            'respondent_name' => 'nullable|string|max:255',
            'respondent_contact' => 'nullable|string|max:20',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
            'severity' => 'required|in:low,medium,high,critical',
            'witnesses' => 'nullable|integer|min:0',
            'status' => 'required|in:pending,investigating,resolved',
            'notes' => 'nullable|string',
        ]);

        try {
            // Generate case number if not provided
            if (empty($validated['case_id'])) {
                $caseNumber = 'BLT-' . str_pad(BlotterRecord::max('id') + 1, 6, '0', STR_PAD_LEFT);
            } else {
                $caseNumber = $validated['case_id'];
            }

            // Create the blotter record
            $blotterRecord = BlotterRecord::create([
                'case_number' => $caseNumber,
                'complainant_name' => $validated['complainant_name'],
                'complainant_contact' => $validated['complainant_contact'] ?? null,
                'respondent_name' => $validated['respondent_name'] ?? null,
                'respondent_contact' => $validated['respondent_contact'] ?? null,
                'incident_type' => $validated['type'],
                'incident_location' => $validated['location'],
                'details' => $validated['description'],
                'incident_date' => $validated['date'],
                'severity' => $validated['severity'],
                'status' => $validated['status'],
                'witnesses' => $validated['witnesses'] ?? 0,
                'notes' => $validated['notes'] ?? null,
            ]);

            // Log the creation
            ActivityLogger::logBlotter('created', $blotterRecord->incident_type, $blotterRecord->id);

            return response()->json([
                'success' => true,
                'message' => 'Case created successfully',
                'data' => $blotterRecord,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating case',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified blotter record.
     */
    public function show(BlotterRecord $blotterRecord)
    {
        return response()->json([
            'success' => true,
            'data' => $blotterRecord->toArray()
        ]);
    }

    /**
     * Update the specified blotter record in storage.
     */
    public function update(Request $request, $id)
    {
        $blotterRecord = BlotterRecord::findOrFail($id);
        
        $validated = $request->validate([
            'status' => 'sometimes|required|in:pending,investigating,resolved',
            'severity' => 'sometimes|required|in:low,medium,high,critical',
            'notes' => 'nullable|string',
            'description' => 'sometimes|required|string',
        ]);

        try {
            $oldStatus = $blotterRecord->status;
            $blotterRecord->update($validated);

            // Log the status update if status was changed
            if (isset($validated['status'])) {
                ActivityLogger::logBlotter('updated', $blotterRecord->incident_type, $blotterRecord->id);
            }

            return response()->json([
                'success' => true,
                'message' => 'Case updated successfully',
                'data' => $blotterRecord,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating case',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified blotter record from storage.
     */
    public function destroy(BlotterRecord $blotterRecord)
    {
        try {
            $blotterRecord->delete();

            return response()->json([
                'success' => true,
                'message' => 'Case deleted successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting case',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
