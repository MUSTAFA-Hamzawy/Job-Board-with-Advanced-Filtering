<?php

use App\Http\Controllers\JobController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Job Routes
|--------------------------------------------------------------------------
*/
Route::prefix('jobs')
    ->controller(JobController::class)
    ->group(function () {
    Route::get('/', 'index');
    Route::post('/', 'create');
});

