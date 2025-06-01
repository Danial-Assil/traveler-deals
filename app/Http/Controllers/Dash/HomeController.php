<?php

namespace App\Http\Controllers\Dash;

use App\Models\Order;
use App\Models\Trip;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends DashController
{

    public function __construct()
    {
        parent::__construct();

        view()->share([
            'module_actions' => [],
            'orders_count' => count(Order::all()),
            'trips_count' => count(Trip::all()),
            'users_count' => count(User::all()),
            'deals_count' => 0,
        ]);
    }

    public function index()
    {
        $page_title = trans('dash.home');
        return view($this->app_folder . '.pages.home', compact('page_title'));
    }

    public function updateToken(Request $request)
    {
        // try {
        $token = $request->all()['token'];
        $update = auth('admin')->user()->update(['fcm_token' => $token]);
        if ($update) {
            return response()->json([
                'success' => true,
            ]);
        }
    }

    public function notifications()
    {
        $items = auth($this->guard)->user()->notifications->where('read_at', '==', null);
        $page_title = trans('dash.notifications');
        return view($this->app_folder . '.pages.notifications.index', compact('items', 'page_title'));
    }

    public function readNotifications()
    {
        $notifications = auth($this->guard)->user()->notifications->where('read_at', '==', null);
        foreach ($notifications as $notification) {
            $notification->update(['read_at' => Carbon::now()]);
        }
    }
}
