<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use App\Classes\Edenemail;
use Mail;
use App\Agents;
use App\Booking;
use App\Website;
use App\Country;
use App\Terminal;
use App\Airport;
use App\Color;
use App\Customer;
use App\PaymentNotification;
class BookingsController  extends Controller
{
        /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        if (request()->has('date1')) {
            $search_filter = request()->input();
            if (request()->has('date1') && (!empty(request()->input('date1')))) {
                //dd(request()->input('date1'));
            }
        }else{
            $search_filter = array(
                'date1'=>'',
                'date2'=>'',
                'is_del' => '',
                'bk_ref'=>'',
                'outbound_flight'=>'',
                'inbound_flight'=>'',
                'email'=>'',
                'cell'=>'',
                'cus_name'=>'',
                'company'=>'',
                'vehicle_number'=>'',
                'payment_method'=>'',
                'surname'=>'',
                'airport_id'=>'',
                'website_id'=>'',
                'bk_status'=>'',
            );
        }
        $title = "Bookings";
        //        $websites = Website:: all();


        /*============ Drivers ============*/
        $drivers = DB::table('drivers')
            ->get();
        /*============ /Drivers ============*/

        $agents = Agents::all();

        /*============ Agents ============*/
        foreach ($agents as $agent){
            $agents_json[] = array('value'=>$agent->id, 'text'=>$agent->agt_company);
        }
        $agents_json = json_encode($agents_json);
        /*============ Agents ============*/

        /*============ Countries ============*/
        $countries = Country:: all();
        foreach ($countries as $country){
            $country_json[] = array('value'=>$country->id, 'text'=>$country->name);
        }
        $country_json = json_encode($country_json);
        /*============ Countries ============*/

        /*============ Airports ============*/
        $allairports= Airport:: all();
        $airports = DB::table('airports')
            ->select('id','airport_nick','airport_name')
            ->where('airport_disable', '=', 0)
            ->get();
        foreach ($airports as $airport){
            $airport_json[] = array('value'=>$airport->id, 'text'=>$airport->airport_name." - ".$airport->airport_nick);
        }
        $airport_json = json_encode($airport_json);
        /*============ Airports ============*/

        /*============ Terminals ============*/
        $terminals = DB::table('terminals as tt')
            ->join("airports as aa", "aa.id", "=", "tt.airport_id")
            ->where('aa.airport_disable', '=', 0)
            ->where('tt.ter_disable', '=', 0)
            ->select('tt.id AS tt_id', 'aa.airport_name', 'tt.ter_name')
            ->get();
        foreach ($terminals as $terminal){
            $terminals_json[] = array('value'=>$terminal->tt_id, 'text'=>$terminal->airport_name." - ".$terminal->ter_name);
        }
        $terminals_json = json_encode($terminals_json);
        //dd($terminals_json);
        /*============ /Terminals ============*/

        /*========= Color =========*/
        $colors = Color::all();
        foreach ($colors as $color){
            $colors_json[] = array('value'=>$color->clr_name, 'text'=>$color->clr_name);
        }
        $colors_json = json_encode($colors_json);
        /*========= Color =========*/

        /*========= Payment Method =========*/
        $payment_method_json = array(
            array(
                "value" => 1,
                "text" => "Pay later",
            ),
            array(
                "value" => 2,
                "text" => "Paypal",
            ),
            array(
                "value" => 3,
                "text" => "Worldpay",
            ),
            array(
                "value" => 4,
                "text" => "other",
            ),
            array(
                "value" => 5,
                "text" => "Stripe",
            ),
            array(
                "value" => 6,
                "text" => "Bank Tranfer",
            ),
            array(
                "value" => 7,
                "text" => "Cash",
            )

        );
        $payment_method_json = json_encode($payment_method_json);
        /*========= /Payment Method =========*/

