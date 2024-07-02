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
class OverparkedController  extends Controller
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
        $bookings = $this->get_bookings();
        //echo"<pre>";print_r($bookings); echo "</pre>";exit;
        //echo"<pre>";print_r($bookings_in); echo "</pre>";
        //echo"<pre>";print_r($bookings_out); echo "</pre>";
        //exit;
        $title = ' Vehicles Over Parked';
        return view('admin.overparked.index', compact('bookings','title'));
    }

    public function get_bookings(){

        $bookings = DB::table("bookings as bb");
        $bookings =  $bookings->join("countries as country", "country.id", "=", "bb.country_id");
        $bookings =  $bookings->join("websites as ww", "ww.id", "=", "bb.website_id");
        $bookings =  $bookings->join("terminals as t1", "t1.id", "=", "bb.bk_ou_te");
        $bookings =  $bookings->join("terminals as t2", "t2.id", "=", "bb.bk_re_te");
        $bookings =  $bookings->join("airports as aa", "aa.id", "=", "bb.airport_id");
        $bookings =  $bookings->join("customers as cus", "cus.id", "=", "bb.customer_id");
        $bookings =  $bookings->join("colors as clrr", "clrr.clr_name", "=", "bb.bk_ve_co");

        $datetime = date("Y-m-d H:i:s");

        $bookings = $bookings->where('bb.bk_to_date', '<', $datetime);
        $bookings = $bookings->where('bb.bk_status', '>', 0);
        $bookings = $bookings->where('bb.bk_is_del', '=', 0);

        $bookings = $bookings->select("bb.*", "bb.id as booking_id",
            DB::raw("DATE_FORMAT(bb.bk_date, '%Y-%m-%d') as bk_date"),
            DB::raw("DATE_FORMAT(bb.bk_from_date, '%d/%m/%Y %H:%i') as bk_from_date"),
            DB::raw("DATE_FORMAT(bb.bk_to_date, '%d/%m/%Y %H:%i') as bk_to_date"),
            DB::raw("DATE_FORMAT(bb.bk_ve_do_dt, '%d/%m/%Y %H:%i') as bk_ve_do_dt"),
            DB::raw("DATE_FORMAT(bb.bk_ve_pu_dt, '%d/%m/%Y %H:%i') as bk_ve_pu_dt"),
            "bb.bk_from_date as bk_from_dateh",
            "bb.bk_to_date as bk_to_dateh",
            "country.id AS countryid",
            "country.name as countryname",
            "aa.id AS selected_airport_id",
            "aa.airport_name",
            "aa.airport_directions",
            "t1.airport_id AS airport_id1",
            "t1.id AS ter_id1",
            "t1.ter_name AS ter_name1",
            "t2.airport_id AS airport_id2",
            "t2.id AS ter_id2",
            "t2.ter_name AS ter_name2",
            "cus.id AS cus_id", "cus.*",
            "ww.*",
            "clrr.id as clrr_id", "clrr.clr_name"
        );
        $bookings =  $bookings->orderBy('bb.id', 'desc');
        $bookings =  $bookings->get();
        return $bookings;
    }
}
