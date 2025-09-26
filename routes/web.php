<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\HotelController as AdminHotelController;

Route::prefix('admin')->group(function () {
    Route::get('/hotel', [AdminHotelController::class, 'create'])->name('admin.hotel.create');
    Route::post('/hotel', [AdminHotelController::class, 'store'])->name('admin.hotel.store');
});

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/change-password', [AuthController::class, 'login'])->name('profile.password');


Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


// About Us page
Route::view('/about', 'pages.about')->name('about');
// Terms & Conditions page
Route::view('/terms', 'pages.terms')->name('terms');
// Privacy Policy page
Route::view('/privacy', 'pages.privacy')->name('privacy');
Route::view('/contact', 'pages.contact')->name('contact');
// For processing form (POST)

Route::post('/contact', function (\Illuminate\Http\Request $request) {
    // You can process the form here:
    // Send email, store message, etc. For now, we'll just show a flash success.
    // Validate here as needed.
    return redirect()->back()->with('success', 'Thank you for contacting us! We will get back to you soon.');
})->name('contact.submit');


/*
|--------------------------------------------------------------------------
| Profile & Orders
|--------------------------------------------------------------------------
*/
Route::get('/profile', [OrderController::class, 'profile'])->name('profile');
Route::get('/profile/orders', [OrderController::class, 'index'])->name('profile.orders');
Route::get('/profile/orders/{id}', [OrderController::class, 'show'])->name('profile.orders.show');
Route::get('/autocomplete', [HomeController::class, 'autocomplete'])->name('autocomplete');
/*
|--------------------------------------------------------------------------
| Home & Search
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/autocomplete', [SearchController::class, 'cities'])->name('autocomplete');

/*
|--------------------------------------------------------------------------
| Hotels
|--------------------------------------------------------------------------
*/
Route::get('/hotel', [HotelController::class, 'all'])->name('hotels.all');
Route::get('/hotels', [HotelController::class, 'index'])->name('hotels.index'); // ?city=goa&...
Route::get('/hotel/{slug}', [HotelController::class, 'show'])->name('hotels.show');

/*
|--------------------------------------------------------------------------
| Tours
|--------------------------------------------------------------------------
*/
Route::get('/tours', [TourController::class, 'all'])->name('tours.all');
Route::get('/tours/search', [TourController::class, 'search'])->name('tours.search'); // AJAX suggestions
Route::get('/city-tour/{city?}', [TourController::class, 'index'])->name('tours.index');   // list tours of a city
Route::get('/tour/{id}', [TourController::class, 'show'])->name('tours.show');        // tour detail

/*
|--------------------------------------------------------------------------
| Flights
|--------------------------------------------------------------------------
*/
Route::get('/flights', [\App\Http\Controllers\FlightController::class, 'all'])->name('flights.all');
Route::get('/flights/search', [FlightController::class, 'search'])->name('flights.search'); // autocomplete
Route::get('/flights/{source}/{destination}', [FlightController::class, 'index'])->name('flights.index');
Route::get('/flight/{id}', [FlightController::class, 'show'])->name('flights.show');

/*
|--------------------------------------------------------------------------
| Cart
|--------------------------------------------------------------------------
*/
Route::post('/cart/add', [CartController::class, 'addHotelRoom'])->name('cart.add');
Route::post('/cart/add-tour', [CartController::class, 'addTour'])->name('cart.addTour');
Route::post('/cart/add-flight', [CartController::class, 'addFlight'])->name('cart.addFlight');
Route::get('/cart', [CartController::class, 'show'])->name('cart.show');
Route::get('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

/*
|--------------------------------------------------------------------------
| Checkout
|--------------------------------------------------------------------------
*/
Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.show');
Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');

/*
|--------------------------------------------------------------------------
| Blogs
|--------------------------------------------------------------------------
*/
Route::get('/blogs', function () {
    $blogs = DB::select("SELECT * FROM blogs ORDER BY published_at DESC");
    return view('blogs.index', compact('blogs'));
})->name('blogs.index');

Route::get('/blogs/{id}', function ($id) {
    $blog = DB::select("SELECT * FROM blogs WHERE id = ?", [$id])[0] ?? null;
    if (!$blog) {
        abort(404);
    }
    return view('blogs.show', compact('blog'));
})->name('blogs.show');


// ------------------
Route::get('/success', function () {
    return redirect()->back()->with('success', 'This is a success message!');
});

Route::get('/error', function () {
    return redirect()->back()->with('error', 'This is an error message!');
});