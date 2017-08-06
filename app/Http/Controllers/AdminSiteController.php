<?php

namespace App\Http\Controllers;

use App\Site;
use App\Template;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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
            $templates = Template::all()->pluck('name', 'id');

            $site = Site::firstOrCreate(
                [
                    'id' => 1,
                ],
                [
                    'title' => 'Site Title',
                    'phrase' => 'Catch Phrase',
                ]);

            return view('admin.site', compact('site', 'templates'));

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

            $site = Site::firstOrFail();

            $message = [
                'title.required' => 'サイトタイトルは、必須入力です。',
            ];
            $this->validate($request, [
                'title' => 'required',Rule::unique('sites')->ignore($site->id),
                'phrase' => 'required',Rule::unique('sites')->ignore($site->id),
                'template_id' => 'required',Rule::unique('sites')->ignore($site->id),

            ], $message);

            $site->title = $request->input('title');
            $site->phrase = $request->input('phrase');
            $site->template_id = $request->input('template_id');
            $site->save();

            $template = Template::find($site->template_id);
            Template::updateTemplateFiles($template);

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
