<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberController as Member;
use App\Http\Controllers\StylistController as Stylist;
use App\Http\Controllers\MemberWebsiteController as Website;
use App\Http\Controllers\StylistWebsiteController as StylistWebsite;
use App\Http\Controllers\CreateGridController as CreateGridController;
use App\Http\Controllers\Admin\LoginController as AdminLogin;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\CommonController;

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

//  Route::group(['prefix' => 'stylist', 'namespace' => 'Stylist', 'as' => 'stylist.'], function () {

//   Route::group(['prefix' => 'grid', 'as' => 'grid.'], function () {

//     Route::get('/index', 'GridController@index')->name('index');
//     Route::get('/create', 'GridController@createGridIndex')->name('create');
//     Route::get('/view/{grid_id}', 'GridController@view')->name('view');
//     Route::post('/save', 'GridController@saveGridDetails')->name('save');
//     Route::get('/export/pdf/{grid_id}', 'GridController@exportGridPdf')->name('download.pdf');
    
//   });

//  });
 
  Route::group(['prefix' => 'options-', 'as' => 'options.'], function () {

    // This routes to get select options data
    Route::post('stylist-clients', [CommonController::class, 'get_stylist_clients_list'])->name('stylist_clients');
  
  });

  Route::get('/stylist-grid', 'Stylist\GridController@index')->name('stylist.grid.index');
  
  Route::get('stylist-grid/create', 'Stylist\GridController@createGridIndex')->name('stylist.grid.create');
  Route::get('stylist-grid/view/{grid_id}', 'Stylist\GridController@view')->name('stylist.grid.view');
  Route::post('/stylist-grid/list', 'Stylist\GridController@getStyleGridList')->name('stylist.grid.list');

  Route::post('stylist-grid/save', 'Stylist\GridController@saveGridDetails')->name('stylist.grid.save');
  Route::get('stylist-grid/export/pdf/{grid_id}', 'Stylist\GridController@exportGridPdf')->name('stylist.grid.download.pdf');
  Route::post('stylist-grid/send-to-clients', 'Stylist\GridController@sendGridToClients')->name('stylist.grid.sent_to_clients');
  Route::post('stylist-grid/clients', 'Stylist\GridController@getGridClients')->name('stylist.grid.clients');

  Route::get('/stylist-messanger/{chat_room_id?}', 'Stylist\ChatController@index')->name('stylist.messanger.index');
  Route::post('/stylist-messanger-auth', 'Stylist\ChatController@pusherAuth')->name('stylist.messanger.pusher.auth');
  Route::POST('/stylist-messanger-contacts', 'Stylist\ChatController@getChatContacts')->name('stylist.messanger.contacts');
  Route::post('/stylist-messanger-save', 'Stylist\ChatController@saveChatMessage')->name('stylist.messanger.send.message');
  Route::post('/stylist-messanger-room-messages', 'Stylist\ChatController@getChatRoomMessage')->name('stylist.messanger.room.messages');
  Route::post('/stylist-messanger-read', 'Stylist\ChatController@updateChatMessageReadStatus')->name('stylist.messanger.read.message');
  Route::post('/stylist-online-status-save', 'Stylist\ChatController@updateOnlineStatus')->name('stylist.messanger.online.status');
  
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
 Route::get('/stylist-sourcing', [Stylist::class, 'stylistSourcing'])->name('stylist.sourcing.index');
 Route::post('/stylist-sourcing-requests-json', [Stylist::class, 'getStylistSourcingRequests'])->name('stylist.sourcing.requests');
 Route::get('/stylist-fulfill-source-request/{title}', [Stylist::class, 'stylistFulfillSourceRequest']);
 Route::post('/stylist-fulfill-source-request-post', [Stylist::class, 'stylistFulfillSourceRequestPost']);
 Route::get('/stylist-source-request-submit', [Stylist::class, 'stylistSourceRequestSubmit']);
 Route::get('/stylist-create-source-request', [Stylist::class, 'stylistCreateSourceRequest'])->name('stylist.sourcing.create');
 Route::post('/get-stylist-brands', [Website::class, 'getStylistBrandList']);
 Route::post('/stylist-submit-request-post', [Stylist::class, 'stylistSubmitRequestPost']);
 Route::get('/stylist-submit-request-complete', [Stylist::class, 'stylistSubmitRequestComplete']);
 Route::get('/stylist-offer-received/{title}', [Stylist::class, 'stylistOfferReceived']);
 Route::post('/stylist-accept-offer', [Stylist::class, 'stylistAcceptOffer']);
 Route::get('/stylist-sourcing/{title}', [Stylist::class, 'sourcingRequestView'])->name('stylist.sourcing.view');
 Route::get('/stylist-offer-accepted', [Stylist::class, 'stylistOfferAcceptedSuccessful']);
 Route::post('/stylist-decline-offer', [Stylist::class, 'stylistDeclineOffer']);
 Route::post('/stylist-sourcing-generate-invoice', [Stylist::class, 'sourcingRequestGenerateInvoice'])->name('stylist.sourcing.generate_invoice');

 Route::get('/stylist-notifications', [Stylist::class, 'notificationsIndex'])->name('stylist.notifications.index');
 Route::post('/stylist-notifications', [Stylist::class, 'notificationsList'])->name('stylist.notifications.list');
 Route::post('/stylist-notifications-unread', [Stylist::class, 'unreadNotificationsList'])->name('stylist.notifications.unread_list');
 Route::post('/stylist-notifications-read-all', [Stylist::class, 'readNotifications'])->name('stylist.notifications.read_all');
 
 Route::get('/stylist-payment', [Stylist::class, 'paymentsIndex'])->name('stylist.payment.index');
 Route::get('/stylist-payment-create', [Stylist::class, 'paymentsCreatePaymentIndex'])->name('stylist.payment.create');
 Route::post('/stylist-payment/get-member-temp-invoice-items', [Stylist::class, 'getMemberTempInvoiceItems'])->name('stylist.payment.member_temp_items');
 Route::post('/stylist-payment/create-product-invoice', [Stylist::class, 'createProductInvoice'])->name('stylist.payment.create_product_invoice');
 Route::post('/stylist-payment/list-json', [Stylist::class, 'getProductPaymentsJson'])->name('stylist.payment.list');

 
  Route::get('/stylist-clients', [Stylist::class, 'clientIndex'])->name('stylist.client.index');
  Route::post('/stylist-client-list-ajax', [Stylist::class, 'getClientsJson'])->name('stylist.client.list');

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
Route::get('/member-sourcing', [Member::class, 'memberSourcing'])->name('member.sourcing.index');
Route::post('/member-sourcing-live-requests-json', [Member::class, 'getMemberSourcingLiveRequests'])->name('member.sourcing.live.requests');
Route::get('/offer-received/{title}', [Member::class, 'memberOfferReceived']);
Route::get('/member-sourcing/{title}', [Member::class, 'sourcingRequestView'])->name('member.sourcing.view');
Route::get('/member-offer-accepted', [Member::class, 'memberOfferAcceptedSuccessful']);
Route::post('/member-accept-offer', [Member::class, 'memberAcceptOffer']);
Route::post('/member-pay-sourcing-invoice', [Member::class, 'paySourcingInvoice'])->name('member.pay_sourcing_invoice');
Route::post('/member-decline-offer', [Member::class, 'memberDeclineOffer']);
Route::get('/member-submit-request-complete', [Member::class, 'memberSubmitRequestComplete']);

