@extends('dash.layouts.app')
@section('content')

<div class="section-body">
    <h2 class="section-title"> {{ trans('dash.from') }} {{ $item->from }} {{ trans('dash.to') }} {{ $item->to }}</h2>

    <div class="row mt-sm-4">
        <div class="col-12 col-md-12 ">
            <div class="card ">
                <div class="card-body p-4">
                    <div class="mb-4">
                        <h3 class="mb-3" style="font-size: 1.2rem;">- {{trans('deals.info') }} : </h3>
                        <div class="row">
                            <div class="col-md-4 mb-1">
                                <b>{{ trans('dash.from') }} : </b> {{ $item->from }}
                            </div>
                            <div class="col-md-4 mb-1">
                                <b>{{ trans('dash.to') }} : </b> {{ $item->to  }}
                            </div>
                            <div class="col-md-4 mb-1">
                                <b>{{ trans('deals.trip') }} : </b> <a href="{{ route('trips.show', $item->trip_id) }}">{{ trans('dash.details') }}</a>
                            </div>
                            <div class="col-md-4 mb-1">
                                <b>{{ trans('deals.traveler') }} : </b><a href="{{ route('users.show', $item->user_trip()->id ) }}"> {{ $item->user_trip()->full_name }}</a>
                            </div>
                            <div class="col-md-4 mb-1">
                                <b>{{ trans('deals.order') }} : </b> <a href="{{ route('orders.show', $item->order_id) }}">{{ trans('dash.details') }}</a>
                            </div>
                            <div class="col-md-4 mb-1">
                                <b>{{ trans('deals.shopper') }} : </b><a href="{{ route('users.show', $item->user_order()->id ) }}"> {{ $item->user_order()->full_name }}</a>
                            </div>
                            <div class="col-md-4 mb-1">
                                <b>{{ trans('dash.created_at') }} : </b> {{ $item->created_at }}
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="row">
                            <div class="col-md-5">
                                <h3 class="mb-3" style="font-size: 1.2rem;">- {{trans('deals.status') }} : </h3>
                                <div class="activities">
                                    <div class="activity">
                                        <div class="activity-icon bg-primary text-white shadow-primary">
                                            <i class="fas fa-check"></i>
                                        </div>
                                        <div class="activity-detail">
                                            <p>تم إنشاء الطلبية من قبل المتسوق</p>
                                            <div class="mb-2">
                                                <span class="text-job ">{{ $item->order->created_at }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="activity">
                                        <div class="activity-icon bg-primary text-white shadow-primary">
                                            <i class="fas fa-check"></i>
                                        </div>
                                        <div class="activity-detail">
                                            <p> تم قبول العرض من قبل المسافر </p>

                                            <div class="mb-2">
                                                <span class="text-job">{{ $item->order->created_at }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="activity">
                                        <div class="activity-icon bg-primary text-white shadow-primary">
                                            <i class="fas fa-check"></i>
                                        </div>
                                        <div class="activity-detail">
                                            <p> تم إدخال المستندات من قبل المسافر</p>
                                            <div class="mb-2">
                                                <span class="text-job">{{ $item->order->created_at }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="activity">
                                        <div class="activity-icon bg-primary text-white shadow-primary">
                                            <i class="fas fa-check"></i>
                                        </div>
                                        <div class="activity-detail">
                                            <p>تم الدفع من قبل المتسوق</p>
                                            <div class="mb-2">
                                                <span class="text-job">{{ $item->order->created_at }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="activity">
                                        <div class="activity-icon bg-primary text-white shadow-primary">
                                            <i class="fas fa-check"></i>
                                        </div>
                                        <div class="activity-detail">
                                            <p>تم تسليم الطلبية للمسافر</p>
                                            <div class="mb-2">
                                                <span class="text-job">{{ $item->order->created_at }}</span>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="activity">
                                        <div class="activity-icon bg-primary text-white shadow-primary">
                                            <i class="fas fa-check"></i>
                                        </div>
                                        <div class="activity-detail">
                                            <p>تم تسليم الطلبية للمتسوق</p>
                                            <div class="mb-2">
                                                <span class="text-job">{{ $item->order->created_at }}</span>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="activity">
                                        <div class="activity-icon bg-primary text-white shadow-primary">
                                            <i class="fas fa-check"></i>
                                        </div>
                                        <div class="activity-detail">
                                            <p>تم التقييم </p>
                                            <div class="mb-2">
                                                <span class="text-job">{{ $item->order->created_at }}</span>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <h3 class="mb-3" style="font-size: 1.2rem;">- {{trans('deals.conversation') }} : </h3>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection