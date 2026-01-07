<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class ActivityLogger
{
    /**
     * Log a user activity
     *
     * @param string $action The action performed (created, updated, deleted, viewed, login, logout, etc.)
     * @param string|null $details Additional details about the action
     * @param int|null $userId User ID (defaults to authenticated user)
     * @return AuditLog
     */
    public static function log(string $action, ?string $details = null, ?int $userId = null): AuditLog
    {
        $userId = $userId ?? Auth::id();

        if (!$userId) {
            return new AuditLog();
        }

        return AuditLog::create([
            'user_id' => $userId,
            'action' => $action,
            'details' => $details,
        ]);
    }

    /**
     * Log a model creation
     */
    public static function logCreated(string $modelName, $model): AuditLog
    {
        $details = "Created {$modelName}";
        if (method_exists($model, 'getKey')) {
            $details .= " (ID: {$model->getKey()})";
        }

        return self::log('created', $details);
    }

    /**
     * Log a model update
     */
    public static function logUpdated(string $modelName, $model, ?array $changes = null): AuditLog
    {
        $details = "Updated {$modelName}";
        if (method_exists($model, 'getKey')) {
            $details .= " (ID: {$model->getKey()})";
        }

        if ($changes) {
            $changesSummary = array_keys($changes);
            $details .= " - Modified: " . implode(', ', $changesSummary);
        }

        return self::log('updated', $details);
    }

    /**
     * Log a model deletion
     */
    public static function logDeleted(string $modelName, $model): AuditLog
    {
        $details = "Deleted {$modelName}";
        if (method_exists($model, 'getKey')) {
            $details .= " (ID: {$model->getKey()})";
        }

        return self::log('deleted', $details);
    }

    /**
     * Log a view action
     */
    public static function logViewed(string $modelName, $modelId): AuditLog
    {
        return self::log('viewed', "Viewed {$modelName} (ID: {$modelId})");
    }

    /**
     * Log a login event
     */
    public static function logLogin(int $userId, string $ipAddress): AuditLog
    {
        return self::log('login', "User logged in from IP: {$ipAddress}", $userId);
    }

    /**
     * Log a logout event
     */
    public static function logLogout(int $userId): AuditLog
    {
        return self::log('logout', "User logged out", $userId);
    }

    /**
     * Get activity for a specific user
     */
    public static function getUserActivity(int $userId, int $limit = 50)
    {
        return AuditLog::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get activity for a specific action
     */
    public static function getActionActivity(string $action, int $limit = 50)
    {
        return AuditLog::where('action', $action)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get recent activity across all users
     */
    public static function getRecentActivity(int $limit = 50)
    {
        return AuditLog::with('user')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
}
