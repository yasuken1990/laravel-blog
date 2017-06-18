<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    const PAGINATION = 10;

    protected $fillable = ['title', 'link', 'content'];

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
}
