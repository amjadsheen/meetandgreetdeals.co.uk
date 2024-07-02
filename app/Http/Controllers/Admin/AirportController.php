<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Airport;
use App\Country;
use App\Direction;
class AirportController extends Controller
{
        /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
	     //echo 'kkkkk'.$domain =  env('APP_URL');
        //$airports = Airport::all();
        $title = "Airports";
        $countries = Country::all();
        $directions = Direction::all();
        foreach ($countries as $country){
            $countries_json[] = array('value'=>$country->id, 'text'=>$country->name);
        }

        $countries_json = json_encode($countries_json);
        foreach ($directions as $direction){
            $directions_json[] = array('value'=> "directions-drop-collect/".$direction->slug, 'text'=>$direction->title);
        }
        $directions_json = json_encode($directions_json);

        $airports = DB::table("airports as at")
            ->leftJoin("countries as ct","ct.id","=","at.country_id")
            ->select("at.*", "ct.name As country_name")
            ->get();

        return view('admin.airport', compact('airports','countries', 'countries_json', 'directions_json', 'title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'country_id'=>'required',
            'airport_nick'=>'required',
            'airport_name'=> 'required|string',
            'airport_directions' => 'required|string'
          ]);
          $airport = new Airport([
            'country_id'=> $request->get('country_id'),
            'airport_nick' => $request->get('airport_nick'),
            'airport_name'=> $request->get('airport_name'),
            'airport_directions'=> $request->get('airport_directions'),

          ]);
          $airport->save();
          return redirect('/admin/airport')->with('success', 'Airport Added');
    }

    public function updateinline(Request $request, $id)
    {
        $test = Airport::find($id);
        $column_name = $request->name;
        $column_value = $request->value;
        if( $request->name) {
            $test = Airport::select()
                ->where('id', '=', $id)
                ->update([$column_name => $column_value]);
            return response()->json([ 'code'=>200], 200);
        }

        return response()->json([ 'error'=> 400, 'message'=> 'Not enought params' ], 400);
    }

    public function delete($id){
        Airport::find($id)->delete($id);
        return response()->json([
            'success' => 'Record deleted successfully!',
            'id' => $id
        ]);
    }
}
