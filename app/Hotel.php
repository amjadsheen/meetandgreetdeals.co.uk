<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    protected $fillable = [
        'id',
        'airport_id',
        'htl_name',
        'htl_disable',
      ];
}
