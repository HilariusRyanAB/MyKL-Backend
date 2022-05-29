<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\WaterFacility;
use Carbon\Carbon;
use Validator;
use Illuminate\Support\Facades\DB;

class WaterFacilityController extends Controller
{
    public function search($id)
    {
        $waterFacility = DB::table('water_facility')
            ->join('properti', 'properti.id_properti', '=', 'water_facility.id_properti')
            ->select('water_facility.*', 'properti.*')
            ->where('water_facility.id_properti', '=', $id)
            ->first();

        if(!is_null($waterFacility))
        {
            return response([
                'message' => 'Water Facility Has Been Retrieved',
                'data' => $waterFacility
            ], 200);
        }

        return response([
            'message' => 'Water Facility Cannot Be Retrieved',
            'data' => null
        ], 404);
    }
}