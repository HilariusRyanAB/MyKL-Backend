<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DeleteReportFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to Delete Report';

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
        $billings = DB::table('billing')->select('billing.*')->get();
        
        for($count = 0; $count < count($billings); $count++)
        {
            $billing = $billings[$count];
            
            $billingYear = DB::table('billing')->select(DB::raw("year(tanggal_pembuatan_billing) as tanggal_pembuatan_billing"))->where('id_billing', $billing->id_billing)->first();
            
            $property= DB::table('properti')->select('properti.*')->where('properti.id_properti', $billing->id_properti)->first();

            $pdfName = 'Payment-Report-'.$property->nomor_kavling.'-'.$billingYear->tanggal_pembuatan_billing.'.pdf';

            Storage::disk('public_uploads')->delete('public/pdf/'.$pdfName);

            echo $pdfName." Successfully Deleted\n";
        }

        return 0;
    }
}