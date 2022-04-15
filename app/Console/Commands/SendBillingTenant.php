<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PDF;
use Mail;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Storage;

class SendBillingTenant extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:billingT';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to Send Billing for Tenant';

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
        $billings = DB::table('billing')->select('billing.*', 'properti.*', 'penyewa.*')
                    ->join('properti', 'billing.id_properti', '=', 'properti.id_properti')
                    ->join('penyewa', 'penyewa.id_penyewa', '=', 'properti.id_penyewa')->get();
        
        for($count = 0; $count < count($billings); $count++)
        {
            //Get Data Billing
            $billing = $billings[$count];

            $data = ['billing' => $billing];
            
            //Convert PDF
            $pdf = PDF::loadView('billing_tenant', $data);

            $pdfName = 'Billing-'.$billing->nomor_billing.'-T.pdf';

            if(!Storage::disk('public_uploads')->put('public/pdf/'.$pdfName, $pdf->output()))
            {
                return false;
            }
            
            $getBilling = Billing::find($billing->id_billing);

            if(strlen($billing->nomor_telepon_penyewa) < 11)
            {
                //Update Status Kirim Gagal
                $updateDataBilling = [
                    'status_pengiriman' => 'Failed',
                ];

                echo $pdfName." Failed to Sended\n";
            }

            else
            {
                //Update Status Kirim Berhasil
                $updateDataBilling = [
                    'status_pengiriman' => 'Success',
                ];

                //Connect Whatsapp
                $twilio_whatsapp_number = getenv('TWILIO_WHATSAPP_NUMBER');
                $account_sid = getenv("TWILIO_SID");
                $auth_token = getenv("TWILIO_AUTH_TOKEN");
        
                $recipient = "whatsapp:+62".substr($billing->nomor_telepon_penyewa, 1);
        
                $client = new Client($account_sid, $auth_token);
        
                $file = 'http://backend.klbizhubbilling.xyz/uploads/public/pdf/'.$pdfName;
        
                $client->messages->create($recipient, array('from' => "whatsapp:$twilio_whatsapp_number", 
                'body' => 'Billing untuk Nomor Kavling '.$billing->nomor_kavling.' Periode '.Carbon::now()->translatedFormat('F').' '.Carbon::now()->translatedFormat('Y').' Mohon Diperhatikan, Terima Kasih.'));
                
                $client->messages->create($recipient, array('from' => "whatsapp:$twilio_whatsapp_number", 'MediaUrl' => $file));

                //Email
                $dataEmail["email"] = $billing->email_penyewa;
                $dataEmail["title"] = "Billing Properti KL BIZ HUB";
                $dataEmail["body"] = 'Billing untuk Nomor Kavling '.$billing->nomor_kavling.' Periode '.Carbon::now()->translatedFormat('F').' '.Carbon::now()->translatedFormat('Y').' Mohon Diperhatikan, Terima Kasih.';
                
                $dataEmail["pdfTitle"] = $pdfName;
        
                Mail::send('email_view', $dataEmail, function($message)use($dataEmail, $pdf) {
                    $message->to($dataEmail["email"], $dataEmail["email"])
                            ->subject($dataEmail["title"])
                            ->attachData($pdf->output(), $dataEmail["pdfTitle"]);
                });

                echo $pdfName." Successfully Sended\n";
            }
            
            if($getBilling->status_pengiriman != 'Sucess')
            {
                $getBilling->status_pengiriman = $updateDataBilling['status_pengiriman'];
                $getBilling->save();
            }
        }

        return 0;
    }
}