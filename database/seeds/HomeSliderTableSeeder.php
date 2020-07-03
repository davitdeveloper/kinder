<?php

use Illuminate\Database\Seeder;

class HomeSliderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = database_path('files'.DIRECTORY_SEPARATOR.'home_sliders.sql');
        DB::unprepared(file_get_contents($path));
    }
}
