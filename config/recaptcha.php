<?php

return [
    // Google's recaptcha verify url
    'url'     => 'https://www.google.com/recaptcha/api/siteverify',
    // Google ReCaptcha keys
    'keys'    => [
        'site'   => env('RECAPTCHA_SITE_KEY', ''),
        'secret' => env('RECAPTCHA_SECRET_KEY', ''),
    ],
    // Timeout in seconds to abort the curl op and return a negative value
    'timeout' => 1,

];
