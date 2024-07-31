<?php

namespace App\Http\Controllers\Admin;

use App\Classes\Domain;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use App\Classes\Edenemail;
use Mail;
use QrCode;
use App\Agents;
use App\Booking;
use App\Website;
use App\Country;
use App\Terminal;
use App\Airport;
use App\Color;
use App\VehicalType;
use App\CarWash;
class ManualbookingController  extends Controller
{
        /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        /* ======= Service ======= */
        $countries = DB::table('countries')
            //->orderByRaw('sort ASC')
            ->get();
        /* ======= Service ======= */

        /* ======= Websites ======= */
        $websites = DB::table('websites')
            ->get();
        /* ======= Websites ======= */

        /* ======= Service ======= */
        $services = DB::table('services')
            //->where('disable', '=', 0)
            ->orderByRaw('sort ASC')
            ->get();
        /* ======= Service ======= */
        /* ======= airport ======= */
        $airports = DB::table('airports')
            ->select('id','airport_name','airport_disable')
            //->where('airport_disable', '=', 0)
            ->get();
        /* ======= airport ======= */

        /* ======= currencies ======= */
        $currencies = DB::table('currencies')
            ->select('id','cur_name','cur_code','cur_symbol','cur_rate')
            ->where('cur_disable', '=', 0)
            ->get();
        /* ======= currencies ======= */
        $vehicaltype = VehicalType::all();

        /* ======= Agents ======= */
        $agents = DB::table('agents')
            ->select('id','agt_company')
            ->get();
        /* ======= Agents ======= */

        /* ======= Color ======= */
        $colors = DB::table('colors')
            ->where('clr_disable', '=', 0)
            ->select("id", "clr_name")
            ->get();
        /* ======= Color ======= */

        $terminal_access_options = array(
            // 'N' => 'Pay Yourself Terminal Access fee ( Drop of Chargers) upon Departure and Arrival.',
            'P' => 'Add Now (Departure & Arrival 25 mins Only)', 
            'N' => 'Customer are responsible to pay Terminal fee upon Departure and Arrival(Not Added)',
             
         );

