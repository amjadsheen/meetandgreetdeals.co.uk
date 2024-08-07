<?php

namespace App\Http\Controllers\Frontend;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Classes\Domain;
use App\Classes\Edenemail;
use Mail;
use QrCode;
use App\Settings;
use App\Booking;
use App\Customer;
use App\Services;
use App\PromotionOffer;
use App\VehicalType;
use App\CarWash;
use App\PaymentNotification;
use Stripe;

class BookingController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index(Request $request)
    {
        //die("KKKK");
        $request_data = $request->all();
        $domain = env('APP_URL');
        $domain = Domain::get_domain_id(1);
        /* ======= Service ======= */
        $services = DB::table('services')
            //->where('disable', '=', 0)
            ->orderByRaw('sort ASC')
            ->get();
        /* ======= Service ======= */
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

        if (isset($request_data) && !empty($request_data) && Domain::checkRequestData($request_data)) {
            //$bk_id_c = $_COOKIE["bk_id"];
            
            $bk_id_c = Domain::get_booking_id($_COOKIE["bk_id"]);
            $booking = Booking::find($bk_id_c);
            if ($booking) {
                $bk_details = DB::table("bookings as bb")
                    ->join("terminals as tt", "tt.id", "=", "bb.bk_ou_te")
                    ->join("currencies as cc", "cc.id", "=", "bb.currency_id")
                    ->join("airports as aa", "aa.id", "=", "bb.airport_id")
                    ->join("services as ss", "ss.id", "=", "bb.service_id")
                    ->where('bb.id', '=', $bk_id_c)
                    ->select(
                        "bb.*",
                        DB::raw("DATE_FORMAT(bb.bk_from_date, '%d/%m/%Y - %H:%i') as bk_from_date"),
                        DB::raw("DATE_FORMAT(bb.bk_ve_do_dt, '%d/%m/%Y - %H:%i') as bk_ve_do_dt"),
                        DB::raw("DATE_FORMAT(bb.bk_to_date, '%d/%m/%Y - %H:%i') as bk_to_date"),
                        DB::raw("DATE_FORMAT(bb.bk_ve_pu_dt, '%d/%m/%Y - %H:%i') as bk_ve_pu_dt"),
                        "aa.airport_name",
                        "aa.airport_directions",
                        "tt.ter_name",
                        "cc.cur_symbol",
                        "ss.service_name"
                    )
                    ->first();

                $html = $this->update_cart($bk_id_c);
                $html_price_only = $this->update_cart_price_only($bk_id_c);
                $colors = DB::table('colors')
                    ->where('clr_disable', '=', 0)
                    ->select("id", "clr_name")
                    ->get();

                $settings['currency'] = $bk_details->cur_symbol;
                $carwash_selected = $this->get_carwash_veh_type_price($domain->id, $bk_details->vehical_type_id);

                $page_title = 'Booking';
                $meta_array = array(
                    'title' =>  strtolower($page_title),
                    'description' => strtolower($page_title),
                    'keywords' => strtolower($page_title),
                    'og:locale' => 'en_US',
                    'og:type' => 'website',
                    'og:title' =>  strtolower($page_title),
                    'og:url' =>  strtolower($page_title),
                    'twitter:card' =>  strtolower($page_title),
                    'twitter:description' => strtolower($page_title),
                    'twitter:title' => strtolower($page_title),

                );
                $skey = env('STRIPE_KEY');
                return view($domain->website_templete . '.booking', compact('page_title', 'meta_array', 'services', 'domain', 'html', 'html_price_only', 'colors', 'settings', 'customer', 'show_login', 'bk_details', 'skey', 'vehicaltype', 'carwash_selected'));
            } else {

                return redirect('/')->with('success', 'Please Complete intitial bookng step.');
            }
        } else {

            return redirect('/')->with('success', 'Please Complete intitial bookng step.');
        }
    }

   public function ValidateBookingDates($vehicles)
    {
        //dd($vehicles);
        $Err = [];
        $airport1 = $vehicles['airport1'];
        $terminal = $vehicles['terminal'];
        $service = $vehicles['service'];
        //dd($vehicles);
        foreach($vehicles['vehicles'] as $key=>$veh){
            $domain = env('APP_URL');
            $domain = Domain::get_domain_id(1);

            /* ======= Settings ======= */
            $settings = $this->get_website_settings($domain->id);
            /* ======= Settings ======= */

            $var_date1 = $veh['date1'];
            $var_date_exp1 = explode('-', $var_date1);
            $date = str_replace('/', '-', $var_date_exp1[0]);
            $date1 = date('Y-m-d', strtotime($date));
            $var_date_time_1 = explode(':', $var_date_exp1[1]);
            $hour1 = $var_date_time_1[0];
            $min1 = $var_date_time_1[1];

            $var_date2 = $veh['date2'];
            $var_date_exp_2 = explode('-', $var_date2);
            $date = str_replace('/', '-', $var_date_exp_2[0]);
            $date2 = date('Y-m-d', strtotime($date));
            $var_date_time_2 = explode(':', $var_date_exp_2[1]);
            $hour2 = $var_date_time_2[0];
            $min2 = $var_date_time_2[1];

            $time1 = $hour1 . ":" . $min1 . ":00";
            $time2 = $hour2 . ":" . $min2 . ":00";
            

            $rs_ter_interval = DB::table('terminals')
                ->select('ter_interval')
                ->where('id', '=', $terminal)
                ->first();
            $st_hours = $rs_ter_interval->ter_interval;
            $st_mins = $st_hours * 60;

            // CHECKING HOURS DIFFERENCE FOR X HOURS
            $cdatetime = date('Y-m-d H:i:s');;
            $interval = date_diff(date_create($date1 . $time1), date_create($cdatetime));
            $int_days = $interval->format('%a');
            $int_hours = 0;
            if ($int_days > 0) {
                $int_hours = $int_days * 24;
            }
            $int_hours = $int_hours + $interval->format('%h');
            $int_mins = $int_hours * 60;
            $int_mins = $int_mins + $interval->format('%i') . " ";

            // Checking for errors
            $airport_disable = 0;
            $rs_ter_interval = DB::table('airports')
                ->select('id')
                ->where('airport_disable', '=', 1)
                ->where('id', '=', $airport1)
                ->count();
            if ($rs_ter_interval == 1) {
                $airport_disable = 1; // airport closed/disabled
            }

            // check if terminal is closed for booking by admin
            $terminal_disable = 0;
            $terminals = DB::table('terminals')
                ->select('id', 'ter_name', 'ter_cap', 'ter_disable')
                ->where('id', '=', $terminal)
                ->first();
            if (($terminals->ter_disable) == 1) { // if terminal closed for booking
                $terminal_disable = 1; // terminal closed/disabled
            }

            // check if terminal is over booked
            /*======= Terminal over booked Check ======*/
            $terminal_booked = 0;
            $ter_count = DB::table('bookings')
                ->select('id')
                ->whereDate('bk_from_date', '>=', $date1 . $time1)
                ->whereDate('bk_from_date', '<=', $date2 . $time2)
                ->where('bk_ou_te', '=', $terminal)
                ->where('bk_status', '=', 2)
                ->count();
            if ($ter_count >= $terminals->ter_cap) {
                $terminal_booked = 1;
            }
            /*======= Terminal over booked Check ======*/


            //service disable check
            $service_disabled = $this->is_service_disabled($service);

            if ($airport1 == 0) {
                $Err[] = "Select airport"; // no airport selected
            }
            if ($airport_disable == 1) {
                $Err[] = "Airport closed for booking"; // airport closed/disabled
            }
            if ($terminal == 0) {
                $Err[] = "Select terminal"; // no terminal selected
            }
            if ($terminal_disable == 1) {
                $Err[] = "Terminal closed for booking"; // terminal disable/closed
            }
            if (($int_mins < $st_mins) and ($st_hours > 0)) {
                //print_r($int_mins.'---'.$st_mins .'---'.$st_hours);exit;
                $Err[] = "Departure date/time too close"; // interval between booking in less than X hours
            }
            if (strtotime($date1 . $time1) >= strtotime($date2 . $time2)) {
                $Err[] = "Vehicle $key Select proper dates"; // datetime1 is greater than datetime2
            }
            if (strtotime($cdatetime) >= strtotime($date1 . $time1)) {
                $Err[] = "Vehicle $key Current date/time past departure date/time"; // arrival datetime passed current datetime
            }
            if ($terminal_booked == 1) {
                $Err[] = "Vehicle $key Space not available on these date(s)"; // terminal over booked
            }
            if ($service == 0) {
                $Err[] = "Please Select Service"; // Service
            }
            if ($service_disabled == 1) {
                $Err[] = "Service Not Available"; // Service disabled
            }
            if (empty($veh['bk_re_nu'])) {
               // $Err[] = "Vehicle $key Reg Number Required"; // Service disabled
            }
            if (empty($veh['v_contact_num'])) {
                //$Err[] = "Vehicle $key Contact Number Required"; // Service disabled
            }
        }
        return $Err;
    }
    public function CompareBooking(Request $request)
    {
       
        $requset_data = $request->all();
        
        if(empty($requset_data)){
            return redirect('/')->with('success', 'Please Review booking details.');
        }
        $all_services = 0;
        if (isset($requset_data['all_services']) && !empty($requset_data['all_services'])) {
            $all_services = 1;
        }
       //dd($requset_data);
        //Domain::AddNewFiledToSession('terminal_parking_fee', 'P');
        $prepared_session_data = Domain::SetSessionData($requset_data);
        //dd($prepared_session_data);
        // Add vehical array to the request data
        session(['booking_data' => $prepared_session_data]);
        $booking_data = session('booking_data');

        $domain =  env('APP_URL');
        $domain = Domain::get_domain_id(1);
        $Err = $this->ValidateBookingData($request);
        
        /* ======= Service ======= */
        $countries = DB::table('countries')
            //->orderByRaw('sort ASC')
            ->get();
        /* ======= Service ======= */

        $terminal_access_options = array(
            // 'N' => 'Pay Yourself Terminal Access fee ( Drop of Chargers) upon Departure and Arrival.',
            'N' => 'Customer are responsible to pay Terminal fee upon Departure and Arrival(Not Added)',
            'P' => 'Add Now (Departure & Arrival 25 mins Only)',
            

        );
        $vehical_selction = array(
            // 'N' => 'Pay Yourself Terminal Access fee ( Drop of Chargers) upon Departure and Arrival.',
            '1' => '1',
            '2' => '2',
            '3' => '3',
            '4' => '4',
            '5' => '5',

        );

         /* ======= airport ======= */
         $airports = DB::table('airports')
         ->select('id', 'airport_name', 'airport_disable')
         ->where('airport_disable', '=', 0)
         ->get();
     /* ======= airport ======= */

     /* ======= currencies ======= */
     $currencies = DB::table('currencies')
         ->select('id', 'cur_name', 'cur_code', 'cur_symbol', 'cur_rate')
         ->where('cur_disable', '=', 0)
         ->get();
     /* ======= currencies ======= */



     

     /* ======= Settings ======= */
        
     $settings = $this->get_website_settings($domain->id);
        /* ======= Service ======= */
        $services = DB::table('services')
            //->where('disable', '=', 0)
            ->orderByRaw('sort ASC')
            ->get();
        /* ======= Service ======= */

        $html = "";
        /* ======= Settings ======= */
        
        /* ======= Settings ======= */
        
        $discount_applied = 0;
        $airport1 = $request->get('airport1');
        $terminal = $request->get('terminal');
        $selected_termainal =  $request->get('terminal');
        $selected_service = $request->get('service');
        $terminal_parking_fee = $request->get('terminal_parking_fee');
        $vehical_num = $request->get('vehical_num');
        //$country = $request->get('country');
        $bookingeditpage = $request->get('bookingeditpage');
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

        $cur_id = 1;
        $discount_coupon = $request->get('discount_coupon');
        $time1 = $hour1 . ":" . $min1 . ":00";
        $time2 = $hour2 . ":" . $min2 . ":00";

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

        // Checking for errors
        $airport_disable = 0;
        $rs_ter_interval = DB::table('airports')
            ->select('id')
            ->where('airport_disable', '=', 1)
            ->where('id', '=', $airport1)
            ->count();
        if ($rs_ter_interval == 1) {
            $airport_disable = 1; // airport closed/disabled
        }

        // check if terminal is closed for booking by admin
        $terminal_disable = 0;
        $terminals = DB::table('terminals')
            ->select('id', 'ter_name', 'ter_cap', 'ter_disable')
            ->where('id', '=', $terminal)
            ->first();
        if (($terminals->ter_disable) == 1) { // if terminal closed for booking
            $terminal_disable = 1; // terminal closed/disabled
        }

        // check if terminal is over booked
        /*======= Terminal over booked Check ======*/
        $terminal_booked = 0;
        $ter_count = DB::table('bookings')
            ->select('id')
            ->whereDate('bk_from_date', '>=', $date1 . $time1)
            ->whereDate('bk_from_date', '<=', $date2 . $time2)
            ->where('bk_ou_te', '=', $terminal)
            ->where('bk_status', '=', 2)
            ->count();
        if ($ter_count >= $terminals->ter_cap) {
            $terminal_booked = 1;
        }
        /*======= Terminal over booked Check ======*/


        //service disable check
        $service_disabled = $this->is_service_disabled($selected_service);
        $allservices = $this->GetAllActiveServices();
        $allterminals = $this->GetAllTerminals($airport1);
        $allwebsites = $this->GetAllActiveWebsites();
        $services_response_array = array();
        $services_terminals_prices = [];
        if (empty($Err)) {

            /*===========PRICING CALCULATOR=============*/
           

            $rs_cur_rate = DB::table('currencies')
                ->select('id', 'cur_name', 'cur_code', 'cur_symbol', 'cur_rate')
                ->where('id', '=', $cur_id)
                ->first();

            $cur_rate = $rs_cur_rate->cur_rate;
            $cur_symbol = $rs_cur_rate->cur_symbol;
            
            foreach ($allwebsites as  $c_website) {
                foreach ($allservices as $service) {
                    foreach ($allterminals as $key => $terminal) {
                         // impilement logic here multiple vehicals
                        // Loop through each vehicle, call the function, and sum the booking prices
                        $net_price = 0;
                        foreach ($prepared_session_data['vehicles'] as $key => $vehicle) {
                            $bookingPrice = $this->handleVehicleBooking(
                                $vehicle['date1'],
                                $vehicle['date2'],
                                [
                                    'website_id' => $c_website->id,
                                    'country' => $prepared_session_data['country'],
                                    'airport1' => $prepared_session_data['airport1'],
                                    'terminal' => $prepared_session_data['terminal'],
                                    'return_terminal' => $terminal->id,
                                    'service' => $service->id,
                                    'cur_id' => $prepared_session_data['currency1'],
                                    'discount_coupon' => $prepared_session_data['discount_coupon'],
                                    'terminal_parking_fee' => $prepared_session_data['terminal_parking_fee'],
                                    'all_services' => $prepared_session_data['all_services'],
                                    'vehical_num' => $prepared_session_data['vehical_num'],
                                    'bk_nop' => $prepared_session_data['bk_nop'],
                                    'luggage' => $prepared_session_data['luggage'],
                                    'ulze' => $prepared_session_data['ulze'],
                                    'bk_ou_fl_nu' => $prepared_session_data['bk_ou_fl_nu'],
                                    //'bk_ve_ma' => $prepared_session_data['bk_ve_ma'],
                                    //'bk_ve_mo' => $prepared_session_data['bk_ve_mo'],
                                    //'bk_ve_co' => $prepared_session_data['bk_ve_co'],
                                    //'v_contact_num' => $prepared_session_data['v_contact_num'],
                                    'vehical_type_id' => $prepared_session_data['vehical_type_id'],
                                    'carwash_in_and_out' => $prepared_session_data['carwash_in_and_out'],
                                    'carwash_out_only' => $prepared_session_data['carwash_out_only'],
                                    'carwash_in_only' => $prepared_session_data['carwash_in_only'],
                                    'carwash_spray_only'  => $prepared_session_data['carwash_spray_only'],
                                ],
                                false
                            );
                            
                            // Add the booking price to the total
                            $net_price += $bookingPrice['net_price'];
                        }
                        $bg_color = "#d7dddac4;";
                        $sort = 0;
                        if($selected_termainal == $terminal->id &&  $service->id == $selected_service ){
                            $bg_color = '';
                            $sort = 1;
                        }
                        $service_name = $this->GetServiceName($service->id);
                        
                        //$service_name = "dasda";
                        $color = "#fff";
                        $price_with_symbol =  $cur_symbol . " " . number_format($net_price, 2, '.', '');
                        $price_with_symbol = "<span style='color:$color; font-size:15px;'>Select " . $price_with_symbol . "</span>";

                      
                        if($all_services){
                            $services_terminals_prices[] = array (
                                "bg_color" => $bg_color,
                                "sort"  => $sort,
                                "website_name" => $c_website->website_name,
                                "website_logo" => $c_website->website_logo,
                                "terminal_name" => $terminal->ter_name,
                                "terminal_id" => $terminal->id,
                                "service_name" => $service_name,
                                "price_with_symbol" => $price_with_symbol,
                                "net_price" => $net_price,
                                "website_id" => $c_website->id,
                                "cur_symbol" => $cur_symbol
                            );
                        }else{
                            //if($service->id == $selected_service ){
                                if($selected_termainal == $terminal->id &&  $service->id == $selected_service){
                                $services_terminals_prices[] = array (
                                    "bg_color" => $bg_color,
                                    "sort"  => $sort,
                                    "website_name" => $c_website->website_name,
                                    "website_logo" => $c_website->website_logo,
                                    "terminal_name" => $terminal->ter_name,
                                    "terminal_id" => $terminal->id,
                                    "service_name" => $service_name,
                                    "price_with_symbol" => $price_with_symbol,
                                    "net_price" => $net_price,
                                    "website_id" => $c_website->id,
                                    "cur_symbol" => $cur_symbol,
                                    "promo" => $this->promocomaprepage($c_website->id)
                                );
                            }
                        }
                        
                    }
                }
            }
            //return $html;
        }
        if(!empty($services_terminals_prices)){
            usort($services_terminals_prices, function($a, $b) {
                return $a['net_price'] - $b['net_price'];
            });
        }
        
        $page_title = 'Booking';
        $meta_array = array(
            'title' =>  strtolower($page_title),
            'description' => strtolower($page_title),
            'keywords' => strtolower($page_title),
            'og:locale' => 'en_US',
            'og:type' => 'website',
            'og:title' =>  strtolower($page_title),
            'og:url' =>  strtolower($page_title),
            'twitter:card' =>  strtolower($page_title),
            'twitter:description' => strtolower($page_title),
            'twitter:title' => strtolower($page_title),

        );
        $skey = env('STRIPE_KEY');
        $booking_edit = 0;
        $selected_terminals = DB::table('terminals')
        ->where('airport_id', '=', $airport1)
        ->get();
        return view($domain->website_templete . '.booking-campare', compact('Err', 'booking_data', 'services_terminals_prices', 'selected_terminals', 'requset_data', 'booking_edit', 'page_title', 'airports', 'currencies', 'countries', 'meta_array', 'services', 'domain', 'html',  'settings',  'skey', 'vehical_selction'));
    }

    public function store(Request $request)
    {
        //die("Sdfsdfsdf");
        $requset_data = $request->all();
        //dd($requset_data);
        $request_data['vehicles'] = [];
        $prepared_session_data_final = Domain::SetSessionDataStore($requset_data);
        
        // session(['booking_data' => $prepared_session_data_final]);
        $prepared_session_data = session('booking_data');
        //dd( $prepared_session_data_final);
        $errors = "";
        $err = 0;
        $errors = $this->ValidateBookingDates($prepared_session_data);
        //dd($errors);
       if(!empty($errors)){
            return redirect('/confirm-booking');
       }
       $domain = Domain::get_domain_id(1);
       $camparison_website = $prepared_session_data['website_id'];
       $date2Err = "";

        /* ======= Service ======= */
        $services = DB::table('services')
            ->where('disable', '=', 0)
            ->orderByRaw('sort ASC')
            ->get();
        /* ======= /Service ======= */

        /* ======= Settings ======= */

        $settings = $this->get_website_settings($domain->id);
        /* ======= Settings ======= */
        $domain_prefix = $domain->website_prefix;
        $domain_ID = $camparison_website;
        $airport1 = $prepared_session_data['airport1'];
        $terminal = $prepared_session_data['terminal'];
        $booking_service =$prepared_session_data['service'];
        $booking_country = 1;
        $return_terminal = $prepared_session_data['return_terminal'];
        $discount_coupon = $prepared_session_data['discount_coupon'];
        $terminal_parking_fee = $prepared_session_data['terminal_parking_fee'];
        $vehical_num = $prepared_session_data['vehical_num'];
        $cur_id = $prepared_session_data['currency1'];
        $payment_option = $prepared_session_data['payment_option'];
        $OutboundFlightNumber = $prepared_session_data['OutboundFlightNumber'];
        $ReturnFlightNumber = $prepared_session_data['ReturnFlightNumber'];
        $nop = $prepared_session_data['bk_nop'];
        $luggage = $prepared_session_data['luggage'];
        $ulze = $prepared_session_data['ulze'];
        /* CUSTOMER DETAILS */
        if (isset($_COOKIE["cus_id"])) {
            $customer_id = Domain::get_customer_id($_COOKIE["cus_id"]);
        }

        $price_table = "regular_prices";
        $discount_table = "regular_discounts";

       //validation for each vehical
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

        // new variables for early booking
        $rs_ter_interval = DB::table('terminals')
        ->select('ter_interval')
        ->where('id', '=', $terminal)
        ->first();
        $st_hours = $rs_ter_interval->ter_interval;
        $st_mins = $st_hours * 60;

       foreach($prepared_session_data['vehicles'] as $key=>$vehical){

            $var_date1 = $vehical['date1'];
            $var_date_exp1 = explode('-', $var_date1);
            $date = str_replace('/', '-', $var_date_exp1[0]);
            $date1 = date('Y-m-d', strtotime($date));
            $var_date_time_1 = explode(':', $var_date_exp1[1]);
            $hour1 = $var_date_time_1[0];
            $min1 = $var_date_time_1[1];

            $var_date2 = $vehical['date2'];
            $var_date_exp_2 = explode('-', $var_date2);
            $date = str_replace('/', '-', $var_date_exp_2[0]);
            $date2 = date('Y-m-d', strtotime($date));
            $var_date_time_2 = explode(':', $var_date_exp_2[1]);
            $hour2 = $var_date_time_2[0];
            $min2 = $var_date_time_2[1];

            $time1 = $hour1 . ":" . $min1 . ":00";
            $time2 = $hour2 . ":" . $min2 . ":00";

            if (empty($var_date1)) {  //meeting date/time is empty
                $date2Err = "Vehicle $key Meeting date/time is required";
                $err = 1;
            }
            if (empty($var_date2)) { //return date/time is empty
                $date2Err = "Vehicle $key Coming back date/time is required";
                $err = 1;
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
                        $date2Err = "Vehicle $key Terminal already booked";
                        $err = 1;
                    } else {
                        $terminal = $terminal;
                    }
                }
            }

            if (strtotime($date1 . $time1) >= strtotime($date2 . $time2)) { // meeting date/time later than return time $Err = 3
                $date2Err = "Vehicle $key Invalid Meeting and coming back date/time";
                $err = 1;
            }

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
                $date2Err = "Vehicle $key Arrival date passed current date";
                $err = 1;
            }

            if (($int_mins < $st_mins) and ($st_hours > 0)) { //$Err = 6
                $date2Err = "Vehicle $key Departure too early";
                $err = 1;
            }
        }
        /* FLIGHT AND VEHICAL DETAILS */
            
            /* CUSTOMER DETAILS ON-OFF BOOKING */
            $title = $request->get('title');
            $name = $this->set_input($request->get('name1'));
            $surname = $this->set_input($request->get('surname'));
            $email = $this->set_input($request->get('email'));
            $email_1 = $this->set_input($request->get('email_1'));
            $company = $this->set_input($request->get('company'));
            $tel = $this->set_input($request->get('tel'));
            $cell = $this->set_input($request->get('cell'));
            $cell2 = $this->set_input($request->get('cell2'));
            $homename = $this->set_input($request->get('homename'));
            $address = $this->set_input($request->get('address'));
            $town = $this->set_input($request->get('town'));
            $county = $this->set_input($request->get('county'));
            $postcode = $this->set_input($request->get('postcode'));
            $country = 1;
            if (!empty($name)  && !empty($email) && !empty($cell)) {
                $add_customers = DB::table('customers')->insert(
                    array(
                        'cus_title' => $title,
                        'cus_name' => $name,
                        'cus_email' => $email,
                        'cus_email_1' => $email_1,
                        'cus_password' => $cell,
                        'cus_company' => $company,
                        'cus_surname' => $surname,
                        'cus_tele' => $tel,
                        'cus_cell' => $cell,
                        'cus_address' => $address,
                        'cus_town' => $town,
                        'cus_county' => $county,
                        'cus_postcode' => $postcode,
                        'cus_oneoff' => 1,
                        'cud_date' => date('Y-m-d'),
                        'cus_cell2' => $cell2,
                        'cus_homename' => $homename,
                        'cus_country' => 1,
                        'cus_status' => 0
                    )
                );
                if ($add_customers == 1) {
                    $customer_id = DB::getPdo()->lastInsertId();
                    //print_r($customer_id); exit;
                    //$booking_partial->customer_id = $customer_id;

                    $encripted_customer_id = Domain::set_encripted_ids($customer_id);
                    setcookie("cus_id", $encripted_customer_id, time() + 3600 * 24 * 100, "/");
                } else {
                    $err = 1;
                }
            }
        /* CUSTOMER DETAILS ON-OFF BOOKING */
        $all_vehical_final_total = 0;
        $saved_booking_id = [];
        $carwash_out_only = 0;
        $carwash_in_and_out = 0;
        $carwash_in_only = 0;
        $vehical_type_id = 0;

        if( $payment_option == 6){ // if banktransfer selected
                
            $paylater_errors = array();
            $this->validate($request, [
                'bank_transition_refernce' => 'required'
            ]);
        }      
        if ($err == 0 && !empty($payment_option)) {
            foreach($prepared_session_data['vehicles'] as $key=>$vehical){
                $var_date1 = $vehical['date1'];
                $var_date_exp1 = explode('-', $var_date1);
                $date = str_replace('/', '-', $var_date_exp1[0]);
                $date1 = date('Y-m-d', strtotime($date));
                $var_date_time_1 = explode(':', $var_date_exp1[1]);
                $hour1 = $var_date_time_1[0];
                $min1 = $var_date_time_1[1];

                $var_date2 = $vehical['date2'];
                $var_date_exp_2 = explode('-', $var_date2);
                $date = str_replace('/', '-', $var_date_exp_2[0]);
                $date2 = date('Y-m-d', strtotime($date));
                $var_date_time_2 = explode(':', $var_date_exp_2[1]);
                $hour2 = $var_date_time_2[0];
                $min2 = $var_date_time_2[1];

                $time1 = $hour1 . ":" . $min1 . ":00";
                $time2 = $hour2 . ":" . $min2 . ":00";

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
    
    
                
    
                $rs_cur_rate = DB::table('currencies')
                    ->select('id', 'cur_name', 'cur_code', 'cur_symbol', 'cur_rate')
                    ->where('id', '=', $cur_id)
                    ->first();
                $cur_rate = $rs_cur_rate->cur_rate;
                $cur_symbol = $rs_cur_rate->cur_symbol;
    
                if ($int_days <= 30) { // if days are less than 30, then select price per day
                    $int_days_less_then_7 = 'cal_d' . $int_days;
                    $gross_price = DB::table($price_table)
                        ->select($int_days_less_then_7)
                        ->where('terminal_id', '=', $terminal)
                        ->where('service_id', '=', $booking_service)
                        ->where('website_id', '=', $camparison_website)
                        ->first();
    
                    $gross_price = number_format($gross_price->$int_days_less_then_7, 2, '.', '');
                } elseif ($int_days > 30) // if days are more than 30, then select price from 7th day + flat rate
                {
    
                    $price = DB::table($price_table)
                        ->select('cal_fix_rate', 'cal_d30')
                        ->where('terminal_id', '=', $terminal)
                        ->where('service_id', '=', $booking_service)
                        ->where('website_id', '=', $camparison_website)
                        ->first();
    
                    //$gross_price = $price->cal_d30 + ($price->cal_fix_rate * ($int_days - 7));
                    $days_count = $int_days - 30;
                    $gross_price = $price->cal_d30 + ($days_count * $price->cal_fix_rate);
                    $gross_price = number_format($gross_price, 2, '.', '');
                }
                $gross_price = $gross_price * $cur_rate; // applying currency rate
    
                // CHECKING AND APPLYING DISCOUNT FOR TERMINAL
                $discount_value = 0;

                $bk_discount_offer_coupon = "";
                $bk_discount_offer_value = 0;
                $bk_discount_offer_amount = 0;
                
               
                if(!empty($request->get('promotion_code'))){
                    $today = date("Y-m-d");
                    $promotion = DB::table("promotion_offers")
                            //->where('offer_active', 1)
                            ->where('offer_date1', '<=', $today)
                            ->where('offer_date2', '>=', $today)
                            ->where('offer_coupon', 'LIKE', '%' . $request->get('promotion_code') . '%')
                            ->where('website_id', $camparison_website)
                            ->first();
                    if ($promotion) {
                        $bk_discount_offer_coupon = $request->get('promotion_code');
                        $bk_discount_offer_value = $promotion->offer_percentage;
                        $bk_discount_offer_amount = $gross_price * $promotion->offer_percentage / 100;
                        $net_price = $gross_price - $bk_discount_offer_amount;
                        $net_price = number_format($net_price, 2, '.', '');
                    }else{
                        $net_price = $gross_price;
                    }
                }else{
                    $net_price = $gross_price;
                }

                $pricing = DB::table($price_table)
                    ->select('cal_vat', 'cal_access_fee', 'cal_online_fee', 'cal_booking_fee')
                    ->where('terminal_id', '=', $terminal)
                    ->where('service_id', '=', $booking_service)
                    ->where('website_id', '=', $camparison_website)
                    ->first();
    
                $vat_value = 0;
                $vat_amount = 0;
                $access_fee = 0;
                $discount_amount = 0;
                $online_fee_value = $pricing->cal_online_fee; // get online fee % no need to apply currency conversion
    
                $booking_fee = $pricing->cal_booking_fee; // get booking fee
                $booking_fee = $booking_fee * $cur_rate; // currency conversion
    
                $vat_value = $pricing->cal_vat; // % vat value, no need to apply currency conversion.
                $vat_amount = $vat_value / 100 * $net_price; // vat calculation on parking price
    
                $net_price = $net_price + $vat_amount;   //  add vat
                $net_price = $net_price + $booking_fee; // add booking fee
    
                $access_fee = $pricing->cal_access_fee;  // get access fee
                $access_fee = $access_fee * $cur_rate;
    
                if($terminal_parking_fee == 'P'){
                    if ($access_fee >= 0) {
                        $net_price = $net_price + $access_fee; // add access fee
                    }
                }
    
                $online_fee_amount = $online_fee_value / 100 * $net_price; // online fee applied on parking price
                $net_price = $net_price + $online_fee_amount;
    
    
                /*=========== /PRICING CALCULATOR=============*/
    
                 
                //COMPARE DEPARTUE DATE WITH CURRENT DATE AND GET DIFFERENCE IN HOUR
                // CHECK IF HOUR EXISTS IF EXISTS GET PRICE AND ADD IT TO RELAVENT COLUMN
                $last_minutes_booking_values = Domain::calculate_last_min_booking_prices($bk_date1, $camparison_website);
                
                $bk_vip = $this->is_vip_service($booking_service);

                if (trim($prepared_session_data['carwash_in_and_out']) == 1) { //a IN AND OUT
                    $carwash_in_and_out = $this->Get_Carwash_Veh_Type_Price_Single($camparison_website, $prepared_session_data['vehical_type_id'], 'carwash_in_and_out');
                    //$carwash_in_and_out = $price;
                }

                if (trim($prepared_session_data['carwash_out_only']) == 1) { //d ONLY OUTSIDE
                    $carwash_out_only = $this->Get_Carwash_Veh_Type_Price_Single($camparison_website, $prepared_session_data['vehical_type_id'], 'carwash_out_only');
                    //$carwash_out_only = $price;
                }

                if (trim($prepared_session_data['carwash_in_only']) == 1) { //d INSIDE OUTSIDE
                    $carwash_in_only = $this->Get_Carwash_Veh_Type_Price_Single($camparison_website, $prepared_session_data['vehical_type_id'], 'carwash_in_only');
                    //$carwash_in_only = $price;
                }

                //if (trim($prepared_session_data['carwash_spray_only']) == 1) { //d INSIDE OUTSIDE
                    //$carwash_spray_only = $this->Get_Carwash_Veh_Type_Price_Single($website_id, $prepared_session_data['vehical_type_id'], 'carwash_spray_only');
                    //$carwash_in_only = $price;
                //}


                $bookingsave = new Booking([
                    'currency_id' => $cur_id,
                    'website_id' => $camparison_website,
                    'bk_vat_value' => $vat_value,
                    'bk_vat_amount' => $vat_amount,
                    'bk_online_fee_value' => $online_fee_value,
                    'bk_online_fee_amount' => $online_fee_amount,
                    'bk_booking_fee' => $booking_fee,
                    'bk_access_fee' => $access_fee,
                    'airport_id' => $airport1,
                    'bk_ref' => 'In process',
                    'bk_date' => $bk_date,
                    'bk_from_date' => $bk_date1,
                    'bk_to_date' => $bk_date2,
                    'bk_ve_do_dt' => $bk_date1,
                    'bk_ve_pu_dt' => $bk_date2,
                    'bk_days' => $int_days,
                    'bk_hours' => $int_hours,
                    'bk_mins' => $int_mins,
                    'bk_gross_price' => $gross_price,
                    'bk_discount_value' => $discount_value,
                    'bk_discount_amount' => $discount_amount,
                    'bk_discount_offer_coupon' => $bk_discount_offer_coupon,
                    'bk_discount_offer_value' => $bk_discount_offer_value,
                    'bk_discount_offer_amount' => $bk_discount_offer_amount,
                    'bk_total_amount' => $net_price,
                    'bk_discount_coupon' => $discount_coupon,
                    'bk_ou_te' => $terminal,
                    'bk_vip' => $bk_vip,
                    'service_id' => $booking_service,
                    'bk_re_te' => $return_terminal,
                    'country_id' => $booking_country,
                    'terminal_parking_fee' => $terminal_parking_fee,
                    'vehical_num' => $vehical_num,
                    'last_min_booking'=> $last_minutes_booking_values,
                    'bk_payment_method'=> $payment_option,
                    'bk_ou_fl_nu' => $OutboundFlightNumber,
                    'bk_re_fl_nu' => $ReturnFlightNumber,
                    'luggage' => $luggage,
                    'ulze' => $ulze,
                    'bk_nop' => $nop,
                    'bk_re_nu' => $vehical['bk_re_nu'],
                    'bk_ve_ma' => $vehical['bk_ve_ma'],
                    'bk_ve_mo' => $vehical['bk_ve_mo'],
                    'bk_ve_co' => $vehical['bk_ve_co'] ?? "",
                    'customer_contact' => $vehical['v_contact_num'] ?? NULL,
                    'vehical_type_id' => $prepared_session_data['vehical_type_id'] ?? 0,
                    'carwash_out_only' => $carwash_out_only,
                    'carwash_in_only' => $carwash_in_only,
                    'carwash_in_and_out' => $carwash_in_and_out,
                ]);
                //dd($bookingsave);

                $bookingsave->save();
    
    
                $insert_id = $bookingsave->id;
    
                $encripted_booking_id = Domain::set_encripted_ids($insert_id);
                $tenMinutes = 30 * 60; // Convert 10 minutes to seconds
                setcookie("bk_id", $encripted_booking_id, time() + 3600 * 24 * 100, "/");
                setcookie("bk_id", $encripted_booking_id, time() + $tenMinutes, "/");
    
    
                $booking_update = Booking::find($insert_id);
    
                $service_refrence = $this->getservice_prefix($booking_service);
                if(!empty($service_refrence)){
                    $booking_update->bk_ref = $domain_prefix . $insert_id . $airport_nick  . '-' . $service_refrence . '-'.$terminal_parking_fee;
                }else{
                    $booking_update->bk_ref = $domain_prefix . $insert_id . $airport_nick . '-'.$terminal_parking_fee;
                }
                
    
    
                /* Not Working Hours New */
                $booking_update->not_working_hours = Domain::GetNotWorkingHoursPrice($camparison_website, $bk_date1, $bk_date2);
                /* /Not Working Hours New */
                

                $booking_exists_flag = 1;
                $customer_exists_and_logged_in = 1;
                
                /* CUSTOMER DETAILS */
                $booking_update->bk_payment_method = $payment_option;
                $booking_update->customer_id = $customer_id;
                $booking_update->bk_status = 1;
                $booking_update->bk_date = date('Y-m-d H:i:s');

                /*==========  DISABLE PROMO =========*/
                if (!empty($booking_update->bk_discount_offer_coupon)) {
                    $promotion = DB::table("promotion_offers")
                        ->where('offer_coupon', '=', $booking_update->bk_discount_offer_coupon)
                        ->first();
                    if ($promotion) {
                        if ($promotion->offer_auto_deactivate == 1) {
                            $promotion_obj = PromotionOffer::find($promotion->id);
                            $promotion_obj->offer_active = 0;
                            $promotion_obj->save();
                            $datep = date('Y-m-d H:i:s');
                            $Customer_details = Customer::find($customer_id);
                            $customername = $Customer_details->cus_name . ' ' . $Customer_details->cus_surname;
                            $add_customers_promo = DB::table('promotion_offer_customers')->insert(
                                array(
                                    'promotion_offer_id' => $promotion->id,
                                    'customer_booking_ref' => $booking_update->bk_ref,
                                    'customer_id' => $customer_id,
                                    'customer_name' => $customername,
                                    'customer_email' => $Customer_details->cus_email,
                                    'customer_contact1' => $Customer_details->cus_cell,
                                    'customer_contact2' => $Customer_details->cus_cell2,
                                    'customer_car_reg' => $booking_update->bk_re_nu,
                                    'promo_used_date' => $datep,
                                )
                            );
                        }
                    }
                }
                /*==========  DISABLE PROMO =========*/
                QrCode::size(500)
                ->margin(20)
                ->errorCorrection('L')
                ->format('png')
                ->generate($booking_update->bk_ref, storage_path('/app/public/qrcodes/') . $insert_id . '.png');

                $booking_update->refrence_num_extra = Domain::generate_refrence_num_extra($booking_update->bk_ou_te, $booking_update->bk_re_te, $booking_update->bk_from_date, $booking_update->bk_to_date );
                if( $payment_option == 1){ //if account_num is added
                    $booking_update->account_num = $request->account_num;
                }

                if( $payment_option == 6){ //if bankteranfer is added
                    $booking_update->bank_transition_refernce = $request->bank_transition_refernce;
                }

                
                

                $carwash = $booking_update->carwash_in_and_out + $booking_update->carwash_out_only + $booking_update->carwash_in_only;
                $TOTAL_PAYABLE_AMOUNT = $booking_update->bk_total_amount + $carwash + $booking_update->not_working_hours + $booking_update->last_min_booking + $booking_update->charging_service_charges + $booking_update->charging;
                $TOTAL_PAYABLE_AMOUNT = number_format($TOTAL_PAYABLE_AMOUNT, 2, '.', '');
                $all_vehical_final_total = $all_vehical_final_total + $TOTAL_PAYABLE_AMOUNT;
                $booking_currency = $this->get_booking_currency($booking_update->currency_id);
                //$booking_update->all_vehicals_total = $all_vehical_final_total;
                $booking_update->bk_status = 1;
                $booking_update->save();
                $saved_booking_id[]= $insert_id;

                //EMAILS 
                /* -------------- @new enail template ---------------- */
                $Email_Template = "email.common";
                /* -------------- /@new enail template ---------------- */

                /*======================== GET EMAIL CONTENT ===========================*/
                $data = Edenemail::send_booking_email($insert_id);
                $st_admin_name = Edenemail::get_email_settings('st_admin_name');
                $st_admin_from_email = Edenemail::get_email_settings('st_admin_from_email');
                $st_admin_email = Edenemail::get_email_settings('st_admin_email');
                $st_notification_email = Edenemail::get_email_settings('st_notification_email');
                $email_subject = Edenemail::get_email_settings('st_new_booking_subject');
                /*======================== /GET EMAIL CONTENT ===========================*/

                if ($payment_option == 1 || $payment_option == 6) { // SEND EMAIL TO CUSTOMER IN CASE PAYLATER
                    /*======================== EMAIL TO CUSTOMER ===========================*/
                    if(!empty($data['cus_email'])){
                        $to_email = $data['cus_email'];
                        $to_name = $data['cus_title'] . ' ' . $data['cus_name'];
                        //basic
                        Mail::send($Email_Template . '.basic', $data, function ($message) use ($st_admin_from_email, $st_admin_name, $email_subject, $to_email, $to_name) {
                            $message->to($to_email, $to_name)->subject($email_subject);
                            $message->from($st_admin_from_email, $st_admin_name);
                        });
                    }
                    if(!empty($data['alternate_email'])){
                        $to_email = $data['alternate_email'];
                        $to_name = $data['cus_title'] . ' ' . $data['cus_name'];
                        //basic
                        Mail::send($Email_Template . '.basic', $data, function ($message) use ($st_admin_from_email, $st_admin_name, $email_subject, $to_email, $to_name) {
                            $message->to($to_email, $to_name)->subject($email_subject);
                            $message->from($st_admin_from_email, $st_admin_name);
                        });
                    }
                    /*======================== /EMAIL TO CUSTOMER ===========================*/
                }

                /*============== TO ADMIN ============*/
                $to_email = $st_admin_email;
                $to_name = $st_admin_name;
                //detailed
                Mail::send($Email_Template . '.detailed', $data, function ($message) use ($st_admin_from_email, $st_admin_name, $email_subject, $to_email, $to_name) {
                    $message->to($to_email, $to_name)->subject($email_subject);
                    $message->from($st_admin_from_email, $st_admin_name);
                });
                /*============== TO ADMIN ============*/
                
                
                /*============== TO amjad  both detailed and basic ============*/
                $to_email = "amjadalisheen@gmail.com";
                $to_name = $data['cus_title'] . ' ' . $data['cus_name'];
                $email_subject_amjad = $email_subject . ' amjad';
                Mail::send($Email_Template . '.detailed', $data, function ($message) use ($st_admin_from_email, $st_admin_name, $email_subject_amjad, $to_email, $to_name) {
                    $message->to($to_email, $to_name)->subject($email_subject_amjad);
                    $message->from($st_admin_from_email, $st_admin_name);
                });
                Mail::send($Email_Template . '.basic', $data, function ($message) use ($st_admin_from_email, $st_admin_name, $email_subject_amjad, $to_email, $to_name) {
                    $message->to($to_email, $to_name)->subject($email_subject_amjad);
                    $message->from($st_admin_from_email, $st_admin_name);
                });
                /*============== TO amjad ============*/  
                
            }
            
            $maxValue = max($saved_booking_id);
            $refrence_num_common = $domain_prefix . $maxValue . "-Inv";
            foreach ($saved_booking_id as $booking_id) {
                DB::table('bookings')
                    ->where('id', $booking_id)
                    ->update(['refrence_num_common' => $refrence_num_common, 'all_vehicals_total' => $all_vehical_final_total]);
            }

            if ($payment_option == 5) { // if stripe selected
                $this->validate($request, [
                    'card_no' => 'required',
                    'expiry_month' => 'required',
                    'expiry_year' => 'required',
                    'cvv' => 'required',
                ]);
            }

            if( $payment_option == 1){ // if paylater selected
                
                $paylater_errors = array();
                $this->validate($request, [
                    'account_num' => 'required'
                ]);
                //check if account number added by customer exist if not return
                $account_num_exists = DB::table("customer_accounts")
                    ->where('account_num', '=', $request->account_num)
                    ->exists();
                if(!$account_num_exists){
                    $paylater_errors['status'] = 401;
                    $paylater_errors['message'] = "Invalid Account Number" ;
                    $paylater_errors['paylaterexception'] = 1 ;
                    return $paylater_errors;
                    exit;
                }

            }


            

               

            $booking_complete = $this->booking_complete_check($maxValue);

            if (!empty($booking_complete)) { // booking complete
               
                $booking_exists = $this->booking_exists_check($maxValue);

                if (!empty($booking_exists)) { // booking exists
                   
                        $booking_exists_for_customer = $this->booking_exists_check_by_customer($maxValue, $customer_id);
                        if (!empty($booking_exists_for_customer)) { // booking exists for customer

                            $return = $domain->website_url . "/booking-confirmation";
                            $cancel_return = $domain->website_url . "/booking-confirmation?payment_status=cancel";
                            $notify_url = $domain->website_url . "/api/ipnn";

                            $data = $payment_option;
                            if ($payment_option == 1) {
                                
                                $redirect = '/booking-confirmation';
                            } elseif ($payment_option == 2) {
                                
                                $querystring = '';

                                //$PayPal_Email_Address = $this->get_global_settings('st_paypal_email');
                                $PayPal_Email_Address = 'extraenterprise@hotmail.com';
                                $querystring .= "?business=$PayPal_Email_Address&";
                                $querystring .= "cmd=_xclick&";
                                $querystring .= "item_name=$booking_exists_for_customer->refrence_num_common&";
                                $querystring .= "currency_code=$booking_currency&";
                                $querystring .= "amount=$all_vehical_final_total&";
                                $querystring .= "return=$return&";
                                $querystring .= "notify_url=$notify_url&";
                                $querystring .= "cancel_return=$cancel_return";
                                //$paypallink = "https://www.paypal.com/cgi-bin/webscr".$querystring;
                                $redirect = "https://www.paypal.com/cgi-bin/webscr" . $querystring;
                            } elseif ($payment_option == 3) {
                                $querystring = '';
                                $querystring .= "?instId=1152063&";
                                $querystring .= "cartId=$booking_exists_for_customer->id&";
                                $querystring .= "currency=$booking_currency&";
                                $querystring .= "amount=$all_vehical_final_total&";
                                $querystring .= "desc=$booking_exists_for_customer->refrence_num_common&";
                                $querystring .= "testMode=0";
                                $redirect = "https://secure.worldpay.com/wcc/purchase" . $querystring;
                            } elseif ($payment_option == 5) { // stripe



                                $stripe = Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

                                    try {
                                        $charge = \Stripe\Charge::create([
                                            "amount" => $all_vehical_final_total * 100,
                                            "currency" => $booking_currency,
                                            "source" => $request->stripeToken,
                                            'description' => $booking_exists_for_customer->refrence_num_common,
                                        ]);

                                        if ($charge['status'] == 'succeeded') {

                                            $txn_idexists =  $this->EntryAleadydone($charge['id']);
                                            if ($txn_idexists) {
                                                // exists
                                            } else {
                                                $all_booking = $this->GetAllBookingByCommonRefrenceNum($booking_exists_for_customer->refrence_num_common);
                                                
                                                // Debugging: Check if bookings are retrieved correctly
                                                if ($all_booking->isEmpty()) {
                                                    throw new Exception('No bookings found with the given reference number.');
                                                }

                                                foreach($all_booking as $booking){
                                                    // Debugging: Output booking details
                                                    error_log("Booking ID: " . $booking->id . ", Reference Number: " . $booking->refrence_num_common);

                                                    $PaymentNotification = new PaymentNotification([
                                                        'booking_id' => $booking->id,
                                                        'payment_reciever' => 'stripe',
                                                        'payment_status' => 'Completed',
                                                        'mc_gross' => $all_vehical_final_total,
                                                        'txn_id' => $charge['id'],
                                                        'item_name' => $booking->refrence_num_common,
                                                        'log' => serialize($charge)
                                                    ]);
                                                    
                                                    $PaymentNotification->save();
                                                    $insert_id = $PaymentNotification->id;
                                                    
                                                    if ($insert_id) {
                                                        // Send notification to all vehicle emails
                                                        $this->SendConfirmationEmail($booking);
                                                        $return = true;
                                                    }
                                                }
                                            }
                                            $redirect = '/booking-confirmation';
                                            $data = 0;
                                        }
                                    } catch (Exception $e) {
                                        error_log($e->getMessage()); // Log the error message
                                    }
                            }else if( $payment_option == 6){ //if bank_transition_refernce is added
                    
                                $redirect = '/booking-confirmation';
                                $data = 0;
                            }
                        } else {
                            $redirect = '/booking-compare';
                            $data = 0;
                        }
                } else {
                    
                    $redirect = '/';
                    $data = 0;
                }
            } else {
                $redirect = '/';
                $data = 0;
            }
            
            //die("sfdsdfsdf");
            session(['last_booking_ref' => $maxValue]);
            //$this->clear_cookie_booking('bk_id');
            return response()->json(['data' => $data, 'redirect' => $redirect], 200);
           
            
        } else {
            echo $date2Err;
        }
        
    }

    

    


    // Fetch terminals
    public function getTerminals($aiportid = 0)
    {
        $terminals['data'] = DB::table('terminals')
            ->where('airport_id', '=', $aiportid)
            ->get();
        echo json_encode($terminals);
        exit;
    }

    // Fetch Airorts
    public function getairorts($countryid = 1)
    {
        $airports['data'] = DB::table('airports')
            ->where('country_id', '=', $countryid)
            ->get();
        echo json_encode($airports);
        exit;
    }


    public function getDiscountCouponVip(Request $request)
    {
        $domain = env('APP_URL');
        $domain = Domain::get_domain_id(1);

        /* ======= Settings ======= */
        $settings = $this->get_website_settings($domain->id);
        /* ======= Settings ======= */

        $vip = $request->get('vip');
        $ter_id = $request->get('terminal');

        $discount_table = "regular_discounts";
        echo "0";
    }

    public function gettef(Request $request)
    {

        $tef = "";
        $terminal_parking_fee = $request->get('terminal_parking_fee');
        Domain::AddNewFiledToSession('terminal_parking_fee', $terminal_parking_fee);
        $prepared_session_data = session('booking_data');
        if(!empty($prepared_session_data)){
        if (isset($prepared_session_data['website_id']) && !empty($prepared_session_data['website_id'])) {
            $terminal = $prepared_session_data['terminal'];
            $service = $prepared_session_data['service'];
            $cur_id = $prepared_session_data['currency1'];
            $website_id = $prepared_session_data['website_id'];
            if ($service != 0 && $terminal != 0) {

                $price_table = "regular_prices";
                $rs_cur_rate = DB::table('currencies')
                    ->select('id', 'cur_name', 'cur_code', 'cur_symbol', 'cur_rate')
                    ->where('id', '=', $cur_id)
                    ->first();
                //print_r($cur_id);exit;
                $cur_rate = $rs_cur_rate->cur_rate;
    
                $pricing = DB::table($price_table)
                        ->select('cal_vat', 'cal_access_fee', 'cal_online_fee', 'cal_booking_fee')
                        ->where('terminal_id', '=', $terminal)
                        ->where('service_id', '=', $service)
                        ->where('website_id', '=', $website_id)
                        ->first();
                $access_fee = 0;
    
                $access_fee = $pricing->cal_access_fee;  // get access fee
                $access_fee = $access_fee * $cur_rate;
                if ($access_fee > 0) {
                    $tef = $access_fee;
                }
                $prepared_session_data = session('booking_data');
                $cart = $this->update_cart($prepared_session_data);
            }
            
            //$cart = "";
            //return response()->json(['tef' => $tef], 200);
            return response()->json(['mini_cart' => $cart['mini_cart'], 'cart' => $cart['cart'], 'msg' => '', 'tef' => $tef], 200);
        }else{
            return redirect('/compare-booking')->with('success', 'Please Complete intitial bookng step.');
        }
    }else{
        return redirect('/compare-booking')->with('success', 'Please Complete intitial bookng step.');
    }
        
    }

    public function getallservicesprice(Request $request)
    {
        $html = "";
        $domain = Domain::get_domain_id(1);
        /* ======= Settings ======= */
        $settings = $this->get_website_settings($domain->id);
        /* ======= Settings ======= */
        $Err = 0;
        $discount_applied = 0;
        $airport1 = $request->get('airport1');
        $terminal = $request->get('terminal');
        $selected_termainal =  $request->get('terminal');
        $selected_service = $request->get('service');
        $terminal_parking_fee = $request->get('terminal_parking_fee');
        $vehical_num = $request->get('vehical_num');
        //$country = $request->get('country');
        $bookingeditpage = $request->get('bookingeditpage');
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

        $cur_id = $request->get('cur_id');
        $discount_coupon = $request->get('discount_coupon');
        $time1 = $hour1 . ":" . $min1 . ":00";
        $time2 = $hour2 . ":" . $min2 . ":00";

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

        // Checking for errors
        $airport_disable = 0;
        $rs_ter_interval = DB::table('airports')
            ->select('id')
            ->where('airport_disable', '=', 1)
            ->where('id', '=', $airport1)
            ->count();
        if ($rs_ter_interval == 1) {
            $airport_disable = 1; // airport closed/disabled
        }

        // check if terminal is closed for booking by admin
        $terminal_disable = 0;
        $terminals = DB::table('terminals')
            ->select('id', 'ter_name', 'ter_cap', 'ter_disable')
            ->where('id', '=', $terminal)
            ->first();
        if (($terminals->ter_disable) == 1) { // if terminal closed for booking
            $terminal_disable = 1; // terminal closed/disabled
        }

        // check if terminal is over booked
        /*======= Terminal over booked Check ======*/
        $terminal_booked = 0;
        $ter_count = DB::table('bookings')
            ->select('id')
            ->whereDate('bk_from_date', '>=', $date1 . $time1)
            ->whereDate('bk_from_date', '<=', $date2 . $time2)
            ->where('bk_ou_te', '=', $terminal)
            ->where('bk_status', '=', 2)
            ->count();
        if ($ter_count >= $terminals->ter_cap) {
            $terminal_booked = 1;
        }
        /*======= Terminal over booked Check ======*/


        //service disable check
        $service_disabled = $this->is_service_disabled($selected_service);
        $allservices = $this->GetAllActiveServices();
        $allterminals = $this->GetAllTerminals($airport1);
        $allwebsites = $this->GetAllActiveWebsites();
        $services_response_array = array();

        if ($Err == 0) {

            /*===========PRICING CALCULATOR=============*/
            $interval = date_diff(date_create($date1 . $time1), date_create($date2 . $time2));
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

            $cur_rate = $rs_cur_rate->cur_rate;
            $cur_symbol = $rs_cur_rate->cur_symbol;

            foreach ($allwebsites as  $c_website) {
                foreach ($allservices as $service) {
                    foreach ($allterminals as $key => $terminal) {

                        if ($int_days <= 30) { // if days are less than 30, then select price per day
                            $int_days_less_then_7 = 'cal_d' . $int_days;
                            $gross_price = DB::table($price_table)
                                ->select($int_days_less_then_7)
                                ->where('terminal_id', '=', $terminal->id)
                                ->where('service_id', '=', $service->id)
                                ->where('website_id', '=', $c_website->id)
                                ->first();
                        
                            $gross_price = number_format($gross_price->$int_days_less_then_7, 2, '.', '');
                        } elseif ($int_days > 30) { // if days are more than 30, then select price from 7th day + flat rate

                            $price = DB::table($price_table)
                                ->select('cal_fix_rate', 'cal_d30')
                                ->where('terminal_id', '=', $terminal->id)
                                ->where('service_id', '=', $service->id)
                                ->where('website_id', '=', $c_website->id)
                                ->first();
                            //$gross_price = $price->cal_d30 + ($price->cal_fix_rate * ($int_days - 7));
                            $days_count = $int_days - 30;
                            $gross_price = $price->cal_d30 + ($days_count * $price->cal_fix_rate);
                            $gross_price = number_format($gross_price, 2, '.', '');
                        }
                        $gross_price = $gross_price * $cur_rate; // applying currency rate

                        if ($discount_applied == 1) { // if discount is applied
                            $discount_value_rs = DB::table($discount_table)
                                ->select('dis_value')
                                ->where('terminal_id', '=', $terminal->id)
                                ->where('service_id', '=', $service->id)
                                ->where('dis_coupon', '=', $discount_coupon)
                                ->where('dis_active', '=', 1)
                                ->where('website_id', '=', $c_website->id)
                                ->first();
                            if ($discount_value_rs) {
                                $discount_value = $discount_value_rs->dis_value;
                                $discount_amount = ($gross_price * $discount_value_rs->dis_value / 100);
                                $discount_amount = number_format($discount_amount, 2, '.', '');
                                $net_price = $gross_price - $discount_amount;
                                $net_price = number_format($net_price, 2, '.', '');
                            } else {
                                $discount_value = 0;
                                $discount_amount = 0;
                                $net_price = $gross_price;
                            }
                        } else { // if discount is not applied

                            $discount_value = 0;
                            $discount_amount = 0;
                            $net_price = $gross_price;
                        }

                        $pricing = DB::table($price_table)
                            ->select('service_id', 'cal_vat', 'cal_access_fee', 'cal_online_fee', 'cal_booking_fee')
                            ->where('terminal_id', '=', $terminal->id)
                            ->where('service_id', '=', $service->id)
                            ->where('website_id', '=', $c_website->id)
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

                        if($terminal_parking_fee == 'P'){ // @am2022 pay access fee in website
                        if ($access_fee >= 0) {
                            $net_price = $net_price + $access_fee; // add access fee
                        }
                        }else{
                        $access_fee = 0;
                        }


                        $online_fee_amount = $online_fee_value / 100 * $net_price; // online fee applied on parking price
                        $net_price = $net_price + $online_fee_amount;



                        /* Not Working Hours New */
                        $not_working_hours_price = Domain::GetNotWorkingHoursPrice($domain->id,  $bk_date1, $bk_date2);
                        $net_price = $not_working_hours_price + $net_price;
                        /* /Not Working Hours New */

                        /* Last minutes booking */
                        $last_minutes_booking_values = Domain::calculate_last_min_booking_prices($bk_date1, 1);
                        $net_price = $last_minutes_booking_values + $net_price;
                        /* Last minutes booking */


                        $bg_color = "";
                        if($selected_termainal == $terminal->id &&  $service->id == $selected_service ){
                            $bg_color = 'style="background: #12d07891;"';
                        }
                        $service_name = $this->GetServiceName($pricing->service_id);
                        $color = "#fff";
                        $price_with_symbol =  $cur_symbol . " " . number_format($net_price, 2, '.', '');
                        $price_with_symbol = "<span style='color:$color; font-size:15px;'>Select " . $price_with_symbol . "</span>";

                        $full_text = $terminal->ter_name . '( ' . $price_with_symbol . ' )';
                        $html .= '<div class="col-md-12 d-flex align-items-stretch mt-4 mt-md-0">';
                        $html .= '<div class="icon-box" '.$bg_color.'>';
                        $html .= '<h4> '. $c_website->website_name . ' Termainal <span style="font-size: 30px; margin-left: 4px;">'  . $terminal->ter_name . ' -- ' .$service_name . '</span></h4>';
                        $html .= '<a style="cursor:pointer;" onclick="updatedservice(' . $terminal->id . ');"  class="plan-btn">' . $price_with_symbol . '</a>';
                        $html .= '</div>';
                        $html .= '</div>';
                    }
                }
            }
            return $html;
        }
    }
    public function GetServiceName($id) {
        $website = Services::where('id', $id)->first();
        return $website->service_name;
    }

    public function Checkout(Request $request)
    {
    
        Domain::AddNewFiledToSession('website_id',$request['website_id']);
        $prepared_session_data = session('booking_data');
        //dd($prepared_session_data);
        // if error return to
        $errors = [];
        $settings = [];
        $terminal_access_options = array(
            // 'N' => 'Pay Yourself Terminal Access fee ( Drop of Chargers) upon Departure and Arrival.',
            'N' => 'Customer are responsible to pay Terminal fee upon Departure and Arrival(Not Added)',
            'P' => 'Add Now (Departure & Arrival 25 mins Only)',
            

        );
        if( !empty($prepared_session_data) && count($prepared_session_data) > 5){
            
            $errors = $this->ValidateBookingDates($prepared_session_data);
            //dd($errors);
                // get prices and sum if multiple vehicles selected
                
                // Initialize total booking price as a numeric variable
                $totalBookingPrice = 0;

                // Loop through each vehicle, call the function, and sum the booking prices
                foreach ($prepared_session_data['vehicles'] as $key => $vehicle) {
                    $bookingPrice = $this->handleVehicleBooking(
                        $vehicle['date1'],
                        $vehicle['date2'],
                        [
                            'website_id' => $prepared_session_data['website_id'],
                            'country' => $prepared_session_data['country'],
                            'airport1' => $prepared_session_data['airport1'],
                            'terminal' => $prepared_session_data['terminal'],
                            'return_terminal' => $prepared_session_data['return_terminal'],
                            'service' => $prepared_session_data['service'],
                            'cur_id' => $prepared_session_data['currency1'],
                            'discount_coupon' => $prepared_session_data['discount_coupon'],
                            'terminal_parking_fee' => $prepared_session_data['terminal_parking_fee'],
                            'all_services' => $prepared_session_data['all_services'],
                            'vehical_num' => $prepared_session_data['vehical_num'],
                            'bk_nop' => $prepared_session_data['bk_nop'],
                            'luggage' => $prepared_session_data['luggage'],
                            'ulze' => $prepared_session_data['ulze'],
                            'bk_ou_fl_nu' => $prepared_session_data['bk_ou_fl_nu'],
                            'bk_re_fl_nu' => $prepared_session_data['bk_re_fl_nu'],
                            //'bk_ve_ma' => $prepared_session_data['bk_ve_ma'],
                            //'bk_ve_mo' => $prepared_session_data['bk_ve_mo'],
                            //'bk_ve_co' => $prepared_session_data['bk_ve_co'],
                            //'v_contact_num' => $prepared_session_data['v_contact_num'],
                            'vehical_type_id' => $prepared_session_data['vehical_type_id'],
                            'carwash_in_and_out' => $prepared_session_data['carwash_in_and_out'],
                            'carwash_out_only' => $prepared_session_data['carwash_out_only'],
                            'carwash_in_only' => $prepared_session_data['carwash_in_only'],
                            'carwash_spray_only'  => $prepared_session_data['carwash_spray_only'],
                        ],
                        false
                    );
                    
                    // Add the booking price to the total
                    $totalBookingPrice += $bookingPrice['net_price'];
                }

                // Dump the total booking price
          
                $domain = env('APP_URL');
                $domain = Domain::get_domain_id(1);
                $comparison_website = Domain::GetDomianById($prepared_session_data['website_id']); 
                /* ======= Service ======= */
                $services = DB::table('services')
                    //->where('disable', '=', 0)
                    ->orderByRaw('sort ASC')
                    ->get();
                /* ======= Service ======= */
                /* ======= Service ======= */
                $settings = $this->get_website_settings($prepared_session_data['website_id']);
                /* ======= /Service ======= */
                $vehicaltype = VehicalType::all();
                $vehicaltype_enabled = [];

                foreach ($vehicaltype as $veh) {
                    $enabled_vehicles = DB::table("car_washes as cw")
                        ->join("vehical_types as vv", "vv.id", "=", "cw.vehical_type_id")
                        ->join("websites as site", "site.id", "=", "cw.website_id")
                        ->where('cw.vehical_type_id', $veh->id)
                        ->where('cw.status', 1)
                        ->where('cw.car_wash_type', '!=', 'carwash_spray_only')
                        ->where('cw.website_id', $prepared_session_data['website_id'])
                        ->select("vv.*")
                        ->get()
                        ->toArray();  // Convert the collection to an array

                    $vehicaltype_enabled = array_merge($vehicaltype_enabled, $enabled_vehicles);
                }

                $vehicaltype_enabled = array_filter($vehicaltype_enabled);
                
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
                $page_title = 'Booking';
                $meta_array = array(
                    'title' =>  strtolower($page_title),
                    'description' => strtolower($page_title),
                    'keywords' => strtolower($page_title),
                    'og:locale' => 'en_US',
                    'og:type' => 'website',
                    'og:title' =>  strtolower($page_title),
                    'og:url' =>  strtolower($page_title),
                    'twitter:card' =>  strtolower($page_title),
                    'twitter:description' => strtolower($page_title),
                    'twitter:title' => strtolower($page_title),

                );
                $skey = env('STRIPE_KEY');
                $cart_data  = $this->update_cart($prepared_session_data);
                $mini_cart = $cart_data['mini_cart'];
                $cart = $cart_data['cart'];
                //$html_price_only = $this->update_cart_price_only($bk_id_c);
                $html = "";
                $html_price_only = "";
                $colors = DB::table('colors')
                    ->where('clr_disable', '=', 0)
                    ->select("id", "clr_name")
                    ->get();

                $settings['currency'] = $prepared_session_data['currency1'];
                //$carwash_selected = $this->get_carwash_veh_type_price($domain->id, $bk_details->vehical_type_id);
                $carwash_selected = 0;
                if(empty($errors)){
                    return view($domain->website_templete . '.booking', compact('page_title', 'meta_array', 'terminal_access_options', 'services', 'domain', 'html', 'html_price_only', 'colors', 'settings', 'customer', 'show_login', 'prepared_session_data', 'skey', 'vehicaltype_enabled', 'carwash_selected', 'totalBookingPrice', 'mini_cart', 'cart', 'comparison_website'));
                }else{
                    return view($domain->website_templete . '.booking', compact('page_title', 'meta_array', 'services', 'terminal_access_options', 'domain', 'html', 'html_price_only', 'colors', 'settings', 'customer', 'show_login', 'prepared_session_data', 'skey', 'vehicaltype_enabled', 'carwash_selected', 'totalBookingPrice'))->withErrors($errors);
                }
        }else{
            $query = http_build_query($request);
            return redirect('/compare-booking?' . $query);
        }

    }

    public function updateVehicleDate(Request $request)
    {
        
        // Validate the incoming data
        $validated = $request->validate([
            'veh' => 'required|integer',
            'name' => 'required|string',
            'value' => 'required|string',
        ]);

        // Get the session data
        $booking_data = session('booking_data', []);

        // Update the session data with the new date
        $veh = $validated['veh'];
        $name = $validated['name'];
        $value = $validated['value'];

        if (isset($booking_data['vehicles'][$veh])) {
            $booking_data['vehicles'][$veh][$name] = $value;
            // Save the updated session data
            session(['booking_data' => $booking_data]);

            return response()->json(['success' => true, 'fff' => $booking_data]);
        }

        return response()->json(['success' => false, 'message' => 'Vehicle not found'], 404);
    }

    public function ValidateBookingData($request)
    {
        $domain = env('APP_URL');
        $domain = Domain::get_domain_id(1);

        /* ======= Settings ======= */
        $settings = $this->get_website_settings($domain->id);
        /* ======= Settings ======= */

        $Err = "";
        $airport1 = $request->get('airport1');
        $terminal = $request->get('terminal');
        $service = $request->get('service');
        $terminal_parking_fee = $request->get('terminal_parking_fee');
        $vehical_num = $request->get('vehical_num');
        //$country = $request->get('country');
        $bookingeditpage = $request->get('bookingeditpage');
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

        $cur_id = $request->get('cur_id');
        $discount_coupon = $request->get('discount_coupon');
        $time1 = $hour1 . ":" . $min1 . ":00";
        $time2 = $hour2 . ":" . $min2 . ":00";
        //print_r($time1. '------'. $time2);exit;
        // new variables for early booking


        $rs_ter_interval = DB::table('terminals')
            ->select('ter_interval')
            ->where('id', '=', $terminal)
            ->first();
        $st_hours = $rs_ter_interval->ter_interval;
        $st_mins = $st_hours * 60;

        // CHECKING HOURS DIFFERENCE FOR X HOURS
        $cdatetime = date('Y-m-d H:i:s');;
        $interval = date_diff(date_create($date1 . $time1), date_create($cdatetime));
        $int_days = $interval->format('%a');
        $int_hours = 0;
        if ($int_days > 0) {
            $int_hours = $int_days * 24;
        }
        $int_hours = $int_hours + $interval->format('%h');
        $int_mins = $int_hours * 60;
        $int_mins = $int_mins + $interval->format('%i') . " ";

        // Checking for errors
        $airport_disable = 0;
        $rs_ter_interval = DB::table('airports')
            ->select('id')
            ->where('airport_disable', '=', 1)
            ->where('id', '=', $airport1)
            ->count();
        if ($rs_ter_interval == 1) {
            $airport_disable = 1; // airport closed/disabled
        }

        // check if terminal is closed for booking by admin
        $terminal_disable = 0;
        $terminals = DB::table('terminals')
            ->select('id', 'ter_name', 'ter_cap', 'ter_disable')
            ->where('id', '=', $terminal)
            ->first();
        if (($terminals->ter_disable) == 1) { // if terminal closed for booking
            $terminal_disable = 1; // terminal closed/disabled
        }

        // check if terminal is over booked
        /*======= Terminal over booked Check ======*/
        $terminal_booked = 0;
        $ter_count = DB::table('bookings')
            ->select('id')
            ->whereDate('bk_from_date', '>=', $date1 . $time1)
            ->whereDate('bk_from_date', '<=', $date2 . $time2)
            ->where('bk_ou_te', '=', $terminal)
            ->where('bk_status', '=', 2)
            ->count();
        if ($ter_count >= $terminals->ter_cap) {
            $terminal_booked = 1;
        }
        /*======= Terminal over booked Check ======*/


        //service disable check
        $service_disabled = $this->is_service_disabled($service);



        if ($airport1 == 0) {
            $Err = "Select airport"; // no airport selected
        } elseif ($airport_disable == 1) {
            $Err = "Airport closed for booking"; // airport closed/disabled
        } elseif ($terminal == 0) {
            $Err = "Select terminal"; // no terminal selected
        } elseif ($terminal_disable == 1) {
            $Err = "Terminal closed for booking"; // terminal disable/closed
        } elseif (($int_mins < $st_mins) and ($st_hours > 0)) {
            //print_r($int_mins.'---'.$st_mins .'---'.$st_hours);exit;
            $Err = "Departure date/time too close"; // interval between booking in less than X hours
        } elseif (strtotime($date1 . $time1) >= strtotime($date2 . $time2)) {
            $Err = "Select proper dates"; // datetime1 is greater than datetime2
        } elseif (strtotime($cdatetime) >= strtotime($date1 . $time1)) {
            $Err = "Current date/time past departure date/time"; // arrival datetime passed current datetime
        } elseif ($terminal_booked == 1) {
            $Err = "Space not available on these date(s)"; // terminal over booked
        } elseif ($service == 0) {
            $Err = "Please Select Service"; // Service
        } elseif ($service_disabled == 1) {
            $Err = "Service Not Available"; // Service disabled
        } elseif ( $terminal_parking_fee  == 'none'){
            $Err = "Please Select Terminal Access Fee"; // Service disabled
        }

        return $Err;
    }

    public function handleVehicleBooking($date1_s, $date2_s, $request, $multiple)
    {
        $domain = env('APP_URL');
        $domain = Domain::get_domain_id(1);
        $offer_percentage = 0;
        $pprice = 0;
        $offer_amount = 0;
        /* ======= Settings ======= */
        $settings = $this->get_website_settings($request['website_id']);
        /* ======= Settings ======= */
       //dd($request);
        
        $airport1 = $request['airport1'];
        $terminal = $request['terminal'];
        $service = $request['service'];
        $terminal_parking_fee = $request['terminal_parking_fee'];
        $vehical_num = $request['vehical_num'];
        $country = $request['country'];
        $bookingeditpage = 0;
        $var_date1 = $date1_s;
        $var_date_exp1 = explode('-', $var_date1);
        $date = str_replace('/', '-', $var_date_exp1[0]);
        $date1 = date('Y-m-d', strtotime($date));
        $var_date_time_1 = explode(':', $var_date_exp1[1]);
        $hour1 = $var_date_time_1[0];
        $min1 = $var_date_time_1[1];

        $var_date2 = $date2_s;
        $var_date_exp_2 = explode('-', $var_date2);
        $date = str_replace('/', '-', $var_date_exp_2[0]);
        $date2 = date('Y-m-d', strtotime($date));
        $var_date_time_2 = explode(':', $var_date_exp_2[1]);
        $hour2 = $var_date_time_2[0];
        $min2 = $var_date_time_2[1];

        $cur_id = $request['cur_id'];
        $discount_coupon = $request['discount_coupon'];
        $time1 = $hour1 . ":" . $min1 . ":00";
        $time2 = $hour2 . ":" . $min2 . ":00";
        //print_r($time1. '------'. $time2);exit;
        // new variables for early booking


        $rs_ter_interval = DB::table('terminals')
            ->select('ter_interval')
            ->where('id', '=', $terminal)
            ->first();
        $st_hours = $rs_ter_interval->ter_interval;
        $st_mins = $st_hours * 60;

        // CHECKING HOURS DIFFERENCE FOR X HOURS
        $cdatetime = date('Y-m-d H:i:s');;
        $interval = date_diff(date_create($date1 . $time1), date_create($cdatetime));
        $int_days = $interval->format('%a');
        $int_hours = 0;
        if ($int_days > 0) {
            $int_hours = $int_days * 24;
        }
        $int_hours = $int_hours + $interval->format('%h');
        $int_mins = $int_hours * 60;
        $int_mins = $int_mins + $interval->format('%i') . " ";

        // Checking for errors
        $airport_disable = 0;
        $rs_ter_interval = DB::table('airports')
            ->select('id')
            ->where('airport_disable', '=', 1)
            ->where('id', '=', $airport1)
            ->count();
        if ($rs_ter_interval == 1) {
            $airport_disable = 1; // airport closed/disabled
        }

        // check if terminal is closed for booking by admin
        $terminal_disable = 0;
        $terminals = DB::table('terminals')
            ->select('id', 'ter_name', 'ter_cap', 'ter_disable')
            ->where('id', '=', $terminal)
            ->first();
        if (($terminals->ter_disable) == 1) { // if terminal closed for booking
            $terminal_disable = 1; // terminal closed/disabled
        }

        // check if terminal is over booked
        /*======= Terminal over booked Check ======*/
        $terminal_booked = 0;
        $ter_count = DB::table('bookings')
            ->select('id')
            ->whereDate('bk_from_date', '>=', $date1 . $time1)
            ->whereDate('bk_from_date', '<=', $date2 . $time2)
            ->where('bk_ou_te', '=', $terminal)
            ->where('bk_status', '=', 2)
            ->count();
        if ($ter_count >= $terminals->ter_cap) {
            $terminal_booked = 1;
        }
        /*======= Terminal over booked Check ======*/

        //service disable check
        $service_disabled = $this->is_service_disabled($service);
        // CHECKING HOURS DIFFERENCE FOR X HOURS

        $ajax = 1;
        $discount_applied = 0;
        /*===========PRICING CALCULATOR=============*/
        $interval = date_diff(date_create($date1 . $time1), date_create($date2 . $time2));
        $bk_date = date('Y-m-d H:i:s');
        $bk_date1 = $date1 . " " . $time1;
        $bk_date2 = $date2 . " " . $time2;
        $int_days = $interval->format('%a') + 1;
        $int_hours = $interval->format('%h');
        $int_mins = $interval->format('%i');
        $price_table = "regular_prices";
        $rs_cur_rate = DB::table('currencies')
            ->select('id', 'cur_name', 'cur_code', 'cur_symbol', 'cur_rate')
            ->where('id', '=', $cur_id)
            ->first();
        $cur_rate = $rs_cur_rate->cur_rate;
        $cur_symbol = $rs_cur_rate->cur_symbol;
        //echo $int_days . "| ppp  <br>";
        if ($int_days <= 30) { // if days are less than 30, then select price per day
            $int_days_less_then_7 = 'cal_d' . $int_days;
            $gross_price = DB::table($price_table)
                    ->select($int_days_less_then_7)
                    ->where('terminal_id', '=', $terminal)
                    ->where('service_id', '=', $service)
                    ->where('website_id', '=', $request['website_id'])
                    ->first();
            
            $gross_price = number_format($gross_price->$int_days_less_then_7, 2, '.', '');
           
        } elseif ($int_days > 30){ // if days are more than 30, then select price from 7th day + flat rate
            $price = DB::table($price_table)
                    ->select('cal_fix_rate', 'cal_d30')
                    ->where('terminal_id', '=', $terminal)
                    ->where('service_id', '=', $service)
                    ->where('website_id', '=', $request['website_id'])
                    ->first();
                $days_count = $int_days - 30;
                $gross_price = $price->cal_d30 + ($days_count * $price->cal_fix_rate);
                $gross_price = number_format($gross_price, 2, '.', '');
        }
        $gross_price = $gross_price * $cur_rate; // applying currency rate
        if(isset($request['discount_coupon']) && !empty($request['discount_coupon'])){
            $today = date("Y-m-d");
            $promotion = DB::table("promotion_offers")
                    ->where('offer_active', 1)
                    ->where('offer_date1', '<=', $today)
                    ->where('offer_date2', '>=', $today)
                    ->where('offer_coupon', 'LIKE', '%' . $request['discount_coupon'] . '%')
                    ->where('website_id', $request['website_id'])
                    ->first();
                if ($promotion) {
                    $offer_percentage = $promotion->offer_percentage;
                    $offer_amount = $gross_price * $promotion->offer_percentage / 100;
                    $net_price = $gross_price - $offer_amount;
                    $net_price = number_format($net_price, 2, '.', '');
                }else{
                    $net_price = $gross_price;
                }
        }else{
            $net_price = $gross_price;
        }
        
        $pricing = DB::table($price_table)
            ->select('cal_vat', 'cal_access_fee', 'cal_online_fee', 'cal_booking_fee')
            ->where('terminal_id', '=', $terminal)
            ->where('service_id', '=', $service)
            ->where('website_id', '=', $request['website_id'])
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

        
        
        if($terminal_parking_fee == 'P'){ // @am2022 pay access fee in website
            $access_fee = $pricing->cal_access_fee;  // get access fee
            $access_fee = $access_fee * $cur_rate;
            $access_fee = number_format($access_fee, 2, '.', '');
            $net_price = $net_price + $access_fee; // add access fee
        }
        

        $online_fee_amount = $online_fee_value / 100 * $net_price; // online fee applied on parking price
        $net_price = $net_price + $online_fee_amount;


        /*=========== /PRICING CALCULATOR=============*/


        /* Not Working Hours New */
        $not_working_hours_price = Domain::GetNotWorkingHoursPrice($request['website_id'],  $bk_date1, $bk_date2);
        $net_price = $not_working_hours_price + $net_price;
        /* /Not Working Hours New */

        /* Last minutes booking */
        $last_minutes_booking_values = Domain::calculate_last_min_booking_prices($bk_date1, 1);
        $net_price = $last_minutes_booking_values + $net_price;
        /* Last minutes booking */

        
        if (trim($request['carwash_in_and_out']) == 1) { //a IN AND OUT
            $pprice = $this->Get_Carwash_Veh_Type_Price_Single($request['website_id'], $request['vehical_type_id'], 'carwash_in_and_out');
            $net_price = $pprice + $net_price;
        }

        if (trim($request['carwash_out_only']) == 1) { //d ONLY OUTSIDE
            $pprice = $this->Get_Carwash_Veh_Type_Price_Single($request['website_id'], $request['vehical_type_id'], 'carwash_out_only');
            $net_price = $pprice + $net_price;
        }

        if (trim($request['carwash_in_only']) == 1) { //d INSIDE OUTSIDE
            $pprice = $this->Get_Carwash_Veh_Type_Price_Single($request['website_id'], $request['vehical_type_id'], 'carwash_in_only');
            $net_price = $pprice + $net_price;
        }

        if (trim($request['carwash_spray_only']) == 1) { //d INSIDE OUTSIDE
            $pprice = $this->Get_Carwash_Veh_Type_Price_Single($request['website_id'], $request['vehical_type_id'], 'carwash_spray_only');
            $net_price = $pprice + $net_price;
        }

        /*=============== EDIT BOOKING DETAILS SHOW HIDE PAYMENT BUTTON ==============*/
        $bkdays_am = "<span style='color:#f22525 !important;font-size: 24px;'>Parking days booked " . $int_days . " days: </span>";
        //". $int_hours ." hours "  . $int_mins . " min";


        
        //echo $cur_symbol . " " . number_format($net_price, 2, '.', '');
        $price_with_symbol =  $cur_symbol . " " . number_format($net_price, 2, '.', '');
        //$pricinf_detaiuls = ['days' => $bkdays_am, 'data' => $bkdays_am . " " . $price_with_symbol, 'net_price' => $net_price, 'bookingeditpage' => 0];
        $pricinf_detaiuls = [
            'net_price' => $net_price = number_format($net_price, 2, '.', ''), 
            'days' => $int_days , 
            'car_wash'=> $pprice,
            'offer_percentage'=> $offer_percentage,
            'offer_amount' => $offer_amount,
            'gross_price' => $gross_price,
            'not_working_hours_price' => $not_working_hours_price,
            'last_minutes_booking_values' => $last_minutes_booking_values,
            'cal_online_fee' => $pricing->cal_online_fee,
            'cal_booking_fee' => $pricing->cal_booking_fee,
            'cal_vat' => $pricing->cal_vat,
            'vat_amount' => $vat_amount,
            'cal_access_fee' => $pricing->cal_access_fee,
            'online_fee_amount' => $online_fee_amount,

        ];

        return $pricinf_detaiuls;
        
    }






    public function getprice(Request $request)
    {
        $domain = env('APP_URL');
        $domain = Domain::get_domain_id(1);

        /* ======= Settings ======= */
        $settings = $this->get_website_settings($domain->id);
        /* ======= Settings ======= */

        $Err = 0;
        $airport1 = $request->get('airport1');
        $terminal = $request->get('terminal');
        $service = $request->get('service');
        $terminal_parking_fee = $request->get('terminal_parking_fee');
        $vehical_num = $request->get('vehical_num');
        //$country = $request->get('country');
        $bookingeditpage = $request->get('bookingeditpage');
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

        $cur_id = $request->get('cur_id');
        $discount_coupon = $request->get('discount_coupon');
        $time1 = $hour1 . ":" . $min1 . ":00";
        $time2 = $hour2 . ":" . $min2 . ":00";
        //print_r($time1. '------'. $time2);exit;
        // new variables for early booking


        $rs_ter_interval = DB::table('terminals')
            ->select('ter_interval')
            ->where('id', '=', $terminal)
            ->first();
        $st_hours = $rs_ter_interval->ter_interval;
        $st_mins = $st_hours * 60;

        // CHECKING HOURS DIFFERENCE FOR X HOURS
        $cdatetime = date('Y-m-d H:i:s');;
        $interval = date_diff(date_create($date1 . $time1), date_create($cdatetime));
        $int_days = $interval->format('%a');
        $int_hours = 0;
        if ($int_days > 0) {
            $int_hours = $int_days * 24;
        }
        $int_hours = $int_hours + $interval->format('%h');
        $int_mins = $int_hours * 60;
        $int_mins = $int_mins + $interval->format('%i') . " ";

        // Checking for errors
        $airport_disable = 0;
        $rs_ter_interval = DB::table('airports')
            ->select('id')
            ->where('airport_disable', '=', 1)
            ->where('id', '=', $airport1)
            ->count();
        if ($rs_ter_interval == 1) {
            $airport_disable = 1; // airport closed/disabled
        }

        // check if terminal is closed for booking by admin
        $terminal_disable = 0;
        $terminals = DB::table('terminals')
            ->select('id', 'ter_name', 'ter_cap', 'ter_disable')
            ->where('id', '=', $terminal)
            ->first();
        if (($terminals->ter_disable) == 1) { // if terminal closed for booking
            $terminal_disable = 1; // terminal closed/disabled
        }

        // check if terminal is over booked
        /*======= Terminal over booked Check ======*/
        $terminal_booked = 0;
        $ter_count = DB::table('bookings')
            ->select('id')
            ->whereDate('bk_from_date', '>=', $date1 . $time1)
            ->whereDate('bk_from_date', '<=', $date2 . $time2)
            ->where('bk_ou_te', '=', $terminal)
            ->where('bk_status', '=', 2)
            ->count();
        if ($ter_count >= $terminals->ter_cap) {
            $terminal_booked = 1;
        }
        /*======= Terminal over booked Check ======*/


        //service disable check
        $service_disabled = $this->is_service_disabled($service);



        if ($airport1 == 0) {
            $Err = 1; // no airport selected
        } elseif ($airport_disable == 1) {
            $Err = 2; // airport closed/disabled
        } elseif ($terminal == 0) {
            $Err = 4; // no terminal selected
        } elseif ($terminal_disable == 1) {
            $Err = 5; // terminal disable/closed
        } elseif (($int_mins < $st_mins) and ($st_hours > 0)) {
            //print_r($int_mins.'---'.$st_mins .'---'.$st_hours);exit;
            $Err = 6; // interval between booking in less than X hours
        } elseif (strtotime($date1 . $time1) >= strtotime($date2 . $time2)) {
            $Err = 3; // datetime1 is greater than datetime2
        } elseif (strtotime($cdatetime) >= strtotime($date1 . $time1)) {
            $Err = 7; // arrival datetime passed current datetime
        } elseif ($terminal_booked == 1) {
            $Err = 8; // terminal over booked
        } elseif ($service == 0) {
            $Err = 9; // Service
        } elseif ($service_disabled == 1) {
            $Err = 10; // Service disabled
        } elseif ( $terminal_parking_fee  == 'none'){
            $Err = 11; // Service disabled
        }
        //} elseif ( $terminal_parking_fee  == 'none'){
        //   $Err = 11; // Service disabled
        // }

        // End checking for erros

        // CHECKING HOURS DIFFERENCE FOR X HOURS

        $ajax = 1;
        $discount_applied = 0;
        


        if ($Err == 0) {
            /*===========PRICING CALCULATOR=============*/
            $interval = date_diff(date_create($date1 . $time1), date_create($date2 . $time2));
            // $ser_id = $wpdb->get_var("SELECT ser_id FROM wp_booking_services WHERE airport_id =".$airport1);
            //$airport_nick = $wpdb->get_var("SELECT airport_nick FROM wp_booking_airports WHERE airport_id =".$airport1);
            //echo "<br />ser_id: ".$ser_id;
            $bk_date = date('Y-m-d H:i:s');
            $bk_date1 = $date1 . " " . $time1;
            $bk_date2 = $date2 . " " . $time2;
            $int_days = $interval->format('%a') + 1;
            $int_hours = $interval->format('%h');
            $int_mins = $interval->format('%i');



            $price_table = "regular_prices";
            $discount_table = "regular_discounts";
            // getting currency conversion rate
            //$qry = "SELECT cur_id, cur_name, cur_code, cur_symbol, cur_rate FROM wp_booking_currencies where cur_id=$cur_id";
            //$rs_cur_rate = $wpdb->get_row($qry);

            $rs_cur_rate = DB::table('currencies')
                ->select('id', 'cur_name', 'cur_code', 'cur_symbol', 'cur_rate')
                ->where('id', '=', $cur_id)
                ->first();
            //print_r($cur_id);exit;
            $cur_rate = $rs_cur_rate->cur_rate;
            $cur_symbol = $rs_cur_rate->cur_symbol;
            //print_r($int_days);
            if ($int_days <= 30) { // if days are less than 30, then select price per day
                $int_days_less_then_7 = 'cal_d' . $int_days;
                //$qry = "SELECT cal_d".$int_days." FROM wp_booking_prices$vip WHERE ter_id = $terminal";
                //$gross_price = $wpdb->get_var($qry);
                //print_r($int_days);exit;
                if ($bookingeditpage > 0) {
                    $gross_price = DB::table('fixed_prices')
                        ->select($int_days_less_then_7)
                        ->where('terminal_id', '=', $terminal)
                        ->where('service_id', '=', $service)
                        ->where('website_id', '=', $domain->id)
                        ->first();
                } else {
                    $gross_price = DB::table($price_table)
                        ->select($int_days_less_then_7)
                        ->where('terminal_id', '=', $terminal)
                        ->where('service_id', '=', $service)
                        ->where('website_id', '=', $domain->id)
                        ->first();
                }
                //print_r($gross_price);
                $gross_price = number_format($gross_price->$int_days_less_then_7, 2, '.', '');
                // print_r($gross_price);exit;
            } elseif ($int_days > 30) // if days are more than 30, then select price from 7th day + flat rate
            {
                //$qry = "SELECT cal_fix_rate, cal_d30 FROM wp_booking_prices$vip WHERE ter_id = $terminal";
                //$price = $wpdb->get_row($qry);
                if ($bookingeditpage > 0) {
                    $fixed_price = DB::table('fixed_prices')
                        ->select('cal_fix_rate', 'cal_d30')
                        ->where('terminal_id', '=', $terminal)
                        ->where('service_id', '=', $service)
                        ->where('website_id', '=', $domain->id)
                        ->first();
                    $price = DB::table($price_table)
                        ->select('cal_fix_rate', 'cal_d30')
                        ->where('terminal_id', '=', $terminal)
                        ->where('service_id', '=', $service)
                        ->where('website_id', '=', $domain->id)
                        ->first();
                    //$gross_price = $fixed_price->cal_d30 + ($price->cal_fix_rate * ($int_days - 7));
                    $days_count = $int_days - 30;
                    $gross_price = $fixed_price->cal_d30 + ($days_count * $fixed_price->cal_fix_rate);
                    $gross_price = number_format($gross_price, 2, '.', '');
                } else {
                    $price = DB::table($price_table)
                        ->select('cal_fix_rate', 'cal_d30')
                        ->where('terminal_id', '=', $terminal)
                        ->where('service_id', '=', $service)
                        ->where('website_id', '=', $domain->id)
                        ->first();
                    //$gross_price = $price->cal_d30 + ($price->cal_fix_rate * ($int_days - 7));
                    $days_count = $int_days - 30;
                    $gross_price = $price->cal_d30 + ($days_count * $price->cal_fix_rate);
                    $gross_price = number_format($gross_price, 2, '.', '');
                }
            }
            $gross_price = $gross_price * $cur_rate; // applying currency rate
            //print_r($gross_price);
            // CHECKING AND APPLYING DISCOUNT FOR TERMINAL
            if ($discount_applied == 1) { // if discount is applied


                $discount_value_rs = DB::table($discount_table)
                    ->select('dis_value')
                    ->where('terminal_id', '=', $terminal)
                    ->where('service_id', '=', $service)
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
                } else {
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
            //$qry = "SELECT cal_vat, cal_access_fee, cal_online_fee, cal_booking_fee FROM wp_booking_prices$vip WHERE ter_id = $terminal";
            //$pricing = $wpdb->get_row($qry);

            $pricing = DB::table($price_table)
                ->select('cal_vat', 'cal_access_fee', 'cal_online_fee', 'cal_booking_fee')
                ->where('terminal_id', '=', $terminal)
                ->where('service_id', '=', $service)
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

            if($terminal_parking_fee == 'P'){ // @am2022 pay access fee in website
                if ($access_fee >= 0) {
                    $net_price = $net_price + $access_fee; // add access fee
                }
            }else{
                $access_fee = 0;
            }
            

            $online_fee_amount = $online_fee_value / 100 * $net_price; // online fee applied on parking price
            $net_price = $net_price + $online_fee_amount;


            /*=========== /PRICING CALCULATOR=============*/


            /* Not Working Hours New */
            $not_working_hours_price = Domain::GetNotWorkingHoursPrice($domain->id,  $bk_date1, $bk_date2);
            $net_price = $not_working_hours_price + $net_price;
            /* /Not Working Hours New */

             /* Last minutes booking */
             $last_minutes_booking_values = Domain::calculate_last_min_booking_prices($bk_date1, 1);
             $net_price = $last_minutes_booking_values + $net_price;
             /* Last minutes booking */

            /*=============== EDIT BOOKING DETAILS SHOW HIDE PAYMENT BUTTON ==============*/
            $bkdays_am = "<span style='color:#f22525 !important;font-size: 24px;'>Parking days booked " . $int_days . " days: </span>";
            //". $int_hours ." hours "  . $int_mins . " min";


            $show_payment_buttons = 0;
            if ($bookingeditpage > 0) {

                $carwash = $request->get('carwash');
                $vehical_type_id= $request->get('vehical_type_id');
                if($carwash > 0 && $vehical_type_id > 0 ) {
                    /* ======= car_washes ======= */
                    $car_washes_price = DB::table('car_washes')
                        ->select( 'car_wash_price')
                        ->where('id', '=', $carwash)
                        ->first();
                    $car_washes_price = CarWash::find($carwash);

                    $net_price = $car_washes_price->car_wash_price + $net_price;
                    /* ======= car_washes ======= */

                }

                $booking = Booking::find($bookingeditpage);

                $carwash = $booking->carwash_in_and_out + $booking->carwash_out_only + $booking->carwash_in_only;
                $Booking_old_total = $booking->bk_total_amount - $booking->bk_discount_offer_amount + $carwash;
                if($net_price > $Booking_old_total) {
                    $show_payment_buttons = 1;
                }else{
                    $show_payment_buttons = 0;
                }

                //echo $net_price. 'KKKKKKKKKKKKKK'. $Booking_old_total .'==='. $show_payment_buttons;
                /*===============  /EDIT BOOKING DETAILS SHOW HIDE PAYMENT BUTTON ==============*/

                //echo $cur_symbol . " " . number_format($net_price, 2, '.', '');
                $price_with_symbol =  $cur_symbol . " " . number_format($net_price, 2, '.', '');
                return response()->json(['days' => $bkdays_am, 'data' => $bkdays_am . " " . $price_with_symbol, 'showhide' => $show_payment_buttons, 'bookingeditpage' => 1], 200);
            } else {
                //echo $cur_symbol . " " . number_format($net_price, 2, '.', '');
                $price_with_symbol =  $cur_symbol . " " . number_format($net_price, 2, '.', '');
                return response()->json(['days' => $bkdays_am, 'data' => $bkdays_am . " " . $price_with_symbol, 'showhide' => $show_payment_buttons, 'bookingeditpage' => 0], 200);
            }
        } else {
            //echo $Err;
            return response()->json(['data' => $Err, 'showhide' => 0, 'bookingeditpage' => 0], 200);
        }
        exit;
    }

    public function set_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function addcarwash(Request $request)
    {
        if ($request->get('add_car_wash') == 1) {
            Domain::AddNewFiledToSession('vehical_type_id', $request->get('vehical_type_id'));
            Domain::AddNewFiledToSession('carwash_in_and_out',$request->get('carwash_in_and_out'));
            Domain::AddNewFiledToSession('carwash_out_only', $request->get('carwash_out_only'));
            Domain::AddNewFiledToSession('carwash_in_only', $request->get('carwash_in_only'));
            Domain::AddNewFiledToSession('carwash_spray_only', $request->get('carwash_spray_only'));
        }else{
            Domain::AddNewFiledToSession('vehical_type_id', 0);
            Domain::AddNewFiledToSession('carwash_in_and_out',0);
            Domain::AddNewFiledToSession('carwash_out_only', 0);
            Domain::AddNewFiledToSession('carwash_in_only', 0);
            Domain::AddNewFiledToSession('carwash_spray_only', 0);
        }
        $prepared_session_data = session('booking_data');
        $cart = $this->update_cart($prepared_session_data);
        return response()->json(['mini_cart' => $cart['mini_cart'], 'cart' => $cart['cart'], 'msg' => '', 'web' => ''], 200);
    }

    

    function getcarwashhtml(Request $request)
    {
        if ($request->get('vehical_type_id') > 0) {
            $prepared_session_data = session('booking_data');
                if(!empty($prepared_session_data)){
                    if (isset($prepared_session_data['website_id']) && !empty($prepared_session_data['website_id'])) {

                        $vehical_type_id = $request->get('vehical_type_id');
                        $prepared_session_data = session('booking_data');
                        $website_id = $prepared_session_data['website_id'];
                        $currency_id = $prepared_session_data['currency1'];
                        $rs_cur_rate = DB::table('currencies')
                            ->select('id', 'cur_name', 'cur_code', 'cur_symbol', 'cur_rate')
                            ->where('id', '=', $currency_id)
                            ->first();
                        //print_r($cur_id);exit;
                        $cur_symbol = $rs_cur_rate->cur_symbol;
                        $settings = $this->get_website_settings($website_id);
                        $wash_types = array(
                            'carwash_in_and_out' => 'FULL CAR WASH (IN AND OUT)',
                            'carwash_out_only' => 'CAR WASH (ONLY OUTSIDE)',
                            'carwash_in_only' => 'CAR WASH (ONLY INSIDE)',
                            'carwash_spray_only' => 'CAR WASH (WATER SPRAY ONLY)'
                        );
                        /*if (isset($_COOKIE["bk_id"])) {
                            //$bk_id_c = $_COOKIE["bk_id"];
                            $bk_id_c = Domain::get_booking_id($_COOKIE["bk_id"]);
                            $bk_details = DB::table("bookings as bb")
                                ->join("terminals as tt", "tt.id", "=", "bb.bk_ou_te")
                                ->join("currencies as cc", "cc.id", "=", "bb.currency_id")
                                ->join("airports as aa", "aa.id", "=", "bb.airport_id")
                                ->join("services as ss", "ss.id", "=", "bb.service_id")
                                ->where('bb.id', '=', $bk_id_c)
                                ->select("bb.*", DB::raw("DATE_FORMAT(bb.bk_from_date, '%d/%m/%Y %H:%i') as bk_from_date"), DB::raw("DATE_FORMAT(bb.bk_to_date, '%d/%m/%Y %H:%i') as bk_to_date"), "aa.airport_name", "aa.airport_directions", "tt.ter_name", "cc.cur_symbol", "ss.service_name")
                                ->first();
                        }*/
            
            
                        //print_r($website_id . ' ' .  $vehical_type_id ); exit;
                        $carwash_price = $this->get_carwash_veh_type_price($website_id, $vehical_type_id);
                        $html = "";
                        foreach ($carwash_price as $key => $cwp) {
                            $description = $wash_types[$key];
                            $currency = $cur_symbol;
                            $price = $cwp;
                            $full_text = $description . '( ' . $currency . ' ' . $price . ' )';
                            $html .= '<div class="funkyradio-success">';
                            $html .= '<input type="radio" id="' . $key . '"  onclick="addcarwash();"  class="validate[required] radio"  name="cwash">';
                            $html .= '<label for="' . $key . '">' . $full_text . '</label>';
                            $html .= '</div>';
            
                        }
                        return $html;

                    }
                }
            
        }
    }


    function getcarwashhtmleditpage(Request $request)
    {
        if ($request->get('vehical_type_id') > 0) {
            $vehical_type_id = $request->get('vehical_type_id');
            $bkcurrency = $request->get('bkcurrency');
            $domain = env('APP_URL');
            $domain = Domain::get_domain_id(1);
            $wash_types = array(
                'carwash_in_and_out' => 'FULL CAR WASH (IN AND OUT)',
                'carwash_out_only' => 'CAR WASH (ONLY OUTSIDE)',
                'carwash_in_only' => 'CAR WASH (ONLY INSIDE)',
                'carwash_spray_only' => 'CAR WASH (WATER SPRAY ONLY)'
            );

            //$carwash_price = $this->get_carwash_veh_type_price($domain->id, $vehical_type_id);
            /* ======= car_washes ======= */
            $car_washes = DB::table('car_washes')
                ->select('id', 'website_id', 'vehical_type_id', 'car_wash_type', 'car_wash_price')
                ->where('website_id', '=', $domain->id)
                ->where('vehical_type_id', '=', $vehical_type_id)
                ->get();
            /* ======= car_washes ======= */
            //print_r($car_washes);
            $html = "";
            foreach ($car_washes as $cwp) {
                if($cwp->car_wash_type != 'carwash_spray_only') {
                    $description = $wash_types[$cwp->car_wash_type];
                    $currency = $bkcurrency;
                    $price = $cwp->car_wash_price;
                    $full_text = $description . '( ' . $currency . ' ' . $price . ' )';
                    $html .= '<div class="funkyradio-success">';
                    $html .= '<input type="radio" value="'.$cwp->id.'" id="' . $cwp->car_wash_type . '"  onclick="calculatePrice();"  class="validate[required] radio"  name="cwash" >';
                    $html .= '<label for="' . $cwp->car_wash_type . '">' . $full_text . '</label>';
                    $html .= '</div>';
                }
            }
            return $html;
        }
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

    public function update_cart($prepared_session_data)
    {
       
        if( !empty($prepared_session_data) && count($prepared_session_data) > 5){
            $html = "";
            //dd($prepared_session_data);
            //$errors = $this->ValidateBookingDates($prepared_session_data);
            //dd($errors);
                // get prices and sum if multiple vehicles selected
                
                // Initialize total booking price as a numeric variable
                $totalBookingPrice = 0;
                $offer_percentage = 0;
                $car_wash = 0;
                $days = 0;
                /*
                'airport1' => $prepared_session_data['airport1'],
                'terminal' => $prepared_session_data['terminal'],
                'return_terminal' => $prepared_session_data['return_terminal'],
                'service' => $prepared_session_data['service'],
                'cur_id' => $prepared_session_data['currency1'],
                'discount_coupon' => $prepared_session_data['discount_coupon'],
                'terminal_parking_fee' => $prepared_session_data['terminal_parking_fee'],
                */
                // Loop through each vehicle, call the function, and sum the booking prices
                $cart_data = [];
                foreach ($prepared_session_data['vehicles'] as $key => $vehicle) {
                    $bookingPrice = $this->handleVehicleBooking(
                        $vehicle['date1'],
                        $vehicle['date2'],
                        [
                            'website_id' => $prepared_session_data['website_id'],
                            'country' => $prepared_session_data['country'],
                            'airport1' => $prepared_session_data['airport1'],
                            'terminal' => $prepared_session_data['terminal'],
                            'return_terminal' => $prepared_session_data['return_terminal'],
                            'service' => $prepared_session_data['service'],
                            'cur_id' => $prepared_session_data['currency1'],
                            'discount_coupon' => $prepared_session_data['discount_coupon'],
                            'terminal_parking_fee' => $prepared_session_data['terminal_parking_fee'],
                            'all_services' => $prepared_session_data['all_services'],
                            'vehical_num' => $prepared_session_data['vehical_num'],
                            'bk_nop' => $prepared_session_data['bk_nop'],
                            'luggage' => $prepared_session_data['luggage'],
                            'ulze' => $prepared_session_data['ulze'],
                            'bk_ou_fl_nu' => $prepared_session_data['bk_ou_fl_nu'],
                            'bk_re_fl_nu' => $prepared_session_data['bk_re_fl_nu'],
                            //'bk_ve_ma' => $prepared_session_data['bk_ve_ma'],
                            //'bk_ve_mo' => $prepared_session_data['bk_ve_mo'],
                            //'bk_ve_co' => $prepared_session_data['bk_ve_co'],
                            //'v_contact_num' => $prepared_session_data['v_contact_num'],
                            'vehical_type_id' => $prepared_session_data['vehical_type_id'],
                            'carwash_in_and_out' => $prepared_session_data['carwash_in_and_out'],
                            'carwash_out_only' => $prepared_session_data['carwash_out_only'],
                            'carwash_in_only' => $prepared_session_data['carwash_in_only'],
                            'carwash_spray_only'  => $prepared_session_data['carwash_spray_only'],
                        ],
                        false
                    );
                    
                    // Add the booking price to the total
                    //dd($bookingPrice);
                    $totalBookingPrice += $bookingPrice['net_price'];
                    /*$offer_percentage = $bookingPrice['offer_percentage'];
                    $car_wash = $bookingPrice['car_wash'];
                    $days = $bookingPrice['days'];
                    $gross_price = $bookingPrice['gross_price'];
                    $not_working_hours_price = $bookingPrice['not_working_hours_price'];
                    $last_minutes_booking_values = $bookingPrice['last_minutes_booking_values'];*/
                    /*'net_price' => $net_price = number_format($net_price, 2, '.', ''), 
                    'days' => $int_days , 
                    'car_wash'=> $pprice,
                    'offer_percentage'=> $offer_percentage,*/
                    /*
                    'net_price' => $net_price = number_format($net_price, 2, '.', ''), 
                    'days' => $int_days , 
                    'car_wash'=> $pprice,
                    'offer_percentage'=> $offer_percentage,
                    'offer_amount' => $offer_amount,
                    'gross_price' => $gross_price,
                    'not_working_hours_price' => $not_working_hours_price,
                    'last_minutes_booking_values' => $last_minutes_booking_values,
                    'cal_online_fee' => $pricing->cal_online_fee,
                    'cal_booking_fee' => $pricing->cal_booking_fee,
                    'cal_vat' => $pricing->cal_vat,
                    'vat_amount' => $vat_amount,
                    'cal_access_fee' => $pricing->cal_access_fee*/
                    $cart_data[$key] = array(
                        'bk_from_date' => $vehicle['date1'],
                        'bk_to_date' => $vehicle['date2'],
                        'net_price' => $bookingPrice['net_price'],
                        'offer_percentage' => $bookingPrice['offer_percentage'],
                        'car_wash' => $bookingPrice['car_wash'],
                        'days' => $bookingPrice['days'],
                        'gross_price' => $bookingPrice['gross_price'],
                        'not_working_hours_price' => $bookingPrice['not_working_hours_price'],
                        'last_minutes_booking_values' => $bookingPrice['last_minutes_booking_values'],
                        'cal_online_fee' => $bookingPrice['cal_online_fee'],
                        'cal_booking_fee' => $bookingPrice['cal_booking_fee'],
                        'cal_vat' => $bookingPrice['cal_vat'],
                        'vat_amount' => $bookingPrice['vat_amount'],
                        'cal_access_fee' => $bookingPrice['cal_access_fee'],
                        'online_fee_amount' => $bookingPrice['online_fee_amount'],
                    );
                }

            }
        
       
       
            $rs_cur_rate = DB::table('currencies')
            ->select('id', 'cur_name', 'cur_code', 'cur_symbol', 'cur_rate')
            ->where('id', '=', $prepared_session_data['currency1'])
            ->first();
            //print_r($cur_id);exit;
            $cur_symbol = $rs_cur_rate->cur_symbol;

        
        if (!empty($prepared_session_data)) {
            
            //dd($prepared_session_data);
            
            $bk_type = "Regular";
            $pcdone = "";
            if ( $this->is_vip_service($prepared_session_data['service'])) {
                $bk_type = " VIP";
            }
            $linethrough = "text-decoration: line-through;";
            if($prepared_session_data['terminal_parking_fee'] == 'P'){
                $linethrough = "";
            }
            

            $html .= "<p><strong>Booking Type</strong>: " . $bk_type . '</p>';
            $html .= "<p><strong>Airport</strong>: " . Domain::GetAirportNameById($prepared_session_data['airport1']) . '</p>';
            $html .= "<p><strong>Outbound terminal</strong>: " . Domain::GetTerminalNameById($prepared_session_data['terminal']) . '</p>';
            $html .= "<p><strong>Service</strong>: " . Domain::GetServiceNameById($prepared_session_data['service']) . '</p>';
            
            foreach($cart_data as $key => $veh){
                $html .= "<hr>";
                if(count($prepared_session_data['vehicles']) > 1){
                    $html .= "<p><strong>Vechical ($key) </strong></p>";
                    
                }

                if (trim($prepared_session_data['carwash_in_and_out']) != 0) {
                    $carwash_title = 'ADD FULL CAR WASH (IN AND OUT) ';
                } elseif (trim($prepared_session_data['carwash_out_only']) != 0) {
                    $carwash_title = 'ADD CAR WASH (ONLY OUTSIDE) ';
                } elseif (trim($prepared_session_data['carwash_in_only']) != 0) {
                    $carwash_title = 'ADD CAR WASH (ONLY INSIDE) ';
                } else if ((trim($prepared_session_data['carwash_in_and_out']) == 0) && (trim($prepared_session_data['carwash_out_only']) == 0 && (trim($prepared_session_data['carwash_in_only']) == 0))) {
                    $carwash_title = 'Car Wash ';
                }

                
                
                $html .= "<p><strong>Departure date/time</strong>: " . $veh['bk_from_date'] . '</p>';
                $html .= "<p><strong>Landing date/time</strong>: " . $veh['bk_to_date'] . '</p>';
                $html .= "<p><strong>Booking interval</strong>: " . $veh['days'] . " Days</p>";
                $html .= "<p><strong>Parking price</strong>: <span>" . $cur_symbol . " " . number_format($veh['gross_price'], 2, '.', '') . "</span></p>";
                $html .= "<p><strong>Online payment fee (" . $veh['cal_online_fee'] . " %)</strong>: <span>" . $cur_symbol . " " . number_format($veh['online_fee_amount'], 2, '.', '') . " - <small>(NRA)</small></span></p>";
                $html .= "<p><strong>Booking fee</strong>: <span>" . $cur_symbol . " " . number_format($veh['cal_booking_fee'], 2, '.', '') . " - <samll>(NRA)</samll></span></p>";
                $html .= "<p><strong style='$linethrough'>Airport access fee</strong>: <span style='$linethrough'>" . $cur_symbol . " " . number_format($veh['cal_access_fee'], 2, '.', '') . " - <samll>(NRA)</samll></span></p>";
                $html .= "<p><strong>VAT ( " . $veh['cal_vat'] . " %)</strong>: <span>" . $cur_symbol . " " . number_format($veh['vat_amount'], 2, '.', '') . "</span></p>";
                if ($veh['car_wash'] > 0) {
                    $html .= "<p><strong> $carwash_title </strong>: <span>" . $cur_symbol . " " . number_format($veh['car_wash'], 2, '.', '') . "</span></p>";
                }
                $html .= "<p><strong> OUT OF WORKING HOURS </strong>: <span>" . $cur_symbol . " " . number_format($veh['not_working_hours_price'], 2, '.', '') . "</span></p>";
                $html .= "<p><strong> Last Minute Booking </strong>: <span>" . $cur_symbol . " " . number_format($veh['last_minutes_booking_values'], 2, '.', '') . "</span></p>";
    
                if ($veh['offer_percentage'] <> "") {
                    $html .= "<p><span style='color:green;'>Promotional discount offered (" . $veh['offer_percentage'] . " %): " . $cur_symbol . " " . number_format($veh['offer_percentage'], 2, '.', '') . "</span></p>";
                }
                
            }
            
        }
        
        $html .= "<hr>";
        $TOTAL_PAYABLE_AMOUNT = $totalBookingPrice;
        $html .= "<br><p class='price small'>TOTAL PAYABLE AMOUNT: <span style='color: #da0909 !important;'>" . $cur_symbol . " " . number_format($TOTAL_PAYABLE_AMOUNT, 2, '.', '') . "</span></p>";
        
        return array(
            'mini_cart'=> $cur_symbol . " " . number_format($totalBookingPrice, 2, '.', ''),
            'cart'=> $html,
        );
        //return $totalBookingPrice ;
    }

    public function get_carwash_veh_type_price($wid, $tyid)
    {
        $response = array();
        if (CarWash::where('website_id', $wid)->where('vehical_type_id', $tyid)->exists()) {
            $carwash = CarWash::where('website_id', $wid)->where('vehical_type_id', $tyid)->where('status', 1)->orderBy('id', 'DESC')->get();
            foreach ($carwash as $cw) {
                if ($cw->car_wash_type != 'carwash_spray_only') {
                    if ($cw->status) {
                        $response[$cw->car_wash_type] = $cw->car_wash_price;
                    }
                    
                }
            }
            if (!empty($response)) {
                ksort($response);
            }
        } 
        return $response;
    }

    public function Get_Carwash_Veh_Type_Price_Single($wid, $tyid, $wash_type)
    {
        if (CarWash::where('website_id', $wid)->where('vehical_type_id', $tyid)->where('car_wash_type', $wash_type)->exists()) {
            $carwash = CarWash::where('website_id', $wid)->where('vehical_type_id', $tyid)->where('car_wash_type', $wash_type)->first();
        } else {
            $carwash = CarWash::where('website_id', 1)->where('vehical_type_id', $tyid)->where('car_wash_type', $wash_type)->first();
        }

        return $carwash->car_wash_price;
    }

    public function update_cart_price_only($bk_id_c)
    {

        $bk_detail = DB::table("bookings as bb")
            ->join("terminals as tt", "tt.id", "=", "bb.bk_ou_te")
            ->join("currencies as cc", "cc.id", "=", "bb.currency_id")
            ->join("airports as aa", "aa.id", "=", "bb.airport_id")
            ->join("services as ss", "ss.id", "=", "bb.service_id")
            ->where('bb.id', '=', $bk_id_c)
            ->select("bb.*", DB::raw("DATE_FORMAT(bb.bk_from_date, '%d/%m/%Y %H:%i') as bk_from_date"), DB::raw("DATE_FORMAT(bb.bk_to_date, '%d/%m/%Y %H:%i') as bk_to_date"), "aa.airport_name", "aa.airport_directions", "tt.ter_name", "cc.cur_symbol", "ss.service_name")
            ->first();
        
        $html = "";
        if (!empty($bk_detail)) {


            $bk_type = "Regular";
            $pcdone = "";
            if ($bk_detail->bk_vip == 1) {
                $bk_type = " VIP";
            }
            //$html .= "<p><strong>Booking Type</strong>: " . $bk_type . '</p>';
            //$html .= "<p><strong>Airport</strong>: " . $bk_detail->airport_name . '</p>';
            //$html .= "<p><strong>Outbound terminal</strong>: " . $bk_detail->ter_name . '</p>';
            //$html .= "<p><strong>Service</strong>: " . $bk_detail->service_name . '</p>';
            //$html .= "<p><strong>Departure date/time</strong>: " . $bk_detail->bk_from_date . '</p>';
            //$html .= "<p><strong>Landing date/time</strong>: " . $bk_detail->bk_to_date . '</p>';
            //$html .= "<p><strong>Booking interval</strong>: " . $bk_detail->bk_days . " Days</p>";
            $carwash = $bk_detail->carwash_in_and_out + $bk_detail->carwash_out_only + $bk_detail->carwash_in_only;
            if (trim($bk_detail->carwash_in_and_out) != 0) {
                $carwash_title = 'ADD FULL CAR WASH (IN AND OUT) ';
            } elseif (trim($bk_detail->carwash_out_only) != 0) {
                $carwash_title = 'ADD CAR WASH (ONLY OUTSIDE) ';
            } elseif (trim($bk_detail->carwash_in_only) != 0) {
                $carwash_title = 'ADD CAR WASH (ONLY INSIDE) ';
            } else if ((trim($bk_detail->carwash_in_and_out) == 0) && (trim($bk_detail->carwash_out_only) == 0 && (trim($bk_detail->carwash_in_only) == 0))) {
                $carwash_title = 'Car Wash ';
            }
            if ($bk_detail->bk_discount_value > 0) { // if discount applied
                //$html .= "<p><strong>Gross price</strong>: " . $bk_detail->cur_symbol . " " . number_format($bk_detail->bk_gross_price, 2, '.', '') . "</p>";
                //$html .= "<p><strong> auto discount amount ($bk_detail->bk_discount_value %)</strong>: <span>" . $bk_detail->cur_symbol . " " . number_format($bk_detail->bk_discount_amount, 2, '.', '') . "</span></p>";
                //$html.="<hr>";
                //$html .= "<p><strong>Parking price</strong>: <span>" . $bk_detail->cur_symbol . " " . number_format($bk_detail->bk_gross_price - $bk_detail->bk_discount_amount, 2, '.', '') . "</span></p>";
                //$html.="<hr>";
                //$html .= "<p><strong>Online payment fee ($bk_detail->bk_online_fee_value %)</strong>: <span>" . $bk_detail->cur_symbol . " " . number_format($bk_detail->bk_online_fee_amount, 2, '.', '') . " - <samll>(NRA)</samll></span></p>";
                //$html .= "<p><strong>Booking fee</strong>: <span>" . $bk_detail->cur_symbol . " " . number_format($bk_detail->bk_booking_fee, 2, '.', '') . " - <samll>(NRA)</samll></span></p>";
                //$html .= "<p><strong>Airport access fee</strong>: <span>" . $bk_detail->cur_symbol . " " . number_format($bk_detail->bk_access_fee, 2, '.', '') . " - <samll>(NRA)</samll></span></p>";
                //$html .= "<p><strong>VAT ($bk_detail->bk_vat_value %)</strong>: <span>" . $bk_detail->cur_symbol . " " . number_format($bk_detail->bk_vat_amount, 2, '.', '') . "</span></p>";
                if ($carwash > 0) {
                    //$html .= "<p><strong> $carwash_title </strong>: <span>" . $bk_detail->cur_symbol . " " . number_format($carwash, 2, '.', '') . "</span></p>";
                } else {
                 //   $html .= "<p><strong> $carwash_title </strong>: <span>" . $bk_detail->cur_symbol . " " . number_format($carwash, 2, '.', '') . "</span>";
                }
                //$html .= "<p><strong> OUT OF WORKING HOURS </strong>: <span>" . $bk_detail->cur_symbol . " " . number_format($bk_detail->not_working_hours, 2, '.', '') . "</span></p>";
                //$html .= "<p><strong> Charging Amount  </strong>: <span>" . $bk_detail->cur_symbol . " " . number_format($bk_detail->charging, 2, '.', '') . "</span></p>";
                //$html .= "<p><strong> Service Charge </strong>: <span>" . $bk_detail->cur_symbol . " " . number_format($bk_detail->charging_service_charges, 2, '.', '') . "</span></p>";
            } else // if dicsount not applied
            {
                //$html .= "<hr>";
                //$html .= "<p><strong>Parking price</strong>: <span>" . $bk_detail->cur_symbol . " " . number_format($bk_detail->bk_gross_price - $bk_detail->bk_discount_amount, 2, '.', '') . "</span></p>";
                //$html .= "<hr>";
                //$html .= "<p><strong>Online payment fee ($bk_detail->bk_online_fee_value %)</strong>: <span>" . $bk_detail->cur_symbol . " " . number_format($bk_detail->bk_online_fee_amount, 2, '.', '') . " - <samll>(NRA)</samll></span></p>";
                //$html .= "<p><strong>Booking fee</strong>: <span>" . $bk_detail->cur_symbol . " " . number_format($bk_detail->bk_booking_fee, 2, '.', '') . " - <samll>(NRA)</samll></span></p>";
                //$html .= "<p><strong>Airport access fee</strong>: <span>" . $bk_detail->cur_symbol . " " . number_format($bk_detail->bk_access_fee, 2, '.', '') . " - <samll>(NRA)</samll></span></p>";
                //$html .= "<p><strong>VAT ($bk_detail->bk_vat_value %)</strong>: <span>" . $bk_detail->cur_symbol . " " . number_format($bk_detail->bk_vat_amount, 2, '.', '') . "</span></p>";
                if ($carwash > 0) {
                    //$html .= "<p><strong> $carwash_title </strong>: <span>" . $bk_detail->cur_symbol . " " . number_format($carwash, 2, '.', '') . "</span></p>";
                } else {
                    //$html .= "<p><strong> $carwash_title </strong>: <span>" . $bk_detail->cur_symbol . " " . number_format($carwash, 2, '.', '') . "</span></p>";
                }
                //$html .= "<p><strong> OUT OF WORKING HOURS </strong>: <span>" . $bk_detail->cur_symbol . " " . number_format($bk_detail->not_working_hours, 2, '.', '') . "</span></p>";
                ///$html .= "<p><strong> Charging Amount  </strong>: <span>" . $bk_detail->cur_symbol . " " . number_format($bk_detail->charging, 2, '.', '') . "</span></p>";
                //$html .= "<p><strong> Service Charge </strong>: <span>" . $bk_detail->cur_symbol . " " . number_format($bk_detail->charging_service_charges, 2, '.', '') . "</span></p>";
            }
            if ($bk_detail->bk_discount_offer_coupon <> "") {
                //$TOTAL_PAYABLE_AMOUNT = $bk_detail->bk_final_amount + $carwash + $bk_detail->not_working_hours  + $bk_detail->last_min_booking + $bk_detail->charging_service_charges + $bk_detail->charging;
                //$html .= "<p><strong><strong>Total Amount</strong>: <span>" . $bk_detail->cur_symbol . " " . number_format($bk_detail->bk_total_amount + $carwash + $bk_detail->not_working_hours, 2, '.', '') . "</span></strong></p>";
                $html .= "<p><span style='color:green;'>Promotional discount offered ($bk_detail->bk_discount_offer_value %): " . $bk_detail->cur_symbol . " " . number_format($bk_detail->bk_discount_offer_amount, 2, '.', '') . "</span></p>";
                //$html .= "<br><strong class='totalclass' > <h3>TOTAL PAYABLE AMOUNT: <span>" . $bk_detail->cur_symbol . " " . number_format($TOTAL_PAYABLE_AMOUNT, 2, '.', '') . "</span></h3></strong>";

            } else {
                
            }
            $TOTAL_PAYABLE_AMOUNT = $bk_detail->bk_total_amount + $carwash  + $bk_detail->not_working_hours + $bk_detail->last_min_booking + $bk_detail->charging_service_charges + $bk_detail->charging;
                $html .= "<br><strong class='totalclass'><h3 style='color:#da0909 !important'>TOTAL PAYABLE AMOUNT: <span>" . $bk_detail->cur_symbol . " " . number_format($TOTAL_PAYABLE_AMOUNT, 2, '.', '') . "</span></h3></strong>";
            /*if ($pcdone == 1) {
                $html .= "<strong style='color:green;'>CONGRATULATIONS !</strong> Promotion code verified...<br /><br />";
            } elseif ($pcdone == 2) {
                $html .= "<strong style='color:red;'>FAILED </strong> Promotion code not verified...<br /><br />";
            }*/
        }
        
        return $html;
    }






    public function bookingconfirm(Request $request)
    {
        $domain = env('APP_URL');
        $domain = Domain::get_domain_id(1);
        /* ======= Service ======= */
        $services = DB::table('services')
            ->where('disable', '=', 0)
            ->orderByRaw('sort ASC')
            ->get();
        /* ======= Service ======= */
        /* ======= Home PromotionOffer ======= */
        $dt = date('Y-m-d');
        $homepromo = PromotionOffer::select('offer_coupon', 'offer_percentage')
            ->where('offer_home', '=', 1)
            ->where('offer_active', '=', 1)
            ->where('website_id', $domain->id)
            ->where('offer_date1', '<=', $dt)
            ->where('offer_date2', '>=', $dt)
            ->first();
        /* ======= Home PromotionOffer ======= */
        /* ======= Service ======= */
        $settings = $this->get_website_settings($domain->id);
        /* ======= /Service ======= */
        $vehicaltype = VehicalType::all();
        /* ======= Customer ======= */
        $show_login = 1;

        if (isset($_COOKIE["cus_id"]) && isset($_COOKIE["bk_id"])) {
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

            if (isset($_COOKIE["bk_id"])) {
                //$bk_id_c = $_COOKIE["bk_id"];
                $bk_id_c = Domain::get_booking_id($_COOKIE["bk_id"]);
                $bk_details = DB::table("bookings as bb")
                    ->join("terminals as tt", "tt.id", "=", "bb.bk_ou_te")
                    ->join("terminals as t2", "t2.id", "=", "bb.bk_re_te")
                    ->join("currencies as cc", "cc.id", "=", "bb.currency_id")
                    ->join("airports as aa", "aa.id", "=", "bb.airport_id")
                    ->join("services as ss", "ss.id", "=", "bb.service_id")
                    ->join("colors as clrr", "clrr.clr_name", "=", "bb.bk_ve_co")
                    ->where('bb.id', '=', $bk_id_c)
                    ->select(
                        "bb.*",
                        DB::raw("DATE_FORMAT(bb.bk_from_date, '%d/%m/%Y %H:%i') as bk_from_date"),
                        DB::raw("DATE_FORMAT(bb.bk_to_date, '%d/%m/%Y %H:%i') as bk_to_date"),
                        DB::raw("DATE_FORMAT(bb.bk_ve_do_dt, '%d/%m/%Y %H:%i') as bk_ve_do_dt"),
                        DB::raw("DATE_FORMAT(bb.bk_ve_pu_dt, '%d/%m/%Y %H:%i') as bk_ve_pu_dt"),
                        "aa.airport_name",
                        "aa.airport_directions",
                        "tt.ter_name",
                        "t2.ter_name as re_ter_name",
                        "cc.cur_symbol",
                        "ss.service_name",
                        "clrr.clr_name"
                    )
                    ->first();

                $html = $this->update_cart_price_only($bk_id_c);

                $colors = DB::table('colors')
                    ->where('clr_disable', '=', 0)
                    ->select("id", "clr_name")
                    ->get();

                $settings['currency'] = $bk_details->cur_symbol;
                $carwash_selected = $this->get_carwash_veh_type_price($domain->id, $bk_details->vehical_type_id);
                $page_title = 'Booking confirm';
                $meta_array = array(
                    'title' =>  strtolower($page_title),
                    'description' => strtolower($page_title),
                    'keywords' => strtolower($page_title),
                    'og:locale' => 'en_US',
                    'og:type' => 'website',
                    'og:title' =>  strtolower($page_title),
                    'og:url' =>  strtolower($page_title),
                    'twitter:card' =>  strtolower($page_title),
                    'twitter:description' => strtolower($page_title),
                    'twitter:title' => strtolower($page_title),

                );
                return view($domain->website_templete . '.booking-confirm', compact('page_title', 'meta_array', 'services', 'domain', 'html', 'colors', 'settings', 'customer', 'vehicaltype',  'show_login', 'bk_details', 'homepromo'));
            }
        } else {
            return redirect('/booking')->with('success', 'Please Complete intitial bookng step.');
        }
    }

    public function addpromocode(Request $request)
    {
        if ($request->get('pc')) {
                $prepared_session_data = session('booking_data');
                if(!empty($prepared_session_data)){
                    if (isset($prepared_session_data['website_id']) && !empty($prepared_session_data['website_id'])) {
                        $pc = $request->get('pc');
                        $website_id = $prepared_session_data['website_id'];
                        $pcdone = 2;
                        $date = date("Y-m-d");
        
                        $domain = env('APP_URL');
                        $domain = Domain::get_domain_id(1);
                        /* ======= promo ======= */
                        $promotion = DB::table("promotion_offers")
                            ->where('offer_active', 1)
                            ->where('offer_date1', '<=', $date)
                            ->where('offer_date2', '>=', $date)
                            ->where('offer_coupon', 'LIKE', '%' . $pc . '%')
                            ->where('website_id', $website_id)
                            ->first();
                        if ($promotion) {
                            $pcdone = 1;
                            Domain::AddNewFiledToSession('discount_coupon', $pc);
                            
                        } else {
                            Domain::AddNewFiledToSession('discount_coupon', "");
                            $pcdone = 2;
                        }
                        if ($pcdone == 1) {
                            $msg = "<strong style='color:green;'>CONGRATULATIONS !</strong> Promotion code verified...<br /><br />";
                        } elseif ($pcdone == 2) {
                            $msg = "<strong style='color:red;'>FAILED </strong> Promotion code not verified...<br /><br />";
                        }
                        $prepared_session_data = session('booking_data');
                        $cart = $this->update_cart($prepared_session_data);
                        //$cart = "";
                        return response()->json(['mini_cart' => $cart['mini_cart'], 'cart' => $cart['cart'], 'msg' => $msg, 'web' => $website_id], 200);
                    }else{
                        return redirect('/compare-booking')->with('success', 'Please Complete intitial bookng step.');
                    }
                }else{
                    return redirect('/compare-booking')->with('success', 'Please Complete intitial bookng step.');
                }
        }
    }

    function booking_exists_check($booking_id)
    {
        $bk_id_row = DB::table('bookings')
            ->select('id', 'bk_status', 'refrence_num_common')
            ->where('id', '=', $booking_id)
            //->where('bk_status', '=', 0)
            ->first();
        return $bk_id_row;
    }

    function booking_complete_check($booking_id)
    {
        $bk_id_row = DB::table('bookings')
            ->select('id', 'bk_status')
            ->where('id', '=', $booking_id)
            ->where('bk_status', '=', 1)
            ->first();
        return $bk_id_row;
    }

    function booking_exists_check_by_customer($booking_id, $customer_id)
    {
        $bk_id_row = DB::table('bookings')
            ->select('id', 'customer_id', 'refrence_num_common')
            ->where('id', '=', $booking_id)
            ->where('customer_id', '=', $customer_id)
            //->where('bk_status', '=', 0)
            ->first();
        return $bk_id_row;
    }


    public function bookingconfirmation()
    {

        $domain = env('APP_URL');
        $domain = Domain::get_domain_id(1);
        /* ======= Service ======= */
        $services = DB::table('services')
            ->where('disable', '=', 0)
            ->orderByRaw('sort ASC')
            ->get();
        /* ======= Service ======= */
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
        $bk_id_c = session('last_booking_ref');
        if (isset($bk_id_c) && !empty($bk_id_c)) {
            
            $bk_details = DB::table("bookings as bb")
                ->join("terminals as tt", "tt.id", "=", "bb.bk_ou_te")
                ->join("currencies as cc", "cc.id", "=", "bb.currency_id")
                ->join("airports as aa", "aa.id", "=", "bb.airport_id")
                ->join("services as ss", "ss.id", "=", "bb.service_id")
                ->join("customers as cus", "cus.id", "=", "bb.customer_id")
                ->where('bb.id', '=', $bk_id_c)
                ->select(
                    "bb.*",
                    DB::raw("DATE_FORMAT(bb.bk_from_date, '%d/%m/%Y %H:%i') as bk_from_date"),
                    DB::raw("DATE_FORMAT(bb.bk_to_date, '%d/%m/%Y %H:%i') as bk_to_date"),
                    "aa.airport_name",
                    "aa.airport_directions",
                    "tt.ter_name",
                    "cc.cur_symbol",
                    "ss.service_name",
                    "cus.cus_name"
                )
                ->first();
             if($bk_details){
                $settings['currency'] = $bk_details->cur_symbol;
                $total_price_html = "";
    
                /*$carwash = $bk_details->carwash_in_and_out + $bk_details->carwash_out_only + $bk_details->carwash_in_only;
    
                if ($bk_details->bk_discount_offer_coupon <> "") {
                    $TOTAL_PAYABLE_AMOUNT = $bk_details->bk_final_amount + $carwash + $bk_details->not_working_hours + $bk_details->last_min_booking + $bk_details->charging_service_charges + $bk_details->charging;
                    $total_price_html .= "" . $bk_details->cur_symbol . " " . number_format($TOTAL_PAYABLE_AMOUNT, 2, '.', '') . "";
    
                } else {
                    $TOTAL_PAYABLE_AMOUNT = $bk_details->bk_total_amount + $carwash + $bk_details->not_working_hours + $bk_details->last_min_booking + $bk_details->charging_service_charges + $bk_details->charging;
                    $total_price_html .= "" . $bk_details->cur_symbol . " " . number_format($TOTAL_PAYABLE_AMOUNT, 2, '.', '') . "";
                }*/
                
                $total_price_html .= "" . $bk_details->cur_symbol . " " . number_format($bk_details->all_vehicals_total, 2, '.', '') . "";
                /*============= PROMO CODE==============*/
                $datepromo = date("y-m-d");
                $special_promo = "";
                /*$promotion = DB::table("promotion_offers")
                    ->where('offer_active', 1)
                    ->where('offer_special', 1)
                    ->where('offer_date1', '<=', $datepromo)
                    ->where('offer_date2', '>=', $datepromo)
                    ->where('website_id', $domain->id)
                    ->first();
                if ($promotion) {
                    $special_promo = "<div style=''><h6>YOUR SPECIAL PROMOTIONAL CODE FOR NEXT BOOKING</h6>";
                    $special_promo = "$special_promo $promotion->offer_coupon ($promotion->offer_percentage % discount) Valid till: $promotion->offer_date2</div>";
                }*/
                /*============= PROMO CODE ==============*/
                $page_title = 'Booking confirmation';
                $meta_array = array(
                    'title' =>  strtolower($page_title),
                    'description' => strtolower($page_title),
                    'keywords' => strtolower($page_title),
                    'og:locale' => 'en_US',
                    'og:type' => 'website',
                    'og:title' =>  strtolower($page_title),
                    'og:url' =>  strtolower($page_title),
                    'twitter:card' =>  strtolower($page_title),
                    'twitter:description' => strtolower($page_title),
                    'twitter:title' => strtolower($page_title),
    
                );
                session(['last_booking_ref' => '']);
                return view($domain->website_templete . '.bookingconfirmation', compact('page_title', 'meta_array', 'services', 'domain', 'settings', 'customer', 'bk_details', 'total_price_html', 'special_promo'));
             } else{
                return redirect('/')->with('success', 'Please Complete intitial bookng step.');
             } 
            
        } else {
            return redirect('/')->with('success', 'Please Complete intitial bookng step.');
        }
    }

    public function clear_cookie_booking($c_type)
    {
        session(['last_booking_ref' => '']);
        session(['bk_id' => '']);
        
    }

    public function set_last_booking_refrence($ref)
    {
        session(['last_booking_ref' => $ref]);
    }

    public function get_global_settings($sname)
    {
        $settings = DB::table("settings")
            ->where('website_id', 1)
            ->where('option_name', $sname)
            ->first();
        return $settings->option_value;
    }

    public function get_booking_currency($cur_id)
    {
        $rs_cur_rate = DB::table('currencies')
            ->select('id', 'cur_name', 'cur_code', 'cur_symbol', 'cur_rate')
            ->where('id', '=', $cur_id)
            ->first();
        return $rs_cur_rate->cur_code;
    }

  

    public function is_service_disabled($service)
    {
        $service_disabled = 0;
        $service_disabled = DB::table('services')
            ->select('*')
            ->where('disable', '=', 1)
            ->where('id', '=', $service)
            ->first();
        if ($service_disabled) {
            $service_disabled = 1;
        }
        return $service_disabled;
    }


    public function getservice_prefix($id)
    {
        $prefix = "";
        $service = DB::table('services')
            ->select('service_prefix')
            ->where('id', '=', $id)
            ->first();
        if (!empty($service->service_prefix)) {
            $prefix = $service->service_prefix;
        }
        return $prefix;
    }

    public function promocomaprepage($website_id){
        $date = date("Y-m-d");
        $promotion = DB::table("promotion_offers")
        ->where('show_compare_page', 1)
        ->where('offer_active', 1)
        ->where('offer_date1', '<=', $date)
        ->where('offer_date2', '>=', $date)
        ->where('website_id', $website_id)
        ->first();
        if ($promotion) {

            return '<span class="badge badge-primary" style="background:#6d6008; text-align:center;margin-top: 15px;">Use Promo <span class="badge badge-sec"> "' . $promotion->offer_coupon . '"</span> and get <span class="badge badge-sec">' . $promotion->offer_percentage . '%</span> Discount </span>';

        }else{
            return  "";
        }
    }
    public function is_vip_service($id)
    {
        $is_vip = 0;
        $service = DB::table('services')
            ->select('is_vip')
            ->where('id', '=', $id)
            ->first();
        if (!empty($service->is_vip)) {
            $is_vip = $service->is_vip;
        }
        return $is_vip;
    }
    public function GetAllActiveServices()
    {
        $active_services = DB::table('services')
            ->select('*')
            ->where('disable', '=', 0)
            ->orderByRaw('sort ASC')
            ->get();
        return $active_services;
    }
    public function GetAllActiveWebsites()
    {
        $active_websites = DB::table('websites')
            ->select('*')
            ->where('disable', '=', 0)
            ->where('default_site', '=', 0)
            //->orderByRaw(' ASC')
            ->get();
        return $active_websites;
    }

    public function GetAllTerminals($airport)
    {
        $active_terminals = DB::table('terminals')
            ->select('*')
             ->where('ter_disable', '=', 0)
             ->where('airport_id', '=', $airport)
            ->orderByRaw('ter_name ASC')
            ->get();
        return $active_terminals;
    }


    public function ipnnwordpay(Request $request)
    {
        $raw_post_data = file_get_contents('php://input');
        $raw_post_array = explode('&', $raw_post_data);
        $wordplayPost = array();
        foreach ($raw_post_array as $keyval) {
            $keyval = explode('=', $keyval);
            if (count($keyval) == 2)
                $wordplayPost[$keyval[0]] = urldecode($keyval[1]);
        }
        if (!empty($wordplayPost)) {
            $wordplayPost_json = json_encode($wordplayPost);
        } else {
            $wordplayPost_json = "";
        }

        if (!empty($wordplayPost)) {

            $transStatus =  $wordplayPost['transStatus'];
            if ($transStatus == 'Y') {
                $cartId =  $wordplayPost['cartId'];
                $bookingdata = $this->GetBookingById($cartId);
                if ($bookingdata) {
                    $all_booking = $this->GetAllBookingByCommonRefrenceNum($RefrenceNum);
                    foreach($all_booking as $booking){
                        $response =  $this->DatabaseEntryWorldpay($bookingdata, $wordplayPost);
                    }
                    if ($response) {
                        header("HTTP/1.1 200 OK");
                    }
                }
            }
        }

        $st_admin_name = Edenemail::get_email_settings('st_admin_name');
        $st_admin_from_email = Edenemail::get_email_settings('st_admin_from_email');
        $st_admin_email = Edenemail::get_email_settings('st_admin_email');
        $st_notification_email = Edenemail::get_email_settings('st_notification_email');
        $email_subject = Edenemail::get_email_settings('st_new_booking_subject');

        /*============== TO CUSTOMER ============*/
        $full_name = " ipn test";
        $email = "amjadalisheengmail.com";
        $from = "amjadalisheengmail.com";
        $subject = "ipn test";
        $data = array(
            'full_name' => $full_name,
            'email' => $email,
            'subject' => $subject,
            'msg' => $wordplayPost_json
        );

        Mail::send('email.contactmail', $data, function ($message) use ($from, $full_name, $subject) {
            $message->to('amjadalisheen@gmail.com', 'Eden Parking')->subject($subject);
            $message->from('edenparking@hotmail.com', 'Eden Parking ipn notifcaion');
        });
    }

    public function ipnn(Request $request)
    {

        $raw_post_data = file_get_contents('php://input');
        $raw_post_array = explode('&', $raw_post_data);
        $myPost = array();
        foreach ($raw_post_array as $keyval) {
            $keyval = explode('=', $keyval);
            if (count($keyval) == 2)
                $myPost[$keyval[0]] = urldecode($keyval[1]);
        }
        $req = 'cmd=_notify-validate';
        foreach ($myPost as $key => $value) {
            $value = urlencode($value);
            $req .= "&$key=$value";
        }




        // STEP 2: Post IPN data back to paypal to validate
        //$ch = curl_init('https://ipnpb.sandbox.paypal.com/cgi-bin/webscr');
        $ch = curl_init('https://ipnpb.paypal.com/cgi-bin/webscr');
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));

        if (!($res = curl_exec($ch))) {
            curl_close($ch);
            exit;
        }
        curl_close($ch);


        // STEP 3: Inspect IPN validation result and act accordingly

        if (strcmp($res, "VERIFIED") == 0) {
            $RefrenceNum =  $_POST['item_name'];
            $bookingdata = $this->GetBookingByRefrenceNum($RefrenceNum);
            if ($bookingdata) {
                $all_booking = $this->GetAllBookingByCommonRefrenceNum($RefrenceNum);
                foreach($all_booking as $booking){
                    $response =  $this->DatabaseEntry($booking, $_POST);
                }
                
                if ($response) {
                    header("HTTP/1.1 200 OK");
                }
            }
        } else if (strcmp($res, "INVALID") == 0) {
            // log for manual investigation

        }
    }


    public function GetBookingByRefrenceNum($RefrenceNum)
    {
        $bookingdata = DB::table("bookings")
            ->where('refrence_num_common', '=', $RefrenceNum)
            ->first();
        return $bookingdata;
    }

    public function GetAllBookingByCommonRefrenceNum($RefrenceNum)
    {
        $bookingdata = DB::table("bookings")
        ->where('refrence_num_common', '=', $RefrenceNum)
        ->get();
        return $bookingdata;
    }

    public function GetBookingById($id)
    {
        $bookingdata = DB::table("bookings")
            ->where('id', '=', $id)
            ->first();
        return $bookingdata;
    }

    public function EntryAleadydone($txn_id)
    {
        $txn_idexists = DB::table("payment_notifications")
            ->where('txn_id', '=', $txn_id)
            ->first();
        return $txn_idexists;
    }

    public function DatabaseEntry($bookingdata, $IpnData)
    {

        $return = false;

        $txn_idexists =  $this->EntryAleadydone($IpnData['txn_id']);
        if ($txn_idexists) {
            $return = true;
        } else {

            $bk_id_c = $bookingdata->id;
            $PaymentNotification = new PaymentNotification([
                'booking_id' => $bk_id_c,
                'payment_reciever' => 'paypal',
                'payment_status' => $IpnData['payment_status'],
                'mc_gross' => $IpnData['mc_gross'],
                'txn_id' => $IpnData['txn_id'],
                'item_name' => $IpnData['item_name'],
                'log' => serialize($IpnData)
            ]);
            $PaymentNotification->save();
            $insert_id = $PaymentNotification->id;
            if ($insert_id) {
                $this->SendConfirmationEmail($bookingdata);
                $return = true;
            }
        }

        return $return;
    }

    public function DatabaseEntryWorldpay($bookingdata, $IpnData)
    {

        $return = false;

        $txn_idexists =  $this->EntryAleadydone($IpnData['transId']);
        if ($txn_idexists) {
            $return = true;
        } else {

            $bk_id_c = $bookingdata->id;
            $PaymentNotification = new PaymentNotification([
                'booking_id' => $bk_id_c,
                'payment_reciever' => 'worldpay',
                'payment_status' => "pending",
                'mc_gross' => $IpnData['amount'],
                'txn_id' => $IpnData['transId'],
                'item_name' => $IpnData['desc'],
                'log' => serialize($IpnData)
            ]);
            $PaymentNotification->save();
            $insert_id = $PaymentNotification->id;
            if ($insert_id) {
                $this->SendConfirmationEmail($bookingdata);
                $return = true;
            }
        }

        return $return;
    }

    public function SendConfirmationEmail($bookingdata)
    {
        $bk_id_c = $bookingdata->id;
        $data = Edenemail::send_booking_email($bk_id_c);
        $st_admin_name = Edenemail::get_email_settings('st_admin_name');
        $st_admin_from_email = Edenemail::get_email_settings('st_admin_from_email');
        $st_admin_email = Edenemail::get_email_settings('st_admin_email');
        $email_subject = Edenemail::get_email_settings('st_new_booking_subject');
        $st_notification_email = Edenemail::get_email_settings('st_notification_email');


        /* -------------- @new email template ---------------- */
        $Email_Template = "email.common";
        /* -------------- /@new email template ---------------- */
        $email_subject = str_replace("New", "Confirmation", $email_subject);
        $email_subject = str_replace("Confirmation Booking details", "Booking Confirmation details", $email_subject);

        if (in_array($data['txn_payment_status'], array('Refunded'))) {
            $email_subject = str_replace("Confirmation", "Cancelled/Refunded", $email_subject);
        }

        $to_name = $st_admin_name;
        /*============== TO ADMIN ============*/
     
        /*============== TO amjad ============*/
        $to_email = "amjadalisheen@gmail.com";
        $email_subject_amjad = $email_subject . ' amjad';
        $to_name = $data['cus_title'] . ' ' . $data['cus_name'];
        Mail::send($Email_Template . '.basic', $data, function ($message) use ($st_admin_from_email, $st_admin_name, $email_subject_amjad, $to_email, $to_name) {
            $message->to($to_email, $to_name)->subject($email_subject_amjad);
            $message->from($st_admin_from_email, $st_admin_name);
        });
        Mail::send($Email_Template . '.detailed', $data, function ($message) use ($st_admin_from_email, $st_admin_name, $email_subject_amjad, $to_email, $to_name) {
            $message->to($to_email, $to_name)->subject($email_subject_amjad);
            $message->from($st_admin_from_email, $st_admin_name);
        });
        /*============== TO amjad ============*/

        /*============== Notifications Emails ============*/
        if (!empty($st_notification_email)) {
            $email_to = explode(";", $st_notification_email);
            for ($x = 0; $x < count($email_to); $x++) {
                Mail::send($Email_Template . '.detailed', $data, function ($message) use ($st_admin_from_email, $st_admin_name, $email_subject, $email_to, $to_name) {
                    $message->to($email_to, $to_name)->subject($email_subject);
                    $message->from($st_admin_from_email, $st_admin_name);
                });
            }
        }
        /*============== Notifications Emails ============*/
        /*============== TO ADMIN ============*/

        /*============== TO CUSTOMER ============*/
        if(!empty($data['email'])){
            $to_email = $data['cus_email'];
            $to_name = $data['cus_title'] . ' ' . $data['cus_name'];
            Mail::send($Email_Template . '.basic', $data, function ($message) use ($st_admin_from_email, $st_admin_name, $email_subject, $to_email, $to_name) {
                $message->to($to_email, $to_name)->subject($email_subject);
                $message->from($st_admin_from_email, $st_admin_name);
            });
        }
        if(!empty($data['cus_email_1'])){
            $to_email = $data['cus_email_1'];
            $to_name = $data['cus_title'] . ' ' . $data['cus_name'];
            Mail::send($Email_Template . '.basic', $data, function ($message) use ($st_admin_from_email, $st_admin_name, $email_subject, $to_email, $to_name) {
                $message->to($to_email, $to_name)->subject($email_subject);
                $message->from($st_admin_from_email, $st_admin_name);
            });
        }
        /*============== TO CUSTOMER ============*/

        /*============== TO COMPARE WEBSITE ============*/
        if(!empty($data['email'])){
            $to_email = $data['email'];
            $to_name = $data['website_name'];
            Mail::send($Email_Template . '.detailed', $data, function ($message) use ($st_admin_from_email, $st_admin_name, $email_subject, $to_email, $to_name) {
                $message->to($to_email, $to_name)->subject($email_subject);
                $message->from($st_admin_from_email, $st_admin_name);
            });
        }
        if(!empty($data['alternate_email'])){
            $to_email = $data['alternate_email'];
            $to_name = $data['website_name'];
            Mail::send($Email_Template . '.detailed', $data, function ($message) use ($st_admin_from_email, $st_admin_name, $email_subject, $to_email, $to_name) {
                $message->to($to_email, $to_name)->subject($email_subject);
                $message->from($st_admin_from_email, $st_admin_name);
            });
        }
        /*============== /TO COMPARE WEBSITE ============*/


        
    }

    public function updatecharging(Request $request)
    {
        //if ($request->get('add_car_wash') == 1) {
        if (isset($_COOKIE["bk_id"])) {

            //bk_id_c = $_COOKIE["bk_id"];
            $bk_id_c = Domain::get_booking_id($_COOKIE["bk_id"]);
            $booking_partial = Booking::find($bk_id_c);

            $domain = env('APP_URL');
            $domain = Domain::get_domain_id(1);
            $settings = $this->get_website_settings($domain->id);
            //dd($settings);
            $charging = $request->get('charging');
            if ($charging > 0) {
                $booking_partial->charging = $charging;
                $booking_partial->charging_service_charges  = $settings['charging_service_charges_' . $charging];
            } else {
                $booking_partial->charging_service_charges = 0;
                $booking_partial->charging = 0;
            }
            $charging_fee = "";
            if ($booking_partial->charging_service_charges == 0) {
                $charging_fee = "Service Charge Free";
            } else {
                $charging_fee = " Service Charge £ " . $booking_partial->charging_service_charges;
            }

            $updated = $booking_partial->save();

            if ($updated) {
                $cart = $this->update_cart_price_only($bk_id_c);
                return response()->json(['data' => $cart, 'charging_fee' => $charging_fee], 200);
            } else {
                return response()->json(['code' => '404'], 404);
            }
        }
        //}
    }
}
