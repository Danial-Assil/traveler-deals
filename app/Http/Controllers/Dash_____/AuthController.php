<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\AppController;
use App\Http\Requests\Dash\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends AppController
{

    protected $auth_folder;

    public function __construct()
    {
        parent::__construct();
        $this->auth_folder = 'dash.auth';
    }


    public function index()
    {
        return view('dash.layouts.app');
    }

    public function showLoginForm()
    {
        $page_title = trans('dash.login');
        return view($this->auth_folder . '.login', compact('page_title'));
    }

    public function do_login(LoginRequest $request)
    {
        $credential = $request->only(['email', 'password']);

        if (Auth::guard('admin')->attempt($credential, $request->filled('remember'))) {
            // return redirect()->route('admin.home');
            return  response()->json(
                [
                    'status' => 'success',
                    'route' => route('admin.home'),
                    'message' =>  trans('dash.login_successfully'),
                ]
            );
        } else {
            return response()->json(
                [
                    'status' => 'error',
                    'message' =>  trans('dash.credential_not_right'),
                ]
            );
            // return redirect()->back();
        }
    }


    public function showForgetPassForm()
    {
        $page_title = trans('dashboard.forget_pass');
        return view($this->auth_folder . '.forget_pass', compact('page_title'));
    }
}
