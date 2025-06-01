<?php

namespace App\Http\Controllers\Api;

use App\Events\User\OrderPayed;
use App\Events\User\OrderPickedUp;
use App\Events\User\TravelerPayedOrder;
use App\Models\Order;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Deal;
use App\Models\DealStatus;
use App\Models\OrderOffer;
use App\Models\ReviewRating;
use App\Models\Trip;
use App\Models\TripRequest;
use App\Models\WalletPayment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Str;

class DealController extends AppController
{
    //
    use ApiResponseTrait;
    public function __construct(Deal $model)
    {
        parent::__construct($model);
    }



    public function getDeal(Request $request)
    {
        // valid request
        $validator = Validator::make($request->only('order_id'), [
            'order_id' => 'required|exists:orders,id',
        ]);
        // Send failed response if request is not valid
        if ($validator->fails()) {
            return $this->returnValidationErrors($validator->messages());
        }
        $order = Order::find($request->order_id); // ->with('order_items')->withCount('offers')->first();

        $deal = $order->current_deal();
        if (!$deal) {
            return $this->returnError(400, 'Deal doesnt existed');
        }
        $order_item = $order->order_items->first();
        $product['id'] = $order_item->id;
        $product['category'] = $order_item->category->title;
        $product['with_box'] = $order_item->with_box;
        $product['link'] = $order_item->link;
        $product['name'] = $order_item->name;
        $product['quantity'] = $order_item->quantity;
        $product['price'] = $order_item->price;
        $product['weight'] = $order_item->weight;
        $product['photos'] = $order_item->images->pluck('image_path');

        $item = [
            'id' => $order->id,
            'name' => $order->name,
            'from' => $order->from_place,
            'to' => $order->to_place,
            'before_date' => $order->before_date,
            'reward' => $deal->reward,
            'amount' => $deal->amount,
            'total_price' => $order->total_price,
            'payment_processing' => $order->payment_processing,
            'fees' => $order->fees,
            'estimated_total' => $deal->estimated_total,
            'deal_method' => $order->getDealMethodTxtAttribute(),
            'product' => $product,
            'status_txt' => $order->status_txt,
            'user' => [
                'full_name' => $order->user->full_name,
                'image' => $order->user->image_path,
                'rating' => number_format($order->user->shopper_rating, 2)
            ]
        ];
        $data = [
            'deal' => $item,
        ];
        return $this->returnData($data);
    }

    // tracking order
    public function getDealStatuses(Request $request)
    {
        // valid request
        $validator = Validator::make($request->only('order_id'), [
            'order_id' => 'required|exists:orders,id',
        ]);
        // Send failed response if request is not valid
        if ($validator->fails()) {
            return $this->returnValidationErrors($validator->messages());
        }
        $order = Order::find($request->order_id);
        $deal = $order->current_deal();
        $trip = Trip::find($deal->trip_id);
        if (!$deal) {
            return $this->returnError(400, 'Deal doesnt existed');
        }

        $statuses = [];
        foreach ($deal->statuses as $deal_status) {
            $status['txt'] = $deal_status->deal_txt();
            $status['is_done'] = true;
            $status['done_at'] = $deal_status->created_at->format('Y-m-d') . ' ' . $deal_status->created_at->format('h:i');
            array_push($statuses, $status);
        }
        foreach ($deal->next_steps() as $step) {
            $status['txt'] = $step;
            $status['is_done'] = false;
            $status['done_at'] = null;
            array_push($statuses, $status);
        }

        if ($trip->user->id != Auth::user()->id) {
            $user['full_name'] = $trip->user->full_name;
            $user['id'] = $trip->user->id;
            $user['rating'] = number_format($trip->user->traveler_rating, 2);
            $user['image'] =  $trip->user->image_path;
        } else {
            $user['full_name'] = $order->user->full_name;
            $user['id'] = $order->user->id;
            $user['rating'] = number_format($order->user->traveler_rating, 2);
            $user['image'] =  $order->user->image_path;
        }


        $data = [
            'deal' => [
                'from' => $trip->from_place,
                'to' => $trip->to_place,
                'available_weight' => $trip->available_weight,
                'reserved_weight' => $trip->reserved_weight,
                'before_date' => $order->before_date,
                'name' => $order->name,
                'reward' => $deal->reward,
                'status' => $deal->status,
                'status_txt' => $deal->status_txt,
                'user' => $user,
                'shopper_rated' => $deal->shopper_rated,
                'traveler_rated' => $deal->traveler_rated,
            ],
            'statuses' => $statuses
        ];
        if (Auth::user()->id == $deal->trip->user_id) {
            $data['deal']['qr_code'] = $deal->qr_code;
        }
        return $this->returnData($data);
    }

