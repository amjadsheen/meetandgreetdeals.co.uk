<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mileage extends Model
{
    protected $fillable = [
        'id',
        'driver_id',
        'booking_id',
        'mileage_type',
        'mileage'
      ];
}
