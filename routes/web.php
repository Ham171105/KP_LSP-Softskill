<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/tutorial', function () { return view('tutorial.index'); })->name('tutorial');
    Route::get('/dashboard/category/{category}', [DashboardController::class, 'showCategory'])->name('dashboard.category');
    
    Route::post('/category/{category}/certificates', [CertificateController::class, 'store'])->name('certificates.store');
    Route::put('/certificates/{certificate}', [CertificateController::class, 'update'])->name('certificates.update');
    Route::delete('/certificates/{certificate}', [CertificateController::class, 'destroy'])->name('certificates.destroy');
    Route::get('/dashboard/category/{category}/export', [CertificateController::class, 'export'])->name('certificates.export');
    
    Route::get('/category/{category}/export', [CertificateController::class, 'export'])->name('certificates.export');
    Route::post('/category/{category}/import', [CertificateController::class, 'import'])->name('certificates.import');
    
    // Print Certificate route
    Route::get('/certificates/{certificate}/print/front', [CertificateController::class, 'printFront'])->name('certificates.print.front');
    Route::get('/certificates/{certificate}/print/back', [CertificateController::class, 'printBack'])->name('certificates.print.back');
    
    // Template Settings
    Route::post('/settings/templates/{category}', [\App\Http\Controllers\TemplateSettingController::class, 'store'])->name('settings.templates.store');
});
