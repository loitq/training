<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Blog;
use App\Comments;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blog = Blog::with(['user' => function($query) {
            $query->select( 'id', 'name');
        }])
            ->select(['id', 'user_id', 'title', 'content'])
            ->orderBy('created_at', 'desc')
            // ->get()
            // ->toArray();
            ->paginate(3);
        return view('user.index', [
            'blogs' => $blog
        ]);
    }

    public function getComment(Request $request)
    {
        $blogId = $request['id'];
        $listComment = Comments::with(['user' => function($query) {
                $query->select('id' ,'name');
            }])
            ->where('blog_id', $blogId)
            ->select(['id', 'user_id', 'comment_content'])
            ->get()
            ->toArray();    
        return $listComment;
    }

    public function addComment(Request $request)
    {
        return [
            'blogId' => $request['blogId'],
            'comment_content' => $request['comment_content']
        ];
    }
}
