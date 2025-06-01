<?php

namespace App\Http\Controllers\Api;

use App\Http\Traits\SendToken;
use App\Http\Traits\UploadImage;
use App\Models\Notification;
use App\Models\User;
use App\Models\UserAttachment;
use App\Models\UserFcm;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Seshac\Otp\Otp;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Validator;

class UserController extends AppController
{
    use SendToken;

    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function logout(Request $request)
    {
        if ($request->fcm_token) {
            $fcm_token = UserFcm::where(['token' => $request->fcm_token])->first();
            if ($fcm_token) {
                $fcm_token->delete();
            }
        }
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return $this->returnSuccess('User has been logged out');
        } catch (JWTException $exception) {
            return $this->returnError(403, 'Sorry, user cannot be logged out');
        }
    }

    public function getProfileInfo()
    {
        $user = Auth::user();
        $item = [
            'full_name' => $user->full_name,
            'mobile' => $user->mobile,
            'email' => $user->email,
            'email_verified' => $user->email_verified_at == null ? 0 : 1,
            'mobile_verified' => $user->mobile_verified_at == null ? 0 : 1,
            'document_verified' => $user->document_verified,
            'image' => $user->image_path,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'invitation_code' => $user->invitation_code,
            'deals_count' => count($user->deals),
            'orders_count' => count($user->orders),
            'trips_count' => count($user->trips),
            'traveler_rating' =>  $user->traveler_rating,
            'shopper_rating' =>  $user->shopper_rating,
            'verified_file' => $user->passport ? $user->passport_path : ($user->id_card ? $user->id_card_path : null),
            'reviews' => $user->recieved_reviews()->with('rated')->select('star_rating', 'comment', 'rated_id')->get()
        ];
        return $this->returnData(['user' => $item]);
    }

    public function updateProfileInfo(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $validate = [
            'first_name' => 'required',
            'last_name' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];

        $validator = Validator::make($request->all(), $validate);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return $this->returnValidationErrors($validator->messages());
        }
        $data = $request->all();
        if ($request->image) {
            $image = $this->uploadImage($request->image);
            $data['image'] = $image;
        }
        $user->update($data);
        return $this->returnSuccess('User updated successfully');
    }

    public function updateMobile(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $validate = [
            'mobile' => 'required|unique:users,mobile',
        ];

        $validator = Validator::make($request->all(), $validate);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return $this->returnValidationErrors($validator->messages());
        }

        return $this->sendTokenToEmail($user->email);
        return $this->returnSuccess('User updated successfully');
    }

    public function verifyMobile(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $validate = [
            'mobile' => 'required|unique:users,mobile',
            'token' => 'required',
        ];

        $validator = Validator::make($request->all(), $validate);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return $this->returnValidationErrors($validator->messages());
        }
        $otp = Otp::validate($user->email, $request->token);
        if ($otp->status) {
            $user->update(['mobile' => $request->mobile, 'mobile_verified_at' => Carbon::now()]);
            return $this->returnSuccess('Verification is done');
        }

        return $this->returnSuccess('Code is not correct');
    }

    // verify by [passport - id]
    public function verifyAccount(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $validate = [
            'file' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'type' => 'required', // passport - id 
        ];
        $validator = Validator::make($request->all(), $validate);
        //Send failed response if request is not valid
        if ($validator->fails()) {
            return $this->returnValidationErrors($validator->messages());
        }
        $attach = UserAttachment::create([
            'user_id' => $user->id,
            'type' => $request->type, // type of attachment [ id - passport ] 
        ]);
        $file = $this->uploadFileToStorage($request->file, $attach->file_folder);
        $attach->update(['file' => $file]);
        return $this->returnSuccess('Uploaded successfully and verification is pending');
    }

    public function updateEmail(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $validate = [
            'email' => 'required|email|unique:users,email',
        ];

        $validator = Validator::make($request->all(), $validate);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return $this->returnValidationErrors($validator->messages());
        }

        try {
            return $this->sendTokenToEmail($request->email);
        } catch (Exception $e) {
            return $this->returnSuccess('User updated successfully');
        }
    }

    public function verifyEmail(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $validate = [
            'email' => 'required|email|unique:users,email',
            'token' => 'required',
        ];

        $validator = Validator::make($request->all(), $validate);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return $this->returnValidationErrors($validator->messages());
        }
        $otp = Otp::validate($request->email, $request->token);
        if ($otp->status) {
            $user->update(['email' => $request->email, 'email_verified_at' => Carbon::now()]);
            return $this->returnSuccess('Verification is done');
        }

        return $this->returnSuccess('Code is not correct');
    }

    public function resetPass(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|string|max:50',
            'confirm_password' => 'required|same:password'
        ]);
        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        $update =  Auth::user()->update($data);
        if ($update) {
            return $this->returnSuccess('User updated successfully');
        } else {
            return $this->returnError(401, 'User updated failed');
        }
    }

    // update firebase token
    public function updateToken(Request $request)
    {
        $token = $request->token;
        $update = Auth::user()->update(['fcm_token' => $token]);
        if ($update) {
            return $this->returnSuccess('Updated successfully');
        }
    }

    public function getAllNotifications()
    {
        $data = [
            'notifications' =>  Auth::user()->custom_notifications(),
        ];
        return $this->returnData($data);
    }

    public function readAllNotifications()
    {
        $update = Auth::user()->notifications()->where('read_at', null)->update(['read_at' => Carbon::now()]);
        return $this->returnSuccess('Updated successfully');
    }

    public function readNotification(Request $request)
    {
        $update = Notification::findorfail($request->id)->update(['read_at' => Carbon::now()]);
        if ($update) {
            return  $this->returnSuccess('Read successfully');
        }
    }
    protected function getFile($id, $type, $file_name)
    {
        $path = storage_path('app/users/' . $id . '/' . $type . '/' . $file_name);
        return response()->file($path);
    }
}
