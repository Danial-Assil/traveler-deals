<?php

namespace App\Http\Controllers\Api;

use App\Events\User\NewTripRequest;
use App\Events\User\TripRequestAccepted;
use App\Http\Requests\Api\AddRequestRequest;

use App\Models\Trip;
use App\Models\TripRequest;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Traits\UploadImage;
use App\Models\Order;
use App\Models\User;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TripController extends AppController
{
    // 
    public function __construct(Trip $model)
    {
        parent::__construct($model);
    }

    public function index()
    {
        $data = [
            'trips' =>  Trip::all()->orderBy('created_at'),
        ];

        return $this->returnData($data);
    }


    public function getMyTrips()
    {
        $trips =  Auth::user()->trips()->latest()->get();
        $trips_active = [];
        $trips_inactive = [];

        foreach ($trips as $trip) {
            $temp_trip['id'] = $trip->id;
            $temp_trip['from'] = $trip->from_place;
            $temp_trip['to'] = $trip->to_place;
            $temp_trip['deal_method'] = $trip->deal_method_txt;
            $temp_trip['available_weight'] = $trip->available_weight;
            $temp_trip['reserved_weight'] = $trip->reserved_weight;
            $temp_trip['departure_date'] = $trip->departure_date;
            $temp_trip['arrive_date'] = $trip->arrive_date;
            $temp_trip['requests_count'] = 0;
            $temp_trip['deals_count'] = 0;
            $temp_trip['earnings_count'] = 0;
            $temp_trip['status'] = $trip->status;
            if ($trip->status == 2 && $trip->delivery_date_to >= Carbon::now()->today()) {

                $temp_trip['status_txt'] = trans('dash.accepted');
                $temp_trip['requests_count'] = $trip->requests->count();
                $temp_trip['deals_count'] = $trip->deals->count();
                $temp_trip['earnings_count'] = $trip->deals->count();

                array_push($trips_active, $temp_trip);
            } else {
                if ($trip->status == 1) {
                    $temp_trip['status_txt'] = trans('trips.inreview');
                } else if ($trip->status == 3) {
                    $temp_trip['status_txt'] = trans('trips.incomplete');
                } else if ($trip->departure_date <= Carbon::now()->today()) {
                    $temp_trip['status_txt'] = trans('trips.ended');
                }
                array_push($trips_inactive, $temp_trip);
            }
        }

        $data = [
            'trips_active' =>  $trips_active,
            'trips_inactive' =>  $trips_inactive
        ];
        return $this->returnData($data);
    }

    public function store(Request $request)
    {

        $req = $request->all();
        $req['categories_not_accept'] = json_decode($request->categories_not_accept);
        $val_array = [
            'from' => 'required',
            'to' => 'required',
            'available_weight' => 'required|numeric',
            'departure_date' => 'required|date|date_format:Y-m-d|after:today',
            'departure_time' => 'required',
            'delivery_date_from' => 'required|date|date_format:Y-m-d|after:today',
            'delivery_date_to' => 'required|date|date_format:Y-m-d|after:today',
            'pickup_place' => 'required',
            'booking_airline' => 'required',
            'booking_reference' => 'required',
            'booking_first_name' => 'required',
            'booking_last_name' => 'required',
            'deal_method' => 'required|numeric',
            //'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'categories_not_accept' => 'array',
            'notes' => 'nullable|string'
        ];

        $user = User::find(Auth::user()->id);
        if (!$user->document_verified) {
            $val_array['photo'] = 'required|image|mimes:jpg,jpeg,png|max:2048';
        }
        $validator = Validator::make($req, $val_array);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return $this->returnValidationErrors($validator->messages());
        }

        $data = [
            'user_id' =>  Auth::user()->id,
            'from_place' => explode(' - ', $request->from)[0],
            'to_place' => explode(' - ', $request->to)[0],
            'from_country' => explode(' - ', $request->from)[1],
            'to_country' => explode(' - ', $request->to)[1],
            'available_weight' =>  $request->available_weight,
            'departure_date' =>  $request->departure_date,
            'departure_time' =>  $request->departure_time,
            'delivery_date_from' =>  $request->delivery_date_from,
            'delivery_date_to' =>  $request->delivery_date_to,
            'pickup_place' =>  $request->pickup_place,
            'booking_airline' =>  $request->booking_airline,
            'booking_reference' =>  $request->booking_reference,
            'booking_first_name' =>  $request->booking_first_name,
            'booking_last_name' =>  $request->booking_last_name,
            'deal_method' =>  $request->deal_method,
            'notes' =>  $request->notes,
        ];

        if ($request->photo) {
            $photoName = $this->uploadImage($request->file('photo'), 'trips/photos');
            $data['photo'] =  $photoName;
        }

        try {
            $item = Trip::create($data);
            $categories_not_accept = json_decode($request->categories_not_accept);
            if (count($categories_not_accept)) {
                $item->categories_not_accept()->attach($categories_not_accept);
            }
            return $this->returnSuccess('Created');
        } catch (Exception $ex) {
            return $this->returnError(400, 'Not Created');
        }
    }

    public function destroy(Request $request)
    {
        // valid request
        $validator = Validator::make($request->only('trip_id'), [
            'trip_id' => 'required|exists:trips,id',
        ]);
        // Send failed response if request is not valid
        if ($validator->fails()) {
            return $this->returnValidationErrors($validator->messages());
        }
        $item = Trip::find($request->trip_id);

        try {
            $item->offers()->delete();
            $item->requests()->delete();
            $item->delete();
            return $this->returnSuccess('Deleted');
        } catch (Exception $e) {
            return $this->returnError(400, 'Not Deleted');
        }
    }

    public function update(Request $request)
    {

        $req = $request->all();
        $req['categories_not_accept'] = json_decode($request->categories_not_accept);
        $validator = Validator::make($req, [
            'trip_id' => 'required|exists:trips,id',
            'from' => 'required',
            'to' => 'required',
            'available_weight' => 'required|numeric',
            'departure_date' => 'required|date|date_format:Y-m-d|after:today',
            'departure_time' => 'required',
            'delivery_date_from' => 'required|date|date_format:Y-m-d|after:today',
            'delivery_date_to' => 'required|date|date_format:Y-m-d|after:today',
            'pickup_place' => 'required',
            'booking_airline' => 'required',
            'booking_reference' => 'required',
            'booking_first_name' => 'required',
            'booking_last_name' => 'required',
            'deal_method' => 'required|numeric',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'passport_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'categories_not_accept' => 'array',
            'notes' => 'nullable|string'
        ]);
        //Send failed response if request is not valid
        if ($validator->fails()) {
            return $this->returnValidationErrors($validator->messages());
        }


        $data = [
            'from_place' => $request->from,
            'to_place' => $request->to,
            'from_country' => $request->from_country,
            'from_city' => $request->from_city,
            'to_country' => $request->to_country,
            'to_city' => $request->to_city,
            'available_weight' =>  $request->available_weight,
            'departure_date' =>  $request->departure_date,
            'departure_time' =>  $request->departure_time,
            'delivery_date_from' =>  $request->delivery_date_from,
            'delivery_date_to' =>  $request->delivery_date_to,
            'arrive_date' =>  $request->arrive_date,
            'pickup_place' =>  $request->pickup_place,
            'booking_airline' =>  $request->booking_airline,
            'booking_reference' =>  $request->booking_reference,
            'booking_first_name' =>  $request->booking_first_name,
            'booking_last_name' =>  $request->booking_last_name,
            'deal_method' =>  $request->deal_method,
            'notes' =>  $request->notes,
        ];

        if ($request->photo) {
            $photoName = $this->uploadImage($request->file('photo'), 'photos');
            $data['photo'] = $photoName;
        }
        if ($request->passport_photo) {
            $passportPhotoName = $this->uploadImage($request->file('passport_photo'), 'passports');
            $data['passport_photo'] = $passportPhotoName;
        }

        try {
            $item = Trip::find($request->trip_id);
            $item->update($data);
            $categories_not_accept = json_decode($request->categories_not_accept);
            $item_categories_not_accept = $item->categories_not_accept->pluck('id')->toArray();

            $is_same = array_diff($categories_not_accept, $item_categories_not_accept) == array_diff($item_categories_not_accept, $categories_not_accept);

            $cancel =  array_diff($item_categories_not_accept, $categories_not_accept);
            $diff  =  array_diff($categories_not_accept, $item_categories_not_accept);

            if (!$is_same) {
                $item->categories_not_accept()->detach(array_values($cancel));
                $item->categories_not_accept()->attach(array_values($diff));
            }
            return $this->returnSuccess('Updated');
        } catch (Exception $ex) {
            return $this->returnError(400, 'Not Updated');
        }
    }

    public function getSuitableOrders(Request $request)
    {
        $validator = Validator::make($request->only('trip_id'), [
            'trip_id' => 'required|exists:trips,id',
        ]);
        // Send failed response if request is not valid
        if ($validator->fails()) {
            return $this->returnValidationErrors($validator->messages());
        }
        $trip = Trip::find($request->trip_id);
        $all_orders = Order::where([
            ['user_id', Auth::user()->id],
            ['from_country', $trip->from_country],
            ['to_country', $trip->to_country],
            ['before_date', '>=', $trip->departure_date],
            ['before_date', '>=', Carbon::now()->today()],
        ])->get();
        // $all_orders =  $all_orders->whereDoesntHave('offers', function ($query) use ($trip) {
        //     return $query->where([['trip_id',$trip->id],['status', 1]]);
        // })->get();
        $orders = [];
        foreach ($all_orders as $order) {
            $temp_order['id'] = $order->id;
            $temp_order['name'] = $order->name;
            $temp_order['photo_path'] =  $order->image_path;
            $temp_order['from'] = $order->from_place;
            $temp_order['to'] = $order->to_place;
            $temp_order['before_date'] = $order->before_date;
            $temp_order['reward'] = $order->reward;
            $temp_order['total_price'] = $order->total_price;
            $temp_order['link'] = $order->order_items->first()->link;
            $temp_order['products_count'] = count($order->order_items);
            $temp_order['offers_count'] = count($order->offers);
            array_push($orders, $temp_order);
        }
        $data = [
            'orders' =>  $orders,
        ];
        return $this->returnData($data);
    }
    public function getMatchingOrders(Request $request)
    {
        $validator = Validator::make($request->only('trip_id'), [
            'trip_id' => 'required|exists:trips,id',
        ]);
        // Send failed response if request is not valid
        if ($validator->fails()) {
            return $this->returnValidationErrors($validator->messages());
        }
        $trip = Trip::find($request->trip_id);
        $all_orders = Order::where([
            ['user_id', '!=', Auth::user()->id],
            ['from_country', $trip->from_country],
            ['to_country', $trip->to_country],
            ['before_date', '>=', $trip->departure_date],
            ['before_date', '>=', Carbon::now()->today()],
            ['status', 1]
        ])->get();
        // $all_orders =  $all_orders->whereHas('offers', function ($query) use ($trip) {
        //     return $query->where('trip_id', '!=', $trip->id);
        // })->get();
        $orders = [];
        foreach ($all_orders as $order) {
            $temp_order['id'] = $order->id;
            $temp_order['name'] = $order->name;
            $temp_order['photo_path'] =  $order->image_path;
            $temp_order['from'] = $order->from_place;
            $temp_order['to'] = $order->to_place;
            $temp_order['before_date'] = $order->before_date;
            $temp_order['reward'] = $order->reward;
            $temp_order['total_price'] = $order->total_price;
            $temp_order['link'] = $order->order_items->first()->link;
            $temp_order['products_count'] = count($order->order_items);
            $temp_order['user']['full_name'] = $order->user->full_name;
            $temp_order['user']['image'] = $order->user->image_path;
            $temp_order['user']['rating'] = number_format($order->user->shopper_rating, 2);

            array_push($orders, $temp_order);
        }
        $data = [
            'orders' =>  $orders,
        ];
        return $this->returnData($data);
    }

    public function show(Request $request)
    {
        // valid request
        $validator = Validator::make($request->only('trip_id'), [
            'trip_id' => 'required|exists:trips,id',
        ]);
        // Send failed response if request is not valid
        if ($validator->fails()) {
            return $this->returnValidationErrors($validator->messages());
        }
        $item = Trip::find($request->trip_id);
        $trip['id'] = $item->id;
        $trip['from_place'] = $item->from_place;
        $trip['to_place'] = $item->to_place;
        $trip['available_weight'] = $item->available_weight;
        $trip['deal_method'] = $item->deal_method;
        $trip['departure_date'] = $item->departure_date;
        $trip['departure_time'] = $item->departure_time;
        $trip['delivery_date_from'] = $item->delivery_date_from;
        $trip['delivery_date_to'] = $item->delivery_date_to;
        $trip['arrive_date'] = $item->arrive_date;
        $trip['pickup_place'] = $item->pickup_place;
        $trip['notes'] = $item->notes;
        $trip['booking_airline'] = $item->booking_airline;
        $trip['booking_reference'] = $item->booking_reference;
        $trip['booking_first_name'] = $item->booking_first_name;
        $trip['booking_last_name'] = $item->booking_last_name;
        $trip['photo'] = $item->photo_path;
        $trip['passport_photo'] = $item->passport_photo_path;
        $trip['categories_not_accept'] = $item->categories_not_accept->pluck('id')->toArray();
        $requests = $item->requests;
        $data = [
            'trip' => $trip,
            'requests' => $requests,
        ];
        return $this->returnData($data);
    }


    public function getRequests(Request $request)
    {
        // valid request
        $validator = Validator::make($request->only('trip_id'), [
            'trip_id' => 'required|exists:trips,id',
        ]);
        // Send failed response if request is not valid
        if ($validator->fails()) {
            return $this->returnValidationErrors($validator->messages());
        }
        $trip_item = Trip::find($request->trip_id);
        $active = [];
        $in_active = [];
        $accepted = [];
        // recieved
        foreach ($trip_item->requests as $trip_request) {
            $request_order = Order::find($trip_request->order_id);
            $recieved['type'] = 1; // received
            $recieved['id'] = $request_order->id;
            $recieved['from'] = $request_order->from_place;
            $recieved['to'] = $request_order->to_place;
            $recieved['deal_method'] = $request_order->getDealMethodTxtAttribute();

            $recieved['before_date'] = $request_order->before_date;
            $recieved['name'] = $request_order->name;
            $recieved['photo_path'] =  $request_order->image_path_thumb;
            $recieved['reward'] = $request_order->reward;
            $recieved['total_price'] = $request_order->total_price;


            $recieved['notes'] = $request_order->notes;

            $recieved['user']['full_name'] = $request_order->user->full_name;
            $recieved['user']['image'] = $request_order->user->image_path;
            $recieved['user']['rating'] = number_format($request_order->user->traveler_rating, 2);

            $recieved['request']['id'] = $trip_request->id;
            $recieved['request']['status'] = $trip_request->status;


            if ($trip_request->status == 1 && !$trip_request->is_expired) {
                $recieved['request']['expired_in'] = $trip_request->expired_in;
                array_push($active, $recieved);
            } else if ($trip_request->status == 2) {
                $recieved['request']['traveler_pay_required'] = $trip_request->order->deal_method == 1   ? 1 : 0;
                $recieved['request']['traveler_payed'] = $trip_request->order->current_deal() ? $trip_request->order->current_deal()->traveler_payed : 0;
                $recieved['request']['shopper_payed'] = $trip_request->order->current_deal() ? $trip_request->order->current_deal()->shopper_payed : 0;

                array_push($accepted, $recieved);
            } else {
                if ($request_order->status == 3) {
                    $recieved['request']['status_txt'] = trans('dash.declined');
                    $recieved['request']['reason'] = $trip_request->reason;
                }
                array_push($in_active, $recieved);
            }
        }


        // sended
        foreach ($trip_item->offers  as $trip_offer) {
            $request_order = Order::find($trip_offer->order_id);
            $sended['type'] = 2; // sended
            $sended['id'] = $request_order->id;
            $sended['from'] = $request_order->from_place;
            $sended['to'] = $request_order->to_place;
            $sended['deal_method'] = $request_order->getDealMethodTxtAttribute();

            $sended['before_date'] = $request_order->before_date;
            $sended['name'] = $request_order->name;
            $sended['photo_path'] =  $request_order->image_path_thumb;
            $sended['reward'] = $request_order->reward;
            $sended['total_price'] = $request_order->total_price;


            $sended['notes'] = $request_order->notes;

            $sended['user']['full_name'] = $request_order->user->full_name;
            $sended['user']['image'] = $request_order->user->image_path;
            $sended['user']['rating'] = number_format($request_order->user->traveler_rating, 2);

            $sended['offer']['id'] = $trip_offer->id;
            $sended['offer']['reward'] = $trip_offer->reward;
            $sended['offer']['amount'] = $trip_offer->amount;
            $sended['offer']['message'] = $trip_offer->message;

            if ($trip_offer->status == 1 && !$trip_offer->is_expired) {
                $sended['offer']['expired_in'] = $trip_offer->expired_in;
                array_push($active, $sended);
            } else if ($trip_offer->status == 2) {
                $sended['offer']['traveler_pay_required'] = $trip_offer->order->deal_method == 1 ? 1 : 0;
                $sended['offer']['traveler_payed'] = $trip_offer->order->current_deal() ? $trip_offer->order->current_deal()->traveler_payed : 0;
                $sended['offer']['shopper_payed'] = $trip_offer->order->current_deal() ? $trip_offer->order->current_deal()->shopper_payed : 0;

                array_push($accepted, $sended);
            } else {
                array_push($in_active, $sended);
            }
        }
        $data = [
            'active' => $active,
            'in_active' => $in_active,
            'accepted' => $accepted,
        ];
        return $this->returnData($data);
    }

    public function addRequest(AddRequestRequest $request)
    {
        $data = [
            'trip_id' => $request->trip_id,
            'order_id' => $request->order_id,
        ];
        $order = Order::find($request->order_id);

        if ($order->requests->where('trip_id', $request->trip_id)->where('status', 1)->count() > 0) {
            $this->returnError(400, trans('trips.have_active_request'));
        }
        $trip_request = TripRequest::create($data);
        event(new NewTripRequest($trip_request));
        return $this->returnSuccess('Done');
    }

    public function cancelRequest(Request $request)
    {
        $validator = Validator::make($request->only('request_id'), [
            'request_id' => 'required|exists:trip_requests,id',
        ]);
        // Send failed response if request is not valid
        if ($validator->fails()) {
            return $this->returnValidationErrors($validator->messages());
        }
        $sended_request = TripRequest::find($request->request_id);
        $sended_request->update(['status' => 4]);
        return $this->returnSuccess('Done');
    }

    public function acceptRequest(Request $request)
    {
        $validator = Validator::make($request->only('request_id'), [
            'request_id' => 'required|exists:trip_requests,id',
        ]);
        // Send failed response if request is not valid
        if ($validator->fails()) {
            return $this->returnValidationErrors($validator->messages());
        }
        $trip_request = TripRequest::find($request->request_id);
        $update = $trip_request->update(['status' => 2]); // status = 2 accepted
        event(new TripRequestAccepted($trip_request));

        if ($update) {
            return $this->returnSuccess('Done');
        }
    }

    public function declineRequest(Request $request)
    {
        $validator = Validator::make($request->only('request_id', 'reason'), [
            'request_id' => 'required|exists:trip_requests,id',
            'reason' => 'required|string|max:255',
        ]);
        // Send failed response if request is not valid
        if ($validator->fails()) {
            return $this->returnValidationErrors($validator->messages());
        }
        $trip_request = TripRequest::find($request->request_id);
        $update = $trip_request->update(['status' => 3, 'reason' => $request->reason]); // status = 3 declined
        if ($update) {
            return $this->returnSuccess('Done');
        }
    }
}
