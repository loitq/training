<?php

use Illuminate\Database\Seeder;

define('_UserCanSeeId', 1);
define('_UserCanDeleteId', 2);
define('_UserCanNotSeeId', 3);

class BlogTableTestAddBlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //add data for user only can see
        DB::table('blogs')->insert([
            'user_id' => _UserCanSeeId,
            'title' => 'user can see title a',
            'content' => 'content'
        ]);

        DB::table('blogs')->insert([
            'user_id' => _UserCanSeeId,
            'title' => 'user can see title b',
            'content' => 'content'
        ]);
        
        DB::table('blogs')->insert([
            'user_id' => _UserCanSeeId,
            'title' => 'user can see title c',
            'content' => 'content'
        ]);
        
        //add data for user can delete
        DB::table('blogs')->insert([
            'user_id' => _UserCanDeleteId,
            'title' => 'user can delete title a',
            'content' => 'content'
        ]);

        DB::table('blogs')->insert([
            'user_id' => _UserCanDeleteId,
            'title' => 'user can delete title b',
            'content' => 'content'
        ]);
        
        DB::table('blogs')->insert([
            'user_id' => _UserCanDeleteId,
            'title' => 'user can delete title c',
            'content' => 'content'
        ]);

        //add data for user can not see
        DB::table('blogs')->insert([
            'user_id' => _UserCanNotSeeId,
            'title' => 'user can not see title a',
            'content' => 'content'
        ]);

        DB::table('blogs')->insert([
            'user_id' => _UserCanNotSeeId,
            'title' => 'user can not see title b',
            'content' => 'content'
        ]);
        
        DB::table('blogs')->insert([
            'user_id' => _UserCanNotSeeId,
            'title' => 'user can not see title c',
            'content' => 'content'
        ]);
    }
}
