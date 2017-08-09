<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Site;
use App\Post;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class FrontController extends Controller
{
    const PAGINATION_PER_PAGE = 5;

    //
    public function index()
    {
        $archiveDates = Post::getArchiveDates();

        try {
            $site = Site::firstOrFail();

            if (Auth::check()) {

                $posts = Post::paginate(self::PAGINATION_PER_PAGE);

            } else {

                $posts = Post::where('status', Post::STATUS_PUBLIC)->paginate(self::PAGINATION_PER_PAGE);

            }

            return view('index', compact('site', 'posts', 'archiveDates'));

        } catch (ModelNotFoundException $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            return abort(404);

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            return abort(404);
        }
    }

    public function archive($date = NULL)
    {
        try {

            $archiveDates = Post::getArchiveDates();

            $site = Site::firstOrFail();

            $pattern = '^([1-9][0-9]{3})-([0-1][0-9])';

            // YYYY-MM チェック
            if (preg_match("#{$pattern}#", $date, $match)) {
                if (!checkdate($match[2], 1, $match[1])) {
                    $date = NULL;
                }
            } else {
                // GETで 年月が渡って来なかったら、現在年月を適用するためにNULLを格納する
                $date = NULL;
            }

            // GETで YYYY-MM が指定されない時は、現在の月が適用される abortでもいいけど...
            if ($date === NULL) {
                $startDate = Carbon::now()->format('Y-m-01');
                $endDate = Carbon::now()->endOfMonth()->format('Y-m-d');
            } else {
                $dt = new Carbon($date);
                $startDate = $dt->format('Y-m-01');
                $endDate = $dt->endOfMonth()->format('Y-m-d');
            }

            if (Auth::check()) {

                $posts = Post::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . '-31 23:59:59'])
                    ->paginate(self::PAGINATION_PER_PAGE);

            } else {

                $posts = Post::where('status', Post::STATUS_PUBLIC)
                    ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                    ->paginate(self::PAGINATION_PER_PAGE);

            }

        } catch (ModelNotFoundException $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            return abort(404);

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            return abort(404);

        }

        return view('index', compact('site', 'posts', 'archiveDates'));

    }

}
