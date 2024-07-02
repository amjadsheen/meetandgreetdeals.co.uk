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
class PaymentLinkController extends Controller
{
        /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
         $title = "Direct Payment Links";
        $counter = GlobalSettings::where('option_name', '=', 'counter')->value('option_value');
      if (empty($counter)){
          $counter = 1020;
      }
        $show_links = 0;
        return view('admin.paymentlink.index', compact( 'title', 'counter','show_links'));
    }

    public function store(Request $request)
    {

        $option_names =$request->get('option_name');
        $amount =$request->get('amount');
        $name =$request->get('p_name');
        //print_r($option_names);
        //die('sdfsdf');
        foreach ($option_names as $opt_name => $opt_value) {

            $exists = GlobalSettings::where('option_name', '=', $opt_name)->first();
            if ($exists === null) {
                $setting = GlobalSettings::firstOrNew(array('option_name' => $opt_name, 'option_value' => '1021'));
                $setting->save();
            } else {
                $setting = GlobalSettings::where('option_name', $opt_name)
                    ->select("id")
                    ->first();
                //dd($setting);
                GlobalSettings::where('id',$setting->id)->update(['option_value'=>$opt_value + 1]);

            }

        }
        $title = "Direct Payment Links";
        $counter = GlobalSettings::where('option_name', '=', 'counter')->value('option_value');
        $counter_count_link = 'dpl'.$counter;
        $paypal = "https://www.paypal.com/cgi-bin/webscr?currency_code=GBP&cmd=_xclick&business=extraenterprise@hotmail.com&amount=$amount&item_name=$name";
        $WP_P = "https://secure.worldpay.com/wcc/purchase?instId=1152063&cartId=$counter_count_link&currency=GBP&amount=$amount&desc=$name&testMode=0";
        $show_links = 1;
        return view('admin.paymentlink.index', compact( 'title', 'counter','paypal','WP_P','show_links','name','amount'));
    }
}
