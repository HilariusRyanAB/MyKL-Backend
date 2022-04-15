<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Billing;
use App\Properti;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EditStatusBilling extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:billing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Billing status in Billing database automatically';

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
            if($billings[$count]->status_billing == 'Unpaid')
            {
                $billing = Billing::find($billings[$count]->id_billing);

                $property = Properti::find($billings[$count]->id_properti);

                $updateDataProperty = [
                    'jumlah_denda' => $property->jumlah_denda + 1,
                ];

                $updateDataBilling = [
                    'status_billing' => 'Expired',
                ];

                $property->jumlah_denda = $updateDataProperty['jumlah_denda'];

                $billing->status_billing = $updateDataBilling['status_billing'];

                $property->save();
                
                $billing->save();

                echo "Billing ".$billing->nomor_billing." Successfully Updated\n";
            }
        }

        return 0;
    }
}
