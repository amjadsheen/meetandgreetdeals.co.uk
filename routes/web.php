<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/clear', function() {
   Artisan::call('storage:link');
Artisan::call('config:clear');
   Artisan::call('cache:clear');
  // Artisan::call('config:clear');
   // Artisan::call('view:clear');
   // Artisan::call('storage:link');
    
   return "Cleared!";

});
//Route::get('/', function () {
//    return view('frontend.home');
//});


//Front-end Routes
Route::get('/', 'Frontend\FrontendController@index');
Route::get('/about-us', 'Frontend\AboutController@index');
Route::get('/pay-later', 'Frontend\AboutController@paylater');
Route::get('/faq', 'Frontend\FaqController@index');
Route::get('/terms-conditions', 'Frontend\TermsController@index');
Route::get('contact-us', 'Frontend\ContactController@index');
Route::post('contact-us', 'Frontend\ContactController@store');
Route::get('/directions', 'Frontend\DirectionsController@index');
Route::get('/directions/{slug}', 'Frontend\DirectionsDetailController@index');

Route::get('/services', 'Frontend\ServicesController@index');
Route::get('/services/{slug}', 'Frontend\ServicesDetailController@index');
Route::get('/reviews', 'Frontend\ReviewController@index');
Route::post('reviews', 'Frontend\ReviewController@ajaxRequestPost');

Route::resource('bookingedit', 'Frontend\BookingEditController');

Route::resource('booking', 'Frontend\BookingController');
Route::get('/compare-booking', 'Frontend\BookingController@CompareBooking');
Route::post('/update-vehicle-date', 'Frontend\BookingController@updateVehicleDate');

Route::get('/confirm-booking', 'Frontend\BookingController@Checkout');
Route::get('/getTerminals/{id}', 'Frontend\BookingController@getTerminals');
Route::get('/getairorts/{id}', 'Frontend\BookingController@getairorts');
Route::get('/addcarwash', 'Frontend\BookingController@addcarwash');
Route::get('/updatecharging', 'Frontend\BookingController@updatecharging');
Route::get('/getcarwashhtml', 'Frontend\BookingController@getcarwashhtml');
Route::get('/getcarwashhtmleditpage', 'Frontend\BookingController@getcarwashhtmleditpage');


Route::get('/getprice', 'Frontend\BookingController@getprice');
Route::get('/getallservicesprice', 'Frontend\BookingController@getallservicesprice');

Route::get('/gettef', 'Frontend\BookingController@gettef');
Route::get('/getDiscountCouponVip', 'Frontend\BookingController@getDiscountCouponVip');
Route::get('/booknow', 'Frontend\BookingController@index');

Route::get('/logincustomers', 'Frontend\CustomersController@logincustomers');
Route::get('/reset_customer_password', 'Frontend\CustomersController@reset_customer_password');

Route::get('/booking-confirm', 'Frontend\BookingController@bookingconfirm');
Route::get('/addpromocode', 'Frontend\BookingController@addpromocode');
Route::get('/booking-confirmation', 'Frontend\BookingController@bookingconfirmation');

Route::get('/customer-login', 'Frontend\CustomersController@customer_login');
Route::get('/customer-logout', 'Frontend\CustomersController@customer_logout');
Route::get('/customer-register', 'Frontend\CustomersController@customer_register');

Route::get('/profile', 'Frontend\CustomersController@profile');
Route::get('/edit-profile', 'Frontend\CustomersController@editprofile');
Route::get('/updateprofile', 'Frontend\CustomersController@updateprofile');
Route::get('/sign-up', 'Frontend\CustomersController@register');
Route::get('/registercustomer', 'Frontend\CustomersController@registercustomer');
Route::get('/my-bookings', 'Frontend\CustomersController@my_bookings');
//Admin

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Auth::routes();

Route::redirect('/register', '/login'); // new added by amjad

Route::get('/user', 'Admin\UserController@index')->name('user')->middleware('user');
Route::get('/admin', 'Admin\AdminController@index')->name('admin')->middleware('admin');
Route::get('/superadmin', 'Admin\SuperAdminController@index')->name('superadmin')->middleware('superadmin');


