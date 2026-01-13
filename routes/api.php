<?php

use App\Http\Controllers\InvoiceController;
use App\Http\Middleware\ResolveUserMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('invoices')->group(function () {
        Route::get('show/{invoice}', [InvoiceController::class, 'show'])
            ->name('invoices.show');
        Route::get('send_to_approve/{invoice}', [InvoiceController::class, 'sendToApprove'])
            ->name('invoices.send_to_approve');
        Route::get('approve/{invoice}', [InvoiceController::class, 'approve'])
            ->name('invoices.approve');
        Route::get('reject/{invoice}', [InvoiceController::class, 'reject'])
            ->name('invoices.reject');
        Route::get('send_to_customer/{invoice}', [InvoiceController::class, 'sendToCustomer'])
            ->name('invoices.send_to_customer');
        Route::get('cancel/{invoice}', [InvoiceController::class, 'cancel'])
            ->name('invoices.cancel');
        Route::get('draft/{invoice}', [InvoiceController::class, 'draft'])
            ->name('invoices.dreaft');
    });
})->prefix('invoices');
