<?php

namespace App\Http\Controllers\Frontend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Classes\Domain;
use App\Services;
class ServicesDetailController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($slug)
    {
        $domain =  env('APP_URL');
        $domain = Domain::get_domain_id(1);
        /* ======= Service ======= */
        $services = DB::table('services')
            //->where('disable', '=', 0)
            ->orderByRaw('sort ASC')
            ->get();
        /* ======= Service ======= */
        $service_single = Services::where('id', $slug)
            ->orWhere('slug', $slug)
            ->firstOrFail();
        //dd($service_single);

        
        $page_title = $service_single->service_name;
        $meta_array = array(
            'title'=>  strtolower($service_single->meta_title),
            'description'=> strtolower($service_single->meta_description),
            'keywords'=>strtolower($service_single->meta_keywords),
            'og:locale'=> 'en_US',
            'og:type'=> 'website',
            'og:title'=>  strtolower($service_single->meta_title),
            'og:url'=>  $domain->website_url .'/services/'.$service_single->slug,
            'twitter:card'=>  'summary',
            'twitter:description' => strtolower($service_single->meta_description),
            'twitter:title' => strtolower($service_single->meta_title),

        );
        return view($domain->website_templete.'.services-detail',compact('page_title', 'meta_array', 'services','domain','service_single'));
    }
}
