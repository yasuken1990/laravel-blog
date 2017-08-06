<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $fillable = ['name', 'top', 'detail', 'js', 'css'];

    public static function updateTemplateFiles(Template $template)
    {
        file_put_contents(base_path('resources/views/index.blade.php'), $template->top);
        file_put_contents(base_path('resources/views/posts/detail.blade.php'), $template->detail);
        file_put_contents(public_path('js/main.js'), $template->js);
        file_put_contents(public_path('css/main.css'), $template->css);
    }
}
