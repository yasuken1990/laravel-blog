<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Faker\Provider\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Intervention\Image\Facades\Image;
use Intervention\Image\Exception\NotReadableException;
use Illuminate\Support\Facades\Log;

class ImageController extends Controller
{

    const PAGINATION_PER_PAGE = 5;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $images = \App\Image::paginate(self::PAGINATION_PER_PAGE);

        return view('admin.images.index', compact('images'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

            $input = Input::all();
            $file = $request->file('fileName');

            if ($file === NULL) {

                return back()->with('error', '画像が選択されていません！');

            }

            $fileName = $file->getClientOriginalName();

            $image = Image::make($input['fileName']);
            $image->save(public_path() . '/images/' . $fileName);

            if ($request->file('fileName')->isValid()) {

                $imageClient = \App\Image::firstOrCreate(['name' => $fileName]);
                return back()->with('success', '画像をアップロードしました！')->with('imgId', $imageClient->id);

            } else {

                return back()->with('error', '画像のアップロードに失敗しました！');

            }
        } catch (NotReadableException $e) {
            Log::warning($e->getMessage());
            Log::warning($e->getTraceAsString());
            Log::warning(print_r($request->toArray(), true));

            return back()->with('error', '画像ファイルではありません！');

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            return back()->with('error', 'System error has occured. Please contact the system administrator.！');

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
        //
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
        //
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
            $image = \App\Image::find($id);

            if (\File::exists(public_path() . '/images/' . $image->name)) {
                \File::delete(public_path() . '/images/' . $image->name);
            }

            foreach ($image->posts as $post) {
                $post->content = $this->destroyImages($post->content);
                $post->save();
            }

            \App\Image::destroy($id);

            return redirect('admin/image');

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            return back()->with('error', '削除できませんでした。');

        }
    }

    public function destroyImages($content)
    {
        $pattern = "#<img src=\".+?/images/(.+?)\" />#";
        if(preg_match_all($pattern, $content,$matches)) {
            foreach ($matches[0] as $imageTag) {
                $content = str_replace($imageTag,'', $content);
            }
            return $content;
        } else {
            return $content;
        }
    }
}
