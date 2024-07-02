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
class PickdropreportController  extends Controller
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
        $highlight = 120;
        if (request()->has('highlight') && (request()->input('highlight') != '')) {
            $highlight = request()->input('highlight') ;
        }
        if (request()->has('ref') && (request()->input('ref') != '')) {

           $ref = request()->input('ref') ;

        }else{
            $ref ='';
        }
        if (request()->has('terminal') && (!empty(request()->input('terminal') ))) {
            $terminal = request()->input('terminal') ;
        }else{
            $terminal ='';
        }
        if (request()->has('end_date') && (request()->input('end_date') != '')) {
            $end_date = request()->input('end_date') ;
        }else{
            $end_date = date('Y-m-d');
            $end_date = date('Y-m-d', strtotime("+30 days"));
        }
        if (request()->has('start_date') && (request()->input('start_date') != '')) {
            $start_date = request()->input('start_date') ;
        }else{
            $start_date = date('Y-m-d');
        }



        //$bookings = $this->get_bookings('all', $ref, $terminal, $start_date, $end_date);
        $bookings_arrivals = $this->get_bookings('Arrivals', $ref, $terminal, $start_date, $end_date);//Arrivals
        $bookings_departures = $this->get_bookings('Departures', $ref, $terminal, $start_date, $end_date);//Departures
        $title = ' Vehicle Arrival/Departure SEARCH';
        return view('admin.pickdropreport.index', compact('bookings_arrivals','bookings_departures','title','terminals_json','ref','terminal','start_date','end_date','highlight'));
    }

    public function get_bookings_old($type, $ref, $terminal, $start_date, $end_date){

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

        if($type == 'all'){

            $bookings = $bookings->whereBetween('bb.bk_ve_do_dt', array($start_date, $end_date));
            $bookings = $bookings->whereBetween('bb.bk_ve_pu_dt', array($start_date, $end_date));
            if(!empty($terminal)){
                //$bookings = $bookings->where('bb.bk_ou_te', '=', $terminal);
                //$bookings = $bookings->orWhere('bb.bk_re_te', '=',$terminal);
              //  $bookings = $bookings->whereLike(['bb.bk_ou_te', 'bb.bk_re_te'], $terminal);
               // $bookings = $bookings->where('bb.bk_re_te', '=', $terminal);
                $bookings = $bookings->orWhere(function ($query) use ($terminal) {
                    $query->where('bb.bk_re_te', '=', $terminal);
                    $query->where('bb.bk_re_te', '=', $terminal);
                    $query->where('bb.bk_status', '>', 0);
                });
            }
        }

        if($type == 'Departures'){ //drop arr  bk_ve_do_dt == bk_from_date
            $bookings = $bookings->whereBetween('bb.bk_from_date', array($start_date, $end_date));
            if(!empty($terminal)){
                //$bookings = $bookings->where('bb.bk_ou_te', '=', $terminal);
                //$bookings = $bookings->orWhere('bb.bk_re_te', '=',$terminal);
                $bookings = $bookings->where('bb.bk_re_te', '=', $terminal);
            }
        }
        if($type == 'Arrivals'){ //Arrivals bk_to_date == bk_ve_pu_dt
            $bookings = $bookings->whereBetween('bb.bk_to_date', array($start_date, $end_date));
            if(!empty($terminal)){
                //$bookings = $bookings->where('bb.bk_ou_te', '=', $terminal);
                //$bookings = $bookings->orWhere('bb.bk_re_te', '=',$terminal);
                $bookings = $bookings->where('bb.bk_ou_te', '=', $terminal);
            }
        }

        if(!empty($ref)){
            $bookings = $bookings->where('bb.bk_ref', '=', $ref);
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
        if($type == 'Arrivals') { //pick dep bk_to_date == bk_ve_pu_dt
            $bookings =  $bookings->orderByRaw('bk_to_date',  'DESC');
        }
        if($type == 'Departures') { //drop arr  bk_ve_do_dt == bk_from_date
            $bookings =  $bookings->orderByRaw('bk_from_date',  'DESC');
        }
        $bookings =  $bookings->get();
        return $bookings;
    }
    public function get_bookings($type, $ref, $terminal, $start_date, $end_date)
    {
        $bookings = DB::table('bookings as bb')
            ->join('countries as country', 'country.id', '=', 'bb.country_id')
            ->join('websites as ww', 'ww.id', '=', 'bb.website_id')
            ->join('terminals as t1', 't1.id', '=', 'bb.bk_ou_te')
            ->join('terminals as t2', 't2.id', '=', 'bb.bk_re_te')
            ->join('airports as aa', 'aa.id', '=', 'bb.airport_id')
            ->join('customers as cus', 'cus.id', '=', 'bb.customer_id')
            ->join('colors as clrr', 'clrr.clr_name', '=', 'bb.bk_ve_co')
            ->leftJoin('agents as agt', 'agt.id', '=', 'bb.agent_id')
            ->leftJoin('agents as fagt', 'fagt.id', '=', 'bb.fwd_agt_id')
            ->where('bb.bk_status', '>', 0)
            ->where('bb.bk_is_del', '=', 0);

        if ($type == 'All') {
            $bookings->where(function ($query) use ($start_date, $end_date) {
                $query->whereBetween('bb.bk_ve_do_dt', [$start_date, $end_date])
                    ->orWhereBetween('bb.bk_ve_pu_dt', [$start_date, $end_date]);
            });
            if (!empty($terminal)) {
                $bookings->where(function ($query) use ($terminal) {
                    $query->where('bb.bk_ou_te', $terminal)
                        ->orWhere('bb.bk_re_te', $terminal);
                });
            }
        } elseif ($type == 'Departures') {
            $bookings->whereBetween('bb.bk_from_date', [$start_date, $end_date]);
            if (!empty($terminal)) {
                $bookings->where('bb.bk_re_te', $terminal);
            }
        } elseif ($type == 'Arrivals') {
            $bookings->whereBetween('bb.bk_to_date', [$start_date, $end_date]);
            if (!empty($terminal)) {
                $bookings->where('bb.bk_ou_te', $terminal);
            }
        }

        if (!empty($ref)) {
            $bookings->where('bb.bk_ref', $ref);
        }

        $bookings->select(
            'bb.*',
            'bb.id as booking_id',
            DB::raw("DATE_FORMAT(bb.bk_date, '%Y-%m-%d') as bk_date"),
            DB::raw("DATE_FORMAT(bb.bk_from_date, '%d/%m/%Y %H:%i') as bk_from_date"),
            DB::raw("DATE_FORMAT(bb.bk_to_date, '%d/%m/%Y %H:%i') as bk_to_date"),
            DB::raw("DATE_FORMAT(bb.bk_ve_do_dt, '%d/%m/%Y %H:%i') as bk_ve_do_dt"),
            DB::raw("DATE_FORMAT(bb.bk_ve_pu_dt, '%d/%m/%Y %H:%i') as bk_ve_pu_dt"),
            'bb.bk_from_date as bk_from_dateh',
            'bb.bk_to_date as bk_to_dateh',
            'country.id as countryid',
            'country.name as countryname',
            'agt.id as agt1_id',
            'agt.agt_company as agt1_company',
            'fagt.id as fagt_id',
            'fagt.agt_company as fagt_company',
            'aa.id as selected_airport_id',
            'aa.airport_name',
            'aa.airport_directions',
            't1.airport_id as airport_id1',
            't1.id as ter_id1',
            't1.ter_name as ter_name1',
            't2.airport_id as airport_id2',
            't2.id as ter_id2',
            't2.ter_name as ter_name2',
            'cus.id as cus_id',
            'cus.*',
            'ww.*',
            'clrr.id as clrr_id',
            'clrr.clr_name'
        );

        if ($type == 'Arrivals') {
            $bookings->orderBy('bk_to_date', 'DESC');
        } elseif ($type == 'Departures') {
            $bookings->orderBy('bk_from_date', 'DESC');
        }

        return $bookings->get();
    }

}
