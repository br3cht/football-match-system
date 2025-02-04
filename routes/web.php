<?php

use App\Http\Controllers\SiteController;
use App\Http\Controllers\SoccerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('matches');
});

