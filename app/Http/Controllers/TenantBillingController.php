<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use Mail;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Exception\RequestException;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class TenantBillingController extends Controller
{
    public function generatePDF()
    {
        $billings = DB::table('billing')->select('billing.*', 'properti.*', 'penyewa.*')->join('properti', 'billing.id_properti', '=', 'properti.id_properti')
        ->join('penyewa', 'penyewa.id_penyewa', '=', 'properti.id_penyewa')->get();
        
        for($count = 0; $count < count($billings); $count++)
        {
            $billing = $billings[$count];
            $data = ['billing' => $billing];
            
            //PDF
            $pdf = PDF::loadView('billing_tenant', $data);
    
            $pdfName = 'Billing-'.$billing->nomor_billing.'-T.pdf';
      
            if(!Storage::disk('public_uploads')->put('public/pdf/'.$pdfName, $pdf->output()))
            {
                return false;
            }
            
            //Whatsapp
            $twilio_whatsapp_number = getenv('TWILIO_WHATSAPP_NUMBER');
            $account_sid = getenv("TWILIO_SID");
            $auth_token = getenv("TWILIO_AUTH_TOKEN");
    
            $recipient = "whatsapp:+6285608024077";
    
            $client = new Client($account_sid, $auth_token);
    
            $file = 'http://backend.klbizhubbilling.xyz/uploads/public/pdf/'.$pdfName;
    
            $client->messages->create($recipient, array('from' => "whatsapp:$twilio_whatsapp_number", 'body' => 'Billing untuk Nomor Kavling '.$billing->nomor_kavling.' Periode '.Carbon::now()->translatedFormat('F').' '.Carbon::now()->translatedFormat('Y').' Mohon Diperhatikan, Terima Kasih.'));
            
            $client->messages->create($recipient, array('from' => "whatsapp:$twilio_whatsapp_number", 'MediaUrl' => $file));
            
            //Email
            $dataEmail["email"] = "benedecash@gmail.com";
            $dataEmail["title"] = "Billing Properti KL BIZ HUB";
            $dataEmail["body"] = 'Billing untuk Nomor Kavling '.$billing->nomor_kavling.' Periode '.Carbon::now()->translatedFormat('F').' '.Carbon::now()->translatedFormat('Y').' Mohon Diperhatikan, Terima Kasih.';
            
            $dataEmail["pdfTitle"] = $pdfName;
      
            Mail::send('email_view', $dataEmail, function($message)use($dataEmail, $pdf) {
                $message->to($dataEmail["email"], $dataEmail["email"])
                        ->subject($dataEmail["title"])
                        ->attachData($pdf->output(), $dataEmail["pdfTitle"]);
            });
            
            echo "Billing ".$billing->nomor_billing." Successfully Sended\n";
        }
    }
}
