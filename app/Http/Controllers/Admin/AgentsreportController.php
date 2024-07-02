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
class AgentsreportController  extends Controller
{
        /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //dd('asdasdasd');
        $highlight = 120;
        if (request()->has('highlight') && (request()->input('highlight') != '')) {
            $highlight = request()->input('highlight') ;
        }

        if (request()->has('end_date') && (request()->input('end_date') != '')) {
            $end_date = request()->input('end_date') ;
        }else{
            $end_date = date('d/m/Y');
        }
        if (request()->has('start_date') && (request()->input('start_date') != '')) {
            $start_date = request()->input('start_date') ;
        }else{
            //$start_date = date('d/m/Y');
            $start_date = date('d/m/Y', strtotime("-60 days"));
        }

        if (request()->has('cagent') && (request()->input('cagent') != '')) {
            $cagent = request()->input('cagent') ;
        }else{
            $cagent = 0;
        }

        if (request()->has('agent_booking_ref') && (request()->input('agent_booking_ref') != '')) {
            $agent_booking_ref = request()->input('agent_booking_ref') ;
        }else{
            $agent_booking_ref = '';
        }



        $agents = Agents::all();
        /*============ Agents ============*/
        foreach ($agents as $agent){
            if(!empty(trim($agent->agt_company))) {
                $agents_ss[$agent->id] = $agent->agt_company;
            }
        }
        //$agents = json_encode($agents_json);
       // dd($agents);
        /*============ Agents ============*/

        $bookings_agt = $this->get_bookings('agt', $start_date, $end_date, $agent_booking_ref, $cagent);
        $bookings_fagt = $this->get_bookings('fagt', $start_date, $end_date, $agent_booking_ref, $cagent);
        //echo"<pre>";print_r($bookings_agt); echo "</pre>";
        //echo"<pre>";print_r($bookings_fagt); echo "</pre>";
        //exit;
        $title = 'Agents Job Reports';
        return view('admin.agentsreport.index', compact('bookings_agt','bookings_fagt', 'title', 'start_date', 'end_date', 'agents_ss', 'cagent', 'agent_booking_ref'));
    }

    public function get_bookings($type, $start_date, $end_date, $agent_booking_ref, $cagent){
       // dd($cagent);
        $agent_data = '';
        if($cagent == 0) {
            $agent_name = 'Eden';
            $agt_commision = 0;
            $agt_fee = 0;
        }else{
            $agent_data = Agents::where('id', $cagent)->first();
            $agent_name = $agent_data->agt_company;
            $agt_commision = $agent_data->agt_commision;
            $agt_fee = $agent_data->agt_fee;
        }

        //dd($agent_data);
        $start_date = date('Y-m-d', strtotime($start_date));
        $end_date = date('Y-m-d', strtotime($end_date));
        $bookings = DB::table("bookings as bb");
        $bookings =  $bookings->join("countries as country", "country.id", "=", "bb.country_id");
        $bookings =  $bookings->join("websites as ww", "ww.id", "=", "bb.website_id");
        $bookings =  $bookings->join("terminals as t1", "t1.id", "=", "bb.bk_ou_te");
        $bookings =  $bookings->join("terminals as t2", "t2.id", "=", "bb.bk_re_te");
        $bookings =  $bookings->join("airports as aa", "aa.id", "=", "bb.airport_id");
        $bookings =  $bookings->join("customers as cus", "cus.id", "=", "bb.customer_id");
        $bookings =  $bookings->join("colors as clrr", "clrr.clr_name", "=", "bb.bk_ve_co");
        $bookings =  $bookings->join("agents as agt", "agt.id", "=", "bb.agent_id",'left outer');
        $bookings =  $bookings->join("agents as fagt", "fagt.id", "=", "bb.fwd_agt_id",'left outer');
        $bookings = $bookings->where('bb.bk_status', '>', 0);
        $bookings = $bookings->where('bb.bk_is_del', '=', 0);

            if(!empty($agent_booking_ref)) {
                $bookings = $bookings->where('bb.bk_ref', '=', $agent_booking_ref);
            }else{
                $bookings = $bookings->whereBetween('bb.bk_ve_do_dt', array($start_date, $end_date));
                //if ($cagent != '') {
                    if ($cagent == 0) {
                        $bookings = $bookings->where('bb.fwd_agt_id', '=', 0);
                        $bookings = $bookings->where('bb.agent_id', '=', 0);
                    } else if ($cagent != 0) {
                        if ($type == 'agt') {
                            $bookings = $bookings->where('bb.agent_id', '=', $cagent);
                        } else if ($type == 'fagt') {
                            $bookings = $bookings->where('bb.fwd_agt_id', '=', $cagent);
                        }
                    }
                //}
            }

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
            "agt.id AS agt1_id",
            "agt.agt_company AS agt1_company",
            "fagt.id AS fagt_id",
            "fagt.agt_company AS fagt_company",
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
        $Total =0;
        $C_Total =0;
        foreach ($bookings as $booking){

            $agt_commision_plus_fee =  $agt_fee + $agt_commision;
            $agt_commision_final = ($agt_commision_plus_fee / 100) * $booking->bk_total_amount;
            $agt_commision_final = $booking->bk_total_amount - $agt_commision_final;

            $Total = $Total + $booking->bk_total_amount;
            $C_Total = $C_Total + $agt_commision_final;

            $booking->agt_fee = $agt_fee;
            $booking->agt_commision = $agt_commision;
            $booking->agt_commision_plus_fee = $agt_commision_plus_fee;
            $booking->agt_commision_final = $agt_commision_final;
            $booking->agt_final_bk_total = $Total;
            $booking->C_Total = $C_Total;
        }
        return $bookings;
    }


}
