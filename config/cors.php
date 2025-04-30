<?php

return [

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    'allowed_origins' => [
        'http://localhost:3000',    // opcional si también usas 3000
        'http://127.0.0.1:3000',    // opcional
        'http://localhost:5173',    // ✅ ¡IMPORTANTE! para tu Vite (React)
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => [
        'Content-Type',
        'X-Guest-Session',
        'Accept',
        'Authorization',
        'Origin',
        'X-Requested-With',
    ],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,
];
