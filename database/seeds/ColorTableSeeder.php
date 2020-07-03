<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('colors')->insert([
            [
                'name' => 'blue',
                'value' => '#4a0ffa',
                'tint' => 'dark',
            ],
            [
                'name' => 'pink',
                'value' => '#ff63cb',
                'tint' => 'dark',
            ],
            [
                'name' => 'white',
                'value' => '#ffffff',
                'tint' => 'dark',
            ],
            [
                'name' => 'red',
                'value' => '#ff0000',
                'tint' => 'dark',
            ],
            [
                'name' => 'No color',
                'value' => null,
                'tint' => null,
            ],
            [
                'name' => 'Green',
                'value' => '#38c109',
                'tint' => 'dark',
            ],
        ]);
    }
}
