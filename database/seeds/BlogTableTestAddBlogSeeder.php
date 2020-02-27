<?php

use Illuminate\Database\Seeder;

define("_BLOG_TEST_RECORD_NUMBER", 5);
define('_UserCanSeeId', 1);
define('_UserCanDeleteId', 2);
define('_UserCanNotSeeId', 3);
define('_UserCanNotDeleteId', 4);

class BlogTableTestAddBlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //add data for user can see
        DB::table('blogs')->insert([
            'user_id' => _UserCanSeeId,
            'title' => 'user can see title1',
            'content' => 'content'
        ]);

        DB::table('blogs')->insert([
            'user_id' => _UserCanSeeId,
            'title' => 'user can see title2',
            'content' => 'content'
        ]);
        
        DB::table('blogs')->insert([
            'user_id' => _UserCanSeeId,
            'title' => 'user can see title3',
            'content' => 'content'
        ]);
        
        //add data for user can delete
        DB::table('blogs')->insert([
            'user_id' => _UserCanDeleteId,
            'title' => 'user can delete title1',
            'content' => 'content'
        ]);

        DB::table('blogs')->insert([
            'user_id' => _UserCanDeleteId,
            'title' => 'user can delete title2',
            'content' => 'content'
        ]);
        
        DB::table('blogs')->insert([
            'user_id' => _UserCanDeleteId,
            'title' => 'user can delete title3',
            'content' => 'content'
        ]);

        //add data for user can not see
        DB::table('blogs')->insert([
            'user_id' => _UserCanNotSeeId,
            'title' => 'user can not see title1',
            'content' => 'content'
        ]);

        DB::table('blogs')->insert([
            'user_id' => _UserCanNotSeeId,
            'title' => 'user can not see title2',
            'content' => 'content'
        ]);
        
        DB::table('blogs')->insert([
            'user_id' => _UserCanNotSeeId,
            'title' => 'user can not see title3',
            'content' => 'content'
        ]);

        //add data for user can not delete
        DB::table('blogs')->insert([
            'user_id' => _UserCanNotDeleteId,
            'title' => 'user can not delete title1',
            'content' => 'content'
        ]);

        DB::table('blogs')->insert([
            'user_id' => _UserCanNotDeleteId,
            'title' => 'user can not delete title2',
            'content' => 'content'
        ]);
        
        DB::table('blogs')->insert([
            'user_id' => _UserCanNotDeleteId,
            'title' => 'user can not delete title3',
            'content' => 'content'
        ]);
    }
}
