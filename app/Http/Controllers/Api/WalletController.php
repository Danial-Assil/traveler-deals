<?php

namespace App\Http\Controllers\Api;

use App\Models\Payment;
use App\Models\Wallet;
use App\Models\WalletDeposit;
use App\Models\WalletDepositRequest;
use App\Models\WalletWithdraw;
use App\Models\WalletWithdrawRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;
use Carbon\Carbon;

class WalletController extends AppController
{

    public function __construct(Wallet $model)
    {
        parent::__construct($model);
    }

    public function getWalletInfo()
    {
        $user = Auth::user();
        $wallet = $user->wallet;
        if (!$wallet) {
            Wallet::create([
                'user_id' => Auth::user()->id
            ]);
        }
        // if (!$user->document_verified) {
        //     return $this->returnError(400, 'You have to verify your account');
        // }
        $wallet['deposits'] = $wallet->deposits;
        $wallet['withdraws'] = $wallet->withdraws;
        $wallet['payments'] = $user->payments->where('type', 1);
        return $this->returnData([
            'wallet' => $wallet,
        ]);
    }
    // electronic pay
    public function deposit(Request $request)
    {
        // valid request
        $validator = Validator::make($request->only('amount', 'trans_token', 'email'), [
            'amount' => 'required|numeric|max:10000|min:1',
            'trans_token' => 'required',
            'email' => 'required|email',
        ]);
        // Send failed response if request is not valid
        if ($validator->fails()) {
            return $this->returnValidationErrors($validator->messages());
        }
        $user = Auth::user();
        $wallet = $user->wallet;
        if (!$user->wallet) {
            return $this->returnError(400, 'You don\'t have a wallet');
        }
        $wallet->update(['amount' => $wallet->amount]);
        $create = WalletDeposit::create([
            'wallet_id' => $wallet->id,
            'amount' => $request->amount,
            'email' => $request->email,
        ]);
        if ($create) {
            return $this->returnSuccess('deposit succefully');
        } else {
            return $this->returnError(400, 'Fail in deposit');
        }
    }

    public function requestDeposit(Request $request)
    {
        // valid request
        $validator = Validator::make($request->only('amount', 'full_name', 'whatsapp_number', 'pref_payment_method', 'country'), [
            'amount' => 'required|numeric|max:10000|min:1',
            'full_name' => 'required|string|max:255',
            'whatsapp_number' => 'required|string|max:255',
            'pref_payment_method' => 'required|string|max:255',
            'country' => 'required|string|max:255',
        ]);
        // Send failed response if request is not valid
        if ($validator->fails()) {
            return $this->returnValidationErrors($validator->messages());
        }
        $user = Auth::user();
        $wallet = $user->wallet;
        if (!$user->wallet) {
            return $this->returnError(400, 'You don\'t have a wallet');
        }
        $wallet->update(['amount' => $wallet->amount]);
        $create = WalletDepositRequest::create([
            'wallet_id' => $wallet->id,
            'amount' => $request->amount,
            'full_name' => $request->full_name,
            'whatsapp_number' => $request->whatsapp_number,
            'pref_payment_method' => $request->pref_payment_method,
            'country' => $request->country,
        ]);
        if ($create) {
            return $this->returnSuccess('deposit request succefully');
        } else {
            return $this->returnError(400, 'Fail in deposit');
        }
    }

    public function withdraw(Request $request)
    {
        // valid request
        $validator = Validator::make($request->only('amount', 'trans_token', 'email'), [
            'amount' => 'required|numeric|max:10000|min:1',
            'trans_token' => 'required',
            'email' => 'required|email',
        ]);
        // Send failed response if request is not valid
        if ($validator->fails()) {
            return $this->returnValidationErrors($validator->messages());
        }
        $user = Auth::user();
        $wallet = $user->wallet;
        if (!$user->wallet) {
            return $this->returnError(400, 'You don\'t have a wallet');
        }
        if ($wallet->amount - $request->amount < 0) {
            return $this->returnError(400, 'You don\'t have enough amount');
        }
        $wallet->update(['amount' => $wallet->amount - $request->amount]);
        $create = WalletWithdraw::create([
            'wallet_id' => $wallet->id,
            'amount' => $request->amount,
            'email' => $request->email,
        ]);
        if ($create) {
            return $this->returnSuccess('withdraw succefully');
        } else {
            return $this->returnError(400, 'Fail in withdraw');
        }
    }

    public function requestWithdraw(Request $request)
    {
        // valid withdraw
        $validator = Validator::make($request->only('amount', 'full_name', 'whatsapp_number', 'pref_payment_method', 'country'), [
            'amount' => 'required|numeric|max:10000|min:1',
            'full_name' => 'required|string|max:255',
            'whatsapp_number' => 'required|string|max:255',
            'pref_payment_method' => 'required|string|max:255',
            'country' => 'required|string|max:255',
        ]);
        // Send failed response if request is not valid
        if ($validator->fails()) {
            return $this->returnValidationErrors($validator->messages());
        }
        $user = Auth::user();
        $wallet = $user->wallet;
        if (!$user->wallet) {
            return $this->returnError(400, 'You don\'t have a wallet');
        }

        $create = WalletWithdrawRequest::create([
            'wallet_id' => $wallet->id,
            'amount' => $request->amount,
            'full_name' => $request->full_name,
            'whatsapp_number' => $request->whatsapp_number,
            'pref_payment_method' => $request->pref_payment_method,
            'country' => $request->country,
        ]);
        if ($create) {
            return $this->returnSuccess('withdraw request succefully');
        } else {
            return $this->returnError(400, 'Fail in withdraw');
        }
    }
}
