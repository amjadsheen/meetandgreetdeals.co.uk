<?php

namespace App\Http\Controllers\Admin;

use App\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use App\Website;
use App\RegularDiscounts;
use App\RegularPrices;
use App\Banner;
use App\Classes\Domain;
use App\FixedPrices;
use App\VehicalType;
use App\CarWash;
use App\NotWorkingHours;
use App\PromotionOffer;
use App\Reviews;
use App\Settings;

class CamparsionWebsiteController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //$airports = Airport::all();
        $title = "Camparsion Website";
        $websites = DB::table('websites')->where('default_site', 0)->get();
        //dd($websites);
        return view('admin.camparsionwebsites.index', compact('websites', 'title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'website_name' => 'required',
            'website_url' => 'required',
            //'website_prefix' => 'required',
        ]);
        $website_logo = $request->file('website_logo');
        if (!empty($website_logo)) {
            /*$extension = $website_logo->getClientOriginalExtension();
            Storage::disk('public')->put($website_logo->getFilename() . '.' . $extension, File::get($website_logo));
            $website_logo_image = $website_logo->getFilename() . '.' . $extension;*/

            $filenameWithExt = $request->file('website_logo')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('website_logo')->getClientOriginalExtension();
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            $website_logo_image = $fileNameToStore;
            $request->file('website_logo')->storeAs('public/uploads', $fileNameToStore);
           // Domain::copy_images_to_public($fileNameToStore);

        } else {
            $website_logo_image = 'edenlogo.png';
        }
        /* -- website_email_banner --- */
        $website_email_banner = $request->file('website_email_banner');
        if (!empty($website_email_banner)) {
            /*$extension = $website_email_banner->getClientOriginalExtension();
            Storage::disk('public')->put($website_email_banner->getFilename() . '.' . $extension, File::get($website_email_banner));
            $website_email_banner_image = $website_email_banner->getFilename() . '.' . $extension;*/

            $filenameWithExt = $request->file('website_email_banner')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('website_email_banner')->getClientOriginalExtension();
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            $website_email_banner_image = $fileNameToStore;
            $request->file('website_email_banner')->storeAs('public/uploads', $fileNameToStore);
            //Domain::copy_images_to_public($fileNameToStore);

        } else {
            $website_email_banner_image = 'website_email_banner.png';
        }
        /* -- website_email_banner --- */

        /* -- website_banner --- */
        $website_banner = $request->file('website_banner');
        if (!empty($website_banner)) {
            /*$extension = $website_banner->getClientOriginalExtension();
            Storage::disk('public')->put($website_banner->getFilename() . '.' . $extension, File::get($website_banner));
            $website_banner = $website_banner->getFilename() . '.' . $extension;*/

            $filenameWithExt = $request->file('website_banner')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('website_banner')->getClientOriginalExtension();
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            $website_banner_image = $fileNameToStore;
            $request->file('website_banner')->storeAs('public/uploads', $fileNameToStore);
            //Domain::copy_images_to_public($fileNameToStore);

        } else {
            $website_banner_image = 'phpA46F.tmp.gif';
        }
        /* -- website_banner --- */

        $website_favicon = $request->file('website_favicon');
        if (!empty($website_favicon)) {
            /*$extension = $website_favicon->getClientOriginalExtension();
            Storage::disk('public')->put($website_favicon->getFilename() . '.' . $extension, File::get($website_favicon));
            $website_favicon_image = $website_favicon->getFilename() . '.' . $extension;*/

            $filenameWithExt = $request->file('website_favicon')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('website_favicon')->getClientOriginalExtension();
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            $website_favicon_image = $fileNameToStore;
            $request->file('website_favicon')->storeAs('public/uploads', $fileNameToStore);
            //Domain::copy_images_to_public($fileNameToStore);


        } else {
            $website_favicon_image = "edenlogo.jpg";
        }
        $website_meta_title = "";
        $website = new Website([
            'website_name' => $request->get('website_name'),
            //'website_prefix' => $request->get('website_prefix'),
            'website_url' => $request->get('website_url'),
            'website_logo' => $website_logo_image,
            'website_email_banner' => $website_email_banner_image,
            'website_banner' => $website_banner_image,
            'website_favicon' => $website_favicon_image,
             'email' => 'info@edenparking.co.uk',
            'alternate_email' => 'edenparking@hotmail.com',
            'contact_num' => '+1 800 345 678',
            'alternate_contact_num' => '+1 800 345 678',
            'address' => 'Eden Parking, Unit 1 Railway House, 14 Chertsey Road, Woking, Surrey, GU21 5AH',
            'working_time' => 'Mon-Fri 09.00 - 17.00',
            'facebook' => 'https://www.facebook.com/Eden-Parking-188120945007064/',
            'twitter' => 'https://twitter.com/edenparking',
            'website_meta_title' => 'Eden Parking Airport Parking Service',
            'website_meta_description' => 'WHY CHOOSE US?No hidden chargesSecure car parkFully insured driver’sSecure online booking BOOK NOW PAY LATERAt Eden Parking we offer a service that allows you to book now and pay later. You book via our site and when you arrive at the airport for departure you pay the full amount in cash . before departure',
            'website_meta_keywords' => 'Parking Airport Parking Service , edenparking',
        ]);

        $isReportCreated = $website->save();
        if ($isReportCreated) {
            $Savedwebsite_id = $website->id;

            /*--- RegularPrices*/
            $terminals_without_website = RegularPrices::where('website_id', '!=', $Savedwebsite_id)->orderBy('website_id', 'asc')->groupBy('terminal_id', 'service_id')->get();
            if (!empty($terminals_without_website)) {
                foreach ($terminals_without_website as $tww) {
                    $found = RegularPrices::where('terminal_id', '=', $tww->terminal_id)->where('service_id', '=', $tww->service_id)->where('website_id', '=', 1)->firstOrFail();
                    if ($found) {
                        $replicated = $found->replicate();
                        $replicated->website_id = $Savedwebsite_id;
                        $replicated->save();
                    }

                }
            }
            /*--- RegularPrices*/

           


            /*--- FIXPRICE EDIT*/
            /*$fixedprice_terminals_without_website = FixedPrices::where('website_id', '!=', $Savedwebsite_id)->whereIn('service_id',array('1','2','3','4'))->orderBy('website_id', 'asc')->groupBy('terminal_id', 'service_id')->get();
            if (!empty($fixedprice_terminals_without_website)) {
                foreach ($fixedprice_terminals_without_website as $tww) {
                    $found = FixedPrices::where('terminal_id', '=', $tww->terminal_id)->where('service_id', '=', $tww->service_id)->firstOrFail();
                    if ($found) {
                        $replicated = $found->replicate();
                        $replicated->website_id = $Savedwebsite_id;
                        $replicated->save();
                    }
                }
            }*/
             /*--- FIXPRICE EDIT*/

            /*--- RegularDiscounts*/
            $reg_disc_terminals_without_website = RegularDiscounts::where('website_id', '!=', $Savedwebsite_id)->groupBy('terminal_id')->get();
            if (!empty($reg_disc_terminals_without_website)) {
                foreach ($reg_disc_terminals_without_website as $tww) {
                    $found = RegularDiscounts::where('terminal_id', '=', $tww->terminal_id)->where('website_id', '=', 1)->firstOrFail();
                    if ($found) {
                        $replicated = $found->replicate();
                        $replicated->website_id = $Savedwebsite_id;
                        $replicated->save();
                    }


                }
            }
            /*--- RegularDiscounts*/


            

            /*--- News*/
            // $news1 = News::where('website_id', '=', 1)->get();
            // if (!empty($news1)) {
            //     foreach ($news1 as $news) {
            //         $found = News::where('id', '=', $news->id)->firstOrFail();
            //         if ($found) {
            //             $replicated = $found->replicate();
            //             $replicated->website_id = $Savedwebsite_id;
            //             $replicated->save();
            //         }


            //     }
            // }
            /*--- News*/


            /*--- Banners*/
            $banners = Banner::where('website_id', '=', 1)->get();
            if (!empty($banners)) {
                // foreach ($banners as $banner) {
                //     $found = Banner::where('id', '=', $banner->id)->firstOrFail();
                //     if ($found) {
                //         $replicated = $found->replicate();
                //         $replicated->website_id = $Savedwebsite_id;
                //         $replicated->save();
                //     }
                // }
            }
            /*--- Banners*/


            /*Carwash*/
            $vehicaltype = VehicalType::all();
            $websites = Website::all();
            $wash_types = array(
                'carwash_in_and_out' => 12,
                'carwash_out_only'=> 12,
                'carwash_in_only'=> 12,
                'carwash_spray_only'=> 12
            );
            foreach ($websites as $www){
                foreach ($vehicaltype as $vvv){
                    $kkk[$www->id][$vvv->id] = $wash_types;
                }
    
            }
            $c=0;
            foreach ($kkk as $wid=>$item){
    
                foreach ($item as $tyid=>$tyy) {
    
                    foreach ($tyy as $wash_type=>$price) {
                        if (!CarWash::where('website_id', $wid)->where('vehical_type_id', $tyid)->where('car_wash_type', $wash_type)->exists()) {
                            $carwash = new CarWash([
                                'website_id' => $wid,
                                'vehical_type_id' => $tyid,
                                'car_wash_type' => $wash_type,
                                'car_wash_price' => $price,
                            ]);
                            $carwash->save();
                          $c++;
                        } else {
    
                        }
    
    
                    }
                }
            }
            /*carwash*/
        }

        return redirect('/admin/camparsionwebsites')->with('success', 'website Added');
    }

    public function updateinline(Request $request, $id)
    {
        $column_name = $request->name;
        $column_value = $request->value;
        if ($request->name && $request->value) {
            $test = Website::select()
                ->where('id', '=', $id)
                ->update([$column_name => $column_value]);
            return response()->json(['code' => 200], 200);
        }

        return response()->json(['error' => 400, 'message' => 'Not enought params'], 400);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $website = Website::where('id', $id)
            ->first();

        return view('admin.camparsionwebsites.edit', compact('website', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //dd($request);
        $request->validate([
            'website_name' => 'required',
            'website_url' => 'required',
            //'website_prefix' => 'required',
        ]);


        $website_logo = $request->file('website_logo');
        if (!empty($website_logo)) {
            /*$extension = $website_logo->getClientOriginalExtension();
            Storage::disk('public')->put($website_logo->getFilename() . '.' . $extension, File::get($website_logo));
            $website_logo_image = $website_logo->getFilename() . '.' . $extension;*/

            $filenameWithExt = $request->file('website_logo')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('website_logo')->getClientOriginalExtension();
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            $website_logo_image = $fileNameToStore;
            $request->file('website_logo')->storeAs('public/uploads', $fileNameToStore);
            //Domain::copy_images_to_public($fileNameToStore);
        } else {
            $website_logo_image = '';
        }

        /* -- website_email_banner --- */
        $website_email_banner = $request->file('website_email_banner');
        if (!empty($website_email_banner)) {
            /*$extension = $website_email_banner->getClientOriginalExtension();
            Storage::disk('public')->put($website_email_banner->getFilename() . '.' . $extension, File::get($website_email_banner));
            $website_email_banner_image = $website_email_banner->getFilename() . '.' . $extension;*/

            $filenameWithExt = $request->file('website_email_banner')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('website_email_banner')->getClientOriginalExtension();
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            $website_email_banner_image = $fileNameToStore;
            $request->file('website_email_banner')->storeAs('public/uploads', $fileNameToStore);
            //Domain::copy_images_to_public($fileNameToStore);

        } else {
            $website_email_banner_image = '';
        }
        /* -- website_email_banner --- */

        $website_banner_image = $request->file('website_banner');
        if (!empty($website_banner_image)) {
            /*$extension = $website_banner->getClientOriginalExtension();
            Storage::disk('public')->put($website_banner->getFilename() . '.' . $extension, File::get($website_banner));
            $website_banner_image = $website_banner->getFilename() . '.' . $extension;*/

            $filenameWithExt = $request->file('website_banner')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('website_banner')->getClientOriginalExtension();
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            $website_banner_image = $fileNameToStore;
            $request->file('website_banner')->storeAs('public/uploads', $fileNameToStore);
            //Domain::copy_images_to_public($fileNameToStore);

        } else {
            $website_banner_image = 'phpA46F.tmp.gif';
        }

        $website_favicon = $request->file('website_favicon');
        if (!empty($website_favicon)) {
            /*$extension = $website_favicon->getClientOriginalExtension();
            Storage::disk('public')->put($website_favicon->getFilename() . '.' . $extension, File::get($website_favicon));
            $website_favicon_image = $website_favicon->getFilename() . '.' . $extension;*/

            $filenameWithExt = $request->file('website_favicon')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('website_favicon')->getClientOriginalExtension();
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            $website_favicon_image = $fileNameToStore;
            $request->file('website_favicon')->storeAs('public/uploads', $fileNameToStore);
            //Domain::copy_images_to_public($fileNameToStore);

        } else {
            $website_favicon_image = "";
        }


        $website = Website::find($id);
        //$website->website_prefix = $request->get('website_prefix');
        $website->website_prefix = "";
        $website->website_templete = $request->get('website_templete');
        $website->website_url = $request->get('website_url');
        $website->website_name = $request->get('website_name');

        $website->email = $request->get('email');
        $website->alternate_email = $request->get('alternate_email');
        $website->contact_num = $request->get('contact_num');
        $website->alternate_contact_num = $request->get('alternate_contact_num');
        $website->address = $request->get('address');
        $website->working_time = $request->get('working_time');
        $website->facebook = $request->get('facebook');
        $website->twitter = $request->get('twitter');

        $website->website_meta_title = $request->get('website_meta_title');
        $website->website_meta_description = $request->get('website_meta_description');
        $website->website_meta_keywords = $request->get('website_meta_keywords');
        if (!empty($website_favicon_image)) {
            $website->website_favicon = $website_favicon_image;
        }
        if (!empty($website_logo)) {
            $website->website_logo = $website_logo_image;
        }
        if (!empty($website_banner_image)) {
            $website->website_banner = $website_banner_image;
        }
        if (!empty($website_email_banner_image)) {
            $website->website_email_banner = $website_email_banner_image;
        }

        $website->save();

        return redirect('/admin/camparsionwebsites')->with('success', 'website has been updated');

    }

    public function delete($id)
    {
        Website::find($id)->delete($id);
        RegularDiscounts::where('website_id', $id)->delete();
        RegularPrices::where('website_id', $id)->delete();
        Banner::where('website_id', $id)->delete();
        FixedPrices::where('website_id', $id)->delete();
        Reviews::where('website_id', $id)->delete();
        News::where('website_id', $id)->delete();
        CarWash::where('website_id', $id)->delete();
        NotWorkingHours::where('website_id', $id)->delete();
        PromotionOffer::where('website_id', $id)->delete();
        Settings::where('website_id', $id)->delete();
        
//             $RegularDiscounts = RegularDiscounts::where('website_id', $id)->firstOrFail();
//             if($RegularDiscounts) {
//                 $RegularDiscounts->delete();
//             }

        return response()->json([
            'success' => 'Record deleted successfully!',
            'id' => $id
        ]);

    }
}
