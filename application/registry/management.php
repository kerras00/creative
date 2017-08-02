<?php

return
[
    'text' => Lang::get('dashboard.modules.administration'),

    'icon'=> 'fa fa-cogs',

    'module' => 'backend',

    'modules' => [
        'users',
        'profiles'
    ]
];