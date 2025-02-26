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
use App\Booking;
use App\Customer;
use App\Settings;
class Edenemail
{

    static public function send_booking_email($bk_id_c) {

        $domain = Domain::get_domain_id(1);
        $PayPal_Email_Address = Edenemail::get_email_settings('st_paypal_email');
        $bk_detail = DB::table("bookings as bb")
            ->join("websites as ww", "ww.id", "=", "bb.website_id")
            ->join("terminals as t1", "t1.id", "=", "bb.bk_ou_te")
            ->join("terminals as t2", "t2.id", "=", "bb.bk_re_te")
            ->join("currencies as cc", "cc.id", "=", "bb.currency_id")
            ->join("airports as aa", "aa.id", "=", "bb.airport_id")
            ->join("services as ss", "ss.id", "=", "bb.service_id")
            ->join("customers as cus", "cus.id", "=", "bb.customer_id")
            ->where('bb.id', '=', $bk_id_c)
            ->select("bb.*",
                "bb.id AS booking_id",
                "bb.bk_date AS booking_date_uk",
                DB::raw("DATE_FORMAT(bb.bk_date, '%d/%m/%Y %H:%i') as bk_date"),
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
                "ss.slug",
                "cus.id AS cus_id","cus.*","ww.*"
            )
            ->first();
        $data = (array) $bk_detail;

          /*============ Payment Status ========== */
            $payment_reciever = "";
            $txn_payment_status = "";
            $txn_idexists = DB::table("payment_notifications")
            ->where('booking_id', '=', $bk_id_c)
            ->orderBy('id', 'desc')
            ->first();
            if($txn_idexists){
                $payment_reciever = $txn_idexists->payment_reciever;
                $txn_payment_status = $txn_idexists->payment_status;
            }
        /*============ Payment Status ========== */

        /*============ Arrange data ============*/
        if(empty($payment_reciever)){

            if($data['bk_payment_method']==1){ // Pay later
                //$payment_option = "PAY LATER <br /><span style='color:red;font-size:22px;font-weight:bold;'>( before flight departure )</span>";
                $payment_option = "PAY LATER <br /><span style='color:red;font-size:22px;font-weight:bold;'>( before flight departure )</span>";
                $current_booking_status = "Pending <span style='color:red;'>( Not Paid Yet )</span><br><span style='color:red;'>Please Pay as soon as Possible to confirm your Booking</span>";
            }else if($bk_detail->bk_payment_method ==2){ // PayPal
                $payment_option = "Paypal";
                $current_booking_status = "Pending <span style='color:red;'>( Not Paid Yet )</span>";
            }else if($bk_detail->bk_payment_method ==3){ // Credit/debit card
                $payment_option = "WorldPay";
                $current_booking_status = "Pending <span style='color:red;'>( Not Paid Yet )</span>";
            }else if($bk_detail->bk_payment_method ==5){ // Stripe
                $payment_option = "Stripe";
                $current_booking_status = "Pending <span style='color:red;'>( Not Paid Yet )</span>";
            }else if($bk_detail->bk_payment_method ==4){ // Credit/debit card
                $payment_option = "Other";
                $current_booking_status = "Pending <span style='color:red;'>( Not Paid Yet )</span>";
            }else if($bk_detail->bk_payment_method ==6){ // Credit/debit card
                $payment_option = "Bank Tranfer";
                $current_booking_status = "Active";
            }else if($bk_detail->bk_payment_method ==7){ // Credit/debit card
                $payment_option = "Cash";
                $current_booking_status = "Active";
            }else if($bk_detail->bk_payment_method ==8){ // Credit/debit card
                $payment_option = "Credit/Debit Card";
                $current_booking_status = "Active";
            }else if($bk_detail->bk_payment_method ==9){ // Credit/debit card
                $payment_option = "Tide link";
                $current_booking_status = "Active";
            }



        }else{
            $payment_option =  ucfirst($payment_reciever);
            if($txn_payment_status == 'Refunded'){
                $current_booking_status = "<span style='color:red;'>Cancelled / Refunded </span>";
            }else{
                $current_booking_status = "Active (<span style='color:green;'>Paid</span>)";
            }
            
        }

        if(isset($data['bk_status'])){
            if($data['bk_status']==4){ //Cancelled
                $current_booking_status = "<span style='color:red;'>Cancelled </span>";
            }
        }
        
        
        
        $data['payment_option'] = $payment_option;
        $data['current_booking_status'] = $current_booking_status;
        $data['txn_payment_status'] = $txn_payment_status;

        $data['directions']  = $domain->website_url ."/".$bk_detail->airport_directions;

        if(!empty($domain->website_logo)){
            $site_log = $domain->website_logo;
        }else{
            $site_log = '';
        }

        if(!empty($domain->website_logo)){
            $campare_site_log = $bk_detail->website_logo;
        }else{
            $campare_site_log = '';
        }

        if(!empty($domain->working_time)){
            $campare_working_time = $domain->working_time;
        }else{
            $campare_working_time = '';
        }

        if(!empty($domain->alternate_email)){
            $campare_alternate_email = $domain->alternate_email;
        }else{
            $campare_alternate_email = '';
        }


        if(!empty($domain->email)){
            $campare_site_email = $domain->email;
        }else{
            $campare_site_email = '';
        }


        if(!empty($bk_detail->website_email_banner)){
            $email_banner = $bk_detail->website_email_banner;
        }else{
            $email_banner = 'website_email_banner.png';
        }

      

        /*============= PROMO CODE==============*/
        $datepromo = date("y-m-d");
        $special_promo ="";
        $promotion = DB::table("promotion_offers")
            ->where('offer_active', 1)
            ->where('offer_special', 1)
            ->where('website_id', $data['website_id'])
            ->where('offer_date1', '<=', $datepromo)
            ->where('offer_date2', '>=', $datepromo)
            ->first();
        if($promotion) {
            $ddate = date('d/m/Y', strtotime($promotion->offer_date2));
            $special_promo = "<div style='background-color:#CDCDCD;padding:2px;'><h2>YOUR SPECIAL PROMOTIONAL CODE FOR NEXT BOOKING</h2>";
            $special_promo = "$special_promo $promotion->offer_coupon ($promotion->offer_percentage % discount) Valid till: $ddate </div>";
        }
        /*============= PROMO CODE ==============*/


        /* ======= Home PromotionOffer ======= */
        $dt = date('Y-m-d');
        $homepromo = DB::table("promotion_offers")
            ->where('offer_home', 1)
            ->where('offer_active', 1)
            ->where('website_id', $data['website_id'])
            ->where('offer_date1', '<=', $datepromo)
            ->where('offer_date2', '>=', $datepromo)
            ->first();
        /* ======= Home PromotionOffer ======= */


        //$data['website_logo'] = $bk_detail->website_url.'/uploads/'.$site_log;
        //$data['website_email_banner'] = $bk_detail->website_url.'/uploads/'.$email_banner;
        
        $data['website_name_compare'] = $domain->website_name;
        $data['main_website_url'] = $domain->website_url;
        $data['website_logo'] = $domain->website_url.'/storage/uploads/'.$site_log;
        $data['campare_website_logo'] = $domain->website_url.'/storage/uploads/'.$campare_site_log;
        $data['campare_working_time'] = $campare_working_time;
        $data['campare_alternate_email'] = $campare_alternate_email;
        $data['campare_site_email'] = $campare_site_email;
        $data['website_email_banner'] = $domain->website_url.'/storage/uploads/'.$email_banner;
        
        $data['image_right'] = $domain->website_url.'/storage/uploads/email/image_right.png';
        $data['image_left'] = $domain->website_url.'/storage/uploads/email/image_left.png';
        $data['qr_com'] = $domain->website_url.'/storage/uploads/email/qr-eden-com.png';
        $data['qr_co_uk']= $domain->website_url.'/storage/uploads/email/qr-eden-co-uk.png';
        $data['booking_qr_code']= $domain->website_url.'/storage/uploads/qrcodes/'.$bk_id_c.'.png';
        $data['special_promo'] = $special_promo;
        $data['homepromo'] = $homepromo;



        $amount_detail = "";
        $amount_detail .= "<tr><td>Booking interval</td><td>$bk_detail->bk_days Days</td></tr>";
        if($bk_detail->bk_gross_price != 0) {
            $amount_detail .= "<tr><td>Parking price</td><td> $bk_detail->cur_symbol " . number_format($bk_detail->bk_gross_price - $bk_detail->bk_discount_amount, 2, '.', '') . "</td></tr>";
        }else{
            $amount_detail .= "<tr><td>Parking price</td><td> $bk_detail->cur_symbol " . number_format($bk_detail->bk_total_amount - $bk_detail->bk_discount_amount, 2, '.', '') . "</td></tr>";
        }

        $carwash = $bk_detail->carwash_in_and_out + $bk_detail->carwash_out_only + $bk_detail->carwash_in_only;
        if($carwash == 0){
            $amount_detail .= "<tr><td>Car Wash</td><td> No Thanks</td></tr>";
        }else{

            if (trim($bk_detail->carwash_in_and_out) != 0) {
                $title = 'ADD FULL CAR WASH (IN AND OUT) ';
            } elseif (trim($bk_detail->carwash_out_only) != 0) {
                $title = 'ADD CAR WASH (ONLY OUTSIDE) ';
            } elseif (trim($bk_detail->carwash_in_only) != 0) {
                $title = 'ADD CAR WASH (ONLY INSIDE) ';
            }
            $amount_detail .= "<tr><td>$title </td><td> $bk_detail->cur_symbol ".number_format($carwash, 2, '.', '')."</td></tr>";
        }

         
        $temrmainl_access_free_notice = "";
        if($data['terminal_parking_fee'] == 'N'){
            $temrmainl_access_free_notice = "Not Added";
        }else if ($data['terminal_parking_fee'] == 'P'){
            $temrmainl_access_free_notice = "<span style='color:green'>(Added)</span> ";
        }
        
        //$amount_detail = "Booking interval: ".$bk_detail->bk_days."Days<br />";
        $amount_detail .= "<tr><td>Out Of Working hours</td><td> $bk_detail->cur_symbol ".number_format($bk_detail->not_working_hours, 2, '.', '')."</td></tr>";
        $amount_detail .= "<tr><td>Last Minute Booking</td><td> $bk_detail->cur_symbol ".number_format($bk_detail->last_min_booking, 2, '.', '')."</td></tr>";
        $amount_detail .= "<tr><td>Terminal Switch Charge</td><td> $bk_detail->cur_symbol ".number_format($bk_detail->terminal_extra_charges, 2, '.', '')."</td></tr>";
        $amount_detail .= "<tr><td>Charging Amount</td><td> $bk_detail->cur_symbol ".number_format($bk_detail->charging, 2, '.', '')."</td></tr>";
        $amount_detail .= "<tr><td>Service Charge</td><td> $bk_detail->cur_symbol ".number_format($bk_detail->charging_service_charges, 2, '.', '')."</td></tr>";
        $amount_detail .= "<tr><td>Online payment fee ($bk_detail->bk_online_fee_value %)</td><td> $bk_detail->cur_symbol ".number_format($bk_detail->bk_online_fee_amount, 2, '.', '')." (Non-Refundable)</td></tr>";
        $amount_detail .= "<tr><td>Booking fee</td><td> $bk_detail->cur_symbol ".number_format($bk_detail->bk_booking_fee, 2, '.', '')." (Non-Refundable)</td></tr>";
        //$amount_detail = "$amount_detail Airport access fee: $bk_detail->cur_symbol ".number_format($bk_detail->bk_access_fee, 2, '.', '')." (Non-Refundable)<br />Customers that book via third parties must pay the terminal access fee.<br />";
        //$amount_detail .= "<tr><td>Airport access fee</td><td> $bk_detail->cur_symbol ".number_format($bk_detail->bk_access_fee, 2, '.', '')." (Non-Refundable) $temrmainl_access_free_notice <br />Customers that book via third parties must pay the terminal access fee.</td></tr>";
        $amount_detail .= "<tr><td>Airport access fee</td><td> $temrmainl_access_free_notice </td></tr>";
        //$amount_detail = "$amount_detail Customers that book via third parties must pay the terminal access fee.<br />";
        $amount_detail .= "<tr><td>VAT ($bk_detail->bk_vat_value %)</td><td> $bk_detail->cur_symbol ".number_format($bk_detail->bk_vat_amount, 2, '.', '')."</td></tr>";

        $TOTAL_PAYABLE_AMOUNT = $bk_detail->bk_total_amount + $carwash + $bk_detail->not_working_hours + $bk_detail->last_min_booking + $bk_detail->terminal_extra_charges + $bk_detail->charging_service_charges + $bk_detail->charging;
        if ($bk_detail->bk_discount_offer_coupon<>""){ // if promotional discount applied
            $amount_detail .= "<tr><td>Total amount</td><td> $bk_detail->cur_symbol ".number_format($TOTAL_PAYABLE_AMOUNT + $bk_detail->bk_discount_offer_amount, 2, '.', '')."</td></tr>";
            $amount_detail .= "<tr><td>Promotional discount amount ($bk_detail->bk_discount_offer_value %)</td><td> $bk_detail->cur_symbol ".number_format($bk_detail->bk_discount_offer_amount, 2, '.', '')."</td></tr>";

            //$amount_detail = "$amount_detail <strong>TOTAL PAYABLE AMOUNT: $bk_detail->cur_symbol ".number_format($bk_detail->bk_final_amount, 2, '.', '')."</strong>";
            //$orderamount = 	number_format($bk_detail->bk_final_amount, 2, '.', '');
            //$TOTAL_PAYABLE_AMOUNT = $bk_detail->bk_final_amount + $carwash + $bk_detail->not_working_hours + $bk_detail->last_min_booking + $bk_detail->charging_service_charges + $bk_detail->charging;
            //$amount_detail .= "$amount_detail<tr><td>TOTAL PAYABLE AMOUNT</td><td> $bk_detail->cur_symbol ".number_format($TOTAL_PAYABLE_AMOUNT, 2, '.', '')."</td></tr>";
            //$orderamount = 	number_format($TOTAL_PAYABLE_AMOUNT, 2, '.', '');
        } else {
            //$amount_detail = "$amount_detail <strong>TOTAL PAYABLE AMOUNT: $bk_detail->cur_symbol ".number_format($bk_detail->bk_total_amount, 2, '.', '')."</strong>";
            //$orderamount = 	number_format($bk_detail->bk_total_amount, 2, '.', '');
            
        }
        
        $amount_detail .= "<tr><td>TOTAL PAYABLE AMOUNT</td><td> $bk_detail->cur_symbol ".number_format($TOTAL_PAYABLE_AMOUNT, 2, '.', '')."</td></tr>";
        $orderamount = 	number_format($TOTAL_PAYABLE_AMOUNT, 2, '.', '');

        
        $supplier_cost = "";
        
        if ($data['supplier_cost_type'] != 'none' && $data['supplier_cost_value'] > 0) {
            if ($data['supplier_cost_type'] == 'percentage') {
                // Calculate supplier cost as a percentage of the total payable amount
                $supplier_cost = ($data['supplier_cost_value'] / 100) * $TOTAL_PAYABLE_AMOUNT;
            } else {
                // Supplier cost is a fixed value
                $supplier_cost = $TOTAL_PAYABLE_AMOUNT - $data['supplier_cost_value']; 
            }
        }
        if(!empty($supplier_cost)){ 
            $supplier_cost = number_format($supplier_cost, 2, '.', '');
            $amount_detail .= "<tr class='hidecustomer'><td>Service Provider Cost</td><td>$bk_detail->cur_symbol $supplier_cost </td></tr>";
        }
        $amount_detail .= "<tr class='hidesupplier'><td colspan='2'>(The price paid is non-refundable in the case of a no show or booking cancellation within 24 hours of departure.)</td></tr>";
        
        
        $data['amount_detail'] = $amount_detail;
        $data['total_payable_amount'] = $bk_detail->cur_symbol . $TOTAL_PAYABLE_AMOUNT;

        
  

        $payment_links = "";
        if(empty($payment_reciever)){
            ///$notify_url = $bk_detail->website_url
            $notify_url = $domain->website_url . "/api/ipnn";
            $paypal_link = "https://www.paypal.com/cgi-bin/webscr?currency_code=$bk_detail->cur_code&cmd=_xclick&business=$PayPal_Email_Address&amount=$orderamount&item_name=$bk_detail->bk_ref&notify_url=$notify_url";
            //$worldpay_link = "https://secure.worldpay.com/wcc/purchase?instId=1152063&cartId=$bk_id_c&currency=$bk_detail->cur_code&amount=$orderamount&desc=$bk_detail->bk_ref&testMode=0";
            $payment_links = "<br />";
            $payment_links = "$payment_links <a href='$paypal_link'>Pay by PayPal</a>";
            //$payment_links = "$payment_links <a href='$worldpay_link'>Pay by WorldPay</a>";
        }else{
            $payment_links = " ";
        }
        if($bk_detail->bk_payment_method ==6 || $bk_detail->bk_payment_method ==7){
            $payment_links = "";
        }

        $data['payment_links'] = $payment_links;



        $total_bookings_count  = self::get_customers_total_booking_count($bk_detail->cus_email);
        if($total_bookings_count > 0){
            $data['total_bookings_count'] = $total_bookings_count;
        }else{
            $data['total_bookings_count'] = 0;
        }

        //empty($payment_reciever)
        $Park_and_Ride_Service ="";
        if(in_array($data['slug'], array('park-and-ride'))) {
            $Park_and_Ride_Service = "<div style='margin:1px 0px 14px 0px;width: 100%;text-align: center;background-color: #f7dddd;padding: 0;border: 1px solid orangered;'>
                                        <h2 style='font-size: 30px;margin:3px;'>Park & Ride Customers Follow The Address Please</h2>
                                        <p style='font-size: 14px;text-align: center;margin: 6px 0;'>Unit 47
                                        The Lodge and Annex Harmondsworth Lane
                                        West Drayton
                                        UB7 0LQ</p>
                                        </div>
                                        ";

        }
        $data['Park_and_Ride_Service'] = $Park_and_Ride_Service;
        return $data;
    }


