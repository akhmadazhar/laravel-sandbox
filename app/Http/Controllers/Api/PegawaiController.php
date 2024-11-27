<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PegawaiController extends Controller
{
    public function display_data(){
         $data = Cache::remember('pegawai-data', 300, function () {
         return Pegawai::orderBy('nama','asc')->get();
        });
        foreach ($data as $key => $value) {
            echo $value->nama . "id: " . $value->id . "<br>";
        }
    }

    public function index()
    {
        $data = Pegawai::orderBy('nama','asc')->get();
        return response()->json([
            'status' => true,
            'message' => 'Data Berhasil ditemukan',
            'data' => $data
        ]);
    }
}
