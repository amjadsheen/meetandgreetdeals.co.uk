<?php

namespace App\Http\Controllers\Admin;

use App\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Country;

class CurrencyController extends Controller
{
        /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //$airports = Airport::all();
        $title = "Currencies";
        $currencies = DB::table('currencies')->paginate(100);

        return view('admin.currencies.index', compact('currencies','title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cur_name'=> 'required',
            'cur_code'=> 'required',
            'cur_symbol'=> 'required',
            'cur_rate'=> 'required',
          ]);
        $currency = new Currency([
            'cur_name'=> $request->get('cur_name'),
            'cur_code'=> $request->get('cur_code'),
            'cur_symbol'=> $request->get('cur_symbol'),
            'cur_rate'=> $request->get('cur_rate'),
          ]);
        $currency->save();
          return redirect('/admin/currencies')->with('success', 'Currency Added');
    }

    public function updateinline(Request $request, $id)
    {
        $column_name = $request->name;
        $column_value = $request->value;
        if( $request->name && $request->value) {
            $test = Currency::select()
                ->where('id', '=', $id)
                ->update([$column_name => $column_value]);
            return response()->json([ 'code'=>200], 200);
        }

        return response()->json([ 'error'=> 400, 'message'=> 'Not enought params' ], 400);
    }

    public function delete($id){
        Currency::find($id)->delete($id);
        return response()->json([
            'success' => 'Record deleted successfully!',
            'id' => $id
        ]);
    }
}
