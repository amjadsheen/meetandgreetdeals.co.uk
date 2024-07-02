<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Airport extends Model
{
    protected $fillable = [
        'id',
        'country_id',
        'airport_nick',
        'airport_name',
        'airport_directions'
      ];
}
