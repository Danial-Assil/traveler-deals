<?php

namespace App\Http\Traits;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

trait UserLoginTrait
{
    // public function login(Request $request)
    // {
    //     // return $request;
    //     $this->validateLogin($request);

    //     if ($this->attemptLogin($request)) {
    //         return $this->successfulLogin($request);
    //     }
    //     return $this->failedLogin($request);
    // }
    // protected function validateLogin(Request $request)
    // {
    //     $this->validate($request, [
    //         'mobile' => 'required',
    //         'password' => 'required',
    //     ]);
    // }
    protected function attemptLogin(Request $request)
    {
        if (
            Auth::guard($this->guard)->attempt([
                'username' => $request['username'],
                'password' => $request['password']
            ], $request->has('remember'))

        ) {
            return true;
        }
        return false;
    }
    // protected function successfulLogin(Request $request)
    // {
    //     return redirect($this->redirectTo);
    // }

    /**
     * This is executed when the user fails to log in
     * 
     * @var Request $request
     * @return Reponse
     */
    // protected function failedLogin(Request $request)
    // {
    //     session()->flash('error', trans('marketers.credential_not_right'));
    //     return redirect()->back();
    // }
}
