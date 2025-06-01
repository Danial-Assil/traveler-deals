<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Traits\SendToken;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Seshac\Otp\Otp;
use Illuminate\Support\Facades\Validator;

class VerificationController extends Controller
{
    use ApiResponseTrait, SendToken;
    //
    public function sendToken(Request $request)
    {
        //valid request
        $validator = Validator::make($request->only('mobile'), [
            'mobile' => 'required|exists:users,mobile'
        ]);
        //Send failed response if request is not valid
        if ($validator->fails()) {
            return $this->returnValidationErrors($validator->messages());
        }
        // send code to mobile number
        try {
            // return $this->sendTokenToMobile($request->mobile);
            $user = User::whereMobile($request->mobile)->first();
            return $this->sendTokenToEmail($user->email);
        } catch (Exception $e) {
            return $this->returnError(401, 'One Error');
        }
    }

    public function verify(Request $request)
    {
        // valid request
        $validator = Validator::make($request->only('mobile', 'token'), [
            'mobile' => 'required|exists:users,mobile',
            'token' => 'required'
        ]);
        // Send failed response if request is not valid
        if ($validator->fails()) {
            return $this->returnValidationErrors($validator->messages());
        }
        $user = User::whereMobile($request->mobile)->first();
        if ($user->is_verified) {
            return $this->returnError(401, 'User is verified');
        }
        // $otp = Otp::validate($user->mobile, $request->token);
        $otp = Otp::validate($user->email, $request->token);
        // if ($otp->status) {
            $user->update(['is_verified' => 1, 'email_verified_at' => Carbon::now()]); 
            return $this->returnSuccess('Verification is done');
        // }
        return $this->returnError(401, 'Code is not valid');
    }

    public function verifyEmail(Request $request)
    {
        // valid request
        $validator = Validator::make($request->only('email', 'token'), [
            'email' => 'required|exists:users,email',
            'token' => 'required'
        ]);
        // Send failed response if request is not valid
        if ($validator->fails()) {
            return $this->returnValidationErrors($validator->messages());
        }
        $user = User::whereEmail($request->email)->first();
        if (!$user->is_verified) {
            return $this->returnError(401, 'User is not verified');
        } 
        $otp = Otp::validate($user->email, $request->token);
        if ($otp->status) { 
            return $this->returnSuccess('Token is valid');
        }
        return $this->returnError(401, 'Code is not valid');
    }
    
}
