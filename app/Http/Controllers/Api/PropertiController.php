<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Properti;
use Validator;
use Illuminate\Support\Facades\DB;

class PropertiController extends Controller
{
    //mobile
    public function readPemilik($id)
    {
        $properties = DB::table('properti')
            ->join('history_kepemilikan', 'history_kepemilikan.id_properti', '=', 'properti.id_properti')
            ->join('pemilik', 'pemilik.id_pemilik', '=', 'history_kepemilikan.id_pemilik')
            ->select('properti.*', 'pemilik.*', 'history_kepemilikan.*')
            ->where('history_kepemilikan.status_kepemilikan', '=', 'Active')
            ->where('pemilik.id_pemilik', '=', $id)
            ->where('properti.status_properti', '=', 'Active')
            ->orderBy('properti.nomor_kavling','asc')
            ->get();

        if(count($properties) > 0)
        {
            return response([
                'message' => 'All Property Has Been Retrieved',
                'data' => $properties
            ], 200);
        }

        return response([
            'message' => 'All Property Cannot Be Retrieved',
            'data' => null
        ], 404);
    }

    public function readPenyewa($id)
    {
        $properties = DB::table('properti')
            ->join('history_penyewaan', 'history_penyewaan.id_properti', '=', 'properti.id_properti')
            ->join('penyewa', 'penyewa.id_penyewa', '=', 'history_penyewaan.id_penyewa')
            ->select('properti.*', 'penyewa.*', 'history_penyewaan.*')
            ->where('history_penyewaan.status_penyewaan', '=', 'Active')
            ->where('penyewa.id_penyewa', '=', $id)
            ->where('properti.status_properti', '=', 'Active')
            ->orderBy('properti.nomor_kavling','asc')
            ->get();

        if(count($properties) > 0)
        {
            return response([
                'message' => 'All Property Has Been Retrieved',
                'data' => $properties
            ], 200);
        }

        return response([
            'message' => 'All Property Cannot Be Retrieved',
            'data' => null
        ], 404);
    }

    public function editMobile(Request $request, $id)
    {
        $property = Properti::find($id);

        if(is_null($property))
        {
            return response([
                'message' => 'Property Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData,
        [
            'id_pemilik' => 'required|numeric', 
            'id_penyewa' => '',
            'status_properti' => 'required',
        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()], 400);
        }

        if($updateData['id_penyewa'] != null)
        {
            $validate = Validator::make($updateData,
            [
                'id_penyewa' => 'required'
            ]);

            if($validate->fails())
            {
                return response(['message' => $validate->errors()], 400);
            }
        }

        $property->id_pemilik = $updateData['id_pemilik'];
        $property->id_penyewa = $updateData['id_penyewa'];
        $property->status_properti = $updateData['status_properti'];

        if($property->save())
        {
            return response(
                [
                    'message' => 'Property Has Been Updated',
                    'data' => $property,
                ], 200);
        }

        return response(
            [
                'message' => 'Property Cannot Be Updated',
                'data' => null,
            ], 400);
    }

    //web
    public function read()
    {
        $properties = DB::table('properti')
                    ->join('history_kepemilikan', 'history_kepemilikan.id_properti', '=', 'properti.id_properti')
                    ->join('pemilik', 'pemilik.id_pemilik', '=', 'history_kepemilikan.id_pemilik')
                    ->leftjoin('history_penyewaan', 'history_penyewaan.id_properti', '=', 'properti.id_properti')
                    ->leftjoin('penyewa', 'penyewa.id_penyewa', '=', 'history_penyewaan.id_penyewa')
                    ->select('properti.*', 'pemilik.*', 'penyewa.*')
                    ->orderBy('nomor_kavling','asc')
                    ->get();

        if(count($properties) > 0)
        {
            return response([
                'message' => 'All Property Has Been Retrieved',
                'data' => $properties
            ], 200);
        }

        return response([
            'message' => 'All Property Cannot Be Retrieved',
            'data' => null
        ], 404);
    }

    public function search($id)
    {
        $property = DB::table('properti')
                    ->join('history_kepemilikan', 'history_kepemilikan.id_properti', '=', 'properti.id_properti')
                    ->join('pemilik', 'pemilik.id_pemilik', '=', 'history_kepemilikan.id_pemilik')
                    ->leftjoin('history_penyewaan', 'history_penyewaan.id_properti', '=', 'properti.id_properti')
                    ->leftjoin('penyewa', 'penyewa.id_penyewa', '=', 'history_penyewaan.id_penyewa')
                    ->select('properti.*', 'pemilik.*', 'penyewa.*')
                    ->where('properti.id_properti', '=', $id)
                    ->get();

        if(!is_null($property))
        {
            return response
            (
                [
                    'message' => 'Property Has Been Retrieved',
                    'data' => $property
                ], 200); 
        }

        return response
        (
            [
                'message' => 'Property Cannot Be Retrieved',
                'data' => null
            ], 404);
    }

    public function add(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData,
        [
            'nomor_kavling' => 'required|string', 
            'luas_tanah' => 'required', 
            'luas_bangunan' => 'required',
            'jumlah_denda' => 'required|numeric', 
            'status_properti' => 'required|string'
        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()], 400);
        }

        $property = Properti::create($storeData);
        return response
        (
            [
                'message' => 'Property Added Successfully',
                'data' => $property,
            ], 200);
    }

    public function edit(Request $request, $id)
    {
        $property = Properti::find($id);

        if(is_null($property))
        {
            return response([
                'message' => 'Property Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData,
        [
            'luas_tanah' => 'required',
            'luas_bangunan' => 'required',
            'status_properti' => 'required',
        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()], 400);
        }

        $property->luas_tanah = $updateData['luas_tanah'];
        $property->luas_bangunan = $updateData['luas_bangunan'];
        $property->status_properti = $updateData['status_properti'];

        if($property->save())
        {
            return response(
                [
                    'message' => 'Property Has Been Updated',
                    'data' => $property,
                ], 200);
        }

        return response(
            [
                'message' => 'Property Cannot Be Updated',
                'data' => null,
            ], 400);
    }

    public function editJmlhDenda(Request $request, $id)
    {
        $property = Properti::find($id);

        if(is_null($property))
        {
            return response([
                'message' => 'Property Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData,
        [
            'jumlah_denda' => 'required|numeric',
        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()], 400);
        }

        $property->jumlah_denda = $updateData['jumlah_denda'];

        if($property->save())
        {
            return response(
                [
                    'message' => 'Property Has Been Updated',
                    'data' => $property,
                ], 200);
        }

        return response(
            [
                'message' => 'Property Cannot Be Updated',
                'data' => null,
            ], 400);
    }

    public function editStatus(Request $request, $id)
    {
        $property = Properti::find($id);

        if(is_null($property))
        {
            return response([
                'message' => 'Property Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData,
        [
            'status_properti' => 'required|string',
        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()], 400);
        }

        $property->status_properti = $updateData['status_properti'];

        if($property->save())
        {
            return response(
                [
                    'message' => 'Status Has Been Updated',
                    'data' => $property,
                ], 200);
        }

        return response(
            [
                'message' => 'Status Cannot Be Updated',
                'data' => null,
            ], 400);
    }
}
