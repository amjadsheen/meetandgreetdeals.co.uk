<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = [
        'id',
        'website_id',
        'news',
        'sort',
        'disable'
      ];
}
