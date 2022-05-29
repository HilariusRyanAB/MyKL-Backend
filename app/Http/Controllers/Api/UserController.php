<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;

class UserController extends Controller
{
    //Mobile App
    public function searchMobile($id)
    {
        $User = User::find($id);

        if(!is_null($User))
        {
            return response
            (
                [
                    'message' => 'User Has Been Retrieved',
                    'data' => $User
                ], 200); 
        }

        return response
        (
            [
                'message' => 'User Cannot Be Retrieved',
                'data' => null
            ], 404);
    }

    public function editMobile(Request $request, $id)
    {
        $User = User::find($id);

        if(is_null($User))
        {
            return response([
                'message' => 'User Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData,
        [
            'nama_user' => 'required|string',
            'alamat_user' => 'required|string',
            'nomor_telepon_user' => '',
            'password' => 'required',
        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()], 400);
        }

        if($updateData['nomor_telepon_user'] != null)
        {
            $validate = Validator::make($updateData,
            [
                'nomor_telepon_user' => 'required|string|unique:user,nomor_telepon_user,'.$id.',id_user',
            ]);

            if($validate->fails())
            {
                return response(['message' => $validate->errors()], 400);
            }
        }
        
        $User->nama_user = $updateData['nama_user'];
        $User->alamat_user = $updateData['alamat_user'];
        $User->nomor_telepon_user = $updateData['nomor_telepon_user'];
        $User->password = bcrypt($updateData['password']);

        if($User->save())
        {
            return response(
                [
                    'message' => 'User Has Been Updated',
                    'data' => $User,
                ], 200);
        }

        return response(
            [
                'message' => 'User Cannot Be Updated',
                'data' => null,
            ], 400);
    }
    
    public function sendNotif()
    {
        $date = Carbon::now()->format('d');
        $month = Carbon::now()->format('F');
        $year = Carbon::now()->format('Y');
        
        $factory = (new Factory)->withServiceAccount('/home/klbizhu1/mykl.klbizhubbilling.xyz/myklnotification-firebase-adminsdk-px628-1c7b4430dd.json');

        $messaging = $factory->createMessaging();

        $users = DB::table('user')->select('user.*')->get();
        
        for($count = 0; $count < count($users); $count++)
        {
            if($users[$count]->status_user == 'Active' && $users[$count]->role_user == 'Owner' && $users[$count]->fcm_token != null)
            {                
                $unpaidBilling = DB::table('properti')
                    ->join('history_kepemilikan', 'history_kepemilikan.id_properti', '=', 'properti.id_properti')
                    ->join('billing', 'billing.id_properti', '=', 'properti.id_properti')
                    ->select('properti.*', 'history_kepemilikan.*', 'billing.*')
                    ->where('history_kepemilikan.status_kepemilikan', '=', 'Active')
                    ->where(DB::raw("monthname(billing.tanggal_pembuatan_billing)"), '=', $month)
                    ->where(DB::raw("year(billing.tanggal_pembuatan_billing)"), '=', $year)
                    ->where('properti.status_properti', '=', 'Active')
                    ->where('billing.status_billing', '=', 'Expired')
                    ->where('history_kepemilikan.id_user', '=', $users[$count]->id_user)
                    ->orderBy('properti.nomor_kavling','asc')
                    ->first();

                if(!is_null($unpaidBilling))
                {
                    $message = CloudMessage::withTarget('token', $users[$count]->fcm_token);

                    $message = CloudMessage::fromArray([
                        'token' => $users[$count]->fcm_token,
                        'notification' => [
                            'title' => 'Bill is Expired',
                            'body' => 'Please Pay Your Bill Now Because All Your Facility Are Lock Until You Pay the Bill'
                        ]
                    ]);

                    $messaging->send($message);

                    echo "Notification To ".$users[$count]->nama_user." Has Been Sended\n";
                }
            }

            else if($users[$count]->status_user == 'Active' && $users[$count]->role_user == 'Tenant' && $users[$count]->fcm_token != null)
            {                
                $unpaidBilling = DB::table('properti')
                    ->join('history_penyewaan', 'history_penyewaan.id_properti', '=', 'properti.id_properti')
                    ->join('billing', 'billing.id_properti', '=', 'properti.id_properti')
                    ->select('properti.*', 'history_penyewaan.*', 'billing.*')
                    ->where('history_penyewaan.status_penyewaan', '=', 'Active')
                    ->where(DB::raw("monthname(billing.tanggal_pembuatan_billing)"), '=', $month)
                    ->where(DB::raw("year(billing.tanggal_pembuatan_billing)"), '=', $year)
                    ->where('properti.status_properti', '=', 'Active')
                    ->where('billing.status_billing', '=', 'Expired')
                    ->where('history_penyewaan.id_user', '=', $users[$count]->id_user)
                    ->orderBy('properti.nomor_kavling','asc')
                    ->first();

                if(!is_null($unpaidBilling))
                {
                    $message = CloudMessage::withTarget('token', $users[$count]->fcm_token);

                    $message = CloudMessage::fromArray([
                        'token' => $users[$count]->fcm_token,
                        'notification' => [
                            'title' => 'Bill is Expired',
                            'body' => 'Please Pay Your Bill Now Because All Your Facility Are Lock Until You Pay the Bill'
                        ]
                    ]);

                    $messaging->send($message);

                    echo "Notification To ".$users[$count]->nama_user." Has Been Sended\n";
                }
            }
        }   
    }
}