   static public function get_global_settings($sname){
        $settings = DB::table("settings")
            ->where('website_id', 1)
            ->where('option_name', $sname)
            ->first();
        return $settings->option_value;
    }

    static public function get_email_settings($sname){
        $settings = DB::table("global_settings")
            ->where('option_name', $sname)
            ->first();
        return $settings->option_value;
    }

    static  function get_website_settings($id){

        $settings_s = DB::table("settings as ss")
            ->leftJoin("websites as ww", "ww.id", "=", "ss.website_id")
            ->where('ss.website_id', $id)
            ->select("ss.*")
            ->get();
        if($settings_s->isEmpty()){
            $settings_s = DB::table("settings as ss")
                ->leftJoin("websites as ww", "ww.id", "=", "ss.website_id")
                ->where('ss.website_id', 1)
                ->select("ss.*")
                ->get();
        }

        foreach ($settings_s as $ss){
            $name = $ss->option_name;
            $settings[$name] = $ss->option_value;
        }

        return $settings;
    }
    static private function get_customers_total_booking_count($cus_email){
        $booking_count = DB::table("bookings as bb");
        $booking_count =  $booking_count->join("customers as cus", "cus.id", "=", "bb.customer_id");
        $booking_count = $booking_count->where('bb.bk_status', '>', 0);
        $booking_count = $booking_count->where('cus_email', '=', $cus_email);
        $booking_count = $booking_count->orWhere('cus_email_1', '=',$cus_email);
        $booking_count =  $booking_count->count();
        return $booking_count;
    }
    
}
