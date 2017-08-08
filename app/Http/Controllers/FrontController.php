<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Site;
use App\Post;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class FrontController extends Controller
{
    const PAGINATION_PER_PAGE = 5;

    //
    public function index($date = '2017-07')
    {
        try {
            $site = Site::firstOrFail();

            if (Auth::check()) {

                $posts = Post::whereBetween('created_at', [$date . '-01', $date . '-31 23:59:59'])
                    ->paginate(self::PAGINATION_PER_PAGE);

            } else {

                $posts = Post::where('status', Post::STATUS_PUBLIC)
                    ->whereBetween('created_at', [$date . '-01', $date . '-31 23:59:59'])
                    ->paginate(self::PAGINATION_PER_PAGE);

            }

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
