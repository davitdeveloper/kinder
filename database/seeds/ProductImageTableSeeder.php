<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductImageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = database_path('files'.DIRECTORY_SEPARATOR.'product_images.sql');
        DB::unprepared(file_get_contents($path));
    }
}
