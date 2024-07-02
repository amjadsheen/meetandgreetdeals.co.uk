<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Drivers extends Model
{
    protected $fillable = [
        'id',
        'drv_firstname',
        'drv_surname',
        'drv_familyname',
        'drv_username',
        'drv_password',
        'drv_dob',
        'drv_nin',
        'drv_dln',
        'drv_issuedate',
        'drv_ed',
        'drv_mobile1',
        'drv_mobile2',
        'drv_landline',
        'drv_didn',
        'drv_photo',
        'drv_licensephoto',
        'drv_address',
        'drv_city',
        'drv_county',
        'drv_postcode',
        'drv_email',
        'airport_id',
        'drv_nok_firstname',
        'drv_nok_surname',
        'drv_nok_familyname',
        'drv_nok_mobile1',
        'drv_nok_mobile2',
        'drv_nok_landline',
        'drv_nok_address',
        'drv_nok_city',
        'drv_nok_county',
        'drv_nok_postcode',
        'drv_nok_email',
        'drv_nok_relation',
        'drv_disable',
    ];
}
