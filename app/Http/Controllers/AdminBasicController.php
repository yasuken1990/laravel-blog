<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Basics;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AdminBasicController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $basics = Basics::find(1);
        return view('admin.basic')->with('basics', $basics);
    }

    public function update(Request $request)
    {
        /**
         * TODO: fix
         * 好みの問題もあるけど、単語をそのまま繋げると読みにくい。
         * スネークか、キャメルにするべき。
         * DBと相性が良く、リクエストをそのままクエリできるので、スネークがおすすめ。
         *
         * エラーメッセージは英語？
         * https://laravel.com/docs/5.4/validation#working-with-error-messages
         * Specifying Custom Messages In Language Files を参照
         *
         * これ、バリデーションエラーが発生したらどうなるの？
         * 全体的にエラー処理ができていない。
         * 下にupdateSampleを書いておいたから参考にしてくださいー
         * コードの意味が理解できるまで調べること。
         */
        $this->validate($request, [
            'sitetitle' => 'required',
            'catchphrase' => 'required',

        ]);

        // id = 1 のレコードがなかったらエラー？
        $basics = Basics::find(1);
        $basics->sitetitle = $request->sitetitle;
        $basics->catchphrase = $request->catchphrase;
        $basics->save();

        /**
         * TODO: fix
         * ここでviewを呼んだらダメ。
         * やってみたらわかるけど、updateのURLで入力画面（indexと同じ画面）が表示されてしまう。
         * しかもPOSTしてるので、戻るボタンを押したとき警告が出るし、それを再送信してしまえば二重送信になる。
         * ここはredirectさせるべき。
         */
        return view('admin.basic')->with('basics', $basics);
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
