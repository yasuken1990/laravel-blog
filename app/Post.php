<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    const PAGINATION = 10;
    const STATUS_PRIVATE = 0;
    const STATUS_PUBLIC = 1;

    protected $fillable = ['title', 'link', 'content', 'status', 'tag_id', 'category_id', 'content'];

    public static $statusLabels = [
        self::STATUS_PRIVATE => '非公開',
        self::STATUS_PUBLIC => '公開',
    ];

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

    public function getStatusLabel()
    {
        return self::$statusLabels[$this->status];
    }
}
