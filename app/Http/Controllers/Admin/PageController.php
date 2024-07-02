<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use App\Page;
class PageController extends Controller
{
        /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $title = "Pages";
        $pages = Page::all();
        return view('admin.page.index', compact('pages','title'));
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
            $image_url = "";
        }

        $slug = $this->createSlug($request->get('title'));
        $meta_title = $request->get('title');
        $meta_description = $request->get('content');

        $page = new Page([
            'title'=> $request->get('title'),
            'slug'=> $slug,
            'image' => $image_url,
            'content' => $request->get('content'),
            'content_left' => $request->get('content_left'),
            'content_right' => $request->get('content_right'),
            'meta_title' => $meta_title,
           // 'meta_description' => $meta_description
          ]);
          $page->save();

          return redirect('/admin/pages')->with('success', 'page Added');
    }

    public function updateinline(Request $request, $id)
    {
        $column_name = $request->name;
        $column_value = $request->value;
        if( $request->name && $request->value) {
            $update = Page::select()
                ->where('id', '=', $id)
                ->update([$column_name => $column_value]);
            return response()->json([ 'code'=>200], 200);
        }

        return response()->json([ 'error'=> 400, 'message'=> 'Not enought params' ], 400);
    }

    public function delete($id){
        Page::find($id)->delete($id);
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
        $page = Page::where('id', $id)
            ->first();

        return view('admin.page.edit', compact('page', 'id'));
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
           // Domain::copy_images_to_public($fileNameToStore);
        }

        $page = Page::find($id);

        $page->title = $request->get('title');
        $page->content = $request->get('content');
        $page->content_left = $request->get('content_left');
        $page->content_right = $request->get('content_right');
        if(!empty($cover)) {
            $page->image = $image_url;
        }
        $page->slug = $request->get('slug');
        $page->meta_title = $request->get('meta_title');
        $page->meta_description = $request->get('meta_description');
        $page->meta_keywords = $request->get('meta_keywords');
        $page->save();

        return redirect('/admin/pages')->with('success', 'page has been updated');

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
        return Page::select('slug')->where('slug', 'like', $slug.'%')
            ->where('id', '<>', $id)
            ->get();
    }

}
