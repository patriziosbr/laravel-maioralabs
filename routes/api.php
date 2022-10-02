<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Product;
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

// Route::get('/job', [App\Http\Controllers\Api\CsvController::class, 'index']); per ricordo
Route::post('/uploadcsv', [App\Http\Controllers\Api\CsvController::class, 'uploadcsv']);
Route::get('/discount-category', [App\Http\Controllers\Api\CsvController::class, 'discount']);
Route::post('/applaydiscount', [App\Http\Controllers\Api\CsvController::class, 'applaydiscount']);
