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
class CheckinoutController  extends Controller
{
        /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //dd('asdasdasd');
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
        //$terminals_json = json_encode($terminals_json);
        //dd($terminals_json);
        /*============ /Terminals ============*/


        if (request()->has('ref') && (request()->input('ref') != '')) {

           $ref = request()->input('ref') ;

        }else{
            $ref ='';
        }
        if (request()->has('terminal') && (request()->input('terminal') != '')) {
            $terminal = request()->input('terminal') ;
        }else{
            $terminal ='';
        }
        if (request()->has('hrs') && (request()->input('hrs') != '')) {
            $hrs = request()->input('hrs') ;
        }else{
            $hrs ='';
        }

        $bookings = $this->get_bookings('all', $ref, $terminal, $hrs);
        $bookings_in = $this->get_bookings('in', $ref, $terminal, $hrs);
        $bookings_out = $this->get_bookings('out', $ref, $terminal, $hrs);
        //echo"<pre>";print_r($bookings); echo "</pre>";
        //echo"<pre>";print_r($bookings_in); echo "</pre>";
        //echo"<pre>";print_r($bookings_out); echo "</pre>";
        //exit;
        $title = ' Checkin/Checkout Report';
        return view('admin.checkinout.index', compact('bookings','bookings_in','bookings_out','title','terminals_json','ref','terminal','hrs'));
    }

    public function get_bookings($type, $ref, $terminal, $hrs){

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
        if($type == 'all') {

            $bookings =  $bookings->join("checkouts as cko", "cko.booking_id", "=", "bb.id");
            $bookings =  $bookings->join("checkins as cki", "cki.booking_id", "=", "bb.id");
            $bookings =  $bookings->join("terminals as cint", "cint.id", "=", "cki.cin_ht");
            $bookings =  $bookings->join("terminals as cout", "cout.id", "=", "cko.cot_ht");

            if(!empty($terminal)){
                $bookings = $bookings->where('cki.cin_ht', '=', $terminal);
                $bookings = $bookings->where('cko.cot_ht', '=',$terminal);
            }
            if(!empty($hrs)){
                $bookings = $bookings->where('cki.cin_datetime', 'LIKE', '%' . $hrs . '%');
                $bookings = $bookings->orWhere('cko.cot_datetime', 'LIKE', '%' . $hrs . '%');
            }

        }
        if($type == 'in') {
            $bookings =  $bookings->join("checkins as cki", "cki.booking_id", "=", "bb.id");
            $bookings =  $bookings->join("terminals as cint", "cint.id", "=", "cki.cin_ht");
            if(!empty($terminal)){
                $bookings = $bookings->where('cki.cin_ht', '=', $terminal);
            }
            if(!empty($hrs)){
                $bookings = $bookings->where('cki.cin_datetime', 'LIKE', '%' . $hrs . '%');
            }
        }
        if($type == 'out') {
            $bookings =  $bookings->join("checkouts as cko", "cko.booking_id", "=", "bb.id");
            $bookings =  $bookings->join("terminals as cout", "cout.id", "=", "cko.cot_ht");
            if(!empty($terminal)){
                $bookings = $bookings->where('cko.cot_ht', '=', $terminal);
            }
            if(!empty($hrs)){
                $bookings = $bookings->where('cko.cot_datetime', 'LIKE', '%' . $hrs . '%');
            }
        }

        //$bookings = $bookings->where('bb.bk_status', '>', 0);
        if(!empty($ref)){
            $bookings = $bookings->where('bb.bk_ref', '=', $ref);
        }

        $bookings = $bookings->where('bb.bk_status', '>', 0);
        $bookings = $bookings->where('bb.bk_is_del', '=', 0);
        if($type == 'all'){
            $bookings = $bookings->where('bb.checkin_status', '=', 1);
            $bookings = $bookings->where('bb.checkout_status', '=', 1);
        }
        if($type == 'in'){
            $bookings = $bookings->where('bb.checkin_status', '=', 1);
        }
        if($type == 'out'){
            $bookings = $bookings->where('bb.checkout_status', '=', 1);
        }


        if($type == 'all') {
            $bookings = $bookings->select("bb.*", "bb.id as booking_id",
                DB::raw("DATE_FORMAT(bb.bk_date, '%Y-%m-%d') as bk_date"),
                DB::raw("DATE_FORMAT(bb.bk_from_date, '%d/%m/%Y %H:%i') as bk_from_date"),
                DB::raw("DATE_FORMAT(bb.bk_to_date, '%d/%m/%Y %H:%i') as bk_to_date"),
                DB::raw("DATE_FORMAT(bb.bk_ve_do_dt, '%d/%m/%Y %H:%i') as bk_ve_do_dt"),
                DB::raw("DATE_FORMAT(bb.bk_ve_pu_dt, '%d/%m/%Y %H:%i') as bk_ve_pu_dt"),
                DB::raw("DATE_FORMAT(cko.cot_datetime, '%d/%m/%Y %H:%i') as coutdatetime"),
                DB::raw("DATE_FORMAT(cki.cin_datetime, '%d/%m/%Y %H:%i') as cindatetime"),
                "country.id AS countryid",
                "country.name as countryname",
                "aa.id AS selected_airport_id",
                "aa.airport_name",
                "aa.airport_directions",
                "agt.id AS agt1_id",
                "agt.agt_company AS agt1_company",
                "fagt.id AS fagt_id",
                "fagt.agt_company AS fagt_company",
                "t1.airport_id AS airport_id1",
                "t1.id AS ter_id1",
                "t1.ter_name AS ter_name1",
                "t2.airport_id AS airport_id2",
                "t2.id AS ter_id2",
                "t2.ter_name AS ter_name2",
                "cout.ter_name AS co_ter_name",
                "cint.ter_name AS ci_ter_name",
                "cc.cur_symbol", "cc.cur_code",
                "ss.service_name",
                "cus.id AS cus_id", "cus.*",
                "ww.*",
                "clrr.id as clrr_id", "clrr.clr_name"
            );
        }
        if($type == 'in') {
            $bookings = $bookings->select("bb.*", "bb.id as booking_id",
                DB::raw("DATE_FORMAT(bb.bk_date, '%Y-%m-%d') as bk_date"),
                DB::raw("DATE_FORMAT(bb.bk_from_date, '%d/%m/%Y %H:%i') as bk_from_date"),
                DB::raw("DATE_FORMAT(bb.bk_to_date, '%d/%m/%Y %H:%i') as bk_to_date"),
                DB::raw("DATE_FORMAT(bb.bk_ve_do_dt, '%d/%m/%Y %H:%i') as bk_ve_do_dt"),
                DB::raw("DATE_FORMAT(bb.bk_ve_pu_dt, '%d/%m/%Y %H:%i') as bk_ve_pu_dt"),
                DB::raw("DATE_FORMAT(cki.cin_datetime, '%d/%m/%Y %H:%i') as cindatetime"),
                "country.id AS countryid",
                "country.name as countryname",
                "aa.id AS selected_airport_id",
                "aa.airport_name",
                "aa.airport_directions",
                "agt.id AS agt1_id",
                "agt.agt_company AS agt1_company",
                "fagt.id AS fagt_id",
                "fagt.agt_company AS fagt_company",
                "t1.airport_id AS airport_id1",
                "t1.id AS ter_id1",
                "t1.ter_name AS ter_name1",
                "t2.airport_id AS airport_id2",
                "t2.id AS ter_id2",
                "t2.ter_name AS ter_name2",
                "cint.ter_name AS ci_ter_name",
                "cc.cur_symbol", "cc.cur_code",
                "ss.service_name",
                "cus.id AS cus_id", "cus.*",
                "ww.*",
                "clrr.id as clrr_id", "clrr.clr_name"
            );
        }
        if($type == 'out') {
            $bookings = $bookings->select("bb.*", "bb.id as booking_id",
                DB::raw("DATE_FORMAT(bb.bk_date, '%Y-%m-%d') as bk_date"),
                DB::raw("DATE_FORMAT(bb.bk_from_date, '%d/%m/%Y %H:%i') as bk_from_date"),
                DB::raw("DATE_FORMAT(bb.bk_to_date, '%d/%m/%Y %H:%i') as bk_to_date"),
                DB::raw("DATE_FORMAT(bb.bk_ve_do_dt, '%d/%m/%Y %H:%i') as bk_ve_do_dt"),
                DB::raw("DATE_FORMAT(bb.bk_ve_pu_dt, '%d/%m/%Y %H:%i') as bk_ve_pu_dt"),
                DB::raw("DATE_FORMAT(cko.cot_datetime, '%d/%m/%Y %H:%i') as coutdatetime"),
                "country.id AS countryid",
                "country.name as countryname",
                "aa.id AS selected_airport_id",
                "aa.airport_name",
                "aa.airport_directions",
                "agt.id AS agt1_id",
                "agt.agt_company AS agt1_company",
                "fagt.id AS fagt_id",
                "fagt.agt_company AS fagt_company",
                "t1.airport_id AS airport_id1",
                "t1.id AS ter_id1",
                "t1.ter_name AS ter_name1",
                "t2.airport_id AS airport_id2",
                "t2.id AS ter_id2",
                "t2.ter_name AS ter_name2",
                "cout.ter_name AS co_ter_name",
                "cc.cur_symbol", "cc.cur_code",
                "ss.service_name",
                "cus.id AS cus_id", "cus.*",
                "ww.*",
                "clrr.id as clrr_id", "clrr.clr_name"
            );
        }

        $bookings =  $bookings->orderBy('bb.id', 'desc');
        $bookings =  $bookings->limit(30);
        $bookings =  $bookings->get();
        return $bookings;
    }
}
