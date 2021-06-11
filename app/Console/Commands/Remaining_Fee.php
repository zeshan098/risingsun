<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class Remaining_Fee extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remaining_fee:fee';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Transfer monthly remaining fees to table';

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
     * @return mixed
     */
    public function handle()
    {
        \Log::info("Cron is working fine!");
     
        /*
           Write your database logic we bellow:
           Item::create(['name'=>'hello new']);
        */
        $alert_val = DB::select(" SELECT * FROM donations WHERE TO_DAYS(to_date)=To_DAYS(NOW())+3 " );
      
        $this->info('Demo:Cron Cummand Run successfully!');
        
    }
}
