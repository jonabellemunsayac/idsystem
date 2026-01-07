# User Activity Tracking - Visual Flow Diagrams

## 1. MODEL CHANGE TRACKING FLOW

```
┌─────────────────────────────────────────────────────────────┐
│              USER ACTION IN ADMIN                            │
├─────────────────────────────────────────────────────────────┤
│                                                              │
│  Admin clicks "Create Case" → Form submitted               │
│           ↓                                                 │
│  BlotterRecord::create($data)                              │
│           ↓                                                 │
│  Database: INSERT INTO blotter_records                     │
│           ↓                                                 │
│  ⚡ Observer Event Triggered: "created"                   │
│           ↓                                                 │
│  AuditableModelObserver::created()                         │
│           ↓                                                 │
│  ActivityLogger::logCreated('BlotterRecord', $model)       │
│           ↓                                                 │
│  AuditLog::create([                                        │
│    'user_id' => 1,                                         │
│    'action' => 'created',                                  │
│    'details' => 'Created BlotterRecord (ID: 45)'           │
│  ])                                                         │
│           ↓                                                 │
│  Database: INSERT INTO audit_logs                          │
│           ↓                                                 │
│  ✅ Activity logged and visible in /audit-logs             │
│                                                              │
└─────────────────────────────────────────────────────────────┘
```

## 2. LOGIN TRACKING FLOW

```
┌─────────────────────────────────────────────────────────────┐
│              USER LOGIN                                      │
├─────────────────────────────────────────────────────────────┤
│                                                              │
│  User enters credentials                                    │
│           ↓                                                 │
│  Login form submitted to /login                            │
│           ↓                                                 │
│  AuthManager validates credentials                         │
│           ↓                                                 │
│  ✅ User authenticated                                     │
│           ↓                                                 │
│  Request passes through middleware stack                   │
│           ↓                                                 │
│  ⚡ LogAuthenticationEvents middleware runs                 │
│           ↓                                                 │
│  Check: Auth::check() && !session()->has('logged_in_tracked')
│           ↓                                                 │
│  Get user IP: request()->ip()                              │
│           ↓                                                 │
│  ActivityLogger::logLogin($user->id, $ip)                  │
│           ↓                                                 │
│  AuditLog::create([                                        │
│    'user_id' => 1,                                         │
│    'action' => 'login',                                    │
│    'details' => 'User logged in from IP: 192.168.1.100'    │
│  ])                                                         │
│           ↓                                                 │
│  Set session: logged_in_tracked = true                     │
│           ↓                                                 │
│  ✅ Login logged and dashboard loads                       │
│                                                              │
└─────────────────────────────────────────────────────────────┘
```

## 3. MANUAL CUSTOM ACTION TRACKING FLOW

```
┌─────────────────────────────────────────────────────────────┐
│              EXPORT OPERATION                                │
├─────────────────────────────────────────────────────────────┤
│                                                              │
│  User clicks "Export Reports"                              │
│           ↓                                                 │
│  ReportController::export() called                         │
│           ↓                                                 │
│  Query: $records = BlotterRecord::all();                   │
│           ↓                                                 │
│  Generate: Create PDF/CSV file                             │
│           ↓                                                 │
│  💡 Developer adds manual logging:                         │
│                                                              │
│    ActivityLogger::log(                                    │
│      'export',                                             │
│      'Exported ' . count($records) . ' blotter records'    │
│    );                                                       │
│           ↓                                                 │
│  AuditLog::create([                                        │
│    'user_id' => 1,                                         │
│    'action' => 'export',                                   │
│    'details' => 'Exported 150 blotter records'             │
│  ])                                                         │
│           ↓                                                 │
│  return response()->download($file);                       │
│           ↓                                                 │
│  ✅ User gets file AND action is logged                    │
│                                                              │
└─────────────────────────────────────────────────────────────┘
```

## 4. AUDIT LOG VIEWING FLOW