        /*========= Status =========*/
        $status_json = array(
            array(
                "value" => 1,
                "text" => "Pending...",
            ),
            array(
                "value" => 2,
                "text" => "Confirmed",
            ),
            array(
                "value" => 3,
                "text" => "Completed",
            ),
            array(
                "value" => 4,
                "text" => "Cancelled",
            ),
            array(
                "value" => 5,
                "text" => "Account job pending",
            ),
            array(
                "value" => 6,
                "text" => "Account job complete",
            ),
            array(
                "value" => 7,
                "text" => "Account job refund",
            ),
            array(
                "value" => 8,
                "text" => "Pay later payment done",
            ),
            array(
                "value" => 9,
                "text" => "Complaint",
            ),
            array(
                "value" => 10,
                "text" => "Special discount",
            ),
            array(
                "value" => 11,
                "text" => "Staff discount",
            ),
            array(
                "value" => 12,
                "text" => "Staff free",
            ),
            array(
                "value" => 13,
                "text" => "Customer free",
            ),
            array(
                "value" => 14,
                "text" => "Special customers",
            ),
            array(
                "value" => 15,
                "text" => "Park and Ride",
            ),
            array(
                "value" => 16,
                "text" => "Not paid",
            ),
            array(
                "value" => 17,
                "text" => "Free for late customer",
            ),
            array(
                "value" => 18,
                "text" => "No Show",
            )
        );
        $status_json = json_encode($status_json);
        /*========= /Status =========*/

        $websites = Website::all();
        //echo "<pre>"; print_r(request()->input()); echo "</pre>";
        $bookings = DB::table("bookings as bb");
        $bookings =  $bookings->join("countries as country", "country.id", "=", "bb.country_id");
        $bookings =  $bookings->join("websites as ww", "ww.id", "=", "bb.website_id");
            $bookings =  $bookings->join("terminals as t1", "t1.id", "=", "bb.bk_ou_te");
            $bookings =  $bookings->join("terminals as t2", "t2.id", "=", "bb.bk_re_te");
            $bookings =  $bookings->join("currencies as cc", "cc.id", "=", "bb.currency_id");
            $bookings =  $bookings->join("airports as aa", "aa.id", "=", "bb.airport_id");
            $bookings =  $bookings->join("services as ss", "ss.id", "=", "bb.service_id");
            $bookings =  $bookings->join("customers as cus", "cus.id", "=", "bb.customer_id");
            $bookings =  $bookings->join("colors as clrr", "clrr.clr_name", "=", "bb.bk_ve_co");
            $bookings =  $bookings->join("agents as agt", "agt.id", "=", "bb.agent_id",'left outer');
            $bookings =  $bookings->join("agents as fagt", "fagt.id", "=", "bb.fwd_agt_id",'left outer');
            $bookings =  $bookings->join("payment_notifications as ipn", "ipn.booking_id", "=", "bb.id",'left outer');

            $search= false;

            if (!empty(request()->input('date1')) || !empty(request()->input('date2'))) {
                $search= true;

                 if (!empty(request()->input('date1')) and empty(request()->input('date2'))) {
                     $date1 = request()->input('date1');
                     $bookings = $bookings->whereDate('bb.bk_date', '>=', $date1);
                 } else if ((empty(request()->input('date1')) and !empty(request()->input('date2')))) {
                     $date2 = request()->input('date2');
                     $bookings = $bookings->whereDate('bb.bk_date', '<=', $date2);
                 } else {
                     $date1 = request()->input('date1');
                     $date2 = request()->input('date2');
                     $bookings = $bookings->whereBetween('bb.bk_date', array($date1, $date2));
                 }
             }else{
               // dd('asasasas');
               $date1 = date("Y-m-d", strtotime("-15 days"));
               $date2 = date("Y-m-d", strtotime("+2 days")); // date("Y-m-d");

              // $bookings = $bookings->whereBetween('bb.bk_date', array($date1, $date2));
            }

             if (request()->input('bk_ref') && (!empty(request()->input('bk_ref')))) {
                $search= true;
                 $bookings = $bookings->where('bb.bk_ref', '=', request()->input('bk_ref'));
                 $search_filter['bk_ref'] = request()->input('bk_ref');
             }

            if (request()->input('is_del') && (!empty(request()->input('is_del'))) && (request()->input('is_del')) != 2 ) {
                $search= true;
                $bookings = $bookings->where('bb.bk_is_del', '=', request()->input('is_del'));
                $search_filter['is_del'] = request()->input('is_del');
             } else {
                 $bookings = $bookings->where('bb.bk_is_del', '=', 0);
             }

