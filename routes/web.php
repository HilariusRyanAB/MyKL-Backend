<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () 
{
    return view('welcome');
});

Route::get('/paymentReport', function () 
{
    return view('payment_report', [
        "billings" => DB::table('billing')
                    ->select('months.id_month', 'months.month_name', "billing.total_biaya as total_biaya", "detail_pembayaran_billing.metode_pembayaran as metode_pembayaran", "billing.status_billing as status_pembayaran")
                    ->join('properti', 'billing.id_properti', '=', 'properti.id_properti')
                    ->leftjoin('detail_pembayaran_billing', 'billing.id_billing', '=', 'detail_pembayaran_billing.id_billing')
                    ->join('months', 'months.month_name', 'like', DB::raw("monthname(billing.tanggal_pembuatan_billing)"))
                    ->where(DB::raw("year(billing.tanggal_pembuatan_billing)"), 2022)
                    ->where(DB::raw("properti.status_properti"), "Active")
                    ->where(DB::raw("properti.id_properti"), 4)
                    ->union(
                        DB::table('billing')
                            ->select(DB::raw("months.id_month, months.month_name, NULL as total_biaya, NULL as metode_pembayaran, NULL as status_pembayaran"))
                            ->join('properti', 'billing.id_properti', '=', 'properti.id_properti')
                            ->join('detail_pembayaran_billing', 'billing.id_billing', '=', 'detail_pembayaran_billing.id_billing')
                            ->join('months', 'months.month_name', 'not like', DB::raw("monthname(billing.tanggal_pembuatan_billing)"))
                            ->where(DB::raw("year(billing.tanggal_pembuatan_billing)"), 2022)
                            ->where(DB::raw("properti.status_properti"), "Active")
                            ->where(DB::raw("properti.id_properti"), 4)
                            ->whereNotIn(DB::raw("months.month_name"),
                                    [DB::raw("select months.month_name from billing join months on months.month_name like monthname(billing.tanggal_pembuatan_billing)"
                                    )]
                                )
                            ->distinct()
                        )
                    ->orderBy('id_month')
                    ->get(),
        "nomor_kavling" => "B1-01",
        "period" => '2022',
    ]);
});