<?php

namespace App\Http\Controllers;

use App\Post;
use App\Category;
use App\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;


class AdminPostController extends Controller
{
    const PAGINATION_PER_PAGE = 10;

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Post Index Page. Post List.
        $posts = Post::paginate(self::PAGINATION_PER_PAGE);
        $status = Post::$statusLabels;

        return view('admin.posts.index', compact('posts', 'status'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Show Create Post Page.
        $category = Category::all()->pluck('name', 'id');
        $tags = Tag::all();
        $status = Post::$statusLabels;

        return view('admin.posts.create', compact('category', 'status', 'tags'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'title' => 'required|unique:posts|max:255',
                    'link' => 'required|unique:posts|max:255',
                    'content' => 'required',
                ]);

            $post = new Post();
            $post->title = $request->input('title');
            $post->link = $request->link;
            $post->category_id = $request->input('category_id');
            $post->status = $request->input('status');
            $post->content = $request->input('content');
            $post->save();

            $post->tags()->sync($request->input('tags'));

            return redirect('admin/post')->with('success', '作成完了！');

        } catch (ValidationException $e) {
            Log::warning($e->getMessage());
            Log::warning($e->getTraceAsString());
            Log::warning(print_r($request->toArray(), true));

            return back();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            return back()->with('error', 'System error has occured. Please contact the system administrator.');

        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Show Post Ediit Page.
        try {
            $post = Post::findOrFail($id);
            $status = Post::$statusLabels;
            $category = Category::all()->pluck('name', 'id');
            $selectedTags = $post->tags()->pluck('id')->toArray();
            $tags = Tag::all();

            return view('admin.posts.edit', compact('post', 'category', 'status', 'tags', 'selectedTags'));

        } catch (ModelNotFoundException $e) {
            Log::warning($e->getMessage());
            Log::warning($e->getTraceAsString());

            return back()->with('error', "ID:{$id}の、記事は存在しません。");

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            return back()->with('error', 'System error has occured. Please contact the system administrator.');

        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $this->validate($request, [
                'title' => ['required', 'max:255', Rule::unique('posts')->ignore($id),],
                'link' => ['required', Rule::unique('posts')->ignore($id),],
                'content' => 'required',
            ]);

            // Do Post Edit.
            $post = Post::findOrFail($id);
            $post->title = $request->input('title');
            $post->link = $request->input('link');
            $post->content = $request->input('content');
            $post->status = $request->input('status');
            $post->category_id = $request->input('category_id');
            $post->save();

            $post->tags()->sync($request->input('tags'));

            return back()->with('success', '更新完了！');

        } catch (ModelNotFoundException $e) {

            Log::warning($e->getMessage());
            Log::warning($e->getTraceAsString());

            return back()->with('error', "ID:{$id}の、記事は存在しません。");

        } catch (ValidationException $e) {
            Log::warning($e->getMessage());
            Log::warning($e->getTraceAsString());
            Log::warning(print_r($request->toArray(), true));

            return back();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            return back()->with('error', 'System error has occured. Please contact the system administrator.');

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            // Do Post Delete.
            Post::destroy($id);

            return redirect('admin/post');

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            return back()->with('error', '削除できませんでした。');

        }
    }
}
