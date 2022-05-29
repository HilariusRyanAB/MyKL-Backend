<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\EntryToken;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CreateEntryToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:entryToken';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Entry Token database automatically';

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
        $users = DB::table('user')->select('user.*')->get();
        
        for($count = 0; $count < count($users); $count++)
        {
            if($users[$count]->status_user == 'Active')
            {
                $storeData = [
                    'id_user' => $users[$count]->id_user,
                    'tanggal_pembuatan_token' => Carbon::now(),
                    'entry_code' =>  Str::random(64),
                    'status_token' => 'Active',
                ];

                $entryToken = EntryToken::create($storeData);

                if($entryToken)
                {
                    echo "Entry Token"." ".$users[$count]->id_user." "."Successfully Created\n";
                }
            }
        }
        
        return 0;
    }
}
