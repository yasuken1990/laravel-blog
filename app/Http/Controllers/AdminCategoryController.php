<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AdminCategoryController extends Controller
{
    /**
     * TODO: fix
     * これだと定数値の意味が、使われてる箇所を読むまでわらからない。ページネーションが5って何の数字だろう？ってなる
     * 例えば「PAGINATION_PER_PAGE」とかにする。
     */
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

        try{
            $this->validate($request, [
                'name' => 'required|unique:categories|max:255',
            ]);

            // Store Create Post and Redirect Post Edit Page.
            $category = new Category();
            $category->name = $request->name;
            $category->created_at = Carbon::now();
            $category->updated_at = Carbon::now();
            $category->save();

            return redirect('admin/category')->with('success', '更新完了！');

        } catch (ValidationException $e) {
            /**
             * TODO: fix
             * 綴は直してくれないんですかね。
             * エラーの中はエラーを出さないと確認できないから要注意。
             * ここ、動作の確認はできてるの？
             */
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
         * failになって、エラーが発生したらどうするの？
         */
        $category = Category::findOrFail($id);

        return view('admin.categories.edit', compact('category'));
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
        try{
            $this->validate($request, [
                'name' => 'required',
            ]);

            /**
             * TODO: fix
             * orCreateが付いてるのはどういう意図？
             */
            Category::updateOrCreate([
                'id' => $id
            ], $request->except(['_token']));

            return redirect('admin/category/edit/' . $id)->with('success', '更新完了！');

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
        Category::destroy($id);

        return redirect('admin/category');
    }
}
