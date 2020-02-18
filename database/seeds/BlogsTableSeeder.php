<?php

use Illuminate\Database\Seeder;

class BlogsTableSeeder extends Seeder
{
    const BLOG_RECORD_NUMBER = 50; 
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Blog::class, BLOG_RECORD_NUMBER)->create();
    }
}
