<?php

use App\Http\Controllers\Api\PegawaiController as ApiPegawaiController;
use App\Http\Controllers\PegawaiController;
use App\Models\Pegawai;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pegawai', [PegawaiController::class, 'index'])->name('pegawai.index');
Route::get('/display-data', [PegawaiController::class, 'display_data']);

Route::get('/input-data',function(){

   $data =  Pegawai::create([
        'nama' => 'AA Azhar'
    ]);
    echo  $data->nama. "id" . $data->id;
});

Route::get('/display-data/{id}', function($id){
    $data = Cache::remember('pegawai-display_'.$id, 300, function () use ($id) {
            return Pegawai::findOrFail($id);
        });
        echo $data->nama . "id: " . $data->id . "<br>";
});

Route::get('/update-data/{id}', function($id){
    $data = Pegawai::findOrFail($id);
    $data->nama = "AA Azhar New";
    $data->update();
        echo $data->nama . "id: " . $data->id . "<br>";
});
