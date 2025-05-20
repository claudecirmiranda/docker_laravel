<?php

use Illuminate\Support\Facades\Route;  
use App\Http\Controllers\Order\OrderController;  
use App\Http\Controllers\Order\TrackingController;  

Route::post('order', [OrderController::class, 'store']);  
Route::post('order/tracking', [TrackingController::class, 'store']);  
