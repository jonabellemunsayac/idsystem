## Simple User Activity Tracking - Quick Reference

### ✅ What's Now Set Up:

**1. Automatic Model Tracking**
- BlotterRecord, Asset, Resident changes are automatically logged
- Create/Update/Delete actions trigger audit entries
- Example: Creating a blotter record → auto-logs to audit_logs table

**2. ActivityLogger Service** (`app/Services/ActivityLogger.php`)
Quick methods to manually log actions:

```php
// Import it
use App\Services\ActivityLogger;

// Log custom actions
ActivityLogger::log('action_name', 'description text');

// Pre-built methods:
ActivityLogger::logLogin(userId, ipAddress);           // Login tracking
ActivityLogger::logLogout(userId);                     // Logout tracking
ActivityLogger::logViewed('ModelName', modelId);       // View tracking
ActivityLogger::logCreated('ModelName', $model);       // Creation tracking
ActivityLogger::logUpdated('ModelName', $model);       // Update tracking
ActivityLogger::logDeleted('ModelName', $model);       // Delete tracking

// Query methods:
ActivityLogger::getRecentActivity(50);                 // Last 50 activities
ActivityLogger::getUserActivity(userId);               // User's activities
ActivityLogger::getActionActivity('created');          // Filter by action
```

**3. Authentication Middleware** (`app/Http/Middleware/LogAuthenticationEvents.php`)
- Automatically logs user logins with IP address
- Logs logout events
- Tracks session authentication

**4. Model Observer** (`app/Observers/AuditableModelObserver.php`)
- Watches for model changes (created, updated, deleted)
- Automatically creates audit log entries
- Registered in AppServiceProvider for: BlotterRecord, Asset, Resident

**5. Audit Logs Display**
- Route: `/audit-logs` (already added to routes/web.php)
- Filters by: User, Action, Date
- Shows: Timestamp, User, Action, Details
- Click "View" for full details in modal

---

### 📊 How Data Gets Logged:

**Scenario 1: Create a Blotter Record**
```
User opens admin panel → Clicks "Add Case" → Submits form
→ BlotterRecord::create() called
→ Observer detects creation
→ Audit entry created: "Created BlotterRecord (ID: 45)"
→ Shows in Audit Logs dashboard
```

**Scenario 2: Manual Custom Action**
```php
// In a controller
ActivityLogger::log('exported', 'Exported 150 residents');

// Shows in Audit Logs as:
// Action: custom
// Details: "Exported 150 residents"
```

**Scenario 3: User Login**
```
User enters credentials → Login middleware
→ ActivityLogger::logLogin(1, "192.168.1.100")
→ Shows in Audit Logs: "User logged in from IP: 192.168.1.100"
```

---

### 🎯 Key Features:

1. **Zero-Config Model Tracking** - Just observe a model and it's automatically tracked
2. **Flexible Logging** - Use built-in methods or create custom actions
3. **Query Builder** - Get activities filtered by user/action/date
4. **Beautiful UI** - Professional audit log dashboard with filters
5. **Relationship** - User → auditLogs (one-to-many relationship)

---

### 💡 Usage in Your App:

**In BlotterController** (already tracked by observer):
```php
$blotter = BlotterRecord::create($data); // ← Automatically logged
```

**In AssetController** (already tracked by observer):
```php
$asset = Asset::create($data);      // ← Automatically logged
$asset->update($data);              // ← Automatically logged
$asset->delete();                   // ← Automatically logged
```

**Custom actions**:
```php
// File: app/Http/Controllers/ReportController.php
public function export()
{
    // ... export logic ...
    ActivityLogger::log('report_export', 'Generated monthly report');
}
```

---

### 🔗 Database Schema:

```sql
audit_logs table:
- id (primary key)
- user_id (foreign key → users)
- action (string) - 'created', 'updated', 'deleted', 'login', 'logout', etc.
- details (text) - Description like "Created BlotterRecord (ID: 45)"
- created_at, updated_at (timestamps)
```

---

### ✨ That's It!

Your app now has complete user activity tracking. Every action on observed models is automatically logged, you can manually log custom actions, and admins can view everything via the Audit Logs dashboard.
