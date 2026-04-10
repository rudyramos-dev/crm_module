<?php

declare(strict_types=1);

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DealController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/crm/dashboard');

Route::prefix('crm')->name('crm.')->group(function (): void {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('customers', CustomerController::class);
    Route::resource('deals', DealController::class);
    Route::post('/deals/{deal}/move-stage', [DealController::class, 'moveStage'])->name('deals.move-stage');

    Route::prefix('customers/{customer}')->name('customers.')->group(function (): void {
        Route::get('/activities', [ActivityController::class, 'index'])->name('activities.index');
        Route::get('/activities/create', [ActivityController::class, 'create'])->name('activities.create');
        Route::post('/activities', [ActivityController::class, 'store'])->name('activities.store');
    });

    Route::post('/activities/{activity}/complete', [ActivityController::class, 'markCompleted'])
        ->name('activities.complete');
});
