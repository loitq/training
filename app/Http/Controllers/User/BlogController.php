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
        $blogs = Blog::where('user_id', '=', $this->defineUser()->id)->get();
        $canDelete = $this->defineUser()->can_delete === Blog::IS_TRUE;
        $canSee = $this->defineUser()->can_see;
        if($canSee === Blog::IS_TRUE)
            return view('blog/index', ['blogs'=>$blogs, 'canDelete'=>$canDelete]);
        else
            return redirect()->back()->withErrors("you can't to enter blog manage");
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
        
        try {
            $blog = new Blog;
            $blog->user_id = $this->defineUser()->id;
            $blog->title = $request->title;
            $blog->content = $request->content;
            $blog->save();

            return redirect()->back()->with('message', 'Create new blog success !');
        } catch(Exception $e) {
            return redirect()->back()->withErrors('Create blog error');
        }
    }

    /**
     * Delete one blog.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) 
    {
        if ($this->defineUser()->can_delete === Blog::IS_TRUE) {
            $blog = Blog::find($id);
            if (isset($blog)) {
                try {
                    $blog->delete();
                } catch(Exception $e) {
                    return redirect()->back()->withErrors('Delete blog error');
                }
            } else {
                return redirect()->back()->withErrors('Delete blog error');
            }
        }

        return redirect()->back()->with('message', 'Delete blog success !');
    }

    /**
     * Edit view blog.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $blog = Blog::find($id);
        if (isset($blog)) 
            return view('blog/edit', ['blog' => $blog]);
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
        if (isset($blog)) {
            try {
                $blog->title = $request->title;
                $blog->content = $request->content;
                $blog->save();
            } catch(Exception $e) {
                return redirect()->back()->withErrors('Update blog error');
            }

            return redirect()->route('blog.index')->with('message', 'Update blog success!');
        }

        return redirect()->back()->withErrors('Update blog error!');
    }
}
