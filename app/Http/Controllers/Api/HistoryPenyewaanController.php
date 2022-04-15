<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\HistoryPenyewaan;
use Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HistoryPenyewaanController extends Controller
{
    //Mobile
    public function searchMobile($id)
    {
        $historyPenyewaan = DB::table('history_penyewaan')
                                ->join('properti', 'history_penyewaan.id_properti', '=', 'properti.id_properti')
                                ->join('penyewa', 'history_penyewaan.id_penyewa', '=', 'penyewa.id_penyewa')
                                ->select('history_penyewaan.*')
                                ->where('penyewa.id_penyewa', '=', $id)
                                ->get();

        if(!is_null($historyPenyewaan))
        {
            return response
            (
                [
                    'message' => 'History Penyewaan Has Been Retrieved',
                    'data' => $historyPenyewaan
                ], 200); 
        }

        return response
        (
            [
                'message' => 'History Penyewaan Cannot Be Retrieved',
                'data' => null
            ], 404);
    }

    public function addMobile(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData,
        [
            'id_penyewa' => 'required', 
            'id_properti' => 'required', 
            'tanggal_mulai_penyewaan' => 'required',
            'tanggal_berhenti_penyewaan' => 'required', 
            'status_penyewaan' => 'required|string'
        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()], 400);
        }

        $historyPenyewaan = HistoryPenyewaan::create($storeData);
        return response
        (
            [
                'message' => 'History Penyewaan Added Successfully',
                'data' => $historyPenyewaan,
            ], 200);
    }

    public function editMobile(Request $request, $id)
    {
        $historyPenyewaan = Penyewa::find($id);

        if(is_null($historyPenyewaan))
        {
            return response([
                'message' => 'History Penyewaan Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData,
        [
            'tanggal_berhenti_penyewaan' => 'required', 
            'status_penyewaan' => 'required|string'
        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()], 400);
        }

        $historyPenyewaan->tanggal_berhenti_penyewaan = $updateData['tanggal_berhenti_penyewaan'];
        $historyPenyewaan->status_penyewaan = $storeData['status_penyewaan'];

        if($historyPenyewaan->save())
        {
            return response(
                [
                    'message' => 'History Penyewaan Has Been Updated',
                    'data' => $historyPenyewaan,
                ], 200);
        }

        return response(
            [
                'message' => 'History Penyewaan Cannot Be Updated',
                'data' => null,
            ], 400);
    }

    //Web
    public function read()
    {
        $historyPenyewaan = DB::table('history_penyewaan')
                                ->join('properti', 'history_penyewaan.id_properti', '=', 'properti.id_properti')
                                ->join('penyewa', 'history_penyewaan.id_penyewa', '=', 'penyewa.id_penyewa')
                                ->select('history_penyewaan.*')
                                ->get();

        if(!is_null($historyPenyewaan))
        {
            return response
            (
                [
                    'message' => 'All History Penyewaan Has Been Retrieved',
                    'data' => $historyPenyewaan
                ], 200); 
        }

        return response
        (
            [
                'message' => 'All History Penyewaan Cannot Be Retrieved',
                'data' => null
            ], 404);
    }

    public function add(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData,
        [
            'id_penyewa' => 'required', 
            'id_properti' => 'required', 
            'tanggal_mulai_penyewaan' => 'required',
            'tanggal_berhenti_penyewaan' => 'required', 
            'status_penyewaan' => 'required|string'
        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()], 400);
        }

        $historyPenyewaan = HistoryPenyewaan::create($storeData);
        return response
        (
            [
                'message' => 'History Penyewaan Added Successfully',
                'data' => $historyPenyewaan,
            ], 200);
    }

    public function edit(Request $request, $id)
    {
        $historyPenyewaan = Penyewa::find($id);

        if(is_null($historyPenyewaan))
        {
            return response([
                'message' => 'History Penyewaan Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData,
        [
            'tanggal_berhenti_penyewaan' => 'required', 
            'status_penyewaan' => 'required|string'
        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()], 400);
        }

        $historyPenyewaan->tanggal_berhenti_penyewaan = $updateData['tanggal_berhenti_penyewaan'];
        $historyPenyewaan->status_penyewaan = $storeData['status_penyewaan'];

        if($historyPenyewaan->save())
        {
            return response(
                [
                    'message' => 'History Penyewaan Has Been Updated',
                    'data' => $historyPenyewaan,
                ], 200);
        }

        return response(
            [
                'message' => 'History Penyewaan Cannot Be Updated',
                'data' => null,
            ], 400);
    }
}
