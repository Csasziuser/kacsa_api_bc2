<?php

use App\Http\Controllers\ParkController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('parks',[ParkController::class,'store']);
Route::get('parks',[ParkController::class,'index']);
Route::get('parks/{park}',[ParkController::class,'show']);