    // public function cancelDeal(Request $request)
    // {
    //     // valid request
    //     $validator = Validator::make($request->only('order_id'), [
    //         'order_id' => 'required|exists:orders,id',
    //     ]);
    //     // Send failed response if request is not valid
    //     if ($validator->fails()) {
    //         return $this->returnValidationErrors($validator->messages());
    //     }
    //     $order = Order::find($request->order_id);

    //     $deal = $order->current_deal();
    //     if (!$deal) {
    //         return $this->returnError(400, 'Deal doesnt existed');
    //     }
    //     $update = $deal->update(['status' => 2]);
    //     $update = $order->update(['status' => 1]);
    //       if ($deal->dealable_type == OrderOffer::class) {
    //         $item = OrderOffer::find($deal->dealable_id);
    //     } else {
    //         $item = TripRequest::find($deal->dealable_id);
    //     }
    //     $item->update(['status' => 5]); // canceled
    //     return $this->returnSuccess('done');
    // }

    // shopper pay for create a deal
    public function pay(Request $request)
    {
        // valid request
        $validator = Validator::make($request->only('order_id'), [
            'order_id' => 'required|exists:orders,id',
            // 'trans_token' => 'required',
        ]);
        // Send failed response if request is not valid
        if ($validator->fails()) {
            return $this->returnValidationErrors($validator->messages());
        }
        $order = Order::find($request->order_id);
        $accept_offer = $order->offers->where('status', 2)->first();
        $accept_request = $order->requests->where('status', 2)->first();

        if ($accept_offer) { // offer
            $accepted_item = $accept_offer;
            $type = 1;
            $reward = $accept_offer->reward;
            $amount = $accepted_item->amount;
            $estimated_total = $accepted_item->amount + $accepted_item->reward + $order->total_price + $order->payment_processing + $order->fees;
        } else { // request
            $accepted_item = $accept_request;
            $type = 2;
            $reward = $order->reward;
            $amount = 0;
            $estimated_total = $order->estimated_total;
        }

        if (!$accepted_item) {
            return $this->returnError(400, trans('Not exist accepted item'));
        }

        $user = Auth::user();
        // $user->payments->create([
        //     'type' => 2,
        //     'trans_token' => 'hhhh',
        //     'amount' => $accepted_item->estimated_total
        // ]);

        $deal = Deal::create([
            'trip_id' => $accepted_item->trip_id,
            'order_id' => $accepted_item->order_id,
            'qr_code' =>  Str::random(50),
            'reward' => $reward,
            'amount' => $amount,
            'estimated_total' =>  $estimated_total,
            'dealable_id' => $accepted_item->id,
            'dealable_type' => $type == 1 ? OrderOffer::class : TripRequest::class,
            'shopper_payed' => 1,
            'shopper_payed_at' => Carbon::now(),
            'status' => $order->deal_method == 1 ? 1 : 2
        ]);

        DealStatus::create([
            'deal_id' => $deal->id,
            'new_status' => 1, // The shopper has made the payment.
            'type' => 1, // shopper 
        ]);

        foreach ($order->offers as $offer) {
            $offer->update(['status' => 5]);
        }
        foreach ($order->requests as $request) {
            $request->update(['status' => 5]);
        }
        $accepted_item->update(['status' => 2]);
        event(new OrderPayed($deal));

        return $this->returnSuccess('done');
    }