             if ((request()->has('outbound_flight')) && (!empty(request()->input('outbound_flight')))) {
                $search= true;
                 $bookings = $bookings->where('bb.bk_ou_fl_nu', '=', request()->input('outbound_flight'));
                 $search_filter['outbound_flight'] = request()->input('outbound_flight');
             }

             if ((request()->has('inbound_flight')) && (!empty(request()->input('inbound_flight')))) {
                $search= true;
                 $bookings = $bookings->where('bb.bk_re_fl_nu', '=', request()->input('inbound_flight'));
                 $search_filter['inbound_flight'] = request()->input('inbound_flight');
             }

             if ((request()->has('email')) && (!empty(request()->input('email')))) {
                $search= true;
                 $bookings = $bookings->where('cus.cus_email', '=', request()->input('email'));
                 $search_filter['email'] = request()->input('email');
             }

             if ((request()->has('cell')) && (!empty(request()->input('cell')))) {
                $search= true;
                 $bookings = $bookings->where('cus.cus_cell', '=', request()->input('cell'));
                 $search_filter['cell'] = request()->input('cell');
             }

             if ((request()->has('cus_name')) && (!empty(request()->input('cus_name')))) {
                $search= true;
                 $bookings = $bookings->where('cus.cus_name', '=', request()->input('cus_name'));
                 $search_filter['cus_name'] = request()->input('cus_name');
             }

             if ((request()->has('company')) && (!empty(request()->input('company')))) {
                $search= true;
                 $bookings = $bookings->where('cus.cus_company', '=', request()->input('company'));
                 $search_filter['company'] = request()->input('company');
             }

             if ((request()->has('vehicle_number')) && (!empty(request()->input('vehicle_number')))) {
                $search= true;
                 $bookings = $bookings->where('bb.bk_re_nu', '=', request()->input('vehicle_number'));
                 $search_filter['vehicle_number'] = request()->input('vehicle_number');
             }

             if ((request()->has('payment_method')) && (!empty(request()->input('payment_method'))) && request()->has('payment_method') != 0) {
                $search= true;
                 $bookings = $bookings->where('bb.bk_payment_method', '=', request()->input('payment_method'));
                 $search_filter['payment_method'] = request()->input('payment_method');
             }

             if ((request()->has('surname')) && (!empty(request()->input('surname')))) {
                $search= true;
                 $bookings = $bookings->where('cus.cus_surname', '=', request()->input('surname'));
                 $search_filter['surname'] = request()->input('surname');
             }


             if ((request()->has('bk_status')) && (!empty(request()->input('bk_status'))) && request()->has('bk_status') != 0) {
                $search= true;
                 $bookings = $bookings->where('bb.bk_status', '=', request()->input('bk_status'));
                 $search_filter['bk_status'] = request()->input('bk_status');
             } else {
                 $bookings = $bookings->where('bb.bk_status', '>', 0);
             }

             if ((request()->has('airport_id')) && (!empty(request()->input('airport_id'))) && request()->has('airport_id') != 0) {
                $search= true;
                 $bookings = $bookings->where('bb.airport_id', '=', request()->input('airport_id'));
                 $search_filter['airport_id'] = request()->input('airport_id');
             }
            if ((request()->has('website_id')) && (!empty(request()->input('website_id'))) && request()->has('website_id') != 0) {
                $search= true;
                $bookings = $bookings->where('bb.website_id', '=', request()->input('website_id'));
                $search_filter['website_id'] = request()->input('website_id');
            }
            if(!$search){
                $bookings = $bookings->whereBetween('bb.bk_date', array($date1, $date2));
            }

