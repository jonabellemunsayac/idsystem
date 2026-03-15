<?php

use App\Http\Controllers\ResidentController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\BlotterController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\ClanController;
use App\Http\Controllers\IDController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ResidentPortalController;
use App\Http\Controllers\QRAuthController;
use App\Http\Controllers\Settings\ProfileController;
use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\Settings\TwoFactorAuthenticationController;
use App\Http\Controllers\Settings\UserAccountController;
use App\Http\Controllers\Admin\AppointmentController as AdminAppointmentController;
use App\Http\Controllers\Admin\CertificateController as AdminCertificateController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\ResidentLoginController;
use App\Http\Controllers\SiteEditorController;
use App\Http\Controllers\PublicPageController;
use App\Http\Controllers\QueryEditorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// CSRF token refresh endpoint (keeps long forms alive)
Route::get('/csrf-refresh', function () {
    return response()->json(['token' => csrf_token()]);
})->name('csrf.refresh');

// Public website routes (dynamic from database)
Route::get('/', [PublicPageController::class, 'home'])->name('public.home');
Route::get('/about', fn () => app(PublicPageController::class)->show('about'))->name('public.about');
Route::get('/services', fn () => app(PublicPageController::class)->show('services'))->name('public.services');
Route::get('/news', fn () => app(PublicPageController::class)->show('news'))->name('public.news');
Route::get('/contact', fn () => app(PublicPageController::class)->show('contact'))->name('public.contact');

// Admin and resident portals
Route::get('/portal', function () {
    if (auth()->check()) {
        return in_array(auth()->user()->role, ['encoder', 'site_editor', 'admin', 'superadmin'])
            ? redirect()->route('dashboard') 
            : redirect()->route('resident.dashboard');
    }
    return redirect()->route('login');
})->name('portal');

// Resident Login (visible in public website only)
Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::post('/login', [ResidentLoginController::class, 'store'])->name('login.store');
});

// Admin Login (protected route - not exposed in public website)
Route::middleware('guest:web')->prefix('admin')->group(function () {
    Route::get('/login', function () {
        return view('auth.admin-login');
    })->name('admin.login');

    Route::post('/login', [AdminLoginController::class, 'store'])->name('admin.login.store');
});

// Public Registration (accessible to everyone, controller handles auth check)
Route::get('/register', [ResidentController::class, 'publicRegisterForm'])
    ->name('public.register');

Route::post('/register', [ResidentController::class, 'publicRegisterStore'])
    ->name('public.register.store');

// QR Authentication (public but secure token-based)
Route::get('/qr/authenticate/{token}', [QRAuthController::class, 'authenticate'])->name('qr.authenticate');

// Public API routes (accessible to anyone)
Route::get('/api/appointments/booked-slots/{date}', [AppointmentController::class, 'getBookedSlots'])->name('api.appointments.booked-slots');
Route::post('/api/appointments/check-slot-availability', [AppointmentController::class, 'checkSlotAvailability'])->name('api.appointments.check-slot-availability');

