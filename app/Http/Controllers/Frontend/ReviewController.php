<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Classes\Domain;
use App\Reviews;
class ReviewController extends Controller
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
           // ->where('disable', '=', 0)
            ->orderByRaw('sort ASC')
            ->get();
        /* ======= Service ======= */
        /* ======= reviews ======= */
        $reviews = DB::table('reviews')
            ->where('disable', '=', 0)
            ->where('website_id', '=', $domain->id)
            ->orderByRaw('id DESC')
            ->get();
        /* ======= reviews ======= */
        $page_title = 'Reviews';
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
        return view($domain->website_templete.'.review',compact('page_title','reviews','domain','services', 'meta_array'));
    }

    public function ajaxRequestPost(Request $request)
    {
       // dd($request);

        $request->validate([
            'fname'=>'required',
            'surname'=>'required',
            'email'=>'required',
            'rate'=>'required',
            'review'=>'required',

        ]);
        $airport = new Reviews([
            'website_id'=> $request->get('website_id'),
            'fname' => $request->get('fname'),
            'surname' => $request->get('surname'),
            'email' => $request->get('email'),
            'mobile' => $request->get('mobile'),
            'booking_refrence' => $request->get('booking_refrence'),
            'rate' => $request->get('rate'),
            'review' => $request->get('review'),
            'review_date' => date('y-m-d H:i:s'),
            'post_title'=> $request->get('fname') .' '. date('y-m-d H:i:s')
        ]);
        $airport->save();

        return response()->json(['success'=>'Thank you. Your feedback was sent perfectly.']);
    }
}
