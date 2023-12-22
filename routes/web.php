<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PriceTrackerController;

Route::get('/subscribe', [PriceTrackerController::class, 'showSubscriptionForm']);
Route::get('/', [PriceTrackerController::class, 'showSubscriptionForm']);
Route::post('/subscribe', [PriceTrackerController::class, 'subscribe']);

