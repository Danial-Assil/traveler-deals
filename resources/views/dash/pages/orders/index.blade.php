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
                                    <th>{{ trans('dash.user') }}</th>
                                    <th>{{ trans($module_name.'.name') }}</th>
                                    <th>{{ trans('dash.from') }}</th>
                                    <th>{{ trans('dash.to') }}</th>
                                    <th>{{ trans($module_name.'.offers_count') }}</th>
                                    <th>{{ trans($module_name.'.items_count') }}</th>
                                    <th width="140">{{ trans('dash.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach( $items as $item)
                                <tr>
                                    <td> {{ $loop->iteration }} </td>
                                    <td> <a href="{{ route('users.show', $item->user->id) }}" style="white-space: nowrap;">{{ $item->user->full_name }}</a></td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->getFrom()  }}</td>
                                    <td>{{ $item->getTo()  }}</td>
                                    <td>{{ count($item->offers) }}</td>
                                    <td>{{ count($item->order_items) }}</td>
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