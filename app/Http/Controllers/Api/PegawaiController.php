<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PegawaiController extends Controller
{

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
