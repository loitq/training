<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Blog;
use App\Comments;
use Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blog = Blog::with(['user' => function ($query) {
            $query->select('id', 'name');
        }])
            ->select(['id', 'user_id', 'title', 'content'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('user.index', [
            'blogs' => $blog
        ]);
    }

    /**
     * Handle get list comment.
     *
     * @param Request $request
     *
     * @return array $listComments
     */
    public function userListComment(Request $request)
    {
        $blogId = $request['id'];
        $listComment = $this->getCommentsbyBligId($blogId);
        return $listComment;
    }

    /**
     * Handle add new comment and load new list comment.
     *
     * @param Request $request
     *
     * @return array
     */
    public function userAddComment(Request $request)
    {
        $user = Auth::user();
        $comment =  new Comments();

        $comment->user_id = $user->id;
        $comment->blog_id = $request['blogId'];
        $comment->comment_content = $request->comment_content;

        $comment->save();

        $listComments = $this->getCommentsbyBligId($request['blog_id']);

        return [
            'blogId' => $request['blogId'],
            'listComments' => $listComments
        ];
    }

    /**
     * Handle get list comment by blogId.
     *
     * @param Request $request
     *
     * @return array $listComments
     */
    private function getCommentsbyBligId($blogId)
    {
        $listComments = Comments::with(['user' => function ($query) {
            $query->select('id', 'name');
        }])
        ->where('blog_id', $blogId)
        ->select(['id', 'user_id', 'comment_content'])
        ->take(3)
        ->get()
        ->toArray();

        return $listComments;
    }
}
