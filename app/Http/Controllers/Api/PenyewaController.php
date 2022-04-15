<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Penyewa;
use Validator;
use Illuminate\Support\Facades\DB;

class PenyewaController extends Controller
{
    //Mobile App
    public function login(Request $request)
    {
        $loginData = $request->all();
        $validate = Validator::make($loginData, [
            'email_penyewa' => 'required',
            'password_penyewa' => 'required'
        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()], 400);
        }

        if(Auth::guard('apiPenyewa')->attempt(['email_penyewa' => $loginData['email_penyewa'], 'password' => $loginData['password_penyewa']]))
        {
            $penyewa = Auth::guard('apiPenyewa')->user();
        
            $token = $penyewa->createToken('Authentification Token')->accessToken;
        
            return response([
                'message' => 'Authenticated',
                'data' => $penyewa,
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
        $tenant = Penyewa::find($id);

        if(!is_null($tenant))
        {
            return response
            (
                [
                    'message' => 'Tenant Has Been Retrieved',
                    'data' => $tenant
                ], 200); 
        }

        return response
        (
            [
                'message' => 'Tenant Cannot Be Retrieved',
                'data' => null
            ], 404);
    }

    public function addMobile(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData,
        [
            'nama_penyewa' => 'required|string', 
            'alamat_penyewa' => '', 
            'email_penyewa' => 'required',
            'nomor_telepon_penyewa' => '', 
            'status_penyewa' => 'required|string'
        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()], 400);
        }

        if($storeData['nomor_telepon_penyewa'] != null)
        {
            $validate = Validator::make($storeData,
            [
                'nomor_telepon_penyewa' => 'required|string|unique:penyewa'
            ]);

            if($validate->fails())
            {
                return response(['message' => $validate->errors()], 400);
            }
        }

        if($storeData['alamat_penyewa'] != null)
        {
            $validate = Validator::make($storeData,
            [
                'alamat_penyewa' => 'required|string'
            ]);

            if($validate->fails())
            {
                return response(['message' => $validate->errors()], 400);
            }
        }
        
        $storeData['password_penyewa'] = bcrypt('default');
        $tenant = Penyewa::create($storeData);
        return response
        (
            [
                'message' => 'Tenant Added Successfully',
                'data' => $tenant,
            ], 200);
    }

    public function editMobile(Request $request, $id)
    {
        $tenant = Penyewa::find($id);

        if(is_null($tenant))
        {
            return response([
                'message' => 'Tenant Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData,
        [
            'alamat_penyewa' => '',
            'email_penyewa' => 'required',
            'nomor_telepon_penyewa' => '',
            'password_penyewa' => 'required',
        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()], 400);
        }

        if($updateData['nomor_telepon_penyewa'] != null)
        {
            $validate = Validator::make($updateData,
            [
                'nomor_telepon_penyewa' => 'required|string|unique:penyewa,nomor_telepon_penyewa,'.$id.',id_penyewa',
            ]);

            if($validate->fails())
            {
                return response(['message' => $validate->errors()], 400);
            }
        }

        if($updateData['alamat_penyewa'] != null)
        {
            $validate = Validator::make($updateData,
            [
                'alamat_penyewa' => 'required|string'
            ]);

            if($validate->fails())
            {
                return response(['message' => $validate->errors()], 400);
            }
        }

        $tenant->alamat_penyewa = $updateData['alamat_penyewa'];
        $tenant->email_penyewa = $updateData['email_penyewa'];
        $tenant->nomor_telepon_penyewa = $updateData['nomor_telepon_penyewa'];
        $tenant->password_penyewa = bcrypt($storeData['password_penyewa']);

        if($tenant->save())
        {
            return response(
                [
                    'message' => 'Tenant Has Been Updated',
                    'data' => $tenant,
                ], 200);
        }

        return response(
            [
                'message' => 'Tenant Cannot Be Updated',
                'data' => null,
            ], 400);
    }

    //Web App
    public function read()
    {
        $tenants = Penyewa::all();

        if(count($tenants) > 0)
        {
            return response([
                'messsage' => 'All Tenant Has Been Retrieved',
                'data' => $tenants
            ], 200);
        }

        return response([
            'message' => 'All Tenant Cannot Be Retrieved',
            'data' => null
        ], 404);
    }

    public function search($id)
    {
        $tenant = Penyewa::find($id);

        if(!is_null($tenant))
        {
            return response
            (
                [
                    'message' => 'Tenant Has Been Retrieved',
                    'data' => $tenant
                ], 200); 
        }

        return response
        (
            [
                'message' => 'Tenant Cannot Be Retrieved',
                'data' => null
            ], 404);
    }

    public function add(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData,
        [
            'nama_penyewa' => 'required|string|unique:penyewa', 
            'alamat_penyewa' => '', 
            'email_penyewa' => '',
            'nomor_telepon_penyewa' => '', 
            'status_penyewa' => 'required|string'
        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()], 400);
        }

