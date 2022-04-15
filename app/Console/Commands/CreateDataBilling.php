<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Billing;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CreateDataBilling extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:billing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Billing list in Billing database automatically';

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
        $properties = DB::table('properti')
            ->join('history_kepemilikan', 'history_kepemilikan.id_properti', '=', 'properti.id_properti')
            ->join('pemilik', 'pemilik.id_pemilik', '=', 'history_kepemilikan.id_pemilik')
            ->leftjoin('history_penyewaan', 'history_penyewaan.id_properti', '=', 'properti.id_properti')
            ->leftjoin('penyewa', 'penyewa.id_penyewa', '=', 'history_penyewaan.id_penyewa')
            ->select('properti.*', 'pemilik.*', 'penyewa.*')
            ->orderBy('nomor_kavling','asc')->get();
        
        for($count = 0; $count < count($properties); $count++)
        {
            if($properties[$count]->status_properti == 'Active')
            {
                $storeData = [
                    'id_properti' => $properties[$count]->id_properti,
                    'tanggal_pembuatan_billing' => Carbon::now(),
                    'nomor_billing' => "KLBIZ-"."".Carbon::now()->format('m')."".Carbon::now()->format('y')."-".$properties[$count]->nomor_kavling,
                    'biaya_kotor' =>  $properties[$count]->luas_bangunan * 2500,
                    'total_pajak' => $properties[$count]->luas_bangunan * 2500 * 0.1,
                    'total_biaya' => ($properties[$count]->luas_bangunan * 2500) + ($properties[$count]->luas_bangunan * 2500 * 0.1) + ($properties[$count]->jumlah_denda * 5000),
                    'status_billing' => 'Unpaid',
                ];

                $billing = Billing::create($storeData);

                if($billing)
                {
                    echo "Billing"." ".$properties[$count]->nomor_kavling." "."Successfully Created\n";
                }
            }
        }
        
        return 0;
    }
}
