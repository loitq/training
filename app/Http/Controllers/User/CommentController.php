<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Blog;
use App\Comments;
use App\MagicNumberConst;
use Auth;

class CommentController extends Controller
{
    /**
     * Handle get list comment.
     *
     * @param Request $request
     * @param int $blogId
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
                'error' => MagicNumberConst::ERROR,
                'message' => $e->getMessage()
            ];
        }
        $listComments = $this->getCommentsByBlogId($request['blogId']);

        return [
            'error' => MagicNumberConst::SUCCESS,
            'blogId' => $request['blogId'],
            'listComments' => $listComments
        ];
    }

    /**
     * Handle get list comment by blogId.
     *
     * @param int $blogId
     * @return array $listComments
     */
    private function getCommentsByBlogId($blogId)
    {
        $listComments = Comments::with(['user' => function ($query) {
            $query->select('id', 'name');
        }])
        ->where('blog_id', $blogId)
        ->select(['id', 'user_id', 'comment_content'])
        ->take(MagicNumberConst::LIMIT_COMMENT)
        ->orderBy('created_at', 'desc')
        ->get()
        ->toArray();

        return $listComments;
    }
}
