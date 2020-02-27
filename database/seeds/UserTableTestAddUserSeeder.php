<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;

define('_PASSWORD_DEFAULT', 'lifull@123');

class UserTableTestAddUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         //user can see blog
         DB::table('users')->insert([
            'name'     => "user_can_see",
            'email'    => "user_can_see@lifull-tech.vn",
            'role'     => User::USER,
            'password' => Hash::make(_PASSWORD_DEFAULT),
            'can_see' => User::IS_TRUE,
        ]);

        //user can see and delete blog
        DB::table('users')->insert([
            'name'     => "user_can_see_delete",
            'email'    => "user_can_see_delete@lifull-tech.vn",
            'role'     => User::USER,
            'password' => Hash::make(_PASSWORD_DEFAULT),
            'can_see' => User::IS_TRUE,
            'can_delete' => User::IS_TRUE
        ]);

        //user can not see blog
        DB::table('users')->insert([
            'name'     => "user_can_not_see",
            'email'    => "user_can_not_see@lifull-tech.vn",
            'role'     => User::USER,
            'password' => Hash::make(_PASSWORD_DEFAULT),
            'can_see' => User::IS_FALSE
        ]);
        
        //user can see but can not delete blog
        DB::table('users')->insert([
            'name'     => "user_can_not_delete",
            'email'    => "user_can_not_delete@lifull-tech.vn",
            'role'     => User::USER,
            'password' => Hash::make(_PASSWORD_DEFAULT),
            'can_see' => User::IS_TRUE,
            'can_delete' => User::IS_FALSE
        ]);
    }
}
