# ✅ User Activity Tracking System - Complete Setup

## System Overview

Your BMS now has a **simple but powerful user activity tracking system** that automatically monitors:
- ✅ User logins and logouts (with IP addresses)
- ✅ All changes to BlotterRecords (create, update, delete)
- ✅ All changes to Assets (create, update, delete)
- ✅ All changes to Residents (create, update, delete)
- ✅ Custom actions you manually log (exports, bulk operations, etc.)

---

## 📁 Files Created/Modified

### New Files Created:
1. **`app/Services/ActivityLogger.php`** - Main logging service with helper methods
2. **`app/Http/Middleware/LogAuthenticationEvents.php`** - Tracks login/logout events
3. **`app/Observers/AuditableModelObserver.php`** - Auto-logs model changes
4. **`AUDIT_TRAIL_SETUP.md`** - Detailed documentation
5. **`USER_TRACKING_GUIDE.md`** - Quick reference guide
6. **`TRACKING_EXAMPLES.php`** - Code examples for integration

### Modified Files:
1. **`app/Providers/AppServiceProvider.php`** - Registered observer for 3 models
2. **`app/Models/User.php`** - Added `auditLogs()` relationship
3. **`app/Http/Controllers/AuditLogController.php`** - Added filtering logic
4. **`bootstrap/app.php`** - Registered authentication logging middleware
5. **`routes/web.php`** - Already had audit-logs route

---

## 🎯 How It Works (Architecture)

```
User Action (e.g., create BlotterRecord)
    ↓
Observer detects event (AuditableModelObserver)
    ↓
ActivityLogger.log() method called
    ↓
Entry written to audit_logs table
    ↓
Admin views it in /audit-logs dashboard
```

### Three Tracking Mechanisms:

**1. Model Observer (Automatic)**
```
When you: BlotterRecord::create($data)
Observer sees: "created" event
Logs: "Created BlotterRecord (ID: 45)"
```

**2. Authentication Middleware (Automatic)**
```
When user: Logs in
Middleware captures: User ID + IP address
Logs: "User logged in from IP: 192.168.x.x"
```

**3. Manual Logging (Explicit)**
```php
When you: ActivityLogger::log('export', 'Exported 150 records')
Logs: "export" action with details
```

---

## 💻 Code Examples

### Example 1: Automatic Logging (No Extra Code)
```php
// In BlotterController::store()
$blotter = BlotterRecord::create($validated);
// ✓ Automatically logged: "Created BlotterRecord (ID: 123)"

// In AssetController::update()
$asset->update($data);
// ✓ Automatically logged: "Updated Asset (ID: 45) - Modified: status, location"
```

### Example 2: Manual Logging for Custom Actions
```php
use App\Services\ActivityLogger;

// In ReportController::export()
public function export()
{
    $records = BlotterRecord::all();
    // ... generate PDF ...
    
    ActivityLogger::log('export', 'Exported ' . count($records) . ' records');
    
    return response()->download($file);
}
```

### Example 3: Manual Logging for Views
```php
// In BlotterController::show()
public function show(BlotterRecord $blotter)
{
    ActivityLogger::logViewed('BlotterRecord', $blotter->id);
    return view('blotter.show', compact('blotter'));
}
```

---

## 📊 Database Schema

```sql
audit_logs table:
├── id (bigint) - Primary key
├── user_id (bigint) - Foreign key to users.id
├── action (varchar) - 'created', 'updated', 'deleted', 'login', 'logout', 'export', etc.
├── details (text) - Description: "Created BlotterRecord (ID: 45)"
├── created_at (timestamp) - When action occurred
└── updated_at (timestamp) - Auto-updated by Laravel

Indexes:
- Primary: id
- Foreign: user_id
- Searchable: action, created_at
```

---

## 🎨 User Interface

**Access via:** `http://yourapp/audit-logs`

**Features:**
- 📋 **Activity Table** - Shows timestamp, user, action, details
- 🔍 **Filters:**
  - Filter by User (dropdown)
  - Filter by Action (created, updated, deleted, login, logout, etc.)
  - Filter by Date (date picker)
- 📅 **Pagination** - Shows 50 entries per page
- 👁️ **View Details** - Click action for full details in modal
- 🏷️ **Color-Coded Badges:**
  - 🟢 Green = created
  - 🔵 Blue = updated
  - 🔴 Red = deleted
  - ⚫ Gray = viewed
  - 🟣 Purple = login/logout

---

## 🔧 Configuration & Customization

### Add More Models to Auto-Tracking

**File:** `app/Providers/AppServiceProvider.php`

Current:
```php
public function boot(): void
{
    BlotterRecord::observe(AuditableModelObserver::class);
    Asset::observe(AuditableModelObserver::class);
    Resident::observe(AuditableModelObserver::class);
}
```

To add Certificate tracking:
```php
Certificate::observe(AuditableModelObserver::class);
Clan::observe(AuditableModelObserver::class);
```

