<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Site;
use App\Tag;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($link)
    {
        //
        try {
            if (Auth::check()) {

                $post = Post::where('link', $link)->firstOrFail();

            } else {

                $post = Post::where('link', $link)->where('status', Post::STATUS_PUBLIC)->firstOrFail();

            }

            $site = Site::firstOrFail();
            $selectedTags = $post->tags()->pluck('id')->toArray();
            $tags = Tag::all();

            return view('posts.detail', compact('post', 'site', 'tags', 'selectedTags'));

        } catch (ModelNotFoundException $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            return abort(404);

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            // TODO フロントだし、500がいいかな…
            // https://readouble.com/laravel/5.4/ja/errors.html
            return back()->with('error', 'System error has occured. Please contact the system administrator.');

        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
