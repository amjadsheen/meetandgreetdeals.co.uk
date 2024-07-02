<?php

namespace App\Http\Controllers\Frontend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Classes\Domain;
use App\Faq;
use App\Services;
class FaqController extends Controller
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
        $faqs = DB::table('faqs')
            ->where('disable', '=', 0)
            ->orderByRaw('sort ASC')
            ->get();
        $page_title = 'Faq';
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

        return view($domain->website_templete.'.faq',compact('services','domain','faqs', 'page_title', 'meta_array'));
    }
}
