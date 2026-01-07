# User Activity Tracking System

## Overview
A simple user activity tracking system that automatically logs user actions like:
- **Model changes**: Created, Updated, Deleted, Restored
- **Authentication events**: Login, Logout
- **User views**: View actions on specific records
- **Custom actions**: Any custom action you want to track

## How It Works

### 1. **Automatic Model Tracking (Observer Pattern)**
When you create, update, or delete records for observed models (BlotterRecord, Asset, Resident), they're automatically logged:

```php
// Example: Creating a blotter record automatically logs it
$blotter = BlotterRecord::create([
    'case_number' => 'CASE-001',
    'complainant_name' => 'John Doe',
    // ... other fields
]);
// ✓ Automatically logged: "Created BlotterRecord (ID: 1)"
```

### 2. **Login/Logout Tracking**
User logins and logouts are tracked with IP addresses (middleware registered in bootstrap):

```
Activity logged:
- User logged in from IP: 192.168.1.1
- User logged out
```

### 3. **Manual Activity Logging**
For custom actions, use the `ActivityLogger` service:

```php
use App\Services\ActivityLogger;

// Log a custom action
ActivityLogger::log('exported', 'Exported residents list');

// Log viewing an item
ActivityLogger::logViewed('Resident', 123);

// Log batch operations
ActivityLogger::log('imported', 'Imported 50 residents from CSV');
```

## Usage Examples

### In Controllers
```php
use App\Services\ActivityLogger;

class ResidentController extends Controller
{
    public function export()
    {
        // ... export logic ...
        ActivityLogger::log('export', 'Exported ' . count($residents) . ' residents');
        
        return response()->download($file);
    }

    public function show(Resident $resident)
    {
        ActivityLogger::logViewed('Resident', $resident->id);
        return view('residents.show', compact('resident'));
    }
}
```

### In Custom Jobs/Commands
```php
use App\Services\ActivityLogger;

class ImportResidentsJob implements ShouldQueue
{
    public function handle()
    {
        $count = $this->importResidents();
        ActivityLogger::log('batch_import', "Imported $count residents");
    }
}
```

## Available ActivityLogger Methods

### Basic Logging
- `log(action, details, userId?)` - Log any custom action
- `logCreated(modelName, model)` - Log model creation
- `logUpdated(modelName, model, changes?)` - Log model update
- `logDeleted(modelName, model)` - Log model deletion
- `logViewed(modelName, modelId)` - Log viewing a record

### Authentication Events
- `logLogin(userId, ipAddress)` - Log user login
- `logLogout(userId)` - Log user logout

### Query Methods
- `getRecentActivity(limit = 50)` - Get recent activities
- `getUserActivity(userId, limit = 50)` - Get user's activities
- `getActionActivity(action, limit = 50)` - Get activities by action type

## Viewing Audit Logs

Access the audit logs from your admin dashboard:
1. Click **Audit Logs** in the sidebar
2. View the activity table with:
   - **Timestamp**: When the action occurred
   - **User**: Who performed the action
   - **Action**: Type of action (created, updated, deleted, etc.)
   - **Details**: Description of what happened

### Filtering Options
- **Filter by User**: See activities from a specific user
- **Filter by Action**: See only certain types of actions
- **Filter by Date**: See activities from a specific date
- **Search**: Search in action details

## Observed Models (Auto-Tracked)

Currently, these models are automatically tracked:
- **BlotterRecord** - Case/incident creation, updates, deletions
- **Asset** - Asset management changes
- **Resident** - Resident profile changes

### Adding More Models to Tracking

To track additional models, register them in `app/Providers/AppServiceProvider.php`:

```php
public function boot(): void
{
    BlotterRecord::observe(AuditableModelObserver::class);
    Asset::observe(AuditableModelObserver::class);
    Resident::observe(AuditableModelObserver::class);
    
    // Add new model tracking:
    Appointment::observe(AuditableModelObserver::class);
    Certificate::observe(AuditableModelObserver::class);
}
```

## Database Schema

The `audit_logs` table contains:
- `id` - Primary key
- `user_id` - ID of user who performed action (foreign key to users)
- `action` - Type of action (created, updated, deleted, viewed, login, logout, etc.)
- `details` - JSON/text details about the action
- `created_at` - Timestamp of the action
- `updated_at` - Updated timestamp

## Benefits

✅ **Compliance**: Track all admin actions for regulatory requirements
✅ **Accountability**: Know who did what and when
✅ **Debugging**: Find when issues occurred and who made changes
✅ **Security**: Detect suspicious activity patterns
✅ **Reversibility**: Understand what was changed to potentially revert it
✅ **Automatic**: Most tracking happens without extra code

## Implementation Status

- ✅ Model change tracking (observer pattern)
- ✅ Login/logout tracking
- ✅ Audit logs display with filters
- ✅ ActivityLogger service
- ✅ BlotterRecord, Asset, Resident tracking
- ✅ User audit log relationship

## Next Steps (Optional)

Consider adding:
1. Soft deletes for audit logs (don't let admins delete logs)
2. Role-based visibility (only super-admins see all logs)
3. Export audit logs to CSV/PDF
4. Email alerts for critical actions
5. Detailed change tracking (show old vs new values)
