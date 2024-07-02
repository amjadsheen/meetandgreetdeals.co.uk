<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use App\Drivers;
class DriversController extends Controller
{
        /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $title = "Driver";
        $drivers = Drivers::all();
        return view('admin.drivers.index', compact('drivers','title'));
    }

    public function store(Request $request)
    {
       // dd($request);
        $request->validate([
            'drv_username'=>'required'
          ]);
        $drv_photo= $request->file('drv_photo');
        if(!empty($drv_photo)) {
            /*$extension = $drv_photo->getClientOriginalExtension();
            Storage::disk('public')->put($drv_photo->getFilename() . '.' . $extension, File::get($drv_photo));
            $drv_photo_url =  $drv_photo->getFilename().'.'.$extension;*/

            $filenameWithExt = $request->file('drv_photo')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('drv_photo')->getClientOriginalExtension();
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            $drv_photo_url = $fileNameToStore;
            $request->file('drv_licensephoto')->storeAs('public/uploads', $fileNameToStore);

        }else{
            $drv_photo_url = "direction_temp_image";
        }

        $drv_licensephoto = $request->file('drv_licensephoto');
        if(!empty($drv_licensephoto)) {
            /*$extension = $drv_licensephoto->getClientOriginalExtension();
            Storage::disk('public')->put($drv_licensephoto->getFilename() . '.' . $extension, File::get($drv_licensephoto));
            $drv_licensephoto_image_url =  $drv_licensephoto->getFilename().'.'.$extension;*/

            $filenameWithExt = $request->file('drv_licensephoto')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('drv_licensephoto')->getClientOriginalExtension();
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            $drv_licensephoto_image_url = $fileNameToStore;
            $request->file('drv_licensephoto')->storeAs('public/uploads', $fileNameToStore);
            //Domain::copy_images_to_public($fileNameToStore);
        }else{
            $drv_licensephoto_image_url = "direction_temp_image";
        }


        $drv_username = $request->get('drv_username');
        if(!Drivers::where('drv_username', $drv_username)->exists()) {
            $driver = new Drivers([
                'drv_username' => $request->get('drv_username'),
                'drv_password' => $request->get('drv_password'),
                'drv_licensephoto' => $drv_licensephoto_image_url,
                'drv_photo' => $drv_photo_url,
            ]);
            $driver->save();
            return redirect('/admin/drivers')->with('success', 'Driver Added');
        }else{
            return redirect('/admin/drivers')->with('warning', ''.$drv_username.' Driver Already Exists..');
        }


    }

    public function updateinline(Request $request, $id)
    {
        $column_name = $request->name;
        $column_value = $request->value;
        if( $request->name && $request->value) {
            $update = Drivers::select()
                ->where('id', '=', $id)
                ->update([$column_name => $column_value]);
            return response()->json([ 'code'=>200], 200);
        }

        return response()->json([ 'error'=> 400, 'message'=> 'Not enought params' ], 400);
    }

    public function delete($id){


        /*$qry = "SELECT cin_id FROM wp_booking_checkins where drv_id = $id";
        $checkins = $wpdb->get_results($qry);
        $checkinsc = $wpdb->num_rows;

        $qry = "SELECT mov_id FROM wp_booking_movements where drv_id= $id";
        $moves = $wpdb->get_results($qry);
        $movesc = $wpdb->num_rows;

        $qry = "SELECT cot_id FROM wp_booking_checkouts where drv_id= $id";
        $checkouts = $wpdb->get_results($qry);
        $checkoutsc = $wpdb->num_rows;

        if ($checkinsc == 0 and $movesc == 0 and $checkoutsc == 0){ // no record found in any table
            $qry = "DELETE FROM wp_booking_drivers WHERE drv_id = $id";
            $wpdb->query($qry);
            echo "0";
        }
        */
        $checkinsc = DB::table('checkins')
            ->select('id')
            ->where('driver_id', $id)
            ->count();

        $movesc = DB::table('movements')
            ->select('id')
            ->where('driver_id', $id)
            ->count();

        $checkoutsc = DB::table('checkouts')
            ->select('id')
            ->where('driver_id', $id)
            ->count();


        if ($checkinsc > 0 || $movesc > 0 || $checkoutsc > 0) { //IF movements EXIST DON'T DELETE.
            return response()->json([
                'error' => 1,
                'msg' => 'Can not delete this Record movements EXIST!',
                'id' => $id
            ]);
        }else{
            Drivers::find($id)->delete($id);
            return response()->json([
                'success' => 'Record deleted successfully!',
                'id' => $id
            ]);
        }

    }

    public function create  (){
        $title = "Driver";
        return view('admin.drivers.create', compact('title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $driver = Drivers::where('id', $id)
            ->first();

        return view('admin.drivers.edit', compact('driver', 'id'));
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
            'title'=>'required'
        ]);


        $driver = Drivers::find($id);

        $driver->title = $request->get('title');
        $driver->content = $request->get('content');
        $driver->content_left = $request->get('content_left');
        $driver->content_right = $request->get('content_right');
        $driver->slug = $request->get('slug');
        $driver->meta_title = $request->get('meta_title');
        $driver->meta_description = $request->get('meta_description');
        $driver->meta_keywords = $request->get('meta_keywords');
        $driver->save();

        return redirect('/admin/drivers')->with('success', 'driver Updated...');

    }
}
