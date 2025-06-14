<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\MusicController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TradeController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\VotingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Rotas Públicas
Route::get('/', function () {
    return view('home');
});

// Rotas de Autenticação
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
    Route::get('forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

// Rotas protegidas por autenticação
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    
    // Verificação de email
    Route::get('email/verify', [AuthController::class, 'showVerifyEmailNotice'])->name('verification.notice');
    Route::get('email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])->middleware('signed')->name('verification.verify');
    Route::post('email/verification-notification', [AuthController::class, 'sendVerificationEmail'])->middleware('throttle:6,1')->name('verification.send');

    // Dashboard
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    
    // Perfil do usuário
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('profile.index');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/update', [ProfileController::class, 'update'])->name('profile.update');
        Route::get('/extended', [ProfileController::class, 'extended'])->name('profile.extended');
        Route::post('/extended', [ProfileController::class, 'storeExtended'])->name('profile.extended.store');
    });
    
    // Grupos
    Route::resource('groups', GroupController::class)->except(['show']);
    Route::get('groups/{group}', [GroupController::class, 'show'])->name('groups.show');
    
    // Músicas
    Route::resource('musics', MusicController::class);
    Route::post('musics/{music}/rate', [MusicController::class, 'rate'])->name('musics.rate.store');
    Route::get('musics/{music}/rate', [MusicController::class, 'showRateForm'])->name('musics.rate');
    
    // Eventos
    Route::resource('events', EventController::class);
    Route::post('events/{event}/participate', [EventController::class, 'participate'])->name('events.participate');
    Route::delete('events/{event}/participate', [EventController::class, 'cancelParticipation'])->name('events.participate.cancel');
    
    // Trocas
    Route::resource('trades', TradeController::class)->except(['edit', 'update']);
    Route::get('trades/manage', [TradeController::class, 'manage'])->name('trades.manage');
    Route::post('trades/{trade}/accept', [TradeController::class, 'accept'])->name('trades.accept');
    Route::delete('trades/{trade}/reject', [TradeController::class, 'reject'])->name('trades.reject');
    Route::delete('trades/{trade}/cancel', [TradeController::class, 'cancel'])->name('trades.cancel');
    
    // Área Administrativa
    Route::prefix('admin')->middleware('can:access-admin-panel')->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        
        // Gerenciamento de Usuários
        Route::resource('users', UserController::class)->except(['show']);
        
        // Gerenciamento de Permissões
        Route::get('permissions', [PermissionController::class, 'index'])->name('admin.permissions');
        Route::post('permissions', [PermissionController::class, 'store'])->name('admin.permissions.store');
        Route::put('permissions/{permission}', [PermissionController::class, 'update'])->name('admin.permissions.update');
        Route::delete('permissions/{permission}', [PermissionController::class, 'destroy'])->name('admin.permissions.destroy');
        Route::post('roles/{role}/permissions', [PermissionController::class, 'updateRolePermissions'])->name('admin.roles.permissions.update');
        
        // Votações
        Route::resource('votings', VotingController::class);
        Route::post('votings/{voting}/start', [VotingController::class, 'start'])->name('admin.votings.start');
        Route::post('votings/{voting}/close', [VotingController::class, 'close'])->name('admin.votings.close');
    });
});