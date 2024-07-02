<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Yards extends Model
{
    protected $fillable = [
        'id',
        'airport_id',
        'yrd_name',
        'yrd_disable'
      ];
}
