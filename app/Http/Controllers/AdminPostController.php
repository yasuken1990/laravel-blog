<?php

namespace App\Http\Controllers;

use App\Post;
use App\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AdminPostController extends Controller
{
    const PAGINATION = 2;

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
        $posts = Post::paginate(self::PAGINATION);
        /**
         * TODO: fix
         * App\Post::getStatus()のコメントを参照し、修正してください。
         */
        $status = Post::getStatus();
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
        $status = Post::getStatus();

        return view('admin.posts.create', compact('category', 'status'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $this->validate($request, [
                'title' => 'required|unique:posts|max:255',
                'link' => 'required|unique:posts',
                'content' => 'required',
            ]);

            $post = new Post();
            $post->title = $request->title;
            $post->link = $request->link;
            $post->category_id = $request->category_id;
            $post->status = $request->status;
            $post->tag_id = 1; // dummy
            $post->content = $request->content;
            $post->save();

            return redirect('admin/post')->with('success', '更新完了！');

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Show Post Ediit Page.
        /**
         * TODO: fix
         * エラーが起きたらどうするの？
         * 指摘された箇所だけではなく、同じ理由のある箇所は全部修正してください。
         */
        $post = Post::findOrFail($id);
        $status = Post::getStatus();
        $category = Category::all()->pluck('name', 'id');
        return view('admin.posts.edit', compact('post', 'category', 'status'));
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
        try {
            $this->validate($request, [
                'title' => 'required|unique:posts|max:255',
                'link' => 'required|unique:posts',
                'content' => 'required',
            ]);

            // Do Post Edit.
            $post = Post::find($id);
            $post->title = $request->title;
            $post->link = $request->link;
            $post->content = $request->content;
            $post->status = $request->status;
            $post->tag_id = 1; // dummy
            $post->category_id = $request->category_id;
            $post->save();

            return back()->with('success', '更新完了！');
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Do Post Delete.
        /**
         * TODO: fix
         * これ動くの？
         */
        POST::destroy($id);

        return redirect('admin/post');
    }
}
