<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminCategoryController extends Controller
{
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
        $categories = Category::all();
        return view('admin.categories.index')->with('categories', $categories);
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
        return redirect('admin/categories');
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
        $category = Category::find($id);
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
        // Do Post Edit.
        $category = Category::find($id);
        $category->name = $request->name;
        $category->created_at = Carbon::now();
        $category->updated_at = Carbon::now();
        $category->save();

        return redirect('admin/categories');
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
        if ($id == Category::NONE) {
           redirect('admin/categories');
        } else {
            Category::where('id', $id)->delete();
        }
        $categories = Category::all();
        return view('admin.categories.index')->with('categories', $categories);
    }
}
