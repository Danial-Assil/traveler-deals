@extends('dash.layouts.app')
@section('content')

<div class="section-body">
    <h2 class="section-title"> {{ trans('dash.from') }} {{ $item->getFrom() }} {{ trans('dash.to') }} {{ $item->getTo() }}</h2>

    <div class="row mt-sm-4">
        <div class="col-12 col-md-12 ">
            <div class="card ">
                <div class="card-body p-4">
                    <div class="mb-4">
                        <h3 class="mb-3" style="font-size: 1.2rem;">- {{trans('orders.info') }} : </h3>
                        <div class="row">
                            <div class="col-md-4 mb-1">
                                <b>{{ trans('orders.user') }} : </b> <a href="{{ route('users.show', $item->user_id) }}">{{ $item->user->full_name }}</a>
                            </div>
                            <div class="col-md-4 mb-1">
                                <b>{{ trans('dash.from') }} : </b> {{ $item->getFrom() }}
                            </div>
                            <div class="col-md-4 mb-1">
                                <b>{{ trans('dash.to') }} : </b> {{ $item->getTo() }}
                            </div>
                            <div class="col-md-4 mb-1">
                                <b>{{ trans('orders.total_weight') }} : </b> {{ $item->total_weight }} {{ $item->order_items->first()->unit_txt }}
                            </div>

                            <div class="col-md-4 mb-1">
                                <b>{{ trans('orders.before_date') }} : </b> {{ $item->before_date }}
                            </div>
                            <div class="col-md-4 mb-1">
                                <b>{{ trans('orders.name') }} : </b> {{ $item->name }}
                            </div>
                            <div class="col-md-4 mb-1">
                                <b>{{ trans('orders.total_price') }} : </b> {{ $item->total_price }} $
                            </div>

                            <div class="col-md-4 mb-1">
                                <b>{{ trans('orders.reward') }} : </b> {{ $item->reward }}
                            </div>
                            <div class="col-md-4 mb-1">
                                <b>{{ trans('orders.fees') }} : </b> {{ $item->fees }}
                            </div>
                            @if($item->deal_method == 2)
                            <div class="col-md-4 mb-1">
                                <b>{{ trans('orders.payment_processing') }} : </b> {{ $item->payment_processing }}
                            </div>
                            @endif
                            <div class="col-md-4 mb-1">
                                <b>{{ trans('orders.estimated_total') }} : </b> {{ $item->estimated_total }}
                            </div>
                            <!-- <div class="col-md-4 mb-1">
                                <b>{{ trans('orders.delivery_type') }} : </b> {{ $item->delivery_type_txt }}
                            </div> -->
                            <div class="col-md-4 mb-1">
                                <b>{{ trans('orders.deal_method') }} : </b> {{ $item->deal_method_txt }}
                            </div>
                            <div class="col-md-4 mb-1">
                                <b>{{ trans('orders.offers_count') }} : </b> {{ $item->offers->count() }}
                            </div>
                            <div class="col-md-4 mb-1">
                                <b>{{ trans('orders.items_count') }} : </b> {{ $item->order_items->count() }}
                            </div>
                            <div class="col-md-4 mb-1">
                                <b>{{ trans('dash.status') }} : </b> {{ $item->status_txt }}
                            </div>
                            <div class="col-md-12 mb-1">
                                <b>{{ trans('orders.notes') }} : </b> {{ $item->notes }}
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <h3 class="mb-3" style="font-size: 1.2rem;">- {{trans('orders.order_items') }} : </h3>
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <th width="30" class="text-center">#</th>
                                        <th>{{ trans($module_name.'.link') }}</th>
                                        <th>{{ trans($module_name.'.item_name') }}</th>
                                        <th>{{ trans($module_name.'.quantity') }}</th>
                                        <th>{{ trans($module_name.'.price') }}</th>
                                        <th>{{ trans($module_name.'.weight') }}</th>
                                        <th>{{ trans($module_name.'.total_weight') }}</th>
                                        <th>{{ trans($module_name.'.total_price') }}</th>
                                        <th>{{ trans($module_name.'.category') }}</th>
                                        <th>{{ trans('dash.image') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach( $item->order_items as $order_item)
                                    <tr>
                                        <td> {{ $loop->iteration }} </td>
                                        <td> @if($order_item->link) <a href="{{ $order_item->link  }}"> Click To Show Product </a> @else Not Found @endif</td>
                                        <td>{{ $order_item->name }}</td>
                                        <td>{{ $order_item->quantity }}</td>
                                        <td>{{ $order_item->price }}</td>
                                        <td>{{ $order_item->weight }} {{ $order_item->unit_txt}}</td>
                                        <td>{{ $order_item->weight * $order_item->quantity }} {{ $order_item->unit_txt}}</td>
                                        <td>{{ $order_item->price * $order_item->quantity }}</td>
                                        <td>{{ $order_item->category->title }}</td>
                                        <td>
                                            <div class="gallery">
                                                @foreach( $order_item->images as $photo)
                                                <div class="gallery-item" data-image="{{ $photo->image_path }}" data-title="Photo {{$loop->iteration}}"></div>
                                                @endforeach
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="mb-4">
                        <h3 class="mb-3" style="font-size: 1.2rem;">- Recieved {{trans('orders.offers') }} : </h3>
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <th width="30" class="text-center">#</th>
                                        <th>{{ trans('dash.trip') }}</th>
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
                                        <td><a href="{{ route('trips.show', $offer->trip_id ) }}">{{ trans('dash.details') }}</a> </td>
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
                    <div class="mb-4">
                        <h3 class="mb-3" style="font-size: 1.2rem;">- Sended {{trans('orders.requests') }} : </h3>
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
                </div>
            </div>
        </div>
    </div>

</div>

@endsection