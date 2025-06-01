@extends('dash.layouts.app')
@section('content')


<div class="section-body">

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-1">
                            <thead>
                                <tr>
                                    <th width="30" class="text-center">#</th>
                                    <th>{{ trans('dash.full_name') }}</th>
                                    <th>{{ trans('users.deals_count') }}</th>
                                    <th>{{ trans('users.trips_count') }}</th>
                                    <th>{{ trans('users.orders_count') }}</th>
                                    <th>{{ trans('users.travelers_rating') }}</th>
                                    <th>{{ trans('users.shoppers_rating') }}</th>
                                    <th>{{ trans('dash.status') }}</th>
                                    <th width="120">{{ trans('dash.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach( $items as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td style="white-space: nowrap;">{{ $item->full_name }} </td>
                                    <td>{{ $item->deals_count }}</td>
                                    <td>{{ $item->trips_count }}</td>
                                    <td>{{ $item->orders_count }}</td>
                                    <td> 
                                        {!! $item->getTravelerRatingStars() !!}
                                    </td>
                                    <td>
                                        {!! $item->getShopperRatingStars() !!}
                                    </td>
                                    <td>
                                        <div class="badge badge-{{ $item->status && $item->is_verified ? 'success' : 'warning'}}">{{ $item->getStatusTxt() }} </div>
                                    </td>
                                    <td class="text-center">
                                        @include('dash.components.actions')
                                    </td>
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

@endsection