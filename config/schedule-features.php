<?php

return [
    'maximum-breaking-time' => env('MAXIMUM_BREAKING_TIME', 2),
    'schedule-days' => [
        [
            'name' => 'Senin',
            'order_direction' => 1,
            'total_hours' => 10,
        ],
        [
            'name' => 'Selasa',
            'order_direction' => 2,
            'total_hours' => 10,
        ],
        [
            'name' => 'Rabu',
            'order_direction' => 3,
            'total_hours' => 10,
        ],
        [
            'name' => 'Kamis',
            'order_direction' => 4,
            'total_hours' => 10,
        ],
        [
            'name' => "Jum'at",
            'order_direction' => 5,
            'total_hours' => 6,
        ],
    ],
];
