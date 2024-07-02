<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'id',
        'title',
        'slug',
        'image',
        'content',
        'content_left',
        'content_right',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'sort',
        'disable',
    ];
}
