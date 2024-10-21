<?php

return [

    'paths' => ['api/*'],

    'allowed_methods' => ['*'],  // Allow all methods or restrict to specific methods (e.g., ['GET', 'POST'])

    'allowed_origins' => ['*'],  // Allow requests from your React frontend

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],  // Allow all headers

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,  // If you're using cookies or sessions
];

