<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('users')->insert([
            'name'     => "loitq",
            'email'    => "loitq@lifull-tech.vn",
            'role'     => 1,
            'password' => Hash::make("lifull@123"),
        ]);

        DB::table('users')->insert([
            'name'     => "user",
            'email'    => "user@lifull-tech.vn",
            'password' => Hash::make("lifull@123"),
        ]);
    }
}
