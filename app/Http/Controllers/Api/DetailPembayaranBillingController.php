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
use Midtrans\Config;

class DetailPembayaranBillingController extends Controller
{
    private $id_merchant;

    public function __construct()
    {
        Config::$isProduction = env("PRODUCTION");
        Config::$serverKey = env("MIDTRANS_SERVER_KEY");
        $id_merchant = env("MIDTRANS_MERCHANT_ID");
        Config::$isSanitized = false;
        Config::$is3ds = false;
    }

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

    public function addMobile(Request $request): \Illuminate\Http\JsonResponse
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData,
        [
            'id_user' => 'required',
            'id_billing' => 'required|numeric', 
            'tanggal_pembayaran' => 'required',
            'metode_pembayaran' => 'required',
            'total_bayar' => '',
            'status_detail_pembayaran' => '',
        ]);
        error_log("1");

        if($validate->fails())
        {
            return response(['message' => $validate->errors()], 400);
        }
        error_log("2");

        $user = User::find($storeData['id_user']);
        $billing = Billing::find($storeData['id_billing']);
        $property = Properti::find($billing->id_properti);
        $storeData['total_bayar'] = $billing->total_biaya;
        $storeData['status_detail_pembayaran'] = "Pending";
        error_log("3");
        $generatedData = $this->generatingData($billing, $user, $property, $storeData['metode_pembayaran']);

        try 
        {
            error_log("4");
            $charge = \Midtrans\CoreApi::charge($generatedData);
            error_log("5");
            $charge->va_numbers = [
                [
                    'bank' => $storeData['metode_pembayaran'],
                    'va_number' => $charge->biller_code.$charge->bill_key
                ]
            ];
            error_log("6");

            // $billing->status_billing = "Paid";
            // $billing->save();
            
            // $property->jumlah_denda = 0;
            // $property->save();
            
            // $internetAccesses = DB::table('internet_access')
            //                 ->select('internet_access.*')
            //                 ->where('id_properti', '=', $billing->id_properti)
            //                 ->first();
            // $internetAccess = InternetAccess::find($internetAccesses->id_internet_access);
            // $internetAccess->status_internet_access = "Active";
            // $internetAccess->save();

            // $cctvAccesses = DB::table('cctv_access')
            //                 ->select('cctv_access.*')
            //                 ->where('id_properti', '=', $billing->id_properti)
            //                 ->first();
            // $cctvAccess = CCTVAccess::find($cctvAccesses->id_cctv_access);
            // $cctvAccess->status_cctv_access = "Active";
            // $cctvAccess->save();
            
            // $waterFacilities = DB::table('water_facility')
            //                 ->select('water_facility.*')
            //                 ->where('id_properti', '=', $billing->id_properti)
            //                 ->first();
            // $waterFacility = WaterFacility::find($waterFacilities->id_water_facility);
            // $waterFacility->status_water_facility = "Active";
            // $waterFacility->save();
            
            // $detailPembayaranBilling = DetailPembayaranBilling::create($storeData);

            return response()->json([
                'message' => 'Detail Billing Payment Added Successfully',
                'data' => $charge,
            ]);
            error_log("7");
        } 
        catch (\Exception $e) 
        {
            error_log("8");
            return response()->json([
                'message' => 'Detail Billing Payment Cannot be Added',
                'data' => $e,
            ], 500);
        }
    }

    public function generatingData($billing, $user, $property, $bank)
    {
        $item = array(
            'id' => $billing->id_properti,
            'price' => $billing->total_biaya,
            'quantity' => 1,
            'name' => 'Billing Property '.$property->nomor_kavling,
        );
        error_log("9");

        $full_name = explode(" ", $user->nama_user);
        $firstname = $full_name[0];
        $lastname = (count($full_name) < 2) ? " " : $full_name[1];
        $customerData = array(
            'first_name' => $firstname,
            "last_name" => $lastname,
            "email" => $user->email_user,
            "phone" => $user->nomor_telepon_user,
        );
        error_log("10");

        $transaction = array(
            'transaction_details' => array(
                'order_id'       => $billing->nomor_billing,
                'gross_amount'   => $billing->total_biaya,
            ),
            'item_details' => $item,
            'customer_details' => $customerData,
        );
        error_log("11");

        $transaction['payment_type'] = "bank_transfer";
        $transaction['bank_transfer'] = array(
            "bank" => $bank,
            "va_number" => "1234567891"
        );
        error_log("12");

        return $transaction;
    }
}