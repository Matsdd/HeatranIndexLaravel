<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// Login Routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Registration Routes
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register'])->name('register');

Route::middleware('admin')->group(function () {
    Route::get('/admin/cards', [CardController::class, 'adminIndex']);
    // Other admin routes...
});


// Dashboard Route (example of a protected route)
Route::get('/', function () {
    return view('dashboard');
})->middleware('auth');
