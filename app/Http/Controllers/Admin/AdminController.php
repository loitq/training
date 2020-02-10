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
<<<<<<< HEAD
        return view('admin.index');
=======
        return view('admin.index', ['roleAdmin' => $this->roleAdmin()]);
>>>>>>> a85ac0b... refactor folder view
    }

    public function userList()
    {
        return view('admin.user.list');
    }

    public function userCreate()
    {
        return view('admin.user.createOrUpdate');
    }

    public function userEdit()
    {
        return view('admin.user.createOrUpdate');
    }
}
