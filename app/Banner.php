<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'id',
        'website_id',
        'tag',
        'image',
        'price',
        'sort',
        'disable'
      ];
}
