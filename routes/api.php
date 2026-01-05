<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\InvoiceController as ApiInvoiceController;
use App\Http\Controllers\Api\CustomerController as ApiCustomerController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| These are JSON endpoints for Vue components
|
*/

// Invoices API
Route::get('/invoices', [ApiInvoiceController::class, 'index']);
Route::post('/invoices', [ApiInvoiceController::class, 'store']);

// Customers API
Route::get('/customers', [ApiCustomerController::class, 'index']);
