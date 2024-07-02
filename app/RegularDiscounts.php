<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegularDiscounts extends Model
{
    protected $fillable = [
        'id',
        'terminal_id',
        'service_id',
        'website_id',
        'dis_coupon',
        'dis_value',
        'dis_active'
      ];
}
