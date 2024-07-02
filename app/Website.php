<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    protected $fillable = [
        'id',
        'website_name',
        'website_url',
        'website_prefix',
        'website_templete',
        'website_logo',
        'website_banner',
        'website_favicon',
        'website_email_banner',
        'email',
        'alternate_email',
        'contact_num',
        'alternate_contact_num',
        'address',
        'working_time',
        'facebook',
        'twitter',
        'website_meta_title',
        'website_meta_description',
        'website_meta_keywords',
        'disable'
      ];
}
