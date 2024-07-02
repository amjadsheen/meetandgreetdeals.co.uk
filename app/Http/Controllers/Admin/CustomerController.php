<?php

namespace App\Http\Controllers\Admin;

use App\Agents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Customer;

class CustomerController extends Controller
{
        /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //$customers_registered = Customer::all();
        $customers_registered = Customer::where('cus_oneoff', 0)->groupBy('cus_email')->get();
        //$customers_oneoff = Customer::where('cus_oneoff', 1)->groupBy('cus_title')
             $customers_oneoff = Customer::where('cus_oneoff', 1)->groupBy('cus_email','cus_title')->get();
        $title = "Customers";
        //$customers = DB::table('customers')->paginate(10);

        return view('admin.customer.index', compact('customers_registered','customers_oneoff','title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cus_name'=> 'required|string',
          ]);
        $customers = new Customer([
            'name'=> $request->get('name'),
          ]);
        $customers->save();
          return redirect('/admin/customers')->with('success', 'customer Added');
    }

    public function updateinline(Request $request, $id)
    {
        $column_name = $request->name;
        $column_value = $request->value;
        if( $request->name && $request->value) {
            $test = Customer::select()
                ->where('id', '=', $id)
                ->update([$column_name => $column_value]);
            return response()->json([ 'code'=>200], 200);
        }

        return response()->json([ 'error'=> 400, 'message'=> 'Not enought params' ], 400);
    }

    public function delete($id){
        Customer::find($id)->delete($id);
        return response()->json([
            'success' => 'Record deleted successfully!',
            'id' => $id
        ]);
    }
    public function getcustomer($id)
    {
        $customer = Customer::find($id);

            echo "<table id='CustomerTable' class='table table-bordered'>
                <tbody>
                <tr>
                   <td>Title: $customer->cus_title</td>
                   <td>Name: $customer->cus_name</td>
                   <td>SurName: $customer->cus_surname</td>
                   <td>Email: $customer->cus_email</td>
                   <td>Email2: $customer->cus_email_1</td>
                </tr>
                <tr>
                   <td>Company: $customer->cus_company</td>
                   <td>Tele#: $customer->cus_tele</td>
                   <td>Cell#: $customer->cus_cell</td>
                   <td>Cell#2: $customer->cus_cell2</td>
                   <td>Country: $customer->cus_country</td>
                </tr>
               <tr>
                   <td>Home: $customer->cus_homename</td>
                   <td>Address: $customer->cus_address</td>
                   <td>Town: $customer->cus_town</td>
                   <td>County: $customer->cus_county</td>
                   <td>Postcode: $customer->cus_postcode</td>
               </tr>
               <tr style='display: none;'>
                <td>Password: $customer->cus_password</td>
                </tr>
                </tbody>
             </table>
           ";

    }
}
