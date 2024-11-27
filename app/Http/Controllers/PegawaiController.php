<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PegawaiController extends Controller
{
     public function display_data(){
        $data = Cache::remember('pegawai-display', 300, function () {
             return Pegawai::orderBy('nama','asc')->get();
        });
        foreach ($data as $key => $value) {
            echo $value->nama . "id: " . $value->id . "<br>";
        }
    }
    public function index(){
        $client = new Client();
        $response = $client->request('GET', 'http://127.0.0.1:8001/api/pegawai');
        $data = json_decode($response->getBody()->getContents(), true);

        return view('pegawai.index',$data);
    }

}
