<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\MechanicController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ServiceDetailController;
use App\Http\Controllers\ServiceRegistrationController;
use App\Http\Controllers\SparepartController;
use App\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - MOTOVEL Precision Motorcycle Service
|--------------------------------------------------------------------------
*/

// ==========================================
// 1. PUBLIC WEBSITE ROUTES
// ==========================================
Route::get('/', [PublicController::class, 'landing'])->name('home');
Route::get('/about', [PublicController::class, 'about'])->name('about');
Route::get('/services', [PublicController::class, 'services'])->name('services');
Route::get('/gallery', [PublicController::class, 'gallery'])->name('gallery');
Route::get('/contact', [PublicController::class, 'contact'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Booking Engine Publik
Route::get('/booking', [BookingController::class, 'index'])->name('booking');
Route::get('/booking/check-phone', [BookingController::class, 'checkPhone'])->name('booking.check-phone');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
Route::get('/booking/success/{id}', [BookingController::class, 'success'])->name('booking.success');

// ==========================================
// 2. AUTHENTICATION ROUTES
// ==========================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// ==========================================
// 3. ADMIN DASHBOARD ROUTES (Protected)
// ==========================================
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 1. Data Pelanggan
    Route::resource('customers', CustomerController::class);

    // 2. Data Kendaraan
    Route::resource('vehicles', VehicleController::class);

    // 3. Data Mekanik
    Route::resource('mechanics', MechanicController::class);

    // 4. Pendaftaran Servis
    Route::resource('services', ServiceRegistrationController::class);

    // 5. Detail Pengerjaan Servis Teknis
    Route::resource('service-details', ServiceDetailController::class);

    // 6. Inventaris & Suku Cadang
    Route::resource('spareparts', SparepartController::class);

    // 7. Kasir & Pembayaran
    Route::get('payments/{payment}/print', [PaymentController::class, 'print'])->name('payments.print');
    Route::resource('payments', PaymentController::class);

    // 8. Riwayat Servis Lengkap
    Route::get('history', [HistoryController::class, 'index'])->name('history');

    // 9. Pusat Laporan & Analitik
    Route::get('reports', [ReportController::class, 'index'])->name('reports');
    Route::get('reports/print', [ReportController::class, 'print'])->name('reports.print');
});
