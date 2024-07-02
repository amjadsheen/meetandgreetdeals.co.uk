<?php
/**
 * Created by PhpStorm.
 * User: YAWAR
 * Date: 7/14/2019
 * Time: 7:53 PM
 */

namespace App\Classes;
use Illuminate\Support\Facades\DB;
use App\Website;
use App\NotWorkingHours;
use Carbon\Carbon;

class Domain
{

    static public function get_domain_id($id) {
        //$websites = Website::all('id', 'website_name');
        //$website = Website::where('website_url', $url)->first();
        $website = Website::where('id', 1)->first(); //@am return website with id 1
        //dd($website);
        //return $options.'llll';
        return $website;

    }

     static public function GetDomianById($id) {
        $website = Website::where('id', $id)->first();
        return $website;
    }

    static public function get_booking_id($id) {
        return Domain::eden_simple_crypt($id,'d');
    }

    static public function get_customer_id($id) {
        return Domain::eden_simple_crypt($id, 'd');
    }

    static public function set_encripted_ids($id) {
        return Domain::eden_simple_crypt($id, 'e');
    }

   static function eden_simple_crypt( $string, $action = 'd' ) {
        // you may change these values to your own
        $secret_key = 'alamalabal';
        $secret_iv = 'sheen';

        $output = false;
        $encrypt_method = "AES-256-CBC";
        $key = hash( 'sha256', $secret_key );
        $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );

        if( $action == 'e' ) {
            $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
        }
        else if( $action == 'd' ){
            $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
        }

