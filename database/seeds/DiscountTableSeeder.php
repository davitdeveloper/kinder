<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiscountTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path1 = database_path('files'.DIRECTORY_SEPARATOR.'model_discounts.sql');
        DB::unprepared(file_get_contents($path1));

        $path2 = database_path('files\product_discounts.sql');
        DB::unprepared(file_get_contents($path2));

    }
}
