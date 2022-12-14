<?php

use App\Http\Controllers\EvenementController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [ 'canLogin' => Route::has('login'), 'canRegister' => Route::has('register'), 'laravelVersion' => Application::VERSION, 'phpVersion' => PHP_VERSION ]);
});

Route::middleware([ 'auth:sanctum', config('jetstream.auth_session'), 'verified' ])->group(function () {
    Route::get('/dashboard', function () { return Inertia::render('Dashboard'); })->name('dashboard');
    Route::prefix('evenements')->group(function(){
        Route::get('/', [EvenementController::class, 'index'])->name('evenements');
        Route::get('/search', [EvenementController::class, 'filter'])->name('evenements.filter');
        Route::post('/create', [EvenementController::class, 'store'])->name('evenement.store');
        Route::patch('/{evenement}/edit', [EvenementController::class, 'update'])->name('evenement.edit');
        Route::delete('/{evenement}/delete', [EvenementController::class, 'destroy'])->name('evenement.delete');
        Route::get('/{evenement}/restore', [EvenementController::class, 'restore'])->name('evenement.restore');
    });
});
