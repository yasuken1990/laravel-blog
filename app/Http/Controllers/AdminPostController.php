<?php

namespace App\Http\Controllers;

use App\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Post;

class AdminPostController extends Controller
{
    const PAGINATION = 5;

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
        $posts = Category::paginate(self::PAGINATION);

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
        $categoies = Category::all();
        /**
         * TODO: fix
         * Collection::pluck() を使ってほしい。
         * せっかくコレクションなのにもったいない。
         */
        $formCategory = [];
        foreach ($categoies as $category) {
            $formCategory[$category->id] = $category->name;
        }

        /**
         * TODO: fix
         * Viewにデータを渡すのにwith() は使わない。
         */
        return view('admin.posts.create')->with('category', $formCategory);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /**
         * TODO: fix
         * エラー処理ぃいい
         */
        $this->validate($request, [
            'title' => 'required|unique:posts|max:255',
            'link' => 'required|unique:posts',
            'contents' => 'required',

        ]);

        // Store Create Post and Redirect Post Edit Page.
        $posts = new Post();
        $posts->title = $request->title;
        $posts->link = $request->link;
        $posts->content = $request->contents;
        $posts->status = 1; // dummy
        $posts->tag_id = 1; // dummy
        $posts->category_id = $request->category_id; //dummy
        $posts->created_at = Carbon::now();
        $posts->updated_at = Carbon::now();
        $posts->save();

        return redirect('admin/posts');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Show Post Detail Page.
        // Edit Pageあるしいらないか…?
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        /**
         * TODO: fix
         * 同上
         */
        // Show Post Ediit Page.
        $post = Post::find($id);
        $categoies = Category::all();
        $formCategory = [];
        foreach ($categoies as $category) {
            $formCategory[$category->id] = $category->name;
        }
        return view('admin.posts.edit')->with('post', $post)->with('category', $formCategory);
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
        // Do Post Edit.
        $post = Post::find($id);
        $post->title = $request->title;
        $post->link = $request->link;
        /**
         * TODO: fix
         * 単数形と複数形なんてどっちでも良いとか思うなよ！！
         * content => contents
         */
        $post->content = $request->contents;
        /**
         * TODO: fix
         * そのうちちゃんと定数にしてね。
         */
        $post->status = 1; // dummy
        $post->tag_id = 1; // dummy
        $post->category_id = $request->category_id; //dummy
        $post->created_at = Carbon::now();
        $post->updated_at = Carbon::now();
        $post->save();

        /**
         * TODO: fix
         * 編集が完了したら編集画面に戻る。であってる？
         * あってるなら、return back(); がいいよ。
         */
        return redirect('admin/posts/edit/' . $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        /**
         * TODO: fix
         * これ動作確認はまだしてないのかな。
         * さすがに動かないよね・・。
         * ここも最後はリダイレクトね。
         */
        // Do Post Delete.
        POST::where('id', $id)->delete();
        $posts = POST::all();
        return view('admin.posts.index')->with('posts', $posts);
    }
}
