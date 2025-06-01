<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;


use JWTAuth;
use Exception;
use App\Models\User;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Traits\SendToken;
use App\Models\UserFcm;
use Carbon\Carbon;
use Seshac\Otp\Otp;

class AuthController extends Controller
{
    use ApiResponseTrait, SendToken;

    public function register(RegisterRequest $request)
    {
        //Validate data
        $data = $request->all();
        $data["password"] = bcrypt($request->password);
        $user = User::create($data);
        // send code to mobile number
        try {
            // $this->sendTokenToMobile($user->mobile);
            $this->sendTokenToEmail($request->email);
        } catch (Exception $e) {
            return $this->returnError(401, 'One Error');
        }
        // User created, return success response
        return $this->returnSuccess('User created successfully');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        //Request is validated

        //Create token
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return $this->returnError(400, 'Login credentials are invalid.');
            }
        } catch (JWTException $e) {
            return $this->returnError(500, 'Could not create token.');
        }

        // Check if the user is verified
        $user = User::whereEmail($request->email)->first();
        if ($user->is_verified == 0) {
            $this->sendTokenToEmail($user->email);
            return $this->returnErrorWithData(['mobile' => $user->mobile], 403, 'User is not verified.');
        }
        if ($request->fcm_token) {
            $create = UserFcm::create(['user_id' => $user->id, 'token' => $request->fcm_token]);
        }
        //Token created, return with success response and jwt token
        $data = [
            'token' => $token,
            'user' => User::whereEmail($request->email)->select('first_name', 'last_name', 'image', 'id', 'email', 'mobile', 'passport', 'id_card')->first(),
        ];
        return $this->returnData($data, '');
    }


    public function forgetPass(Request $request)
    {
        //valid request
        $validator = Validator::make($request->only('email'), [
            'email' => 'required|email|exists:users,email'
        ]);
        //Send failed response if request is not valid
        if ($validator->fails()) {
            return $this->returnValidationErrors($validator->messages());
        }
        // send code to email
        try {
            return $this->sendTokenToEmail($request->email, 'Forget Pass');
        } catch (Exception $e) {
            return $this->returnError(401, 'One Error');
        }
    }

    public function resetPass(Request $request)
    {
        //valid request
        $validator = Validator::make($request->only('email', 'password', 'confirm_password'), [
            'email' => 'required|email|exists:users,email',
            'password' => [
                'required',
                'string',
                'max:15',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
            ],
            'confirm_password' => 'required|string|same:password'
            // 'token' => 'required'
        ]);
        //Send failed response if request is not valid
        if ($validator->fails()) {
            return $this->returnValidationErrors($validator->messages());
        }

        $user = User::whereEmail($request->email)->first();
        if (!$user->is_verified) {
            return $this->returnError(401, 'User is not verified');
        }
        // $otp = Otp::validate($user->email, $request->token);
        // if ($otp->status) {
        //     $user->update(['password' => bcrypt($request->password)]);
        //     return $this->returnSuccess('Reset Pass done');
        // }
        $update = $user->update(['password' => bcrypt($request->password)]);
        if ($update) {
            return $this->returnSuccess('Reset Pass done');
        }
        return $this->returnError(401, 'Code is not valid');
    }
}
