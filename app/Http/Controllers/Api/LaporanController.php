<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Properti;
use PDF;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{
    public function laporanPembayaranTahunan(Request $request)
    {
        $input = $request->all();
        $validate = Validator::make($input, [
            'id_properti' => 'required',
            'tahun' => 'required',
        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()],400);
        }
        
    $data = DB::table('billing')
            ->select('months.id_month', 'months.month_name', "billing.total_biaya as total_biaya", "detail_pembayaran_billing.metode_pembayaran as metode_pembayaran", "billing.status_billing as status_pembayaran")
            ->join('properti', 'billing.id_properti', '=', 'properti.id_properti')
            ->leftjoin('detail_pembayaran_billing', 'billing.id_billing', '=', 'detail_pembayaran_billing.id_billing')
            ->join('months', 'months.month_name', 'like', DB::raw("monthname(billing.tanggal_pembuatan_billing)"))
            ->where(DB::raw("year(billing.tanggal_pembuatan_billing)"), $input['tahun'])
            ->where(DB::raw("properti.status_properti"), "Active")
            ->where(DB::raw("properti.id_properti"), $input['id_properti'])
            ->union(
                DB::table('billing')
                    ->select(DB::raw("months.id_month, months.month_name, NULL as total_biaya, NULL as metode_pembayaran, NULL as status_pembayaran"))
                    ->join('properti', 'billing.id_properti', '=', 'properti.id_properti')
                    ->join('detail_pembayaran_billing', 'billing.id_billing', '=', 'detail_pembayaran_billing.id_billing')
                    ->join('months', 'months.month_name', 'not like', DB::raw("monthname(billing.tanggal_pembuatan_billing)"))
                    ->where(DB::raw("year(billing.tanggal_pembuatan_billing)"), $input['tahun'])
                    ->where(DB::raw("properti.status_properti"), "Active")
                    ->where(DB::raw("properti.id_properti"), $input['id_properti'])
                    ->whereNotIn(DB::raw("months.month_name"),
                            [DB::raw("select months.month_name from billing join months on months.month_name like monthname(billing.tanggal_pembuatan_billing)"
                            )]
                        )
                    ->distinct()
                )
            ->orderBy('id_month')
            ->get();
        
        if(count($data) > 0)
        {
            return response([
                'message' => 'Report Successfully Create',
                'data' => 'https://mykl.klbizhubbilling.xyz/api/previewReport?id_properti='.$input['id_properti'].'&tahun='.$input['tahun'],
            ],200);
        }
        
        return response([
            'message' => 'Failed to Create Report',
            'data' => null
        ], 404);
    }
    
    public function previewReport(Request $request)
    {
        $input = $request->all();
        $validate = Validator::make($input, [
            'id_properti' => 'required',
            'tahun' => 'required',
        ]);
        
        $nomorKavling = Properti::find($input['id_properti']);
        
        if($validate->fails())
        {
            return response(['message' => $validate->errors()],400);
        }
        
        return view('payment_report', [
            "billings" => DB::table('billing')
                        ->select('months.id_month', 'months.month_name', "billing.total_biaya as total_biaya", "detail_pembayaran_billing.metode_pembayaran as metode_pembayaran", "billing.status_billing as status_pembayaran")
                        ->join('properti', 'billing.id_properti', '=', 'properti.id_properti')
                        ->leftjoin('detail_pembayaran_billing', 'billing.id_billing', '=', 'detail_pembayaran_billing.id_billing')
                        ->join('months', 'months.month_name', 'like', DB::raw("monthname(billing.tanggal_pembuatan_billing)"))
                        ->where(DB::raw("year(billing.tanggal_pembuatan_billing)"), $input['tahun'])
                        ->where(DB::raw("properti.status_properti"), "Active")
                        ->where(DB::raw("properti.id_properti"), $input['id_properti'])
                        ->union(
                            DB::table('billing')
                                ->select(DB::raw("months.id_month, months.month_name, NULL as total_biaya, NULL as metode_pembayaran, NULL as status_pembayaran"))
                                ->join('properti', 'billing.id_properti', '=', 'properti.id_properti')
                                ->join('detail_pembayaran_billing', 'billing.id_billing', '=', 'detail_pembayaran_billing.id_billing')
                                ->join('months', 'months.month_name', 'not like', DB::raw("monthname(billing.tanggal_pembuatan_billing)"))
                                ->where(DB::raw("year(billing.tanggal_pembuatan_billing)"), $input['tahun'])
                                ->where(DB::raw("properti.status_properti"), "Active")
                                ->where(DB::raw("properti.id_properti"), $input['id_properti'])
                                ->whereNotIn(DB::raw("months.month_name"),
                                        [DB::raw("select months.month_name from billing join months on months.month_name like monthname(billing.tanggal_pembuatan_billing)"
                                        )]
                                    )
                                ->distinct()
                            )
                        ->orderBy('id_month')
                        ->get(),
            "nomor_kavling" => $nomorKavling['nomor_kavling'],
            "period" => $input['tahun'],
        ]);
    }
    
    public function cetakLaporanPembayaranTahunan(Request $request)
    {
        $input = $request->all();
        $validate = Validator::make($input, [
            'id_properti' => 'required',
            'tahun' => 'required',
        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()],400);
        }
        
        $property= DB::table('properti')->select('properti.*')->where('properti.id_properti', $input['id_properti'])->first();
        
        $details = DB::table('billing')
                    ->select('months.id_month', 'months.month_name', "billing.total_biaya as total_biaya", "detail_pembayaran_billing.metode_pembayaran as metode_pembayaran", "billing.status_billing as status_pembayaran")
                    ->join('properti', 'billing.id_properti', '=', 'properti.id_properti')
                    ->leftjoin('detail_pembayaran_billing', 'billing.id_billing', '=', 'detail_pembayaran_billing.id_billing')
                    ->join('months', 'months.month_name', 'like', DB::raw("monthname(billing.tanggal_pembuatan_billing)"))
                    ->where(DB::raw("year(billing.tanggal_pembuatan_billing)"), $input['tahun'])
                    ->where(DB::raw("properti.status_properti"), "Active")
                    ->where(DB::raw("properti.id_properti"), $input['id_properti'])
                    ->union(
                        DB::table('billing')
                            ->select(DB::raw("months.id_month, months.month_name, NULL as total_biaya, NULL as metode_pembayaran, NULL as status_pembayaran"))
                            ->join('properti', 'billing.id_properti', '=', 'properti.id_properti')
                            ->join('detail_pembayaran_billing', 'billing.id_billing', '=', 'detail_pembayaran_billing.id_billing')
                            ->join('months', 'months.month_name', 'not like', DB::raw("monthname(billing.tanggal_pembuatan_billing)"))
                            ->where(DB::raw("year(billing.tanggal_pembuatan_billing)"), $input['tahun'])
                            ->where(DB::raw("properti.status_properti"), "Active")
                            ->where(DB::raw("properti.id_properti"), $input['id_properti'])
                            ->whereNotIn(DB::raw("months.month_name"),
                                    [DB::raw("select months.month_name from billing join months on months.month_name like monthname(billing.tanggal_pembuatan_billing)"
                                    )]
                                )
                            ->distinct()
                        )
                    ->orderBy('id_month')
                    ->get();
        
        $data = [
                    'billings' => $details, 
                    'nomor_kavling' => $property->nomor_kavling, 
                    'period' => $input['tahun']
                ];
                
        //Convert PDF
        $pdf = PDF::loadView('payment_report', $data);
        
        $pdfName = 'Payment-Report-'.$property->nomor_kavling.'-'.$input['tahun'].'.pdf';
        
        if(!Storage::disk('public_uploads')->put('public/pdf/'.$pdfName, $pdf->output()))
        {
            return false;
        }
        
        $file = 'https://mykl.klbizhubbilling.xyz/uploads/public/pdf/'.$pdfName;
        
        $passingData = [
            'file_name' => $pdfName,
            'file_link' => $file,
        ];
                    
        if(count($details) > 0)
        {
            return response([
                'message' => 'Report Successfully Printed',
                'data' => $passingData,
            ],200);
        }
        
        return response([
            'message' => 'Cannot Print The Report',
            'data' => null,
        ],404);
    }
}