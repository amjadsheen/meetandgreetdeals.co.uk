<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\VehicalType;
use App\CarWash;
use App\Website;
class CarWashController extends Controller
{
        /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
            //dd("CarWash Disabled");
        $title = "CarWash";

        $vehicaltype = VehicalType::all();
        $websites = Website::all();
        $wash_types = array(
            'carwash_in_and_out' => 'FULL CAR WASH (IN AND OUT)',
            'carwash_out_only'=>'CAR WASH (ONLY OUTSIDE)',
            'carwash_in_only'=>'CAR WASH (ONLY INSIDE)',
            'carwash_spray_only'=>'CAR WASH (WATER SPRAY ONLY)'
        );


        if (request()->has('filter_website') && (!empty(request()->input('filter_website')))) {
            $filter_website = request()->input('filter_website');
        }else{
            $filter_website = 1;

        }

        foreach ($vehicaltype as $veh){
            $carwash[$veh->v_name] = DB::table("car_washes as cw")
                ->join("vehical_types as vv", "vv.id", "=", "cw.vehical_type_id")
                ->join("websites as site", "site.id", "=", "cw.website_id")
                ->where('cw.vehical_type_id', $veh->id)
                ->where('cw.website_id',$filter_website)
                ->select("cw.*", "vv.v_name","site.website_name")
                ->get();
        }
        //dd($carwash);
        return view('admin.carwash.index', compact('carwash', 'vehicaltype', 'websites', 'wash_types', 'title','filter_website'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'website_id'=>'required',
            'vehical_type_id'=> 'required',
            'car_wash_type'=> 'required',
            'car_wash_price'=> 'required',
          ]);

        $website_id = $request->get('website_id');
        $vehical_type_id = $request->get('vehical_type_id');
        $car_wash_type =$request->get('car_wash_type');

        if(!CarWash::where('website_id', $website_id)->where('vehical_type_id', $vehical_type_id)->where('car_wash_type', $car_wash_type)->exists()) {
            $carwash = new CarWash([
                'website_id' => $request->get('website_id'),
                'vehical_type_id' => $request->get('vehical_type_id'),
                'car_wash_type' => $request->get('car_wash_type'),
                'car_wash_price' => $request->get('car_wash_price'),
            ]);
            $carwash->save();
            return redirect('/admin/carwash')->with('success', 'Carwash Added');
        }else{
            return redirect('/admin/carwash')->with('warning', 'Carwash Exist ');
        }
    }

    public function updateinline(Request $request, $id)
    {
        $test = CarWash::find($id);
        $column_name = $request->name;
        $column_value = $request->value;
        if( $request->name) {
            $update = CarWash::select()
                ->where('id', '=', $id)
                ->update([$column_name => $column_value]);
            return response()->json([ 'code'=>200], 200);
        }

        return response()->json([ 'error'=> 400, 'message'=> 'Not enought params' ], 400);
    }

    public function delete($id){
        CarWash::find($id)->delete($id);
        return response()->json([
            'success' => 'Record deleted successfully!',
            'id' => $id
        ]);
    }

    public function autogenerate(){
        $vehicaltype = VehicalType::all();
        $websites = Website::all();
        /*$wash_types = array(
            'carwash_in_and_out' => array('w_type'=>"FULL CAR WASH (IN AND OUT)",'price'=> 12),
            'carwash_out_only'=> array('w_type'=>"CAR WASH (ONLY OUTSIDE)",'price'=> 12),
            'carwash_in_only'=> array('w_type'=>"CAR WASH (ONLY INSIDE))",'price'=> 12),
            'carwash_spray_only'=> array('w_type'=>"CAR WASH (WATER SPRAY ONLY)",'price'=> 12)
        );*/
        $wash_types = array(
            'carwash_in_and_out' => 12,
            'carwash_out_only'=> 12,
            'carwash_in_only'=> 12,
            'carwash_spray_only'=> 12
        );
        foreach ($websites as $www){
            foreach ($vehicaltype as $vvv){
                $kkk[$www->id][$vvv->id] = $wash_types;
            }

        }
        $c=0;
        foreach ($kkk as $wid=>$item){

            foreach ($item as $tyid=>$tyy) {

                foreach ($tyy as $wash_type=>$price) {


                    //echo"<pre>"; print_r($wid); print_r($tyid); print_r($wash_type); echo "</pre>";
                    if (!CarWash::where('website_id', $wid)->where('vehical_type_id', $tyid)->where('car_wash_type', $wash_type)->exists()) {
                        $carwash = new CarWash([
                            'website_id' => $wid,
                            'vehical_type_id' => $tyid,
                            'car_wash_type' => $wash_type,
                            'car_wash_price' => $price,
                        ]);
                        $carwash->save();
                      $c++;
                    } else {

                    }


                }


            }

        }

        return redirect('/admin/carwash')->with('success', ''.$c.' Carwash Generated');
    }
}
