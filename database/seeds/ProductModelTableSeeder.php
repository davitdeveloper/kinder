<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductModelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = database_path('files'.DIRECTORY_SEPARATOR.'product_models.sql');
        DB::unprepared(file_get_contents($path));
    }
}
