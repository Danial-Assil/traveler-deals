<?php

namespace App\Http\Controllers\Api;

use App\Events\User\NewOrderOffer;
use App\Events\User\OrderOfferAccepted;
use App\Http\Requests\Api\AddOfferRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderItemImage;
use App\Models\OrderOffer;
use App\Models\Trip;
use App\Models\TripRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;
use Carbon\Carbon;

class OrderController extends AppController
{

    public function __construct(Order $model)
    {
        parent::__construct($model);
    }

    public function index()
    {
        $data = [
            'orders' =>  Order::all(),
        ];
        return $this->returnData($data);
    }


    public function getMyOrders()
    {
        $orders =  Auth::user()->orders()->latest()->get();
        $orders_requested = [];
        $orders_transit = [];
        $orders_received = [];
        $orders_inactive = [];
        foreach ($orders as $order) {
            $temp_order['id'] = $order->id;
            $temp_order['name'] = $order->name;
            $temp_order['photo_path'] =  $order->image_path;
            $temp_order['from'] = $order->from_place;
            $temp_order['to'] = $order->to_place;
            $temp_order['before_date'] = $order->before_date;
            $temp_order['reward'] =  $order->reward;
            $temp_order['total_price'] = $order->total_price;
            $temp_order['link'] = $order->order_items->first()->link;
            $temp_order['products_count'] = count($order->order_items);
            $temp_order['offers_count'] = count($order->offers);
            if (Carbon::parse($order->before_date)->format('Y-m-d') >= Carbon::now()->today() && ($order->status == 1 || $order->status == 2)) {
                $temp_order['status_txt'] = trans('orders.no_offers');
                $temp_order['status_color'] = 'ff0000';
                array_push($orders_requested, $temp_order);
            } else if ($order->status == 3) {
                $temp_order['status_txt'] = trans('orders.order_in_transit');
                $temp_order['status_color'] = 'ff0000';
                array_push($orders_transit, $temp_order);
            } else if ($order->status == 4) {
                $temp_order['status_txt'] = trans('orders.order_received');
                $temp_order['status_color'] = '000000';
                array_push($orders_received, $temp_order);
            } else if (Carbon::parse($order->before_date)->format('Y-m-d') < Carbon::now()->today() && ($order->status == 1 || $order->status == 2)) {
                $temp_order['status_txt'] = trans('orders.order_not_active');
                $temp_order['status_color'] = '000000';
                array_push($orders_inactive, $temp_order);
            }
        }
        $data = [
            'orders_requested' =>  $orders_requested,
            'orders_transit' =>  $orders_transit,
            'orders_received' =>  $orders_received,
            'orders_inactive' =>  $orders_inactive,
        ];
        return $this->returnData($data);
    }

    public function show(Request $request)
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

