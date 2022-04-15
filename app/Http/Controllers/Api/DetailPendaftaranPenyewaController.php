<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DetailPendaftaranPenyewa;
use Validator;
use Illuminate\Support\Facades\DB;

class DetailPendaftaranPenyewaController extends Controller
{
    //Mobile
    public function readMobile($id)
    {
        $document = DB::table('detail_pendaftaran_penyewa')
                    ->join('penyewa', 'penyewa.id_penyewa', '=', 'detail_pendaftaran_penyewa.id_penyewa')
                    ->join('pemilik', 'pemilik.id_pemilik', '=', 'detail_pendaftaran_penyewa.id_pemilik')
                    ->select('detail_pendaftaran_penyewa.*', 'penyewa.*', 'pemilik.*')
                    ->where('pemilik.id_pemilik', '=', $id)
                    ->get();

        if(!is_null($document))
        {
            return response([
                'messsage' => 'All Rental Registration Has Been Retrieved',
                'data' => $document
            ], 200);
        }

        return response([
            'message' => 'All Rental Registration Cannot Be Retrieved',
            'data' => null
        ], 404);
    }

    public function addMobile(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData,
        [
            'id_pemilik' => 'required|numeric', 
            'id_penyewa' => 'required|numeric', 
            'tanggal_pendaftaran' => 'required',
        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()], 400);
        }

        $document = DokumenPenyewaan::create($storeData);
        return response
        (
            [
                'message' => 'Rental Registration Added Successfully',
                'data' => $document,
            ], 200);
    }

    //Web
    public function read()
    {
        $document = DB::table('detail_pendaftaran_penyewa')
                    ->join('penyewa', 'penyewa.id_penyewa', '=', 'detail_pendaftaran_penyewa.id_penyewa')
                    ->join('pemilik', 'pemilik.id_pemilik', '=', 'detail_pendaftaran_penyewa.id_pemilik')
                    ->select('detail_pendaftaran_penyewa.*', 'penyewa.*', 'pemilik.*')
                    ->get();

        if(!is_null($document))
        {
            return response([
                'messsage' => 'All Rental Registration Has Been Retrieved',
                'data' => $document
            ], 200);
        }

        return response([
            'message' => 'All Rental Registration Cannot Be Retrieved',
            'data' => null
        ], 404);
    }

    public function add(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData,
        [
            'id_pemilik' => 'required|numeric', 
            'id_penyewa' => 'required|numeric', 
            'tanggal_pendaftaran' => 'required',
        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()], 400);
        }

        $document = DokumenPenyewaan::create($storeData);
        return response
        (
            [
                'message' => 'Rental Registration Added Successfully',
                'data' => $document,
            ], 200);
    }
}
