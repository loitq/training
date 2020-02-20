<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Blog;
use App\User;
use Exception;
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
        $canSee = $this->defineUser()->can_see;
        if ($canSee === Blog::IS_FALSE) {
            return redirect()->back()->withErrors("you can't to enter blog manage");
        }

        //return view blog index with param $candelete and $blog
        $canDelete = $this->defineUser()->can_delete === Blog::IS_TRUE;
        $blogs = Blog::where('user_id', '=', $this->defineUser()->id)->get();
        
        return view('blog/index', ['blogs'=>$blogs, 'canDelete'=>$canDelete]);
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
            'title' => 'required|max:100|min:10',
            'content' => 'required',
        ]);
        
        try {
            $blog = new Blog;
            $blog->user_id = $this->defineUser()->id;
            $blog->title = $request->title;
            $blog->content = $request->content;
            $blog->save();

            return redirect()->back()->with('message', 'Create new blog success !');
        } catch (Exception $e) {
            return redirect()->back()->withErrors('Create blog error');
        }
    }

    /**
    * Delete one blog.
    *
    * @param  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {
        if ($this->defineUser()->can_delete === Blog::IS_FALSE) {
            return redirect()->back()->withErrors('You need administrator permission to delete this blog !');
        }

        // Find and delete
        $blog = Blog::find($id);
        if (!isset($blog)) {
            return redirect()->back()->withErrors('Blog not found !');
        }

        //delete blog and return back with status
        try {
            $blog->delete();
        } catch (Exception $e) {
            return redirect()->back()->withErrors('Delete blog error');
        }

        return redirect()->back()->with('message', 'Delete blog success !');
    }

    /**
    * Edit view blog.
    *
    * @param  $id
    * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        $blog = Blog::find($id);
        if (isset($blog)) {
            return view('blog/edit', ['blog' => $blog]);
        }

        return redirect()->back()->withErrors('Blog not found !');
    }

    /**
    * Update one blog.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param $id
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:100|min:10',
            'content' => 'required',
        ]);
        $blog = Blog::find($id);
        if (!isset($blog)) {
            return redirect()->route('blog.index')->withErrors('Blog not found !');
        }

        //update blog
        try {
            $blog->title = $request->title;
            $blog->content = $request->content;
            $blog->save();
        } catch (Exception $e) {
            return redirect()->back()->withErrors('Update blog error');
        }

        return redirect()->route('blog.index')->with('message', 'Update blog success!');
    }
}
