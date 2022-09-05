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
        Route::get('/create', [EvenementController::class, 'store'])->name('evenement.store');
        Route::get('/{evenement}/edit', [EvenementController::class, 'edit'])->name('evenements.edit');
        Route::get('/{evenement}/delete', [EvenementController::class, 'destroy'])->name('evenements.delete');
        Route::get('/{evenement}/restore', [EvenementController::class, 'restore'])->name('evenements.restore');
    });
});