        $title = "Booking - Manual Order";
        return view('admin.manualorder.create', compact( 'title','countries','services','airports','currencies','colors','vehicaltype','agents', 'websites', 'terminal_access_options'));
     }









    public function store(Request $request){
       
        $access_fee = 0;
        $website_id = $request->get('website_id');
        $bk_date = $request->get('bk_date');
        $bk_ref = $request->get('bk_ref');
        $service = $request->get('service');
        $country = $request->get('country');
        $airport_id = $request->get('airport_id');
        $bk_ou_te = $request->get('bk_ou_te');
        $bk_re_te = $request->get('bk_re_te');
        $bk_from_date = $request->get('bk_from_date');
        $bk_to_date = $request->get('bk_to_date');
        $cur_id = $request->get('cur_id');
        //$bk_vip = $request->get('bk_vip');
        $bk_total_amount = $request->get('bk_total_amount');
        $bk_final_amount = $request->get('bk_total_amount_final');
        $bk_payment_method = $request->get('bk_payment_method');
        $bk_nop = $request->get('bk_nop');
        $bk_ou_fl_nu = $request->get('bk_ou_fl_nu');
        $bk_re_fl_nu = $request->get('bk_re_fl_nu');
        $bk_re_nu = $request->get('bk_re_nu');
        $bk_ve_ma = $request->get('bk_ve_ma');
        $bk_ve_mo = $request->get('bk_ve_mo');
        $bk_ve_co = $request->get('bk_ve_co');
        $bk_ve_do_dt = $request->get('bk_ve_do_dt');
        $bk_ve_pu_dt = $request->get('bk_ve_pu_dt');
        $cus_title = $request->get('cus_title');
        $cus_name = $request->get('cus_name');
        $cus_surname = $request->get('cus_surname');
        $cus_email = $request->get('cus_email');
        $cus_company = $request->get('cus_company');
        $cus_tele = $request->get('cus_tele');
        $cus_cell = $request->get('cus_cell');
        $cus_cell2 = $request->get('cus_cell2');
        $cus_homename = $request->get('cus_homename');
        $cus_address = $request->get('cus_address');
        $cus_town = $request->get('cus_town');
        $cus_county = $request->get('cus_county');
        $cus_postcode = $request->get('cus_postcode');
        $cus_country = $request->get('cus_country');
        $bk_note = $request->get('bk_note');
        if(empty($bk_note)){
            $bk_note = $bk_ref;
        }
        $agt_id = $request->get('agt_id');
        $cwash = $request->get('cwash');
        $access_fee = $request->get('bk_access_fee');
        //$terminal_parking_fee = $request->get('terminal_parking_fee');
        
        // if( in_array($service, array(2,4))){ // 2,4 vip services
        //     $bk_vip = 1;
        // }else{
            
        // }
        $bk_vip = 0;
        $email_to_client = 0;
        $email_to_admins = 0;

        $email_to_client = $request->get('email_to_client');
        $email_to_admins = $request->get('email_to_admins');

        /* ======= Settings ======= */
        $settings = Edenemail::get_website_settings($website_id);
        /* ======= Settings ======= */

        /* Get Domain data */
        $domain = Domain::GetDomianById($website_id);
        /* /Get Domain data */




        $bk_date = str_replace('/', '-', $bk_date);
        $bk_date = date('Y-m-d', strtotime($bk_date));


        $bk_from_date = str_replace('/', '-', $bk_from_date);
        $bk_date1 = date('Y-m-d H:i:00', strtotime($bk_from_date));

        $bk_to_date = str_replace('/', '-', $bk_to_date);
        $bk_date2 = date('Y-m-d H:i:00', strtotime($bk_to_date));


        $bk_ve_do_dt = str_replace('/', '-', $bk_ve_do_dt);
        $bk_ve_do_dt = date('Y-m-d H:i:00', strtotime($bk_ve_do_dt));


        $bk_ve_pu_dt = str_replace('/', '-', $bk_ve_pu_dt);
        $bk_ve_pu_dt = date('Y-m-d H:i:00', strtotime($bk_ve_pu_dt));


        /* carwash*/
        if(!empty($cwash)){

           $cc =  explode('$', $cwash);
            $col = $cc[0];
            $val = $cc[1];
        }else{
            $col ="carwash_spray_only";
            $val = 0;
        }

        /* carwash*/

       $bk_ref_exist = $this->booking_bk_ref_exists($bk_ref);
      if (!empty($bk_ref_exist)) { // booking exists for customer
          return response()->json([ 'data'=>'Booking Refrence Already Exists'], 200);

      } else {
          if (!empty($cus_name)) {
              $add_customers = DB::table('customers')->insert(
                  array(
                      'cus_title' => $cus_title,
                      'cus_name' => $cus_name,
                      'cus_email' => $cus_email,
                      'cus_email_1' => $cus_email,
                      'cus_password' => '',
                      'cus_company' => $cus_company,
                      'cus_surname' => $cus_surname,
                      'cus_tele' => $cus_tele,
                      'cus_cell' => $cus_cell,
                      'cus_address' => $cus_address,
                      'cus_town' => $cus_town,
                      'cus_county' => $cus_county,
                      'cus_postcode' => $cus_postcode,
                      'cus_oneoff' => 1,
                      'cud_date' => date('Y-m-d'),
                      'cus_cell2' => $cus_cell2,
                      'cus_homename' => $cus_homename,
                      'cus_country' => $cus_country,
                      'cus_status' => 0
                  )
              );
              if ($add_customers == 1) {

                  $customer_id = DB::getPdo()->lastInsertId();
                  $vat_value = 0;
                  $vat_amount = 0;
                  $online_fee_value = 0;
                  $online_fee_amount = 0;
                  $booking_fee = 0;
                  

                  $diff = date_diff(date_create($bk_date1), date_create($bk_date2));
                  $int_days = $diff->format("%a");
                  $int_hours = $diff->format("%h");
                  $int_mins = $diff->format("%i");

                  $gross_price = 0;
                  $discount_value = 0;
                  $discount_amount = 0;
                  $net_price = 0;
                  $discount_coupon = "";

                  $bookingsave = new Booking([
                      'country_id' => $country,
                      'service_id' => $service,
                      'website_id' => $website_id,
                      'currency_id' => $cur_id,
                      'bk_vat_value' => $vat_value,
                      'bk_vat_amount' => $vat_amount,
                      'bk_online_fee_value' => $online_fee_value,
                      'bk_online_fee_amount' => $online_fee_amount,
                      'bk_booking_fee' => $booking_fee,
                      'bk_access_fee' => $access_fee,
                      'airport_id' => $airport_id,
                      'bk_ref' => $bk_ref,
                      'bk_date' => $bk_date,
                      'bk_from_date' => $bk_date1,
                      'bk_to_date' => $bk_date2,
                      'bk_days' => $int_days,
                      'bk_hours' => $int_hours,
                      'bk_mins' => $int_mins,
                      'bk_gross_price' => $gross_price,
                      'bk_discount_value' => $discount_value,
                      'bk_discount_amount' => $discount_amount,
                      'bk_total_amount' => $bk_final_amount,
                      'bk_gross_price' => $bk_total_amount,
                      'bk_final_amount' => $bk_final_amount,
                      'bk_discount_coupon' => $discount_coupon,
                      'bk_ou_te' => $bk_ou_te,
                      'bk_ve_do_dt' => $bk_ve_do_dt,
                      'bk_ve_pu_dt' => $bk_ve_pu_dt,
                      'bk_vip' => $bk_vip,
                      'customer_id' => $customer_id,
                      'bk_ou_fl_nu' => $bk_ou_fl_nu,
                      'bk_re_fl_nu' => $bk_re_fl_nu,
                      'bk_re_te' => $bk_re_te,
                      'bk_re_nu' => $bk_re_nu,
                      'bk_ve_ma' => $bk_ve_ma,
                      'bk_ve_mo' => $bk_ve_mo,
                      'bk_ve_co' => $bk_ve_co,
                      'bk_nop' => $bk_nop,
                      'bk_note' => $bk_note,
                      'agent_id' => $agt_id,
                      'bk_status' => 1,
                      'bk_payment_method' => $bk_payment_method,
                      $col => $val,
                      //'terminal_parking_fee' => $terminal_parking_fee
                  ]);
                  $bookingsave->save();
                  $insert_id = $bookingsave->id;
                  if($insert_id){
                      $booking_update = Booking::find($insert_id);

                      /*  Not Working Hours*/
                      /*$currentTime = date("H:i",strtotime($bk_date1));
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

                      /* /Not Working Hours */
                      /* Not Working Hours New */
                        $booking_update->not_working_hours = Domain::GetNotWorkingHoursPrice($website_id, $bk_date1, $bk_date2 );
                        /* /Not Working Hours New */
                      $booking_update->save();

                      /*======================== QRCODE ===========================*/
                     
                      QrCode::size(500)
                            ->margin(20)
                            ->errorCorrection('L')
                            ->format('png')
                            ->generate($bk_ref, storage_path('/app/public/qrcodes/') . $insert_id . '.png');


                      /*======================== GET EMAIL CONTENT ===========================*/
                      $data = Edenemail::send_booking_email($insert_id);
                      $st_admin_name = Edenemail::get_email_settings('st_admin_name');
                      $st_admin_from_email = Edenemail::get_email_settings('st_admin_from_email');
                      $st_admin_email = Edenemail::get_email_settings('st_admin_email');
                      $st_notification_email = Edenemail::get_email_settings('st_notification_email');
                      $email_subject = Edenemail::get_email_settings('st_new_booking_subject');
                      /*======================== GET EMAIL CONTENT ===========================*/

                       /* -------------- @new enail template ---------------- */
                       $Email_Template = "email.eden"; //@new enail template
                       if(in_array($domain->website_templete, array('eden'))){ // if eden use eden
                           $Email_Template = "email.".$domain->website_templete;
                       }else{
                           $Email_Template = "email.common";
                           $email_subject = str_replace("Eden", $domain->website_name, $email_subject);
                           $st_admin_name =  str_replace("Eden", $domain->website_name, $st_admin_name);
                       }
                       /* -------------- /@new enail template ---------------- */
                       
                      if($email_to_admins == 1) {
                          /*============== TO ADMIN ============*/
                          $to_email = $st_admin_email;
                          $to_name = $st_admin_name;
                          Mail::send($Email_Template.'.detailed', $data, function ($message) use ($st_admin_from_email, $st_admin_name, $email_subject, $to_email, $to_name) {
                              $message->to($to_email, $to_name)->subject($email_subject);
                              $message->from($st_admin_from_email, $st_admin_name);
                          });
                          /*============== TO ADMIN ============*/

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
                    }

                      if($email_to_client == 1) {
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
                      }


                      return response()->json([ 'data'=>'Booking Added Succesfully Ref# is '.$bk_ref.''], 200);
                  }else{
                      return response()->json([ 'data'=>'Something Went Wrong Try Again Later.'], 200);
                  }

              }
          }
      }
    }




















    // Fetch Airorts
    public function getairorts($countryid = 0)
    {
        $airports['data'] = DB::table('airports')
            ->where('country_id', '=', $countryid)
            ->get();
        echo json_encode($airports);
        exit;
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
    function getcarwashhtml($vehical_type_id){
        if ($vehical_type_id) {
            $wash_types = array(
                'carwash_in_and_out' => 'FULL CAR WASH (IN AND OUT)',
                'carwash_out_only'=>'CAR WASH (ONLY OUTSIDE)',
                'carwash_in_only'=>'CAR WASH (ONLY INSIDE)',
                'carwash_spray_only'=>'CAR WASH (WATER SPRAY ONLY)'
            );

            //print_r($settings); exit;
            $carwash_price = $this->get_carwash_veh_type_price( $vehical_type_id );
            $html ="";
            foreach ($carwash_price as $key=>$cwp){
                $description = $wash_types[$key];
                $currency = "£";
                $price = $cwp;
                $full_text= $description .'( '.  $currency .' '. $price .' )';
                $html.='<div class="funkyradio-success">';
                $html.='<input style="display:inline" type="radio" id="'.$key.'"  value="'.$key.'$'.$price.'" class="validate[required] radio"  name="cwash">';
                $html.='<label for="'.$key.'">'.$full_text.'</label>';
                $html.='</div>';

            }
            return $html;
        }
    }
    public function get_carwash_veh_type_price( $tyid )
    {
        $carwash = CarWash::where('website_id', 1)->where('vehical_type_id', $tyid)->orderBy('id', 'DESC')->get();
        $response = array();
        foreach ($carwash as $cw){
            //if($cw->car_wash_type != 'carwash_spray_only') {
                $response[$cw->car_wash_type] = $cw->car_wash_price;
            //}
        }
        if(!empty($response)){
            ksort($response);
        }

        return $response;
    }

    public function  booking_bk_ref_exists($bk_ref){
        $bk_id_row = DB::table('bookings')
            ->select('id')
            ->where('bk_ref', '=', $bk_ref)
            ->first();
        return $bk_id_row;
    }

}
