<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'id',
        'cus_title',
        'cus_name',
        'cus_email',
        'cus_email_1',
        'cus_password',
        'cus_company',
        'cus_surname',
        'cus_tele',
        'cus_cell',
        'cus_cell2',
        'cus_homename',
        'cus_address',
        'cus_town',
        'cus_county',
        'cus_postcode',
        'cus_country',
        'cus_oneoff',
        'cus_status'
      ];
}
//ALTER TABLE `bookings` ADD `ulze` VARCHAR(55) NULL AFTER `luggage`;
//not_working_hours
//ALTER TABLE `customers` ADD `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `cus_status`, ADD `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`;
//ALTER TABLE `bookings` ADD `customer_contact` varchar(191) NULL DEFAULT NULL AFTER `customer_id`;
//ALTER TABLE `car_washes` ADD `status` NOT NULL DEFAULT '1' AFTER `car_wash_price`;

//ALTER TABLE `bookings` ADD `bank_transition_refernce` varchar(191) NULL DEFAULT NULL AFTER `account_num`;



//ALTER TABLE `promotion_offers` ADD `show_compare_page` INT(3) NOT NULL DEFAULT '0' AFTER `offer_home`;
// ALTER TABLE `websites` ADD `show_homepage` INT(3) NOT NULL DEFAULT '0' AFTER `websites`;
// ALTER TABLE `websites` ADD `show_link` INT(3) NOT NULL DEFAULT '0' AFTER `show_homepage`;



// ALTER TABLE `websites` ADD `show_link` INT(3) NOT NULL DEFAULT '0' AFTER `show_homepage`;

/*
ALTER TABLE `websites`
ADD `supplier_cost_type` ENUM('percentage', 'fixed', 'none') NOT NULL DEFAULT 'percentage' AFTER `show_homepage`,
ADD `supplier_cost_value` INT NOT NULL AFTER `supplier_cost_type`;
*/



/*
ALTER TABLE `bookings` ADD `terminal_extra_charges` INT(3) NOT NULL DEFAULT '0' AFTER `last_min_booking`;
*/