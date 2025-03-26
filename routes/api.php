<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AttributeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::fallback(function () {
    return response()->json([
        "message" => "Route Not Found!",
    ]);
});

Route::get('/location', [LocationController::class, 'index']);
Route::get('/category', [CategoryController::class, 'index']);
Route::get('/language', [LanguageController::class, 'index']);
Route::get('/attribute', [AttributeController::class, 'index']);

require_once __DIR__ . '/job.php';
