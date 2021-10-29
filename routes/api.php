<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [App\Http\Controllers\CommonController::class, 'register'])->name('register');
Route::post('login', [App\Http\Controllers\CommonController::class, 'login'])->name('login');
Route::post('logout', [App\Http\Controllers\CommonController::class, 'logout'])->name('logout');


Route::middleware('api')->group(function () {
    Route::Resource('companies', CompanyController::class);
    
});
Route::get('/company/edit/{id}', [App\Http\Controllers\CompanyController::class, 'edit']);

Route::middleware('api')->group(function () {
    Route::apiResource('employees', EmployeeController::class);
});
Route::get('/employees/edit/{id}', [App\Http\Controllers\EmployeeController::class, 'edit']);
Route::get('/get-companies', [App\Http\Controllers\EmployeeController::class, 'getCompanies']);
