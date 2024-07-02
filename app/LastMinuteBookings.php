<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LastMinuteBookings extends Model
{
    protected $fillable = [
        'id',
        'website_id',
        'hour',
        'charges'
      ];
}
