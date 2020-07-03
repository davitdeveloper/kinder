<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChildrenAgeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('children_ages')->insert([
            ['description' => 'մինչև 1'],
            ['description' => '1-2տ'],
            ['description' => '3-5տ'],
            ['description' => '5-10տ'],
            ['description' => '10տ և ավելի'],
        ]);
    }
}