// Protected admin routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Dashboard export routes
    Route::get('/dashboard/export/summary-csv', [DashboardController::class, 'exportSummaryCSV'])->name('dashboard.export.summary.csv');
    Route::get('/dashboard/export/summary-pdf', [DashboardController::class, 'exportSummaryPDF'])->name('dashboard.export.summary.pdf');

    // Residents Management (encoder, admin, superadmin)
    Route::middleware('role:encoder,admin,superadmin')->group(function () {
        Route::get('residents/search', [ResidentController::class, 'searchJson'])->name('residents.search');
        Route::resource('residents', ResidentController::class);
        Route::get('residents/export/excel', [ResidentController::class, 'export'])->name('residents.export');

        // Clans Management
        Route::get('clans/{clan}/members', [ClanController::class, 'getMembers'])->name('clans.members');
        Route::resource('clans', ClanController::class);

        // IDs Management
        Route::get('/api/residents/search', [IDController::class, 'searchResidents'])->name('api.residents.search');
        Route::post('/api/ids/generate', [IDController::class, 'generateID'])->name('api.ids.generate');
        Route::post('/api/ids/log-print', [IDController::class, 'logPrint'])->name('api.ids.log-print');
        Route::resource('ids', IDController::class);

        // Certificates Management (encoder, admin, superadmin)
        Route::get('certificates/template/download/{type}', [CertificateController::class, 'downloadTemplate'])->name('certificates.template.download');
        Route::get('certificates/template/file/{type}', [CertificateController::class, 'getTemplateFile'])->name('certificates.template.file');
        Route::get('certificates/word-template/{type}/{resident?}', [CertificateController::class, 'wordTemplate'])->name('certificates.word.template');
        Route::get('certificates/editor', [CertificateController::class, 'editor'])->name('certificates.editor');
        Route::post('certificates/print-log', [CertificateController::class, 'logPrinted'])->name('certificates.print-log');
        Route::resource('certificates', CertificateController::class);
        Route::patch('certificates/{certificate}/approve', [CertificateController::class, 'approve'])->name('certificates.approve');
    });

    // Appointments, Blotter, Assets, Certificates, Reports (admin, superadmin)
    Route::middleware('role:admin,superadmin')->group(function () {
        // Appointments Management
        Route::post('/appointments/check-slot-availability', [AppointmentController::class, 'checkSlotAvailability'])->name('appointments.checkSlotAvailability');
        Route::get('/appointments/booked-slots/{date}', [AppointmentController::class, 'getBookedSlots'])->name('appointments.getBookedSlots');
        Route::resource('appointments', AppointmentController::class);
        Route::patch('appointments/{appointment}/approve', [AppointmentController::class, 'approve'])->name('appointments.approve');

        // Blotter Records
        Route::resource('blotter', BlotterController::class);
        Route::get('/blotter', [BlotterController::class, 'index'])->name('blotter.index');
        Route::get('/api/blotter/{id}', function ($id) {
            $case = \App\Models\BlotterRecord::findOrFail($id);
            return response()->json(['success' => true, 'data' => $case]);
        })->name('api.blotter.show');

        // Assets Management
        Route::resource('assets', AssetController::class);
        Route::get('/api/assets/{id}', function ($id) {
            $asset = \App\Models\Asset::findOrFail($id);
            return response()->json(['success' => true, 'data' => $asset]);
        })->name('api.assets.show');

        // Reports & Analytics
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/api/reports/demographics', [ReportController::class, 'getResidentDemographics'])->name('api.reports.demographics');
        Route::get('/api/reports/demographic-stats', [ReportController::class, 'getDemographics'])->name('api.reports.demographic-stats');
        Route::get('/api/reports/street-stats', [ReportController::class, 'getStreetStats'])->name('api.reports.street-stats');
        Route::get('/api/reports/street-names', [ReportController::class, 'getStreetNames'])->name('api.reports.street-names');
        Route::get('/api/reports/gender-distribution', [ReportController::class, 'getGenderDistribution'])->name('api.reports.gender-distribution');
        Route::get('/api/reports/age-group-distribution', [ReportController::class, 'getAgeGroupDistribution'])->name('api.reports.age-group-distribution');
        Route::get('/api/reports/special-sector-distribution', [ReportController::class, 'getSpecialSectorDistribution'])->name('api.reports.special-sector-distribution');
        Route::get('/api/reports/street-distribution', [ReportController::class, 'getStreetDistribution'])->name('api.reports.street-distribution');
        Route::get('/api/reports/appointments', [ReportController::class, 'getMonthlyAppointments'])->name('api.reports.appointments');
        Route::get('/api/reports/blotter', [ReportController::class, 'getBlotterStatistics'])->name('api.reports.blotter');
        Route::get('/api/reports/assets', [ReportController::class, 'getAssetUtilization'])->name('api.reports.assets');
        Route::get('/api/reports/dashboard-stats', [ReportController::class, 'getDashboardStats'])->name('api.reports.dashboard-stats');
        Route::get('/api/reports/export/pdf', [ReportController::class, 'exportPDF'])->name('api.reports.export.pdf');
        Route::get('/api/reports/export/excel', [ReportController::class, 'exportExcel'])->name('api.reports.export.excel');

        // Query Editor
        Route::get('/query-editor', [QueryEditorController::class, 'index'])->name('query-editor.index');
        Route::post('/query-editor/execute', [QueryEditorController::class, 'executeQuery'])->name('query-editor.execute');
        Route::get('/query-editor/table/{tableName}/structure', [QueryEditorController::class, 'getTableStructure'])->name('query-editor.table.structure');
        Route::get('/query-editor/table/{tableName}/preview', [QueryEditorController::class, 'previewTable'])->name('query-editor.table.preview');
    });

    // Site Editor (site_editor, admin, superadmin)
    Route::middleware('role:site_editor,admin,superadmin')->group(function () {
        Route::get('site-editor', [SiteEditorController::class, 'index'])->name('site-editor.index');
        Route::get('site-editor/{sitePage}/edit', [SiteEditorController::class, 'edit'])->name('site-editor.edit');
        Route::put('site-editor/{sitePage}', [SiteEditorController::class, 'update'])->name('site-editor.update');
        Route::post('site-editor/upload-image', [SiteEditorController::class, 'uploadImage'])->name('site-editor.upload-image');
        Route::post('site-editor/{sitePage}/add-section', [SiteEditorController::class, 'addSection'])->name('site-editor.add-section');
        Route::post('site-editor/{sitePage}/remove-section', [SiteEditorController::class, 'removeSection'])->name('site-editor.remove-section');
        Route::post('site-editor/{sitePage}/meta', [SiteEditorController::class, 'updateMeta'])->name('site-editor.update-meta');
        Route::get('site-editor/{sitePage}/preview', [SiteEditorController::class, 'preview'])->name('site-editor.preview');
    });

    // Superadmin-only routes
    Route::middleware('role:superadmin')->group(function () {
        // Audit Logs
        Route::resource('audit-logs', AuditLogController::class)->only(['index', 'show']);

        // User Management
        Route::resource('users', \App\Http\Controllers\UserManagementController::class)->except(['show']);
    });

    // Settings (all authenticated staff)
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        Route::get('password', [PasswordController::class, 'edit'])->name('password.edit');
        Route::patch('password', [PasswordController::class, 'update'])->name('password.update');

        Route::get('two-factor', [TwoFactorAuthenticationController::class, 'show'])->name('two-factor.show');
        Route::post('two-factor/enable', [TwoFactorAuthenticationController::class, 'enable'])->name('two-factor.enable');
        Route::post('two-factor/disable', [TwoFactorAuthenticationController::class, 'disable'])->name('two-factor.disable');

        // User Account Settings
        Route::get('user-account', [UserAccountController::class, 'index'])->name('user-account.index');
        Route::patch('user-account/password', [UserAccountController::class, 'updatePassword'])->name('user-account.update-password');
    });

    // Admin-specific routes
    Route::prefix('admin')->name('admin.')->middleware('can:manage-system')->group(function () {
        Route::resource('appointments', AdminAppointmentController::class);
        Route::patch('appointments/{appointment}/status', [AdminAppointmentController::class, 'updateStatus'])->name('appointments.updateStatus');

        Route::get('certificates/template/download/{type}', [AdminCertificateController::class, 'downloadTemplate'])->name('certificates.template.download');
        Route::resource('certificates', AdminCertificateController::class);
        Route::patch('certificates/{certificate}/status', [AdminCertificateController::class, 'updateStatus'])->name('certificates.updateStatus');
    });


    // Admin Logout
    Route::post('/logout', function (Request $request) {
        auth()->guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    })->name('logout');
});

