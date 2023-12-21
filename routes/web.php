<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PriceTrackerController;

Route::get('/', [PriceTrackerController::class, 'showSubscriptionForm']);
Route::post('/subscribe', [PriceTrackerController::class, 'subscribe']);

