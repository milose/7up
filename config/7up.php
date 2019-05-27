<?php

return [
    'nsfw' => [
        'location' => env('NSFW_LOCATION'),
        'threshold' => env('NSFW_THRESHOLD', .50),
    ],
];