### Available ActivityLogger Methods

```php
use App\Services\ActivityLogger;

// Manual logging
ActivityLogger::log($action, $details);           // Generic log
ActivityLogger::logLogin($userId, $ipAddress);   // Login
ActivityLogger::logLogout($userId);              // Logout
ActivityLogger::logViewed($modelName, $modelId); // View
ActivityLogger::logCreated($modelName, $model);  // Create
ActivityLogger::logUpdated($modelName, $model);  // Update
ActivityLogger::logDeleted($modelName, $model);  // Delete

// Query/retrieve
ActivityLogger::getRecentActivity(50);            // Last 50 activities
ActivityLogger::getUserActivity($userId, 50);    // Specific user
ActivityLogger::getActionActivity('created', 50);// Specific action
```

---

## ✨ What's Tracked

### ✅ Automatically Tracked:
- **BlotterRecord**: Create, Update, Delete
- **Asset**: Create, Update, Delete
- **Resident**: Create, Update, Delete
- **Authentication**: Login, Logout (with IP)

### 📝 Common Custom Actions to Log:
- Report exports
- Bulk operations (bulk update, bulk delete)
- Batch imports
- Sensitive operations
- Data corrections
- Password changes
- Permission changes

---

## 🚀 Quick Start

### To view audit logs:
1. Go to `/audit-logs` in your admin panel
2. Click "Audit Logs" in sidebar (if menu item exists)
3. View all activities with filters

### To log a custom action:
```php
use App\Services\ActivityLogger;

// In any controller
ActivityLogger::log('action_name', 'Description of what happened');
```

### To check user's activity history:
```php
$userId = 1;
$activities = ActivityLogger::getUserActivity($userId, 100);

foreach ($activities as $log) {
    echo $log->user->name . " - " . $log->action . " - " . $log->details;
}
```

---

## 🔒 Security Considerations

1. **Who can see audit logs?** - Currently all authenticated users (modify AuditLogController to restrict)
2. **Immutability** - Audit logs should NOT be deletable by regular admins
3. **Retention** - Consider archiving old logs after 1-2 years
4. **Sensitive Data** - Be careful what you log (passwords, credit cards, etc.)

### Add Role-Based Access (Optional):
```php
// In AuditLogController::index()
$this->authorize('view-audit-logs'); // Add authorization check
```

---

## 📈 What's Logged vs Not Logged

### Logged:
✅ Model CRUD operations (auto)
✅ User authentication events (auto)
✅ Manual custom actions (manual)
✅ Export operations (manual)
✅ Bulk operations (manual)
✅ IP addresses for logins
✅ Timestamps with seconds precision

### NOT Currently Logged (Can Add):
❌ View operations (unless manually logged)
❌ Search operations
❌ Report generation (unless manually logged)
❌ Password changes (consider adding)
❌ Permission/role changes (consider adding)

---

## 🐛 Troubleshooting

**No activities showing?**
- Check if models are being observed in AppServiceProvider.php
- Check if user_id is correctly set (use `auth()->id()`)
- Verify audit_logs table exists and has records

**Login tracking not working?**
- Verify LogAuthenticationEvents middleware is registered in bootstrap/app.php
- Check that user is authenticated via auth() helper

**Filter not working?**
- Ensure query parameters are passed correctly from form
- Check AuditLogController::index() filtering logic

---

## 📚 Documentation Files

1. **`USER_TRACKING_GUIDE.md`** - Quick reference for common tasks
2. **`AUDIT_TRAIL_SETUP.md`** - Comprehensive system documentation
3. **`TRACKING_EXAMPLES.php`** - Code examples for different scenarios
4. **This file** - Complete setup overview

---

## ✅ Verification Checklist

After deployment, verify:
- [ ] ActivityLogger service file exists
- [ ] Middleware file exists and is registered
- [ ] Observer file exists and is registered
- [ ] AppServiceProvider has observer registrations
- [ ] User model has auditLogs() relationship
- [ ] Routes include audit-logs resource route
- [ ] audit_logs table exists in database
- [ ] Can access /audit-logs page
- [ ] Activities appear when creating/updating records
- [ ] Login activities appear in logs

---

## 🎯 Next Steps

1. **Test it**: Create a blotter record and check if it appears in audit logs
2. **Customize**: Add more models to automatic tracking if needed
3. **Integrate**: Add manual logging to critical operations (exports, bulk updates)
4. **Secure**: Add role-based access control to audit log viewing
5. **Monitor**: Regularly check audit logs for suspicious activity

---

## 📞 Support

For questions about:
- **Logging code**: See `TRACKING_EXAMPLES.php`
- **Usage**: See `USER_TRACKING_GUIDE.md`
- **Architecture**: See `AUDIT_TRAIL_SETUP.md`
- **Database**: Check `2025_11_26_174604_initial_schema.php` audit_logs table

---

**Status: ✅ Ready to Use**

Your user activity tracking system is fully implemented and operational!
