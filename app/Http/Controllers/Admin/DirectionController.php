<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use App\Direction;
class DirectionController extends Controller
{
        /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $title = "Directions";
        $directions = Direction::all();
        return view('admin.direction.index', compact('directions','title'));
    }

    public function store(Request $request)
    {
       // dd($request);
        $request->validate([
            'title'=>'required',
          ]);

        $cover = $request->file('image');
        if(!empty($cover)) {
            /*$extension = $cover->getClientOriginalExtension();
            Storage::disk('public')->put($cover->getFilename() . '.' . $extension, File::get($cover));
           $image_url =  $cover->getFilename().'.'.$extension;*/

            $filenameWithExt = $request->file('image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            $image_url = $fileNameToStore;
            $request->file('image')->storeAs('public/uploads', $fileNameToStore);
            //Domain::copy_images_to_public($fileNameToStore);
        }else{
            $image_url = "coming-soon-1.jpg";
        }

        $slug = $this->createSlug($request->get('title'));
        $meta_title = $request->get('title');
        $meta_description = $request->get('content');

        $direction = new Direction([
            'title'=> $request->get('title'),
            'slug'=> $slug,
            'image' => $image_url,
            'content' => $request->get('content'),
            'terminal_1' => $request->get('terminal_1'),
            'terminal_2' => $request->get('terminal_2'),
            'terminal_3' => $request->get('terminal_3'),
            'terminal_4' => $request->get('terminal_4'),
            'terminal_5' => $request->get('terminal_5'),
            'meta_title' => $meta_title,
            'meta_description' => $meta_description
          ]);
          $direction->save();

          return redirect('/admin/directions')->with('success', 'direction Added');
    }

    public function updateinline(Request $request, $id)
    {
        $column_name = $request->name;
        $column_value = $request->value;
        if( $request->name && $request->value) {
            $update = Direction::select()
                ->where('id', '=', $id)
                ->update([$column_name => $column_value]);
            return response()->json([ 'code'=>200], 200);
        }

        return response()->json([ 'error'=> 400, 'message'=> 'Not enought params' ], 400);
    }

    public function delete($id){
        Direction::find($id)->delete($id);
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
        $direction = Direction::where('id', $id)
            ->first();

        return view('admin.direction.edit', compact('direction', 'id'));
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

        $cover = $request->file('image');
        if(!empty($cover)) {
           /*$extension = $cover->getClientOriginalExtension();
            Storage::disk('public')->put($cover->getFilename() . '.' . $extension, File::get($cover));*/

            $filenameWithExt = $request->file('image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            $image_url = $fileNameToStore;
            $request->file('image')->storeAs('public/uploads', $fileNameToStore);
            //Domain::copy_images_to_public($fileNameToStore);
        }

        $direction = Direction::find($id);

        $direction->title = $request->get('title');
        $direction->content = $request->get('content');
        $direction->terminal_1 = $request->get('terminal_1');
        $direction->terminal_2 = $request->get('terminal_2');
        $direction->terminal_3 = $request->get('terminal_3');
        $direction->terminal_4 = $request->get('terminal_4');
        $direction->terminal_5 = $request->get('terminal_5');
        if(!empty($cover)) {
            $direction->image = $image_url;
        }else{
          //  $direction->image = "coming-soon-1.jpg";
        }
        $direction->slug = $request->get('slug');
        $direction->meta_title = $request->get('meta_title');
        $direction->meta_description = $request->get('meta_description');
        $direction->meta_keywords = $request->get('meta_keywords');
        $direction->save();

        return redirect('/admin/directions')->with('success', 'direction has been updated');

    }


    //For Generating Unique Slug Our Custom function
    public function createSlug($title, $id = 0)
    {
        // Normalize the title
        $slug = str_slug($title);
        // Get any that could possibly be related.
        // This cuts the queries down by doing it once.
        $allSlugs = $this->getRelatedSlugs($slug, $id);
        // If we haven't used it before then we are all good.
        if (! $allSlugs->contains('slug', $slug)){
            return $slug;
        }
        // Just append numbers like a savage until we find not used.
        for ($i = 1; $i <= 10; $i++) {
            $newSlug = $slug.'-'.$i;
            if (! $allSlugs->contains('slug', $newSlug)) {
                return $newSlug;
            }
        }
        throw new \Exception('Can not create a unique slug');
    }

    protected function getRelatedSlugs($slug, $id = 0)
    {
        return Direction::select('slug')->where('slug', 'like', $slug.'%')
            ->where('id', '<>', $id)
            ->get();
    }

}
