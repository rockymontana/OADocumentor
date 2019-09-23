<?php
return [
    'openapi' => env('API_OA_VERSION', "3.0.0"),
    'info' => [
        'version' => env('API_VERSION', "1.0"),
        "contact" => [
            "name" => env("API_CONTACT_NAME", "Example LTD"),
            "url" => env("API_CONTACT_URL", "https://www.example.com"),
            "email" => env("API_CONTACT_EMAIL", "support@example.com"),
        ],
        "title" => env('API_NAME', "Example API"),
        "license" => [
            "name" => env("API_LICENSE_NAME", 'MIT'),
            "url" => env("API_LICENSE_URL", 'https://opensource.org/licenses/MIT'),
        ],
    ],
    'servers' => [
        [
            'url' => config('app.url')
        ]
    ]
];
