<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\CCTVAccess;
use Carbon\Carbon;
use Validator;
use Illuminate\Support\Facades\DB;

class CCTVAccessController extends Controller
{
    public function search($id)
    {
        $cctvAccess = DB::table('cctv_access')
            ->join('properti', 'properti.id_properti', '=', 'cctv_access.id_properti')
            ->select('cctv_access.*', 'properti.*')
            ->where('cctv_access.id_properti', '=', $id)
            ->first();

        if(!is_null($cctvAccess))
        {
            return response([
                'message' => 'CCTV Access Has Been Retrieved',
                'data' => $cctvAccess
            ], 200);
        }

        return response([
            'message' => 'CCTV Access Cannot Be Retrieved',
            'data' => null
        ], 404);
    }
}