<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Site;
use App\Post;

class FrontController extends Controller
{
    //
    public function index()
    {
        $site = Site::find(1);
        $posts = Post::all();
        return view('index', compact('site', 'posts'));
    }
}
