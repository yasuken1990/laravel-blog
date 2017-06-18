<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Site;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AdminSiteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $site = Site::find(1);
        return view('admin.site')->with('site', $site);
    }

    public function update(Request $request)
    {
        try{
            $message = [
                'title.required' => 'サイトタイトルは、必須入力です。',
            ];
            $this->validate($request, [
                'title' => 'required',
                'phrase' => 'required',

            ], $message);

            Site::updateOrCreate([
                'id' => 1
            ], $request->except(['_token']));

            return redirect('admin/site')->with('success', '更新完了！');

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
     * Sample update method.
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function updateSample(Request $request)
    {
        try {

            $this->validate($request, [
                'title' => 'required',
                'phrase' => 'required',

            ]);


            // Basicsはおかしいので、Siteに改名しました。
            Site::updateOrCreate([
                'id' => 1
            ], $request->except(['_token']));

            return redirect('admin')->with('success', 'Successfully updated.');

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
}
