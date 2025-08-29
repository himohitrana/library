<?php

return [
    // Directories where Blade templates are stored
    'paths' => [
        resource_path('views'),
    ],

    // Compiled views directory
    'compiled' => env('VIEW_COMPILED_PATH', realpath(storage_path('framework/views'))),
];