// Resident portal routes (uses resident guard)
Route::middleware(['auth:resident'])->prefix('resident')->name('resident.')->group(function () {
    Route::get('dashboard', [ResidentPortalController::class, 'dashboard'])->name('dashboard');
    Route::get('profile', [ResidentPortalController::class, 'profile'])->name('profile');
    Route::get('appointments', [ResidentPortalController::class, 'appointments'])->name('appointments');
    Route::get('certificates', [ResidentPortalController::class, 'certificates'])->name('certificates');
    Route::get('family', [ResidentPortalController::class, 'family'])->name('family');
    Route::get('request-certificate', [ResidentPortalController::class, 'requestCertificate'])->name('request-certificate');
    Route::get('book-appointment', [ResidentPortalController::class, 'bookAppointment'])->name('book-appointment');
    Route::post('logout', [QRAuthController::class, 'logout'])->name('logout');
});

// Resident API routes (uses resident guard)
Route::middleware(['auth:resident'])->prefix('api/resident')->name('api.resident.')->group(function () {
    // Appointments API
    Route::get('/appointments', [AppointmentController::class, 'apiIndex'])->name('appointments.index');
    Route::post('/appointments', [AppointmentController::class, 'apiStore'])->name('appointments.store');
    Route::get('/appointments/{id}', [AppointmentController::class, 'apiShow'])->name('appointments.show');
    Route::put('/appointments/{id}', [AppointmentController::class, 'apiUpdate'])->name('appointments.update');
    Route::delete('/appointments/{id}', [AppointmentController::class, 'apiDestroy'])->name('appointments.destroy');
    
    // Certificates API
    Route::get('/certificates', [CertificateController::class, 'apiIndex'])->name('certificates.index');
    Route::post('/certificates', [CertificateController::class, 'apiStore'])->name('certificates.store');
    Route::get('/certificates/{id}', [CertificateController::class, 'apiShow'])->name('certificates.show');
    Route::post('/certificates/{id}/cancel', [CertificateController::class, 'apiCancel'])->name('certificates.cancel');
});
