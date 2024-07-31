<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use App\Agents;
use App\Booking;
use App\Website;
use App\Country;
use App\Terminal;
use App\Airport;
use App\Color;
class DocketController  extends Controller
{
        /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //dd('asdasdasd');

        $domain = Domain::get_domain_id(1);
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
        $bookings = $bookings->where('bb.id', '=', request()->input('id'));
        $bookings =  $bookings->select("bb.*", "bb.id as booking_id",
            //DB::raw("DATE_FORMAT(bb.bk_date, '%Y-%m-%d') as bk_date"),
            //DB::raw("DATE_FORMAT(bb.bk_from_date, '%d/%m/%Y %H:%i') as bk_from_date"),
            //DB::raw("DATE_FORMAT(bb.bk_to_date, '%d/%m/%Y %H:%i') as bk_to_date"),
            //DB::raw("DATE_FORMAT(bb.bk_ve_do_dt, '%d/%m/%Y %H:%i') as bk_ve_do_dt"),
            // DB::raw("DATE_FORMAT(bb.bk_ve_pu_dt, '%d/%m/%Y %H:%i') as bk_ve_pu_dt"),
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
        $bookings =  $bookings->orderBy('bb.id', 'desc');
        $bookings =  $bookings->first();
        //dd($bookings);
        $CUSTOMER_EMAIL = $bookings->cus_email;
        $booking_count = DB::table("bookings as bb");
        $booking_count =  $booking_count->join("customers as cus", "cus.id", "=", "bb.customer_id");
        $booking_count = $booking_count->where('bb.bk_status', '>', 0);
        $booking_count = $booking_count->where('cus_email', '=', $CUSTOMER_EMAIL);
        $booking_count = $booking_count->orWhere('cus_email_1', '=',$CUSTOMER_EMAIL);
        $booking_count =  $booking_count->count();
        //dd($booking_count);
        if (request()->has('docket') && (!empty(request()->input('docket'))) && (request()->input('docket') == 5 || request()->input('docket') == 6)) {
            $docket= request()->input('docket');
            return view('admin.docket.docket-4-5', compact('bookings','docket', 'domain'));
        }else if (request()->has('docket') && (!empty(request()->input('docket'))) && (request()->input('docket') == '22-p' || request()->input('docket') == '22')) {
            $print = $docket= request()->input('print');
            $docket = $docket= request()->input('docket');
            return view('admin.docket.docket-22', compact('bookings','print','docket','booking_count', 'domain'));
        }else{
            $print = $docket= request()->input('print');
            $docket = $docket= request()->input('docket');
            return view('admin.docket.docket', compact('bookings','print','docket','booking_count', 'domain'));
        }
    }

}
