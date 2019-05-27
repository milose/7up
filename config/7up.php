<?php

return [
    'path' => env('UP_PATH', 'app/files'),
    'storage' => env('UP_STORAGE', storage_path()),

    'nsfw' => [
        'location' => env('NSFW_LOCATION'),
        'threshold' => env('NSFW_THRESHOLD', .50),
    ],
];
