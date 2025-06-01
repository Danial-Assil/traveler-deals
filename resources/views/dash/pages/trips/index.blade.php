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
                                    <th>{{ trans('dash.from') }}</th>
                                    <th>{{ trans('dash.to') }}</th>
                                    <th>{{ trans($module_name.'.departure_date') }}</th>
                                    <th>{{ trans($module_name.'.available_weight') }}</th>
                                    <th>{{ trans($module_name.'.requests_count') }}</th>
                                    <th width="140">{{ trans('dash.status') }}</th>
                                    <th width="140">{{ trans('dash.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach( $items as $item)
                                <tr>
                                    <td> {{ $loop->iteration }} </td>
                                    <td><a href="{{ route('users.show', $item->user->id) }}" style="white-space: nowrap;">{{ $item->user->full_name }}</a></td>
                                    <td>{{ $item->getFrom() }}</td>
                                    <td>{{ $item->getTo() }}</td>
                                    <td>{{ $item->departure_date }}</td>
                                    <td>{{ $item->available_weight }}</td>
                                    <td>{{ $item->requests_count }}</td>
                                    <td>{!! $item->statusBadge() !!}</td>
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