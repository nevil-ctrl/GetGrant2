<?php

return [
    /*
     * Важно: paths должен включать все API маршруты
     */
    'paths' => ['api/*', 'sanctum/csrf-cookie', 'auth/*'],

    'allowed_methods' => ['*'],

    /*
     * ВАЖНО: Если фронтенд и бэкенд на одном домене (localhost:8000),
     * то allowed_origins должен быть ['*'] или вообще не нужен CORS
     */
    'allowed_origins' => ['*'], // Для dev режима можно так

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    /*
     * КРИТИЧЕСКИ ВАЖНО: должно быть true для работы с cookies
     */
    'supports_credentials' => true,
];
