<p>Owner: {{ $payment->owner_first_name }} {{ $payment->owner_second_name }}</p>
<p>VISA **** **** **** {{ substr($payment->cc_number, -4) }}</p>
<p>Expires {{ substr($payment->expiration_date, 0, 2) }}/{{ substr($payment->expiration_date, 2, 2) }}</p>
