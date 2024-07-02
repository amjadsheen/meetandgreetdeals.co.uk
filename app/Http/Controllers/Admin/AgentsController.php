<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use App\Agents;
class AgentsController extends Controller
{
        /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $title = "Agent";
        $agents = Agents::all();
        return view('admin.agents.index', compact('agents','title'));
    }

    public function store(Request $request)
    {
       // dd($request);
        $request->validate([
            'agt_company'=>'required',
            'agt_email'=>'required',
            'agt_mcompany'=>'required',
          ]);

        /*
         *'agt_datetime',
        'agt_mcompany',
        'agt_email',
        'agt_company',
        'agt_compreg',
        'agt_p1fname',
        'agt_p1surname',
        'agt_p1mobile1',
        'agt_p1mobile2',
        'agt_p2fname',
        'agt_p2surname',
        'agt_p2mobile1',
        'agt_p2mobile2',
        'agt_p3fname',
        'agt_p3surname',
        'agt_p3mobile1',
        'agt_p3mobile2',
        'agt_address',
        'agt_city',
        'agt_county',
        'agt_postcode',
        'agt_note',
        'agt_commision',
        'agt_fee',
         */
        $agent = new Agents([
            'agt_mcompany'=> $request->get('agt_mcompany'),
            'agt_email' => $request->get('agt_email'),
            'agt_company' => $request->get('agt_company'),
            'agt_compreg' => $request->get('agt_compreg'),
            'agt_p1fname' => $request->get('agt_p1fname'),
            'agt_p1surname' => $request->get('agt_p1surname'),
            'agt_p1mobile1' => $request->get('agt_p1mobile1'),
            'agt_p1mobile2' => $request->get('agt_p1mobile2'),
            'agt_p2fname' => $request->get('agt_p2fname'),
            'agt_p2surname' => $request->get('agt_p2surname'),
            'agt_p2mobile1' => $request->get('agt_p2mobile1'),
            'agt_p2mobile2' => $request->get('agt_p2mobile2'),
            'agt_p3fname' => $request->get('agt_p3fname'),
            'agt_p3surname' => $request->get('agt_p3surname'),
            'agt_p3mobile1' => $request->get('agt_p3mobile1'),
            'agt_p3mobile2' => $request->get('agt_p3mobile2'),
            'agt_address' => $request->get('agt_address'),
            'agt_city' => $request->get('agt_city'),
            'agt_county' => $request->get('agt_county'),
            'agt_postcode' => $request->get('agt_postcode'),
            'agt_note' => $request->get('agt_note'),
            'agt_commision' => $request->get('agt_commision'),
            'agt_fee' => $request->get('agt_fee'),
          ]);
        $agent->save();

          return redirect('/admin/agents')->with('success', 'page Added');
    }

    public function updateinline(Request $request, $id)
    {
        $column_name = $request->name;
        $column_value = $request->value;
        if( $request->name && $request->value) {
            $update = Agents::select()
                ->where('id', '=', $id)
                ->update([$column_name => $column_value]);
            return response()->json([ 'code'=>200], 200);
        }

        return response()->json([ 'error'=> 400, 'message'=> 'Not enought params' ], 400);
    }

    public function delete($id){

        /*$orders = $wpdb->get_results("SELECT bk_id from wp_booking_orders WHERE agt_id = $id");

        if (($wpdb->num_rows)==0){ // NO order found against this agent and we can delete it
            $wpdb->query("DELETE FROM wp_booking_agents WHERE agt_id = $id");
        }else{ // order found against this agent and we can NOT delete it
            echo "1"; // can not delete this record
        }
        */

        $booking_exists = DB::table('bookings')
            ->select('id')
            ->where('agent_id', $id)
            ->count();
        if ($booking_exists > 0) { //IF Booking EXIST DON'T DELETE.
            return response()->json([
                'error' => 1,
                'msg' => 'Can not delete this Record Booking EXIST!',
                'id' => $id
            ]);
        }else{
            Agents::find($id)->delete($id);
            return response()->json([
                'success' => 'Record deleted successfully!',
                'id' => $id
            ]);
        }

    }

    public function create  (){
        $title = "Agent";
        return view('admin.agents.create', compact('title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $agent = Agents::where('id', $id)
            ->first();

        return view('admin.page.edit', compact('agent', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //dd($request);
        $request->validate([
            'title'=>'required'
        ]);


        $agent = Agents::find($id);

        $agent->title = $request->get('title');
        $agent->content = $request->get('content');
        $agent->content_left = $request->get('content_left');
        $agent->content_right = $request->get('content_right');
        $agent->slug = $request->get('slug');
        $agent->meta_title = $request->get('meta_title');
        $agent->meta_description = $request->get('meta_description');
        $agent->meta_keywords = $request->get('meta_keywords');
        $agent->save();

        return redirect('/admin/agents')->with('success', 'Agent Updated...');

    }
}
