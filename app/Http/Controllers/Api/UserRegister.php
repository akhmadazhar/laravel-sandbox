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

        $at_expiration = 60;
        $acces_token = $user->createToken('access_token',['access-api'],Carbon::now()->addMinutes($at_expiration))->plainTextToken;

        $rt_expiration = 30 * 24 * 60;
        $refresh_token = $user->createToken('refresh_token',['issue-access-token'],Carbon::now()->addMinutes($rt_expiration))->plainTextToken;
        return response()->json([
            'status' => true,
            'message' => 'Akun Berasil di Registrasi !',
            'data' => [
                'name' => $user->name,
                'email' => $user->email,
                'token' => $acces_token,
                'refresh_token' => $refresh_token,
            ]
        ]);
    }

    public function login(Request $request){
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password]))
        {
            $user = User::where('email',$request->email)->first();

            $at_expiration = 60;
            $acces_token = $user->createToken('acces_token',['access-api'],Carbon::now()->addMinutes($at_expiration))->plainTextToken;

            $rt_expiration = 30 * 24 * 60;
            $refresh_token = $user->createToken('refresh_token',['issue-access-token'],Carbon::now()->addMinutes($rt_expiration))->plainTextToken;

            return response()->json([
                'status' => true,
                'message' => 'Berhasil Login !',
                'data' => [
                    'email' => $request->email,
                    'token' => $acces_token,
                    'refres_token' => $refresh_token,
                ]
            ],200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Autentikasi Gagal!'
            ]);
        }
    }

    public function refreshToken(Request $request)
    {
        $at_expiration = 60;
        $acces_token = $request->user()->createToken('access-api',['access-api'],Carbon::now()->addMinutes($at_expiration))->plainTextToken;

        return response()->json([
                'status' => true,
                'message' => 'Token Berhasil Diperbaharui',
                'data' => [
                    'name' => $request->user()->name,
                    'email' => $request->user()->email,
                    'token' => $acces_token,
                ]
            ],200);
    }
}
