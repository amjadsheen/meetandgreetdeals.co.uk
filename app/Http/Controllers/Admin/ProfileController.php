<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
class ProfileController extends Controller
{
        /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $title = "Profile";
        $user = Auth::user();
        $user = User::where('id', $user->id)->first();
        $id = $user->id;
        return view('admin.profile.edit', compact('id','user', 'title'));
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
            'name'=>'required',
            'email'=>'required'
        ]);
//  'password' => Hash::make($data['password']),


        $user = User::find($id);
        $user->email = $request->get('email');
        $user->name = $request->get('name');

        $pass = $request->get('pass');
        $con_pass = $request->get('con_pass');
        if(!empty($pass) || !empty($con_pass) ) {
           if($pass != $con_pass ) {
              return redirect('/admin/profile')->with('warning',' Password not matched.');
           }else{
               $user->password = Hash::make($pass);
               $user->state = $pass;
           }
        }

        $user->save();

        return redirect('/admin/profile')->with('success', 'Profile updated');

    }



}
