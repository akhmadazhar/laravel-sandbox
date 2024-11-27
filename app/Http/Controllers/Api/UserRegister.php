<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserRegister extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' =>'required|email',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' =>'Validasi Gagal !',
                'error' => $validator->errors()
            ]);
        }
        // $data = $request->all();
        // $data['password'] = bcrypt($request->password);
        $user = User::create($request->all());
        $token = $user->createToken('my-api')->plainTextToken;
            return response()->json([
                'status' => true,
                'message' => 'Data Berhasil Ditambahkan!',
                'data' => [
                    'nama' => $user->name,
                    'email' => $user->email,
                    'token' => $token
                ]
            ]);
    }
}
