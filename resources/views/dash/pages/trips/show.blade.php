@extends('dash.layouts.app')
@section('content')

<div class="section-body">
    <div class="d-flex" style="justify-content: space-between;align-items:center">
        <h2 class="section-title"> {{ trans('dash.from') }} {{ $item->getFrom() }} {{ trans('dash.to') }} {{ $item->getTo() }}</h2>
        <div>
            @if( $item->status == 1)
            <a class="btn btn-primary" href="{{ route('trips.accept', $item->id) }}">{{ trans('dash.accept')}}</a>
            @endif
        </div>
    </div>

    <div class="row mt-sm-4">
        <div class="col-12 col-md-12 ">
            <div class="card ">
                <div class="card-body p-4">
                    <div class="mb-4">
                        <h3 class="mb-3" style="font-size: 1.2rem;">- {{trans('trips.info') }} : </h3>
                        <div class="row">
                            <div class="col-md-4 mb-1">
                                <b>{{ trans('dash.user') }} : </b> <a href="{{ route('users.show', $item->user_id) }}">{{ $item->user->full_name }}</a>
                            </div>
                            <div class="col-md-4 mb-1">
                                <b>{{ trans('dash.from') }} : </b> {{ $item->getFrom() }}
                            </div>
                            <div class="col-md-4 mb-1">
                                <b>{{ trans('dash.to') }} : </b> {{ $item->getTo() }}
                            </div>
                            <div class="col-md-4 mb-1">
                                <b>{{ trans('trips.available_weight') }} : </b> {{ $item->available_weight }}
                            </div>
                            <div class="col-md-4 mb-1">
                                <b>{{ trans('trips.departure_date') }} : </b> {{ $item->departure_date }}
                            </div>
                            <div class="col-md-4 mb-1">
                                <b>{{ trans('trips.departure_time') }} : </b> {{ $item->departure_time }}
                            </div>
                            <div class="col-md-4 mb-1">
                                <b>{{ trans('trips.delivery_date_from') }} : </b> {{ $item->delivery_date_from }}
                            </div>
                            <div class="col-md-4 mb-1">
                                <b>{{ trans('trips.delivery_date_to') }} : </b> {{ $item->delivery_date_to }}
                            </div>
                            <div class="col-md-4 mb-1">
                                <b>{{ trans('orders.deal_method') }} : </b> {{ $item->deal_method_txt }}
                            </div>
                            <div class="col-md-4 mb-1">
                                <b>{{ trans('trips.pickup_place') }} : </b> {{ $item->pickup_place }}
                            </div>
                            <div class="col-md-4 mb-1">
                                <b>{{ trans('dash.status') }} : </b> {!! $item->statusBadge() !!}
                            </div>
                            <div class="col-md-4 mb-1 d-flex" style="gap: 10px;">
                                <b style="white-space: nowrap;">{{ trans('dash.photo') }} : </b>
                                @if($item->photo_path)
                                <div class="gallery">
                                    <div class="gallery-item" data-image="{{ $item->photo_path }}" data-title="Photo"></div>
                                </div>
                                @else
                                <div>Not Found</div>
                                @endif
                            </div>
                            <!-- <div class="col-md-4 mb-1 d-flex" style="gap: 10px;">
                                <b style="white-space: nowrap;">{{ trans('trips.passpost_photo') }} : </b>
                                <div class="gallery">
                                    <div class="gallery-item" data-image="{{ $item->passpost_photo_path }}" data-title="Passport"></div>
                                </div>
                            </div> -->
                            <div class="col-md-12">
                            </div>
                            @if( $item->status == 2)
                            <div class="col-md-4 mb-1">
                                <b>{{ trans('trips.arrive_date') }} : </b> {{ $item->arrive_date }}
                            </div>
                            <div class="col-md-4 mb-1">
                                <b>{{ trans('trips.arrive_time') }} : </b> {{ $item->arrive_time }}
                            </div>
                            @endif
                            @if( $item->status != 1)
                            <div class="col-md-4 mb-1">
                                <b>{{ trans('trips.replied_at') }} : </b> {{ $item->replied_at }}
                            </div>
                            @endif
                            <div class="col-md-12 mb-1">
                                <b>{{ trans('trips.notes') }} : </b> {{ $item->notes }}
                            </div>
                            <div class="col-md-12 mb-1">
                                <b>{{ trans('trips.categories_not_accept') }} : </b>
                                @foreach($item->categories_not_accept as $cat)
                                {{$cat->title}}
                                @if($loop->iteration < count($item->categories_not_accept))
                                    ,
                                    @endif
                                    @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <h3 class="mb-3" style="font-size: 1.2rem;">- {{trans('trips.booking_info') }} : </h3>
                        <div class="row">
                            <div class="col-md-4 mb-1">
                                <b>{{ trans('trips.booking_airline') }} : </b> {{ $item->booking_airline }}
                            </div>
                            <div class="col-md-4 mb-1">
                                <b>{{ trans('trips.booking_reference') }} : </b> {{ $item->booking_reference }}
                            </div>
                            <div class="col-md-4 mb-1">
                                <b>{{ trans('dash.first_name') }} : </b> {{ $item->booking_first_name }}
                            </div>
                            <div class="col-md-4 mb-1">
                                <b>{{ trans('dash.last_name') }} : </b> {{ $item->booking_last_name }}
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <h3 class="mb-3" style="font-size: 1.2rem;">- {{trans('trips.requests') }} : </h3>
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <th width="30" class="text-center">#</th>
                                        <th>{{ trans('dash.order') }}</th>
                                        <th>{{ trans('dash.reason') }}</th>
                                        <th>{{ trans('dash.target_price') }}</th>
                                        <th>{{ trans('dash.status') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach( $item->requests as $request)
                                    <tr>
                                        <td>{{ $loop->iteration }} </td>
                                        <td><a href="{{ route('orders.show', $request->order_id ) }}">{{ trans('dash.details') }}</a> </td>
                                        <td>{{ $request->reason }}</td>
                                        <td>{{ $request->target_price }}</td>
                                        <td>{!! $request->statusBadge() !!}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="mb-4">
                        <h3 class="mb-3" style="font-size: 1.2rem;">- {{trans('trips.offers') }} : </h3>
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <th width="30" class="text-center">#</th>
                                        <th>{{ trans('dash.order') }}</th>
                                        <th>{{ trans('dash.reward') }}</th>
                                        <th>{{ trans('dash.amount') }}</th>
                                        <th>{{ trans('dash.message') }}</th>
                                        <th>{{ trans('dash.status') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach( $item->offers as $offer)
                                    <tr>
                                        <td>{{ $loop->iteration }} </td>
                                        <td><a href="{{ route('orders.show', $offer->order_id ) }}">{{ trans('dash.details') }}</a> </td>
                                        <td>{{ $offer->reward }}</td>
                                        <td>{{ $offer->amount }}</td>
                                        <td>{{ $offer->message }}</td>
                                        <td>{!! $offer->statusBadge() !!}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection