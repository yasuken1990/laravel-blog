<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Site;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AdminSiteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        try {
            $site = Site::firstOrCreate(
                [
                    'id' => 1,
                ],
                [
                    'title' => 'Site Title',
                    'phrase' => 'Catch Phrase',
                ]);

            return view('admin.site', compact('site'));

        } catch (ModelNotFoundException $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            return back()->with('error', 'サイト情報が存在しません。深刻なエラーです！今すぐ管理者に連絡してください！');
            
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            return back()->with('error', 'System error has occured. Please contact the system administrator.');

        }
    }

    public function update(Request $request)
    {
        try {
            $message = [
                'title.required' => 'サイトタイトルは、必須入力です。',
            ];
            $this->validate($request, [
                'title' => 'required',
                'phrase' => 'required',

            ], $message);

            $site = Site::firstOrFail();

            $site->title = $request->input('title');
            $site->phrase = $request->input('phrase');
            $site->save();

            return redirect('admin/site')->with('success', '更新完了！');

        } catch (ValidationException $e) {
            Log::warning($e->getMessage());
            Log::warning($e->getTraceAsString());
            Log::warning(print_r($request->toArray(), true));

            return back();

        } catch (ModelNotFoundException $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            return back()->with('error', 'サイト情報が存在しません。深刻なエラーです！今すぐ管理者に連絡してください！');

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            return back()->with('error', 'System error has occured. Please contact the system administrator.');

        }
    }
}
