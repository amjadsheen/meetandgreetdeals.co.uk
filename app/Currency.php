<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $fillable = [
        'id',
        'cur_name',
        'cur_code',
        'cur_symbol',
        'cur_rate',
        'cur_sort',
        'cur_disable',
      ];
}
