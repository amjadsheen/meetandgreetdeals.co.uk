<?php

namespace App\Http\Controllers\Frontend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Classes\Domain;
use App\Direction;
use App\Services;
class DirectionsDetailController extends Controller
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
        $direction = Direction::where('id', $slug)
            ->orWhere('slug', $slug)
            ->firstOrFail();
        
        $page_title = $direction->title;
        $meta_array = array(
            'title'=>  strtolower($direction->meta_title),
            'description'=> strtolower($direction->meta_description),
            'keywords'=>strtolower($direction->meta_keywords),
            'og:locale'=> 'en_US',
            'og:type'=> 'website',
            'og:title'=>  strtolower($direction->meta_title),
            'og:url'=>  $domain->website_url .'/directions/'.$direction->slug,
            'twitter:card'=>  'summary',
            'twitter:description' => strtolower($direction->meta_description),
            'twitter:title' => strtolower($direction->meta_title),

        );
        return view($domain->website_templete.'.directions-detail',compact('page_title', 'meta_array', 'services','domain','direction'));
    }
}
