<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    protected $fillable = [
        'id',
        'service_name',
        'slug',
        'service_image',
        'service_details',
        'sort',
        'disable'
      ];
}
