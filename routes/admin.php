<?php

use App\Http\Controllers\Dash\AboutController;
use App\Http\Controllers\Dash\AdminController;
use App\Http\Controllers\Dash\AuthController;
use App\Http\Controllers\Dash\CategoryController;
use App\Http\Controllers\Dash\ConversationController;
use App\Http\Controllers\Dash\DealController;
use App\Http\Controllers\Dash\HomeController;
use App\Http\Controllers\Dash\NewsController; 
use App\Http\Controllers\Dash\UserController;
use App\Http\Controllers\Dash\OrderController; 
use App\Http\Controllers\Dash\HelpSupportController;
use App\Http\Controllers\Dash\TripController;
use Illuminate\Support\Facades\Route;

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



// IF THE ADMIN USER DON NOT LOGIN CAN ABLE TO SEE THIS ROUTES
Route::middleware(['guest:admin'])->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::get('/forget_pass', [AuthController::class, 'showForgetPassForm'])->name('forget_pass');
    Route::post('/do_forget_pass', [AdminController::class, 'do_forget_pass'])->name('do_forget_pass');
    Route::post('do_login',   [AuthController::class, 'do_login'])->name('do_login');
    Route::get('reset_pass/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset_pass_get');
    Route::post('reset_pass', [ForgotPasswordController::class, 'do_reset_pass'])->name('do_reset_pass');
});

// IF THE ADMIN USER  LOGGEDIN CAN ABLE TO SEE THIS ROUTES
Route::prefix(LaravelLocalization::setLocale())->middleware(['auth:admin'])->group(function () {


    Route::patch('/fcm-token', [HomeController::class, 'updateToken'])->name('fcmToken');
    Route::post('/read_notifications', [HomeController::class, 'readNotifications'])->name('admin.read_notifications');
    Route::get('/notifications', [HomeController::class, 'notifications'])->name('admin.notifications');

    Route::get('/', [HomeController::class, 'index'])->name('admin.home');
    // Route::get('/',      [AdminController::class, 'index'])->name('dashboard.home');
    Route::post('/', [DashboardController::class, 'change_lang'])->name('change_lang');
    Route::post('logout', [AdminController::class, 'do_logout'])->name('admin.logout');
    Route::post('reset_pass', [AdminController::class, 'reset_pass'])->name('admin.reset_pass');
    Route::get('profile', [AdminController::class, 'profile'])->name('admin.profile');
    Route::put('profile/update', [AdminController::class, 'update_profile'])->name('admin.update_profile');

    Route::resource('categories', CategoryController::class);
    
    Route::resource('news', NewsController::class);
    
  
    Route::resource('users', UserController::class);
    Route::put('/users/{id}/reset_pass', [UserController::class, 'resetPassword'])->name('users.reset_pass');
    Route::post('/users/{id}/set_active', [UserController::class, 'setActive'])->name('users.set_active');
    
    Route::resource('conversations', ConversationController::class);

    Route::resource('orders', OrderController::class);
    Route::resource('trips', TripController::class);
    Route::get('/trips/{id}/accept', [TripController::class, 'accept'])->name('trips.accept');
    Route::post('/trips/do_accept', [TripController::class, 'do_accept'])->name('trips.do_accept');

    Route::resource('deals', DealController::class);
   
     
    Route::resource('help_supports', HelpSupportController::class);
 
     
   
});
