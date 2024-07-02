<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Country;

class CountryController extends Controller
{
        /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //$airports = Airport::all();
        $title = "Country";
        $countries = DB::table('countries')->paginate(10);

        return view('admin.country', compact('countries','title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=> 'required|string',
          ]);
        $country = new Country([
            'name'=> $request->get('name'),
          ]);
        $country->save();
          return redirect('/admin/country')->with('success', 'country Added');
    }

    public function updateinline(Request $request, $id)
    {
       // $test = Country::find($id);
        $column_name = $request->name;
        $column_value = $request->value;
        if( $request->name && $request->value) {
            $test = Country::select()
                ->where('id', '=', $id)
                ->update([$column_name => $column_value]);
            return response()->json([ 'code'=>200], 200);
        }

        return response()->json([ 'error'=> 400, 'message'=> 'Not enought params' ], 400);
    }

    public function delete($id){
        Country::find($id)->delete($id);
        return response()->json([
            'success' => 'Record deleted successfully!',
            'id' => $id
        ]);
    }
}