// Member Grids 
Route::get('/member-grid', 'Member\GridController@index')->name('member.grid.index');
Route::post('/member-grid/list', 'Member\GridController@getStyleGridList')->name('member.grid.list');
Route::get('member-grid/view/{grid_id}', 'Member\GridController@view')->name('member.grid.view');
Route::post('member-grid/product-details', 'Member\GridController@getStyleGridProductDetails')->name('member.grid.product');

Route::get('/member-grid-details', [Member::class, 'memberGridDetails']);
Route::get('/member-orders', [Member::class, 'memberOrders']);
Route::post('/member-orders/list-json', [Member::class, 'getMemberOrdersJson'])->name('member.orders.list');
Route::post('/member-orders/pay-invoice', [Member::class, 'payMemberOrderInvoice'])->name('member.order.pay_invoice');
Route::get('/member-submit-request', [Member::class, 'memberSubmitRequest'])->name('member.create_sourcing_request');
Route::post('/get-brands-list', [Website::class, 'getBrandList']);
Route::post('/member-submit-request-post', [Member::class, 'memberSubmitRequestPost']);

// member notifications 
Route::get('/member-notifications', [Member::class, 'notificationsIndex'])->name('member.notifications.index');
Route::post('/member-notifications', [Member::class, 'notificationsList'])->name('member.notifications.list');
Route::post('/member-notifications-unread', [Member::class, 'unreadNotificationsList'])->name('member.notifications.unread_list');
Route::post('/member-notifications-read-all', [Member::class, 'readNotifications'])->name('member.notifications.read_all');

// Subscription


Route::group(['prefix' => 'member-subscription', 'as' => 'member.subscription.'], function () {
  
    Route::get('/', 'Member\SubscriptionController@index')->name('index');
    Route::post('list', 'Member\SubscriptionController@getSubscriptionList')->name('list');
    Route::post('buy', 'Member\SubscriptionController@buySubscription')->name('buy');
    Route::post('cancel', 'Member\SubscriptionController@cancelSubscription')->name('cancel');
    Route::get('billing', 'Member\SubscriptionController@subscriptionBillingIndex')->name('billing.index');
    Route::post('billing-details', 'Member\SubscriptionController@subscriptionBillingDetails')->name('billing.content');
    Route::post('invoice/history', 'Member\SubscriptionController@getSubscriptioninvoiceHistory')->name('invoice.history');
    Route::post('check-already-purchased-cancelled-subscription', 'Member\SubscriptionController@checkAlreadyPurchasedCancelledSubscription')->name('check_already_purchased_cancelled');
});


