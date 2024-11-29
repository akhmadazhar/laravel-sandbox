<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

            $personalAccesToken = $user->tokens()->latest()->first();
            $personalAccesToken->expires_at = Carbon::now()->addHours();
            $personalAccesToken->save();
        return response()->json([
            'status' => true,
            'message' => 'Akun Berasil di Registrasi !',
            'data' => [
                'name' => $user->name,
                'email' => $user->email,
                'token' => $token,
            ]
        ]);
    }

    public function login(Request $request){
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password]))
        {
            $user = User::where('email',$request->email)->first();
            $token = $user->createToken('my-api')->plainTextToken;

            $personalAccesToken = $user->tokens()->latest()->first();
            $personalAccesToken->expires_at = Carbon::now()->addHours();
            $personalAccesToken->save();

            return response()->json([
                'status' => true,
                'message' => 'Berhasil Login !',
                'data' => [
                    'email' => $request->email,
                    'token' => $token
                ]
            ],200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Autentikasi Gagal!'
            ]);
        }
    }
}
