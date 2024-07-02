<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Yards;
use App\Airport;
use App\Locations;
class LocationsController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $title = "Location";
        $airports = Airport::all();
        foreach ($airports as $airport) {
            $rs_yards = DB::table("yards as yd")
                ->join("airports as aa", "aa.id", "=", "yd.airport_id")
                ->where('yd.airport_id', $airport->id)
                ->select("yd.*","aa.id as aa_id")
                ->get();
            if(!$rs_yards->isEmpty()){
                foreach ($rs_yards as $yards) {
                    $locations[$airport->airport_name][$yards->yrd_name]  = DB::table("locations")
                        ->select("id as loc_id", "loc_name", "loc_occupied", "loc_disable")
                        ->where('yard_id','=' ,$yards->id)
                        ->get();
                }


            }
        }
        //echo "<pre>"; print_r($location); echo "</pre>";
        //exit;

        return view('admin.locations.index', compact('airports','locations', 'title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'yard_id' => 'required',
            'loc_name' => 'required',
        ]);
        $loc_name= $request->get('loc_name');
        $yard_id= $request->get('yard_id');
        if(!Locations::where('loc_name', $loc_name)->where('yard_id', $yard_id)->exists()){
            $yard = new Locations([
                'yard_id' => $request->get('yard_id'),
                'loc_name' => $request->get('loc_name')
            ]);
            $yard->save();
            return redirect('/admin/locations')->with('success', 'Location Added Successfully');
        }else{
            return redirect('/admin/locations')->with('warning', 'Location Already Exits.');
        }

    }

    public function updateinline(Request $request, $id)
    {
        //$test = Faq::find($id);
        $column_name = $request->name;
        $column_value = $request->value;
        if ($request->name && $request->value) {
            $update = Locations::select()
                ->where('id', '=', $id)
                ->update([$column_name => $column_value]);
            return response()->json(['code' => 200], 200);
        }

        return response()->json(['error' => 400, 'message' => 'Not enought params'], 400);
    }

    public function delete($id){
        $movement_exists = DB::table('movements')
            ->select('id')
            ->where('location_id', $id)
            ->count();
        if ($movement_exists > 0) { //IF MOMENT EXIST FOR YARD DON'T DELETE.
            return response()->json([
                'error' => 1,
                'msg' => 'Can not delete this Record MOMENT EXIST!',
                'id' => $id
            ]);
        } else {
            Locations::find($id)->delete($id);
            return response()->json([
                'success' => 'Record deleted successfully!',
                'id' => $id
            ]);
        }


    }
    public function getyards($aiportid=0){
        $yards['data']  = DB::table('yards as yy')
            ->where('airport_id', $aiportid)
            ->get();

        echo json_encode($yards);
        exit;
    }
}
