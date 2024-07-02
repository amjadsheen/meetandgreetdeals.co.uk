<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Terminal;
use App\Airport;
use App\RegularPrices;
use App\RegularDiscounts;
use App\Website;
class TerminalController extends Controller
{
        /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //$terminals = DB::table('terminals')->paginate(10);
        //$terminals = Terminal::all();
        $title = "Terminals";
        $airports = Airport::all();
        foreach ($airports as $airport){
            $terminals[$airport->airport_name] = DB::table('terminals')->where('airport_id', '=', $airport->id)->get();
            //$airportterminals[] = $terminal;
        }
        //echo "<pre>";
        //print_r($terminals);exit;
        return view('admin.terminal', compact('terminals','airports','title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'airport_id'=>'required',
            'ter_name'=> 'required',
            'ter_cap'=> 'required',
            'ter_interval' => 'required'
          ]);
          $terminal = new Terminal([
            'airport_id' => $request->get('airport_id'),
            'ter_name'=> $request->get('ter_name'),
            'ter_cap'=> $request->get('ter_cap'),
            'ter_interval'=> $request->get('ter_interval')
          ]);
        $isReportCreated = $terminal->save();

        if($isReportCreated){
            $SavedTerminalId = $terminal->id;

            $websites = Website::all('id', 'website_name');
            if (count($websites)) {
                foreach ($websites as $website) {
                    /*--- RegularPrices*/
                    $RegularPrice = new RegularPrices([
                        'terminal_id' => $SavedTerminalId,
                        'website_id' => $website->id,
                    ]);
                    $RegularPrice->save();
                    /*--- RegularPrices*/


                    /*--- RegularDiscounts*/
                    $RegularDiscount = new RegularDiscounts([
                        'terminal_id' => $SavedTerminalId,
                        'website_id' => $website->id,
                    ]);
                    $RegularDiscount->save();
                    /*--- RegularDiscounts*/

                }
            }else{
                //die('ooo');
                $RegularPrice = new RegularPrices([
                    'terminal_id' => $SavedTerminalId,
                ]);
                $RegularPrice->save();
                /*--- RegularPrices*/



                /*--- RegularDiscounts*/
                $RegularDiscount = new RegularDiscounts([
                    'terminal_id' => $SavedTerminalId,
                ]);
                $RegularDiscount->save();
                /*--- RegularDiscounts*/

            }

        }

          return redirect('/admin/terminal')->with('success', 'Terminal Added');
    }

    public function updateinline(Request $request, $id)
    {
        //Terminal::find($id);
        $column_name = $request->name;
        $column_value = $request->value;
        if( $request->name ) {
            $update = Terminal::select()
                ->where('id', '=', $id)
                ->update([$column_name => $column_value]);
            return response()->json([ 'code'=>200], 200);
        }

        return response()->json([ 'error'=> 400, 'message'=> 'Not enought params' ], 400);
    }

    public function delete($id){
        Terminal::find($id)->delete($id);

        RegularDiscounts::where('terminal_id', $id)->delete();
        RegularPrices::where('terminal_id', $id)->delete();

        return response()->json([
            'success' => 'Record deleted successfully!',
            'id' => $id
        ]);
    }
}
