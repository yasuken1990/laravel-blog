<?php

namespace App\Http\Controllers;

use App\Category;
use Carbon\Carbon;
use function foo\func;
use Illuminate\Http\Request;
use App\Site;
use App\Post;
use App\Tag;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class FrontController extends Controller
{
    const PAGINATION_PER_PAGE = 5;

    //
    public function index()
    {
        try {

            $archiveDates = Post::getArchiveDates();
            list($calendar, $year, $month) = $this->getCalendar();

            $site = Site::firstOrFail();

            if (Auth::check()) {

                $posts = Post::paginate(self::PAGINATION_PER_PAGE);

            } else {

                $posts = Post::where('status', Post::STATUS_PUBLIC)->paginate(self::PAGINATION_PER_PAGE);

            }

            return view('index', compact('site', 'posts', 'archiveDates', 'calendar', 'year', 'month'));

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

    public function search(Request $request)
    {
        try {

            $keyword = $request->input('keyword');

            $archiveDates = Post::getArchiveDates();
            list($calendar, $year, $month) = $this->getCalendar();


            $site = Site::firstOrFail();

            $categoryIds = Category::where('name', 'like', "%{$keyword}%")->get(['id'])->toArray();

            $tagIds = Tag::where('name', 'like', "%{$keyword}%")->get();

            $tagPostIds = [];
            foreach ($tagIds as $tag) {
                foreach ($tag->posts as $key => $post) {
                    $tagPostIds[] = $post->id;
                }
            }
            $query = Post::query();
            $query->where('status', Post::STATUS_PUBLIC)
                ->where(function ($post) use ($keyword, $categoryIds, $tagPostIds) {
                    $post->orWhere('title', 'like', "%{$keyword}%")
                        ->orWhere('content', 'like', "%{$keyword}%")
                        ->whereIn('category_id', $categoryIds)
                        ->whereIn('id', $tagPostIds);

                });

            if (Auth::check()) {

                $posts = $query::paginate(self::PAGINATION_PER_PAGE);

            } else {

                $posts = $query->paginate(self::PAGINATION_PER_PAGE);

            }

            return view('index', compact('site', 'posts', 'archiveDates', 'calendar', 'year', 'month'));

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

    public function archiveDay($date = NULL)
    {
        try {

            $archiveDates = Post::getArchiveDates();
            list($calendar, $year, $month) = $this->getCalendar();

            $site = Site::firstOrFail();

            $pattern = '^([1-9][0-9]{3})-([0-1][0-9])-([0-3][0-9])';

            // YYYY-MM-DD チェック
            if (preg_match("#{$pattern}#", $date, $match)) {
                if (!checkdate($match[2], 1, $match[1])) {
                    return back();
                }
            } else {
                return back();
            }

            $startDate = Carbon::parse($date)->format('Y-m-d 00:00:00');
            $endDate = Carbon::parse($date)->format('Y-m-d 23:59:59');

            if (Auth::check()) {

                $posts = Post::whereBetween('created_at', [$startDate, $endDate])
                    ->paginate(self::PAGINATION_PER_PAGE);

            } else {

                $posts = Post::where('status', Post::STATUS_PUBLIC)
                    ->whereBetween('created_at', [$startDate, $endDate])
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

        return view('index', compact('site', 'posts', 'archiveDates', 'calendar', 'year', 'month'));

    }


    public function archive($date = NULL)
    {
        try {

            $archiveDates = Post::getArchiveDates();
            list($calendar, $year, $month) = $this->getCalendar();

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

        return view('index', compact('site', 'posts', 'archiveDates', 'calendar', 'year', 'month'));

    }

    public function getCalendar()
    {

        foreach (Post::getArchivePostsDates() as $date => $post) {
            $day = (int)Carbon::parse($post['created_at'])->format('j');
            $postDate[$day] = Carbon::parse($post['created_at'])->format('Y-m-d');
        }

        $year = Carbon::now()->format('Y');
        $month = Carbon::now()->format('m');

        $last_day = date('j', mktime(0, 0, 0, $month + 1, 0, $year));

        $calendar = array();
        $j = 0;

        for ($i = 1; $i < $last_day + 1; $i++) {

            $week = date('w', mktime(0, 0, 0, $month, $i, $year));

            if ($i == 1) {

                for ($s = 1; $s <= $week; $s++) {

                    $calendar[$j]['day'] = '';
                    $calendar[$j]['post'] = false;
                    $j++;

                }

            }

            $calendar[$j]['day'] = $i;

            if (isset($postDate) && array_key_exists($i, $postDate)) {
                $calendar[$j]['post'] = true;
                $calendar[$j]['date'] = $postDate[$i];
            } else {
                $calendar[$j]['post'] = false;
            }

            $j++;

            if ($i == $last_day) {

                for ($e = 1; $e <= 6 - $week; $e++) {

                    $calendar[$j]['day'] = '';
                    $calendar[$j]['post'] = false;
                    $j++;

                }

            }

        }

        return array($calendar, $year, $month);

    }
}
