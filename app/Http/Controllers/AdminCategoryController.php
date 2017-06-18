<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

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
        /**
         * TODO: fix
         * 指定のidが見つからなかたときの処理を入れてください。
         */
        // Show Post Ediit Page.
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

            Category::updateOrCreate([
                'id' => $id
            ], $request->except(['_token']));

            return redirect('admin/category/edit/' . $id)->with('success', '更新完了！');

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
        Category::destroy($id);

        return redirect('admin/category');
    }
}
