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

    /**
     * Log ID card print action
     */
    public static function logPrint(string $printType, int $residentId, string $residentName): AuditLog
    {
        return self::log('printed', "Printed {$printType} ID card for {$residentName} (Resident ID: {$residentId})");
    }

    /**
     * Log asset action
     */
    public static function logAsset(string $action, string $assetName, int $assetId): AuditLog
    {
        $actionText = match($action) {
            'created' => 'Added',
            'updated' => 'Updated',
            'deleted' => 'Deleted',
            default => ucfirst($action)
        };
        return self::log($action, "{$actionText} asset: {$assetName} (Asset ID: {$assetId})");
    }

    /**
     * Log certificate action
     */
    public static function logCertificate(string $action, string $certificateType, int $certificateId): AuditLog
    {
        $actionText = match($action) {
            'created' => 'Generated',
            'viewed' => 'Viewed',
            'printed' => 'Printed',
            default => ucfirst($action)
        };
        return self::log($action, "{$actionText} {$certificateType} certificate (Certificate ID: {$certificateId})");
    }

    /**
     * Log blotter action
     */
    public static function logBlotter(string $action, string $incidentType, int $blotterId): AuditLog
    {
        $actionText = match($action) {
            'created' => 'Created',
            'updated' => 'Updated',
            'deleted' => 'Deleted',
            default => ucfirst($action)
        };
        return self::log($action, "{$actionText} blotter record: {$incidentType} (Blotter ID: {$blotterId})");
    }

    /**
     * Log appointment action
     */
    public static function logAppointment(string $action, string $purpose, int $appointmentId): AuditLog
    {
        $actionText = match($action) {
            'created' => 'Scheduled',
            'updated' => 'Updated',
            'deleted' => 'Cancelled',
            'approved' => 'Approved',
            'rejected' => 'Rejected',
            default => ucfirst($action)
        };
        return self::log($action, "{$actionText} appointment: {$purpose} (Appointment ID: {$appointmentId})");
    }

    /**
     * Log resident account action
     */
    public static function logResidentAccount(string $action, string $residentName, int $residentId): AuditLog
    {
        $actionText = match($action) {
            'created' => 'Created',
            'updated' => 'Updated',
            'deleted' => 'Deleted',
            'activated' => 'Activated',
            'deactivated' => 'Deactivated',
            default => ucfirst($action)
        };
        return self::log($action, "{$actionText} resident account: {$residentName} (Resident ID: {$residentId})");
    }

    /**
     * Log report generation
     */
    public static function logReport(string $reportType, string $parameters = ''): AuditLog
    {
        $details = "Generated {$reportType} report";
        if ($parameters) {
            $details .= " ({$parameters})";
        }
        return self::log('generated', $details);
    }

    /**
     * Log export action
     */
    public static function logExport(string $dataType, string $format = 'CSV'): AuditLog
    {
        return self::log('exported', "Exported {$dataType} data as {$format}");
    }
}

