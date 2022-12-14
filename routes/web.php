<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberController as Member;
use App\Http\Controllers\StylistController as Stylist;
use App\Http\Controllers\MemberWebsiteController as Website;
use App\Http\Controllers\StylistWebsiteController as StylistWebsite;
use App\Http\Controllers\CreateGridController as CreateGridController;
use App\Http\Controllers\Admin\LoginController as AdminLogin;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;

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
  Route::post('/get-grid-data',[CreateGridController::class,'get_grid_data']);
 // });
 //stylist Section Start
 Route::get('/', [StylistWebsite::class, 'index']);
 Route::get('/sign-up', [StylistWebsite::class, 'index']);

 Route::group(['prefix' => 'stylist', 'namespace' => 'Stylist', 'as' => 'stylist.'], function () {

  Route::group(['prefix' => 'grid', 'as' => 'grid.'], function () {

    Route::get('/index', 'GridController@index')->name('index');
    Route::get('/create', 'GridController@createGridIndex')->name('create');
    Route::get('/view/{grid_id}', 'GridController@view')->name('view');
    Route::post('/save', 'GridController@saveGridDetails')->name('save');
    Route::get('/export/pdf/{grid_id}', 'GridController@exportGridPdf')->name('download.pdf');
    
  });

 });
 
  Route::get('/stylist-messanger', 'Stylist\ChatController@index')->name('stylist.messanger.index');
  Route::post('/stylist-messanger-auth', 'Stylist\ChatController@pusherAuth')->name('stylist.messanger.pusher.auth');
  Route::POST('/stylist-messanger-contacts', 'Stylist\ChatController@getChatContacts')->name('stylist.messanger.contacts');
  Route::post('/stylist-messanger-save', 'Stylist\ChatController@saveChatMessage')->name('stylist.messanger.send.message');
  Route::post('/stylist-messanger-room-messages', 'Stylist\ChatController@getChatRoomMessage')->name('stylist.messanger.room.messages');
  Route::post('/stylist-messanger-read', 'Stylist\ChatController@updateChatMessageReadStatus')->name('stylist.messanger.read.message');
  
 Route::get('/stylist-registration', [StylistWebsite::class, 'stylistRegistration']);
 Route::get('/stylist-testing', [Login::class, 'index']);
 Route::post('/check-stylist-existance', [StylistWebsite::class, 'checkStylistExistance']);
 Route::post('/add-stylist', [StylistWebsite::class, 'addStylist']);
 Route::get('/stylist-account-confirmation/{title}', [StylistWebsite::class, 'stylistAccountConfirmation']);
 Route::post('/add-stylist-second-process', [StylistWebsite::class, 'addStylistSecondProcess']);
 Route::get('/stylist-login', [StylistWebsite::class, 'stylistLogin']);
 Route::post('/stylist-login-post', [StylistWebsite::class, 'stylistLoginPost']);
 Route::get('/stylist-forgot-password', [StylistWebsite::class, 'stylistForgotPassword']);
 Route::post('/stylist-forgot-password-post', [StylistWebsite::class, 'stylistForgotPasswordPost']);
 Route::get('/stylist-reset-password/{title}', [StylistWebsite::class, 'stylistResetPassword']);
 Route::post('/stylist-reset-password-post', [StylistWebsite::class, 'stylistResetPasswordPost']);
 Route::get('/stylist-dashboard', [Stylist::class, 'stylistDashboard'])->name('stylist.dashboard');;
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
Route::get('/member-forgot-password', [Website::class, 'memberForgotPassword']);
Route::post('/member-forgot-password-post', [Website::class, 'memberForgotPasswordPost']);
Route::get('/member-reset-password/{title}', [Website::class, 'memberResetPassword']);
Route::post('/member-reset-password-post', [Website::class, 'memberResetPasswordPost']);

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

// Memeber panel chat
Route::get('/member-messanger', 'Member\ChatController@index')->name('member.messanger.index');
Route::post('/member-messanger-auth', 'Member\ChatController@pusherAuth')->name('member.messanger.pusher.auth');
Route::POST('/member-messanger-contacts', 'Member\ChatController@getChatContacts')->name('member.messanger.contacts');
Route::post('/member-messanger-save', 'Member\ChatController@saveChatMessage')->name('member.messanger.send.message');
Route::post('/member-messanger-room-messages', 'Member\ChatController@getChatRoomMessage')->name('member.messanger.room.messages');
Route::post('/member-messanger-read', 'Member\ChatController@updateChatMessageReadStatus')->name('member.messanger.read.message');
  
//member section End

//Admin Section Start
Route::get('/admin', [AdminLogin::class, 'adminLogin']);
Route::post('/admin-login-post', [AdminLogin::class, 'adminLoginPost']);
Route::get('/admin-logout', [AdminLogin::class, 'adminLogout']);
Route::get('/admin-dashboard', [AdminDashboard::class, 'adminDashboard']);
Route::get('/admin-member-list', [AdminDashboard::class, 'adminMemberList']);
Route::post('/admin-member-list-ajax', [AdminDashboard::class, 'adminMemberListAjax']);
Route::get('/admin-member-details/{title}', [AdminDashboard::class, 'adminMemberDetails']);
Route::get('/admin-stylist', [AdminDashboard::class, 'adminStylist']);
Route::post('/admin-stylist-list-ajax', [AdminDashboard::class, 'adminStylistListAjax']);
Route::get('/admin-stylist-details/{title}', [AdminDashboard::class, 'adminStylistDetails']);
Route::post('/admin-cancel-membership', [AdminDashboard::class, 'adminCancelMembership']);
Route::post('/admin-cancel-stylist-membership', [AdminDashboard::class, 'adminCancelStylistMembership']);
Route::get('/admin-member-order-details/{title}', [AdminDashboard::class, 'adminMemberOrderDetails']);
Route::get('/admin-stylist-order-details/{title}', [AdminDashboard::class, 'adminStylistOrderDetails']);


//admin section end

// Route::get('/loadgridview', function () {
	// error_log("ROOT ROUTE");
    // return view('stylist.postloginview.create_grid');
// });

