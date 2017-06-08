<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Basics;
use App\Post;

class FrontController extends Controller
{
    //
    public function index()
    {
        $basics = Basics::find(1);
        $posts = Post::all();
        return view('index')->with('basics', $basics)->with('posts', $posts);
    }
}
