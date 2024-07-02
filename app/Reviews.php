<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
    protected $fillable = [
        'id',
        'website_id',
        'post_title',
        'fname',
        'surname',
        'email',
        'mobile',
        'booking_refrence',
        'rate',
        'review',
        'review_date',
        'disable'
      ];
}
