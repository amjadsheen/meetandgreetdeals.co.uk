<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarWash extends Model
{
    protected $fillable = [
        'website_id',
        'vehical_type_id',
        'car_wash_type',
        'car_wash_price'
      ];
}
