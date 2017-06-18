<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class AdminPasswordController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = User::findOrFail(1);
        return view('admin.password')->with('user', $user);
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
            Log::warnning($e->getMessage());
            Log::warnning($e->getTraceAsString());
            Log::warnning(print_r($request->toArray(), true));

            return back();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            return back()->with('error', 'System error has occured. Please contact the system administrator.');
        }
    }
}
