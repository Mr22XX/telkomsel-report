<?php

use App\Http\Controllers\ReportController;
use App\Http\Controllers\ManagerDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth','role:manager'])->group(function () {
    Route::get('/manager/dashboard', [ManagerDashboardController::class,'index'])->name('manager.dashboard');
    // Route::get('/manager/ranking', [ManagerDashboardController::class,'ranking'])->name('manager.ranking');
    Route::get('/manager/monitoring', [ManagerDashboardController::class,'monitoring'])->name('manager.monitoring');
    Route::get('/manager/rekap', [ManagerDashboardController::class,'rekap'])->name('manager.rekap');
    // Route::get('/manager/export', [ManagerDashboardController::class,'export'])->name('manager.export');
    // Route::get('/manager/sales', [ManagerDashboardController::class,'sales'])->name('manager.sales');
});


Route::middleware(['auth'])->group(function () {

    Route::get('/sales/dashboard', function () {
        return app(\App\Http\Controllers\SalesDashboardController::class)->index();
    })->name('sales.dashboard');

    Route::resource('reports', ReportController::class);
});

Route::view('/offline', 'offline');





// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';
