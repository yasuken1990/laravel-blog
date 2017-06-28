<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    const PAGINATION = 10;
    const STATUS_PRIVATE = 0;
    const STATUS_PUBLIC = 1;

    protected $fillable = ['title', 'link', 'content', 'status', 'tag_id', 'category_id', 'content'];

    //
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function tags()
    {
        return $this->morphToMany('App\Tag', 'taggable');
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    /**
     * TODO: fix
     * スコープが・・
     * public static function かな。
     * でもgetStatusって言ったら、ひとつのインスタンスのstatusを返しそうだけどね。
     * gitlabの他のプログラムをみて、よりよい方法に変えてください。
     */
    static function getStatus()
    {
        return collect([
            self::STATUS_PRIVATE => '非公開',
            self::STATUS_PUBLIC => '公開'
        ]);
    }
}
