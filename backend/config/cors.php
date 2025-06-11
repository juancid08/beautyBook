<?php

return [

    // A qué rutas aplicamos CORS (incluimos Sanctum)
    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    // Métodos permitidos
    'allowed_methods' => ['*'],

    // Orígenes permitidos de tu SPA Angular
    'allowed_origins' => ['http://localhost:4200'],

    'allowed_origins_patterns' => [],

    // Todas las cabeceras que te hagan falta
    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    // ¡IMPRESCINDIBLE para que el navegador envíe y acepte cookies!
    'supports_credentials' => true,
];
