<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Validator;
use Illuminate\Support\Facades\DB;

class PegawaiController extends Controller
{
    public function read()
    {
        $staffs = DB::table('pegawai')->select('pegawai.*')->get();

        if(count($staffs) > 0)
        {
            return response([
                'messsage' => 'All Staff Has Been Retrieved',
                'data' => $staffs
            ], 200);
        }

        return response([
            'message' => 'All Staff Cannot Be Retrieved',
            'data' => null
        ], 404);
    }

    public function search($id)
    {
        $staff = DB::table('pegawai')->select('pegawai.*')
                ->where('pegawai.id_pegawai', '=', $id)->first();

        if(!is_null($staff))
        {
            return response
            (
                [
                    'message' => 'Staff Has Been Retrieved',
                    'data' => $staff
                ], 200); 
        }

        return response
        (
            [
                'message' => 'Staff Cannot Be Retrieved',
                'data' => null
            ], 404);
    }

    public function add(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData,
        [
            'nama_pegawai' => 'required|string', 
            'nomor_pegawai' => 'required|string|unique:pegawai', 
            'password' => 'required|string',
            'jenis_kelamin' => 'required|string',
            'status_pegawai' => 'required|string',
            'status_otoritas' => 'required|string',
            'role' => 'required|string',
        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()], 400);
        }

        $storeData['password'] = bcrypt($request->password);
        $staff = User::create($storeData);
        return response
        (
            [
                'message' => 'Staff Added Successfully',
                'data' => $staff,
            ], 200);
    }

    public function editStOtoritas(Request $request, $id)
    {
        $staff = User::find($id);

        if(is_null($staff))
        {
            return response([
                'message' => 'Staff Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData,
        [
            'status_otoritas' => 'required|string',
        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()], 400);
        }

        $staff->status_otoritas = $updateData['status_otoritas'];

        if($staff->save())
        {
            return response(
                [
                    'message' => 'Otority Has Been Updated',
                    'data' => $staff,
                ], 200);
        }

        return response(
            [
                'message' => 'Otority Cannot Be Updated',
                'data' => null,
            ], 400);
    }

    public function editPassword(Request $request, $id)
    {
        $staff = User::find($id);

        if(is_null($staff))
        {
            return response([
                'message' => 'Employee Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData,
        [
            'password' => 'required'
        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()->first()], 400);
        }
        
        $updateData['password'] = bcrypt($request->password);
        $staff->password = $updateData['password'];

        if($staff->save())
        {
            return response(
                [
                    'message' => 'Password Has Been Updated',
                    'data' => $staff,
                ], 200);
        }

        return response(
            [
                'message' => 'Password Cannot Be Updated',
                'data' => null,
            ], 400);
    }

    public function editStatus(Request $request, $id)
    {
        $staff = User::find($id);

        if(is_null($staff))
        {
            return response([
                'message' => 'Staff Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData,
        [
            'status_pegawai' => 'required|string',
        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()], 400);
        }

        $staff->status_pegawai = $updateData['status_pegawai'];

        if($staff->save())
        {
            return response(
                [
                    'message' => 'Status Has Been Updated',
                    'data' => $staff,
                ], 200);
        }

        return response(
            [
                'message' => 'Status Cannot Be Updated',
                'data' => null,
            ], 400);
    }

    public function delete($id)
    {
        $staff = User::find($id);

        if(is_null($staff))
        {
            return response([
                'message' => 'Staff Not Found',
                'data'=> null,
            ], 404);
        }

        if($staff->delete())
        {
            return response([
                'message' => 'Staff Has Been Deleted',
                'data' => $staff,
            ], 200);
        }

        return response([
            'message' => 'Staff Cannot Be Deleted',
            'data' => null,
        ], 400);
    }
}