<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\InternetAccess;
use Carbon\Carbon;
use Validator;
use Illuminate\Support\Facades\DB;

class InternetAccessController extends Controller
{
    public function search($id)
    {
        $internetAccess = DB::table('internet_access')
            ->join('properti', 'properti.id_properti', '=', 'internet_access.id_properti')
            ->select('internet_access.*', 'properti.*')
            ->where('internet_access.id_properti', '=', $id)
            ->first();

        if(!is_null($internetAccess))
        {
            return response([
                'message' => 'Internet Access Has Been Retrieved',
                'data' => $internetAccess
            ], 200);
        }

        return response([
            'message' => 'Internet Access Cannot Be Retrieved',
            'data' => null
        ], 404);
    }
}