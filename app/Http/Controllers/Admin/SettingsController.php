<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use App\LastMinuteBookings;
use App\Settings;
use App\NotWorkingHours;
use App\Website;
class SettingsController extends Controller
{
        /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $title = "Setting";
        //$websites = DB::table('websites')->where('default_site', 0)->get();
        $websites = DB::table('websites')->get();
        $settings = Settings::all();
        $settings_array = [];
        $filter_website = $this->get_website_with_default_settings();
        if (request()->has('filter_website') && (!empty(request()->input('filter_website')))) {
            $filter_website = request()->input('filter_website');
        }
            
        $settings = DB::table("settings as ss")
            ->leftJoin("websites as ww", "ww.id", "=", "ss.website_id")
            ->where('ss.website_id', $filter_website)
            ->select("ss.*")
            ->get();
        
        if($settings->isEmpty()){ // copy default website
            $settings = $this->add_settings_for_website_new($filter_website);
        }

        $nwhrs = DB::table("not_working_hours as nhr")
            ->leftJoin("websites as ww", "ww.id", "=", "nhr.website_id")
            ->where('nhr.website_id', $filter_website)
            ->select("nhr.*")
            ->get();
            //print_r($nwhrs); exit;
        if($nwhrs->isEmpty()){ // copy default website
            $nwhrs = $this->add_nwhrs_for_website_new($filter_website);
        }
        $lmb = DB::table("last_minute_bookings as lmb")
        ->leftJoin("websites as ww", "ww.id", "=", "lmb.website_id")
        ->where('lmb.website_id', $filter_website)
        ->select("lmb.*")
        ->get();
        if($lmb->isEmpty()){ // copy default website
            $lmb = $this->add_lastmin_bookings($filter_website);
        }
        //dd($settings);

    
        foreach ($settings as $ss){
            //print_r($ss);
            $name = $ss->option_name;
            $settings_array[$name] = $ss->option_value;
        }
        return view('admin.settings.index', compact('filter_website','websites','settings_array','nwhrs', 'lmb','title'));
    }

    public function updateinline(Request $request, $id)
    {
        $column_name = $request->name;
        $column_value = $request->value;
        if( $request->name && $request->value) {
            $update = NotWorkingHours::select()
                ->where('id', '=', $id)
                ->update([$column_name => $column_value]);
            return response()->json([ 'code'=>200], 200);
        }
        return response()->json([ 'error'=> 400, 'message'=> 'Not enought params' ], 400);
    }

    public function updateinline_lastminutebookings(Request $request, $id)
    {
        $column_name = $request->name;
        $column_value = $request->value;
        if( $request->name && $request->value) {
            $update = LastMinuteBookings::select()
                ->where('id', '=', $id)
                ->update([$column_name => $column_value]);
            return response()->json([ 'code'=>200], 200);
        }
        return response()->json([ 'error'=> 400, 'message'=> 'Not enought params' ], 400);
    }

    public function store(Request $request)
    {
        $sss =$request->get('option_name');
        foreach ($sss as $website=>$items) {
            foreach ($items as $key => $item) {
                $exists = Settings::where('website_id', '=', $website)->where('option_name', '=', $key)->first();
                //echo "<pre>";print_r($exists);echo "<pre>";
                if ($exists === null) {
                    $setting = Settings::firstOrNew(array('website_id' => $website, 'option_name' => $key, 'option_value' => $item));
                    $setting->save();
                    //DB::table('settings')->insert(
                    //   ['website_id' => $website, 'option_name' => $key, 'option_value' => $item]
                    //);
                } else {
                    $setting = Settings::where('website_id', $website)
                        ->where('option_name', $key)
                        ->select("id")
                        ->first();
                    Settings::where('id',$setting->id)->update(['option_name'=>$key,'option_value'=>$item]);
                }

            }
        }
        //exit;
          return redirect('/admin/settings')->with('success', 'Setting Saved');
    }

    public  function add_settings_for_website_new($filter_website){
        
        $settings = DB::table("settings as ss")
            ->leftJoin("websites as ww", "ww.id", "=", "ss.website_id")
            ->where('ss.website_id', 1)
            ->select("ss.*")
            ->get();
        foreach ($settings as $ss){
            $setting = Settings::firstOrNew(array('website_id' => $filter_website, 'option_name' => $ss->option_name, 'option_value' => $ss->option_value));
            $setting->save();
        }

        return $settings = DB::table("settings as ss")
            ->leftJoin("websites as ww", "ww.id", "=", "ss.website_id")
            ->where('ss.website_id', $filter_website)
            ->select("ss.*")
            ->get();
    }

    public  function add_nwhrs_for_website_new($filter_website){
        
        $nhrs = DB::table("not_working_hours as nhr")
            ->leftJoin("websites as ww", "ww.id", "=", "nhr.website_id")
            ->where('nhr.website_id', 1)
            ->select("nhr.*")
            ->get();
        foreach ($nhrs as $ss){
            $newnhrs = NotWorkingHours::firstOrNew(array('website_id' => $filter_website, 'not_working_start_time' => $ss->not_working_start_time, 'not_working_end_time' => $ss->not_working_end_time, 'charges' => $ss->charges));
            $newnhrs->save();
        }

        return $nhrs = DB::table("not_working_hours as nhr")
            ->leftJoin("websites as ww", "ww.id", "=", "nhr.website_id")
            ->where('nhr.website_id', $filter_website)
            ->select("nhr.*")
            ->get();
    }
    public  function add_lastmin_bookings($filter_website){
        
        $nhrs = DB::table("last_minute_bookings as nhr")
            ->leftJoin("websites as ww", "ww.id", "=", "nhr.website_id")
            ->where('nhr.website_id', 1)
            ->select("nhr.*")
            ->get();
        foreach ($nhrs as $ss){
            $newnhrs = LastMinuteBookings::firstOrNew(array('website_id' => $filter_website, 'hour' => $ss->hour,  'charges' => $ss->charges));
            $newnhrs->save();
        }

        return $nhrs = DB::table("not_working_hours as nhr")
            ->leftJoin("websites as ww", "ww.id", "=", "nhr.website_id")
            ->where('nhr.website_id', $filter_website)
            ->select("nhr.*")
            ->get();
    }

    public function get_website_with_default_settings(){
        $default_website = Website::where('default_site', 0)->first();
            $default = $default_website->id;
            return $default;
    }
}
