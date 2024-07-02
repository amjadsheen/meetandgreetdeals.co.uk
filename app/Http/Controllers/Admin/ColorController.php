<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Color;

class ColorController extends Controller
{
        /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $title = "Colors";
        $colors = Color::all();
        //$colors = DB::table('colors')->paginate(10);

        return view('admin.color', compact('colors', 'title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'clr_name'=>'required',
            'clr_sort'=> 'required',
          ]);
          $color = new Color([
            'clr_name' => $request->get('clr_name'),
            'clr_sort'=> $request->get('clr_sort'),
          ]);
        $color->save();
          return redirect('/admin/color')->with('success', 'Color Added');
    }

    public function updateinline(Request $request, $id)
    {
        $test = Color::find($id);
        $column_name = $request->name;
        $column_value = $request->value;
        if( $request->name && $request->value) {
            $update = Color::select()
                ->where('id', '=', $id)
                ->update([$column_name => $column_value]);
            return response()->json([ 'code'=>200], 200);
        }

        return response()->json([ 'error'=> 400, 'message'=> 'Not enought params' ], 400);
    }

    public function delete($id){
        Color::find($id)->delete($id);
        return response()->json([
            'success' => 'Record deleted successfully!',
            'id' => $id
        ]);
    }
}
