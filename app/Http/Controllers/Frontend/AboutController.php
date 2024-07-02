<?php

namespace App\Http\Controllers\Frontend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Classes\Domain;
use App\Page;
use App\Services;
class AboutController extends Controller
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
        $services = DB::table('services')
            //->where('disable', '=', 0)
            ->orderByRaw('sort ASC')
            ->get();
        /* ======= Service ======= */

        $page = Page::where('slug', 'about-us')->first();
        $page_title = 'About Us';
        $meta_array = array(
            'title'=>  strtolower($page_title),
            'description'=> strtolower($page_title),
            'keywords'=>strtolower($page_title),
            'og:locale'=> 'en_US',
            'og:type'=> 'website',
            'og:title'=>  strtolower($page_title),
            'og:url'=>  strtolower($page_title),
            'twitter:card'=>  strtolower($page_title),
            'twitter:description' => strtolower($page_title),
            'twitter:title' => strtolower($page_title),

        );

        return view($domain->website_templete.'.about',compact('services','domain','page', 'page_title','meta_array' ));
    }
    public function paylater()
    {
        $domain =  env('APP_URL');
        $domain = Domain::get_domain_id(1);

        /* ======= Service ======= */
        $services = DB::table('services')
            ->where('disable', '=', 0)
            ->orderByRaw('sort ASC')
            ->get();
        /* ======= Service ======= */

        $page = Page::where('slug', 'pay-later')
            ->first();

         $page_title = 'Pay Later';
        $meta_array = array(
            'title'=>  strtolower($page_title),
            'description'=> strtolower($page_title),
            'keywords'=>strtolower($page_title),
            'og:locale'=> 'en_US',
            'og:type'=> 'website',
            'og:title'=>  strtolower($page_title),
            'og:url'=>  strtolower($page_title),
            'twitter:card'=>  strtolower($page_title),
            'twitter:description' => strtolower($page_title),
            'twitter:title' => strtolower($page_title),

        );

        return view($domain->website_templete.'.paylater',compact('services','domain','page', 'page_title', 'meta_array'));
    }
}
