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
    protected $signature = 'Remaining_Fee:fee';

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
        // $student_remaining_fee = \DB::select("INSERT INTO remaining_bus_fees (arrears, student_detail_id, date)
            
        //   SELECT Case when rbf.arrears is NUll then sbf.remarks else sbf.remarks + rbf.arrears end as plus, sbf.student_detail_id,  sbf.pay_day FROM student_bus_fares sbf
        //     left join remaining_bus_fees rbf on sbf.student_detail_id = rbf.student_detail_id
        //     WHERE YEAR(sbf.pay_day) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH)
        //     AND MONTH(sbf.pay_day) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)
        //     and sbf.remarks is not Null");

        // $this->info('The  messages were sent successfully!');
        
    }
}
