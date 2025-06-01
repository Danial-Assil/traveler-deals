<?php

namespace App\Http\Traits;
 
use Seshac\Otp\Otp;
use Illuminate\Support\Facades\Mail;

trait SendToken
{
    use ApiResponseTrait;
    public function sendTokenToEmail($email, $subject = '')
    {
        // $api_username = env('MORA_API_USERNAME');
        // $api_sender = env('MORA_API_SENDER');
        // $api_key = env('MORA_API_KEY');

        $otp = Otp::generate($email); // 2 minutes , 4 digits
        if ($otp->status == false) {
            return $this->returnError(402, $otp->message);
        }
        $subject = $subject != '' ? $subject : 'Verification Code';
        $to_name = '';
        Mail::send('emails.send_token', ['token' => $otp->token], function ($message) use ($to_name, $subject, $email) {
            $message->to($email, $to_name)->subject($subject);
            $message->sender(env('MAIL_FROM_ADDRESS'));
        });

        return $this->returnSuccess("sent successfully");
    }

    public function sendTokenToMobile($mobile)
    {
        // $api_username = env('MORA_API_USERNAME');
        // $api_sender = env('MORA_API_SENDER');
        // $api_key = env('MORA_API_KEY'); 

        $otp = Otp::generate($mobile); // 2 minutes 
        if ($otp->status == false) {
            return $this->returnError(402, $otp->message);
        }
        // $response = Http::get('http://mora-sa.com/api/v1/sendsms?api_key=' . $api_key . '&username=' . $api_username . '&sender=' . $api_sender . '&message=' . 'This is your verification code ' . $otp->token . '&numbers=' . $mobile);

        return $this->returnSuccess("sent successfully");
    }
    
}