//Route::get('/admin/profile', 'Admin\ProfileController@index')->name('admin')->middleware('admin');
Route::resource('/admin/profile', 'Admin\ProfileController')->middleware('admin');
/* ------------ country -------------- */
Route::resource('/admin/country', 'Admin\CountryController')->middleware('admin');
Route::post('/admin/country/updateinline/{id}', ['as' => 'country/updateinline', 'uses' => 'Admin\CountryController@updateinline'])->middleware('admin');
Route::post('/admin/country/delete/{id}', ['as' => 'country/delete', 'uses' => 'Admin\CountryController@delete'])->middleware('admin');
/* ------------ country -------------- */

/* ------------ Airport -------------- */
Route::resource('/admin/airport', 'Admin\AirportController')->middleware('admin');
Route::post('/admin/airport/updateinline/{id}', ['as' => 'airport/updateinline', 'uses' => 'Admin\AirportController@updateinline'])->middleware('admin');
Route::post('/admin/airport/delete/{id}', ['as' => 'airport/delete', 'uses' => 'Admin\AirportController@delete'])->middleware('admin');
/* ------------ Airport -------------- */

/* ------------ Terminals -------------- */
Route::resource('/admin/terminal', 'Admin\TerminalController')->middleware('admin');
Route::post('/admin/terminal/updateinline/{id}', ['as' => 'terminal/updateinline', 'uses' => 'Admin\TerminalController@updateinline'])->middleware('admin');
Route::post('/admin/terminal/delete/{id}', ['as' => 'terminal/delete', 'uses' => 'Admin\TerminalController@delete'])->middleware('admin');
/* ------------ Terminals -------------- */


/* ------------ Terminal Charges -------------- */
Route::resource('/admin/terminal-charges', 'Admin\TerminalChargesController')->middleware('admin');
Route::post('/admin/terminal-charges/updateinline/{id}', ['as' => 'terminal-charges/updateinline', 'uses' => 'Admin\TerminalChargesController@updateinline'])->middleware('admin');
Route::post('/admin/terminal-charges/delete/{id}', ['as' => 'terminal-charges/delete', 'uses' => 'Admin\TerminalChargesController@delete'])->middleware('admin');
/* ------------ Terminals Charges -------------- */


/* ------------ Colors -------------- */
Route::resource('/admin/color', 'Admin\ColorController')->middleware('admin');
Route::post('/admin/color/updateinline/{id}', ['as' => 'color/updateinline', 'uses' => 'Admin\ColorController@updateinline'])->middleware('admin');
Route::post('/admin/color/delete/{id}', ['as' => 'color/delete', 'uses' => 'Admin\ColorController@delete'])->middleware('admin');
/* ------------ Colors -------------- */


/* ------------ Booking Edit Fix Prices -------------- */
Route::resource('/admin/booking-edit-fix-prices', 'Admin\FixedPricesController')->middleware('admin');
Route::post('/admin/booking-edit-fix-prices/updateinline/{id}', ['as' => 'booking-edit-fix-prices/updateinline', 'uses' => 'Admin\FixedPricesController@updateinline'])->middleware('admin');
//Route::post('/admin/booking-edit-fix-prices/delete/{id}', ['as' => 'booking-edit-fix-prices/delete', 'uses' => 'Admin\FixedPricesController@delete'])->middleware('admin');
Route::post('/admin/booking-edit-fix-prices/autogenerate', 'Admin\FixedPricesController@autogenerate');
Route::post('/admin/booking-edit-fix-prices/autogeneratefixedprices', 'Admin\FixedPricesController@autogeneratefixedprices');
/* ------------ Booking Edit Fix Prices -------------- */

