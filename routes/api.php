<?php

use App\Http\Controllers\Api\PegawaiController;
use App\Http\Controllers\Api\PersonController;
use App\Http\Controllers\PegawaiController as ControllersPegawaiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::resource('/person',PersonController::class);
Route::get('pegawai',[PegawaiController::class,'index']);
