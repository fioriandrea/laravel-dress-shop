@extends('layouts.master')

@section('title', $add ? 'Add Address' : 'Modify Address')

@section('before')
@include('form_invalid_style')
@endsection

@section('content')
    <!-- form to use post add_address -->
    <form method="post" action="{{ $add ? route('add_address') : route('modify_address', ['id' => $address->id]) }}" class="mt-3 form-horizontal">
        @csrf
        <div class="form-group">
            <label for="street">@lang('labels.Street')</label>
            <input required type="text" class="form-control" id="street" name="street" placeholder="1234 Main St" maxlength="25" value="{{ $address->street }}">
        </div>
        <div class="form-group">
            <label for="city">@lang('labels.City')</label>
            <input required type="text" class="form-control" id="city" name="city" placeholder="Castel Mella" maxlength="25" value="{{ $address->city }}">
        </div>
        <div class="form-group">
            <label for="province">@lang('labels.Province')</label>
            <input required type="text" class="form-control" id="province" name="province" placeholder="Brescia" maxlength="25" value="{{ $address->province }}">
        </div>
        <div class="form-group">
            <label for="zip">@lang('labels.ZIP')</label>
            <input required class="form-control" id="zip" name="zip" type="number" max="99999" value="{{ $address->zip }}">
        </div>
        <div class="form-group">
            <label for="country">@lang('labels.Country')</label>
            <input required class="form-control" id="country" name="country" maxlength="25" value="{{ $address->country }}">
        </div>
        <button type="submit" class="w-100 btn btn-outline-primary my-2">@lang('labels.Submit')</button>
    </form>
@endsection