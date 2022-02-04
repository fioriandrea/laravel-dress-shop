@extends('layouts.master')

@section('title', $user->name . '\'s Cart')

@section('content')
    <!-- form to use post add_address -->
    <form method="post" action="{{ $add ? route('add_address') : route('modify_address') }}" class="mt-3 form-horizontal">
        @csrf
        <input name="id" value="{{ $address->id ?? '' }}" hidden>
        <div class="form-group">
            <label for="street">Street</label>
            <input required type="text" class="form-control" id="street" name="street" placeholder="1234 Main St" maxlength="40" value="{{ $address->street }}">
        </div>
        <div class="form-group">
            <label for="city">City</label>
            <input required type="text" class="form-control" id="city" name="city" placeholder="Castel Mella" maxlength="40" value="{{ $address->city }}">
        </div>
        <div class="form-group">
            <label for="province">Province</label>
            <input required type="text" class="form-control" id="province" name="province" placeholder="Brescia" maxlength="40" value="{{ $address->province }}">
        </div>
        <div class="form-group">
            <label for="zip">ZIP</label>
            <input required class="form-control" id="zip" name="zip" type="number" maxlength="10" value="{{ $address->zip }}">
        </div>
        <div class="form-group">
            <label for="country">Country</label>
            <input required class="form-control" id="country" name="country" maxlength="40" value="{{ $address->country }}">
        </div>
        <button type="submit" class="w-100 btn btn-outline-primary">Submit</button>
    </form>
@endsection