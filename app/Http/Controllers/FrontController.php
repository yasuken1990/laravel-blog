<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Basics;

class FrontController extends Controller
{
    //
    public function index()
    {
        $basics = Basics::find(1);
        return view('index')->with('basics', $basics);
    }
}
