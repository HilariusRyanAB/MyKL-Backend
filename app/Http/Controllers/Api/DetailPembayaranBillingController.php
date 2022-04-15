<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DetailPembayaranBilling;
use App\Http\Controllers\Api\BillingController;
use Validator;
use Illuminate\Support\Facades\DB;

class DetailPembayaranBillingController extends Controller
{
    //Mobile
    public function readMobile($id)
    {
        $detailPembayaranBilling = DB::table('detail_pembayaran_billing')
                    ->join('billing', 'billing.id_billing', '=', 'detail_pembayaran_billing.id_billing')
                    ->select('detail_pembayaran_billing.*', 'billing.*')
                    ->where('billing.id_billing', '=', $id)
                    ->get();

        if(!is_null($detailPembayaranBilling))
        {
            return response([
                'messsage' => 'Detail Billing Payment Has Been Retrieved',
                'data' => $detailPembayaranBilling
            ], 200);
        }

        return response([
            'message' => 'Detail Billing Payment Cannot Be Retrieved',
            'data' => null
        ], 404);
    }

    public function addPemilikMobile__construct(Request $request)
    {

        $storeData = $request->all();
        $validate = Validator::make($storeData,
        [
            'id_pemilik' => 'required',
            'id_billing' => 'required|numeric', 
            'tanggal_pembayaran' => 'required', 
            'total_bayar' => 'required', 
        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()], 400);
        }

        $detailPembayaranBilling = DetailPembayaranBilling::create($storeData);
        return response
        (
            [
                'message' => 'Detail Billing Payment Added Successfully',
                'data' => $detailPembayaranBilling,
            ], 200);
    }

    public function addPenyewaMobile(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData,
        [
            'id_penyewa' => 'required',
            'id_billing' => 'required|numeric', 
            'tanggal_pembayaran' => 'required',
            'total_bayar' => 'required', 
        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()], 400);
        }

        $detailPembayaranBilling = DetailPembayaranBilling::create($storeData);
        return response
        (
            [
                'message' => 'Detail Billing Payment Added Successfully',
                'data' => $detailPembayaranBilling,
            ], 200);
    }

    //Web
    public function read()
    {
        $detailPembayaranBilling = DB::table('detail_pembayaran_billing')
                    ->join('billing', 'billing.id_billing', '=', 'detail_pembayaran_billing.id_billing')
                    ->select('detail_pembayaran_billing.*', 'billing.*')
                    ->get();

        if(!is_null($detailPembayaranBilling))
        {
            return response([
                'messsage' => 'Detail Billing Payment Has Been Retrieved',
                'data' => $detailPembayaranBilling
            ], 200);
        }

        return response([
            'message' => 'Detail Billing Payment Cannot Be Retrieved',
            'data' => null
        ], 404);
    }

    public function addPemilik(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData,
        [
            'id_pemilik' => 'required',
            'id_billing' => 'required|numeric', 
            'tanggal_pembayaran' => 'required', 
            'total_bayar' => 'required', 
        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()], 400);
        }

        $detailPembayaranBilling = DetailPembayaranBilling::create($storeData);
        return response
        (
            [
                'message' => 'Detail Billing Payment Added Successfully',
                'data' => $detailPembayaranBilling,
            ], 200);
    }

    public function addPenyewa(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData,
        [
            'id_penyewa' => 'required',
            'id_billing' => 'required|numeric', 
            'tanggal_pembayaran' => 'required', 
            'total_bayar' => 'required', 
        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()], 400);
        }

        $detailPembayaranBilling = DetailPembayaranBilling::create($storeData);
        return response
        (
            [
                'message' => 'Detail Billing Payment Added Successfully',
                'data' => $detailPembayaranBilling,
            ], 200);
    }
}