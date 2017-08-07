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
            'text' => Lang::get('dashboard.attrs.name'),
            'required' => TRUE,
            'info' => Lang::get('dashboard.info.profile_name'),
            'col' => array('sm'=>6,'md'=>8),
            'type' => 'text'
        ],
        'default_module' => [
            'text' => Lang::get('dashboard.attrs.default_module'),
            'required' => TRUE,
            'info' => Lang::get('dashboard.info.default_module'),
            'col' => array('sm'=>6,'md'=>4),
            'type' => 'select',
            'default' => 1
        ],
        'description' => [
            'text' => Lang::get('dashboard.attrs.description'),
            'required' => TRUE,
            'info' => Lang::get('dashboard.info.description'),
            'col' => array('sm'=>6,'md'=>8),
            'type' => 'text',
            
        ],
        'status' => [
            'text' => Lang::get('dashboard.attrs.status'),
            'required' => TRUE,
            'info' => Lang::get('dashboard.info.status'),
            'col' => array('sm'=>6,'md'=>4),
            'type' => 'select'
        ],

     ],

    'filters' => [
        'name' => Lang::get('personal_attr.dni'),
    ]
    
];