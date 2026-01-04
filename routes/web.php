<?php

use App\Http\Controllers\ResidentController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\ClanController;
use App\Http\Controllers\IDController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ResidentPortalController;
use App\Http\Controllers\QRAuthController;
use App\Http\Controllers\Settings\ProfileController;
use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\Settings\TwoFactorAuthenticationController;
use App\Http\Controllers\Admin\AppointmentController as AdminAppointmentController;
use App\Http\Controllers\Admin\CertificateController as AdminCertificateController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\ResidentLoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Root redirect
Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->role === 'admin' 
            ? redirect()->route('dashboard') 
            : redirect()->route('resident.dashboard');
    }
    return redirect()->route('login');
})->name('home');

// Guest only routes (login & register)
Route::middleware('guest')->group(function () {
    // Resident Login
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::post('/login', [ResidentLoginController::class, 'store'])->name('login.store');

    // Admin Login
    Route::get('/admin/login', function () {
        return view('auth.admin-login');
    })->name('admin.login');

    Route::post('/admin/login', [AdminLoginController::class, 'store'])->name('admin.login.store');
});

// Public Registration (accessible to everyone, controller handles auth check)
Route::get('/register', [ResidentController::class, 'publicRegisterForm'])
    ->name('public.register');

Route::post('/register', [ResidentController::class, 'publicRegisterStore'])
    ->name('public.register.store');

// QR Authentication (public but secure token-based)
Route::get('/qr/authenticate/{token}', [QRAuthController::class, 'authenticate'])->name('qr.authenticate');

// Protected admin routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Residents Management
    Route::resource('residents', ResidentController::class);

    // Appointments Management
    Route::resource('appointments', AppointmentController::class);
    Route::patch('appointments/{appointment}/approve', [AppointmentController::class, 'approve'])->name('appointments.approve');

    // Certificates Management
    Route::resource('certificates', CertificateController::class);
    Route::patch('certificates/{certificate}/approve', [CertificateController::class, 'approve'])->name('certificates.approve');

    // Clans Management
    Route::resource('clans', ClanController::class);

    // IDs Management
    Route::get('/api/residents/search', [IDController::class, 'searchResidents'])->name('api.residents.search');
    Route::post('/api/ids/generate', [IDController::class, 'generateID'])->name('api.ids.generate');
    Route::resource('ids', IDController::class);

    // Blotter Records
    Route::get('/blotter', function () {
        return view('blotter.index');
    })->name('blotter.index');

    // Assets Management
    Route::get('/assets', function () {
        return view('assets.index');
    })->name('assets.index');

    // Reports & Analytics
    Route::get('/reports', function () {
        return view('reports.index');
    })->name('reports.index');

    // Settings
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        Route::get('password', [PasswordController::class, 'edit'])->name('password.edit');
        Route::patch('password', [PasswordController::class, 'update'])->name('password.update');

        Route::get('two-factor', [TwoFactorAuthenticationController::class, 'show'])->name('two-factor.show');
        Route::post('two-factor/enable', [TwoFactorAuthenticationController::class, 'enable'])->name('two-factor.enable');
        Route::post('two-factor/disable', [TwoFactorAuthenticationController::class, 'disable'])->name('two-factor.disable');
    });

    // Admin-specific routes
    Route::prefix('admin')->name('admin.')->middleware('can:manage-system')->group(function () {
        Route::resource('appointments', AdminAppointmentController::class);
        Route::patch('appointments/{appointment}/status', [AdminAppointmentController::class, 'updateStatus'])->name('appointments.updateStatus');

        Route::resource('certificates', AdminCertificateController::class);
        Route::patch('certificates/{certificate}/status', [AdminCertificateController::class, 'updateStatus'])->name('certificates.updateStatus');
    });

    // Logout
    Route::post('/logout', function (Request $request) {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
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

