<?php

return
[
    'text' => Lang::get('dashboard.modules.profiles'),

    'icon'=> 'fa fa-address-book',

    'module' => 'backend',

    'info' => Lang::get('dashboard.info.profiles_module'),
    
    'fields' => [
        'name' => Lang::get('dashboard.attrs.name'),
        'description' => Lang::get('dashboard.attrs.description'),
        'default_module' => Lang::get('dashboard.attrs.default_module'),
        'status' => Lang::get('dashboard.personal_attr.status'),
    ],

    'fields_info' => [
        'name' => [
            'required' => TRUE,
            'info' => Lang::get('dashboard.info.profile_name'),
            'col' => array('sm'=>6,'md'=>3),
            'type' => 'text'
        ],
     ],

    'filters' => [
        'name' => Lang::get('personal_attr.dni'),
    ]
    
];