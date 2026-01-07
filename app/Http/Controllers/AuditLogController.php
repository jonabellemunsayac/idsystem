<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    /**
     * Display a listing of audit logs (one per user with latest activity).
     */
    public function index(Request $request)
    {
        try {
            // Check if viewing all activities for a specific user
            if ($request->filled('view_user')) {
                $userId = $request->view_user;
                $logs = AuditLog::with('user')
                    ->where('user_id', $userId)
                    ->orderBy('created_at', 'desc')
                    ->paginate(50);
                
                $users = \App\Models\User::whereHas('auditLogs')->get();
                $viewingUserActivities = true;
                $viewingUserId = $userId;
                
                return view('audit-logs.index', compact('logs', 'users', 'viewingUserActivities', 'viewingUserId'));
            }

            // Get only the latest activity for each user (non-login actions preferred)
            $userIds = AuditLog::distinct('user_id')->pluck('user_id');
            $latestLogs = [];
            
            foreach ($userIds as $userId) {
                // Try to get latest non-login action first
                $log = AuditLog::with('user')
                    ->where('user_id', $userId)
                    ->where('action', '!=', 'login')
                    ->orderBy('created_at', 'desc')
                    ->first();
                
                // If only login exists, get the latest login
                if (!$log) {
                    $log = AuditLog::with('user')
                        ->where('user_id', $userId)
                        ->orderBy('created_at', 'desc')
                        ->first();
                }
                
                if ($log) {
                    $latestLogs[] = $log;
                }
            }

            // Sort by created_at descending
            usort($latestLogs, function($a, $b) {
                return $b->created_at <=> $a->created_at;
            });

            $users = \App\Models\User::whereHas('auditLogs')->get();
            $viewingUserActivities = false;
            $logs = collect($latestLogs);
            
            return view('audit-logs.index', compact('logs', 'users', 'viewingUserActivities'));
        } catch (\Exception $e) {
            \Log::error('Audit log controller error: ' . $e->getMessage());
            return view('audit-logs.index', [
                'logs' => collect(),
                'users' => collect(),
                'viewingUserActivities' => false,
                'error' => 'Error loading audit logs'
            ]);
        }
    }

    /**
     * Show the form for creating a new audit log.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created audit log in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified audit log.
     */
    public function show(AuditLog $auditLog)
    {
        return response()->json($auditLog);
    }

    /**
     * Show the form for editing the specified audit log.
     */
    public function edit(AuditLog $auditLog)
    {
        //
    }

    /**
     * Update the specified audit log in storage.
     */
    public function update(Request $request, AuditLog $auditLog)
    {
        //
    }

    /**
     * Remove the specified audit log from storage.
     */
    public function destroy(AuditLog $auditLog)
    {
        //
    }
}
