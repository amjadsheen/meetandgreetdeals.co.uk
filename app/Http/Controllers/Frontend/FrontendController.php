<?php

namespace App\Http\Controllers\Frontend;

use App\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Classes\Domain;
use App\Services;
use App\PromotionOffer;
use App\Settings;
use App\Page;

class FrontendController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $domain =  env('APP_URL');
        $domain = Domain::get_domain_id(1);

        /* ======= Service ======= */
        $countries = DB::table('countries')
            //->orderByRaw('sort ASC')
            ->get();
        /* ======= Service ======= */

        $terminal_access_options = array(
            // 'N' => 'Pay Yourself Terminal Access fee ( Drop of Chargers) upon Departure and Arrival.',
            'P' => 'Add Now (Departure & Arrival 25 mins Only)',
            'N' => 'Customer are responsible to pay Terminal fee upon Departure and Arrival(Not Added)',

        );
        $vehical_selction = array(
            // 'N' => 'Pay Yourself Terminal Access fee ( Drop of Chargers) upon Departure and Arrival.',
            '1' => '1',
            '2' => '2',
            '3' => '3',
            '4' => '4',
            '5' => '5',

        );

        /* ======= Service ======= */
        $services = DB::table('services')
            //->where('disable', '=', 0)
            ->orderByRaw('sort ASC')
            ->get();
        /* ======= Service ======= */
        /* ======= News ======= */
        $news = DB::table('news')
            ->where('disable', '=', 0)
            ->where('website_id', '=', $domain->id)
            ->orderByRaw('sort ASC')
            ->get();
        /* ======= News ======= */

        /* ======= Banners ======= */
        $banners = DB::table('banners')
            ->where('disable', '=', 0)
            ->where('website_id', '=', $domain->id)
            ->orderByRaw('sort ASC')
            ->get();
        /* ======= Banners ======= */


        /* ======= Banners ======= */
        $partners = DB::table('websites')
            ->where('disable', '=', 0)
            ->where('show_homepage', '=', 1)
            ->orderByRaw('id ASC')
            ->get();
        /* ======= Banners ======= */

        /* ======= Banners ======= */
        $directions = DB::table('directions')
            ->where('disable', '=', 0)
            ->orderByRaw('sort ASC')
            ->limit(4)
            ->get();
        /* ======= Banners ======= */

        /* ======= Home PromotionOffer ======= */
        $dt = date('Y-m-d');
        $homepromo = PromotionOffer::select('offer_coupon', 'offer_percentage')
            ->where('offer_home', '=', 1)
            ->where('offer_active', '=', 1)
            ->where('website_id', $domain->id)
            ->where('offer_date1', '<=', $dt)
            ->where('offer_date2', '>=', $dt)
            ->first();
        /* ======= Home PromotionOffer ======= */

        /* ======= reviews ======= */
        $reviews = DB::table('reviews')
            ->where('disable', '=', 0)
            ->where('rate', '>', 1)
            ->where('website_id', '=', $domain->id)
            ->orderByRaw('id DESC')
            ->limit(5)
            ->get();
        /* ======= reviews ======= */

        /* ======= airport ======= */
        $airports = DB::table('airports')
            ->select('id', 'airport_name', 'airport_disable')
            ->where('airport_disable', '=', 0)
            ->get();
        /* ======= airport ======= */

        /* ======= currencies ======= */
        $currencies = DB::table('currencies')
            ->select('id', 'cur_name', 'cur_code', 'cur_symbol', 'cur_rate')
            ->where('cur_disable', '=', 0)
            ->get();
        /* ======= currencies ======= */



        /* ======= whyus ======= */
        $whyus = Page::where('slug', 'why-us')
            ->first();
        /* ======= /whyus ======= */

        /* ======= Settings ======= */
        $settings = $this->get_website_settings(1);

        /* ======= Settings ======= */
        if (request()->has('redirect') && (!empty(request()->input('redirect')))) {
            $redirect = request()->input('redirect');
        } else {
            $redirect = "booking";
        }
        //dd($redirect);
        $booking_edit = 0;

        $page_title = 'Home';
        $meta_array = array(
            'title' =>  strtolower($domain->website_meta_title),
            'description' => strtolower($domain->website_meta_description),
            'keywords' => strtolower($domain->website_meta_keywords),
            'og:locale' => 'en_US',
            'og:type' => 'website',
            'og:title' =>  strtolower($domain->website_meta_title),
            'og:url' =>  strtolower($domain->website_ur),
            'twitter:card' =>  strtolower($domain->website_meta_title),
            'twitter:description' => strtolower($domain->website_meta_description),
            'twitter:title' => strtolower($domain->website_meta_title),

        );
        if (isset($_COOKIE["bk_id"])) {
            // dd($settings);
            //$bk_id_c = $_COOKIE["bk_id"];
            $bk_id_c = Domain::get_booking_id($_COOKIE["bk_id"]);
            $booking_exists = Booking::find($bk_id_c);
            if ($booking_exists) {
                $bk_details = DB::table("bookings as bb")
                    ->join("terminals as tt", "tt.id", "=", "bb.bk_ou_te")
                    ->join("currencies as cc", "cc.id", "=", "bb.currency_id")
                    ->join("airports as aa", "aa.id", "=", "bb.airport_id")
                    ->join("services as ss", "ss.id", "=", "bb.service_id")
                    ->where('bb.id', '=', $bk_id_c)
                    ->select("bb.*", DB::raw("DATE_FORMAT(bb.bk_from_date, '%d/%m/%Y - %H:%i') as bk_from_date"), DB::raw("DATE_FORMAT(bb.bk_to_date, '%d/%m/%Y - %H:%i') as bk_to_date"), "aa.airport_name", "aa.airport_directions", "tt.ter_name", "cc.cur_symbol", "ss.service_name")
                    ->first();
                $booking_edit = 1;

                /* ======= selected airport ======= */
                $selected_airport = DB::table('airports')
                    ->select('id', 'airport_name', 'airport_disable')
                    ->where('country_id', '=', $bk_details->country_id)
                    ->get();
                /* ======= selected airport ======= */

                /* ======= selected terminals ======= */
                $selected_terminals = DB::table('terminals')
                    ->where('airport_id', '=', $bk_details->airport_id)
                    ->get();
                //dd($selected_terminals);
                /* ======= selected terminals ======= */
                //dd($domain->website_templete);
                return view($domain->website_templete . '.home', compact('page_title', 'meta_array', 'redirect', 'countries', 'services', 'domain', 'news', 'banners', 'homepromo', 'reviews', 'airports', 'currencies', 'settings', 'booking_edit', 'bk_details', 'selected_airport', 'selected_terminals', 'directions', 'terminal_access_options', 'vehical_selction', 'whyus', 'partners'));
            }else{
                return view($domain->website_templete . '.home', compact('page_title', 'meta_array', 'redirect', 'countries', 'services', 'domain', 'news', 'banners', 'homepromo', 'reviews', 'airports', 'currencies', 'settings', 'booking_edit', 'directions', 'terminal_access_options', 'vehical_selction', 'whyus', 'partners'));
            }
        } else {
            return view($domain->website_templete . '.home', compact('page_title', 'meta_array', 'redirect', 'countries', 'services', 'domain', 'news', 'banners', 'homepromo', 'reviews', 'airports', 'currencies', 'settings', 'booking_edit', 'directions', 'terminal_access_options', 'vehical_selction', 'whyus', 'partners'));
        }
    }

    public  function get_website_settings($id)
    {
        /*$settings_s = Settings::all();
        foreach ($settings_s as $ss){
            $name = $ss->option_name;
            $settings[$name] = $ss->option_value;
        }*/
        $settings_s = DB::table("settings as ss")
            ->leftJoin("websites as ww", "ww.id", "=", "ss.website_id")
            ->where('ss.website_id', $id)
            ->select("ss.*")
            ->get();
        if ($settings_s->isEmpty()) {
            $settings_s = DB::table("settings as ss")
                ->leftJoin("websites as ww", "ww.id", "=", "ss.website_id")
                ->where('ss.website_id', 1)
                ->select("ss.*")
                ->get();
        }

        foreach ($settings_s as $ss) {
            $name = $ss->option_name;
            $settings[$name] = $ss->option_value;
        }

        return $settings;
    }
}
