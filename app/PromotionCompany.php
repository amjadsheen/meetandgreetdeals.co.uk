<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PromotionCompany extends Model
{
    protected $fillable = [
        'id',
        'company_name',
        'company_contact'
      ];
}
