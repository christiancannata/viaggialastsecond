<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'mandrill' => [
        'secret' => env('MANDRILL_SECRET'),
    ],

    'ses' => [
        'key'    => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'stripe' => [
        'model'  => Meritocracy\User::class,
        'key'    => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
    'facebook' => [
        'client_id'     => '756054691129338',
        'client_secret' => 'b39467b7dbae9e9309b31bc7169a8bcc',
        'redirect'      => env('API_CURRENT_ENDPOINT') .'/auth/facebook/callback',
    ],
    'linkedin' => [
        'client_id'     => '77y03jogf7nzph',
        'client_secret' => 'CAxycw78NI5etJhV',
        'redirect'      => env('API_CURRENT_ENDPOINT') . '/auth/linkedin/callback',
    ],
    'paypal' => [
        'client_id' => (getenv('APP_ENV') == "local") ? 'AYw79S1LtIeeKgFy8So7SuE1GPnSJm6jurrDp6_rZ5aqwBMJQ8e5czVcSm9T1aunW2li2-kxP_Cu8Pmb' :'AbcXQyIKzuabcPpXKjszvTmmJuaKx2P0xWJ7DbXTZHpwljqoKJhWiYjKJ8Qzjp1cyPlmECy-3eN3TkJi' ,
        'secret' => (getenv('APP_ENV') == "local") ? 'EHUSHK-vSBkZP4nMX8rCsvlyo-NGsN5tL28dowjlltTGJxrpOuFPiaum6pzrItD6HBI09KqjRUS5TcbF' :'EKz1WH0JH3VZEzw2mWFVxNmmDcrfRjLYlA6v6z5Ip-H2UBundswT8FkQjtWmBhOUCdWIC5qD2A68Ud2y' ,

    ],

];
