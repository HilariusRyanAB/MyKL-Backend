<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Pemilik;
use App\UserOwner;
use Validator;
use Illuminate\Support\Facades\DB;

class PemilikController extends Controller
{
    //Mobile App
    public function login(Request $request)
    {
        $loginData = $request->all();
        $validate = Validator::make($loginData, [
            'email_pemilik' => 'required',
            'password_pemilik' => 'required'
        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()], 400);
        }

        if(Auth::guard('apiPemilik')->attempt(['email_pemilik' => $loginData['email_pemilik'], 'password' => $loginData['password_pemilik']]))
        {
            $pemilik = Auth::guard('apiPemilik')->user();
        
            $token = $pemilik->createToken('Authentification Token')->accessToken;
        
            return response([
                'message' => 'Authenticated',
                'data' => $pemilik,
                'token_type' => 'Bearer',
                'access_token' => $token
            ]);
        }

        else
        {            
            return response(['message' => 'Invalid Credentials'], 401);
        }
    }

    public function searchMobile($id)
    {
        $owner = Pemilik::find($id);

        if(!is_null($owner))
        {
            return response
            (
                [
                    'message' => 'Owner Has Been Retrieved',
                    'data' => $owner
                ], 200); 
        }

        return response
        (
            [
                'message' => 'Owner Cannot Be Retrieved',
                'data' => null
            ], 404);
    }

    public function editMobile(Request $request, $id)
    {
        $owner = Pemilik::find($id);

        if(is_null($owner))
        {
            return response([
                'message' => 'Owner Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData,
        [
            'alamat_pemilik' => 'required|string',
            'nomor_telepon_pemilik' => '',
            'email_pemilik' => 'required',
            'password_pemilik' => 'required',
        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()], 400);
        }

        if($updateData['nomor_telepon_pemilik'] != null)
        {
            $validate = Validator::make($updateData,
            [
                'nomor_telepon_pemilik' => 'required|string|unique:pemilik,nomor_telepon_pemilik,'.$id.',id_pemilik',
            ]);

            if($validate->fails())
            {
                return response(['message' => $validate->errors()], 400);
            }
        }

        $owner->alamat_pemilik = $updateData['alamat_pemilik'];
        $owner->email_pemilik = $updateData['email_pemilik'];
        $owner->nomor_telepon_pemilik = $updateData['nomor_telepon_pemilik'];
        $owner->password_pemilik = bcrypt($storeData['password_pemilik']);

        if($owner->save())
        {
            return response(
                [
                    'message' => 'Owner Has Been Updated',
                    'data' => $owner,
                ], 200);
        }

        return response(
            [
                'message' => 'Owner Cannot Be Updated',
                'data' => null,
            ], 400);
    }

    //Web App
    public function read()
    {
        $owners = Pemilik::all();

        if(count($owners) > 0)
        {
            return response([
                'messsage' => 'All Owner Has Been Retrieved',
                'data' => $owners
            ], 200);
        }

        return response([
            'message' => 'All Owner Cannot Be Retrieved',
            'data' => null
        ], 404);
    }

    public function search($id)
    {
        $owner = Pemilik::find($id);

        if(!is_null($owner))
        {
            return response
            (
                [
                    'message' => 'Owner Has Been Retrieved',
                    'data' => $owner
                ], 200); 
        }

        return response
        (
            [
                'message' => 'Owner Cannot Be Retrieved',
                'data' => null
            ], 404);
    }

    public function add(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData,
        [
            'nama_pemilik' => 'required|string|unique:pemilik', 
            'alamat_pemilik' => 'required|string', 
            'nomor_telepon_pemilik' => '', 
            'email_pemilik' => 'required',
            'status_pemilik' => 'required|string'
        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()], 400);
        }

        if($storeData['nomor_telepon_pemilik'] != null)
        {
            $validate = Validator::make($storeData,
            [
                'nomor_telepon_pemilik' => 'required|string|unique:pemilik'
            ]);

            if($validate->fails())
            {
                return response(['message' => $validate->errors()], 400);
            }
        }

        $storeData['password_pemilik'] = bcrypt('default');
        $owner = Pemilik::create($storeData);
        return response
        (
            [
                'message' => 'Owner Added Successfully',
                'data' => $owner,
            ], 200);
    }

    public function edit(Request $request, $id)
    {
        $owner = Pemilik::find($id);

        if(is_null($owner))
        {
            return response([
                'message' => 'Owner Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData,
        [
            'alamat_pemilik' => 'required|string',
            'nomor_telepon_pemilik' => '',
            'email_pemilik' => 'required',
        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()], 400);
        }

        if($updateData['nomor_telepon_pemilik'] != null)
        {
            $validate = Validator::make($updateData,
            [
                'nomor_telepon_pemilik' => 'required|string|unique:pemilik,nomor_telepon_pemilik,'.$id.',id_pemilik',
            ]);

            if($validate->fails())
            {
                return response(['message' => $validate->errors()], 400);
            }
        }

        $owner->alamat_pemilik = $updateData['alamat_pemilik'];
        $owner->email_pemilik = $updateData['email_pemilik'];
        $owner->nomor_telepon_pemilik = $updateData['nomor_telepon_pemilik'];

        if($owner->save())
        {
            return response(
                [
                    'message' => 'Owner Has Been Updated',
                    'data' => $owner,
                ], 200);
        }

        return response(
            [
                'message' => 'Owner Cannot Be Updated',
                'data' => null,
            ], 400);
    }

    public function editStatus(Request $request, $id)
    {
        $owner = Pemilik::find($id);

        if(is_null($owner))
        {
            return response([
                'message' => 'Owner Not Found',
                'data' => null
            ], 404);
        }

        $property = DB::table('properti')
                    ->join('history_kepemilikan', 'history_kepemilikan.id_properti', '=', 'properti.id_properti')
                    ->join('pemilik', 'history_kepemilikan.id_pemilik', '=', 'pemilik.id_pemilik')
                    ->select('properti.*')
                    ->where('properti.status_properti', '=', 'Active')
                    ->where('history_kepemilikan.status_kepemilikan', '=', 'Active')
                    ->where('pemilik.id_pemilik', '=', $id)
                    ->first();
            
        if(!is_null($property))
        {
            return response([
                'message' => 'Owner is Still Tied to the Property',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData,
        [
            'status_pemilik' => 'required|string',
        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()], 400);
        }

        $owner->status_pemilik = $updateData['status_pemilik'];

        if($owner->save())
        {
            return response(
                [
                    'message' => 'Status Has Been Updated',
                    'data' => $owner,
                ], 200);
        }

        return response(
            [
                'message' => 'Status Cannot Be Updated',
                'data' => null,
            ], 400);
    }
}