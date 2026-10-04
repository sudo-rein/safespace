<?php

use App\Http\Controllers\Counselor\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Student\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Student\ReportController;


Route::get('/', function () {
    return view('welcome');
});

// Sends each role to its own home
Route::get('/dashboard', function () {
    return auth()->user()->isCounselor()
        ? redirect()->route('counselor.dashboard')
        : redirect()->route('student.home');
})->middleware('auth')->name('dashboard');

// Student area
Route::middleware(['auth', 'student'])
    ->prefix('student')
    ->name('student.')
    ->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('home');
    });

// Counselor area
Route::middleware(['auth', 'counselor'])
    ->prefix('counselor')
    ->name('counselor.')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth', 'student'])
    ->prefix('student')
    ->name('student.')
    ->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('home');
        Route::get('/report', [ReportController::class, 'create'])->name('report.create');
        Route::post('/report', [ReportController::class, 'store'])->name('report.store');
        Route::get('/report/{incident}/confirmation', [ReportController::class, 'confirmation'])->name('report.confirmation');
    });


require __DIR__.'/auth.php';