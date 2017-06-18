<?php

namespace App\Http\Controllers;

use App\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Facades\Log;

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

        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Show Create Post Page.
        $category = Category::pluck('name', 'id');

        return view('admin.posts.create', compact('category'));
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
            $post->status = 1; // dummy
            $post->tag_id = 1; // dummy
            $post->content = $request->content;
            $post->save();

            return redirect('admin/post')->with('success', '更新完了！');

        } catch (ValidationException $e) {
            dd($e);
            // ここに入る場合はユーザの入力ミスだが、サポート時に必要ならログを取る
            Log::warnning($e->getMessage());
            Log::warnning($e->getTraceAsString());
            Log::warnning(print_r($request->toArray(), true));

            // リクエスト元のページに戻し、バリデーションエラーを表示する。
            return back();
        } catch (\Exception $e) {
            // こっちはシステム的なエラーの可能性が高い。
            // 必ずログを取り、必要に応じてアラートメールを飛ばす。
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            // ユーザにもこれはあなたのせいじゃないよって通知する。
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
        $post = Post::findOrFail($id);
        $category = Category::pluck('name', 'id');

        return view('admin.posts.edit', compact('post', 'category'));
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
            $post->status = 1; // dummy
            $post->tag_id = 1; // dummy
            $post->category_id = $request->category_id; //dummy
            $post->save();

            return back()->with('success', '更新完了！');
        } catch (ValidationException $e) {
            // ここに入る場合はユーザの入力ミスだが、サポート時に必要ならログを取る
            Log::warnning($e->getMessage());
            Log::warnning($e->getTraceAsString());
            Log::warnning(print_r($request->toArray(), true));

            // リクエスト元のページに戻し、バリデーションエラーを表示する。
            return back();
        } catch (\Exception $e) {
            // こっちはシステム的なエラーの可能性が高い。
            // 必ずログを取り、必要に応じてアラートメールを飛ばす。
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            // ユーザにもこれはあなたのせいじゃないよって通知する。
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
        POST::destroy($id);

        return redirect('admin/post');
    }
}