<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // DB::table('users')->insert([
        //     'name'     => "loitq",
        //     'email'    => "loitq@lifull-tech.vn",
        //     'role'     => \App\User::ADMIN,
        //     'password' => Hash::make("lifull@123"),
        // ]);

        // DB::table('users')->insert([
        //     'name'     => "user",
        //     'email'    => "user@lifull-tech.vn",
        //     'role'     => \App\User::USER,
        //     'password' => Hash::make("lifull@123"),
        // ]);

        factory(App\User::class, 2)->create();
    }
}
