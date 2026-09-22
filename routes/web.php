<?php

use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\InstallationController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicInstallationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicInstallationController::class, 'create'])->name('public.form');
Route::post('/submit', [PublicInstallationController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('public.submit');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AnalyticsController::class, 'index'])->name('dashboard');

    Route::resource('products', ProductController::class)->except(['show']);
    Route::resource('installations', InstallationController::class);

    Route::get('/export', [ExportController::class, 'index'])->name('export.index');
    Route::get('/export/download', [ExportController::class, 'download'])->name('export.download');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
