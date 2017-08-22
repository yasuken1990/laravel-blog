<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        try {
            $user = User::findOrFail(1);

            return view('admin.password', compact('user'));

        } catch (ModelNotFoundException $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            return back()->with('error', 'ユーザが存在しません。深刻なエラーです！今すぐ管理者に連絡してください！');

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            return back()->with('error', 'System error has occured. Please contact the system administrator.');

        }
    }

    public function update(Request $request)
    {
        try {
            $this->validate($request, [
                'password' => 'required',
            ]);

            $request->user()->fill([
                'password' => Hash::make($request->password)
            ])->save();

            return redirect('admin/password')->with('success', '更新完了！');
        } catch (ValidationException $e) {
            Log::warning($e->getMessage());
            Log::warning($e->getTraceAsString());

            return back();

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            return back()->with('error', 'System error has occured. Please contact the system administrator.');

        }
    }
}
