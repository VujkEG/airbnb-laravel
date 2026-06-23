<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\WishlistController;

// Javne rute za smeštaj i stranice
Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle')->middleware('auth');
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store')->middleware('auth');
Route::delete('/rezervacije/{id}/otkazi', [BookingController::class, 'destroy'])->name('bookings.destroy');
Route::get('/moje-rezervacije', [BookingController::class, 'myBookings'])->name('bookings.my')->middleware('auth');
Route::post('/rezervisi', [BookingController::class, 'store'])->name('bookings.store');
Route::get('/smestaj/{product}', [ProductController::class, 'show'])->name('smestaj.show');
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/shop', [ProductController::class, 'index'])->name('shop');
Route::get('/o-nama', [HomeController::class, 'about'])->name('about');
Route::get('/korpa', [HomeController::class, 'index'])->name('cart.index');
Route::post('/korpa/dodaj/{id}', [HomeController::class, 'index'])->name('cart.add');

// Laravel Auth rute (Login, Register, Logout)
Auth::routes();

Route::resource('kategorija', CategoryController::class);
Route::resource('post', App\Http\Controllers\PostController::class);

// =======================================================
// DOMAĆIN PANEL RUTE (Sa lepim Airbnb URL-ovima)
// =======================================================
Route::prefix('host')->name('host.')->middleware(['auth', 'host'])->group(function () {
    // Dashboard za Hosta
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Rute za kalendar unutar host panela
    Route::get('/kalendar', [AdminController::class, 'calendarView'])->name('calendar');
    Route::get('/kalendar/events', [AdminController::class, 'getCalendarEvents'])->name('calendar.events');
    
    // URL postaje /host/smestaji ali unutrašnji naziv rute ostaje host.proizvodi
    Route::resource('smestaji', AdminProductController::class)->names('proizvodi');
    
    // POPRAVLJENO: Dodat 'destroy' u dozvoljene metode
    Route::resource('rezervacije', AdminOrderController::class)->names('narudzbine')->only(['index', 'show', 'update', 'destroy']);
});

// Zadržane i admin rute sa čistim i lepim adresama
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // DODATE RUTE ZA KALENDAR ZAUZETOSTI (FullCalendar API)
    Route::get('/kalendar', [AdminController::class, 'calendarView'])->name('calendar');
    Route::get('/kalendar/events', [AdminController::class, 'getCalendarEvents'])->name('calendar.events');
    
    // URL: /admin/smestaji -> Rutiranje mapa na: admin.proizvodi
    Route::resource('smestaji', AdminProductController::class)->names('proizvodi');
    
    // URL: /admin/regije -> Rutiranje mapa na: admin.kategorije
    Route::resource('regije', AdminCategoryController::class)->names('kategorije');
    
    // POPRAVLJENO: Dodat 'destroy' u dozvoljene metode za Admina
    Route::resource('rezervacije', AdminOrderController::class)->names('narudzbine')->only(['index', 'show', 'update', 'destroy']);
});