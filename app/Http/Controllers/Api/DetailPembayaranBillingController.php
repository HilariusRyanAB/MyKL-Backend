<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\DetailPembayaranBilling;
use App\Properti;
use App\Billing;
use App\InternetAccess;
use App\CCTVAccess;
use App\WaterFacility;
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
                    ->join('properti', 'properti.id_properti', '=', 'billing.id_properti')
                    ->join('user', 'user.id_user', '=', 'detail_pembayaran_billing.id_user')
                    ->select('detail_pembayaran_billing.*', 'billing.*', 'user.*', 'properti.*')
                    ->where('user.id_user', '=', $id)
                    ->where('billing.status_billing', '=', 'Paid')
                    ->get();

        if(!is_null($detailPembayaranBilling))
        {
            return response([
                'message' => 'All Detail Billing Payment Has Been Retrieved',
                'data' => $detailPembayaranBilling
            ], 200);
        }

        return response([
            'message' => 'All Detail Billing Payment Cannot Be Retrieved',
            'data' => null
        ], 404);
    }
    
    public function searchMobile($id)
    {
        $detailPembayaranBilling = DB::table('detail_pembayaran_billing')
                    ->join('billing', 'billing.id_billing', '=', 'detail_pembayaran_billing.id_billing')
                    ->join('properti', 'properti.id_properti', '=', 'billing.id_properti')
                    ->join('user', 'user.id_user', '=', 'detail_pembayaran_billing.id_user')
                    ->select('detail_pembayaran_billing.*', 'billing.*', 'user.*', 'properti.*')
                    ->where('billing.id_billing', '=', $id)
                    ->first();

        if(!is_null($detailPembayaranBilling))
        {
            return response([
                'message' => 'Detail Billing Payment Has Been Retrieved',
                'data' => $detailPembayaranBilling
            ], 200);
        }

        return response([
            'message' => 'Detail Billing Payment Cannot Be Retrieved',
            'data' => null
        ], 404);
    }

    public function addMobile(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData,
        [
            'id_user' => 'required',
            'id_billing' => 'required|numeric', 
            'tanggal_pembayaran' => 'required',
            'total_bayar' => 'required', 
        ]);

        $billing = Billing::find($storeData->id_billing);
        $billing->status_billing = "Paid";
        $billing->save();

        $property = Properti::find($billing->id_properti);
        $property->jumlah_denda = 0;
        $property->save();
        
        $internetAccesses = DB::table('internet_access')
                        ->select('internet_access.*')
                        ->where('id_properti', '=', $billing->id_properti)
                        ->first();
        $internetAccess = InternetAccess::find($internetAccesses->id_internet_access);
        $internetAccess->status_internet_access = "Active";
        $internetAccess->save();

        $cctvAccesses = DB::table('cctv_access')
                        ->select('cctv_access.*')
                        ->where('id_properti', '=', $billing->id_properti)
                        ->first();
        $cctvAccess = CCTVAccess::find($cctvAccesses->id_cctv_access);
        $cctvAccess->status_cctv_access = "Active";
        $cctvAccess->save();
        
        $waterFacilities = DB::table('water_facility')
                        ->select('water_facility.*')
                        ->where('id_properti', '=', $billing->id_properti)
                        ->first();
        $waterFacility = WaterFacility::find($waterFacilities->id_water_facility);
        $waterFacility->status_water_facility = "Active";
        $waterFacility->save();

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