<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PromotionOfferCustomer extends Model
{
    protected $fillable = [
        'id',
        'promotion_offer_id',
        'customer_booking_ref',
        'customer_id',
        'customer_name',
        'customer_email',
        'customer_contact1',
        'customer_contact2',
        'customer_car_reg',
        'promo_used_date'
      ];
}
