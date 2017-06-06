<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Basics;

class AdminBasicController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $basics = Basics::find(1);
        return view('admin.basic')->with('basics', $basics);
    }

    public function update(Request $request)
    {
        $basics = Basics::find(1);
        $basics->sitetitle = $request->sitetitle;
        $basics->catchphrase = $request->catchphrase;
        $basics->save();
        return view('admin.basic')->with('basics', $basics);
    }
}
