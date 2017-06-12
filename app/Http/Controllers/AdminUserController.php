<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class AdminUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = User::find(1);
        return view('admin.user')->with('user', $user);
    }

    public function update(Request $request)
    {
        /**
         * TODO: fix
         * 名前だけ変えて、パスワードは変えたくないときとかどうするのか。
         * パスワードは入れ直す必要がある？もしその時入力ミスをしたらアウト？
         */
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = User::find(1);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        return view('admin.user')->with('user', $user);
    }
}
