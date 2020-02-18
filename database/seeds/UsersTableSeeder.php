<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    const USER_RECORD_NUMBER = 2;
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('users')->insert([
            'name'     => "loitq",
            'email'    => "loitq@lifull-tech.vn",
            'role'     => \App\User::ADMIN,
            'password' => Hash::make("lifull@123"),
            'can_see' => \APP\User::IS_TRUE,
        ]);

        DB::table('users')->insert([
            'name'     => "user",
            'email'    => "user@lifull-tech.vn",
            'role'     => \App\User::USER,
            'password' => Hash::make("lifull@123"),
            'can_see' => \APP\User::IS_TRUE,
        ]);

        factory(App\User::class, USER_RECORD_NUMBER)->create();
    }
}
