<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Terminal extends Model
{
    protected $fillable = [
        'id',
        'airport_id',
        'ter_name',
        'ter_cap',
        'ter_gap',
        'ter_interval',
        'ter_disable'
      ];
}
