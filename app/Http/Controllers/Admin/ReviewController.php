<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Reviews;
use App\Website;
class ReviewController extends Controller
{
        /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $title = "Reviews";
        $websites = Website::all('id', 'website_name');
        // echo "<pre>";  print_r(array()$websites);echo "</pre>";
        foreach ($websites as $website){
            $websites_json[] = array('value'=>$website->id, 'text'=>$website->website_name);
        }
        $websites_json = json_encode($websites_json);


        foreach ($websites as $website) {
            $reviews[$website->website_name] = DB::table("reviews as review")
                ->leftJoin("websites as site", "site.id", "=", "review.website_id")
                ->where('review.website_id', $website->id)
                ->select("review.*", "site.website_name")
                ->orderByRaw('id DESC')
                ->get();
        }
        //dd($reviews);
        return view('admin.review.review', compact('reviews', 'title', 'websites', 'websites_json'));

    }

    public function store(Request $request)
    {
        $request->validate([
            'fname'=>'required',
            'surname'=>'required',
            'email'=>'required',
            'rate'=>'required',
            'review'=>'required',
          ]);
          $airport = new Faq([
            'site_id'=> $request->get('site_id'),
             'fname' => $request->get('fname'),
              'surname' => $request->get('email'),
              'email' => $request->get('email'),
              'mobile' => $request->get('mobile'),
              'booking_refrence' => $request->get('booking_refrence'),
              'rate' => $request->get('rate'),
              'review' => $request->get('review'),
              'review_date' => date('y-m-d H:i:s'),
              'post_title'=> $request->get('fname') .' '. date('y-m-d H:i:s')
          ]);
          $airport->save();
          return redirect('/admin/faqs')->with('success', 'Review Added');
    }

    public function updateinline(Request $request, $id)
    {
        //$test = Faq::find($id);
        $column_name = $request->name;
        $column_value = $request->value;
        if( $request->name && $request->value) {
            $update = Reviews::select()
                ->where('id', '=', $id)
                ->update([$column_name => $column_value]);
            return response()->json([ 'code'=>200], 200);
        }

        return response()->json([ 'error'=> 400, 'message'=> 'Not enought params' ], 400);
    }

    public function delete($id){
        Reviews::find($id)->delete($id);
        return response()->json([
            'success' => 'Record deleted successfully!',
            'id' => $id
        ]);
    }
    public function import(){
        $filename = storage_path('/app/re/re.csv');
        $rows   = array_map('str_getcsv', file($filename));
        $header = array_shift($rows);
        $csv    = array();
        foreach($rows as $row) {
            $csv[] = array_combine($header, $row);
        }
        echo "<pre>";print_r($csv); echo "</pre>";
        $website = 1;
        foreach($csv as $rrr) {
            foreach($rrr as $key=>$r) {
                if($key == 'post_date'){
                    $r = date('Y-m-d H:i:s', strtotime($r));

                }
               if(!Reviews::where('post_title', $rrr['post_title'])->exists()){
                    $review = new Reviews([
                        'website_id' => $website,
                        'post_title' => $rrr['post_title'],
                        'fname' =>  $rrr['wpcr3_review_name'],
                        'surname' =>  $rrr['wpcr3_f1'],
                        'email'=> $rrr['wpcr3_review_email'],
                        'rate'=> $rrr['wpcr3_review_rating'],
                        'review'=> $rrr['post_content'],
                        'review_date'=> $r,
                    ]);
                   $review->save();
                }
            }
        }
        exit;

    }
}
