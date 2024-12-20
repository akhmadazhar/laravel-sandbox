<?php

use App\Http\Controllers\Api\PegawaiController;
use App\Http\Controllers\Api\PersonController;
use App\Http\Controllers\Api\UserRegister;
use App\Http\Controllers\PegawaiController as ControllersPegawaiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::resource('/person',PersonController::class)->middleware(['auth:sanctum','ability:access-api']);
Route::get('pegawai',[PegawaiController::class,'index'])->middleware('auth:sanctum');
Route::post('/user/register',[UserRegister::class,'register']);
Route::post('/user/login',[UserRegister::class,'login']);

Route::get('/user/refresh-token',[UserRegister::class,'refreshToken'])->middleware(['auth:sanctum','ability:issue-access-token']);

Route::get('/user/logout', function(Request $request){
    $request->user()->tokens()->delete();

    return response()->json([
        'status' => 'true',
        'message' => 'Token Berhasil Dihapus!'
    ],200);
})->middleware('auth:sanctum');
