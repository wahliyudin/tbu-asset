<?php

return [
    'sidebars' => [
        [
            'title' => 'DASHBOARD',
            'child' => [
                [
                    'title' => 'DASHBOARD',
                    'permissions' => 'c,r,u,d',
                ],
                [
                    'title' => 'PERSONAL DASHBOARD',
                    'permissions' => 'c,r,u,d',
                ],
            ]
        ],
        [
            'title' => 'MASTER',
            'child' => [
                [
                    'title' => 'CATEGORY',
                    'permissions' => 'c,r,u,d',
                ],
                [
                    'title' => 'CLUSTER',
                    'permissions' => 'c,r,u,d',
                ],
                [
                    'title' => 'SUB CLUSTER',
                    'permissions' => 'c,r,u,d',
                ],
                [
                    'title' => 'SUB CLUSTER ITEM',
                    'permissions' => 'c,r,u,d',
                ],
                [
                    'title' => 'CATALOG',
                    'permissions' => 'c,r,u,d',
                ],
                [
                    'title' => 'DEALER',
                    'permissions' => 'c,r,u,d',
                ],
                [
                    'title' => 'LEASING',
                    'permissions' => 'c,r,u,d',
                ],
                [
                    'title' => 'UNIT',
                    'permissions' => 'c,r,u,d',
                ],
                [
                    'title' => 'UOM',
                    'permissions' => 'c,r,u,d',
                ],
            ]
        ],
        [
            'title' => 'ASSET MASTER',
            'child' => [
                [
                    'title' => 'ASSET MASTER',
                    'permissions' => 'c,r,u,d',
                ],
            ]
        ],
        [
            'title' => 'ASSET REQUEST',
            'child' => [
                [
                    'title' => 'ASSET REQUEST',
                    'permissions' => 'c,r,u,d,approv,reject,report',
                ],
                [
                    'title' => 'ASSET REGISTER',
                    'permissions' => 'c,r,u',
                ],
            ]
        ],
        [
            'title' => 'ASSET TRANSFER',
            'child' => [
                [
                    'title' => 'ASSET TRANSFER',
                    'permissions' => 'c,r,u,d,approv,reject,report',
                ],
            ]
        ],
        [
            'title' => 'ASSET DISPOSE',
            'child' => [
                [
                    'title' => 'ASSET DISPOSE',
                    'permissions' => 'c,r,u,d,approv,reject,report',
                ],
            ]
        ],
        [
            'title' => 'SETTING',
            'child' => [
                [
                    'title' => 'APPROVAL',
                    'permissions' => 'c,r,u,d',
                ],
                [
                    'title' => 'ACCESS PERMISSION',
                    'permissions' => 'r,u',
                ],
            ]
        ],
    ],
    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete',
        'approv' => 'approv',
        'reject' => 'reject',
        'report' => 'report',
        'list' => 'list',
    ]
];
