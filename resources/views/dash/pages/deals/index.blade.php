@extends('dash.layouts.app')
@section('content')

<div class="section-body">

    <div class="row">
        <div class="col-12">
            <div class="card">
                <!-- <div class="card-header">
                        <h4>Basic DataTables</h4>
                    </div> -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-1">
                            <thead>
                                <tr>
                                    <th width="30" class="text-center">#</th>
                                    <th>{{ trans('dash.from') }}</th>
                                    <th>{{ trans('dash.to') }}</th> 
                                    <th>{{ trans('trips.single') }}</th>
                                    <th>{{ trans('orders.single') }}</th>
                                    <th>{{ trans('dash.status') }}</th>
                                    <th width="140">{{ trans('dash.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach( $items as $item)
                                <tr>
                                    <td> {{ $loop->iteration }} </td>
                                    <td>{{ $item->trip->getFrom() }}</td>
                                    <td>{{ $item->trip->getTo() }}</td>
                                    <td><a href="{{ route('trips.show', $item->trip_id ) }}">{{ trans('dash.details') }}</a></td>
                                    <td><a href="{{ route('orders.show', $item->order_id ) }}">{{ trans('dash.details') }}</a></td> 
                                    <td>
                                        <div class="badge badge-success">{{ $item->status_txt}}</div>
                                    </td>
                                    <td>
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