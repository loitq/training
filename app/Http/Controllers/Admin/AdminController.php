<?php
/**
 * Parses and verifies the doc comments for files!
 *
 * PHP version 7
 *
 * @category PHP
 * @package  PHP_CodeSniffer
 * @author   LoiTQ <loitq@lifull-tech.vn>
 * @license  http://matrix.squiz.net/developer/tools/php_cs/licence BSD Licence
 * @link     http://pear.php.net/package/PHP_CodeSniffer
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\User;
use Auth;

/**
 * Template Class Doc Comment
 * 
 * AdminConttroller
 * 
 * @category PHP
 * @package  PHP_CodeSniffer
 * @author   LoiTQ <loitq@lifull-tech.vn>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://127.0.0.1/
 */
class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roleAdmin = \App\User::ADMIN;
        return view('admin.user.dashboard', ['roleAdmin' => $roleAdmin]);
    }

    /**
     * Log account admin out of the application.
     *
     * @return void
     */
    public function userList()
    {
        $users = Auth::user();
        $roleAdmin = \App\User::ADMIN;
        if ($users->role === \App\User::ADMIN) {
            $users = User::where('role', \App\User::ROLE_USER)
                ->paginate(\App\User::PAGINATE_USER);
            return view(
                'admin.user.list', [
                'users' => $users, 'roleAdmin' => $roleAdmin
                ]
            );
        } else {
            return redirect()->back();
        }
    }

    /**
     * Log account admin out of the application.
     *
     * @return void
     */
    public function userCreate()
    {
        $roleAdmin = \App\User::ADMIN;
        return view('admin.user.createOrUpdate', ['roleAdmin' => $roleAdmin]);
    }

    /**
     * Log account admin out of the application.
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
        $user->can_see = \App\User::IS_TRUE;
        $user->can_delete = \App\User::IS_TRUE;
        if ($request->can_see == null) {
            $user->can_see = \App\User::IS_FALSE;
        }
        if ($request->can_delete == null) {
            $user->can_delete = \App\User::IS_FALSE;
        }
        $user->save();
        return redirect()->back()->with('message', 'Create user success !');
    }

    /**
     * Log account admin out of the application.
     *
     * @param $id Id user
     *
     * @return \Illuminate\Http\Response
     */
    public function userEdit($id)
    {
        $edit = User::find($id);
        $roleAdmin = \App\User::ADMIN;
        return view(
            'admin.user.createOrUpdate', [
            'edit' => $edit, 'roleAdmin' => $roleAdmin
            ]
        );
    }

    /**
     * Log account admin out of the application.
     *
     * @param Request $request Request edit user
     * @param $id      Id user
     * 
     * @return \Illuminate\Http\Response
     */
    public function handleUserEdit(Request $request, $id)
    {
        $user = User::find($id);

        $user->can_see = \App\User::IS_TRUE;
        $user->can_delete = \App\User::IS_TRUE;
        if ($request->can_see == null) {
            $user->can_see = \App\User::IS_FALSE;
        }
        if ($request->can_delete == null) {
            $user->can_delete = \App\User::IS_FALSE;
        }
        $user->save();
        return redirect()->back()->with('message', 'Edit user success !');
    }

    /**
     * Log account admin out of the application.
     *
     * @param $id Id user
     *
     * @return \Illuminate\Http\Response
     */
    public function handleDelete($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect('/admin/user/list')
            ->with('message', 'Delete account success !');
    }

    /**
     * Log account admin out of the application.
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
