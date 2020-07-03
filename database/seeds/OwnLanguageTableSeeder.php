<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OwnLanguageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('own_languages')->insert([
            ['description' => 'Հայերեն'],
            ['description' => 'Ռուսերեն'],
            ['description' => 'Անգլերեն']
        ]);
    }
}
