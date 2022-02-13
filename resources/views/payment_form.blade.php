@extends('layouts.master')

@section('title', $add ? 'Add Payment Method' : 'Modify Payment Method')

@section('before')
@include('form_invalid_style')
@endsection

@section('content')
    <!--an owner, credit card number, expiration date-->
    <form method="post" action="{{ $add ? route('add_payment_method') : route('modify_payment_method', ['id' => $payment->id]) }}" id="payment-form" class="mt-3 form-horizontal">
        @csrf
        <div class="form-group">
            <label for="owner_first_name">@lang('labels.Owners_First_Name')</label>
            <input name="owner_first_name" required type="text" class="form-control" id="owner-first-name" value="{{ $payment->owner_first_name }}" maxlength="25">
        </div>
        <div class="form-group">
            <label for="owner-second-name">@lang('labels.Owners_Second_Name')</label>
            <input name="owner_second_name" required type="text" class="form-control" id="owner-second-name" value="{{ $payment->owner_second_name }}" maxlength="25">
        </div>
        <div class="form-group">
            <label for="ccn">@lang('labels.Credit_Card_Number')</label>
            <input name="cc_number" required class="form-control" id="ccn" type="tel" value="{{ $payment->cc_number }}">
        </div>
        <div class="form-group">
            <label for="expiration_date">@lang('labels.Expiration_Date')</label>
            <input name="expiration_date" required type="month" class="form-control" id="expiration-date" value="{{ $payment->expiration_date }}">
        </div>
        <button type="submit" class="w-100 btn btn-outline-primary my-2">@lang('labels.Submit')</button>
    </form>
</div>
@endsection

@section('after')
<script> 
    const formatCardNumber = (value, delim = ' ') => {
        const res = [];
        for (let i = 0; i < value.length; i++) {
            if (i % 4 === 0 && i !== 0) {
                res.push(delim);
            }
            res.push(value[i]);
        }
        return res.join('');
    };

    /*
    * Precondition: input an input element and the form containing it
    * Postcondition: credit card number formatting is applied to the input element with id inputid
    */
    const mkcreditCardFormatter = (input, form, placeholderSym = 'X', delim = ' ') => {
        const getreal = (value) => value.replaceAll(delim, '');

        let real = getreal(input.value);

        input.placeholder = formatCardNumber(new Array(16).fill(placeholderSym).join(''));
        input.pattern = `[0-9]{4}${delim}[0-9]{4}${delim}[0-9]{4}${delim}[0-9]{4}`;

        const inputFormatter = (val) => {
            real = getreal(val);
            real = real.replaceAll(/[^\d]+/g, '');
            real = real.slice(0, 16);
            input.value = formatCardNumber(real, delim);
        };
        inputFormatter(real);
        input.addEventListener('input', (e) => inputFormatter(e.target.value));
        form.addEventListener('submit', (e) => {
            input.pattern = `[0-9]{16}`;
            input.value = real;
        });
    };

    mkcreditCardFormatter(document.querySelector('#ccn'), document.querySelector('#payment-form'));
    document.getElementById('expiration-date').min = new Date().toISOString().split('-')[0] + '-' + new Date().toISOString().split('-')[1];
</script>
@endsection
