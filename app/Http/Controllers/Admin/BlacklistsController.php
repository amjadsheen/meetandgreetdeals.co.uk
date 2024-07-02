<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Blacklists;
class BlacklistsController extends Controller
{
        /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //$airports = Airport::all();
        $title = "Blacklists";
        $blacklists = DB::table('blacklists')
            ->get();
        return view('admin.blacklists.index', compact('blacklists','title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bl_data'=>'required',
            'bl_type'=>'required',
            'bl_remarks'=>'required',
          ]);
          $blacklist = new Blacklists([
            'bl_data'=> $request->get('bl_data'),
            'bl_type' => $request->get('bl_type'),
            'bl_remarks' => $request->get('bl_remarks'),
          ]);
        $blacklist->save();
          return redirect('/admin/blacklists')->with('success', 'blacklist Added');
    }

    public function updateinline(Request $request, $id)
    {
        //$test = Faq::find($id);
        $column_name = $request->name;
        $column_value = $request->value;
        if( $request->name && $request->value) {
            $update = Blacklists::select()
                ->where('id', '=', $id)
                ->update([$column_name => $column_value]);
            return response()->json([ 'code'=>200], 200);
        }

        return response()->json([ 'error'=> 400, 'message'=> 'Not enought params' ], 400);
    }

    public function delete($id){
        Blacklists::find($id)->delete($id);
        return response()->json([
            'success' => 'Record deleted successfully!',
            'id' => $id
        ]);
    }
}
