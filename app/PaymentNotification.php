<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentNotification extends Model
{
    protected $fillable = [
        'id',
        'booking_id',
        'payment_reciever',
        'payment_status',
        'mc_gross',
        'txn_id',
        'item_name',
        'log',
      ];
}
