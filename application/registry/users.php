<?php

return
[
    'text' => Lang::get('dashboard.users'),

    'icon'=> 'fa fa-cogs',

    'module' => 'backend',
    
    'fields' => [
        'dni' => Lang::get('personal_attr.dni'),
        'name' => Lang::get('personal_attr.name'),
        'last_name' => Lang::get('personal_attr.last_name'),
    ],

    'filters' => [
        'dni' => Lang::get('dashboard.personal_attr.dni'),
        'name' => Lang::get('dashboard.personal_attr.name'),
        'last_name' => Lang::get('dashboard.personal_attr.last_name'),
        'email' => Lang::get('dashboard.personal_attr.email'),
        'profile_id' => Lang::get('dashboard.personal_attr.profile'),
    ]
    
];