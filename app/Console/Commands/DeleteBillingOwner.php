<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DeleteBillingOwner extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:billingO';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to Delete Billing for Owner';

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
        $billings = DB::table('billing')->select('billing.*', 'properti.*', 'pemilik.*')
                    ->join('properti', 'billing.id_properti', '=', 'properti.id_properti')
                    ->join('pemilik', 'pemilik.id_pemilik', '=', 'properti.id_pemilik')->get();
        
        for($count = 0; $count < count($billings); $count++)
        {
            $billing = $billings[$count];

            $pdfName = 'Billing-'.$billing->nomor_billing.'-O.pdf';
            
            Storage::disk('public_uploads')->delete('public/pdf/'.$pdfName);

            echo $pdfName." Successfully Deleted\n";
        }

        return 0;
    }
}
