<?php

return
[
    'text' => Lang::get('dashboard.administration'),

    'icon'=> 'fa fa-cogs',

    'module' => 'backend',
    
    'rules' => [
        'dni' => Lang::get('personal_attr.dni'),
        'name' => Lang::get('personal_attr.name'),
        'last_name' => Lang::get('personal_attr.last_name'),
    ],

    'module' => [
        'users' => [
            'text' => Lang::get('dashboard.users'),
            'icon' => 'fa fa-users',

            'filters' => [
                'dni' => Lang::get('dashboard.personal_attr.dni'),
                'name' => Lang::get('dashboard.personal_attr.name'),
                'last_name' => Lang::get('dashboard.personal_attr.last_name'),
                'email' => Lang::get('dashboard.personal_attr.email'),
                'profile_id' => Lang::get('dashboard.personal_attr.profile'),
            ],
            
            'rules' => [
                'dni' => Lang::get('personal_attr.dni'),
                'name' => Lang::get('personal_attr.name'),
                'last_name' => Lang::get('personal_attr.last_name'),
            ],
        ],

        'profiles' => [
            'text' => Lang::get('dashboard.profiles'),
            'icon' => 'fa fa-address-book-o'
        ]
    ],

    'methods' => [
        'users' => [
            'text' => Lang::get('dashboard.users'),
            'icon' => 'fa fa-users',
            'filters' => [
                'dni' => Lang::get('dashboard.personal_attr.dni'),
                'name' => Lang::get('dashboard.personal_attr.name'),
                'last_name' => Lang::get('dashboard.personal_attr.last_name'),
                'email' => Lang::get('dashboard.personal_attr.email'),
                'profile_id' => Lang::get('dashboard.personal_attr.profile'),
            ],
        ],

        'profiles' => [
            'text' => Lang::get('dashboard.profiles'),
            'icon' => 'fa fa-address-book-o'
        ]
    ]
];