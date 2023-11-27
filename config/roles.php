<?php

/**
 *  Roles and permissions
 */

$models = [
    'users',
    'job_titles',
    'departments',
    'roles',
    'events',
    'posts',
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
        array_fill_keys($models,$permissions)
    ],


    'roles' => [
        /**
         *
         *      Admin
         *
         */

        'admin' => [
            'posts' => [
                'index',
                'create',
                'edit',
                'delete',
            ],
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
            'posts' => [
                'index',
            ],
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
            'posts' => [
                'index'
            ],
            'events' => [
                'index',
                'show',
            ],
        ],
    ]
];
