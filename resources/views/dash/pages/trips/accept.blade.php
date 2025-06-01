@extends('dash.layouts.app')
@section('content')


<div class="section-body">
    <div class="d-flex" style="justify-content: space-between;align-items:center">
        <h2 class="section-title"> Accept Trip - {{ trans('dash.from') }} {{ $item->getFrom() }} {{ trans('dash.to') }} {{ $item->getTo() }}</h2>

    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <!-- <div class="card-header">
                        <h4>Basic DataTables</h4>
                    </div> -->
                <div class="card-body">
                    <form id="create-modal" action="{{ route($module_name.'.do_accept') }}" method="POST">
                        @csrf
                        <div class="msg_form"></div>

                        <input type="hidden" class="form-control" name="trip_id" value="{{$item->id}}">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Arrive Date</label>
                                <div class="input-group">
                                    <input type="date" class="form-control" name="arrive_date">
                                </div>
                                <small data-id="msg_arrive_date" class="text-error"></small>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Arrive Time</label>
                                <div class="input-group">
                                    <input type="time" class="form-control" name="arrive_time">
                                </div>
                                <small data-id="msg_arrive_time" class="text-error"></small>
                            </div>
                        </div>
                        <button class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection