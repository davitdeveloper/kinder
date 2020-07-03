<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

         $this->call(RoleTableSeeder::class);
         $this->call(ColorTableSeeder::class);
        $this->call(CitiesTableSeeder::class);
         $this->call(UserTableSeeder::class);
         $this->call(DistributorTableSeeder::class);
         $this->call(ArticleCategoryTableSeeder::class);
         $this->call(ProductCategoryTableSeeder::class);
         $this->call(ManufacturerTableSeeder::class);
         $this->call(SizeTableSeeder::class);
//         $this->call(ManufacturerShoeSizeTableSeeder::class);
//         $this->call(ManufacturerTopSizeTableSeeder::class);
//         $this->call(ManufacturerPantSizeTableSeeder::class);
//         $this->call(ManufacturerAccessorySizeTableSeeder::class);
         $this->call(ProductModelTableSeeder::class);
         $this->call(ProductTableSeeder::class);
         $this->call(ProductImageTableSeeder::class);
         $this->call(DiscountTableSeeder::class);
         $this->call(SkillTableSeeder::class);
         $this->call(BadHabitTableSeeder::class);
         $this->call(ChildrenAgeTableSeeder::class);
         $this->call(ChildrenAmountTableSeeder::class);
         $this->call(OwnLanguageTableSeeder::class);
         $this->call(WorkTypeTableSeeder::class);
         $this->call(HomeSliderTableSeeder::class);
    }
}
