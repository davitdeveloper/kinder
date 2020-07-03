<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SkillTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('skills')->insert([
            ['description' => 'Կերակուր պատրաստել'],
            ['description' => 'Դասապատրաստել'],
            ['description' => 'Տան մաքրությանը հետևել'],
            ['description' => 'Մանկական տոներ կազմակերպել'],
            ['description' => 'Աշխատել հաշմանդամ երեխայի հետ'],
            ['description' => 'Տանել երեխային մանկապարտեզ/դպրոց'],
            ['description' => 'Ճանապարհորդել ընտանիքի հետ'],
            ['description' => 'Վարորդական իրավունքի առկայություն'],
            ['description' => 'Երեխային լողացնել'],
            ['description' => 'Երեխայի շորերը լվանալ'],
        ]);
    }
}
