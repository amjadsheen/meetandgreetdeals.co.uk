<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Classes\Coupon;
use App\PromotionOffer;
use App\PromotionCompany;
use App\PromotionOfferCustomer;
use App\Website;

class PromotionOfferController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $title = "Promotion Offers";

        $websites = Website::all('id', 'website_name');
        // echo "<pre>";  print_r(array()$websites);echo "</pre>";
        foreach ($websites as $website) {
            $websites_json[] = array('value' => $website->id, 'text' => $website->website_name);
        }
        $websites_json = json_encode($websites_json);


        $companies = PromotionCompany::all();
        foreach ($companies as $company) {
            $company_json[] = array('value' => $company->id, 'text' => $company->company_name);
        }
        $company_json = json_encode($company_json);

        if (request()->has('filter_website') && (!empty(request()->input('filter_website')))) {
            $filter_website = request()->input('filter_website');
            $promotions[] = DB::table("promotion_offers as offer")
                ->leftJoin("promotion_companies as company", "company.id", "=", "offer.promotion_company_id")
                ->leftJoin("websites as site", "site.id", "=", "offer.website_id")
                ->where('offer.website_id', $filter_website)
                ->select("offer.*",
                    DB::raw("DATE_FORMAT(offer.offer_date1, '%d/%m/%Y') as offer_date1"),
                    DB::raw("DATE_FORMAT(offer.offer_date2, '%d/%m/%Y') as offer_date2"),
                    "company.company_name", "company.id As company_id", "site.website_name")
                ->get();
        } else {
            $filter_website = 1;
            $promotions[] = DB::table("promotion_offers as offer")
                ->leftJoin("promotion_companies as company", "company.id", "=", "offer.promotion_company_id")
                ->leftJoin("websites as site", "site.id", "=", "offer.website_id")
                //->where('offer.website_id', $filter_website)
                ->select("offer.*",
                    DB::raw("DATE_FORMAT(offer.offer_date1, '%d/%m/%Y') as offer_date1"),
                    DB::raw("DATE_FORMAT(offer.offer_date2, '%d/%m/%Y') as offer_date2"),
                    "company.company_name", "company.id As company_id", "site.website_name")
                ->get();
        }


        foreach ($promotions as $promotion) {
            foreach ($promotion as $single) {
                $used_promos = DB::table("promotion_offer_customers")
                    ->where('promotion_offer_id', $single->id)
                    ->select("*")
                    ->count();
                $single->used_count = $used_promos;
            }
        }

        return view('admin.offers.index', compact('companies', 'company_json', 'promotions', 'websites', 'websites_json', 'title', 'filter_website'));

    }


    public function store(Request $request)
    {

        $request->validate([
            'website_id' => 'required',
            'offer_date1' => 'required',
            'offer_date2' => 'required',
            'offer_percentage' => 'required',
            'num_of_coupon' => 'required',
        ]);
        $num_of_coupon = $request->get('num_of_coupon');
        $coupons = Coupon::generate_coupons($num_of_coupon);

        $count = 0;
        foreach ($coupons as $key => $val) {
            $exist = PromotionOffer::select('id')->where('offer_coupon', $val)->get()->toArray();
            if (empty($exist)) {
                $data = array(
                    'website_id' => $request->get('website_id'),
                    'offer_coupon' => $val,
                    'promotion_company_id' => $request->get('promotion_company_id'),
                    'offer_date1' => $request->get('offer_date1'),
                    'offer_date2' => $request->get('offer_date2'),
                    'offer_percentage' => $request->get('offer_percentage'),
                    'offer_auto_generted' => 1
                );
                PromotionOffer::insert($data);
                $count++;
            }

        }
        return redirect('/admin/promotion-offers')->with('success', ' ' . $count . ' Coupons Created');
    }

    public function updateinline(Request $request, $id)
    {


        $column_name = $request->name;
        $column_value = $request->value;
        $filter_website = $request->website;
        if ($request->name) {
            //offer_special
            //offer_home
            if ($column_name == 'offer_home' && $column_value == 1) {
                // $update_other_rows = PromotionOffer::select()->where($column_name, '=', 1)->where('website_id', $filter_website)->update([$column_name => 0]);
                $update_other_rows = PromotionOffer::select()->where('offer_home', '=', 1)->update(['offer_home' => 0]);
            }
            if ($column_name == 'show_compare_page' && $column_value == 1) {
                $promotionOffer = PromotionOffer::find($id);
                //if ($promotionOffer) {
                    // Update other rows for the same website
                    PromotionOffer::where('website_id', '=', $promotionOffer->website_id)->update(['show_compare_page' => 0]);
                    // Update the selected row
                    //$promotionOffer->update([$column_name => $column_value]);
    
                    //return response()->json(['success' => 200, 'message' => 'Updated successfully']);
                //}
            }
            if ($column_name == 'offer_special' && $column_value == 1) {
                // $update_other_rows = PromotionOffer::select()->) {
                // $update_other_rows = PromotionOffer::select()->where($column_name, '=', 1)->where('website_id', $filter_website)->update([$column_name => 0]);
                $update_other_rows = PromotionOffer::select()->where('offer_special', '=', 1)->update(['offer_special' => 0]);
            }
            $update = PromotionOffer::select()->where('id', '=', $id)->update([$column_name => $column_value]);
            return response()->json(['code' => 200], 200);
        }

        return response()->json(['error' => 400, 'message' => 'Not enought params'], 400);
    }

    public function delete($id)
    {
        PromotionOffer::find($id)->delete($id);
        return response()->json([
            'success' => 'Record deleted successfully!',
            'id' => $id
        ]);
    }

    public function getcustomers($id)
    {
        $used_promos = DB::table("promotion_offer_customers")
            ->where('promotion_offer_id', $id)
            ->select("*")
            ->get();
        foreach ($used_promos as $used_promo) {
            echo "<tr>
               <td>$used_promo->customer_booking_ref</td>
               <td>$used_promo->customer_name</td>
               <td>$used_promo->customer_email</td>
               <td>$used_promo->customer_contact1</td>
               <td>$used_promo->customer_contact2</td>
               <td>$used_promo->customer_car_reg</td>
               <td>$used_promo->promo_used_date</td>
           </tr>";
        }
    }
}
