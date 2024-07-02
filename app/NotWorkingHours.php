<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotWorkingHours extends Model
{
    protected $fillable = [
        'id',
        'website_id',
        'not_working_start_time',
        'not_working_end_time',
        'charges'
      ];
}
