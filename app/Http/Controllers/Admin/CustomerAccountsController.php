<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\CustomerAccount;
class CustomerAccountsController extends Controller
{
        /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $title = "Customer Accounts";
        $customer_accounts = DB::table('customer_accounts')->get();
        return view('admin.customer-accounts.index', compact('customer_accounts','title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'account_num'=>'required',
            'customer_email'=>'required'
          ]);
          $customer_accounts = new CustomerAccount([
            'account_num'=> $request->get('account_num'),
            'customer_email' => $request->get('customer_email'),
            //'customer_id' => $request->get('customer_id'),
            'status' => $request->get('status')
          ]);
        $customer_accounts->save();
        return redirect('/admin/customeraccounts')->with('success', 'customer_accounts Added');
    }

    public function updateinline(Request $request, $id)
    {
        //$test = Faq::find($id);
        $column_name = $request->name;
        $column_value = $request->value;
        if( $request->name && $request->value) {
            $update = CustomerAccount::select()
                ->where('id', '=', $id)
                ->update([$column_name => $column_value]);
            return response()->json([ 'code'=>200], 200);
        }

        return response()->json([ 'error'=> 400, 'message'=> 'Not enought params' ], 400);
    }

    public function delete($id){
        CustomerAccount::find($id)->delete($id);
        return response()->json([
            'success' => 'Record deleted successfully!',
            'id' => $id
        ]);
    }
}
