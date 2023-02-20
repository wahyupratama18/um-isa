<?php

use App\Http\Controllers\BallotController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\ProfileController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');

        if (env('USER_DELETION')) {
            Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
        }
    });

    Route::middleware('role:1')->group(function () {
        Route::resource('positions', PositionController::class)->except(['show', 'index']);
        Route::resource('positions.candidates', CandidateController::class)->except(['show', 'index']);
        Route::resource('ballots', BallotController::class)->only(['edit', 'update', 'destroy']);
    });

    Route::middleware('role:2')->group(function () {
        Route::resource('ballots', BallotController::class)->only(['create', 'store']);
    });

    Route::resource('positions', PositionController::class)->only(['index']);
    Route::resource('ballots', BallotController::class)->only(['index']);
    Route::resource('positions.candidates', CandidateController::class)->only(['index']);
});

require __DIR__.'/auth.php';
