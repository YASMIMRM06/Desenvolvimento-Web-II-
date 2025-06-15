<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\MusicaController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\PerfilExtendidoController;
use App\Http\Controllers\ItemColecionavelController;
use App\Http\Controllers\TrocaController;

/*
|--------------------------------------------------------------------------
| Rotas Públicas
|--------------------------------------------------------------------------
*/

// Página inicial
Route::get('/', [HomeController::class, 'index'])->name('home');

// Página sobre
Route::get('/sobre', [HomeController::class, 'sobre'])->name('sobre');

// Busca
Route::get('/buscar', [HomeController::class, 'buscar'])->name('buscar');

/*
|--------------------------------------------------------------------------
| Rotas de Autenticação
|--------------------------------------------------------------------------
*/

Auth::routes(['verify' => true]);

/*
|--------------------------------------------------------------------------
| Rotas Protegidas (requerem autenticação)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {
    
    // Rotas de perfil do usuário
    Route::prefix('profile')->group(function () {
        Route::get('/', [UserController::class, 'showProfile'])->name('profile.show');
        Route::get('/edit', [UserController::class, 'editProfile'])->name('profile.edit');
        Route::put('/update', [UserController::class, 'updateProfile'])->name('profile.update');
    });

    // Rotas de perfil extendido
    Route::prefix('perfil-extendido')->group(function () {
        Route::get('/edit', [PerfilExtendidoController::class, 'edit'])->name('perfil-extendido.edit');
        Route::put('/update', [PerfilExtendidoController::class, 'update'])->name('perfil-extendido.update');
    });

    // Rotas de usuários (apenas para administradores)
    Route::middleware('can:admin')->prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::get('/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/', [UserController::class, 'store'])->name('users.store');
        Route::get('/{user}', [UserController::class, 'show'])->name('users.show');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        Route::post('/{user}/permissions', [UserController::class, 'updatePermissions'])->name('users.update-permissions');
    });

    // Rotas de grupos
    Route::prefix('grupos')->group(function () {
        Route::get('/', [GrupoController::class, 'index'])->name('grupos.index');
        Route::get('/create', [GrupoController::class, 'create'])->middleware('can:create,App\Models\Grupo')->name('grupos.create');
        Route::post('/', [GrupoController::class, 'store'])->middleware('can:create,App\Models\Grupo')->name('grupos.store');
        Route::get('/{grupo}', [GrupoController::class, 'show'])->name('grupos.show');
        Route::get('/{grupo}/edit', [GrupoController::class, 'edit'])->middleware('can:update,grupo')->name('grupos.edit');
        Route::put('/{grupo}', [GrupoController::class, 'update'])->middleware('can:update,grupo')->name('grupos.update');
        Route::delete('/{grupo}', [GrupoController::class, 'destroy'])->middleware('can:delete,grupo')->name('grupos.destroy');
    });

    // Rotas de músicas
    Route::prefix('musicas')->group(function () {
        Route::get('/', [MusicaController::class, 'index'])->name('musicas.index');
        Route::get('/create', [MusicaController::class, 'create'])->middleware('can:create,App\Models\Musica')->name('musicas.create');
        Route::post('/', [MusicaController::class, 'store'])->middleware('can:create,App\Models\Musica')->name('musicas.store');
        Route::get('/{musica}', [MusicaController::class, 'show'])->name('musicas.show');
        Route::get('/{musica}/edit', [MusicaController::class, 'edit'])->middleware('can:update,musica')->name('musicas.edit');
        Route::put('/{musica}', [MusicaController::class, 'update'])->middleware('can:update,musica')->name('musicas.update');
        Route::delete('/{musica}', [MusicaController::class, 'destroy'])->middleware('can:delete,musica')->name('musicas.destroy');
        Route::post('/{musica}/avaliar', [MusicaController::class, 'avaliar'])->name('musicas.avaliar');
    });

    // Rotas de eventos
    Route::prefix('eventos')->group(function () {
        Route::get('/', [EventoController::class, 'index'])->name('eventos.index');
        Route::get('/create', [EventoController::class, 'create'])->middleware('can:create,App\Models\Evento')->name('eventos.create');
        Route::post('/', [EventoController::class, 'store'])->middleware('can:create,App\Models\Evento')->name('eventos.store');
        Route::get('/{evento}', [EventoController::class, 'show'])->name('eventos.show');
        Route::get('/{evento}/edit', [EventoController::class, 'edit'])->middleware('can:update,evento')->name('eventos.edit');
        Route::put('/{evento}', [EventoController::class, 'update'])->middleware('can:update,evento')->name('eventos.update');
        Route::delete('/{evento}', [EventoController::class, 'destroy'])->middleware('can:delete,evento')->name('eventos.destroy');
        Route::post('/{evento}/participar', [EventoController::class, 'participar'])->name('eventos.participar');
        Route::post('/{evento}/cancelar', [EventoController::class, 'cancelarParticipacao'])->name('eventos.cancelar');
    });

    // Rotas de itens colecionáveis
    Route::prefix('itens')->group(function () {
        Route::get('/', [ItemColecionavelController::class, 'index'])->name('itens.index');
        Route::get('/disponiveis', [ItemColecionavelController::class, 'disponiveisParaTroca'])->name('itens.disponiveis');
        Route::get('/create', [ItemColecionavelController::class, 'create'])->name('itens.create');
        Route::post('/', [ItemColecionavelController::class, 'store'])->name('itens.store');
        Route::get('/{item}', [ItemColecionavelController::class, 'show'])->name('itens.show');
        Route::get('/{item}/edit', [ItemColecionavelController::class, 'edit'])->middleware('can:update,item')->name('itens.edit');
        Route::put('/{item}', [ItemColecionavelController::class, 'update'])->middleware('can:update,item')->name('itens.update');
        Route::delete('/{item}', [ItemColecionavelController::class, 'destroy'])->middleware('can:delete,item')->name('itens.destroy');
    });

    // Rotas de trocas
    Route::prefix('trocas')->group(function () {
        Route::get('/', [TrocaController::class, 'index'])->name('trocas.index');
        Route::get('/criar/{item}', [TrocaController::class, 'create'])->name('trocas.create');
        Route::post('/{item}', [TrocaController::class, 'store'])->name('trocas.store');
        Route::get('/{troca}', [TrocaController::class, 'show'])->name('trocas.show');
        Route::post('/{troca}/aceitar', [TrocaController::class, 'aceitar'])->name('trocas.aceitar');
        Route::post('/{troca}/recusar', [TrocaController::class, 'recusar'])->name('trocas.recusar');
        Route::post('/{troca}/cancelar', [TrocaController::class, 'cancelar'])->name('trocas.cancelar');
    });
});

/*
|--------------------------------------------------------------------------
| Rotas de Fallback (404)
|--------------------------------------------------------------------------
*/

Route::fallback(function () {
    return view('errors.404');
});