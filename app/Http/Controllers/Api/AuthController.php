<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Validator;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $loginData = $request->all();
        $validate = Validator::make($loginData, [
            'nomor_pegawai' => 'required',
            'password' => 'required'
        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()], 400);
        }

        if(!Auth::attempt($loginData))
        {
            return response(['message' => 'Invalid Credentials'], 401);
        }

        $user = Auth::user();
        
        $token = $user->createToken('Authentification Token')->accessToken;
    
        return response([
            'message' => 'Authenticated',
            'data' => $user,
            'token_type' => 'Bearer',
            'access_token' => $token
        ]);
    }
}