<?php

use App\Http\Controllers\BookingRequestController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */

Route::get('/', function () {
    return to_route('login');
});

Route::middleware('auth')->group(function () {

    Route::controller(DashboardController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('dashboard');
    })->middleware(['verified']);


    Route::resource('users', UserController::class);
    Route::get('users-all', action: [UserController::class, 'users'])->name('users.all');

    Route::resource('places', PlaceController::class);
    Route::put('disactive-review/{review}', action: [PlaceController::class, 'disactive_review'])->name('places.review');


    Route::controller(BookingRequestController::class)->group(function () {
        Route::get('pending-bookings', 'pending_booking')->name('pending_booking');
        Route::get('approved-bookings', 'approved_booking')->name('approved_booking');
        Route::get('rejected-bookings', 'rejected_booking')->name('rejected_booking');
        Route::put('requests-approve/{booking}', 'booking_approve')->name('booking_approve');
        Route::put('booking-requests/{booking}', 'booking_reject')->name('booking_reject');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
