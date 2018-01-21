<?php

return [
    'two_checkout' => [
        'account_number' => env('TWO_CHECKOUT_ACCOUNT_NUMBER'),
        'public_key' => env('TWO_CHECKOUT_PUBLIC_KEY'),
        'private_key' => env('TWO_CHECKOUT_PRIVATE_KEY')
    ],
    'twilio' => [
        'id' => env('TWILIO_ID'),
        'token' => env('TWILIO_TOKEN')
    ]
];
