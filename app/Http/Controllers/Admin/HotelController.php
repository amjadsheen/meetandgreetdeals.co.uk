<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Hotel;
use App\Airport;
class HotelController extends Controller
{
        /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $title = "Hotel";
        $airports = Airport::all();
        foreach ($airports as $airport){
            $airport_json[] = array('value'=>$airport->id, 'text'=>$airport->airport_name);
        }
        $airport_json = json_encode($airport_json);
        $hotels = DB::table('hotels as hh')
            ->join("airports as aa", "aa.id", "=", "hh.airport_id")
            ->select("hh.*", "aa.airport_name")
            ->get();
        return view('admin.hotel.index', compact('title','hotels','airports','airport_json'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'htl_name'=>'required',
          ]);
          $hotel = new Hotel([
           'airport_id'=> $request->get('airport_id'),
            'htl_name'=> $request->get('htl_name')
          ]);
          $hotel->save();
          return redirect('/admin/hotels')->with('success', 'Hotel Added');
    }

    public function updateinline(Request $request, $id)
    {
        $column_name = $request->name;
        $column_value = $request->value;
        if( $request->name && $request->value) {
            $update = Hotel::select()
                ->where('id', '=', $id)
                ->update([$column_name => $column_value]);
            return response()->json([ 'code'=>200], 200);
        }

        return response()->json([ 'error'=> 400, 'message'=> 'Not enought params' ], 400);
    }

    public function delete($id){
        Hotel::find($id)->delete($id);
        return response()->json([
            'success' => 'Record deleted successfully!',
            'id' => $id
        ]);
    }
}
