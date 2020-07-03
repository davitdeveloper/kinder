<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistributorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('distributors')->insert([
            [
                'user_id' => 1,
                'company' => 'Kinder.am',
                'director' => 'Griqor Semirjyan',
                'description' => 'Մեր ֆիռման',
                'tax_code' => 'af88s5g',
                'bank_name' => 'Ineco',
                'iban' => '54645646464',
                'logo' => '/storage/distributor/natali.jpg',
                'address' => 'Kievyan 9',
                'phone' => '98653665',
                'website' => 'Kinder.am',
            ],
            [
                'user_id' => 3,
                'company' => 'Շորեր ՍՊԸ',
                'director' => 'Գագիկ Խաչիկյան',
                'description' => 'Ֆիռմային շորերի պաշտոնական ներկայացուցիչ',
                'tax_code' => 'af88s5g',
                'bank_name' => 'Ineco',
                'iban' => '54645646464',
                'logo' => '/storage/distributor/natali.jpg',
                'address' => 'Kievyan 9',
                'phone' => '98653665',
                'website' => 'shorer.am',
            ],
            [
                'user_id' => 4,
                'company' => 'Նատալի Ֆառմ',
                'director' => 'Սամվել Դալաքյան',
                'description' => 'Դեղորայքի պաշտոնական ներկայացուցիչ և արտադրող',
                'tax_code' => 'jngs55fg',
                'bank_name' => 'AmeriaBank',
                'iban' => '46545645645',
                'logo' => '/storage/distributor/shorer.jpg',
                'address' => 'Sebastia 64',
                'phone' => '77787576',
                'website' => 'natali.am',
            ]
        ]);
    }
}
