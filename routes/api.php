<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\RoleController;
use App\Http\Controllers\Api\Department\DepartmentController;
use App\Http\Controllers\Api\Employee\EmployeeController;
use App\Http\Controllers\Api\Finance\FinanceTransactionController;
use App\Http\Controllers\Api\Product\ProductController;
use App\Http\Controllers\Api\Purchase\PurchaseController;
use App\Http\Controllers\Api\Supplier\SupplierController;
use App\Http\Controllers\Api\Task\TaskController;
use App\Http\Controllers\Api\User\UserController;

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('users', UserController::class);
    Route::apiResource('roles', RoleController::class);
    Route::apiResource('products', ProductController::class);
    Route::apiResource('department', DepartmentController::class);
    Route::apiResource('finance-transactions', FinanceTransactionController::class);
    Route::apiResource('employees', EmployeeController::class);
    Route::apiResource('suppliers', SupplierController::class);
    Route::apiResource('purchases', PurchaseController::class);
    Route::apiResource('tasks', TaskController::class);
});
