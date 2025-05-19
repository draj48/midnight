@extends('layouts.app')

@section('content')
    <script src="https://js.stripe.com/v3/"></script>

    <script>
        'use strict';

        const stripe = Stripe('{{ config('settings.stripe_key') }}');

        stripe.redirectToCheckout({
            sessionId: '{{ $stripeSession->id }}'
        });
    </script>
@endsection