/* ------------ price regular -------------- */
Route::resource('/admin/regular-prices', 'Admin\ReqularPricesController')->middleware('admin');
Route::post('/admin/regular-prices/updateinline/{id}', ['as' => 'regular-prices/updateinline', 'uses' => 'Admin\ReqularPricesController@updateinline'])->middleware('admin');
//Route::post('/admin/regular-prices/delete/{id}', ['as' => 'regular-prices/delete', 'uses' => 'Admin\ReqularPricesController@delete'])->middleware('admin');
Route::post('/admin/regular-prices/autogenerate', 'Admin\ReqularPricesController@autogenerate');
Route::post('/admin/regular-prices/autogeneratefixedprices', 'Admin\ReqularPricesController@autogeneratefixedprices');

/* ------------ price regular -------------- */

/* ------------ price vip -------------- */
Route::resource('/admin/vip-prices', 'Admin\VipPricesController')->middleware('admin');
Route::post('/admin/vip-prices/updateinline/{id}', ['as' => 'vip-prices/updateinline', 'uses' => 'Admin\VipPricesController@updateinline'])->middleware('admin');
//Route::post('/admin/vip-prices/delete/{id}', ['as' => 'vip-prices/delete', 'uses' => 'Admin\VipPricesController@delete'])->middleware('admin');
Route::post('/admin/vip-prices/autogenerate', 'Admin\VipPricesController@autogenerate');
Route::post('/admin/vip-prices/autogeneratefixedprices', 'Admin\VipPricesController@autogeneratefixedprices');
/* ------------ price vip -------------- */

/* ------------ coupon discount regular -------------- */
Route::resource('/admin/regular-discounts', 'Admin\RegularDiscountsController')->middleware('admin');
Route::post('/admin/regular-discounts/updateinline/{id}', ['as' => 'regular-discounts/updateinline', 'uses' => 'Admin\RegularDiscountsController@updateinline'])->middleware('admin');
Route::post('/admin/regular-discounts/autogenerate', 'Admin\RegularDiscountsController@autogenerate');
/* ------------ coupon discount regular -------------- */

/* ------------ coupon discount vip -------------- */
Route::resource('/admin/vip-discounts', 'Admin\VipDiscountsController')->middleware('admin');
Route::post('/admin/vip-discounts/updateinline/{id}', ['as' => 'vip-discounts/updateinline', 'uses' => 'Admin\VipDiscountsController@updateinline'])->middleware('admin');
/* ------------ coupon discount vip -------------- */


/* ------------ Promotion company -------------- */
Route::resource('/admin/promotion-companies', 'Admin\PromotionCompanyController')->middleware('admin');
Route::post('/admin/promotion-companies/updateinline/{id}', ['as' => 'promotion-companies/updateinline', 'uses' => 'Admin\PromotionCompanyController@updateinline'])->middleware('admin');
Route::post('/admin/promotion-companies/delete/{id}', ['as' => 'promotion-companies/delete', 'uses' => 'Admin\PromotionCompanyController@delete'])->middleware('admin');
/* ------------ Promotion company  -------------- */

/* ------------ Promotion offer -------------- */
Route::resource('/admin/promotion-offers', 'Admin\PromotionOfferController')->middleware('admin');
Route::post('/admin/promotion-offers/updateinline/{id}', ['as' => 'promotion-offers/updateinline', 'uses' => 'Admin\PromotionOfferController@updateinline'])->middleware('admin');
Route::post('/admin/promotion-offers/delete/{id}', ['as' => 'promotion-offers/delete', 'uses' => 'Admin\PromotionOfferController@delete'])->middleware('admin');
Route::post('/admin/promotion-offers/getcustomers/{id}', ['as' => 'promotion-offers/getcustomers', 'uses' => 'Admin\PromotionOfferController@getcustomers'])->middleware('admin');

/* ------------ Promotion offer  -------------- */


/* ------------ currencies -------------- */
Route::resource('/admin/currencies', 'Admin\CurrencyController')->middleware('admin');
Route::post('/admin/currencies/updateinline/{id}', ['as' => 'currencies/updateinline', 'uses' => 'Admin\CurrencyController@updateinline'])->middleware('admin');
Route::post('/admin/currencies/delete/{id}', ['as' => 'currencies/delete', 'uses' => 'Admin\CurrencyController@delete'])->middleware('admin');
/* ------------ currencies  -------------- */


