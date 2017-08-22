<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Category;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoryController extends Controller
{
    const PAGINATION_PER_PAGE = 5;

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
        $categories = Category::paginate(self::PAGINATION_PER_PAGE);

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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try {
            $this->validate($request, [
                'name' => 'required|unique:categories|max:255',
            ]);

            // Store Create Post and Redirect Post Edit Page.
            $category = new Category();
            $category->name = $request->input('name');
            $category->created_at = Carbon::now();
            $category->updated_at = Carbon::now();
            $category->save();

            return redirect('admin/category')->with('success', '更新完了！');

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
            $category = Category::findOrFail($id);

            return view('admin.categories.edit', compact('category'));

        } catch (ModelNotFoundException $e) {
            Log::warning($e->getMessage());
            Log::warning($e->getTraceAsString());

            return back()->with('error', "ID:{$id}の、カテゴリは存在しません。");

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            return back()->with('error', '予期せぬエラーが発生しました。');

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
                'name' => 'required',
            ]);

            $category = Category::findOrFail($id);
            $category->name = $request->input('name');
            $category->save();

            return redirect('admin/category/edit/' . $id)->with('success', '更新完了！');
        } catch (ModelNotFoundException $e) {
            Log::warning($e->getMessage());
            Log::warning($e->getTraceAsString());
            Log::warning(print_r($request->toArray(), true));

            return back()->with('error', '不正なリクエストです。');
        } catch (ValidationException $e) {
            Log::warning($e->getMessage());
            Log::warning($e->getTraceAsString());
            Log::warning(print_r($request->toArray(), true));

            return back();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            return back()->with('error', '予期せぬエラーが発生しました。');

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
            Category::destroy($id);

            return redirect('admin/category');

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            return back()->with('error', '削除できませんでした。');

        }
    }
}
