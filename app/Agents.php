<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agents extends Model
{
    protected $fillable = [
        'id',
        'agt_datetime',
        'agt_mcompany',
        'agt_email',
        'agt_company',
        'agt_compreg',
        'agt_p1fname',
        'agt_p1surname',
        'agt_p1mobile1',
        'agt_p1mobile2',
        'agt_p2fname',
        'agt_p2surname',
        'agt_p2mobile1',
        'agt_p2mobile2',
        'agt_p3fname',
        'agt_p3surname',
        'agt_p3mobile1',
        'agt_p3mobile2',
        'agt_address',
        'agt_city',
        'agt_county',
        'agt_postcode',
        'agt_note',
        'agt_commision',
        'agt_fee',
    ];
}
