<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use App\GlobalSettings;
class GlobalSettingsController extends Controller
{
        /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $title = "Email Setting";
        $settings = GlobalSettings::all();
        $settings_array = array();
        foreach ($settings as $ss){
            $name = $ss->option_name;
            $settings_array[$name] = $ss->option_value;
        }
        //dd($settings_array);
        return view('admin.globalsettings.index', compact('settings_array', 'title'));
    }

    public function store(Request $request)
    {
        $option_names =$request->get('option_name');
            echo "<pre>"; print_r($option_names); echo "</pre>";
            foreach ($option_names as $opt_name => $opt_value) {

                $exists = GlobalSettings::where('option_name', '=', $opt_name)->first();
                if ($exists === null) {
                    $setting = GlobalSettings::firstOrNew(array('option_name' => $opt_name, 'option_value' => $opt_value));
                    $setting->save();
                } else {
                    $setting = GlobalSettings::where('option_name', $opt_name)
                        ->select("id")
                        ->first();
                    //dd($setting);
                    GlobalSettings::where('id',$setting->id)->update(['option_value'=>$opt_value]);
                    $update = GlobalSettings::select()
                        ->where('id', '=', $setting->id)
                        ->update(['option_value' => $opt_value]);
                }

            }
        //exit;
          return redirect('/admin/globalsettings')->with('success', 'Email Setting Saved');
    }
}
