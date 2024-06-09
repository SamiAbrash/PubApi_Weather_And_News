<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherAndNewsController;



Route::get('/weather-news', [WeatherAndNewsController::class, 'getFunction']);