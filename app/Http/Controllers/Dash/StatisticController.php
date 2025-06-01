<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Company;
use App\Models\Conditioner;
use App\Models\CreatedNotif;
use App\Models\Notification;
use App\Models\Package;
use App\Models\PackageSubscription;
use App\Models\User;
use App\Models\UserPackage;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StatisticController extends AdminController
{

    public function index()
    {
        $page_title = trans('statistics.module_title');

        $users = User::where('status', '!=', null);
        $users_subscribed = PackageSubscription::where('status', '!=', null);
        $users_added_conditioner = User::with('conditioners')->has('conditioners', '>', 0);

        $notifications = CreatedNotif::where('type', '!=', null);
        $notifications_scheduale = CreatedNotif::where('type', 2);
        $notifications_direct = CreatedNotif::where('type', 1);

        $conditioners = Conditioner::all();
        $packages = Package::active()->with('users')->withCount('users')->get();
        $users_by_year = User::all()->groupBy(function ($val) {
            return Carbon::parse($val->created_at)->format('Y');
        });

        foreach ($packages as $package) {
            $package->years = PackageSubscription::where('package_id', $package->id)->get()->groupBy(function ($val) {
                return Carbon::parse($val->created_at)->format('Y');
            })->toArray();
        }

        $packages_years =  array_keys(PackageSubscription::all()->groupBy(function ($val) {
            return Carbon::parse($val->created_at)->format('Y');
        })->toArray());

        $users_years =  array_keys(User::all()->groupBy(function ($val) {
            return Carbon::parse($val->created_at)->format('Y');
        })->toArray());

        if (request('from')) {
            $users->where('created_at', '>=', request('from'));
            $notifications->where('created_at', '>=', request('from'));
            $notifications_scheduale->where('created_at', '>=', request('from'));
            $notifications_direct->where('created_at', '>=', request('from'));
            $users_added_conditioner->whereHas('conditioners', function ($query) {
                $query->where('created_at', '>=', request('from'));
            });
            $users_subscribed->where('created_at', '>=', request('from'));
            
        }
        if (request('to')) {
            $users->where('created_at', '<=', request('to'));
            $notifications->where('created_at', '<=', request('to'));
            $notifications_scheduale->where('created_at', '<=', request('to'));
            $notifications_direct->where('created_at', '<=', request('to'));
            $users_added_conditioner->whereHas('conditioners', function ($query) {
                $query->where('created_at', '<=', request('to'));
            });
            $users_subscribed->where('created_at', '<=', request('to'));
        }


        $users_count = count($users->get());
        $users_subscribed_count = count($users_subscribed->get());
        $users_added_conditioner_count = count($users_added_conditioner->get());

        $notifications_count = count($notifications->get());
        $notifications_scheduale_count = count($notifications_scheduale->get());
        $notifications_direct_count = count($notifications_direct->get());


        return view(
            $this->app_folder . '.pages.statistics.index',
            compact('page_title', 'users_count', 'users_subscribed_count', 'conditioners', 'users_added_conditioner_count', 'notifications_count', 'notifications_scheduale_count', 'notifications_direct_count', 'packages', 'packages_years', 'users_by_year', 'users_years')
        );
    }
}