/* ------------ websites -------------- */
Route::resource('/admin/websites', 'Admin\WebsiteController')->middleware('admin');
Route::post('/admin/websites/updateinline/{id}', ['as' => 'websites/updateinline', 'uses' => 'Admin\WebsiteController@updateinline'])->middleware('admin');
Route::post('/admin/websites/delete/{id}', ['as' => 'websites/delete', 'uses' => 'Admin\WebsiteController@delete'])->middleware('admin');
/* ------------ websites  -------------- */

/* ------------ camparsionwebsites -------------- */
Route::resource('/admin/camparsionwebsites', 'Admin\CamparsionWebsiteController')->middleware('admin');
Route::post('/admin/camparsionwebsites/updateinline/{id}', ['as' => 'camparsionwebsites/updateinline', 'uses' => 'Admin\CamparsionWebsiteController@updateinline'])->middleware('admin');
Route::post('/admin/camparsionwebsites/delete/{id}', ['as' => 'camparsionwebsites/delete', 'uses' => 'Admin\CamparsionWebsiteController@delete'])->middleware('admin');
/* ------------ /camparsionwebsites  -------------- */

/* ------------ faq -------------- */
Route::resource('/admin/faqs', 'Admin\FaqController')->middleware('admin');
Route::post('/admin/faqs/updateinline/{id}', ['as' => 'faqs/updateinline', 'uses' => 'Admin\FaqController@updateinline'])->middleware('admin');
Route::post('/admin/faqs/delete/{id}', ['as' => 'faqs/delete', 'uses' => 'Admin\FaqController@delete'])->middleware('admin');
/* ------------ faq  -------------- */

/* ------------ Review -------------- */
Route::resource('/admin/reviews', 'Admin\ReviewController')->middleware('admin');
Route::post('/admin/reviews/updateinline/{id}', ['as' => 'reviews/updateinline', 'uses' => 'Admin\ReviewController@updateinline'])->middleware('admin');
Route::post('/admin/reviews/delete/{id}', ['as' => 'reviews/delete', 'uses' => 'Admin\ReviewController@delete'])->middleware('admin');
Route::post('/admin/reviews/import', 'Admin\ReviewController@import');
/* ------------ Review  -------------- */


/* ------------ banners -------------- */
Route::resource('/admin/banner', 'Admin\BannerController')->middleware('admin');
Route::post('/admin/banner/updateinline/{id}', ['as' => 'banner/updateinline', 'uses' => 'Admin\BannerController@updateinline'])->middleware('admin');
Route::post('/admin/banner/delete/{id}', ['as' => 'banner/delete', 'uses' => 'Admin\BannerController@delete'])->middleware('admin');
Route::post('/admin/banner/autogenerate', 'Admin\BannerController@autogenerate');
/* ------------ banners  -------------- */


/* ------------ directions -------------- */
Route::resource('/admin/directions', 'Admin\DirectionController')->middleware('admin');
Route::post('/admin/directions/updateinline/{id}', ['as' => 'directions/updateinline', 'uses' => 'Admin\DirectionController@updateinline'])->middleware('admin');
Route::post('/admin/directions/delete/{id}', ['as' => 'directions/delete', 'uses' => 'Admin\DirectionController@delete'])->middleware('admin');
/* ------------ directions  -------------- */

/* ------------ pages -------------- */
Route::resource('/admin/pages', 'Admin\PageController')->middleware('admin');
Route::post('/admin/pages/updateinline/{id}', ['as' => 'pages/updateinline', 'uses' => 'Admin\PageController@updateinline'])->middleware('admin');
Route::post('/admin/pages/delete/{id}', ['as' => 'pages/delete', 'uses' => 'Admin\PageController@delete'])->middleware('admin');
/* ------------ pages  -------------- */


