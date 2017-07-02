<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Site;
use App\Post;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class FrontController extends Controller
{
    //
    public function index()
    {
        try {
            $site = Site::firstOrFail();
            $posts = Post::all();

            return view('index', compact('site', 'posts'));

        } catch (ModelNotFoundException $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            return abort(404);

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            // TODO フロントだし、500がいいかな…
            // https://readouble.com/laravel/5.4/ja/errors.html
            return abort(404);
        }
    }
}
