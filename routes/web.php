<?php

use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {


    Route::get('/dashboard/manager', function () {
        return view('manager.dashboard');
    })->name('manager.dashboard');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/sales/dashboard', function () {
        return app(\App\Http\Controllers\SalesDashboardController::class)->index();
    })->name('sales.dashboard');

    Route::resource('reports', ReportController::class);
});




// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';
