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
    public function readPemilik($id)
    {
        $month = Carbon::now()->format('F');
        
        $billing = DB::table('properti')
            ->join('history_kepemilikan', 'history_kepemilikan.id_properti', '=', 'properti.id_properti')
            ->join('user', 'user.id_user', '=', 'history_kepemilikan.id_user')
            ->join('billing', 'billing.id_properti', '=', 'properti.id_properti')
            ->select('properti.*', 'user.*', 'history_kepemilikan.*', 'billing.*')
            ->where('history_kepemilikan.status_kepemilikan', '=', 'Active')
            ->where('user.id_user', '=', $id)
            ->where(DB::raw("monthname(billing.tanggal_pembuatan_billing)"), '=', $month)
            ->where('properti.status_properti', '=', 'Active')
            ->where('billing.status_billing', '<>', 'Paid')
            ->orderBy('properti.nomor_kavling','asc')
            ->get();

        if(count($billing) > 0)
        {
            return response([
                'message' => 'All Billing Has Been Retrieved',
                'data' => $billing
            ], 200);
        }

        return response([
            'message' => 'All Billing Cannot Be Retrieved',
            'data' => null
        ], 404);
    }

    public function readPenyewa($id)
    {
        $month = Carbon::now()->format('F');
        
        $billing = DB::table('properti')
            ->join('history_penyewaan', 'history_penyewaan.id_properti', '=', 'properti.id_properti')
            ->join('user', 'user.id_user', '=', 'history_penyewaan.id_user')
            ->join('billing', 'billing.id_properti', '=', 'properti.id_properti')
            ->select('properti.*', 'user.*', 'history_penyewaan.*', 'billing.*')
            ->where('history_penyewaan.status_penyewaan', '=', 'Active')
            ->where('user.id_user', '=', $id)
            ->where(DB::raw("monthname(billing.tanggal_pembuatan_billing)"), '=', $month)
            ->where('properti.status_properti', '=', 'Active')
            ->where('billing.status_billing', '<>', 'Paid')
            ->orderBy('properti.nomor_kavling','asc')
            ->get();

        if(count($billing) > 0)
        {
            return response([
                'message' => 'All Billing Has Been Retrieved',
                'data' => $billing
            ], 200);
        }

        return response([
            'message' => 'All Billing Cannot Be Retrieved',
            'data' => null
        ], 404);
    }
    
    public function searchMobile($id)
    {
        $month = Carbon::now()->format('F');
        $year = Carbon::now()->format('Y');

        $billing = DB::table('billing')
                    ->join('properti', 'billing.id_properti', '=', 'properti.id_properti')
                    ->select('billing.*', 'properti.*')
                    ->where(DB::raw("monthname(billing.tanggal_pembuatan_billing)"), '=', $month)
                    ->where(DB::raw("year(billing.tanggal_pembuatan_billing)"), '=', $year)
                    ->where('properti.id_properti', '=', $id)
                    ->first();

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
}