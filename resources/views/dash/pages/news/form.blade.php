@extends('dash.layouts.form')
@section('title', isset($item) ? 'Edit '.$item->full_name : 'New User')
@section('form')

<div class="row">

    <div class="form-group col-md-6">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="{{ trans('dash.title')}} {{ trans('dash.ar')}} " name="ar[title]">
        </div>
        <small data-id="msg_ar_title" class="text-error"></small>
    </div>

    <div class="form-group col-md-6">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="{{ trans('dash.title')}} {{ trans('dash.en')}} " name="en[title]">
        </div>
        <small data-id="msg_en_title" class="text-error"></small>
    </div>

    <div class="form-group col-md-12">
        <div class="input-group">
            <textarea class="form-control" placeholder="{{ trans('dash.description')}} {{ trans('dash.ar')}} " cols="5" name="ar[description]"></textarea>
        </div>
        <small data-id="msg_ar_description" class="text-error"></small>
    </div>

    <div class="form-group col-md-12">
        <div class="input-group">
            <textarea class="form-control" placeholder="{{ trans('dash.description')}} {{ trans('dash.en')}} " cols="5" name="en[description]"></textarea>
        </div>
        <small data-id="msg_en_description" class="text-error"></small>
    </div>

</div>

@endsection