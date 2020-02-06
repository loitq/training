<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Blog;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminBlogController extends Controller
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
        $blogs = User::join('blogs', 'users.id', '=', 'blogs.user_id')->get();

        return view('admin-blog/index', ['blogs'=>$blogs]);
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

        return redirect()->back()->with('message', 'Create blog success !')->with('message', 'Create new blog success');
    }

    /**
     * Delete one blog.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) 
    {
        $blog = Blog::find($id);
        if(isset($blog)) {
            $blog->delete();
        } else {
            return redirect()->back()->withErrors('Blog not found');
        }
            
        return redirect()->back()->with('message', 'delete blog success !');
    }

    /**
     * Edit view blog.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $blog = User::join('blogs', 'users.id', '=', 'blogs.user_id')->where('blogs.id', '=', $id)->first();
        if (isset($blog)) 
            return view('admin-blog/edit', ['blog' => $blog]);
        else
            return redirect()->back()->withErrors('Blog not found');
    }

    /**
     * Update one blog.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request ,$id)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);
        $blog = Blog::find($id);
        if(isset($blog)) {
            $blog->title = $request->title;
            $blog->content = $request->content;
            $blog->save();
        } else {
            return redirect()->back()->withErrors('Blog not found');
        }

        return redirect()->route('admin.blog.index')->with('message', 'Update blog success !');
    }
}
