<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Middleware\EncryptCookies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use DateTime;
use App\Classes\Domain;
use App\Classes\Edenemail;
use Mail;
use App\Settings;
use App\Booking;
use App\Customer;

class CustomersController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $domain = env('APP_URL');
        $domain = Domain::get_domain_id(1);
        /* ======= Service ======= */

        $services = DB::table('services')
            //->where('disable', '=', 0)
            ->orderByRaw('sort ASC')
            ->get();
        /* ======= Service ======= */

        if (isset($_COOKIE["cus_id"])) {
            //$customer_id = $_COOKIE["cus_id"];
            $customer_id = Domain::get_customer_id($_COOKIE["cus_id"]);
            $customer = Customer::find($customer_id);
        }


    }


    public function customer_register()
    {
        $domain = env('APP_URL');
        $domain = Domain::get_domain_id(1);

        /* ======= Service ======= */
        $services = DB::table('services')
            //->where('disable', '=', 0)
            ->orderByRaw('sort ASC')
            ->get();
        /* ======= Service ======= */
        $page_title = 'Register';
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
        return view($domain->website_templete.'.register', compact('page_title', 'meta_array', 'services', 'domain'));
    }

    public function customer_login()
    {
        $domain = env('APP_URL');
        $domain = Domain::get_domain_id(1);

        /* ======= Service ======= */
        $services = DB::table('services')
            //->where('disable', '=', 0)
            ->orderByRaw('sort ASC')
            ->get();
        /* ======= Service ======= */
        $page_title = 'Login';
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

        if (!isset($_COOKIE["cus_id"])) {
            return view($domain->website_templete.'.login', compact('page_title', 'meta_array', 'services', 'domain'));
        }else{
            return redirect('/profile')->with('success', 'logged in.');
        }


    }

    public function customer_logout()
    {
        setcookie('cus_id', '', time() - 3600, "/");
        return redirect('/')->with('success', 'logout.');
    }

    public function profile()
    {
        if (isset($_COOKIE["cus_id"])) {
            $domain = env('APP_URL');
            $domain = Domain::get_domain_id(1);

            /* ======= Service ======= */
            $services = DB::table('services')
                //->where('disable', '=', 0)
                ->orderByRaw('sort ASC')
                ->get();
            /* ======= Service ======= */

            //$customer_id = $_COOKIE["cus_id"];
            $customer_id = Domain::get_customer_id($_COOKIE["cus_id"]);
            $customer = Customer::find($customer_id);
            $page_title = 'Profile';
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

            return view($domain->website_templete.'.profile', compact('page_title', 'meta_array', 'services', 'domain', 'customer'));
        }else{
            return redirect('/customer-login')->with('success', 'Pleaslogin.');
        }
    }
    public function editprofile(){
        if (isset($_COOKIE["cus_id"])) {
            $domain = env('APP_URL');
            $domain = Domain::get_domain_id(1);

            /* ======= Service ======= */
            $services = DB::table('services')
                //->where('disable', '=', 0)
                ->orderByRaw('sort ASC')
                ->get();
            /* ======= Service ======= */

            //$customer_id = $_COOKIE["cus_id"];
            $customer_id = Domain::get_customer_id($_COOKIE["cus_id"]);
            $customer = Customer::find($customer_id);
            if (request()->has('redirect') && (!empty(request()->input('redirect')))) {
                $redirect = request()->input('redirect');;
            }else{
                $redirect ="profile";
            }
            $page_title = 'Edit Profile';
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

            return view($domain->website_templete.'.edit-profile', compact('page_title', 'meta_array', 'services', 'domain', 'customer', 'redirect'));
        }else{
            return redirect('/customer-login')->with('success', 'Pleaslogin.');
        }
    }

    public function logincustomers(Request $request)
    {
        $username = $request->get('username');
        $passwrd = $request->get('passwrd');

        $customer_exists = Customer::where('cus_email', '=', $username)->where('cus_password', '=', $passwrd)->first();
        //dd($customer_exists);
        if ($customer_exists === null) {
            return response()->json(['code' => '404'], 404);
        } else {

            $encripted_booking_id = Domain::set_encripted_ids($customer_exists->id);
            setcookie("cus_id", $encripted_booking_id, time() + 3600 * 24 * 100, "/");
            //return redirect('/booknow')->with('success', 'Please Complete intitial bookng step.');
            return response()->json(['code' => '200'], 200);
        }

    }
    public function reset_customer_password(Request $request)
    {
        $domain = env('APP_URL');
        $domain = Domain::get_domain_id(1);

        $email = $request->get('email');
        $customer_exists = Customer::where('cus_email', '=', $email)->first();
        //dd($customer_exists);
        if ($customer_exists === null) {
            return response()->json(['code' => '404'], 404);
        } else {
          //print_r($customer_exists->cus_password);
            /*======================== EMAIL TO CUSTOMER ===========================*/
            $data = array(
                'cus_title'=> $customer_exists->cus_title ,
                'cus_name'=> $customer_exists->cus_name ,
                'cus_email'=> $customer_exists->cus_email ,
                'cus_password'=> $customer_exists->cus_password,
                'website_logo'=> $domain->website_url.'/uploads/'.$domain->website_logo,
                'website_email_banner'=> $domain->website_url.'/uploads/'.$domain->website_email_banner,
                'image_right'=> $domain->website_url.'/uploads/email/image_right.png',
                'image_left'=> $domain->website_url.'/uploads/email/image_left.png'
            );

            $st_admin_name = Edenemail::get_email_settings('st_admin_name');
            $st_admin_from_email = Edenemail::get_email_settings('st_admin_from_email');
            $email_subject ="EdenParking: Forget Password";
            $to_email = $customer_exists->cus_email;
            $to_name = $customer_exists->cus_title . ' ' . $customer_exists->cus_name;
            Mail::send('email.forgertpassmail', $data, function ($message) use ($st_admin_from_email, $st_admin_name, $email_subject, $to_email, $to_name) {
                $message->to($to_email, $to_name)->subject($email_subject);
                $message->from($st_admin_from_email, $st_admin_name);
            });
            /*======================== /EMAIL TO CUSTOMER ===========================*/
            return response()->json(['code' => '200'], 200);
        }

    }

    public function updateprofile(Request $request)
    {
        if (isset($_COOKIE["cus_id"])) {
            $redirect= $this->set_input($request->get('redirect'));
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
            $country = $this->set_input($request->get('country'));
            if (!empty($name) && !empty($surname) && !empty($email) && !empty($cell) && !empty($postcode)) {
                //$customer_id = $_COOKIE["cus_id"];
                $customer_id = Domain::get_customer_id($_COOKIE["cus_id"]);
                $customer = Customer::find($customer_id);

                /*
                 'cus_title'=> $title,
                            'cus_name'=> $name,
                            'cus_email'=> $email,
                            'cus_email_1'=> $email_1,
                            'cus_password'=> $cell,
                            'cus_company'=> $company,
                            'cus_surname'=> $surname,
                            'cus_tele'=> $cell,
                            'cus_cell'=> $cell,
                            'cus_address'=> $address,
                            'cus_town'=> $town,
                            'cus_county'=> $county,
                            'cus_postcode'=>$postcode,
                            'cus_oneoff'=> 1,
                            'cud_date'=> date('Y-m-d'),
                            'cus_cell2'=> $cell2,
                            'cus_homename'=> $homename,
                            'cus_country'=> $country,
                            'cus_status' => 0
                 */
                $customer->cus_title = $title;
                $customer->cus_name = $name;
                $customer->cus_email = $email;
                $customer->cus_email_1 = $email_1;
                $customer->cus_password = $cell;
                $customer->cus_company = $company;
                $customer->cus_surname = $surname;
                $customer->cus_tele = $tel;
                $customer->cus_cell = $cell;
                $customer->cus_address = $address;
                $customer->cus_town = $town;
                $customer->cus_county = $county;
                $customer->cus_postcode = $postcode;
                $customer->cus_cell2 = $cell2;
                $customer->cus_homename = $homename;
                $customer->cus_country = $country;

                $updated = $customer->save();

                echo json_encode(array('updated'=>$updated,'redirect'=>$redirect));
                exit;
            }
        }


    }

    public function set_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function my_bookings(){
        if (isset($_COOKIE["cus_id"])) {
            $domain = env('APP_URL');
            $domain = Domain::get_domain_id(1);

            /* ======= Service ======= */
            $services = DB::table('services')
                //->where('disable', '=', 0)
                ->orderByRaw('sort ASC')
                ->get();
            /* ======= Service ======= */

            //$customer_id = $_COOKIE["cus_id"];
            $customer_id = Domain::get_customer_id($_COOKIE["cus_id"]);
            $customer = Customer::find($customer_id);
            $allbookings = DB::table("bookings as bb")
                ->join("terminals as t1", "t1.id", "=", "bb.bk_ou_te")
                ->join("terminals as t2", "t2.id", "=", "bb.bk_re_te")
                ->join("currencies as cc", "cc.id", "=", "bb.currency_id")
                ->join("airports as aa", "aa.id", "=", "bb.airport_id")
                ->join("services as ss", "ss.id", "=", "bb.service_id")
                ->join("customers as cus", "cus.id", "=", "bb.customer_id")
                ->where('bb.customer_id', '=', $customer_id)
                ->where('bb.website_id', '=', $domain->id)
                ->where('bb.bk_status', '>', 0)
                ->select("bb.*", "bb.id as booking_id",
                    DB::raw("DATE_FORMAT(bb.bk_date, '%d/%m/%Y') as bk_date"),
                    DB::raw("DATE_FORMAT(bb.bk_from_date, '%d/%m/%Y %H:%i') as bk_from_date"),
                    DB::raw("DATE_FORMAT(bb.bk_to_date, '%d/%m/%Y %H:%i') as bk_to_date"),
                    DB::raw("DATE_FORMAT(bb.bk_ve_do_dt, '%d/%m/%Y %H:%i') as bk_ve_do_dt"),
                    DB::raw("DATE_FORMAT(bb.bk_ve_pu_dt, '%d/%m/%Y %H:%i') as bk_ve_pu_dt"),
                    "aa.airport_name",
                    "aa.airport_directions",
                    "t1.airport_id AS airport_id1",
                    "t1.id AS ter_id1",
                    "t1.ter_name AS ter_name1",
                    "t2.airport_id AS airport_id2",
                    "t2.id AS ter_id2",
                    "t2.ter_name AS ter_name2",
                    "cc.cur_symbol", "cc.cur_code",
                    "ss.service_name",
                    "cus.id AS cus_id","cus.*"
                )
                ->orderBy('bb.id', 'desc') ->get();

            //dd($allbookings);
            $t1 = strtotime(date('Y-m-d H:i:0'));

            $total_price_html ="";
            foreach ($allbookings as $key=> $booking){

                $date1 = date('Y-m-d H:i:0');
                $old_date_timestamp = strtr($booking->bk_from_date, '/', '-');
                $old_date_timestamp = strtotime($old_date_timestamp);
                $date2 = date('Y-m-d H:i:0', $old_date_timestamp);
                $timestamp1 = strtotime($date1);
                $timestamp2 = strtotime($date2);
                $hour = floor(($timestamp2 - $timestamp1)/(60*60));
                //echo $booking->bk_from_date ." =========== ".$date2." ==========> Difference between two dates is " . $hour . " hour(s)<hr>";




                $booking->days_left = $hour;
                $carwash = $booking->carwash_in_and_out + $booking->carwash_out_only + $booking->carwash_in_only;

                // if ($booking->bk_discount_offer_coupon <> "") {
                //     $TOTAL_PAYABLE_AMOUNT = $booking->bk_final_amount + $carwash + $booking->not_working_hours + $booking->charging_service_charges + $booking->charging;;
                //     $total_price_html = "" . $booking->cur_symbol . " " . number_format($TOTAL_PAYABLE_AMOUNT, 2, '.', '') . "";

                // } else {
                    
                // }
                $TOTAL_PAYABLE_AMOUNT = $booking->bk_total_amount + $carwash + $booking->not_working_hours + $booking->charging_service_charges + $booking->charging;;
                $total_price_html = "" . $booking->cur_symbol . " " . number_format($TOTAL_PAYABLE_AMOUNT, 2, '.', '') . "";
                $booking->total_amount_special = $total_price_html;
            }

            $page_title = 'My Bookings';
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
            return view($domain->website_templete.'.my-bookings', compact('page_title', 'meta_array', 'services', 'domain', 'customer','allbookings'));
        }else{
            return redirect('/customer-login')->with('success', 'Pleaslogin.');
        }


    }

    public function register(){
        $domain = env('APP_URL');
        $domain = Domain::get_domain_id(1);

        /* ======= Service ======= */
        $services = DB::table('services')
            //->where('disable', '=', 0)
            ->orderByRaw('sort ASC')
            ->get();
        /* ======= Service ======= */

        $page_title = 'Sign Up';
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

        if (isset($_COOKIE["cus_id"])) {
            return redirect('/profile')->with('success', 'logged in.');

        }else{
            return view($domain->website_templete.'.sign-up', compact('page_title', 'meta_array', 'services', 'domain'));
        }
    }
     public function registercustomer(Request $request)
     {
         $created = 0;
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
         $country = $this->set_input($request->get('country'));
         //print_r('dfgdfgdfgdf'); exit;
         if (!empty($name) && !empty($surname) && !empty($email) && !empty($cell) && !empty($postcode)) {
             if(!Customer::where('cus_email', $email)->exists()) {
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
                         'cus_oneoff' => 0,
                         'cud_date' => date('Y-m-d'),
                         'cus_cell2' => $cell2,
                         'cus_homename' => $homename,
                         'cus_country' => $country,
                         'cus_status' => 0
                     )
                 );

                 if ($add_customers == 1){
                     $customer_id = DB::getPdo()->lastInsertId();
                     ///print_r($customer_id); exit;
                      $encripted_booking_id = Domain::set_encripted_ids($customer_id);
                     setcookie("cus_id",$encripted_booking_id, time()+3600*24*100,"/");
                     $created = 1;
                 }

             }else{
                 $created = -1;
             }

         }
         $redirect = 'profile';
         echo json_encode(array('created'=>$created,'redirect'=>$redirect));
     }
}
