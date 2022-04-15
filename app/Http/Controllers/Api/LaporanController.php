<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function laporanPembayaranBulanan(Request $request)
    {
        $input = $request->all();
        $validate = Validator::make($input, [
            'bulan' => 'required',
            'tahun' => 'required',
        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()],400);
        }

        $details = DB::table('billing')
            ->join('properti', 'billing.id_properti', '=', 'properti.id_properti')
            ->select("properti.nomor_kavling as nomor_kavling", "billing.status_bayar as status_pembayaran", "billing.total_biaya as total_biaya",
                "billing.tanggal_pembayaran_billing as tanggal_pembayaran")
            ->where(DB::raw("year(billing.tanggal_pembuatan_billing)"), $input['tahun'])
            ->where(DB::raw("properti.status_properti"), "Active")
            ->where(DB::raw("monthname(billing.tanggal_pembuatan_billing)"), $input['bulan'])
            ->get();

        if(count($details) > 0)
        {
            return response([
                'message' => 'Report Successfully Create',
                'data' => $details,
            ],200);
        }
        
        return response([
            'message' => 'Cannot Get The Report',
            'data' => null,
        ],404);
    }

    public function laporanPendapatanBulanan(Request $request)
    {
        $input = $request->all();
        $validate = Validator::make($input, [
            'tahun' => 'required',
        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()],400);
        }

        $details = DB::table('billing')
            ->select(DB::raw("monthname(billing.tanggal_pembuatan_billing) as month"), DB::raw("(SELECT SUM(billing.total_biaya) FROM billing 
                                JOIN properti ON billing.id_properti = properti.id_properti
                                WHERE properti.status_properti = 'Active'
                                AND billing.status_bayar = 'Paid'
                                AND year(billing.tanggal_pembuatan_billing) = ".$input['tahun'].") as total"))->join('properti', 'billing.id_properti', '=', 'properti.id_properti')
            ->where(DB::raw("year(billing.tanggal_pembuatan_billing)"), $input['tahun'])
            ->where("properti.status_properti", 'Active')
            ->where("billing.status_bayar", 'Paid')
            ->groupBy([DB::raw("monthname(billing.tanggal_pembuatan_billing)")])
            ->get();

        if(count($details) > 0)
        {
            return response([
                'message' => 'Report Successfully Create',
                'data' => $details,
            ],200);
        }
        
        return response([
            'message' => 'Cannot Get The Report',
            'data' => null,
        ],404);
    }
}