<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Locations extends Model
{
    protected $fillable = [
        'id',
        'yard_id',
        'loc_name',
        'loc_occupied',
        'loc_disable'
      ];
}
