<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\ReportController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\ClerkMiddleware;

// Authentication Routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Public Routes
Route::get('/', [HomeController::class, 'welcome'])->name('welcome');
Route::get('/rooms/availability', [RoomController::class, 'checkAvailability'])->name('rooms.availability');
Route::post('/reservations/public', [ReservationController::class, 'storePublic'])->name('reservations.public.store');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Reservation Clerk Routes (accessible to both clerks and admins)
    Route::middleware([ClerkMiddleware::class])->group(function () {
        Route::resource('customers', CustomerController::class);
        Route::resource('reservations', ReservationController::class)->except(['storePublic']);
        Route::post('reservations/{reservation}/checkin', [ReservationController::class, 'checkIn'])->name('reservations.checkin');
        Route::post('reservations/{reservation}/checkout', [ReservationController::class, 'checkOut'])->name('reservations.checkout');
        Route::post('reservations/{reservation}/cancel', [ReservationController::class, 'cancel'])->name('reservations.cancel');
        Route::post('reservations/{reservation}/services', [ReservationController::class, 'addService'])->name('reservations.addService');

        Route::resource('billings', BillingController::class);
        Route::post('billings/{billing}/process-payment', [BillingController::class, 'processPayment'])->name('billings.processPayment');
    });

    // Admin Only Routes
    Route::middleware([AdminMiddleware::class])->group(function () {
        Route::resource('rooms', RoomController::class);
        Route::get('reports/occupancy', [ReportController::class, 'occupancy'])->name('reports.occupancy');
        Route::get('reports/financial', [ReportController::class, 'financial'])->name('reports.financial');
        Route::get('reports/daily', [ReportController::class, 'dailyReport'])->name('reports.daily');
        Route::post('reports/generate-daily', [ReportController::class, 'generateDailyReport'])->name('reports.generateDaily');
    });
});
