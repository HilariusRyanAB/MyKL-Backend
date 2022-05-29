<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\EntryToken;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;

class SendNotification1 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:sendNotification1';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Notification1 automatically';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $date = Carbon::now()->format('d');
        $month = Carbon::now()->format('F');
        $year = Carbon::now()->format('Y');

        if($date >= 20 && $date < 25)
        {
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
                        ->where('billing.status_billing', '=', 'Unpaid')
                        ->where('history_kepemilikan.id_user', '=', $users[$count]->id_user)
                        ->orderBy('properti.nomor_kavling','asc')
                        ->first();

                    if(!is_null($unpaidBilling))
                    {
                        $message = CloudMessage::withTarget('token', $users[$count]->fcm_token);

                        $message = CloudMessage::fromArray([
                            'token' => $users[$count]->fcm_token,
                            'notification' => [
                                'title' => 'Payment Alert',
                                'body' => 'Please Pay Your Bill as Soon as Possible before Due Date'
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
                        ->where('billing.status_billing', '=', 'Unpaid')
                        ->where('history_penyewaan.id_user', '=', $users[$count]->id_user)
                        ->orderBy('properti.nomor_kavling','asc')
                        ->first();

                    if(!is_null($unpaidBilling))
                    {
                        $message = CloudMessage::withTarget('token', $users[$count]->fcm_token);

                        $message = CloudMessage::fromArray([
                            'token' => $users[$count]->fcm_token,
                            'notification' => [
                                'title' => 'Payment Alert',
                                'body' => 'Please Pay Your Bill as Soon as Possible before Due Date'
                            ]
                        ]);

                        $messaging->send($message);

                        echo "Notification To ".$users[$count]->nama_user." Has Been Sended\n";
                    }
                }
            }
        }
        
        return 0;
    }
}