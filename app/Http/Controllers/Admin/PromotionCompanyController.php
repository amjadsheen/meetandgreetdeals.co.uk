<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\PromotionCompany;

class PromotionCompanyController extends Controller
{
        /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //$airports = Airport::all();
        $title = "Promotion Companies";
        $promotion_companies = DB::table('promotion_companies')->paginate(10);

        return view('admin.promotion_companies', compact('promotion_companies','title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'company_name'=> 'required|string',
            'company_contact'=> 'required|string',
          ]);
        $promotioncompany = new PromotionCompany([
            'company_name'=> $request->get('company_name'),
            'company_contact'=> $request->get('company_contact'),
          ]);
        $promotioncompany->save();
          return redirect('/admin/promotion-companies')->with('success', 'Promotion Company Added');
    }

    public function updateinline(Request $request, $id)
    {

        $column_name = $request->name;
        $column_value = $request->value;
        if( $request->name && $request->value) {
            $update = PromotionCompany::select()
                ->where('id', '=', $id)
                ->update([$column_name => $column_value]);
            return response()->json([ 'code'=>200], 200);
        }

        return response()->json([ 'error'=> 400, 'message'=> 'Not enought params' ], 400);
    }

    public function delete($id){
        PromotionCompany::find($id)->delete($id);
        return response()->json([
            'success' => 'Record deleted successfully!',
            'id' => $id
        ]);
    }
}
