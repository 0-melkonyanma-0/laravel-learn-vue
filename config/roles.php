<?php

declare(strict_types=1);

/**
 *  Roles and permissions
 */

$models = [
    'users',
    'job_titles',
    'departments',
    'roles',
    'events',
    'statistics',
    'settlements',
];

$permissions = [
    'index',
    'show',
    'create',
    'edit',
    'delete',
];

return [
    'permissions' => [
        array_fill_keys($models, $permissions)
    ],


    'roles' => [
        /**
         *
         *      Admin
         *
         */

        'admin' => [
            'users' => [
                'index',
                'create',
                'edit',
                'delete',
            ],
            'departments' => [
                'index',
                'create',
                'edit',
                'delete',
            ],
            'job_titles' => [
                'index',
                'create',
                'edit',
                'delete',
            ],
            'roles' => [
                'index',
                'create',
                'edit',
                'delete',
            ],
            'events' => [
                'index',
                'show',
                'create',
                'edit',
                'delete',
            ],
            'statistics' => [
                'index',
                'show',
                'create',
                'edit',
                'delete',
            ],
            'settlements' => [
                'index',
                'delete',
            ]
        ],

        /**
         *
         *      Manager
         *
         */

        'manager' => [
            'users' => [
                'index',
            ],
            'departments' => [
                'index',
            ],
            'job_titles' => [
                'index',
            ],
            'events' => [
                'index',
                'show',
                'create',
                'edit',
                'delete',
            ],
        ],

        /**
         *
         *      Employee
         *
         */

        'employee' => [
            'events' => [
                'index',
                'show',
            ],
        ],
    ]
];
