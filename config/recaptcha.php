<?php

return [
    'url'  => 'https://www.google.com/recaptcha/api/siteverify',
    'keys' => [
        'site'   => env('RECAPTCHA_SITE_KEY', ''),
        'secret' => env('RECAPTCHA_SECRET_KEY', ''),
    ],
];
