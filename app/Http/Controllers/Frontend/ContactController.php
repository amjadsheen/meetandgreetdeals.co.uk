<?php

namespace App\Http\Controllers\Frontend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Classes\Domain;
use App\Page;
use App\Services;
use Mail;
class ContactController extends Controller
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
        $page = Page::where('slug', 'contact-us')
            ->first();
        //dd($page);

        $page_title = 'Contact Us';
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

        return view($domain->website_templete.'.contact',compact('services','domain','page', 'page_title', 'meta_array'));
    }
    public function store(Request $request)
    {
        //dd($request);
        // dd($request);
        $request->validate([
            'full_name'=>'required',
            'email'=>'required|email',
            'subject'=>'required',
            'message'=>'required',
        ]);
        $from = $request->post('email');
        $full_name = $request->post('full_name');
        $subject = $request->post('subject');
        $msg = $request->post('message');
        $data = array(
            'full_name'=> $full_name,
            'email'=> $from,
            'subject'=> $subject,
            'msg'=> $msg
        );

        /*Mail::send('email.contactmail', $data, function($message) use ($from, $full_name, $subject) {
            $message->to('amjadalisheen@gmail.com', 'Link Airport Parking')->subject($subject);
            $message->from('moonparking1@gmail.com', 'Link Airport Parking contact form');
        });
        Mail::send('email.contactmail', $data, function($message) use ($from, $full_name, $subject) {
            $message->to('linkairportparking@hotmail.com', 'Link Airport Parking')->subject($subject);
            $message->from('moonparking1@gmail.com', 'Link Airport Parking contact form');
        });*/
       
        //return redirect('contact-us')->with('success', 'Thank You for your submission.');
        return redirect('contact-us')->with('success', 'Please Try Again');
    }
}
