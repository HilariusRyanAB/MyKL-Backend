<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Billing;
use App\Properti;
use Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BillingController extends Controller
{
    //Mobile
    public function searchMobile($id)
    {
        $month = Carbon::now()->format('F');
        $year = Carbon::now()->format('Y');

        $billing = DB::table('billing')
                    ->join('properti', 'billing.id_properti', '=', 'properti.id_properti')
                    ->select('billing.*')
                    ->where(DB::raw("monthname(billing.tanggal_pembuatan_billing)"), '=', $month)
                    ->where(DB::raw("year(billing.tanggal_pembuatan_billing)"), '=', $year)
                    ->where('properti.id_properti', '=', $id)
                    ->get();

        if(!is_null($billing))
        {
            return response
            (
                [
                    'message' => 'Billing Has Been Retrieved',
                    'data' => $billing
                ], 200); 
        }

        return response
        (
            [
                'message' => 'Billing Cannot Be Retrieved',
                'data' => null
            ], 404);
    }

    public function editStatusMobile(Request $request, $id)
    {
        $billings = DB::table('billing')
                    ->select('billing.*')
                    ->where('id_billing', '=', $id)
                    ->first();

        $billing = Billing::find($billings->id_billing);
        $property = Properti::find($billings->id_properti);

        if(is_null($billing))
        {
            return response([
                'message' => 'Billing Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();

        if($validate->fails())
        {
            return response(['message' => $validate->errors()], 400);
        }

        $billing->status_billing = "Paid";

        $property->jumlah_denda = 0;
        $property->save();

        if($billing->save())
        {
            return response(
                [
                    'message' => 'Status Has Been Updated',
                    'data' => $billing,
                ], 200);
        }

        return response(
            [
                'message' => 'Status Cannot Be Updated',
                'data' => null,
            ], 400);
    }

    //Web
    public function read()
    {
        $month = Carbon::now()->format('F');
        $year = Carbon::now()->format('Y');

        $billings = DB::table('billing')
                    ->join('properti', 'billing.id_properti', '=', 'properti.id_properti')
                    ->select('billing.*')
                    ->where(DB::raw("monthname(billing.tanggal_pembuatan_billing)"), '=', $month)
                    ->where(DB::raw("year(billing.tanggal_pembuatan_billing)"), '=', $year)
                    ->get();

        if(!is_null($billings))
        {
            return response
            (
                [
                    'message' => 'All Billings Has Been Retrieved',
                    'data' => $billings
                ], 200); 
        }

        return response
        (
            [
                'message' => 'Billings Cannot Be Retrieved',
                'data' => null
            ], 404);
    }

    public function editStatus(Request $request, $id)
    {
        $month = Carbon::now()->format('F');

        $billings = DB::table('billing')
                    ->select('billing.*')
                    ->where('id_billing', '=', $id)
                    ->first();
        
        $billing = Billing::find($billings->id_billing);
        $property = Properti::find($billings->id_properti);

        if(is_null($billing))
        {
            return response([
                'message' => 'Billing Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        if($validate->fails())
        {
            return response(['message' => $validate->errors()], 400);
        }

        $billing->status_billing = "Paid";

        $property->jumlah_denda = 0;
        $property->save();

        if($billing->save())
        {
            return response(
                [
                    'message' => 'Status Has Been Updated',
                    'data' => $billing,
                ], 200);
        }

        return response(
            [
                'message' => 'Status Cannot Be Updated',
                'data' => null,
            ], 400);
    }
}