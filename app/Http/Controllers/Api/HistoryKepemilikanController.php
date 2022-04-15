<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\HistoryKepemilikan;
use Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HistoryKepemilikanController extends Controller
{
    //Mobile
    public function searchMobile($id)
    {
        $historyKepemilikan = DB::table('history_kepemilikan')
                                ->join('properti', 'history_kepemilikan.id_properti', '=', 'properti.id_properti')
                                ->join('pemilik', 'history_kepemilikan.id_pemilik', '=', 'pemilik.id_pemilik')
                                ->select('history_kepemilikan.*')
                                ->where('pemilik.id_pemilik', '=', $id)
                                ->get();

        if(!is_null($historyKepemilikan))
        {
            return response
            (
                [
                    'message' => 'History Kepemilikan Has Been Retrieved',
                    'data' => $historyKepemilikan
                ], 200); 
        }

        return response
        (
            [
                'message' => 'History Kepemilikan Cannot Be Retrieved',
                'data' => null
            ], 404);
    }

    public function addMobile(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData,
        [
            'id_pemilik' => 'required', 
            'id_properti' => 'required', 
            'tanggal_mulai_kepemilikan' => 'required',
            'tanggal_berhenti_kepemilikan' => 'required', 
            'status_kepemilikan' => 'required|string'
        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()], 400);
        }

        $historyKepemilikan = HistoryKepemilikan::create($storeData);
        return response
        (
            [
                'message' => 'History Kepemilikan Added Successfully',
                'data' => $historyKepemilikan,
            ], 200);
    }

    public function editMobile(Request $request, $id)
    {
        $historyKepemilikan = Penyewa::find($id);

        if(is_null($historyKepemilikan))
        {
            return response([
                'message' => 'History Kepemilikan Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData,
        [
            'tanggal_berhenti_kepemilikan' => 'required', 
            'status_kepemilikan' => 'required|string'
        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()], 400);
        }

        $historyKepemilikan->tanggal_berhenti_kepemilikan = $updateData['tanggal_berhenti_kepemilikan'];
        $historyKepemilikan->status_kepemilikan = $storeData['status_kepemilikan'];

        if($historyKepemilikan->save())
        {
            return response(
                [
                    'message' => 'History Kepemilikan Has Been Updated',
                    'data' => $historyKepemilikan,
                ], 200);
        }

        return response(
            [
                'message' => 'History Kepemilikan Cannot Be Updated',
                'data' => null,
            ], 400);
    }

    //Web
    public function read()
    {
        $historyKepemilikan = DB::table('history_kepemilikan')
                                ->join('properti', 'history_kepemilikan.id_properti', '=', 'properti.id_properti')
                                ->join('pemilik', 'history_kepemilikan.id_pemilik', '=', 'pemilik.id_pemilik')
                                ->select('history_kepemilikan.*')
                                ->get();

        if(!is_null($historyKepemilikan))
        {
            return response
            (
                [
                    'message' => 'All History Kepemilikan Has Been Retrieved',
                    'data' => $historyKepemilikan
                ], 200); 
        }

        return response
        (
            [
                'message' => 'All History Kepemilikan Cannot Be Retrieved',
                'data' => null
            ], 404);
    }

    public function add(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData,
        [
            'id_pemilik' => 'required', 
            'id_properti' => 'required', 
            'tanggal_mulai_kepemilikan' => 'required',
            'tanggal_berhenti_kepemilikan' => 'required', 
            'status_kepemilikan' => 'required|string'
        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()], 400);
        }

        $historyKepemilikan = HistoryKepemilikan::create($storeData);
        return response
        (
            [
                'message' => 'History Kepemilikan Added Successfully',
                'data' => $historyKepemilikan,
            ], 200);
    }

    public function edit(Request $request, $id)
    {
        $historyKepemilikan = Penyewa::find($id);

        if(is_null($historyKepemilikan))
        {
            return response([
                'message' => 'History Kepemilikan Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData,
        [
            'tanggal_berhenti_kepemilikan' => 'required', 
            'status_kepemilikan' => 'required|string'
        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()], 400);
        }

        $historyKepemilikan->tanggal_berhenti_kepemilikan = $updateData['tanggal_berhenti_kepemilikan'];
        $historyKepemilikan->status_kepemilikan = $storeData['status_kepemilikan'];

        if($historyKepemilikan->save())
        {
            return response(
                [
                    'message' => 'History Kepemilikan Has Been Updated',
                    'data' => $historyKepemilikan,
                ], 200);
        }

        return response(
            [
                'message' => 'History Kepemilikan Cannot Be Updated',
                'data' => null,
            ], 400);
    }
}
