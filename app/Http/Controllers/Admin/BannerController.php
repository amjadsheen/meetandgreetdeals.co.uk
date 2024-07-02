<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use App\Banner;
use App\Website;
class BannerController extends Controller
{
        /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $title = "Banners";
       // $banners = Banner::all();
        $websites = Website::all('id', 'website_name');
       // echo "<pre>";  print_r(array()$websites);echo "</pre>";
        foreach ($websites as $website){
            $websites_json[] = array('value'=>$website->id, 'text'=>$website->website_name);
        }
        $websites_json = json_encode($websites_json);


        foreach ($websites as $website) {
            $banners[$website->website_name] = DB::table("banners as banner")
                ->leftJoin("websites as site", "site.id", "=", "banner.website_id")
                ->where('banner.website_ID', $website->id)
                ->select("banner.*", "site.website_name")
                ->orderByRaw('sort',  'ASC')
                ->get();
        }
        //echo"<pre>";print_r($banners);echo"</pre>";exit;

        return view('admin.banner.index', compact('banners', 'title', 'websites', 'websites_json'));
    }

    public function store(Request $request)
    {
       // dd($request);
        $request->validate([
            'tag'=>'required',
           'website_id'=>'required',
            'price'=>'required',
          ]);

        $cover = $request->file('image');
       /* $extension = $cover->getClientOriginalExtension();
        Storage::disk('public')->put($cover->getFilename().'.'.$extension,  File::get($cover));*/

        if(!empty($cover)) {
            /*$extension = $cover->getClientOriginalExtension();
            Storage::disk('public')->put($cover->getFilename() . '.' . $extension, File::get($cover));*/

            $filenameWithExt = $request->file('image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            $cover_image = $fileNameToStore;
            $request->file('image')->storeAs('public/uploads', $fileNameToStore);
           // Domain::copy_images_to_public($fileNameToStore);
        }

        $banner = new Banner([
            'tag'=> $request->get('tag'),
            'website_id' => $request->get('website_id'),
            'image' => $cover_image,
            'price' => $request->get('price')
          ]);
          $banner->save();
          return redirect('/admin/banner')->with('success', 'banner Added');
    }

    public function updateinline(Request $request, $id)
    {
        //$test = Banner::find($id);
        $column_name = $request->name;
        $column_value = $request->value;
        if( $request->name && $request->value) {
            $update = Banner::select()
                ->where('id', '=', $id)
                ->update([$column_name => $column_value]);
            return response()->json([ 'code'=>200], 200);
        }

        return response()->json([ 'error'=> 400, 'message'=> 'Not enought params' ], 400);
    }

    public function delete($id){
        Banner::find($id)->delete($id);
        return response()->json([
            'success' => 'Record deleted successfully!',
            'id' => $id
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $banner = Banner::where('id', $id)
            ->first();
        $websites = Website::all('id', 'website_name');
        return view('admin.banner.edit', compact('banner', 'id','websites'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //dd($request);
        $request->validate([
            'tag'=>'required',
            'website_id'=> 'required',
            'price'=> 'required',
        ]);

        $cover = $request->file('image');
        if(!empty($cover)) {
            /*$extension = $cover->getClientOriginalExtension();
            Storage::disk('public')->put($cover->getFilename() . '.' . $extension, File::get($cover));*/

            $filenameWithExt = $request->file('image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            $cover_image = $fileNameToStore;
            $request->file('image')->storeAs('public/uploads', $fileNameToStore);
            //Domain::copy_images_to_public($fileNameToStore);
        }
        $banner = Banner::find($id);
        $banner->tag = $request->get('tag');
        $banner->website_id = $request->get('website_id');
        $banner->price = $request->get('price');
        if(!empty($cover)) {
            $banner->image = $cover_image;
        }
        $banner->save();

        return redirect('/admin/banner')->with('success', 'Banner has been updated');

    }

    public function autogenerate()
    {
        $c=0;
        $websites = Website::all('id', 'website_name');
        $days_Array = array('Day 1'=> 'day-1.png','Day 2'=> 'day-2.png','Day 3'=> 'day-3.png','Day 4'=> 'day-4.png','Day 5'=> 'day-5.png','Day 6'=> 'day-6.png','Day 7'=> 'day-7.png','Day 8'=> 'day-8.png');
        $price_Array = array('Day 1'=> 40, 'Day 2'=>43, 'Day 3'=> 46, 'Day 4'=> 49, 'Day 5'=> 52, 'Day 6'=> 55, 'Day 7'=>58, 'Day 8'=>61 );
        foreach ($websites as $website){
            foreach ($days_Array as $day=>$image){
               if(!Banner::where('tag', $day)->where('website_id', $website->id)->exists()){
                   $banner = new Banner([
                       'tag'=> $day,
                       'website_id' =>$website->id,
                       'image' => $image,
                       'price' => $price_Array[$day],
                       'sort'=>$c,
                       'disable'=>0
                   ]);
                   $banner->save();
                   $c++;
               }
            }

        }
        if($c > 0){
            return redirect('/admin/banner')->with('success', ''.$c.' Banners Generated.');
        }else{
            return redirect('/admin/banner')->with('success', 'Banner Exists for All Sites.');
        }

    }

}
