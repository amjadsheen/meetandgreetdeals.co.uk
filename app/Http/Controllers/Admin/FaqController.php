<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Faq;
class FaqController extends Controller
{
        /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //$airports = Airport::all();
        $title = "Faqs";
        //$faqs = Faq::all();
        $faqs = DB::table('faqs')
            //->where('disable', '=', 0)
            ->orderByRaw('sort ASC')
            ->get();
        return view('admin.faq', compact('faqs','title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'question'=>'required',
            'answer'=>'required',
          ]);
          $airport = new Faq([
            'question'=> $request->get('question'),
            'answer' => $request->get('answer')
          ]);
          $airport->save();
          return redirect('/admin/faqs')->with('success', 'Faq Added');
    }

    public function updateinline(Request $request, $id)
    {
        //$test = Faq::find($id);
        $column_name = $request->name;
        $column_value = $request->value;
        if( $request->name && $request->value) {
            $update = Faq::select()
                ->where('id', '=', $id)
                ->update([$column_name => $column_value]);
            return response()->json([ 'code'=>200], 200);
        }

        return response()->json([ 'error'=> 400, 'message'=> 'Not enought params' ], 400);
    }

    public function delete($id){
        Faq::find($id)->delete($id);
        return response()->json([
            'success' => 'Record deleted successfully!',
            'id' => $id
        ]);
    }
}
