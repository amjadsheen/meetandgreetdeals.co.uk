<?php

namespace App\Http\Controllers\Frontend;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Classes\Domain;
use App\Classes\Edenemail;
use Mail;
use QrCode;
use App\Settings;
use App\Booking;
use App\Customer;
use App\PromotionOffer;
use App\VehicalType;
use App\CarWash;
use App\BookingsEditHistory;
class BookingEditController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        return redirect('/my-bookings')->with('success', 'Select Booking to Edit');
    }

    public function show()
    {
        return redirect('/my-bookings')->with('success', 'Select Booking to Edit');
    }

    public function edit($id)
    {
        //dd('sdasdas');
        $bk_id_c = $id;

        $domain = env('APP_URL');
        $domain = Domain::get_domain_id(1);
        /* ======= Service ======= */
        $services = DB::table('services')
            //->where('disable', '=', 0)
            ->orderByRaw('sort ASC')
            ->get();
        /* ======= Service ======= */
        $terminal_access_options = array(
            'N' => 'Pay Yourself',
            'P' => 'Add Now (Departure & Arrival 25 mins Only)'
        );
        /* ======= Service ======= */
        $settings = $this->get_website_settings($domain->id);
        /* ======= /Service ======= */
        $vehicaltype = VehicalType::all();
        /* ======= Customer ======= */
        $show_login = 1;

        if (isset($_COOKIE["cus_id"])) {
            //$customer_id = $_COOKIE["cus_id"];
            $customer_id = Domain::get_customer_id($_COOKIE["cus_id"]);
            $customer = Customer::find($customer_id);
            if ($customer === null) {
                $show_login = 1;
            } else {
                $show_login = 0;
            }
        } else {
            $customer = array();
        }
        /* ======= /Customer ======= */

        if (isset($bk_id_c)) {
            $booking = Booking::find($bk_id_c);
            if ($booking) {

                $date1 = date('Y-m-d H:i:0');
                $old_date_timestamp = strtr($booking->bk_from_date, '/', '-');
                $old_date_timestamp = strtotime($old_date_timestamp);
                $date2 = date('Y-m-d H:i:0', $old_date_timestamp);
                $timestamp1 = strtotime($date1);
                $timestamp2 = strtotime($date2);
                $hour_lefts = floor(($timestamp2 - $timestamp1) / (60 * 60));
                if ($hour_lefts > 0 && $hour_lefts >= 12) {

                    $bk_details = DB::table("bookings as bb")
                        ->join("terminals as tt", "tt.id", "=", "bb.bk_ou_te")
                        ->join("terminals as t2", "t2.id", "=", "bb.bk_re_te")
                        ->join("currencies as cc", "cc.id", "=", "bb.currency_id")
                        ->join("airports as aa", "aa.id", "=", "bb.airport_id")
                        ->join("services as ss", "ss.id", "=", "bb.service_id")
                        ->join("colors as clrr", "clrr.clr_name", "=", "bb.bk_ve_co")
                        ->where('bb.id', '=', $bk_id_c)
                        ->select("bb.*", "bb.id as booking_id",
                            DB::raw("DATE_FORMAT(bb.bk_from_date, '%d/%m/%Y - %H:%i') as bk_from_date"),
                            DB::raw("DATE_FORMAT(bb.bk_to_date, '%d/%m/%Y - %H:%i') as bk_to_date"),
                            DB::raw("DATE_FORMAT(bb.bk_ve_do_dt, '%d/%m/%Y - %H:%i') as bk_ve_do_dt"),
                            DB::raw("DATE_FORMAT(bb.bk_ve_pu_dt, '%d/%m/%Y - %H:%i') as bk_ve_pu_dt"),
                            "aa.airport_name", "aa.airport_directions", "tt.ter_name", "t2.ter_name as re_ter_name", "cc.cur_symbol", "ss.service_name", "clrr.clr_name")
                        ->first();

                    $colors = DB::table('colors')
                        ->where('clr_disable', '=', 0)
                        ->select("id", "clr_name")
                        ->get();

                    /* ======= countries ======= */
                    $countries = DB::table('countries')
                        //->orderByRaw('sort ASC')
                        ->get();
                    /* ======= /countries ======= */

                    /* ======= selected airport ======= */
                    $selected_airport = DB::table('airports')
                        ->select('id', 'airport_name', 'airport_disable')
                        ->where('country_id', '=', $bk_details->country_id)
                        ->get();
                    /* ======= selected airport ======= */

                    /* ======= selected terminals ======= */
                    $selected_terminals = DB::table('terminals')
                        ->where('airport_id', '=', $bk_details->airport_id)
                        ->get();
                    //dd($selected_terminals);
                    /* ======= selected terminals ======= */

                    /* ======= currencies ======= */
                    $currencies = DB::table('currencies')
                        ->select('id', 'cur_name', 'cur_code', 'cur_symbol', 'cur_rate')
                        ->where('cur_disable', '=', 0)
                        ->get();
                    /* ======= currencies ======= */

                    /* ======= car_washes ======= */
                    $car_washes = DB::table('car_washes')
                        ->select('id', 'website_id', 'vehical_type_id', 'car_wash_type', 'car_wash_price')
                        ->where('website_id', '=', $domain->id)
                        ->get();
                    /* ======= car_washes ======= */

                    $settings['currency'] = $bk_details->cur_symbol;
                    $carwash_selected = $this->get_carwash_veh_type_price($domain->id, $bk_details->vehical_type_id);
                    //dd($bk_details);
                    $page_title = 'Booking Edit';
                    $meta_array = array(
                        'title'=>  strtolower($page_title),
                        'description'=> strtolower($page_title),
                        'keywords'=>strtolower($page_title),
                        'og:locale'=> 'en_US',
                        'og:type'=> 'website',
                        'og:title'=>  strtolower($page_title),
                        'og:url'=>  strtolower($page_title),
                        'twitter:card'=>  strtolower($page_title),
                        'twitter:description' => strtolower($page_title),
                        'twitter:title' => strtolower($page_title),
            
                    );
                    return view($domain->website_templete.'.bookingedit.booking-edit', compact('page_title', 'meta_array', 'services', 'domain', 'colors', 'settings', 'customer', 'show_login', 'bk_details', 'vehicaltype', 'carwash_selected', 'countries', 'selected_terminals', 'selected_airport', 'currencies', 'car_washes', 'terminal_access_options'));

                } else {

                    return redirect('/my-bookings')->with('warning', 'You cannot Modify Booking Now Contact Us For Further Details.');
                }

            } else {

                return redirect('/my-bookings')->with('warning', 'Booking Not Found.');
            }
        } else {

            return redirect('/my-bookings')->with('warning', 'Booking Not Found.');
        }

    }

    public function update(Request $request, $id)
    {

        if ($id) {
            $err = 0;
            $date2Err = "";
            /* ======= Domain ======= */
            $domain = env('APP_URL');
            $domain = Domain::get_domain_id(1);
            /* ======= /Domain ======= */

            /* ======= Settings ======= */
            $settings = $this->get_website_settings($domain->id);
            /* ======= Settings ======= */

            $airport1 = $request->get('airport1');
            $terminal = $request->get('terminal');
            $booking_service = $request->get('service');
            $booking_country = $request->get('country');
            $return_terminal = $request->get('return_terminal');
            $discount_coupon = $request->get('discount_coupon');
            //$terminal_parking_fee = $request->get('terminal_parking_fee');
            //$vip = $request->get('vip');

            $cur_id = $request->get('currency1');

            $var_date1 = $request->get('date1');
            $var_date_exp1 = explode('-', $var_date1);
            $date = str_replace('/', '-', $var_date_exp1[0]);
            $date1 = date('Y-m-d', strtotime($date));
            $var_date_time_1 = explode(':', $var_date_exp1[1]);
            $hour1 = $var_date_time_1[0];
            $min1 = $var_date_time_1[1];

            $var_date2 = $request->get('date2');
            $var_date_exp_2 = explode('-', $var_date2);
            $date = str_replace('/', '-', $var_date_exp_2[0]);
            $date2 = date('Y-m-d', strtotime($date));
            $var_date_time_2 = explode(':', $var_date_exp_2[1]);
            $hour2 = $var_date_time_2[0];
            $min2 = $var_date_time_2[1];



            $price_table = "regular_prices";
            $discount_table = "regular_discounts";
            $time1 = $hour1 . ":" . $min1 . ":00";
            $time2 = $hour2 . ":" . $min2 . ":00";

            if (empty($var_date1)) {  //meeting date/time is empty
                $date2Err = "<br />Meeting date/time is required";
                $err = 1;
            }

            if (empty($var_date2)) { //return date/time is empty
                $date2Err = "<br />Coming back date/time is required";
                $err = 1;
            }

            if (($airport1) == "0") { // if no airport selected $Err = 1
                $date2Err = "<br />Please select an airport";
                $err = 1;
            } else {
                $airport1 = $airport1;
            }


            if (($airport1) <> "0") { // if airport selected but disabled $Err = 2
                $rs_ter_interval = DB::table('airports')
                    ->select('id')
                    ->where('airport_disable', '=', 1)
                    ->where('id', '=', $airport1)
                    ->count();
                if ($rs_ter_interval == 1) {
                    $date2Err = "<br />Airport closed for booking";
                    $err = 1;
                } else {
                    $airport1 = $airport1;
                }
            }

            if (($terminal) == "0") { // if no terminal selected $Err = 4
                $date2Err = "<br />Please select a terminal";
                $err = 1;
            } else {
                $terminal = $terminal;
            }

            if ($booking_service == 0) { // if no terminal selected $Err = 4
                $date2Err = "<br />Please select a Service";
                $err = 1;
            } else {
                $booking_service = $booking_service;
            }

            if ($return_terminal == 0) { // if no terminal selected $Err = 4
                $date2Err = "<br />Please Select Return Terminal";
                $err = 1;
            } else {
                $return_terminal = $return_terminal;
            }

            if ($booking_country == 0) { // if no terminal selected $Err = 4
                $date2Err = "<br />Please Select Country";
                $err = 1;
            } else {
                $booking_country = $booking_country;
            }


            if (($terminal) <> "0") { // if terminal selected but disabled $Err= 5

                $terminals = DB::table('terminals')
                    ->select('id', 'ter_name', 'ter_cap', 'ter_disable')
                    ->where('id', '=', $terminal)
                    ->first();
                if (($terminals->ter_disable) == 1) { // if terminal closed for booking
                    $date2Err = "<br />Terminal closed for booking";
                    $err = 1;
                } elseif ($terminals->ter_disable == 0) // if terminal is active then check the cap
                {
                    $ter_count = DB::table('bookings')
                        ->select('id')
                        ->whereDate('bk_from_date', '>=', $date1 . $time1)
                        ->whereDate('bk_from_date', '<=', $date2 . $time2)
                        ->where('bk_ou_te', '=', $terminal)
                        ->where('bk_status', '=', 2)
                        ->count();
                    if ($ter_count >= $terminals->ter_cap) {
                        $date2Err = "<br />Terminal already booked";
                        $err = 1;
                    } else {
                        $terminal = $terminal;
                    }
                }
            }

            if (strtotime($date1 . $time1) >= strtotime($date2 . $time2)) { // meeting date/time later than return time $Err = 3
                $date2Err = "<br />Invalid Meeting and coming back date/time";
                $err = 1;
            }

            // new variables for early booking
            $rs_ter_interval = DB::table('terminals')
                ->select('ter_interval')
                ->where('id', '=', $terminal)
                ->first();
            $st_hours = $rs_ter_interval->ter_interval;
            $st_mins = $st_hours * 60;

            // CHECKING HOURS DIFFERENCE FOR X HOURS
            $cdatetime = date('Y-m-d H:i:s');
            $interval = date_diff(date_create($date1 . $time1), date_create($cdatetime));
            $int_days = $interval->format('%a');
            $int_hours = 0;
            if ($int_days > 0) {
                $int_hours = $int_days * 24;
            }
            $int_hours = $int_hours + $interval->format('%h');
            $int_mins = $int_hours * 60;
            $int_mins = $int_mins + $interval->format('%i') . " ";

            if (strtotime($cdatetime) >= strtotime($date1 . $time1)) { // $Err = 7
                $date2Err = "<br />Arrival date passed current date";
                $err = 1;
            }

            if (($int_mins < $st_mins) and ($st_hours > 0)) { //$Err = 6
                $date2Err = "<br />Departure too early";
                $err = 1;
            }

            $discount_coupon = $this->set_input($request->get('discount_coupon'));

            if ($err == 0) {

                $discount_applied = 0;
                if (!empty($request->get('discount_coupon'))) {
                    $discount_coupon = $this->set_input($request->get('discount_coupon'));
                    $discount_applied = 1;
                } else {
                    $discount_coupon = "";
                }

                /*===========PRICING CALCULATOR=============*/
                $interval = date_diff(date_create($date1 . $time1), date_create($date2 . $time2));

                $airport_nick_query = DB::table('airports')
                    ->select('airport_nick')
                    ->where('id', '=', $airport1)
                    ->first();
                $airport_nick = $airport_nick_query->airport_nick;


                $bk_date = date('Y-m-d H:i:s');
                $bk_date1 = $date1 . " " . $time1;
                $bk_date2 = $date2 . " " . $time2;
                $int_days = $interval->format('%a') + 1;
                $int_hours = $interval->format('%h');
                $int_mins = $interval->format('%i');



                $price_table = "regular_prices";
                $discount_table = "regular_discounts";
                $rs_cur_rate = DB::table('currencies')
                    ->select('id', 'cur_name', 'cur_code', 'cur_symbol', 'cur_rate')
                    ->where('id', '=', $cur_id)
                    ->first();
                //print_r($cur_id);exit;
                $cur_rate = $rs_cur_rate->cur_rate;
                $cur_symbol = $rs_cur_rate->cur_symbol;

                if ($int_days <= 30) { // if days are less than 30, then select price per day
                    $int_days_less_then_7 = 'cal_d' . $int_days;
                    $gross_price = DB::table('fixed_prices') //Fixed PRICE FROM ANOTHER TABLE TO BOOKING EDIT
                        ->select($int_days_less_then_7)
                        ->where('terminal_id', '=', $terminal)
                        ->where('service_id', '=', $booking_service)
                        ->where('website_id', '=', $domain->id)
                        ->first();

                    $gross_price = number_format($gross_price->$int_days_less_then_7, 2, '.', '');

                } elseif ($int_days > 30) // if days are more than 30, then select price from 7th day + flat rate
                {
                    $fixed_price = DB::table('fixed_prices')
                        ->select('cal_fix_rate', 'cal_d30')
                        ->where('terminal_id', '=', $terminal)
                        ->where('service_id', '=', $booking_service)
                        ->where('website_id', '=', $domain->id)
                        ->first();

                    $price = DB::table($price_table)
                        ->select('cal_fix_rate', 'cal_d30')
                        ->where('terminal_id', '=', $terminal)
                        ->where('service_id', '=', $booking_service)
                        ->where('website_id', '=', $domain->id)
                        ->first();

                    $gross_price = $fixed_price->cal_d30 + ($price->cal_fix_rate * ($int_days - 7));
                    $gross_price = number_format($gross_price, 2, '.', '');
                }
                $gross_price = $gross_price * $cur_rate; // applying currency rate

                // CHECKING AND APPLYING DISCOUNT FOR TERMINAL
                if ($discount_applied == 1) { // if discount is applied

                    $discount_value_rs = DB::table($discount_table)
                        ->select('dis_value')
                        ->where('terminal_id', '=', $terminal)
                        ->where('dis_coupon', '=', $discount_coupon)
                        ->where('dis_active', '=', 1)
                        ->where('website_id', '=', $domain->id)
                        ->first();
                    if ($discount_value_rs) {
                        $discount_value = $discount_value_rs->dis_value;
                        $discount_amount = ($gross_price * $discount_value_rs->dis_value / 100);
                        $discount_amount = number_format($discount_amount, 2, '.', '');
                        $net_price = $gross_price - $discount_amount;
                        $net_price = number_format($net_price, 2, '.', '');
                    } else // if discount is not applied
                    {
                        $discount_value = 0;
                        $discount_amount = 0;
                        $net_price = $gross_price;
                    }

                } else // if discount is not applied
                {
                    $discount_value = 0;
                    $discount_amount = 0;
                    $net_price = $gross_price;
                }

                $pricing = DB::table($price_table)
                    ->select('cal_vat', 'cal_access_fee', 'cal_online_fee', 'cal_booking_fee')
                    ->where('terminal_id', '=', $terminal)
                    ->where('service_id', '=', $booking_service)
                    ->where('website_id', '=', $domain->id)
                    ->first();

                $vat_value = 0;
                $vat_amount = 0;
                $access_fee = 0;

                $online_fee_value = $pricing->cal_online_fee; // get online fee % no need to apply currency conversion

                $booking_fee = $pricing->cal_booking_fee; // get booking fee
                $booking_fee = $booking_fee * $cur_rate; // currency conversion

                $vat_value = $pricing->cal_vat; // % vat value, no need to apply currency conversion.
                $vat_amount = $vat_value / 100 * $net_price; // vat calculation on parking price

                $net_price = $net_price + $vat_amount;   //  add vat
                $net_price = $net_price + $booking_fee; // add booking fee

                $access_fee = $pricing->cal_access_fee;  // get access fee
                $access_fee = $access_fee * $cur_rate;

                //if($terminal_parking_fee == 'P'){
                    if ($access_fee >= 0) {
                        $net_price = $net_price + $access_fee; // add access fee
                    }
              //  }else{
                    //$access_fee = 0;
                //}

                $online_fee_amount = $online_fee_value / 100 * $net_price; // online fee applied on parking price
                $net_price = $net_price + $online_fee_amount;


                /*=========== /PRICING CALCULATOR=============*/

                $bk_id_c = $id;


                $booking_update = Booking::find($bk_id_c);

                /*=========== COPY ROW TO BOOKING BKUP TABLE =============*/
                $this->add_entry_booking_edit_history($booking_update);
                /*=========== /COPY ROW TO BOOKING BKUP TABLE=============*/
                $current_carwash = $booking_update->carwash_in_and_out + $booking_update->carwash_out_only + $booking_update->carwash_in_only;
                $CurrentFinalTotal = $booking_update->bk_total_amount - $booking_update->bk_discount_offer_amount + $current_carwash;


                $booking_update->currency_id = $cur_id;
                $booking_update->bk_vat_value = $vat_value;
                $booking_update->bk_vat_amount = $vat_amount;
                $booking_update->bk_online_fee_value = $vat_amount;
                $booking_update->bk_online_fee_amount = $online_fee_amount;
                $booking_update->bk_booking_fee = $booking_fee;
                $booking_update->bk_access_fee = $access_fee;
                $booking_update->airport_id = $airport1;
                $booking_update->bk_date = $bk_date;
                $booking_update->bk_from_date = $bk_date1;
                $booking_update->bk_to_date = $bk_date2;
                $booking_update->bk_days = $int_days;
                $booking_update->bk_hours = $int_hours;
                $booking_update->bk_mins = $int_mins;
                $booking_update->bk_gross_price = $gross_price;
                $booking_update->bk_discount_value = $discount_value;
                $booking_update->bk_discount_amount = $discount_amount;
                $booking_update->bk_total_amount = $net_price;
                $booking_update->bk_discount_coupon = $discount_coupon;
                $booking_update->bk_ou_te = $terminal;
                $booking_update->bk_vip = 0;
                $booking_update->service_id = $booking_service;
                $booking_update->bk_re_te = $return_terminal;
                $booking_update->country_id = $booking_country;
                //$booking_update->terminal_parking_fee = $terminal_parking_fee;
               


                /*  Not Working Hours*/
                /*$New_Date_To_Compare = $date1 . $time1;
                $currentTime = date("H:i", strtotime($New_Date_To_Compare));
                $currentTime = strtotime($currentTime);
                $not_working_hours_start = $settings['not_working_hours_start'];
                $not_working_mins_start = $settings['not_working_mins_start'];
                $not_working_mins_end = $settings['not_working_mins_end'];
                $not_working_hours_end = $settings['not_working_hours_end'];
                $startTime = strtotime($not_working_hours_start . ':' . $not_working_mins_start);
                $endTime = strtotime($not_working_hours_end . ':' . $not_working_mins_end);
                $not_working_hours_price = $settings['not_working_hours_price'];
                if (($startTime < $endTime && $currentTime >= $startTime && $currentTime <= $endTime) || ($startTime > $endTime && ($currentTime >= $startTime || $currentTime <= $endTime))) {
                    $booking_update->not_working_hours = $not_working_hours_price;
                } else {
                    $booking_update->not_working_hours = 0;
                }*/
                /* Not Working Hours New */
                $booking_update->not_working_hours = Domain::GetNotWorkingHoursPrice($domain->id,  $bk_date1, $bk_date2 );
                /* /Not Working Hours New */
                /* /Not Working Hours */


                /*=====================STEP2===============*/
                /*PickUp DropOff Date*/
                $var_date1 = $request->get('date1');
                $var_date_exp1 = explode('-', $var_date1);
                $date = str_replace('/', '-', $var_date_exp1[0]);
                $date1 = date('Y-m-d', strtotime($date));
                $var_date_time_1 = explode(':', $var_date_exp1[1]);
                $hour1 = $var_date_time_1[0];
                $min1 = $var_date_time_1[1];
                $time1 = $hour1 . ":" . $min1 . ":00";
                $bk_date1 = $date1 . " " . $time1;

                $var_date2 = $request->get('date2');
                $var_date_exp_2 = explode('-', $var_date2);
                $date = str_replace('/', '-', $var_date_exp_2[0]);
                $date2 = date('Y-m-d', strtotime($date));
                $var_date_time_2 = explode(':', $var_date_exp_2[1]);
                $hour2 = $var_date_time_2[0];
                $min2 = $var_date_time_2[1];
                $time2 = $hour2 . ":" . $min2 . ":00";
                $bk_date2 = $date2 . " " . $time2;
                /*PickUp DropOff Date*/

                /* FLIGHT AND VEHICAL DETAILS */
                $OutboundFlightNumber = $this->set_input($request->get('OutboundFlightNumber'));
                $ReturnFlightNumber = $this->set_input($request->get('ReturnFlightNumber'));
                $RegistrationNumber = $this->set_input($request->get('RegistrationNumber'));
                $VehicleMake = $this->set_input($request->get('VehicleMake'));
                $VehicleModel = $this->set_input($request->get('VehicleModel'));
                $VehicleColour = $request->get('VehicleColour');
                $nop = $request->get('nop');


                $booking_update->bk_ou_fl_nu = $OutboundFlightNumber;
                $booking_update->bk_re_fl_nu = $ReturnFlightNumber;
                $booking_update->bk_re_nu = $RegistrationNumber;
                $booking_update->bk_ve_ma = $VehicleMake;
                $booking_update->bk_ve_mo = $VehicleModel;
                $booking_update->bk_ve_co = $VehicleColour;
                $booking_update->bk_nop = $nop;
                $booking_update->bk_ve_do_dt = $bk_date1;
                $booking_update->bk_ve_pu_dt = $bk_date2;

                /* /FLIGHT AND VEHICAL DETAILS */

                /* /=================STEP2============== */
                /*========================== SAVE OLD BOOKING DETAILS ===================*/
                $booking_update->bk_days_b4_update = $booking_update->bk_days .' days ' . $booking_update->bk_hours .' hours and '. $booking_update->bk_mins .' mins';
                $booking_update->bk_amount_b4_update = $booking_update->bk_total_amount + $booking_update->bk_discount_offer_amount;
                /*========================== SAVE OLD BOOKING DETAILS ===================*/


                $carwash = $request->get('cwash');
                $vehical_type_id= $request->get('vehical_type_id');
                if($carwash > 0 && $vehical_type_id > 0 ) {
                    /* ======= car_washes ======= */
                    $booking_update->carwash_out_only = 0;
                    $booking_update->carwash_in_and_out = 0;
                    $booking_update->carwash_in_only = 0;
                    $car_washes_price = CarWash::find($carwash);
                    $ctype= $car_washes_price->car_wash_type;
                    $booking_update->$ctype = $car_washes_price->car_wash_price;
                    $booking_update->vehical_type_id = $vehical_type_id;
                    $net_price += $car_washes_price->car_wash_price;
                }else{
                    $booking_update->carwash_out_only = 0;
                    $booking_update->carwash_in_and_out = 0;
                    $booking_update->carwash_in_only = 0;
                    $booking_update->vehical_type_id = 0;
                }


                /*========================== Payment method Require Again ===================*/
                $MoreAmountPayablbe = 0;
                $redirectionflag = 0;
                $NewFinalTotal = $net_price;
                //echo "---New==>". $NewFinalTotal . " ---OLD ===> ".$CurrentFinalTotal;
                if($NewFinalTotal > $CurrentFinalTotal ){
                    $MoreAmountPayablbe = $NewFinalTotal - $CurrentFinalTotal;
                    $redirectionflag = 1;
                }
                /*========================== /Payment method Require Again===================*/







                /*=====================STEP3===================*/



                        $date = date('Y-m-d H:i:s');
                        $payment_option = $request->get('payment_option');

                        $booking_update->bk_payment_method = $payment_option;
                        $booking_update->bk_date = $date;

                        $TOTAL_PAYABLE_AMOUNT = $MoreAmountPayablbe  + $booking_update->not_working_hours;
                        $TOTAL_PAYABLE_AMOUNT = number_format($TOTAL_PAYABLE_AMOUNT, 2, '.', '');
                        $booking_currency = $this->get_booking_currency($booking_update->currency_id);


                        $booking_update->save();

                        $localDomins = array('http://edenp.co', 'http://edennew.co','http://edenm.co');
                        
                        /* -------------- @new enail template ---------------- */
                        $Email_Template = "email.eden"; //@new enail template
                        if(in_array($domain->website_templete, array('eden'))){ // if eden use eden
                            $Email_Template = "email.".$domain->website_templete;
                        }else{
                            $Email_Template = "email.common";
                        }
                        /* -------------- /@new enail template ---------------- */
                        
                        
                        if(!in_array($domain->website_url, $localDomins)) {


                            /*======================== GET EMAIL CONTENT ===========================*/
                            $data = Edenemail::send_booking_email($bk_id_c);
                            $st_admin_name = Edenemail::get_email_settings('st_admin_name');
                            $st_admin_from_email = Edenemail::get_email_settings('st_admin_from_email');
                            $st_admin_email = Edenemail::get_email_settings('st_admin_email');
                            $st_notification_email = Edenemail::get_email_settings('st_notification_email');
                            $email_subject = Edenemail::get_email_settings('st_edit_booking_subject');
                            /*======================== /GET EMAIL CONTENT ===========================*/

                            if(!in_array($domain->website_templete, array('eden'))){ // if not eden dont use eden
                                $email_subject = str_replace("Eden", $domain->website_name, $email_subject);
                                $st_admin_name =  str_replace("Eden", $domain->website_name, $st_admin_name);
                            }
                            
                            /*======================== EMAIL TO CUSTOMER ===========================*/
                            $to_email = $data['cus_email'];
                            $to_name = $data['cus_title'] . ' ' . $data['cus_name'];
                            Mail::send($Email_Template.'.bookingmail', $data, function ($message) use ($st_admin_from_email, $st_admin_name, $email_subject, $to_email, $to_name) {
                                $message->to($to_email, $to_name)->subject($email_subject);
                                $message->from($st_admin_from_email, $st_admin_name);
                            });
                            /*======================== /EMAIL TO CUSTOMER ===========================*/


                            /*============== TO ADMIN ============*/
                            $to_email = $st_admin_email;
                            $to_name = $st_admin_name;
                            Mail::send($Email_Template.'.bookingmail', $data, function ($message) use ($st_admin_from_email, $st_admin_name, $email_subject, $to_email, $to_name) {
                                $message->to($to_email, $to_name)->subject($email_subject);
                                $message->from($st_admin_from_email, $st_admin_name);
                            });
                            /*============== TO ADMIN ============*/

                            /*============== Notifications Emails ============*/
                            if (!empty($st_notification_email)) {
                                $email_to = explode(";", $st_notification_email);
                                for ($x = 0; $x < count($email_to); $x++) {
                                    Mail::send($Email_Template.'.bookingmail', $data, function ($message) use ($st_admin_from_email, $st_admin_name, $email_subject, $email_to, $to_name) {
                                        $message->to($email_to, $to_name)->subject($email_subject);
                                        $message->from($st_admin_from_email, $st_admin_name);
                                    });
                                }
                            }
                            /*============== Notifications Emails ============*/

                            /*============== EMAIL IF AIRPORT IS LUTON ============*/
                            if ($data['airport_name'] == 'London Luton') {
                                $email_Luton = 'amjadalisheen@yahoo.com';
                                Mail::send($Email_Template.'.bookingmail', $data, function ($message) use ($st_admin_from_email, $st_admin_name, $email_subject, $email_Luton, $to_name) {
                                    $message->to($email_Luton, $to_name)->subject($email_subject);
                                    $message->from($st_admin_from_email, $st_admin_name);
                                });

                                $email_Luton = 'emgparking@gmail.com';
                                Mail::send($Email_Template.'.bookingmail', $data, function ($message) use ($st_admin_from_email, $st_admin_name, $email_subject, $email_Luton, $to_name) {
                                    $message->to($email_Luton, $to_name)->subject($email_subject);
                                    $message->from($st_admin_from_email, $st_admin_name);
                                });
                            }
                            /*============== EMAIL IF AIRPORT IS LUTON ============*/
                        }
                        //$return = $domain->website_url . "/bookingedit/$bk_id_c/edit";
                        $return = $domain->website_url . "/booking-confirmation";
                        //$cancel_return = $domain->website_url . "/bookingedit/$bk_id_c/edit";
                        $cancel_return = $domain->website_url . "/booking-confirmation";
                        $notify_url = $domain->website_url . "/api/ipnn";

                        $data = $payment_option;
                        if ($payment_option == 1) {
                            //$redirect = "/bookingedit/$bk_id_c/edit";
                            $redirect = $domain->website_url . "/booking-confirmation";
                        } elseif ($payment_option == 2) {
                            $querystring = '';

                            //$PayPal_Email_Address = $this->get_global_settings('st_paypal_email');
                            $PayPal_Email_Address = 'extraenterprise@hotmail.com';
                            $querystring .= "?business=$PayPal_Email_Address&";
                            $querystring .= "cmd=_xclick&";
                            $querystring .= "item_name=$booking_update->bk_ref&";
                            $querystring .= "currency_code=$booking_currency&";
                            $querystring .= "amount=$TOTAL_PAYABLE_AMOUNT&";
                            $querystring .= "return=$return&";
                            $querystring .= "notify_url=$notify_url&";
                            $querystring .= "cancel_return=$cancel_return";
                            // $paypallink = "https://www.paypal.com/cgi-bin/webscr".$querystring;
                            $redirect = "https://www.paypal.com/cgi-bin/webscr" . $querystring;

                        } elseif ($payment_option == 3) {
                            $querystring = '';
                            $querystring .= "?instId=1152063&";
                            $querystring .= "cartId=$booking_update->id&";
                            $querystring .= "currency=$booking_currency&";
                            $querystring .= "amount=$TOTAL_PAYABLE_AMOUNT&";
                            $querystring .= "desc=$booking_update->bk_ref&";
                            $querystring .= "testMode=0";
                            $redirect = "https://secure.worldpay.com/wcc/purchase" . $querystring;

                        }

                        if($redirectionflag == 0){
                            $redirect = $domain->website_url . "/booking-confirmation";
                        }
                        /*========================== /STEP3===================*/
                        $this->set_last_booking_refrence($booking_update->id);
                //echo "1";
                return response()->json(['success' => 1, 'data' => 'BOOKING Modified SuccessFully.', 'redirectionflag' => $redirectionflag,  'redirect' => $redirect], 200);
            } else {
                //echo $date2Err;
                $redirect = "";
                //$redirect = $domain->website_url . "/booking-confirmation";
                return response()->json(['success' => 0, 'data' => $date2Err, 'redirectionflag' => 0, 'redirect' => $redirect], 200);
            }

        }

    }

    public function get_carwash_veh_type_price($wid, $tyid)
    {
        if (CarWash::where('website_id', $wid)->where('vehical_type_id', $tyid)->exists()) {
            $carwash = CarWash::where('website_id', $wid)->where('vehical_type_id', $tyid)->orderBy('id', 'DESC')->get();
        } else {
            $carwash = CarWash::where('website_id', 1)->where('vehical_type_id', $tyid)->orderBy('id', 'DESC')->get();
        }
        $response = array();
        foreach ($carwash as $cw) {
            if ($cw->car_wash_type != 'carwash_spray_only') {
                $response[$cw->car_wash_type] = $cw->car_wash_price;
            }
        }
        if (!empty($response)) {
            ksort($response);
        }

        return $response;
    }

    public function get_global_settings($sname)
    {
        $settings = DB::table("settings")
            ->where('website_id', 1)
            ->where('option_name', $sname)
            ->first();
        return $settings->option_value;
    }

    public function set_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function booking_exists_check_by_customer($booking_id, $customer_id)
    {
        $bk_id_row = DB::table('bookings')
            ->select('id', 'customer_id')
            ->where('id', '=', $booking_id)
            ->where('customer_id', '=', $customer_id)
            ->where('bk_status', '=', 0)
            ->first();
        return $bk_id_row;
    }

    public function get_website_settings($id)
    {
        /*$settings_s = Settings::all();
        foreach ($settings_s as $ss){
            $name = $ss->option_name;
            $settings[$name] = $ss->option_value;
        }*/
        $settings_s = DB::table("settings as ss")
            ->leftJoin("websites as ww", "ww.id", "=", "ss.website_id")
            ->where('ss.website_id', $id)
            ->select("ss.*")
            ->get();
        if ($settings_s->isEmpty()) {
            $settings_s = DB::table("settings as ss")
                ->leftJoin("websites as ww", "ww.id", "=", "ss.website_id")
                ->where('ss.website_id', 1)
                ->select("ss.*")
                ->get();
        }

        foreach ($settings_s as $ss) {
            $name = $ss->option_name;
            $settings[$name] = $ss->option_value;
        }

        return $settings;
    }
    public function get_booking_currency($cur_id)
    {
        $rs_cur_rate = DB::table('currencies')
            ->select('id', 'cur_name', 'cur_code', 'cur_symbol', 'cur_rate')
            ->where('id', '=', $cur_id)
            ->first();
        return $rs_cur_rate->cur_code;
    }
    public function add_entry_booking_edit_history($booking_update)
    {
        $bookinghistory = new BookingsEditHistory([
            'booking_id' => $booking_update->id,
            'website_id' => $booking_update->website_id,
            'bk_ref' =>  $booking_update->bk_ref,
            'customer_id' => $booking_update->customer_id,
            'country_id' => $booking_update->country_id,
            'airport_id' => $booking_update->airport_id,
            'bk_date' => $booking_update->bk_date,
            'bk_from_date' => $booking_update->bk_from_date,
            'bk_to_date' => $booking_update->bk_to_date,
            'bk_days' => $booking_update->bk_days,
            'bk_hours' => $booking_update->bk_hours,
            'bk_mins' => $booking_update->bk_mins,
            'currency_id' =>$booking_update->currency_id,
            'bk_gross_price' => $booking_update->bk_gross_price,
            'bk_discount_coupon' => $booking_update->bk_discount_coupon,
            'bk_discount_value' => $booking_update->bk_discount_value,
            'bk_discount_amount' => $booking_update->bk_discount_amount,
            'bk_access_fee' => $booking_update->bk_access_fee,
            'bk_vat_value' => $booking_update->bk_vat_value,
            'bk_vat_amount' => $booking_update->bk_vat_amount,
            'bk_online_fee_value' => $booking_update->bk_online_fee_value,
            'bk_online_fee_amount' => $booking_update->bk_online_fee_amount,
            'bk_booking_fee' => $booking_update->bk_booking_fee,
            'bk_total_amount' => $booking_update->bk_total_amount,
            'bk_discount_offer_coupon' => $booking_update->bk_discount_offer_coupon,
            'bk_discount_offer_value' => $booking_update->bk_discount_offer_value,
            'bk_discount_offer_amount' => $booking_update->bk_discount_offer_amount,
            'bk_final_amount' =>  $booking_update->bk_final_amount,
            'bk_ou_fl_nu' =>  $booking_update->bk_ou_fl_nu,
            'bk_ou_te' =>  $booking_update->bk_ou_te,
            'bk_re_fl_nu' =>  $booking_update->bk_re_fl_nu,
            'bk_re_te' =>  $booking_update->bk_re_te,
            'bk_re_nu' =>  $booking_update->bk_re_nu,
            'bk_ve_ma' =>  $booking_update->bk_ve_ma,
            'bk_ve_mo' =>  $booking_update->bk_ve_mo,
            'bk_ve_co' =>  $booking_update->bk_ve_co,
            'bk_ve_do_dt' =>  $booking_update->bk_ve_do_dt,
            'bk_ve_pu_dt' =>  $booking_update->bk_ve_pu_dt,
            'bk_nop' =>  $booking_update->bk_nop,
            'bk_note' =>  $booking_update->bk_note,
            'bk_agtnote' =>  $booking_update->bk_agtnote,
            'bk_fagtnote' =>  $booking_update->bk_fagtnote,
            'bk_payment_method' =>  $booking_update->bk_payment_method,
            'bk_payment_status' =>  $booking_update->bk_payment_status,
            'bk_status' =>  $booking_update->bk_status,
            'bk_vip' =>  $booking_update->bk_vip,
            'agent_id' =>  $booking_update->agent_id,
            'fwd_agt_id' =>  $booking_update->fwd_agt_id,
            'bk_is_del' =>  $booking_update->bk_is_del,
            'bk_email_flag' =>  $booking_update->bk_email_flag,
            'bk_print_flag' =>  $booking_update->bk_print_flag,
            'carwash_in_and_out' =>  $booking_update->carwash_in_and_out,
            'carwash_out_only' =>  $booking_update->carwash_out_only,
            'carwash_in_only' =>  $booking_update->carwash_in_only,
            'carwash_spray_only' =>  $booking_update->carwash_spray_only,
            'not_working_hours' =>  $booking_update->not_working_hours,
            'service_id' =>  $booking_update->service_id,
            'checkout_status' =>  $booking_update->checkout_status,
            'checkin_status' =>  $booking_update->checkin_status,
            'bk_amount_b4_update' =>  $booking_update->bk_amount_b4_update,
            'bk_days_b4_update' =>  $booking_update->bk_days_b4_update,
            'bk_dates_b4_update' =>  $booking_update->bk_dates_b4_update,
        ]);
        $bookinghistory->save();

    }
    public function set_last_booking_refrence($ref)
    {
        $bk_id_c = Domain::set_encripted_ids($ref);
        setcookie('last_booking_ref', $bk_id_c, time() + 12 * 3600, "/");
    }
}
