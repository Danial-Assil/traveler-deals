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
                                    <th>{{ trans('dash.title') }}</th>
                                    <th>{{ trans('dash.created_at') }}</th>
                                    <th>{{ trans('dash.status') }}</th>
                                    <th width="140">{{ trans('dash.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach( $items as $item)
                                <tr>
                                    <td> {{ $loop->iteration }} </td>
                                    <td>{{ $item->title }}</td>
                                    <td>{{ $item->created_at }}</td>
                                    <td>
                                        <div class="badge badge-success">{{ $item->status}}</div>
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