/* ------------ customers -------------- */
Route::resource('/admin/customers', 'Admin\CustomerController')->middleware('admin');
Route::post('/admin/customers/updateinline/{id}', ['as' => 'customers/updateinline', 'uses' => 'Admin\CustomerController@updateinline'])->middleware('admin');
Route::post('/admin/customers/delete/{id}', ['as' => 'customers/delete', 'uses' => 'Admin\CustomerController@delete'])->middleware('admin');
Route::post('/admin/customers/getcustomer/{id}', ['as' => 'customers/getcustomer', 'uses' => 'Admin\CustomerController@getcustomer'])->middleware('admin');

/* ------------ customers  -------------- */


// Route::get('/home', 'AcademicController@index')->name('home');



/* ------------ News -------------- */
Route::resource('/admin/news', 'Admin\NewsController')->middleware('admin');
Route::post('/admin/news/updateinline/{id}', ['as' => 'news/updateinline', 'uses' => 'Admin\NewsController@updateinline'])->middleware('admin');
Route::post('/admin/news/delete/{id}', ['as' => 'news/delete', 'uses' => 'Admin\NewsController@delete'])->middleware('admin');
/* ------------ /News -------------- */


/* ------------ Services -------------- */
Route::resource('/admin/services', 'Admin\ServicesController')->middleware('admin');
Route::post('/admin/services/updateinline/{id}', ['as' => 'services/updateinline', 'uses' => 'Admin\ServicesController@updateinline'])->middleware('admin');
Route::post('/admin/services/delete/{id}', ['as' => 'services/delete', 'uses' => 'Admin\ServicesController@delete'])->middleware('admin');
/* ------------ /Services  -------------- */


/* ------------ Settings -------------- */
Route::resource('/admin/settings', 'Admin\SettingsController')->middleware('admin');
Route::post('/admin/settings/updateinline/{id}', ['as' => 'settings/updateinline', 'uses' => 'Admin\SettingsController@updateinline'])->middleware('admin');
Route::post('/admin/settings/updateinline_lastminutebookings/{id}', ['as' => 'settings/updateinline_lastminutebookings', 'uses' => 'Admin\SettingsController@updateinline_lastminutebookings'])->middleware('admin');
Route::post('/admin/settings/delete/{id}', ['as' => 'settings/delete', 'uses' => 'Admin\SettingsController@delete'])->middleware('admin');
/* ------------ /Settings  -------------- */

/* ------------ PaymentLink -------------- */
Route::resource('/admin/paymentlink', 'Admin\PaymentLinkController')->middleware('admin');
/* ------------ /PaymentLink  -------------- */

/* ------------ GlobalSettings -------------- */
Route::resource('/admin/globalsettings', 'Admin\GlobalSettingsController')->middleware('admin');
Route::post('/admin/globalsettings/updateinline/{id}', ['as' => 'globalsettings/updateinline', 'uses' => 'Admin\GlobalSettingsController@updateinline'])->middleware('admin');
Route::post('/admin/globalsettings/delete/{id}', ['as' => 'globalsettings/delete', 'uses' => 'Admin\SGlobalSettingsontroller@delete'])->middleware('admin');
/* ------------ /GlobalSettings  -------------- */

/* ------------ blacklists -------------- */
Route::resource('/admin/blacklists', 'Admin\BlacklistsController')->middleware('admin');
Route::post('/admin/blacklists/updateinline/{id}', ['as' => 'blacklists/updateinline', 'uses' => 'Admin\BlacklistsController@updateinline'])->middleware('admin');
Route::post('/admin/blacklists/delete/{id}', ['as' => 'blacklists/delete', 'uses' => 'Admin\BlacklistsController@delete'])->middleware('admin');
/* ------------ /blacklists  -------------- */

/* ------------ customeraccounts -------------- */
Route::resource('/admin/customeraccounts', 'Admin\CustomerAccountsController')->middleware('admin');
Route::post('/admin/customeraccounts/updateinline/{id}', ['as' => 'customeraccounts/updateinline', 'uses' => 'Admin\CustomerAccountsController@updateinline'])->middleware('admin');
Route::post('/admin/customeraccounts/delete/{id}', ['as' => 'customeraccounts/delete', 'uses' => 'Admin\CustomerAccountsController@delete'])->middleware('admin');
/* ------------ /customeraccounts  -------------- */


