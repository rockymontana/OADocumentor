<?php

return [
    /**
     * The from directory represents from which directory the
     * documentation files can be found. This directory should be
     * the base directory that contains all the documentation files.
     */
    'directories' => [
        'paths' => base_path('docs/paths'),
        'components' => base_path('docs/components'),
    ],
    'save' => [
        'path' => '/docs',
        'filename' => 'openapi.yml',
    ],
    'redoc' => [
        'enable' => true,
        'endpoint' => 'docs'
    ]
];