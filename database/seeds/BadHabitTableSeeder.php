<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BadHabitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('bad_habits')->insert([
            ['description' => 'Ծխել'],
            ['description' => 'Խմել'],
            ['description' => 'Տրամադրության հաճախակի փոփոխություններ']
        ]);
    }
}
