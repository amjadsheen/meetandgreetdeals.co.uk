<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Direction extends Model
{
    protected $fillable = [
        'id',
        'title',
        'slug',
        'image',
        'content',
        'terminal_1',
        'terminal_2',
        'terminal_3',
        'terminal_4',
        'terminal_5',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'sort',
        'disable',
      ];
}
