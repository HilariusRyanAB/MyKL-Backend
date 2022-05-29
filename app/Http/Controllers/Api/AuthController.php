<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $loginData = $request->all();
        $validate = Validator::make($loginData, [
            'email_user' => 'required',
            'password' => 'required',
            'role_user' => 'required',
        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()], 400);
        }
        
        $user = User::where('email_user', $request->email_user)->where('role_user', $request->role_user)->first();
        if(!$user || !Hash::check($request->password, $user->password))
        {
            return response(['message' => 'Invalid Credentials'], 401);
        }
        
        $token = $user->createToken('Authentification Token')->accessToken;
    
        return response([
            'message' => 'Authenticated',
            'data' => $user,
            'token_type' => 'Bearer',
            'access_token' => $token
        ]);
    }
    
    public function getToken(Request $request)
    {
        $newData = $request->all();
        $validate = Validator::make($newData, [
            'id_user' => 'required',
            'fcm_token' => 'required',
        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()], 400);
        }

        $user = User::find($request->id_user);

        $user->fcm_token = $request->fcm_token;
        $user->save();
        
        return response([
            'message' => 'FCM Token Added Successfully',
            'data' => $user
        ]);
    }
}