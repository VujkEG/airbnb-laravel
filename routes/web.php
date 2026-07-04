<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\ApartmanController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminApartmanController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminBookingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\WishlistController;

// Javne rute za smeštaj i stranice
Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle')->middleware('auth');
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store')->middleware('auth');
Route::delete('/rezervacije/{id}/otkazi', [BookingController::class, 'destroy'])->name('bookings.destroy');
Route::get('/moje-rezervacije', [BookingController::class, 'myBookings'])->name('bookings.my')->middleware('auth');
Route::post('/rezervisi', [BookingController::class, 'store'])->name('bookings.store');

Route::get('/smestaj/{product}', [ApartmanController::class, 'show'])->name('smestaj.show');
Route::get('/', [HomeController::class, 'index'])->name('home');

// POPRAVLJENO: URL adresa promenjena sa /shop na /smestaji, dok ime rute 'shop' ostaje radi stabilnosti pretrage
Route::get('/smestaji', [ApartmanController::class, 'index'])->name('shop');
Route::get('/o-nama', [HomeController::class, 'about'])->name('about');

// Laravel Auth rute (Login, Register, Logout)
Auth::routes();

Route::resource('kategorija', CategoryController::class);
Route::resource('post', App\Http\Controllers\PostController::class);

// =======================================================
// DOMAĆIN PANEL RUTE
// =======================================================
Route::prefix('host')->name('host.')->middleware(['auth', 'host'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    Route::get('/kalendar', [AdminController::class, 'calendarView'])->name('calendar');
    Route::get('/kalendar/events', [AdminController::class, 'getCalendarEvents'])->name('calendar.events');
    
    Route::resource('smestaji', AdminApartmanController::class)->names('proizvodi');
    Route::resource('rezervacije', AdminBookingController::class)->names('narudzbine')->only(['index', 'show', 'update', 'destroy']);
});

// =======================================================
// ADMIN PANEL RUTE
// =======================================================
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    Route::get('/kalendar', [AdminController::class, 'calendarView'])->name('calendar');
    Route::get('/kalendar/events', [AdminController::class, 'getCalendarEvents'])->name('calendar.events');
    
    Route::resource('smestaji', AdminApartmanController::class)->names('proizvodi');
    Route::resource('regije', AdminCategoryController::class)->names('kategorije');
    Route::resource('rezervacije', AdminBookingController::class)->names('narudzbine')->only(['index', 'show', 'update', 'destroy']);
});