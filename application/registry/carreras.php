<?php

return
[
    'text' => 'Carreras',
    'icon'=> '',
    'module' => 'backend',

    'rules' => [
        'codigo' => Lang::get('personal_attr.code'),
        'nombre' => Lang::get('personal_attr.name'),
        'status' => Lang::get('personal_attr.status'),
    ],

    'filters' => [
        'codigo' => Lang::get('personal_attr.code'),
        'nombre' => Lang::get('personal_attr.name'),
    ],

    'methods' => [
        'detalles' => [
            'text' => 'Detalles',
            'icon' => 'fa fa-list'
        ],

        'otro' => [
            'text' => 'otro',
            'icon' => 'fa fa-list'
        ]
    ]
];