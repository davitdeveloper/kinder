<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChildrenAmountTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('children_amounts')->insert([
            ['description' => '1'],
            ['description' => '2'],
            ['description' => '3'],
            ['description' => '4 և ավելի'],
        ]);
    }
}
