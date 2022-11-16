<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberController as Member;
use App\Http\Controllers\StylistController as Stylist;
use App\Http\Controllers\MemberWebsiteController as Website;
use App\Http\Controllers\StylistWebsiteController as StylistWebsite;
use App\Http\Controllers\CreateGridController as CreateGridController;


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
// echo "web"; die;
//Route::get('/', function () {
  //  return view('welcome');
//});
  //Route::domain('stylist.com')->group(function () {
  Route::get('/loadgridview',[CreateGridController::class,'loadgridview']);
  Route::post('/add-grid',[CreateGridController::class,'add_grid']);
  Route::post('/get-grid-data','App\Http\Controllers\CreateGridController@get_grid_data');
 // });
 //stylist Section Start
 Route::get('/', [StylistWebsite::class, 'index']);
 Route::get('/sign-up', [StylistWebsite::class, 'index']);

 Route::get('/stylist-registration', [StylistWebsite::class, 'stylistRegistration']);
 Route::post('/check-stylist-existance', [StylistWebsite::class, 'checkStylistExistance']);
 Route::post('/add-stylist', [StylistWebsite::class, 'addStylist']);
 Route::get('/stylist-account-confirmation/{title}', [StylistWebsite::class, 'stylistAccountConfirmation']);
 Route::post('/add-stylist-second-process', [StylistWebsite::class, 'addStylistSecondProcess']);
 Route::get('/stylist-login', [StylistWebsite::class, 'stylistLogin']);
 Route::post('/stylist-login-post', [StylistWebsite::class, 'stylistLoginPost']);
 Route::get('/stylist-dashboard', [Stylist::class, 'stylistDashboard']);
 Route::get('/stylist-logout', [StylistWebsite::class, 'stylistLogout']);
 Route::get('/stylist-sourcing', [Stylist::class, 'stylistSourcing']);
 Route::get('/stylist-fulfill-source-request/{title}', [Stylist::class, 'stylistFulfillSourceRequest']);
 Route::post('/stylist-fulfill-source-request-post', [Stylist::class, 'stylistFulfillSourceRequestPost']);
 Route::get('/stylist-source-request-submit', [Stylist::class, 'stylistSourceRequestSubmit']);
 Route::get('/stylist-create-source-request', [Stylist::class, 'stylistCreateSourceRequest']);
 Route::post('/get-stylist-brands', [Website::class, 'getStylistBrandList']);
 Route::post('/stylist-submit-request-post', [Stylist::class, 'stylistSubmitRequestPost']);
 Route::get('/stylist-submit-request-complete', [Stylist::class, 'stylistSubmitRequestComplete']);
 Route::get('/stylist-offer-received/{title}', [Stylist::class, 'stylistOfferReceived']);
 Route::post('/stylist-accept-offer', [Stylist::class, 'stylistAcceptOffer']);
 Route::get('/stylist-offer-accepted', [Stylist::class, 'stylistOfferAcceptedSuccessful']);
 Route::post('/stylist-decline-offer', [Stylist::class, 'stylistDeclineOffer']);
 
 
 //stylist section End
 ///member Section Start
Route::post('/add-member', [Website::class, 'addMember']);
Route::post('/check-member-existance', [Website::class, 'checkMemberExistance']);
Route::get('/member-login', [Website::class, 'memberLogin']);
Route::post('/member-login-post', [Website::class, 'memberLoginPost']);
Route::get('/member-logout', [Website::class, 'memberLogout']);
Route::get('/member-registration', [Website::class, 'index']);
Route::get('/member-account-verification/{title}', [Website::class, 'memberAccountVerification']);
//Route::get('/search-product/{title}','ProductController@searchProduct');

Route::get('/member-dashboard', [Member::class, 'memberDashboard']);
Route::get('/member-sourcing', [Member::class, 'memberSourcing']);
Route::get('/offer-received/{title}', [Member::class, 'memberOfferReceived']);
Route::get('/member-offer-accepted', [Member::class, 'memberOfferAcceptedSuccessful']);
Route::post('/member-accept-offer', [Member::class, 'memberAcceptOffer']);
Route::post('/member-decline-offer', [Member::class, 'memberDeclineOffer']);
Route::get('/member-submit-request-complete', [Member::class, 'memberSubmitRequestComplete']);
Route::get('/member-grid', [Member::class, 'memberGrid']);
Route::get('/member-grid-details', [Member::class, 'memberGridDetails']);
Route::get('/member-orders', [Member::class, 'memberOrders']);
Route::get('/member-submit-request', [Member::class, 'memberSubmitRequest']);
Route::post('/get-brands-list', [Website::class, 'getBrandList']);
Route::post('/member-submit-request-post', [Member::class, 'memberSubmitRequestPost']);

//member section End

// Route::get('/loadgridview', function () {
	// error_log("ROOT ROUTE");
    // return view('stylist.postloginview.create_grid');
// });

