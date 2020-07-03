<?php

namespace App\Console\Commands;

use App\Models\Rate;
use Illuminate\Console\Command;

class TestCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get rate';

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
        $rates = Rate::all();
        if($rates->count()){
            foreach ($rates as $rate){
                $rate->delete();
            }
        }

        $file_get = json_decode(file_get_contents('https://www.inecobank.am/api/rates/'))->items;

        if(!empty($file_get)){
            foreach($file_get as $key => $rt){
                if(empty($rt->cash->buy) || $rt->cash->buy == '0.00'){
                    continue;
                }
                $ratBlock[$key]['currency'] = $rt->code;
                $ratBlock[$key]['buy'] = $rt->cash->buy;
                $ratBlock[$key]['sell'] = $rt->cash->sell;
                Rate::create($ratBlock[$key]);
            }
        }

    }
}