```
┌─────────────────────────────────────────────────────────────┐
│              AUDIT LOG DASHBOARD                             │
├─────────────────────────────────────────────────────────────┤
│                                                              │
│  Admin clicks "Audit Logs" in sidebar                       │
│           ↓                                                 │
│  GET /audit-logs                                           │
│           ↓                                                 │
│  AuditLogController::index()                               │
│           ↓                                                 │
│  Build query:                                              │
│  $query = AuditLog::with('user');                          │
│           ↓                                                 │
│  Check filters:                                            │
│  - user_id?     → where('user_id', $userId)                │
│  - action?      → where('action', $action)                 │
│  - date?        → whereDate('created_at', $date)           │
│  - search?      → where('details', 'like', '%...%')        │
│           ↓                                                 │
│  Order & Paginate:                                         │
│  orderBy('created_at', 'desc')->paginate(50)               │
│           ↓                                                 │
│  Pass data to view:                                        │
│  view('audit-logs.index', [                                │
│    'logs' => $logs,    // Paginated results                │
│    'users' => $users,  // For filter dropdown              │
│    'actions' => $actions  // For action dropdown           │
│  ])                                                         │
│           ↓                                                 │
│  Blade renders:                                            │
│  @forelse($logs as $log)                                   │
│    <table row with: timestamp, user, action, details>      │
│  @empty                                                    │
│    No activities found                                     │
│  @endforelse                                               │
│           ↓                                                 │
│  ✅ Admin sees all tracked activities                      │
│                                                              │
└─────────────────────────────────────────────────────────────┘
```

## 5. DATA STORAGE ARCHITECTURE

```
┌─────────────────────────────────────────────────────────────┐
│                   DATABASE TABLES                            │
├─────────────────────────────────────────────────────────────┤
│                                                              │
│  users                                                       │
│  ├── id (PK)              ┐                                │
│  ├── name                 │                                │
│  ├── email                │                                │
│  ├── password             │                                │
│  ├── role                 │                                │
│  └── ...                  │                                │
│                           │                                │
│  audit_logs              │ (Relationship)                   │
│  ├── id (PK)             │                                │
│  ├── user_id (FK) ────────┴─ Points to users.id           │
│  ├── action              │  'created', 'updated', etc.    │
│  ├── details             │  Full description              │
│  ├── created_at          │  When it happened              │
│  └── updated_at          │                                │
│                                                              │
│  blotter_records                                            │
│  ├── id (PK)                                               │
│  ├── case_number                                           │
│  ├── complainant_name                                      │
│  ├── ... other fields ...                                  │
│  ├── created_at                                            │
│  └── updated_at                                            │
│       ↓ (Triggers Observer)                                │
│       └─→ AuditLog entry created                          │
│                                                              │
│  assets                                                     │
│  ├── id (PK)                                               │
│  ├── name                                                  │
│  ├── status                                                │
│  ├── ... other fields ...                                  │
│  ├── created_at                                            │
│  └── updated_at                                            │
│       ↓ (Triggers Observer)                                │
│       └─→ AuditLog entry created                          │
│                                                              │
│  residents                                                  │
│  ├── id (PK)                                               │
│  ├── name                                                  │
│  ├── age                                                   │
│  ├── ... other fields ...                                  │
│  ├── created_at                                            │
│  └── updated_at                                            │
│       ↓ (Triggers Observer)                                │
│       └─→ AuditLog entry created                          │
│                                                              │
└─────────────────────────────────────────────────────────────┘
```

## 6. TRACKED ACTIONS HIERARCHY

