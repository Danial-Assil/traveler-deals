<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use App\Models\Conditioner;
use App\Models\Coupon;
use App\Models\CreatedNotif;
use App\Models\Feature;
use App\Models\MainProgram;
use App\Models\Package;
use App\Models\Room;
use PDF;
use App\Models\User;
use App\Models\UserTask;
use App\Notifications\User\LifeSpanNotification;
use App\Notifications\User\MaintenanceNotification;
use App\Notifications\User\UsageNotification;
use App\Notifications\UserMaintenanceNotification;
use Carbon\Carbon;
use ArPHP\I18N\Arabic;
use Illuminate\Support\Facades\Mail;
use Seshac\Otp\Otp;

class TestController extends Controller
{
    //
    public function test()
    { 
       
    }

}
