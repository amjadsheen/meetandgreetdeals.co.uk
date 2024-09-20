<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TerminalCharge extends Model
{
    protected $fillable = [
        'id',
        'airport_id',
        'departure_terminal',
        'arrival_terminal',
        'extra_charges',
        'status'
      ];
}
