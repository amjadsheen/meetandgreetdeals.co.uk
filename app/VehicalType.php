<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehicalType extends Model
{
    protected $fillable = [
        'v_name',
        'disabled',
        'v_image',
      ];
}
