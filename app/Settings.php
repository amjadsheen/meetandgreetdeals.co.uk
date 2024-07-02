<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $fillable = [
        'website_id',
        'option_name',
        'option_type',
        'option_value',
        'autoload',
        'disable'
      ];
}