        if($storeData['nomor_telepon_penyewa'] != null)
        {
            $validate = Validator::make($storeData,
            [
                'nomor_telepon_penyewa' => 'required|string|unique:penyewa'
            ]);

            if($validate->fails())
            {
                return response(['message' => $validate->errors()], 400);
            }
        }

        if($storeData['alamat_penyewa'] != null)
        {
            $validate = Validator::make($storeData,
            [
                'alamat_penyewa' => 'required|string'
            ]);

            if($validate->fails())
            {
                return response(['message' => $validate->errors()], 400);
            }
        }

        if($updateData['email_penyewa'] != null)
        {
            $validate = Validator::make($updateData,
            [
                'email_penyewa' => 'required|email:rfc,dns|unique:penyewa,email_penyewa,'.$id.',id_penyewa',
            ]);

            if($validate->fails())
            {
                return response(['message' => $validate->errors()], 400);
            }
        }
        
        $storeData['password_penyewa'] = bcrypt('default');
        $tenant = Penyewa::create($storeData);
        return response
        (
            [
                'message' => 'Tenant Added Successfully',
                'data' => $tenant,
            ], 200);
    }

    public function edit(Request $request, $id)
    {
        $tenant = Penyewa::find($id);

        if(is_null($tenant))
        {
            return response([
                'message' => 'Tenant Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData,
        [
            'alamat_penyewa' => '',
            'email_penyewa' => 'required',
            'nomor_telepon_penyewa' => '',
        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()], 400);
        }

        if($updateData['nomor_telepon_penyewa'] != null)
        {
            $validate = Validator::make($updateData,
            [
                'nomor_telepon_penyewa' => 'required|string|unique:penyewa,nomor_telepon_penyewa,'.$id.',id_penyewa',
            ]);

            if($validate->fails())
            {
                return response(['message' => $validate->errors()], 400);
            }
        }

        if($updateData['alamat_penyewa'] != null)
        {
            $validate = Validator::make($updateData,
            [
                'alamat_penyewa' => 'required|string'
            ]);

            if($validate->fails())
            {
                return response(['message' => $validate->errors()], 400);
            }
        }

        $tenant->alamat_penyewa = $updateData['alamat_penyewa'];
        $tenant->email_penyewa = $updateData['email_penyewa'];
        $tenant->nomor_telepon_penyewa = $updateData['nomor_telepon_penyewa'];

        if($tenant->save())
        {
            return response(
                [
                    'message' => 'Tenant Has Been Updated',
                    'data' => $tenant,
                ], 200);
        }

        return response(
            [
                'message' => 'Tenant Cannot Be Updated',
                'data' => null,
            ], 400);
    }

    public function editStatus(Request $request, $id)
    {
        $tenant = Penyewa::find($id);

        if(is_null($tenant))
        {
            return response([
                'message' => 'Tenant Not Found',
                'data' => null
            ], 404);
        }

        $property = DB::table('properti')
                    ->join('history_penyewaan', 'history_penyewaan.id_properti', '=', 'properti.id_properti')
                    ->join('penyewa', 'history_penyewaan.id_penyewa', '=', 'penyewa.id_penyewa')
                    ->select('properti.*')
                    ->where('properti.status_properti', '=', 'Active')
                    ->where('history_penyewaan.status_penyewaan', '=', 'Active')
                    ->where('penyewa.id_penyewa', '=', $id)
                    ->first();
            
        if(!is_null($property))
        {
            return response([
                'message' => 'Tenant is Still Tied to the Property',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData,
        [
            'status_penyewa' => 'required|string',
        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()], 400);
        }

        $tenant->status_penyewa = $updateData['status_penyewa'];

        if($tenant->save())
        {
            return response(
                [
                    'message' => 'Status Has Been Updated',
                    'data' => $tenant,
                ], 200);
        }

        return response(
            [
                'message' => 'Status Cannot Be Updated',
                'data' => null,
            ], 400);
    }
}