        $products = [];
        foreach ($order->order_items as $order_item) {
            $product['id'] = $order_item->id;
            $product['category'] = $order_item->category->title;
            $product['with_box'] = $order_item->with_box;
            $product['link'] = $order_item->link;
            $product['name'] = $order_item->name;
            $product['quantity'] =  $order_item->quantity;
            $product['price'] = $order_item->price . "";
            $product['weight'] = $order_item->weight . "";
            $product['photos'] = $order_item->images->pluck('image_path');
            array_push($products, $product);
        }
        $item = [
            'id' => $order->id,
            'name' => $order->name,
            'photo' =>  $order->image_path,
            'from' => $order->from_place,
            'to' => $order->to_place,
            'before_date' => $order->before_date,
            'reward' => $order->reward,
            'total_price' => $order->total_price,
            'fees' => $order->fees,
            'payment_processing' => $order->payment_processing,
            'deal_method' => $order->deal_method_txt,
            'products_count' => count($order->order_items),
            'products' => $products,
            'notes' => $order->notes,
            'status_txt' => $order->status_txt,
            'status' =>  $order->status,
            'user' => [
                'full_name' => $order->user->full_name,
                'image' => $order->user->image_path,
                'rating' => number_format($order->user->shopper_rating, 2)
            ]
        ];
        $data = [
            'order' => $item,
        ];
        return $this->returnData($data);
    }

    public function store(Request $request)
    {

        $req = $request->all();
        $req['products'] = json_decode($request->products, true);
        $prods = [];
        if ($req['products']) {
            foreach ($req['products'] as $pro) {
                $prod = $pro;
                $prod['photos'] = [];
                foreach ($pro['photos'] as $phot) {
                    $photo_file = $request->hasfile($phot) ? $request->file($phot) : null;
                    array_push($prod['photos'], $photo_file);
                }
                array_push($prods, $prod);
            }
            $req['products'] = $prods;
        }

        $validator = Validator::make($req, [
            'from' => 'required',
            'to' => 'required',
            'before_date' => 'required|date|date_format:Y-m-d|after:today',
            'name' => 'required|string',
            'deal_method' => 'required',
            'reward' => 'required|numeric',
            'fees' => 'required|numeric',
            'payment_processing' => 'numeric|nullable',
            'estimated_total' => 'required|numeric',
            'notes' => 'nullable',
            'products' => 'required|array',
            'products.*.link' => 'url',
            'products.*.with_box' => 'required',
            // 'products.*.name' => 'required|string',
            'products.*.quantity' => 'required|string|numeric',
            'products.*.price' => 'required|string|numeric',
            'products.*.weight' => 'required|string|numeric',
            'products.*.unit' => 'nullable|numeric',
            'products.*.category_id' => 'required|exists:categories,id',
            'products.*.photos' => 'required|array|min:1|max:10',
            'products.*.photos.*' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return $this->returnValidationErrors($validator->messages());
        }

        $data = [
            'user_id' => Auth::user()->id,
            'from_country' => explode(' - ', $request->from)[1],
            'from_place' => explode(' - ', $request->from)[0],
            'to_country' => explode(' - ', $request->to)[1],
            'to_place' => explode(' - ', $request->to)[0],
            'before_date' => $request->before_date,
            'name' => $request->name,
            'reward' => $request->reward,
            'fees' => $request->fees,
            'payment_processing' => $request->deal_method == 1 ? $request->payment_processing : 0,
            'estimated_total' => $request->estimated_total,
            'deal_method' => $request->deal_method,
            'delivery_type' => $request->delivery_type,
            'notes' => $request->notes,
        ];

        //try {
        $products = json_decode($request->products, true);
        $total_weight = 0;
        foreach ($products as $item) {
            $total_weight += ($item['weight'] * $item['quantity']);
            $total_price = $item['quantity'] * $item['price'];
        }
        $data['total_weight'] = $total_weight;
        $data['total_price'] = $total_price;

        $item = Order::create($data);

        $folder_name = $this->module_name . '/' . Carbon::now()->format("Y-m");
        foreach ($products as $product) {

            $order_item = OrderItem::create([
                'order_id' => $item->id,
                // 'name' => $product['name'],
                'link' => $product['link'],
                'with_box' => $product['with_box'],
                'quantity' => $product['quantity'],
                'price' => $product['price'],
                'weight' => $product['weight'],
                'unit' => 1, //$product['unit'],
                'category_id' => $product['category_id'],
                'photo' => null
            ]);

            $photoName = null;
            foreach ($product['photos'] as  $key => $image) {
                if ($request->hasfile($image)) {
                    $photoName = $this->uploadImage($request->file($image), $folder_name, $order_item->id . '_' . ($key + 1));
                    OrderItemImage::create([
                        'order_item_id' => $order_item->id,
                        'image' => $photoName
                    ]);
                }
            }
        }
        return $this->returnSuccess('Created');
    }

    public function destroy(Request $request)
    {
        // valid request
        $validator = Validator::make($request->only('order_id'), [
            'order_id' => 'required|exists:orders,id',
        ]);
        // Send failed response if request is not valid
        if ($validator->fails()) {
            return $this->returnValidationErrors($validator->messages());
        }
        $item = Order::find($request->order_id);

        $delete = $item->offers()->delete();
        $delete = $item->requests()->delete();
        $delete = $item->delete();
        if ($delete) {
            return $this->returnSuccess('Deleted');
        }
        return $this->returnError(400, 'Not Deleted');
    }

    public function update(Request $request)
    {
        $req = $request->all();

        $req['product'] = json_decode($request->product, true);

        $photos = [];
        if (isset($req['product']['new_photos'])) {
            foreach ($req['product']['new_photos'] as $phot) {
                $photo_file = $request->hasfile($phot) ? $request->file($phot) : null;
                array_push($photos, $photo_file);
            }
            $req['product']['new_photos'] = $photos;
        }
        // return $req;
        $validator = Validator::make($req, [
            'order_id' => 'required|exists:orders,id',
            'name' => 'required|string',
            'deal_method' => 'required',
            'reward' => 'required|numeric',
            'fees' => 'required|numeric',
            'payment_processing' => 'numeric|nullable',
            'estimated_total' => 'required|numeric',
            'notes' => 'nullable',
            'product' => 'required',
            'product.link' => 'nullable|url',
            'product.with_box' => 'required',
            // 'product.name' => 'required|string',
            'product.price' => 'required|numeric',
            'product.new_photos' => 'array|max:10',
            'product.new_photos.*' => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return $this->returnValidationErrors($validator->messages());
        }

        $item = Order::find($request->order_id);
        $data = [
            'name' => $request->name,
            'reward' => $request->reward,
            'fees' => $request->fees,
            'payment_processing' => $request->payment_processing,
            'estimated_total' => $request->estimated_total,
            'deal_method' => $request->deal_method,
            'notes' => $request->notes,
        ];

        try {
            $product = $req['product'];
            $update = $item->update($data);
            $order_item = $item->order_items->first();
            $order_item->update([
                'link' =>  $product['link'],
                'with_box' =>  $product['with_box'],
                // 'name' =>  $product['name'],
                'price' =>  $product['price']
            ]);
            if (isset($product['old_photos'])) {
                $old_images = [];
                $images = $order_item->images->pluck('image')->toArray();
                foreach ($product['old_photos'] as  $old_photo) {
                    $img_name = explode('/', $old_photo)[count(explode('/', $old_photo)) - 1];
                    array_push($old_images, $img_name);
                }
                $diff = array_diff($images, $old_images);

                foreach ($diff as $img_name) {
                    $img = $order_item->images->where('image', $img_name)->first();
                    if ($img)
                        $img->delete();
                }
            }
            if (isset($product['new_photos']) && count($product['new_photos']) > 0) {

                $photoName = null;
                foreach ($product['new_photos'] as  $key => $image) {
                    $photoName = $this->uploadImage($image, null, $key + 1);
                    OrderItemImage::create([
                        'order_item_id' => $order_item->id,
                        'image' => $photoName
                    ]);
                }
            }

            return $this->returnSuccess('Updated');
        } catch (Exception $ex) {
            return $this->returnError(400, 'Not Updated');
        }
    }

    public function getSuitableTrips(Request $request)
    {
        $validator = Validator::make($request->only('order_id'), [
            'order_id' => 'required|exists:orders,id',
        ]);
        // Send failed response if request is not valid
        if ($validator->fails()) {
            return $this->returnValidationErrors($validator->messages());
        }
        $order = Order::find($request->order_id);
        $all_trips = Trip::where([
            ['user_id', Auth::user()->id],
            ['from_country', $order->from_country],
            ['to_country', $order->to_country],
            ['departure_date', '<=', $order->before_date],
            ['departure_date', '>=', Carbon::now()->today()],
            ['status', 2]
        ])->get();
        $trips = [];
        foreach ($all_trips as $trip) {
            $temp_trip['id'] = $trip->id;
            $temp_trip['from'] = $trip->from_place;
            $temp_trip['to'] = $trip->to_place;
            $temp_trip['deal_method'] = $trip->deal_method_txt;
            $temp_trip['available_weight'] = $trip->available_weight;
            $temp_trip['reserved_weight'] = $trip->reserved_weight;
            $temp_trip['departure_date'] = $trip->departure_date;
            $temp_trip['arrive_date'] = $trip->departure_date;
            $temp_trip['requests_count'] = $trip->requests->count();
            $temp_trip['deals_count'] = $trip->deals->count();
            $temp_trip['earnings_count'] = $trip->deals->count();
            $temp_trip['status_txt'] = trans('dash.accepted');
            array_push($trips, $temp_trip);
        }
        $data = [
            'trips' =>  $trips,
        ];
        return $this->returnData($data);
    }

    public function getMatchingTrips(Request $request)
    {
        $validator = Validator::make($request->only('order_id'), [
            'order_id' => 'required|exists:orders,id',
        ]);
        // Send failed response if request is not valid
        if ($validator->fails()) {
            return $this->returnValidationErrors($validator->messages());
        }
        $order = Order::find($request->order_id);
        $all_trips = Trip::where([
            ['user_id', '!=', Auth::user()->id],
            ['from_country', $order->from_country],
            ['to_country', $order->to_country],
            ['departure_date', '<=', $order->before_date],
            ['departure_date', '>=', Carbon::now()->today()],
            ['status', 2]
        ])->get();
        $trips = [];
        foreach ($all_trips as $trip) {
            $temp_trip['id'] = $trip->id;
            $temp_trip['from'] = $trip->from_place;
            $temp_trip['to'] = $trip->to_place;
            $temp_trip['deal_method'] = $trip->deal_method_txt;
            $temp_trip['available_weight'] = $trip->available_weight;
            $temp_trip['reserved_weight'] = $trip->reserved_weight;
            $temp_trip['departure_date'] = $trip->departure_date;
            $temp_trip['arrive_date'] = $trip->departure_date;
            $temp_order['user']['full_name'] = $trip->user->full_name;
            $temp_order['user']['image'] = $trip->user->image_path;
            $temp_order['user']['rating'] = number_format($trip->user->traveler_rating);
            $temp_trip['status_txt'] = trans('dash.accepted');
            array_push($trips, $temp_trip);
        }
        $data = [
            'trips' =>  $trips,
        ];
        return $this->returnData($data);
    }

    public function addOffer(AddOfferRequest $request)
    {
        $data = [
            'trip_id' => $request->trip_id,
            'order_id' => $request->order_id,
            'reward' => $request->reward,
            'delivery_date' => $request->delivery_date,
            'message' => $request->message,
        ];
        $order = Order::find($request->order_id);
        $trip = Trip::find($request->trip_id);

        if (
            $order->offers->where('trip_id', $request->trip_id)->where('status', 2)->count() > 0
            || $order->requests->where('trip_id', $request->trip_id)->where('status', 2)->count() > 0
        ) {
            $this->returnError(400, trans('orders.have_active_offer'));
        }

        if ($trip->from_country != $order->from_country || $trip->to_country != $order->to_country || Carbon::parse($trip->departure_date) > Carbon::parse($order->before_date)) {
            return $this->returnError(400, 'This trip is not suitable for this order');
        }

        if (count(array_intersect($trip->categories_not_accept->pluck('id')->toArray(), $order->order_items->pluck('category_id')->unique()->toArray())) > 0) {
            return $this->returnError(400, 'Categories in order are not allowed this trip');
        }

        $order_offer = OrderOffer::create($data);
        event(new NewOrderOffer($order_offer));

        return $this->returnSuccess('Done');
    }

    public function cancelOffer(Request $request)
    {
        $validator = Validator::make($request->only('offer_id'), [
            'offer_id' => 'required|exists:order_offers,id',
        ]);
        // Send failed response if request is not valid
        if ($validator->fails()) {
            return $this->returnValidationErrors($validator->messages());
        }
        $sended_offer = OrderOffer::find($request->offer_id);
        $sended_offer->update(['status' => 4]);
        return $this->returnSuccess('Done');
    }

    public function getOffers(Request $request)
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
        $active = [];
        $accepted = [];
        $in_active = [];

        // recieved offers
        foreach ($order->offers as $order_offer) {
            $offer_trip = Trip::find($order_offer->trip_id);
            $recieved['type'] = 1; // received
            $recieved['id'] = $offer_trip->id;
            $recieved['from'] = $offer_trip->from_place;
            $recieved['to'] = $offer_trip->to_place;
            $recieved['deal_method'] = $offer_trip->getDealMethodTxtAttribute();
            $categories_not_accept = [];
            foreach ($offer_trip->categories_not_accept as $cat) {
                array_push($categories_not_accept, $cat->title);
            }
            $recieved['categories_not_accept'] = $categories_not_accept;
            $recieved['departure_date_time'] =  Carbon::parse($offer_trip->departure_date)->format('D, d M') . ' ' . Carbon::parse($offer_trip->departure_time)->format('g:i A');
            $recieved['departure_date'] =  Carbon::parse($offer_trip->departure_date)->format('D, d M');
            $recieved['departure_time'] = Carbon::parse($offer_trip->departure_time)->format('g:i A');

            $recieved['delivery_date_from'] = $offer_trip->delivery_date_from;
            $recieved['delivery_date_to'] = $offer_trip->delivery_date_to;
            $recieved['pickup_place'] = $offer_trip->pickup_place;
            $recieved['notes'] = $offer_trip->notes;

            $recieved['available_weight'] = $offer_trip->available_weight;
            $recieved['reserved_weight'] = $offer_trip->reserved_weight;
            $recieved['user']['full_name'] = $offer_trip->user->full_name;
            $recieved['user']['image'] = $offer_trip->user->image_path;
            $recieved['user']['rating'] = number_format($offer_trip->user->traveler_rating, 2);

            $recieved['offer']['id'] = $order_offer->id;
            $recieved['offer']['reward'] =  $order_offer->reward;
            $recieved['offer']['amount'] = $order_offer->amount;
            $recieved['offer']['status'] = $order_offer->status;
            $recieved['offer']['message'] = $order_offer->message;

            if (($order_offer->status == 1 && !$order_offer->is_expired) || ($order_offer->status == 2 && $order->current_deal() == null)) {
                $recieved['offer']['expired_in'] = $order_offer->expired_in;
                array_push($active, $recieved);
            } else if ($order_offer->status == 2 && $order->current_deal() != null && $order->current_deal()->dealable_type == OrderOffer::class && $order->current_deal()->dealable_id  == $order_offer->id) {
                $recieved['offer']['traveler_pay_required'] = $order_offer->order->deal_method == 1  ? 1 : 0;
                $recieved['offer']['traveler_payed'] = $order_offer->order->current_deal() ? $order_offer->order->current_deal()->traveler_payed : 0;
                $recieved['offer']['shopper_payed'] = $order_offer->order->current_deal() ? $order_offer->order->current_deal()->shopper_payed : 0;
                array_push($accepted, $recieved);
            } else {
                array_push($in_active, $recieved);
            }
        }

        // sended requests
        foreach ($order->requests as $sended_request) {
            $request_trip = Trip::find($sended_request->trip_id);
            $sended['type'] = 2; // sended
            $sended['id'] = $request_trip->id;
            $sended['from'] = $request_trip->from_place;
            $sended['to'] = $request_trip->to_place;
            $sended['deal_method'] = $request_trip->getDealMethodTxtAttribute();
            $categories_not_accept = [];
            foreach ($request_trip->categories_not_accept as $cat) {
                array_push($categories_not_accept, $cat->title);
            }
            $sended['categories_not_accept'] = $categories_not_accept;
            $sended['departure_date_time'] =  Carbon::parse($request_trip->departure_date)->format('D, d M') . ' ' . Carbon::parse($request_trip->departure_time)->format('g:i A');
            $sended['departure_date'] =  Carbon::parse($request_trip->departure_date)->format('D, d M');
            $sended['departure_time'] = Carbon::parse($request_trip->departure_time)->format('g:i A');

            $sended['delivery_date_from'] = $request_trip->delivery_date_from;
            $sended['delivery_date_to'] = $request_trip->delivery_date_to;
            $sended['pickup_place'] = $request_trip->pickup_place;
            $sended['notes'] = $request_trip->notes;

            $sended['available_weight'] = $request_trip->available_weight;
            $sended['reserved_weight'] = $request_trip->reserved_weight;
            $sended['user']['full_name'] = $request_trip->user->full_name;
            $sended['user']['image'] = $request_trip->user->image_path;
            $sended['user']['rating'] = number_format($request_trip->user->traveler_rating, 2);

            $sended['request']['id'] = $sended_request->id;
            $sended['request']['reward'] =  $order->reward;
            $sended['request']['status'] = $sended_request->status;

            if ((($sended_request->status == 1 && !$sended_request->is_expired) || ($sended_request->status == 2 && $order->current_deal() == null))) {
                $sended['request']['expired_in'] = $sended_request->expired_in;
                array_push($active, $sended);
            } else if ($sended_request->status == 2 && $order->current_deal() != null && $order->current_deal()->dealable_type == TripRequest::class && $order->current_deal()->dealable_id == $sended_request->id) {
                $sended['request']['traveler_pay_required'] = $sended_request->order->deal_method == 1 ? 1 : 0;
                $sended['request']['traveler_payed'] = $sended_request->order->current_deal() ? $sended_request->order->current_deal()->traveler_payed : 0;
                $sended['request']['shopper_payed'] = $sended_request->order->current_deal() ? $sended_request->order->current_deal()->shopper_payed : 0;
                array_push($accepted, $sended);
            } else {
                if ($sended_request->status == 3) {
                    $sended['request']['message'] = $sended_request->message;
                }
                array_push($in_active, $sended);
            }
        }

        $data = [
            'accepted' => $accepted,
            'active' => $active,
            'in_active' => $in_active,
        ];
        return $this->returnData($data);
    }

    public function acceptOffer(Request $request)
    {
        $validator = Validator::make($request->only('offer_id'), [
            'offer_id' => 'required|exists:order_offers,id',
        ]);
        // Send failed response if request is not valid
        if ($validator->fails()) {
            return $this->returnValidationErrors($validator->messages());
        }
        $order_offer = OrderOffer::find($request->offer_id);
        $update = $order_offer->update(['status' => 2]); // status = 2 accepted
        event(new OrderOfferAccepted($order_offer));

        if ($update) {
            return $this->returnSuccess('Done');
        }
    }

    public function declineOffer(Request $request)
    {
        $validator = Validator::make($request->only('offer_id'), [
            'offer_id' => 'required|exists:order_offers,id'
        ]);
        // Send failed response if request is not valid
        if ($validator->fails()) {
            return $this->returnValidationErrors($validator->messages());
        }
        $offer = OrderOffer::find($request->offer_id);
        $update = $offer->update(['status' => 3]); // status = 3 declined
        if ($update) {
            return $this->returnSuccess('Done');
        }
    }
    public function getOffer(Request $request)
    {
        // valid request
        $validator = Validator::make($request->only('offer_id'), [
            'offer_id' => 'required|exists:order_offers,id',
        ]);
        // Send failed response if request is not valid
        if ($validator->fails()) {
            return $this->returnValidationErrors($validator->messages());
        }
        $order_offer = OrderOffer::find($request->offer_id);

        $offer['id'] = $order_offer->id;
        $offer['reward'] = $order_offer->reward;
        $offer['amount'] = $order_offer->amount;
        $offer['message'] = $order_offer->message;

        $data = [
            'offer' => $offer,
        ];
        return $this->returnData($data);
    }
}
