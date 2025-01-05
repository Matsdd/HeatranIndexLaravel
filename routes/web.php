<?php

use App\Models\Card;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;

// Login Routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Registration Routes
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register'])->name('register');

Route::get('/profile', [ProfileController::class, 'user'])->middleware('auth')->name('profile');
Route::post('/profile-picture/upload', [ProfileController::class, 'uploadProfilePicture'])->name('profile-picture.upload');
Route::delete('/profile-picture/remove', [ProfileController::class, 'removeProfilePicture'])->name('profile-picture.remove');
Route::get('/profile-picture/{filename}', [ProfileController::class, 'getProfilePicture'])
    ->name('profile.picture')
    ->middleware(['auth']);

Route::get('/admin/cards', [CardController::class, 'adminIndex']);
Route::get('/admin/users', [AdminController::class, 'index'])->name('admin.users');
Route::delete('/admin/users/{id}', [AdminController::class, 'destroy'])->name('admin.deleteUser');

Route::resource('cards', CardController::class)->middleware('auth');
Route::get('/discover', [CardController::class, 'discover'])->name('cards.discover');
Route::get('/cards/{card}', [CardController::class, 'show']);
Route::get('/cards/{card}/edit', [CardController::class, 'edit'])->name('cards.edit')->middleware('auth');
Route::put('/cards/{card}', [CardController::class, 'update'])->name('cards.update')->middleware('auth');
Route::get('/create', [CardController::class, 'create'])->name('cards.create')->middleware('auth');
Route::delete('/cards/{card}', [CardController::class, 'destroy'])->name('cards.destroy')->middleware('auth');

Route::post('/store', [CardController::class, 'store'])->name('cards.store')->middleware('auth');
Route::post('/cards/{card}/favorite', [CardController::class, 'favorite'])->name('cards.favorite');
Route::delete('/cards/{card}/unfavorite', [CardController::class, 'unfavorite'])->name('cards.unfavorite');

// Dashboard Route (example of a protected route)
Route::get('/', function () {
    return view('cards.discover',[
        'cards' => Card::all()
    ]);
})->middleware('auth');
