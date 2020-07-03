<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'role_id' => 3,
                'name' => 'Griqor',
                'email' => 'griqor@mail.ru',
                'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm'
            ],
            [
                'role_id' => 1,
                'name' => 'Vzgo',
                'email' => 'vzgo@mail.ru',
                'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm'
            ],
            [
                'role_id' => 1,
                'name' => 'Beno',
                'email' => 'beno@mail.ru',
                'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm'
            ],
            [
                'role_id' => 3,
                'name' => 'Gago',
                'email' => 'gago@mail.ru',
                'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm'
            ],
            [
                'role_id' => 3,
                'name' => 'Suro',
                'email' => 'suro@mail.ru',
                'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm'
            ],
            [
                'role_id' => 4,
                'name' => 'Vaspur',
                'email' => 'vaspur@mail.ru',
                'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm'
            ],
        ]);
    }
}