    // shopper pay by wallet  for create a deal
    public function payByWallet(Request $request)
    {
        // valid request
        $validator = Validator::make($request->only('order_id'), [
            'order_id' => 'required|exists:orders,id',
        ]);
        // Send failed response if request is not valid
        if ($validator->fails()) {
            return $this->returnValidationErrors($validator->messages());
        }
        $order = Order::find($request->order_id);
        $accept_offer = $order->offers->where('status', 2)->first();
        $accept_request = $order->requests->where('status', 2)->first();

        if ($accept_offer) { // offer
            $accepted_item = $accept_offer;
            $type = 1;
            $reward = $accept_offer->reward;
            $amount = $accepted_item->amount;
            $estimated_total = $accepted_item->amount + $accepted_item->reward + $order->total_price + $order->payment_processing + $order->fees;
        } else { // request
            $accepted_item = $accept_request;
            $type = 2;
            $reward = $order->reward;
            $amount = 0;
            $estimated_total = $order->estimated_total;
        }

        if (!$accepted_item) {
            return $this->returnError(400, trans('Not exist accepted item'));
        }

        $user = Auth::user();
        $wallet = $user->wallet;
        if ($wallet->amount < $accepted_item->estimated_total) {
            return $this->returnError(400, trans('Wallet amount does\'nt enough'));
        }
        $wallet->update(['amount' => $wallet->amount - $accepted_item->estimated_total]);
        $user->payments->create([
            'amount' => $accepted_item->estimated_total
        ]);

        $deal = Deal::create([
            'trip_id' => $accepted_item->trip_id,
            'order_id' => $accepted_item->order_id,
            'qr_code' =>  Str::random(50),
            'reward' => $reward,
            'amount' => $amount,
            'estimated_total' =>  $estimated_total,
            'dealable_id' => $accepted_item->id,
            'dealable_type' => $type == 1 ? OrderOffer::class : TripRequest::class,
            'shopper_payed' => 1,
            'shopper_payed_at' => Carbon::now(),
            'status' => $order->deal_method == 1 ? 1 : 2
        ]);

        DealStatus::create([
            'deal_id' => $deal->id,
            'new_status' => 1, // The shopper has made the payment.
            'type' => 1, // shopper 
        ]);

        foreach ($order->offers as $offer) {
            $offer->update(['status' => 5]);
        }
        foreach ($order->requests as $request) {
            $request->update(['status' => 5]);
        }
        $accepted_item->update(['status' => 2]);
        event(new OrderPayed($deal));

        return $this->returnSuccess('done');
    }

    // traveler pay if the deal method by traveler
    public function payByTraveler(Request $request)
    {
        // valid request
        $validator = Validator::make($request->only('order_id'), [
            'order_id' => 'required|exists:orders,id',
            // 'trans_token' => 'required',
        ]);
        // Send failed response if request is not valid
        if ($validator->fails()) {
            return $this->returnValidationErrors($validator->messages());
        }

        $order = Order::find($request->order_id);
        $deal = $order->current_deal();

        if (!$deal) {
            return $this->returnError(400, trans('Not exist active deal'));
        }
        if ($order->deal_method == 2) {
            return $this->returnError(400, trans('Deal method not valid'));
        }
        if ($deal->traveler_payed) {
            return $this->returnError(400, trans('Traveler already payed'));
        }
        $deal->update(['traveler_payed' => 1, 'traveler_payed_at' => Carbon::now(), 'status' => 2]);
        DealStatus::create([
            'deal_id' => $deal->id,
            'new_status' => 2, // The Traveler has made the payment.  
            'type' => 2, // Traveler 
        ]);

        $user = Auth::user();
        // $user->payments->create([
        //     'type' => 2,
        //     'trans_token' => $request->trans_token,
        //     'amount' => 0
        // ]);

        event(new TravelerPayedOrder($deal));
        return $this->returnSuccess('done');
    }

