@extends('dash.layouts.app')
@section('content')

<div class="section-body">
    <h2 class="section-title">{{ $item->full_name }}</h2>

    <div class="row mt-sm-4">
        <div class="col-12 col-md-12 ">
            <div class="card profile-widget">
                <div class="profile-widget-header">
                    <img alt="image" src="{{ $item->image_path }}" class="rounded-circle profile-widget-picture">
                    <div class="profile-widget-items">
                        <div class="profile-widget-item">
                            <div class="profile-widget-item-label">{{ trans('trips.module_title')}}</div>
                            <div class="profile-widget-item-value">{{ count($item->trips) }}</div>
                        </div>
                        <div class="profile-widget-item">
                            <div class="profile-widget-item-label">{{ trans('orders.module_title')}}</div>
                            <div class="profile-widget-item-value">{{ count($item->orders) }}</div>
                        </div>
                        <div class="profile-widget-item">
                            <div class="profile-widget-item-label">{{ trans('deals.module_title')}}</div>
                            <div class="profile-widget-item-value">{{ count($item->trips) }}</div>
                        </div>
                        <div class="profile-widget-item">
                            <div class="profile-widget-item-label">{{ trans('users.shoppers_rating')}}</div>
                            <div class="profile-widget-item-value">{!! $item->getShopperRatingStars() !!}</div>
                        </div>
                        <div class="profile-widget-item">
                            <div class="profile-widget-item-label">{{ trans('users.travelers_rating')}}</div>
                            <div class="profile-widget-item-value">{!! $item->getTravelerRatingStars()  !!}</div>
                        </div>
                    </div>
                </div>
                <div class="profile-widget-description">
                    <div class="mb-4">
                        <h3 class="mb-3" style="font-size: 1.2rem;">- {{trans('users.personal_info') }} : </h3>
                        <div class="row">
                            <div class="col-md-4 mb-1">
                                <b>{{ trans('users.first_name') }} : </b> {{ $item->first_name }}
                            </div>
                            <div class="col-md-4 mb-1">
                                <b>{{ trans('users.last_name') }} : </b> {{ $item->last_name }}
                            </div>
                            <div class="col-md-4 mb-1">
                                <b>{{ trans('users.mobile') }} : </b> <span style="direction: ltr;display: inline-block;">{{ $item->mobile }}</span>
                            </div>
                            <div class="col-md-4 mb-1">
                                <b>{{ trans('users.email') }} : </b> {{ $item->email }}
                            </div>
                            <div class="col-md-4 mb-1">
                                <b>{{ trans('users.verified') }} : </b> {{ $item->is_verified ? trans('dash.yes') : trans('dash.no') }}
                            </div>
                            @if( $item->is_verified )
                            <div class="col-md-4 mb-1">
                                <b>{{ trans('users.email_verified_at') }} : </b> {{ $item->email_verified_at }}
                            </div>
                            <div class="col-md-4 mb-1">
                                <b>{{ trans('users.mobile_verified_at') }} : </b> {{ $item->mobile_verified_at }}
                            </div>
                            <div class="col-md-4 mb-1">
                                <b>{{ trans('users.birthdate') }} : </b> {{ $item->birthdate }}
                            </div>
                            <div class="col-md-4 mb-1">
                                <b>{{ trans('users.invitation_code') }} : </b> {{ $item->invitation_code }}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="mb-4">
                        <h3 class="mb-3" style="font-size: 1.2rem;">- {{trans('users.data') }} : </h3>
                        <ul class="nav nav-tabs" id="myTab2" role="tablist" style="padding-right: 0;">
                            <li class="nav-item">
                                <a class="nav-link active" id="trips-tab2" data-toggle="tab" href="#trips" role="tab" aria-controls="trips" aria-selected="true">{{ trans('trips.module_title') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab2" data-toggle="tab" href="#orders" role="tab" aria-controls="profile" aria-selected="false">{{ trans('orders.module_title') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="contact-tab2" data-toggle="tab" href="#deals" role="tab" aria-controls="contact" aria-selected="false">{{ trans('deals.module_title') }}</a>
                            </li>
                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade show active" id="trips" role="tabpanel" aria-labelledby="home-tab2">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                            <tr>
                                                <th width="30" class="text-center">#</th>
                                                <th>{{ trans('dash.from') }}</th>
                                                <th>{{ trans('dash.to') }}</th>
                                                <th>{{ trans('trips.departure_date') }}</th>
                                                <th>{{ trans('trips.available_weight') }}</th>
                                                <th>{{ trans('trips.requests_count') }}</th>
                                                <th width="140">{{ trans('dash.action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach( $item->trips as $trip)
                                            <tr>
                                                <td> {{ $loop->iteration }} </td>
                                                <td>{{ $trip->getFrom()  }}</td>
                                                <td>{{ $trip->getTo()  }}</td>
                                                <td>{{ $trip->departure_date }}</td>
                                                <td>{{ $trip->available_weight }}</td>
                                                <td>{{ count($trip->requests) }}</td>
                                                <td> 
                                                    {{ view('dash.components.actions')->with(['item' => $trip, 'module_name' => 'trips' ,'module_actions' => ['show']]) }}
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="orders" role="tabpanel" aria-labelledby="profile-tab2">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                            <tr>
                                                <th width="30" class="text-center">#</th>
                                                <th>{{ trans('orders.name') }}</th>
                                                <th>{{ trans('dash.from') }}</th>
                                                <th>{{ trans('dash.to') }}</th>
                                                <th>{{ trans('orders.offers_count') }}</th>
                                                <th>{{ trans('orders.items_count') }}</th>
                                                <th width="140">{{ trans('dash.action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach( $item->orders as $order)
                                            <tr>
                                                <td> {{ $loop->iteration }} </td>
                                                <td>{{ $order->name }}</td>
                                                <td>{{ $order->getFrom() }}</td>
                                                <td>{{ $order->getTo() }}</td>
                                                <td>{{ $order->weight }}</td>
                                                <td>{{ count($order->order_items) }}</td>
                                                <td>
                                                    {{ view('dash.components.actions')->with(['item' => $order, 'module_name' => 'orders' ,'module_actions' => ['show']]) }}
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="deals" role="tabpanel" aria-labelledby="contact-tab2">

                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <h3 class="mb-3" style="font-size: 1.2rem;">- {{trans('users.wallet') }} : </h3>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


@endsection