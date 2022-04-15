<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DeleteBillingTenant extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:billingT';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to Delete Billing for Tenant';

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
            $billing = $billings[$count];

            $pdfName = 'Billing-'.$billing->nomor_billing.'-T.pdf';

            Storage::disk('public_uploads')->delete('public/pdf/'.$pdfName);

            echo $pdfName." Successfully Deleted\n";
        }

        return 0;
    }
}