/* ------------ yards -------------- */
Route::resource('/admin/yards', 'Admin\YardsController')->middleware('admin');
Route::post('/admin/yards/updateinline/{id}', ['as' => 'yards/updateinline', 'uses' => 'Admin\YardsController@updateinline'])->middleware('admin');
Route::post('/admin/yards/delete/{id}', ['as' => 'yards/delete', 'uses' => 'Admin\YardsController@delete'])->middleware('admin');
/* ------------ /yards  -------------- */



/* ------------ locations -------------- */
Route::resource('/admin/locations', 'Admin\LocationsController')->middleware('admin');
Route::post('/admin/locations/updateinline/{id}', ['as' => 'locations/updateinline', 'uses' => 'Admin\LocationsController@updateinline'])->middleware('admin');
Route::post('/admin/locations/delete/{id}', ['as' => 'locations/delete', 'uses' => 'Admin\LocationsController@delete'])->middleware('admin');
Route::get('/admin/locations/getyards/{id}', 'Admin\LocationsController@getyards')->middleware('admin');
/* ------------ /locations  -------------- */



/* ------------ Agents -------------- */
Route::resource('/admin/agents', 'Admin\AgentsController')->middleware('admin');
Route::post('/admin/agents/updateinline/{id}', ['as' => 'agents/updateinline', 'uses' => 'Admin\AgentsController@updateinline'])->middleware('admin');
Route::post('/admin/agents/delete/{id}', ['as' => 'agents/delete', 'uses' => 'Admin\AgentsController@delete'])->middleware('admin');
/* ------------ /Agents  -------------- */


/* ------------ Drivers -------------- */
Route::resource('/admin/drivers', 'Admin\DriversController')->middleware('admin');
Route::post('/admin/drivers/updateinline/{id}', ['as' => 'drivers/updateinline', 'uses' => 'Admin\DriversController@updateinline'])->middleware('admin');
Route::post('/admin/drivers/delete/{id}', ['as' => 'drivers/delete', 'uses' => 'Admin\DriversController@delete'])->middleware('admin');
/* ------------ /Drivers  -------------- */




/* ------------ CarWash -------------- */
Route::resource('/admin/carwash', 'Admin\CarWashController')->middleware('admin');
Route::post('/admin/carwash/updateinline/{id}', ['as' => 'carwash/updateinline', 'uses' => 'Admin\CarWashController@updateinline'])->middleware('admin');
Route::post('/admin/carwash/delete/{id}', ['as' => 'carwash/delete', 'uses' => 'Admin\CarWashController@delete'])->middleware('admin');
Route::post('/admin/carwash/autogenerate', 'Admin\CarWashController@autogenerate');
/* ------------ /CarWash  -------------- */

/* ------------ VehicalType -------------- */
Route::resource('/admin/vehicaltype', 'Admin\VehicalTypeController')->middleware('admin');
Route::post('/admin/vehicaltype/updateinline/{id}', ['as' => 'vehicaltype/updateinline', 'uses' => 'Admin\VehicalTypeController@updateinline'])->middleware('admin');
Route::post('/admin/vehicaltype/delete/{id}', ['as' => 'vehicaltype/delete', 'uses' => 'Admin\VehicalTypeController@delete'])->middleware('admin');
/* ------------ /VehicalType  -------------- */

/* ------------ Hotels -------------- */
Route::resource('/admin/hotels', 'Admin\HotelController')->middleware('admin');
Route::post('/admin/hotels/updateinline/{id}', ['as' => 'hotels/updateinline', 'uses' => 'Admin\HotelController@updateinline'])->middleware('admin');
Route::post('/admin/hotels/delete/{id}', ['as' => 'hotels/delete', 'uses' => 'Admin\HotelController@delete'])->middleware('admin');
/* ------------ Hotels  -------------- */

