<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LeadController;
use App\Http\Controllers\Api\SalesPersonController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::controller(AuthController::class)->group(function(){
    Route::post('register', 'register')->name('register');
    Route::post('login', 'login')->name('login');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api')->name('logout');

Route::get('/user', [AuthController::class, 'user'])->middleware('auth:api')->name('user');
Route::put('/user/{id}', [AuthController::class, 'updateProfile'])->middleware('auth:api')->name('update-user');

Route::middleware('auth:api')->group(function () {
    Route::post('/leads', [LeadController::class, 'store'])->middleware('permission:create-lead');
});
Route::middleware('auth:api')->group(function () {
    Route::put('/leads/{id}/status', [LeadController::class, 'updateStatus']);
});

Route::get('/leads/{id}', [LeadController::class, 'show'])->middleware('auth:api')->name('get-leads');
Route::put('/update/{id}/salesperson', [SalesPersonController::class, 'updateSalesperson'])->middleware('auth:api')->name('update-salesperson');

Route::get('/all-salesperson', [SalesPersonController::class, 'allSalesperson'])->middleware('auth:api')->name('get-all-salesperson');
Route::post('/penalty-salesperson', [SalesPersonController::class, 'assignPenaltyToSalesperson'])->middleware('auth:api')->name('assign-penalty-to-salesperson');
Route::put('/penalty-salesperson/{id}', [SalesPersonController::class, 'removePenaltyFromSalesperson'])->middleware('auth:api')->name('update-penalty-to-salesperson');

