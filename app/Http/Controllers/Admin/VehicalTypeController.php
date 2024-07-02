<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use App\VehicalType;
use App\CarWash;
class VehicalTypeController extends Controller
{
        /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //dd("CarWash Disabled");
        $title = "VehicalType";
        $vehicaltype = VehicalType::all();
        //$colors = DB::table('colors')->paginate(10);

        return view('admin.vehicaltype.index', compact('vehicaltype', 'title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'v_name'=>'required',
          ]);
//dd($request);
        $cover = $request->file('v_image');
        if(!empty($cover)) {
            /*$extension = $cover->getClientOriginalExtension();
            Storage::disk('public')->put($cover->getFilename() . '.' . $extension, File::get($cover));
            $vechical_type_image = $cover->getFilename().'.'.$extension;*/

            $filenameWithExt = $request->file('v_image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('v_image')->getClientOriginalExtension();
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            $vechical_type_image = $fileNameToStore;
            $request->file('v_image')->storeAs('public/uploads', $fileNameToStore);
            //Domain::copy_images_to_public($fileNameToStore);

        }else{
            $vechical_type_image = "";
        }
        $v_name = $request->get('v_name');
        $vehicaltype = new VehicalType([
            'v_name' => $v_name,
            'v_image' => $vechical_type_image,
          ]);
        $vehicaltype->save();
          return redirect('/admin/vehicaltype')->with('success', 'vehicaltype Added');
    }

    public function updateinline(Request $request, $id)
    {
        $test = VehicalType::find($id);
        $column_name = $request->name;
        $column_value = $request->value;
        if( $request->name && $request->value) {
            $update = VehicalType::select()
                ->where('id', '=', $id)
                ->update([$column_name => $column_value]);
            return response()->json([ 'code'=>200], 200);
        }

        return response()->json([ 'error'=> 400, 'message'=> 'Not enought params' ], 400);
    }

    public function delete($id){
        VehicalType::find($id)->delete($id);
        return response()->json([
            'success' => 'Record deleted successfully!',
            'id' => $id
        ]);
    }

/**
* Show the form for editing the specified resource.
*
* @param  int  $id
* @return \Illuminate\Http\Response
*/
    public function edit($id)
    {
        $title = "VehicalType";
       $vehicaltype = VehicalType::where('id', $id)->first();
        return view('admin.vehicaltype.edit', compact('vehicaltype', 'id','title'));
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
            'v_name'=>'required'
        ]);

        $cover = $request->file('v_image');
        if(!empty($cover)) {
           /* $extension = $cover->getClientOriginalExtension();
            Storage::disk('public')->put($cover->getFilename() . '.' . $extension, File::get($cover));*/

            $filenameWithExt = $request->file('v_image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('v_image')->getClientOriginalExtension();
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            $cover_image = $fileNameToStore;
            $request->file('v_image')->storeAs('public/uploads', $fileNameToStore);
            //Domain::copy_images_to_public($fileNameToStore);
        }
       $v_type = VehicalType::find($id);
       $v_type->v_name = $request->get('v_name');
        if(!empty($cover_image)) {
           $v_type->v_image = $cover_image;
        }
       $v_type->save();

        return redirect('/admin/vehicaltype')->with('success', 'vehicaltype has been updated');

    }
}
