<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\ProductCategory;


class ProductCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            $path = database_path('files'.DIRECTORY_SEPARATOR.'category.sql');
            DB::unprepared(file_get_contents($path));
    }
}
