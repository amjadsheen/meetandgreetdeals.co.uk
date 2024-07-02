<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use App\News;
use App\Website;
class NewsController extends Controller
{
        /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $title = "New Ticker";
        $websites = Website::all('id', 'website_name');
       // echo "<pre>";  print_r(array()$websites);echo "</pre>";
        foreach ($websites as $website){
            $websites_json[] = array('value'=>$website->id, 'text'=>$website->website_name);
        }
        $websites_json = json_encode($websites_json);


        foreach ($websites as $website) {
            $news[$website->website_name] = DB::table("news as news")
                ->leftJoin("websites as site", "site.id", "=", "news.website_id")
                ->where('news.website_ID', $website->id)
                ->select("news.*", "site.website_name")
                ->get();
        }

        return view('admin.news.index', compact('news', 'title', 'websites', 'websites_json'));
    }

    public function store(Request $request)
    {
       // dd($request);
        $request->validate([
            'news'=>'required',
            'website_id'=>'required',
          ]);

        $website = new News([
            'news'=> $request->get('news'),
            'website_id' => $request->get('website_id'),
          ]);
        $website->save();
          return redirect('/admin/news')->with('success', 'News Added');
    }

    public function updateinline(Request $request, $id)
    {
        $column_name = $request->name;
        $column_value = $request->value;
        if( $request->name && $request->value) {
            $update = News::select()
                ->where('id', '=', $id)
                ->update([$column_name => $column_value]);
            return response()->json([ 'code'=>200], 200);
        }

        return response()->json([ 'error'=> 400, 'message'=> 'Not enought params' ], 400);
    }

    public function delete($id){
        News::find($id)->delete($id);
        return response()->json([
            'success' => 'Record deleted successfully!',
            'id' => $id
        ]);
    }


}
