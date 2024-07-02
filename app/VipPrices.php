<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VipPrices extends Model
{
    protected $fillable = [
        'id',
        'service_id',
        'terminal_id',
        'website_id',
        'cal_access_fee',
        'cal_vat',
        'cal_online_fee',
        'cal_booking_fee',
        'cal_fix_rate',
        'is_enable',
        'cal_d1',
        'cal_d2',
        'cal_d3',
        'cal_d4',
        'cal_d5',
        'cal_d6',
        'cal_d7'
      ];
}
