<?php

return [

    'name' => env('APP_NAME', 'Pluggedin'),

    'env' => env('APP_ENV', 'production'),

    'chart_datetime_format' => env('CHART_DATETIME_FORMAT', 'j-M'),

    'datetime_format' => env('DATETIME_FORMAT', 'j M Y'),

    'display_timezone' => env('DISPLAY_TIMEZONE', 'Europe/Amsterdam'),

    'force_https' => env('FORCE_HTTPS', false),

    'admin_name' => env('ADMIN_NAME', 'Admin'),

    'admin_email' => env('ADMIN_EMAIL', 'admin@example.com'),

    'admin_password' => env('ADMIN_PASSWORD', 'password'),
];
