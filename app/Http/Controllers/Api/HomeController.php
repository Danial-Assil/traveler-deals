<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Traits\ApiResponseTrait;
use App\Models\AppModel;
use App\Models\Order;
use App\Models\Trip;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class HomeController extends AppController
{
    //
    use ApiResponseTrait;
    public function __construct(AppModel $model)
    {
        parent::__construct($model);
    }

    public function home(Request $request)
    {
        $trips = Trip::published()->where([
            ['departure_date', '>', Carbon::now()->today()]
        ])->with('user:id,first_name,last_name')->latest();
        $orders = Order::where([
            ['before_date', '>', Carbon::now()->today()],
            ['status', 1],
        ])->with('order_items', 'user:id,first_name,last_name')->latest();
        $pg = 10;
        if ($request->from || $request->to || $request->weight || $request->before_date || $request->shopper || $request->traveler) {
            $pg = 5;
        }
        if ($request->from) {
            $trips = $trips->where('from_place',  explode(' - ', $request->from)[0])->where('from_country', explode(' - ', $request->from)[1]);
            $orders = $orders->where('from_place',  explode(' - ', $request->from)[0])->where('from_country', explode(' - ', $request->from)[1]);
        }
        if ($request->to) {
            $trips = $trips->where('to_place',  explode(' - ', $request->to)[0])->where('to_country', explode(' - ', $request->to)[1]);
            $orders = $orders->where('to_place',  explode(' - ', $request->to)[0])->where('to_country', explode(' - ', $request->to)[1]);
        }
        if ($request->weight) {
            $trips = $trips->where('available_weight',  $request->weight);
            $orders = $orders->where('total_weight',  $request->weight);
        }
        if ($request->before_date) {
            $trips = $trips->where('departure_date', '<=', $request->before_date);
            $orders = $orders->where('before_date', '<=', $request->before_date);
        }
        if (isset($request->shopper) && $request->shopper == 0) {
            $trips = $trips->where('deal_method', '!=', 1);
            $orders = $orders->where('deal_method',  '!=', 1);
        }
        if (isset($request->traveler) && $request->traveler == 0) {
            $trips = $trips->where('deal_method', '!=', 2);
            $orders = $orders->where('deal_method',  '!=', 2);
        }
        $trips = $trips->paginate($pg, ['*'], 'page', $request->trips_page ? $request->trips_page : 1);
        $trips_items = [];
        foreach ($trips as $trip) {
            $trips_item['id'] = $trip->id;
            $trips_item['from'] = $trip->from_place;
            $trips_item['to'] = $trip->to_place;
            $trips_item['deal_method'] = $trip->deal_method_txt;
            $categories_not_accept = [];
            foreach ($trip->categories_not_accept as $cat) {
                array_push($categories_not_accept, $cat->title);
            }
            $trips_item['categories_not_accept'] = $categories_not_accept;
            $trips_item['departure_date_time'] =  Carbon::parse($trip->departure_date)->format('D, d M') . ' ' . Carbon::parse($trip->departure_time)->format('g:i A');
            $trips_item['departure_date'] =  Carbon::parse($trip->departure_date)->format('D, d M');
            $trips_item['departure_time'] = Carbon::parse($trip->departure_time)->format('g:i A');

            $trips_item['delivery_date_from'] = $trip->delivery_date_from;
            $trips_item['delivery_date_to'] = $trip->delivery_date_to;
            $trips_item['pickup_place'] = $trip->pickup_place;
            $trips_item['notes'] = $trip->notes;

            $trips_item['available_weight'] = $trip->available_weight;
            $trips_item['reserved_weight'] = $trip->reserved_weight;
            $trips_item['user']['full_name'] = $trip->user->full_name;
            $trips_item['user']['image'] = $trip->user->image_path;
            $trips_item['user']['rating'] = number_format($trip->user->traveler_rating, 2);
            array_push($trips_items, $trips_item);
        }
        $orders = $orders->paginate($pg, ['*'], 'page', $request->orders_page ? $request->orders_page : 1);
        $orders_items = [];
        foreach ($orders as $order) {
            $orders_item['id'] = $order->id;
            $orders_item['name'] = $order->name;
            $orders_item['photo_path'] =  $order->image_path_thumb;
            $orders_item['from'] = $order->from_place;
            $orders_item['to'] = $order->to_place;
            $orders_item['before_date'] = $order->before_date;
            $orders_item['reward'] = $order->reward;
            $orders_item['total_price'] = $order->total_price;
            $orders_item['products_count'] = count($order->order_items);
            $orders_item['user']['full_name'] = $order->user->full_name;
            $orders_item['user']['image'] = $order->user->image_path;
            $orders_item['user']['rating'] = number_format($order->user->shopper_rating, 2);
            array_push($orders_items, $orders_item);
        }
        $user = Auth::user();

        $data = [
            'trips' => $trips_items,
            'orders' => $orders_items,
            'user' => [
                'id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name, 
                'image_path' => $user->image_path,
                'email' => $user->email,
                'mobile' => $user->mobile,
                'passport' => $user->passport ? 1 : 0,
                'id_card' => $user->id_card ? 1 : 0,
                // 0 => no , 1 => pending , 2 => yes
                'account_verified' => $user->id_card || $user->passport ? 2 : ($user->attachements->where('reply_at', null)->count() > 0 ? 1 :  0),
            ],

        ];

        return $this->returnData($data);
    }
}
