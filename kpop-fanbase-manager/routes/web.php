<?php

// routes/web.php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SongController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// Authentication Routes
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Home Route
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Song Routes
Route::resource('songs', SongController::class)->only(['index', 'show']);
Route::post('/songs/{song}/rate', [SongController::class, 'rate'])->name('songs.rate')->middleware('auth');
Route::get('/search', [SongController::class, 'search'])->name('songs.search');

// Group Routes
Route::resource('groups', GroupController::class)->only(['index', 'show']);

// Event Routes
Route::resource('events', EventController::class);
Route::post('/events/{event}/participate', [EventController::class, 'participate'])->name('events.participate')->middleware('auth');

// Admin Routes
Route::prefix('admin')->middleware(['auth', 'can:access-admin'])->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::put('/users/{user}/roles', [AdminController::class, 'updateUserRole'])->name('admin.users.update-roles');
    Route::get('/groups', [AdminController::class, 'groups'])->name('admin.groups');
    Route::get('/events', [AdminController::class, 'events'])->name('admin.events');
});