    public function pickUp(Request $request)
    {
        // valid request
        $validator = Validator::make($request->only('order_id'), [
            'order_id' => 'required|exists:orders,id',
        ]);
        // Send failed response if request is not valid
        if ($validator->fails()) {
            return $this->returnValidationErrors($validator->messages());
        }

        $order = Order::find($request->order_id);
        $deal = $order->current_deal();
        $deal->update(['status' => 3]); // picked
        $order->update(['status' => 3]); // order in_transit
        $deal_status = DealStatus::create([
            'deal_id' => $deal->id,
            'new_status' => 3, //  The Traveler picked up the item.
            'type' => 2, // traveler 
        ]);
        event(new OrderPickedUp($order));
        return $this->returnSuccess('done');
    }

    public function deliver(Request $request)
    {
        // valid request
        $validator = Validator::make($request->only('order_id', 'qr_code'), [
            'order_id' => 'required|exists:orders,id',
            'qr_code' => 'required'
        ]);
        // Send failed response if request is not valid
        if ($validator->fails()) {
            return $this->returnValidationErrors($validator->messages());
        }

        $deal = Order::find($request->order_id)->current_deal();

        if (Auth::user()->id != $deal->order->user_id) {
            return $this->returnError(403, 'Not Allowed');
        }
        if ($request->qr_code != $deal->qr_code) {
            return $this->returnError(403, 'Qr Not Valid');
        }
        $deal->update(['status' => 4]); // delivered
        $deal->order->update(['status' => 4]); // order delivered
        $deal_status = DealStatus::create([
            'deal_id' => $deal->id,
            'new_status' => 4, // The shopper confirmed the delivery.
            'type' => 1, // shopper
            'done_at' => Carbon::now(),
        ]);

        return $this->returnSuccess('done');
    }

    public function rateTraveler(Request $request)
    {
        // valid request
        $validator = Validator::make($request->only('order_id', 'star_rating', 'comment'), [
            'order_id' => 'required|exists:orders,id',
            'star_rating' => 'required',
            'comment' => 'required|max:255',
        ]);
        // Send failed response if request is not valid
        if ($validator->fails()) {
            return $this->returnValidationErrors($validator->messages());
        }

        $deal = Order::find($request->order_id)->current_deal();
        $deal->update(['shopper_rated' => 1]); // the shopper has rated the traveler
        ReviewRating::create([
            'deal_id' => $deal->id,
            'user_id' => Auth::user()->id,
            'rated_id' =>  $deal->trip->user_id,
            'star_rating' => $request->star_rating,
            'comment' => $request->comment,
        ]);

        $deal_status = DealStatus::create([
            'deal_id' => $deal->id,
            'new_status' => 5, // Rate the shopper  
            'type' => 2, // Traveler
            'done_at' => Carbon::now(),
        ]);

        return $this->returnSuccess('done');
    }

    public function rateShopper(Request $request)
    {
        // valid request
        $validator = Validator::make($request->only('order_id', 'star_rating', 'comment'), [
            'order_id' => 'required|exists:orders,id',
            'star_rating' => 'required',
            'comment' => 'required|max:255',
        ]);
        // Send failed response if request is not valid
        if ($validator->fails()) {
            return $this->returnValidationErrors($validator->messages());
        }

        $deal = Order::find($request->order_id)->current_deal();
        $deal->update(['traveler_rated' => 1]); // the traveler has rated the shopper
        ReviewRating::create([
            'deal_id' => $deal->id,
            'user_id' => Auth::user()->id,
            'rated_id' =>  $deal->order->user_id,
            'star_rating' => $request->star_rating,
            'comment' => $request->comment,
        ]);
        $deal_status = DealStatus::create([
            'deal_id' => $deal->id,
            'new_status' => 5, // Rate the traveler  
            'type' => 1, // Shopper
            'done_at' => Carbon::now(),
        ]);

        return $this->returnSuccess('done');
    }
}
