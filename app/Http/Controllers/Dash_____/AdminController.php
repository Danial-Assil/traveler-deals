<?php

namespace App\Http\Controllers\Dash;

use App\Http\Traits\UploadImage;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Carbon\Carbon;
use Mail;
use Hash;
use Illuminate\Support\Str;

class AdminController extends DashController
{

    use UploadImage;
    protected $auth_folder;

    public function __construct()
    {
        parent::__construct();
        $this->auth_folder = 'dashboard.auth';
    }

    public function do_logout()
    {
        Auth::guard('admin')->logout();
        return redirect(route('admin.login'));
    }
    public function profile()
    {
        $page_title = trans('dashboard.profile');
        $user = Auth::guard('admin')->user();
        return view($this->app_folder . '.pages.profile.index', compact('page_title', 'user'));
    }

    public function showForgetPassForm()
    {
        $page_title = trans('dashboard.forget_pass');
        return view($this->auth_folder . '.forget_pass', compact('page_title'));
    }

    public function do_forget_pass(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|exists:admins'
        ]);
        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        Mail::send('dashboard.auth.email_forgetPass', ['token' => $token], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Password');
        });

        if (Mail::failures() == 0) {
            return back()->with('failed', 'Failed! there is some issue with email provider');
        }

        return back()->with('message', 'We have e-mailed your password reset link!');
    }


    public function reset_pass(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|string|max:50',
            'confirm_password' => 'required|same:password'
        ]);
        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        $user = Admin::find(Auth::guard('admin')->user()->id);
        $update = $user->update($data);
        if ($update) {
            return response()->json(
                [
                    'status' => 'success',
                    'message' =>  trans('dashboard.update_successfully'),
                ]
            );
        } else {
            return response()->json(['status' => 'error', 'message' => trans('dashboard.fail_update')]);
        }
    }


    public function update_profile(Request $request)
    {
        $this->validate($request, [
            'birthdate' => 'date|nullable'
        ]);

        $data = $request->all();
        $user = Admin::find(Auth::guard('admin')->user()->id);

        $img_name = $this->uploadImage(null, $request->image);
        if ($img_name) {
            $data['image'] = $img_name;
        }
        $update = $user->update($data);
        if ($update) {
            return response()->json(
                [
                    'status' => 'success',
                    'message' =>  trans('dashboard.update_successfully')
                ]
            );
        } else {
            return response()->json(['status' => 'error', 'message' => trans('dashboard.fail_update')]);
        }
    }
}