/* ------------ Admin Bookings -------------- */
Route::resource('/admin/bookings', 'Admin\BookingsController')->middleware('admin');
Route::post('/admin/bookings/updateinline/{id}', ['as' => 'bookings/updateinline', 'uses' => 'Admin\BookingsController@updateinline'])->middleware('admin');
Route::post('/admin/bookings/delete/{id}', ['as' => 'bookings/delete', 'uses' => 'Admin\BookingsController@delete'])->middleware('admin');
Route::post('/admin/bookings/purge/{id}', ['as' => 'bookings/purge', 'uses' => 'Admin\BookingsController@purge'])->middleware('admin');
Route::post('/admin/bookings/undelete/{id}', ['as' => 'bookings/undelete', 'uses' => 'Admin\BookingsController@undelete'])->middleware('admin');
Route::post('/admin/bookings/send_email_to_customer/{id}', ['as' => 'bookings/send_email_to_customer', 'uses' => 'Admin\BookingsController@send_email_to_customer'])->middleware('admin');
Route::post('/admin/bookings/confirmbookingbanktransfer/{id}', ['as' => 'bookings/confirmbookingbanktransfer', 'uses' => 'Admin\BookingsController@confirmbookingbanktransfer'])->middleware('admin');
Route::post('/admin/bookings/send_payment_email/{id}', ['as' => 'bookings/send_payment_email', 'uses' => 'Admin\BookingsController@send_payment_email'])->middleware('admin');
Route::post('/admin/bookings/printdone/{id}', ['as' => 'bookings/printdone', 'uses' => 'Admin\BookingsController@printdone'])->middleware('admin');
Route::post('/admin/bookings/search', ['as' => 'bookings/search', 'uses' => 'Admin\BookingsController@index'])->middleware('admin');
Route::get('/admin/bookings/add_check_in/{id}', ['as' => 'bookings/add_check_in', 'uses' => 'Admin\BookingsController@add_check_in'])->middleware('admin');
Route::get('/admin/bookings/add_check_out/{id}', ['as' => 'bookings/add_check_out', 'uses' => 'Admin\BookingsController@add_check_out'])->middleware('admin');
Route::get('/admin/bookings/get_ckin_ckou_terminal/{id}', ['as' => 'bookings/get_ckin_ckou_terminal', 'uses' => 'Admin\BookingsController@get_ckin_ckou_terminal'])->middleware('admin');
Route::post('/admin/bookings/add_ckin_ckou_form', ['as' => 'bookings/add_ckin_ckou_form', 'uses' => 'Admin\BookingsController@add_ckin_ckou_form'])->middleware('admin');
/* ------------ /Admin Bookings  -------------- */
/*------- Docket -------*/
Route::resource('/admin/docket', 'Admin\DocketController')->middleware('admin');
/*------- Docket -------*/

/*------- Checkinout -------*/
Route::resource('/admin/checkinout', 'Admin\CheckinoutController')->middleware('admin');
/*------- Checkinout -------*/
/*------- PickDrop Report -------*/
Route::resource('/admin/pickdrop', 'Admin\PickdropreportController')->middleware('admin');
/*------- PickDrop Report -------*/

/*------- overparked Report -------*/
Route::resource('/admin/overparked', 'Admin\OverparkedController')->middleware('admin');
/*------- overparked Report -------*/

/*------- Agent Report -------*/
Route::resource('/admin/agentreports', 'Admin\AgentsreportController')->middleware('admin');
/*------- Agent Report -------*/

/*------- Manual Order -------*/
Route::resource('/admin/manualbooking', 'Admin\ManualbookingController')->middleware('admin');
Route::get('/admin/manualbooking/getairorts/{id}', ['as' => 'manualbooking/getairorts', 'uses' => 'Admin\ManualbookingController@getairorts'])->middleware('admin');
Route::get('/admin/manualbooking/getTerminals/{id}', ['as' => 'manualbooking/getTerminals', 'uses' => 'Admin\ManualbookingController@getTerminals'])->middleware('admin');
Route::get('/admin/manualbooking/getcarwashhtml/{id}', ['as' => 'manualbooking/getcarwashhtml', 'uses' => 'Admin\ManualbookingController@getcarwashhtml'])->middleware('admin');
/*------- Manual Order -------*/

Route::get('/symlink', function () {
   Artisan::call('storage:link');
});