// Memeber panel chat
Route::get('/member-messanger/{chat_room_id?}', 'Member\ChatController@index')->name('member.messanger.index');
Route::post('/member-messanger-auth', 'Member\ChatController@pusherAuth')->name('member.messanger.pusher.auth');
Route::POST('/member-messanger-contacts', 'Member\ChatController@getChatContacts')->name('member.messanger.contacts');
Route::post('/member-messanger-save', 'Member\ChatController@saveChatMessage')->name('member.messanger.send.message');
Route::post('/member-messanger-room-messages', 'Member\ChatController@getChatRoomMessage')->name('member.messanger.room.messages');
Route::post('/member-messanger-read', 'Member\ChatController@updateChatMessageReadStatus')->name('member.messanger.read.message');
Route::post('/member-online-status-save', 'Member\ChatController@updateOnlineStatus')->name('member.messanger.online.status');
  
// Stripe 


Route::post('/stripe-create-charge-payment', 'PaymentGatwayController@stripe_charge_payment')->name('stripe_charge_payment');

// member cart 

Route::group(['prefix' => 'member-cart', 'as' => 'member.cart.'], function () {

  Route::get('/', 'Member\CartController@index')->name('index');
  Route::post('add', 'Member\CartController@addToCart')->name('add');
  Route::post('remove', 'Member\CartController@removeCartItems')->name('remove');
  Route::post('list', 'Member\CartController@getCartList')->name('list');
  Route::post('send-to-messanger', 'Member\CartController@sendCartItemsToMessanger')->name('send_to_messanger');
});

//member section End

//Admin Section Start
Route::get('/admin', [AdminLogin::class, 'adminLogin']);
Route::post('/admin-login-post', [AdminLogin::class, 'adminLoginPost']);
Route::get('/admin-logout', [AdminLogin::class, 'adminLogout']);
Route::get('/admin-dashboard', [AdminDashboard::class, 'adminDashboard']);
Route::get('/admin-member-list', [AdminDashboard::class, 'adminMemberList']);
Route::post('/admin-member-list-ajax', [AdminDashboard::class, 'adminMemberListAjax']);
Route::get('/admin-member-details/{title}', [AdminDashboard::class, 'adminMemberDetails'])->name('admin.member.view');
Route::post('admin-member-details/subscription-billing-details', [AdminDashboard::class, 'memberSubscriptionBillingDetails'])->name('admin.member.subscription.billing');
Route::post('admin-member-details/subscription-invoice-history', [AdminDashboard::class, 'getMemberSubscriptioninvoiceHistory'])->name('admin.member.subscription.invoice.history');
Route::get('/admin-stylist', [AdminDashboard::class, 'adminStylist']);
Route::post('/admin-stylist-list-ajax', [AdminDashboard::class, 'adminStylistListAjax']);
Route::get('/admin-stylist-details/{title}', [AdminDashboard::class, 'adminStylistDetails']);
Route::post('/admin-cancel-member-membership', [AdminDashboard::class, 'adminCancelMemberMembership'])->name('admin.member.subscription.cancel');
Route::post('/admin-cancel-stylist-membership', [AdminDashboard::class, 'adminCancelStylistMembership']);
Route::get('/admin-member-order-details/{title}', [AdminDashboard::class, 'adminMemberOrderDetails']);
Route::get('/admin-stylist-order-details/{title}', [AdminDashboard::class, 'adminStylistOrderDetails']);
Route::get('/admin-review-stylist', [AdminDashboard::class, 'adminReviewStylist']);
Route::post('/admin-review-stylist-ajax', [AdminDashboard::class, 'adminReviewStylistAjax']);
Route::get('/admin-review-stylist-details/{title}', [AdminDashboard::class, 'adminReviewStylistDetails']);
Route::post('/admin-update-stylist-status', [AdminDashboard::class, 'adminUpdateStylistStatus']);
Route::get('/admin-upload-product', [AdminDashboard::class, 'adminUploadProduct']);
Route::post('/admin-upload-product-ajax', [AdminDashboard::class, 'adminUploadProductAjax']);
Route::post('/admin-show-product-list-ajax', [AdminDashboard::class, 'adminShowProductListAjax']);
Route::post('/admin-view-product-ajax', [AdminDashboard::class, 'adminViewProductAjax']);
Route::post('/admin-remove-product-ajax', [AdminDashboard::class, 'adminRemoveProductAjax']);
Route::get('/admin-settings', [AdminDashboard::class, 'adminSettings']);
Route::get('/admin-profile-settings', [AdminDashboard::class, 'adminProfileSettings']);
Route::post('/admin-update-profile-settings-ajax', [AdminDashboard::class, 'adminUpdateProfileSettingsAjax']);

// Admin chat 
Route::get('/admin-messanger', 'Admin\ChatController@index')->name('admin.messanger.index');
Route::POST('/admin-messanger-contacts', 'Admin\ChatController@getChatContacts')->name('admin.messanger.contacts');
Route::post('/admin-messanger-room-messages', 'Admin\ChatController@getChatRoomMessage')->name('admin.messanger.room.messages');

//admin section end

// Route::get('/loadgridview', function () {
	// error_log("ROOT ROUTE");
    // return view('stylist.postloginview.create_grid');
// });

