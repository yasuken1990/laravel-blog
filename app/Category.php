<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    const PAGINATION = 10;

    protected $fillable = ['name'];

}
