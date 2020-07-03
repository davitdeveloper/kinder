<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WorkTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('work_types')->insert([
            ['description' => 'Բնակությամբ'],
            ['description' => 'Ամբողջական զբաղվածությամբ'],
            ['description' => 'Ժամային'],
            ['description' => 'Պայմանագրային (մինչև x ամիս)'],
        ]);
    }
}
