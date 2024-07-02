<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Terminal;
use App\Airport;
use App\FixedPrices;
use App\Website;
use App\Services;
use App\Country;
class FixedPricesController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        $title = "Booking Edit Fixed Pricing";
        $airports = Airport::all();
        $countries = Country::all();
        $websites = Website::all();
        $terminal = Terminal::all();
        $allterminal = Terminal::all();
        $services = Services::all();
        foreach ($airports as $airport) {
            $terminals[$airport->id] = DB::table('terminals')->where('airport_id', '=', $airport->id)->get();
        }

        $filter_website = '';
        foreach ($websites as $website) {
            foreach ($airports as $airport) {
                foreach ($terminal as $ter) {
                        $Prices[$website->id][$airport->id][$ter->id] = DB::table("fixed_prices as pp")
                            ->join("terminals as tt", "tt.id", "=", "pp.terminal_id")
                            ->join("airports as aa", "aa.id", "=", "tt.airport_id")
                            ->join("websites as site", "site.id", "=", "pp.website_id")
                            ->join("services as ss", "ss.id", "=", "pp.service_id")
                            ->where('tt.airport_id', $airport->id)
                            ->where('pp.terminal_id', $ter->id)
                            ->where('pp.website_id', $website->id)
                            ->select("pp.*", "tt.ter_name", "tt.airport_id", "site.id as site_id", "site.website_name", "ss.service_name")
                            ->orderBy('pp.service_id', 'asc')
                            ->get();
                }
            }
        }
        //dd($Prices);
        return view('admin.fixed-prices.fixed-prices', compact('Prices', 'title', 'websites', 'airports', 'terminals', 'countries', 'services', 'filter_website'));
    }


    public function updateinline(Request $request, $id)
    {

        $column_name = $request->name;
        $column_value = $request->value;
        if ($request->name && $request->value) {
            $update = FixedPrices::select()
                ->where('id', '=', $id)
                ->update([$column_name => $column_value]);
            return response()->json(['code' => 200], 200);
        }

        return response()->json(['error' => 400, 'message' => 'Not enought params'], 400);
    }

    public function autogenerate()
    {
        $websites = Website::all();
        $services = Services::all();
        $terminals = Terminal::all();
        $c=0;
        foreach ($websites as $website) {
            foreach ($terminals as $terminal) {
                foreach ($services as $service) {
                    $found = FixedPrices::where('website_id', '=', $website->id)
                        ->where('terminal_id', '=', $terminal->id)
                        ->where('service_id', '=', $service->id)
                        ->groupBy('website_id', 'terminal_id', 'service_id')
                        ->exists();
                    if ($found) {
                        echo "FFOUND::".$website->id . "===== " . $terminal->id . " ===== " . $service->id . "<hr>";
                    } else {
                        echo "NOT-FOUND::".$website->id . "===== " . $terminal->id . " ===== " . $service->id . "<hr>";
                        $New_Entry = new FixedPrices([
                            'terminal_id'=> $terminal->id,
                            'service_id' =>$service->id,
                            'website_id' => $website->id,
                        ]);
                        $New_Entry->save();
                    }
                }
                }
            }
            if($c > 0){
             return redirect('/admin/booking-edit-fix-prices')->with('success', ''.$c.'  Missing Fixed Prices Generated.');
            }else{
             return redirect('/admin/booking-edit-fix-prices')->with('success', 'Booking Fixed Prices Already Exists for All Sites, Terminals and Services.');
            }
        }

        public function autogeneratefixedprices(Request $request){
            $website = $request->post('website');
            $terminal = $request->post('terminal');
            $start_day = $request->post('start_day');
            $fixed_price = $request->post('fixed_price');
            $service = $request->post('service');
            $c=0;
            if(!empty($website) && !empty($terminal) && !empty($start_day) && !empty($fixed_price) && !empty($service)) {
                for ($days = $start_day; $days <= 30; $days++) {
                    $daaay = "cal_d" . $days;
                    DB::table('fixed_prices')
                        ->where('website_id', $website)
                        ->where('terminal_id', $terminal)
                        ->where('service_id', $service)
                        ->update(array($daaay => $fixed_price));
                    $c++;
                }
            }


            if($c > 0){
                return redirect('/admin/booking-edit-fix-prices')->with('success', ''.$c.'  Updated.');
            }else{
                return redirect('/admin/booking-edit-fix-prices')->with('success', 'Not Updated... Please Recheck Your Options');
            }
        }





}
