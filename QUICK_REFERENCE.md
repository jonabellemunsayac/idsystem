# 📋 User Activity Tracking - Quick Reference Card

## 🎯 ACCESS AUDIT LOGS
```
URL: /audit-logs
Menu: Sidebar → Audit Logs
```

## 🔍 WHAT'S TRACKED (Automatic)

| Action | Model | Example |
|--------|-------|---------|
| ✅ Created | BlotterRecord, Asset, Resident | New case added |
| ✅ Updated | BlotterRecord, Asset, Resident | Status changed |
| ✅ Deleted | BlotterRecord, Asset, Resident | Record removed |
| ✅ Login | User (with IP) | User logged in |
| ✅ Logout | User | User logged out |

## 💻 CODE SNIPPETS

### Log Custom Action
```php
use App\Services\ActivityLogger;

ActivityLogger::log('export', 'Exported 150 records');
```

### Log Login (if manual)
```php
ActivityLogger::logLogin($userId, $ipAddress);
```

### Log Viewing Record
```php
ActivityLogger::logViewed('ModelName', $recordId);
```

### Get Recent Activities
```php
$logs = ActivityLogger::getRecentActivity(50);
```

### Get User's Activities
```php
$logs = ActivityLogger::getUserActivity(auth()->id(), 50);
```

### Get Specific Action Type
```php
$logs = ActivityLogger::getActionActivity('created', 50);
```

## 🔧 ADD MODEL TO TRACKING

**File:** `app/Providers/AppServiceProvider.php`

```php
public function boot(): void
{
    // Add this line:
    YourModel::observe(AuditableModelObserver::class);
}
```

## 📊 AUDIT LOG TABLE COLUMNS

| Column | Purpose |
|--------|---------|
| Timestamp | When action occurred |
| User | Who performed action |
| Action | Type (created, updated, deleted, login, etc.) |
| Details | What happened |

## 🎨 ACTION COLOR CODING

- 🟢 **Green** = Created
- 🔵 **Blue** = Updated  
- 🔴 **Red** = Deleted
- ⚫ **Gray** = Viewed
- 🟣 **Purple** = Login
- 🟠 **Orange** = Logout

## 🔐 DATABASE SCHEMA

```sql
audit_logs
├── id (bigint) - Primary key
├── user_id (bigint) - Who did it
├── action (varchar) - Type of action
├── details (text) - Description
├── created_at (timestamp) - When
└── updated_at (timestamp)
```

## 🛠️ ARCHITECTURE

```
User Action
    ↓
Observer/Middleware detects
    ↓
ActivityLogger.log() called
    ↓
Audit log entry created
    ↓
View in dashboard
```

## 📁 KEY FILES

- `app/Services/ActivityLogger.php` - Main service
- `app/Http/Middleware/LogAuthenticationEvents.php` - Auth tracking
- `app/Observers/AuditableModelObserver.php` - Model tracking
- `app/Http/Controllers/AuditLogController.php` - Display logic
- `resources/views/audit-logs/index.blade.php` - UI

## 💡 COMMON PATTERNS

### In Controller Store Method (Auto-logged)
```php
public function store(Request $request)
{
    $record = Model::create($data);  // ✅ Auto-logged
    return redirect()->back();
}
```

### In Export Method (Manual log)
```php
public function export()
{
    // ... generate file ...
    ActivityLogger::log('export', 'Exported records');
    return response()->download($file);
}
```

### In Show Method (Track views)
```php
public function show(Model $model)
{
    ActivityLogger::logViewed('Model', $model->id);
    return view('show', compact('model'));
}
```

## 🚀 QUICK TEST

1. Go to `/audit-logs`
2. Create a new BlotterRecord
3. Refresh audit logs page
4. Should see "Created BlotterRecord" entry
5. ✅ System working!

## 📊 AVAILABLE FILTERS

- **User Filter** - See activities by specific user
- **Action Filter** - See specific action types
- **Date Filter** - See activities from specific date
- **Search** - Search in activity details
- **Pagination** - 50 entries per page

## 🔗 RELATIONSHIPS

```
User (1) ← Many → (Many) AuditLog
          auditLogs()
```

## 📌 AUTOMATICALLY OBSERVED MODELS

```
✅ app/Models/BlotterRecord
✅ app/Models/Asset  
✅ app/Models/Resident
```

To add more:
```php
// In AppServiceProvider::boot()
Certificate::observe(AuditableModelObserver::class);
```

## ⚠️ IMPORTANT NOTES

- Middleware registered in `bootstrap/app.php`
- Observer registered in `AppServiceProvider`
- All model changes auto-logged
- Manual logging optional but recommended
- Audit logs are read-only (no delete)

## 📖 FULL DOCUMENTATION

- `USER_TRACKING_GUIDE.md` - Complete guide
- `TRACKING_EXAMPLES.php` - Code examples
- `TRACKING_FLOW_DIAGRAMS.md` - Visual diagrams
- `SYSTEM_READY.md` - Full overview

---

**Status:** ✅ Ready to Use | **Last Updated:** Jan 6, 2026
