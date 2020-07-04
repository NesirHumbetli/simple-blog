<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'name' => 'Nesir Humbetli',
            'email' => 'Nesir.Humbetli@gmail.com',
            'password' => bcrypt(102030),
        ]);
    }
}
