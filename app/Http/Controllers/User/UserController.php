<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Blog;
use App\Comments;
use App\MagicNumberConst;
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
            ->paginate(MagicNumberConst::PAGINATE_BLOG);
        return view('user.index', [
            'blogs' => $blog
        ]);
    }
}
