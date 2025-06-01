<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\DealController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\TripController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\VerificationController;
use App\Http\Controllers\Api\WalletController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


/*****************************  Auth  ***************************/
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
// veirfy the account by token sent to the mobile number  
Route::post('number/verify', [VerificationController::class, 'verify']);
// send a token to mobile 
Route::post('number/send_token', [VerificationController::class, 'sendToken']);
// forget password with mobile for getting a token
Route::post('forget_pass', [AuthController::class, 'forgetPass']);
// reset password with the token sent to mobile 
Route::post('reset_pass', [AuthController::class, 'resetPass']);
Route::post('email/verify', [VerificationController::class, 'verifyEmail']);
Route::post('account/verify', [UserController::class, 'verifyAccount']);


/*****************************  Home  ***************************/
Route::post('home', [HomeController::class, 'home']);
Route::post('get_categories', [CategoryController::class, 'getAll']);

/*****************************  News  ***************************/
Route::get('news', [NewsController::class, 'index']);

/*****************************  Wallet  ***************************/
Route::get('mywallet', [WalletController::class, 'getWalletInfo']);
Route::post('deposit', [WalletController::class, 'deposit']);
Route::post('deposit_request', [WalletController::class, 'requestDeposit']);
Route::post('withdraw', [WalletController::class, 'withdraw']);
Route::post('withdraw_request', [WalletController::class, 'requestWithdraw']);

/*****************************  Trips  ***************************/
Route::get('trips', [TripController::class, 'index']);
Route::post('trips/get_trip', [TripController::class, 'show']);
Route::post('trips/store', [TripController::class, 'store']);
Route::post('trips/delete', [TripController::class, 'destroy']);
Route::post('trips/update', [TripController::class, 'update']);

Route::post('trips/add_request', [TripController::class, 'addRequest']);
Route::post('trips/cancel_request', [TripController::class, 'cancelRequest']);
Route::post('my_trips', [TripController::class, 'getMyTrips']);
Route::post('trips/suitable_orders', [TripController::class, 'getSuitableOrders']);
Route::post('trips/matching_orders', [TripController::class, 'getMatchingOrders']);
Route::post('trips/get_trip_requests', [TripController::class, 'getRequests']);
Route::post('trips/accept_request', [TripController::class, 'acceptRequest']);
Route::post('trips/decline_request', [TripController::class, 'declineRequest']);

/*****************************  Orders  ***************************/
Route::get('orders', [OrderController::class, 'index']);
Route::post('orders/get_order', [OrderController::class, 'show']);
Route::post('orders/store', [OrderController::class, 'store']);
Route::post('orders/delete', [OrderController::class, 'destroy']);
Route::post('orders/update', [OrderController::class, 'update']);

Route::post('orders/add_offer', [OrderController::class, 'addOffer']);
Route::post('orders/cancel_offer', [OrderController::class, 'cancelOffer']);
Route::post('orders/accept_offer', [OrderController::class, 'acceptOffer']);
Route::post('my_orders', [OrderController::class, 'getMyOrders']);
Route::post('orders/suitable_trips', [OrderController::class, 'getSuitableTrips']);
Route::post('orders/matching_trips', [OrderController::class, 'getMatchingTrips']);
Route::post('orders/get_order_offers', [OrderController::class, 'getOffers']);
Route::post('orders/get_order_outgoing_requests', [OrderController::class, 'getOutgoingRequests']);
Route::post('orders/get_order_offer', [OrderController::class, 'getOffer']);
Route::post('orders/accept_offer', [OrderController::class, 'acceptOffer']);
Route::post('orders/decline_offer', [OrderController::class, 'declineOffer']);
 
/*****************************  Deals  ***************************/
Route::post('orders/get_deal', [DealController::class, 'getDeal']);
Route::post('orders/cancel_deal', [DealController::class, 'cancelDeal']);
Route::post('orders/tracking_order', [DealController::class, 'getDealStatuses']);
Route::post('orders/pay_deal', [DealController::class, 'pay']);
Route::post('orders/pay_deal_by_wallet', [DealController::class, 'payByWallet']);
Route::post('orders/pay_traveler', [DealController::class, 'payByTraveler']);
Route::post('orders/pick_up', [DealController::class, 'pickUp']);
Route::post('orders/deliver', [DealController::class, 'deliver']);
Route::post('orders/rate_traveler', [DealController::class, 'rateTraveler']);
Route::post('orders/rate_shopper', [DealController::class, 'rateShopper']);

/*****************************  User  ***************************/
Route::post('get_profile_info', [UserController::class, 'getProfileInfo']);
Route::post('update_profile_info', [UserController::class, 'updateProfileInfo']);
Route::post('update_mobile', [UserController::class, 'updateMobile']);
Route::post('verify_mobile', [UserController::class, 'verifyMobile']);
Route::post('update_email', [UserController::class, 'updateEmail']);
Route::post('verify_email', [UserController::class, 'verifyEmail']);
// get all notifications 
Route::get('get_all_notifications', [UserController::class, 'getAllNotifications']);
// read all notifications
Route::post('read_all_notification', [UserController::class, 'readAllNotifications']);
// read one notification
Route::post('read_notification', [UserController::class, 'readNotification']);


Route::get('/linkstorage', function () {
    Artisan::call('route:cache');
    Artisan::call('config:clear'); 
});
