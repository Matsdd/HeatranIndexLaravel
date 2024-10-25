<?php

use App\Models\Card;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\ProfileController;

// Login Routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Registration Routes
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register'])->name('register');

Route::get('/profile', [ProfileController::class, 'user'])->name('profile')->middleware('auth');


Route::middleware('admin')->group(function () {
    Route::get('/admin/cards', [CardController::class, 'adminIndex']);
});

Route::resource('cards', CardController::class)->middleware('auth');
Route::get('/discover', [CardController::class, 'discover'])->name('cards.discover');
Route::get('/cards/{card}', [CardController::class, 'show']);
Route::get('/create', [CardController::class, 'create'])->name('cards.create')->middleware('auth');

Route::post('/store', [CardController::class, 'store'])->name('cards.store')->middleware('auth');
Route::post('/cards/{card}/favorite', [CardController::class, 'favorite'])->name('cards.favorite');
Route::delete('/cards/{card}/unfavorite', [CardController::class, 'unfavorite'])->name('cards.unfavorite');

// Dashboard Route (example of a protected route)
Route::get('/', function () {
    return view('cards.discover',[
        'cards' => Card::all()
    ]);
})->middleware('auth');
