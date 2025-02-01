<?php

use App\Http\Controllers\SiteController;
use App\Http\Controllers\SoccerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/competions', [SoccerController::class, 'getCompetions']);
Route::get('/standing', [SiteController::class, 'matches']);
