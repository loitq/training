<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Blog;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogs = DB::table('blogs')
            ->join('users', 'blogs.user_id', 'users.id')
            ->select('users.name as userName','blogs.id as blogId', 'blogs.user_id as userId', 'blogs.title', 'blogs.content')
            ->orderBy('blogs.created_at', 'desc')
            ->get();
        $blog = Blog::with('user')
            ->get('blogs.id')->toArray();
        var_dump($blog); die;
        return view('user.index', [
            'roleAdmin' => '',
            'blogs' => json_decode($blogs, true)
        ]);
    }
}
