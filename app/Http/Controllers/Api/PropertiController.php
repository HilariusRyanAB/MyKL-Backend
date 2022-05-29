<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Properti;
use Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PropertiController extends Controller
{
    public function readPemilik($id)
    {
        $month = Carbon::now()->format('F');
        
        $properties = DB::table('properti')
            ->join('history_kepemilikan', 'history_kepemilikan.id_properti', '=', 'properti.id_properti')
            ->join('user', 'user.id_user', '=', 'history_kepemilikan.id_user')
            ->join('billing', 'billing.id_properti', '=', 'properti.id_properti')
            ->leftjoin('denda', 'billing.id_billing', '=', 'denda.id_billing')
            ->select('properti.*', 'user.*', 'history_kepemilikan.*', 'billing.*', 'denda.*')
            ->where('history_kepemilikan.status_kepemilikan', '=', 'Active')
            ->where('user.id_user', '=', $id)
            ->where(DB::raw("monthname(billing.tanggal_pembuatan_billing)"), '=', $month)
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
        $month = Carbon::now()->format('F');
        
        $properties = DB::table('properti')
            ->join('history_penyewaan', 'history_penyewaan.id_properti', '=', 'properti.id_properti')
            ->join('user', 'user.id_user', '=', 'history_penyewaan.id_user')
            ->join('billing', 'billing.id_properti', '=', 'properti.id_properti')
            ->leftjoin('denda', 'billing.id_billing', '=', 'denda.id_billing')
            ->select('properti.*', 'user.*', 'history_penyewaan.*', 'billing.*', 'denda.*')
            ->where('history_penyewaan.status_penyewaan', '=', 'Active')
            ->where('user.id_user', '=', $id)
            ->where(DB::raw("monthname(billing.tanggal_pembuatan_billing)"), '=', $month)
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

    public function searchMobile($id)
    {
        $month = Carbon::now()->format('F');

        $property = DB::table('properti')
            ->join('internet_access', 'internet_access.id_properti', '=', 'properti.id_properti')
            ->join('cctv_access', 'cctv_access.id_properti', '=', 'properti.id_properti')
            ->join('water_facility', 'water_facility.id_properti', '=', 'properti.id_properti')
            ->join('billing', 'billing.id_properti', '=', 'properti.id_properti')
            ->leftjoin('denda', 'billing.id_billing', '=', 'denda.id_billing')
            ->select('properti.*', 'internet_access.*', 'cctv_access.*', 'water_facility.*', 'billing.*', 'denda.*')
            ->where('properti.id_properti', '=', $id)
            ->where(DB::raw("monthname(billing.tanggal_pembuatan_billing)"), '=', $month)
            ->first();

        if(!is_null($property))
        {
            return response([
                'message' => 'Property Has Been Retrieved',
                'data' => $property
            ], 200);
        }

        return response([
            'message' => 'Property Cannot Be Retrieved',
            'data' => null
        ], 404);
    }
}