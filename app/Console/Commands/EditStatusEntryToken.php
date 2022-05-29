<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\EntryToken;
use App\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EditStatusEntryToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:entryToken';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Entry Token status in Entry Token database automatically';

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
        $entryTokens = DB::table('entry_token')->select('entry_token.*')->get();

        for($count = 0; $count < count($entryTokens); $count++)
        {
            if($entryTokens[$count]->status_token == 'Active')
            {
                $entryToken = EntryToken::find($entryTokens[$count]->id_entry_token);

                $updateDataEntryToken = [
                    'status_token' => 'Inactive',
                ];

                $entryToken->status_token = $updateDataEntryToken['status_token'];
                
                $entryToken->save();

                echo "Entry Token ".$entryToken->id_entry_token." Successfully Updated\n";
            }
        }

        return 0;
    }
}
