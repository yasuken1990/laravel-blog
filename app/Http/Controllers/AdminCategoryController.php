<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminCategoryController extends Controller
{
    const PAGINATION = 5;
    //
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
        $categories = Category::paginate(self::PAGINATION);

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Show Create Post Page.
        return view('admin.categories.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:categories|max:255',
        ]);

        // Store Create Post and Redirect Post Edit Page.
        $category = new Category();
        $category->name = $request->name;
        $category->created_at = Carbon::now();
        $category->updated_at = Carbon::now();
        $category->save();
        return redirect('admin/category');
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
         * 指定のidが見つからなかたときの処理を入れてください。
         */
        // Show Post Ediit Page.
        $category = Category::findOrFail($id);
        return view('admin.categories.edit')->with('category', $category);
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
        /**
         * TODO: fix
         * storeメソッドと同様にエラー処理を行ってください。
         * ここバリデーションないし。
         */
        // Do Post Edit.
        $category = Category::find($id);
        $category->name = $request->name;
        $category->created_at = Carbon::now();
        $category->updated_at = Carbon::now();
        $category->save();

        return redirect('admin/category');
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
         * const NONE = 1 なら、id = 1のカテゴリは存在できないってこと？
         * 比較演算子は === とか !== を自信をもって使えないと、どこかでバグを出すと思う。
         */
        // Do Post Delete.
        if ($id == Category::NONE) {
           redirect('admin/categories');
        } else {
            /**
             * TODO: fix
             * Model::destroy($id)のほうがスマート。
             */
            Category::where('id', $id)->delete();
        }

        /**
         * TODO: fix
         * ここもリダイレクトだね。
         * URIに複数系のものと単数形のものが混ざってるけど、何か意図がある？
         * return redirect('admin/category');
         */
        $categories = Category::all();
        return view('admin.categories.index')->with('categories', $categories);
    }
}