```
┌─────────────────────────────────────────────────────────────┐
│              AUDIT LOG ACTIONS                               │
├─────────────────────────────────────────────────────────────┤
│                                                              │
│  AUTOMATIC (via Observer)                                   │
│  ├── created   [GREEN]   - New record created              │
│  ├── updated   [BLUE]    - Record modified                 │
│  ├── deleted   [RED]     - Record removed                  │
│  ├── restored  [YELLOW]  - Soft-delete restored            │
│  └── force_deleted [BLACK] - Permanently deleted           │
│                                                              │
│  AUTHENTICATION (via Middleware)                            │
│  ├── login    [BLUE]  - User logged in (with IP)          │
│  └── logout   [ORANGE] - User logged out                  │
│                                                              │
│  CUSTOM (via Manual Logging)                               │
│  ├── viewed    [GRAY]   - Record viewed                    │
│  ├── export    [PURPLE] - Data exported                    │
│  ├── import    [PURPLE] - Data imported                    │
│  ├── bulk_update [CYAN] - Batch operation                  │
│  ├── report    [TEAL]   - Report generated                 │
│  └── ... any custom action you log ...                     │
│                                                              │
└─────────────────────────────────────────────────────────────┘
```

## 7. CLASS RELATIONSHIPS DIAGRAM

```
┌─────────────────────────────────────────────┐
│          ActivityLogger (Service)            │
│                                              │
│  Methods:                                   │
│  + log(action, details)                     │
│  + logCreated(modelName, model)             │
│  + logUpdated(modelName, model)             │
│  + logDeleted(modelName, model)             │
│  + logLogin(userId, ipAddress)              │
│  + logLogout(userId)                        │
│  + getUserActivity(userId)                  │
│  + getActionActivity(action)                │
│  + getRecentActivity()                      │
└─────────────────────────┬────────────────────┘
                          │ Calls
                          ↓
┌─────────────────────────────────────────────┐
│       AuditLog::create() (Model)             │
│                                              │
│  Fields:                                    │
│  - id (PK)                                  │
│  - user_id (FK)                             │
│  - action                                   │
│  - details                                  │
│  - created_at                               │
│  - updated_at                               │
└─────────────────────────┬────────────────────┘
                          │ Belongs To
                          ↓
┌─────────────────────────────────────────────┐
│         User (Model)                         │
│                                              │
│  New Relationship:                          │
│  + auditLogs() → HasMany AuditLog           │
└─────────────────────────────────────────────┘
        ↑        ↑        ↑
        │        │        │
    Observes (via AppServiceProvider)
        │        │        │
    ┌───┴────┐ ┌─┴───┐ ┌─┴────────┐
    │         │ │     │ │          │
┌───────┐ ┌────────┐ ┌───────────┐
│Blotter│ │ Asset  │ │ Resident  │
│Record │ │ (Model)│ │ (Model)   │
│(Model)│ └────────┘ └───────────┘
└───────┘
    ↓ ↓ ↓ (Trigger Events)
    └─┴─┴───→ AuditableModelObserver
          (Listens for: created, updated, deleted, restored, forceDeleted)
                  ↓
            ActivityLogger::log()
                  ↓
            AuditLog::create()
```

## 8. MIDDLEWARE EXECUTION FLOW

```
HTTP Request
    ↓
┌─────────────────────────────────────┐
│  Global Middleware Stack            │ (bootstrap/app.php)
├─────────────────────────────────────┤
│                                     │
│  ⬜ Other Middleware...             │
│  ⬜ EncryptCookies                  │
│  ⬜ Session                         │
│  ⬜ Auth                            │
│                                     │
│  ⚡ LogAuthenticationEvents         │ ← OUR MIDDLEWARE
│     ├─ Check: Auth::check()         │
│     ├─ Check: session('logged_in_tracked') │
│     ├─ If not set:                  │
│     │   - Get User ID               │
│     │   - Get IP Address            │
│     │   - ActivityLogger::logLogin() │
│     │   - Set session flag          │
│     └─ Pass to next                 │
│                                     │
│  ⬜ Other Middleware...             │
│                                     │
└─────────────────────────────────────┘
    ↓
Controller & Action Executed
    ↓
Response sent to User
```

---

**Legend:**
- ⚡ = Our custom component
- ✅ = Complete/Success
- 💡 = Developer action point
- 🟢🔵🔴⚫🟣 = Color codes for audit log actions

