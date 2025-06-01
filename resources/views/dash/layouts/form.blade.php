@extends('dash.layouts.app')
@section('content')
<div class="section-body">
    <h2 class="section-title">@yield('title')</h2>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ isset($item) ? route($module_name.'.update', $item->id) : route($module_name.'.store') }}" method="{{ isset($item) ? 'PUT' : 'POST'}}" enctype="multipart/form-data">
                        <div class="msg_form"></div>
                        <div class="overlay-box">
                            <i class="far fa-refresh"></i>
                        </div>
                        @yield('form')
                        <div class="modal-btns d-flex mt-2" style="justify-content: end;">
                            <a class="btn btn-default" href="{{ route($module_name.'.index') }}">{{ trans('dash.cancel')}}</a>
                            <button type="button" class="btn btn-primary btn-submit" onclick="{{ isset($item) ? 'updateItem(this,event)' : 'storeItem(this,event)'}} ">{{ trans('dash.save')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection