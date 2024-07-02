<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blacklists extends Model
{
    protected $fillable = [
        'id',
        'bl_data',
        'bl_type',
        'bl_datetime',
        'bl_attempts',
        'bl_remarks'
      ];
}
