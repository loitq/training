<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Blog;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{

    // return information user
    public function defineUser() {
        return Auth::user();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogs = Blog::all();
        if ($this->defineUser()->can_delete === Blog::IS_TRUE) {
            $canDelete = true;
        }else {
            $canDelete = false;
        }
        $canDelete = false;
        $canSee = $this->defineUser()->can_see;
        if($canSee === Blog::IS_TRUE)
            return view('user.blog.index', ['blogs'=>$blogs, 'canDelete'=>$canDelete]);
        else
            return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);
        $blog = new Blog;
        $blog->user_id = $this->defineUser()->id;
        $blog->title = $request->title;
        $blog->content = $request->content;
        $blog->save();
        return redirect()->back();
    }
}
