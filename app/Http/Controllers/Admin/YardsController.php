<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Yards;
use App\Airport;

class YardsController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $title = "Yard";
        $airports = Airport::all();
        foreach ($airports as $airport) {
            $yards[$airport->airport_name] = DB::table("yards as yd")
                ->join("airports as aa", "aa.id", "=", "yd.airport_id")
                ->where('yd.airport_id', $airport->id)
                ->select("yd.*")
                ->get();
        }
        //dd($yards);
        //$yards = DB::table('yards')->get();
        return view('admin.yards.index', compact('airports', 'yards', 'title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'airport_id' => 'required',
            'yrd_name' => 'required',
        ]);
        $yrd_name = $request->get('yrd_name');
        $airport_id = $request->get('airport_id');
        if(!Yards::where('yrd_name', $yrd_name)->where('airport_id', $airport_id)->exists()){
            $yard = new Yards([
                'airport_id' => $request->get('airport_id'),
                'yrd_name' => $request->get('yrd_name')
            ]);
            $yard->save();
            return redirect('/admin/yards')->with('success', 'Yard Added Successfully');
        }else{
            return redirect('/admin/yards')->with('warning', 'Yard Already Exits.');
        }

    }

    public function updateinline(Request $request, $id)
    {
        //$test = Faq::find($id);
        $column_name = $request->name;
        $column_value = $request->value;
        if ($request->name && $request->value) {
            $update = Yards::select()
                ->where('id', '=', $id)
                ->update([$column_name => $column_value]);
            return response()->json(['code' => 200], 200);
        }

        return response()->json(['error' => 400, 'message' => 'Not enought params'], 400);
    }

    public function delete($id)
    {

        /* $qry = "SELECT wp_booking_yards.yrd_id
                 FROM wp_booking_yards
                 INNER JOIN wp_booking_locations ON wp_booking_yards.yrd_id = wp_booking_locations.yrd_id
                  INNER JOIN wp_booking_movements ON wp_booking_locations.loc_id = wp_booking_movements.loc_id
                 WHERE wp_booking_yards.yrd_id = $id";
         $wpdb->get_results($qry);

         if (($wpdb->num_rows)==0){ // NO movement found for this yard and we can delete it
             $wpdb->query("DELETE FROM wp_booking_yards WHERE yrd_id =$id");
         }else{ // order found against this airport in orders and we can NOT delete it
             echo "1"; // can not deltet this record
         }*/

        $movement_exists = DB::table('yards as yy')
            ->select('id')
            ->join("locations as ll", "ll.yard_id", "=", "yy.id")
            ->join("movements as mm", "ll.id", "=", "mm.location_id")
            ->where('yy.id', $id)
            ->count();
        if ($movement_exists > 0) { //IF MOMENT EXIST FOR YARD DON'T DELETE.
            return response()->json([
                'error' => 1,
                'msg' => 'Can not delete this Record MOMENT EXIST!',
                'id' => $id
            ]);
        } else {
            Yards::find($id)->delete($id);
            return response()->json([
                'success' => 'Record deleted successfully!',
                'id' => $id
            ]);
        }


    }


}
