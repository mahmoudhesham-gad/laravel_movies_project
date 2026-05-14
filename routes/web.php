<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\FavoriteMovieController;
use App\Http\Controllers\UserController;

Route::get('/', [MovieController::class, 'index'])->name('home');

Route::get('/search', [MovieController::class, 'search'])->name('movies.search');

Route::get('/movies/{imdbId}', [MovieController::class, 'show'])->name('movies.show');

Route::get('/favorites', [FavoriteMovieController::class, 'index'])
    ->name('favorites.index')
    ->middleware('auth');

Route::post('/favorites', [FavoriteMovieController::class, 'store'])
    ->name('favorites.store')
    ->middleware('auth');

Route::delete('/favorites/{favoriteMovie}', [FavoriteMovieController::class, 'destroy'])
    ->name('favorites.destroy')
    ->middleware('auth');

Route::get('/profile', [UserController::class, 'profile'])
    ->name('profile')
    ->middleware('auth');

Route::post('/profile', [UserController::class, 'updateProfilePicture'])
    ->name('profile.update')
    ->middleware('auth');

Route::get('/login', [AuthController::class, 'showLoginForm'])
    ->name('login')
    ->middleware('guest');

Route::get('/register', [AuthController::class, 'showRegisterForm'])
    ->name('register')
    ->middleware('guest');

Route::post('/login', [AuthController::class, 'login'])->middleware('guest');

Route::post('/register', [AuthController::class, 'register'])->middleware('guest');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');