        //DB::enableQueryLog();
        $bookings =  $bookings->select("bb.*", "bb.id as booking_id",
                DB::raw("DATE_FORMAT(bb.bk_date, '%d/%m/%Y') as bk_date"),
                DB::raw("DATE_FORMAT(bb.bk_from_date, '%d/%m/%Y %H:%i') as bk_from_date"),
                DB::raw("DATE_FORMAT(bb.bk_to_date, '%d/%m/%Y %H:%i') as bk_to_date"),
                DB::raw("DATE_FORMAT(bb.bk_ve_do_dt, '%d/%m/%Y %H:%i') as bk_ve_do_dt"),
                DB::raw("DATE_FORMAT(bb.bk_ve_pu_dt, '%d/%m/%Y %H:%i') as bk_ve_pu_dt"),
                "country.id AS countryid",
                "country.name as countryname",
                "aa.id AS selected_airport_id",
                "aa.airport_name",
                "aa.airport_directions",
                "agt.id AS agt1_id",
                "agt.agt_company AS agt1_company",
                "fagt.id AS fagt_id",
                "fagt.agt_company AS fagt_company",
                "ipn.txn_id AS txn_id",
                "ipn.payment_status AS payment_status_ipn",
                "t1.airport_id AS airport_id1",
                "t1.id AS ter_id1",
                "t1.ter_name AS ter_name1",
                "t2.airport_id AS airport_id2",
                "t2.id AS ter_id2",
                "t2.ter_name AS ter_name2",
                "cc.cur_symbol", "cc.cur_code",
                "ss.service_name",
                "cus.id AS cus_id","cus.*",
                "ww.*",
                "clrr.id as clrr_id", "clrr.clr_name"
            );
            $bookings =  $bookings->groupBy('bb.id');
            $bookings =  $bookings->orderBy('bb.id', 'desc');
            //$bookings =  $bookings->paginate(15);
            $bookings =  $bookings->get();
        //dd(DB::getQueryLog());
        //dd($payment_method_json);
        foreach ($bookings as $booking){
            $booking->checkin = 'oooo'.$booking->bk_ref;
            if(!empty($booking->txn_id)){
               $payment_status_ipn = $this->GetlatestIpnEntry($booking->booking_id);
               if($payment_status_ipn){
                $booking->payment_status_ipn = $payment_status_ipn;
               }
            }
            
        }
        //dd($bookings);
        return view('admin.bookings.index', compact('title','bookings','country_json','airport_json','terminals_json','colors_json','payment_method_json','status_json','agents_json','search_filter','drivers','allairports','websites'));
    }

    public function store(Request $request)
    {
    }

    public function GetlatestIpnEntry($booking_id)
    {
        $txn_idexists = DB::table("payment_notifications")
        ->where('booking_id', '=', $booking_id)
        ->orderBy('id', 'desc')
        ->first();
        if($txn_idexists){
            return $txn_idexists->payment_status;
        }else{
            return false;
        }

       
     //'sdsdsd';       
    }

    public function updateinline(Request $request, $id)
    {
        $column_name = $request->name;
        $column_value = $request->value;

        if( $column_name == 'bk_total_amount' ){

            $column_value = str_replace('£', '', $column_value);

            $rs = DB::table('bookings')
                ->where('id', '=', $id)
                ->select("bk_discount_offer_value", "bk_discount_offer_amount")
                ->first();

            if($rs->bk_discount_offer_value > 0){
                if( $request->name && $request->value) {
                    $bk_final_amount = $column_value - $rs->bk_discount_offer_amount;
                    $update = Booking::select()
                        ->where('id', '=', $id)
                        ->update(['bk_final_amount' => $bk_final_amount]);
                    $update = Booking::select()
                        ->where('id', '=', $id)
                        ->update([$column_name => $column_value]);
                    return response()->json([ 'code'=>200], 200);
                }

            }else{
                if( $request->name && $request->value) {
                    $update = Booking::select()
                        ->where('id', '=', $id)
                        ->update([$column_name => $column_value]);
                    return response()->json([ 'code'=>200], 200);
                }
            }
        } else if( $column_name == 'bk_ve_do_dt'  || $column_name == 'bk_from_date'){
            //bk_from_date == bk_ve_do_dt
            $update = Booking::select()
            ->where('id', '=', $id)
            ->update(['bk_ve_do_dt' => $column_value]);
         
            $update = Booking::select()
            ->where('id', '=', $id)
            ->update(['bk_from_date' => $column_value]);

        } else if( $column_name == 'bk_ve_pu_dt' || $column_name == 'bk_to_date' ){
            //bk_to_date == bk_ve_pu_dt
            $update = Booking::select()
            ->where('id', '=', $id)
            ->update(['bk_to_date' => $column_value]);

            $update = Booking::select()
            ->where('id', '=', $id)
            ->update(['bk_ve_pu_dt' => $column_value]);    
        
        } else if( $column_name == 'cus_email' ||  $column_name == 'cus_email_1' ||  $column_name == 'cus_cell' ){
            $update = Customer::select()
                ->where('id', '=', $id)
                ->update([$column_name => $column_value]);
            return response()->json([ 'code'=>200], 200);
            
        }

        if( $request->name && $request->value) {
            $update = Booking::select()
                ->where('id', '=', $id)
                ->update([$column_name => $column_value]);
            return response()->json([ 'code'=>200], 200);
        }


        return response()->json([ 'error'=> 400, 'message'=> 'Not enought params' ], 400);
    }



    public function create  (){
        $title = "Agent";
        return view('admin.agents.create', compact('title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $agent = Agents::where('id', $id)
            ->first();

        return view('admin.page.edit', compact('agent', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //dd($request);
        $request->validate([
            'title'=>'required'
        ]);


        $agent = Agents::find($id);

        $agent->title = $request->get('title');
        $agent->content = $request->get('content');
        $agent->content_left = $request->get('content_left');
        $agent->content_right = $request->get('content_right');
        $agent->slug = $request->get('slug');
        $agent->meta_title = $request->get('meta_title');
        $agent->meta_description = $request->get('meta_description');
        $agent->meta_keywords = $request->get('meta_keywords');
        $agent->save();

        return redirect('/admin/agents')->with('success', 'Agent Updated...');

    }

    public function delete($id){
        Booking::select()
            ->where('id', '=', $id)
            ->update(['bk_is_del' => 1]);
        return response()->json([
            'success' => 'Record deleted successfully!',
            'id' => $id
        ]);
    }
    public function purge($id){
        Booking::find($id)->delete($id);
        return response()->json([
            'success' => 'Record purged successfully!',
            'id' => $id
        ]);
    }
    public function undelete($id){
       Booking::select()
            ->where('id', '=', $id)
            ->update(['bk_is_del' => 0]);
        return response()->json([
            'success' => 'Record Un-deleted successfully!',
            'id' => $id
        ]);
    }
    public function printdone($id){
        Booking::select()
            ->where('id', '=', $id)
            ->update(['bk_print_flag' => 1]);
        return response()->json([
            'success' => 'Print Done Succesfully',
            'id' => $id
        ]);
    }
 
    public function GetAllBookingByCommonRefrenceNum($RefrenceNum)
    {
        $bookingdata = DB::table("bookings")
        ->where('refrence_num_common', '=', $RefrenceNum)
        ->get();
        return $bookingdata;
    }
    
    public function confirmbookingbanktransfer($bk_id_c){
        $booking = Booking::find($bk_id_c);
        if($booking){
            $all_booking = $this->GetAllBookingByCommonRefrenceNum($booking->refrence_num_common);
                                                
            // Debugging: Check if bookings are retrieved correctly
            if ($all_booking->isEmpty()) {
                
            }else{
                foreach($all_booking as $booking){
                    
                    $PaymentNotification = new PaymentNotification([
                        'booking_id' => $booking->id,
                        'payment_reciever' => 'banktransfer',
                        'payment_status' => 'Completed',
                        'mc_gross' => $booking->all_vehicals_total,
                        'txn_id' => $booking->bank_transition_refernce,
                        'item_name' => $booking->refrence_num_common,
                        'log' => 'none'
                    ]);
    
                    $PaymentNotification->save();
                    $insert_id = $PaymentNotification->id;
                    $this->SendConfirmationEmail($booking);
                }
            }
        }
        
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

    public function send_email_to_customer($bk_id_c){

        $data = Edenemail::send_booking_email($bk_id_c);

        $st_admin_name = Edenemail::get_email_settings('st_admin_name');
        $st_admin_from_email = Edenemail::get_email_settings('st_admin_from_email');
        $st_admin_email = Edenemail::get_email_settings('st_admin_email');
        $email_subject = Edenemail::get_email_settings('st_new_booking_subject');
        $st_notification_email = Edenemail::get_email_settings('st_notification_email');

        /* -------------- @new enail template ---------------- */
        
        $Email_Template = "email.common";
        $email_subject = str_replace("Eden", $data['website_name'], $email_subject);
        $st_admin_name =  str_replace("Eden", $data['website_name'], $st_admin_name);
        /* -------------- /@new enail template ---------------- */

        if(in_array($data['txn_payment_status'], array('Refunded'))){
            $email_subject = str_replace("New", "Cancelled/Refunded", $email_subject);
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


    public function send_payment_email($bk_id_c){

    }

    public function get_global_settings($sname){
        $settings = DB::table("settings")
            ->where('website_id', 1)
            ->where('option_name', $sname)
            ->first();
        return $settings->option_value;
    }
    public function get_email_settings($sname){
        $settings = DB::table("global_settings")
            ->where('option_name', $sname)
            ->first();
        return $settings->option_value;
    }

    public function add_check_in($booking_id){
        //echo "dsfsdfsdf"; exit;
        $already_exists = $this->ck_in_out_exist('checkins', $booking_id);
        if (!empty($already_exists)) {
            //die('lllll');
            $booking = DB::table("bookings as bb")
                ->where('bb.id', '=', $booking_id)
                ->select("bk_ref")
                ->first();
            return response()->json([
                'success' => '1',
                'id' => $booking_id,
                'ciot' => 'cin',
                'ref' => "Already CheckIned:: Reference number: " . $booking->bk_ref,
                'ctype' => 'CheckIn',
                'disabled' => '1'
            ]);
        }else{
            $booking = DB::table("bookings as bb")
                ->where('bb.id', '=', $booking_id)
                ->select("bk_ref")
                ->first();
            //print_r($booking->bk_ref);

            return response()->json([
                'success' => '1',
                'id' => $booking_id,
                'ciot' => 'cin',
                'ref' => "Check In:: Reference number: " . $booking->bk_ref,
                'ctype' => 'CheckIn',
                'disabled' => '0'
            ]);
        }
    }

    public function add_check_out($booking_id){

        $checkin_exists = $this->ck_in_out_exist('checkins', $booking_id);
        if (!empty($checkin_exists)) {
            $booking = DB::table("bookings as bb")
                ->where('bb.id', '=', $booking_id)
                ->select("bk_ref")
                ->first();
            $checkout_already_exists = $this->ck_in_out_exist('checkouts', $booking_id);
            if (!empty($checkout_already_exists)) {
                return response()->json([
                    'success' => '1',
                    'id' => $booking_id,
                    'ciot' => 'cout',
                    'ref'=>"Already CheckedOut:: Reference number: ".$booking->bk_ref,
                    'ctype'=>'CheckOut',
                    'disabled' => '1'
                ]);
            }else{
                return response()->json([
                    'success' => '1',
                    'id' => $booking_id,
                    'ciot' => 'cout',
                    'ref'=>"Check Out:: Reference number: ".$booking->bk_ref,
                    'ctype'=>'CheckOut',
                    'disabled' => '0'
                ]);
            }

        }else{
            $booking = DB::table("bookings as bb")
                ->where('bb.id', '=', $booking_id)
                ->select("bk_ref")
                ->first();
            return response()->json([
                'success' => '1',
                'id' => $booking_id,
                'ciot' => 'cout',
                'ref'=>"Not CheckedIn Please CheckIn First:: Reference number: ".$booking->bk_ref,
                'ctype'=>'CheckOut',
                'disabled' => '1'
            ]);
        }



    }

    public function get_ckin_ckou_terminal($id){
        $args = explode('&',$id);
        $booking_id =$args[0];
        $cin_out_table = $args[1];

        $booking = DB::table("bookings as bb")
            ->where('bb.id', '=', $booking_id)
            ->select("airport_id")
            ->first();
        //print_r($booking->airport_id);

       $airport_id =  $booking->airport_id;

        $terminals['data'] = DB::table('terminals')
            ->where('airport_id', '=', $airport_id)
            ->where('ter_disable', '=', 0)
            ->get();
        echo json_encode($terminals);
        exit;

        /*return response()->json([
            'success' => 'Print Done Succesfully',
            'booking_id' => $booking_id,
            'type' => $cin_out_table,
            'airport_id'=>$airport_id
        ]);*/
    }

    public function add_ckin_ckou_form(Request $request){
        /*echo "hhhh"; print_r($request->post('drv_id')); echo "hhhh";
        echo "nnnn"; print_r($request->post('ck_in_out_type')); echo "nnnn";
        echo "vvvvv"; print_r($request->post('ck_in_out_point')); echo "vvvv";
        exit;*/
        $inserted_id = 0;
        $success = 0;
        $success_msg = "";
        $err = 0;
        $errStr= "";
        $drv_id =  trim($request->post('drv_id'));
        $ckin_ckout_bk_id = trim($request->post('ckin_ckout_bk_id'));
        $cin_out_table = trim($request->post('cin_out_table'));

        $ck_in_out_type = trim($request->post('ck_in_out_type'));
        $ck_in_out_point = trim($request->post('ck_in_out_point'));
        $cot_datetime = trim($request->post('cot_datetime'));
        $cot_remarks = trim($request->post('cot_remarks'));

       //echo "<pre>"; print_r($drv_id); echo"</pre>";
        //echo "<pre>"; print_r($cin_type); echo"</pre>";
        //echo "<pre>"; print_r($cot_ht); echo"</pre>";

        if($cin_out_table == 'cin'){
            $table = 'checkins';
            $label = "CheckIn";
            $cin_type_cloumn = "cin_type";
            $cin_ht_cloumn = "cin_ht";
            $cin_remarks_cloumn = "cin_remarks";
            $cin_datetime_cloumn = "cin_datetime";
            $booking_status_cloumn = "checkin_status";
        }else{
            $table = 'checkouts';
            $label = "CheckOut";
            $cin_type_cloumn = "cot_type";
            $cin_ht_cloumn = "cot_ht";
            $cin_remarks_cloumn = "cot_remarks";
            $cin_datetime_cloumn = "cot_datetime";
            $booking_status_cloumn = "checkout_status";
        }




        if (empty($drv_id)) {
            $err=1;
            $errStr = "Please Select Driver:";
        }else if (empty($ck_in_out_type)) {
            $err=2;
            $errStr = "$label point type:";

        }else if ( empty($ck_in_out_point)) {
            $err=3;
            $errStr = "$label points:";
        }else{

            /*
             * $sql = $wpdb->prepare("INSERT INTO wp_booking_checkins (drv_id, bk_id, cin_type, cin_ht, cin_datetime, cin_remarks)
			   VALUES (%d, %d, %d, %d, %s, %s)",
			   $_POST["drv_id"], $_POST["bk_id"], $_POST["cin_type"], $_POST["cin_ht"], $_POST["cin_datetime"],$_POST["cin_remarks"]);
			   $wpdb->query($sql);
			  if ($wpdb->last_error==''){echo "0";}else{echo "Unknow error, nothing recorded.";}

             */

            $already_exists = $this->ck_in_out_exist($table, $ckin_ckout_bk_id);
            if (!empty($already_exists)) {
                $err = 5;
                $errStr = "$label Already Exists....";
            }else{
                $ckin_added = DB::table($table)->insert(
                    array(
                        'driver_id' => $drv_id,
                        'booking_id' => $ckin_ckout_bk_id,
                        $cin_type_cloumn => $ck_in_out_type,
                        $cin_ht_cloumn => $ck_in_out_point,
                        $cin_datetime_cloumn => $cot_datetime,
                        $cin_remarks_cloumn => $cot_remarks,
                    )
                );
                if ($ckin_added == 1) {
                    $inserted_id = DB::getPdo()->lastInsertId();
                    $success_msg = "$label Added Succesfully.";
                    $success = 1;
                    $booking_update_status = Booking::find($ckin_ckout_bk_id);
                    if($booking_update_status) {
                        if ($cin_out_table == 'cin') {
                            $booking_update_status->checkin_status = 1;
                        } else {
                            $booking_update_status->checkout_status = 1;
                        }
                        $booking_update_status->save();
                    }
                } else {
                    $inserted_id = 0;
                    $err = 5;
                    $errStr = "Something Went Wrong Tr Again Later.";
                }
            }
        }

        return response()->json([
            'error' => $err,
            'error_text' => $errStr,
            'inserted_id' => $inserted_id,
            'success' => $success,
            'success_msg' => $success_msg,
       ]);
    }

    public function ck_in_out_exist($table,$booking_id){
        $bk_id_row = DB::table($table)
            ->where('booking_id', '=', $booking_id)
            ->first();
        return $bk_id_row;
    }

}
