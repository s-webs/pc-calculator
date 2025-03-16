<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
    Route::resource('/pc-categories', \App\Http\Controllers\Computers\PcCategoriesController::class)->names('pc-categories');
    Route::resource('/pc-components', \App\Http\Controllers\Computers\PcComponentsController::class)->names('pc-components');
    Route::resource('/pc-builds', \App\Http\Controllers\Computers\PcBuildController::class)->names('pc-builds');
});
