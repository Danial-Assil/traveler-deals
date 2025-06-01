@extends('dash.layouts.form')
@section('title', isset($item) ? 'Edit '.$item->full_name : 'New User')
@section('form')
<div class="row">
    <div class="form-group col-md-6">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="{{ trans('users.first_name')}}" name="first_name" value="{{ isset($item) ? $item->first_name : ''}}">
        </div>
        <small data-id="msg_first_name" class="text-error"></small>
    </div>
    <div class="form-group col-md-6">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="{{ trans('users.last_name')}}" name="last_name" value="{{ isset($item) ? $item->last_name : ''}}">
        </div>
        <small data-id="msg_last_name" class="text-error"></small>
    </div>
    <div class="form-group col-md-12">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="{{ trans('users.email')}}" name="email" value="{{ isset($item) ? $item->email : ''}}">
        </div>
        <small data-id="msg_email" class="text-error"></small>
    </div>
    <div class="form-group col-md-6">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="{{ trans('users.mobile')}}" name="mobile" value="{{ isset($item) ? $item->mobile : ''}}">
        </div>
        <small data-id="msg_mobile" class="text-error"></small>
    </div>
    <div class="form-group col-md-6">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="{{ trans('users.password')}}" name="password">
        </div>
        <small data-id="msg_password" class="text-error"></small>
    </div>
</div>
@endsection