        return $output;
    }

    static function copy_images_to_public($image){
        return true;
        /*$file = env('ImagesSrc').$image;
        $newfile = env('ImagesDes').$image;
        if(!file_exists($newfile)) {
            if(!copy($file,$newfile)){
                //echo "failed to copy $file";
            }
        }*/

    }

    static function GetNotWorkingHoursPrice($domain,$bk_date1, $bk_date2){
        $currentTime_1 = date('H:i:s', strtotime($bk_date1));
        $currentTime_2 = date('H:i:s', strtotime($bk_date2));
        $NOTWORKINGHOURSCHARGES_1 = 0;
        $nhrs = DB::table('not_working_hours')
              ->where('website_id', $domain)
             ->get();
            foreach($nhrs as $nffff){
                $startTime =  date('H:i:s', strtotime($nffff->not_working_start_time));
                $endTime =  date('H:i:s', strtotime($nffff->not_working_end_time));

                if(  ( ($currentTime_2 >= $startTime) && ($currentTime_2 <= $endTime) ) || ($currentTime_1 >= $startTime) && ($currentTime_1 <= $endTime)  ){
                    $NOTWORKINGHOURSCHARGES_1  = $nffff->charges;
                }
               
            }
           return $NOTWORKINGHOURSCHARGES_1  ;
    }

    static function calculate_last_min_booking_prices($departure_date_orignal, $camparison_website){
        $last_min_bookings_price = Domain::get_last_min_booking_prices($camparison_website);
        $departure_date = Carbon::parse($departure_date_orignal);
        $currentDateTime = Carbon::now();
        $hoursDifference = $currentDateTime->diffInHours($departure_date);
        $last_minutes_booking_values = 0;
        if(!empty($last_min_bookings_price)){
            if (array_key_exists($hoursDifference, $last_min_bookings_price)) {
                $last_minutes_booking_values = $last_min_bookings_price[$hoursDifference];
            } 
        }
        return $last_minutes_booking_values;
    }

    static function get_last_min_booking_prices($camparison_website){
        $get_last_min_booking_prices_array= [];
        $lmb = DB::table("last_minute_bookings as lmb")
                ->select("lmb.*")
                ->where('lmb.website_id', $camparison_website)
                ->get()
                ->toArray();
        foreach($lmb as $lm){
            $get_last_min_booking_prices_array[$lm->hour] = $lm->charges;
        }  
        return $get_last_min_booking_prices_array;
    }

    static public function generate_refrence_num_extra($departure_terminal, $return_terminal, $departure_date, $return_date) {
        //split $departure_date
        $departure_date_only = date('y-m-d', strtotime( $departure_date));
        $departure_time_only = date('H:i', strtotime( $departure_date));
        $new_departure_satetime = $departure_date_only .'T'.$departure_time_only;
    
        //split $return_date
        $return_date_only = date('y-m-d', strtotime( $return_date));
        $return_time_only = date('H:i', strtotime( $return_date));
        $new_return_date_time = $return_date_only .'T'.$return_time_only;
        
        return $departure_terminal . '-' . $new_departure_satetime . '/' . $return_terminal . '-' . $new_return_date_time;
        }
    
    static function checkRequestData($request_data) {
        //var_dump($request_data);
        $required_keys_and_types = [
            "country" => "string",
            "airport1" => "string",
            "terminal" => "string",
            "return_terminal" => "string",
            "service" => "string",
            "date1" => "string",
            "date2" => "string",
            "vehical_num" => "string"
        ];

        // Check if all required keys exist in the $request_data array and their values have the expected data types
        foreach ($required_keys_and_types as $key => $expected_type) {
            if (!array_key_exists($key, $request_data) || gettype($request_data[$key]) !== $expected_type) {
                // Return false if any key is missing or its value has an unexpected data type
                //dd('false');
                return false;
            }
        }
        //dd('true');
        // Return true if all required keys and their values have the expected data types
        return true;

       
    }
    static function SetSessionDataStore($request_data) {
          
            // Retrieve the existing session data
        $exsting_session_date = session('booking_data', []);

        // Initialize an empty vehicles array
        $vehicles = [];

        // Initialize the index starting from 1
        $index = 1;

        foreach ($request_data['date1'] as $key => $value) {
            $vehicles[$index] = [
                'date1' => $value,
                'date2' => $request_data['date2'][$key] ?? null,
                'bk_ve_ma' => $request_data['bk_ve_ma'][$key] ?? null,
                'bk_ve_mo' => $request_data['bk_ve_mo'][$key] ?? null,
                'bk_ve_co' => $request_data['bk_ve_co'][$key] ?? '',
                'v_contact_num' => $request_data['v_contact_num'][$key] ?? null,
                'bk_re_nu' => $request_data['bk_re_nu'][$key] ?? null,
                //'vehical_type_id' => $requset_data['vehical_type_id'] ?? 0,
                //'carwash_in_and_out' => $requset_data['carwash_in_and_out'] ?? 0,
                //'carwash_out_only' => $requset_data['carwash_out_only'] ?? 0,
                //'carwash_in_only' => $requset_data['carwash_in_only'] ?? 0,
                //'carwash_spray_only' => $requset_data['carwash_spray_only']?? 0,
            ];
            $index++;
        }

        // Add the vehicles array to the request data
        $request_data['vehicles'] = $vehicles;

        // Merge the existing session data with the request data
        // Request data values take precedence
        $combined_data = array_merge($exsting_session_date, $request_data);

        // Store the combined data back into the session
        session(['booking_data' => $combined_data]);
       // echo"<pre>"; print_r($combined_data); echo"</pre>";
        return $combined_data;
    }
    static function AddNewFiledToSession($field,$value) {
        $prepared_session_data = session('booking_data');
        if(is_array($prepared_session_data)) {
            $prepared_session_data[$field] = $value;
            session(['booking_data' => $prepared_session_data]);
        } else {
            $prepared_session_data = [
                $field => $value
            ];
            session(['booking_data' => $prepared_session_data]);
        }
        
    }
    static function SetSessionData($requset_data) {
        
        $booking_data = session('booking_data');
        //dd($booking_data);
        $update_vechicals_time = true;
        if(!empty($booking_data)){
            if(key_exists("vehicles", $booking_data)){
                $existing_veh = count($booking_data['vehicles']);
                if($requset_data['vehical_num'] == $existing_veh){
                    $update_vechicals_time = true;
                    $existing_vechicals = $booking_data['vehicles'];
                }
            }
        }
        
        

        // Initialize an empty vehical array
        $vehical = [];
        $vehical_num = 1;
        // Check if 'bk_nop' exists in the request data, and add it if it doesn't
        if (!isset($request_data['bk_nop'])) {
            $requset_data['bk_nop'] = 1; // default value
        }
        if (!isset($request_data['luggage'])) {
            $requset_data['luggage'] = "Not sure"; // default value
        }
        if (!isset($request_data['ulze'])) {
            $requset_data['ulze'] = "Not sure"; // default value
        }
        if (!isset($request_data['bk_ou_fl_nu'])) {
            $requset_data['bk_ou_fl_nu'] = ""; // default value
        }
        if (!isset($request_data['bk_re_fl_nu'])) {
            $requset_data['bk_re_fl_nu'] = ""; // default value
        }
        if (!isset($request_data['bk_re_nu'])) {
            $requset_data['bk_re_nu'] = ""; // default value
        }
        if (!isset($request_data['bk_ve_ma'])) {
            $requset_data['bk_ve_ma'] = ""; // default value
        }
        if (!isset($request_data['bk_ve_mo'])) {
            $requset_data['bk_ve_mo'] = ""; // default value
        }
        if (!isset($request_data['bk_ve_co'])) {
            $requset_data['bk_ve_co'] = ""; // default value
        }
        if (!isset($request_data['v_contact_num'])) {
            $requset_data['v_contact_num'] = ""; // default value
        }
        
        if (!isset($request_data['vehical_type_id'])) {
            $requset_data['vehical_type_id'] = 0; // default value
        }
        if (!isset($request_data['carwash_in_and_out'])) {
            $requset_data['carwash_in_and_out'] = 0; // default value
        }
        if (!isset($request_data['carwash_out_only'])) {
            $requset_data['carwash_out_only'] = 0; // default value
        }
        if (!isset($request_data['carwash_in_only'])) {
            $requset_data['carwash_in_only'] = 0; // default value
        }
        if (!isset($request_data['carwash_spray_only'])) {
            $requset_data['carwash_spray_only'] = 0; // default value
        }
        
        // Check if vehical_num is set and not empty
        if (isset($requset_data['vehical_num']) && !empty($requset_data['vehical_num'])) {
            // Get the vehical_num from the request data
            $vehical_num = intval($requset_data['vehical_num']);

            // Loop from 1 to vehical_num
            for ($i = 1; $i <= $vehical_num; $i++) {
                // Set the date1 and date2 for each vehical
                $vehical[$i] = [
                    "date1" => $requset_data['date1'],
                    "date2" => $requset_data['date2'],
                    'bk_ve_ma' => $requset_data['bk_ve_ma'],
                    'bk_ve_mo' => $requset_data['bk_ve_mo'],
                    'bk_ve_co' => $requset_data['bk_ve_co'],
                    'bk_re_nu' => $requset_data['bk_re_nu'],
                    'v_contact_num' => $requset_data['v_contact_num'],
                    //'vehical_type_id' => $requset_data['vehical_type_id'],
                    //'carwash_in_and_out' => $requset_data['carwash_in_and_out'],
                    //'carwash_out_only' => $requset_data['carwash_out_only'],
                   // 'carwash_in_only' => $requset_data['carwash_in_only'],
                    //'carwash_spray_only' => $requset_data['carwash_spray_only'],

                ];
            } 
        }
        if(!$update_vechicals_time){
            $requset_data['vehicles'] = $existing_vechicals;
        }else{
            $requset_data['vehicles'] = $vehical;
        }
        

        return $requset_data;
       
    }
    
}
