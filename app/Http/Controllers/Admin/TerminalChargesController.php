<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Terminal;
use App\TerminalCharge;
use App\Airport;
use App\RegularPrices;
use App\RegularDiscounts;
use App\Website;
class TerminalChargesController extends Controller
{
        /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $title = "Terminal Charges";
        
        // Fetch all terminals from the existing terminals table
        $websites = DB::table('websites')->where('default_site', 0)->get();
        $terminals = DB::table('terminals')->get();

        foreach ($websites as $website) {
            foreach ($terminals as $departure) {
                foreach ($terminals as $arrival) {
                    // Skip if it's the same terminal
                    if ($departure->id === $arrival->id) {
                        continue;
                    }

                    // Check if the combination already exists for the specific website
                    $exists = DB::table('terminal_charges')->where([
                        ['airport_id', '=', $departure->airport_id],
                        ['departure_terminal', '=', $departure->ter_name],
                        ['arrival_terminal', '=', $arrival->ter_name],
                        ['website_id', '=', $website->id], // Include website_id in the check
                    ])->exists();

                    if (!$exists) {
                        // Calculate extra charges (custom logic can be applied here)
                        $extraCharges = 0; // Example: default extra charges

                        // Insert the combination with website_id
                        DB::table('terminal_charges')->insert([
                            'airport_id' => $departure->airport_id,
                            'departure_terminal' => $departure->ter_name,
                            'arrival_terminal' => $arrival->ter_name,
                            'extra_charges' => $extraCharges,
                            'website_id' => $website->id, // Insert website_id
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
        }

        // Check for 'filter_website' input, default to 2 if not provided
        $filter_website = request()->has('filter_website') && !empty(request()->input('filter_website')) 
        ? request()->input('filter_website') 
        : 2;

        $combinations = DB::select("
        SELECT 
            tc.id,
            a.airport_name,
            t1.ter_name AS departure_terminal_name,
            t2.ter_name AS arrival_terminal_name,
            tc.extra_charges,
            w.id AS website_id,
            w.website_name
        FROM 
            terminal_charges tc
        JOIN 
            airports a ON a.id = tc.airport_id
        JOIN 
            terminals t1 ON t1.ter_name = tc.departure_terminal AND t1.airport_id = tc.airport_id
        JOIN 
            terminals t2 ON t2.ter_name = tc.arrival_terminal AND t2.airport_id = tc.airport_id
        JOIN 
            websites w ON w.id = tc.website_id
        WHERE tc.website_id = ?
        ", [$filter_website]);  // Parameter binding for security

       
    
        return view('admin.terminal_charges', compact('combinations','title', 'websites', 'filter_website'));
    }

    public function updateinline(Request $request, $id)
    {
        //Terminal::find($id);
        $column_name = $request->name;
        $column_value = $request->value;
        if( $request->name ) {
            $update = TerminalCharge::select()
                ->where('id', '=', $id)
                ->update([$column_name => $column_value]);
            return response()->json([ 'code'=>200], 200);
        }

        return response()->json([ 'error'=> 400, 'message'=> 'Not enought params' ], 400);
    }

    public function delete($id){
        TerminalCharge::find($id)->delete($id);
        return response()->json([
            'success' => 'Record deleted successfully!',
            'id' => $id
        ]);
    }
}
