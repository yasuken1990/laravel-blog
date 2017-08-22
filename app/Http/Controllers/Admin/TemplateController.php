<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Template;
use App\Site;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TemplateController extends Controller
{

    const PAGINATION_PER_PAGE = 10;

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
        $templates = Template::paginate(self::PAGINATION_PER_PAGE);

        return view('admin.templates.index', compact('templates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.templates.create');
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
                'name' => 'required|unique:templates|max:255',
                'top' => 'required',
                'detail' => 'required',
            ]);

            $template = new Template();
            $template->name = $request->input('name');
            $template->top = $request->input('top');
            $template->detail = $request->input('detail');
            $template->js = $request->input('js');
            $template->css = $request->input('css');
            $template->save();

            return redirect('admin/template')->with('success', '作成完了！');

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
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        try {
            $template = Template::findOrFail($id);
            return view('admin.templates.edit', compact('template'));

        } catch (ModelNotFoundException $e) {
            Log::warning($e->getMessage());
            Log::warning($e->getTraceAsString());

            return back()->with('error', "ID:{$id}の、テンプレートは存在しません。");

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            return back()->with('error', 'System error has occured. Please contact the system administrator.');

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
                'name' => 'required', 'max:255', Rule::unique('templates')->ignore($id),
                'top' => 'required', Rule::unique('templates')->ignore($id),
                'detail' => 'required', Rule::unique('templates')->ignore($id),
            ]);

            // Do template Edit.
            $template = Template::findOrFail($id);
            $template->name = $request->input('name');
            $template->top = $request->input('top');
            $template->detail = $request->input('detail');
            $template->js = $request->input('js');
            $template->css = $request->input('css');
            $template->save();

            $site = Site::firstOrFail();

            // いま設定中のtemplateの場合、即時反映する.
            if ($template->id === $site->template_id) {
                Template::updateTemplateFiles($template);
            }

            return back()->with('success', '更新完了！');

        } catch (ModelNotFoundException $e) {

            Log::warning($e->getMessage());
            Log::warning($e->getTraceAsString());

            return back()->with('error', "ID:{$id}の、テンプレートは存在しません。");

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
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            // Do template Delete.
            Template::destroy($id);

            return redirect('admin/template');

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            return back()->with('error', '削除できませんでした。');

        }
    }
}
