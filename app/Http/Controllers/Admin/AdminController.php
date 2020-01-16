<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.index');
    }

    public function userList()
    {
        return view('admin.user.list');
    }

    public function userCreate()
    {
        return view('admin.user.create');
    }

    public function userEdit()
    {
        return view('admin.user.edit');
    }
}
