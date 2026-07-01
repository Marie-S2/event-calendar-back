<?php

return [

    'paths' => ['*'],

    'allowed_methods' => ['*'],

    'allowed_origins' => [
       'http://localhost:4200',
        'https://event-calendar-front.vercel.app',
        'https://event-calendar-front-d8ybfm7cu-poh123.vercel.app',
    ],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,
];