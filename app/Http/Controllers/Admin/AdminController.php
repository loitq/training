<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\User;
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
        return view('admin.index', ['roleAdmin' => $this->roleAdmin()]);
    }

    /**
     * Permisson account admin
     *
     * @return $roleAdmin
     */
    public function roleAdmin()
    {
        $roleAdmin = \App\User::ADMIN;
        return $roleAdmin;
    }

    /**
     * Display user list.
     *
     * @return \Illuminate\View\View
     */
    public function userList()
    {
        $users = Auth::user();
        if ($users->role === \App\User::USER) {
            return redirect()->back();
        }

        $users = User::where('role', \App\User::ROLE_USER)
            ->paginate(\App\User::PAGINATE_USER);
        return view(
            'admin.user.list', [
            'users' => $users, 'roleAdmin' => $this->roleAdmin()
            ]
        );
    }

    /**
     * Return view create.
     *
     * @return \Illuminate\View\View
     */
    public function userCreate()
    {
        return view(
            'admin.user.createOrUpdate', [
            'roleAdmin' => $this->roleAdmin()
            ]
        );
    }

    /**
     * Handle create user.
     *
     * @param Request $request Request create user
     *
     * @return \Illuminate\Http\Response
     */
    public function handleUserCreate(Request $request)
    {
        $this->validate(
            $request, [
            'username' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required',
            ]
        );

        $user = new User();
        $user->name = $request->username;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        if ($request->can_see === "on") {
            $user->can_see = \App\User::IS_TRUE;
        } 
        if ($request->can_delete === "on") {
            $user->can_delete = \App\User::IS_TRUE;
        }

        $result = $user->save();

        if (!$result) {
            return redirect()->back()->with('error', 'Create user failed !');
        }

        return redirect()->back()->with('message', 'Create user success !');
    }

    /**
     * Return view user edit
     *
     * @param $id Id user
     * 
     * @return \Illuminate\View\View
     */
    public function userEdit($id)
    {
        $edit = User::find($id);
        if (!$edit) {
            return redirect('/admin/user/create');
        }

        return view(
            'admin.user.createOrUpdate', [
            'edit' => $edit, 'roleAdmin' => $this->roleAdmin()
            ]
        );       
    }

    /**
     * Handle edit account user
     *
     * @param Request $request Request edit user
     * @param $id      Id user
     * 
     * @return \Illuminate\Http\Response
     */
    public function handleUserEdit(Request $request, $id)
    {
        $user = User::find($id);
        if ($request->can_see != "on") {
            $user->can_see = \App\User::IS_FALSE;
        } else {
            $user->can_see = \App\User::IS_TRUE;
        }
        if ($request->can_delete != "on") {
            $user->can_delete = \App\User::IS_FALSE;
        } else {
            $user->can_delete = \App\User::IS_TRUE;
        }

        $result = $user->save();

        if (!$result) {
            return redirect()->back()->with('error', 'Edit user failed !');
        }

        return redirect()->back()->with('message', 'Edit user success !');
    }

    /**
     * Delete account user
     *
     * @param $id Id user
     *
     * @return \Illuminate\Http\Response
     */
    public function handleDelete($id)
    {
        $user = User::find($id);
        if (!isset($user)) {
            return redirect('/admin/user/list')
                ->with('message', 'Could not be deleted');
        }

        $user->delete();

        return redirect('/admin/user/list')
            ->with('message', 'Delete account success !');
    }

    /**
     * Logout admin
     *
     * @param Request $request Request logout admin
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/login');
    }
}
