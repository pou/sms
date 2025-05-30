<?php

use App\Http\Controllers\Api\SmsController;
use Illuminate\Support\Facades\Route;

Route::get('/getNumber', [SmsController::class, 'getNumber']);
Route::get('/getSms', [SmsController::class, 'getSms']);
Route::get('/cancelNumber', [SmsController::class, 'cancelNumber']);
Route::get('/getStatus', [SmsController::class, 'getStatus']);
