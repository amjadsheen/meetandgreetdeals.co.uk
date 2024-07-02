<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerAccount extends Model
{
    protected $fillable = [
        'id',
        'account_num',
        'customer_id',
        'status',
        'customer_email'
      ];
}
