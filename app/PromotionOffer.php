<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PromotionOffer extends Model
{
    protected $fillable = [
        'id',
        'website_id',
        'offer_coupon',
        'offer_percentage',
        'offer_date1',
        'offer_date2',
        'offer_home',
        'offer_special',
        'offer_active',
        'offer_auto_deactivate',
        'offer_auto_generted',
        'promotion_company_id',
      ];
}
