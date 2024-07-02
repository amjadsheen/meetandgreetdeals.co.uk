<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $fillable = [
        'id',
        'clr_name',
        'clr_sort',
        'clr_disable'
      ];
}
