<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Blog;
use App\Comments;
use Auth;

class CommentController extends Controller
{
    /**
     * Handle get list comment.
     *
     * @param Request $request
     * @return array $listComments
     */
    public function index(Request $request, $blogId)
    {
        return $listComments = $this->getCommentsbyBlogId($blogId);
    }

    /**
     * Handle add new comment and load new list comment.
     *
     * @param Request $request
     * @return array
     */
    public function create(Request $request)
    {
        $user = Auth::user();
        try {
            $comment =  new Comments();

            $comment->user_id = $user->id;
            $comment->blog_id = $request['blogId'];
            $comment->comment_content = $request->comment_content;

            $comment->save();
        } catch (Exception $e) {
            return [
                'error' => 1,
                'message' => $e->getMessage()
            ];
        }
        $listComments = $this->getCommentsbyBlogId($request['blogId']);

        return [
            'error' => 0,
            'blogId' => $request['blogId'],
            'listComments' => $listComments
        ];
    }

    /**
     * Handle get list comment by blogId.
     *
     * @param Request $request
     * @return array $listComments
     */
    private function getCommentsbyBlogId($blogId)
    {
        $listComments = Comments::with(['user' => function ($query) {
            $query->select('id', 'name');
        }])
        ->where('blog_id', $blogId)
        ->select(['id', 'user_id', 'comment_content'])
        ->take(Comments::LIMIT_COMMENT)
        ->orderBy('created_at', 'desc')
        ->get()
        ->toArray();

        return $listComments;
    }
}
