<?php 


return (object) [

    'auth_failed' => [

        /**
         * Cantidad de intentos permitidos
         */
        'try' => 3,

        /**
         * Tiempo para volver a hacer un intento de inicio de sesion
         */
        'time' => 60,

        /**
         * Establece si al alcanzar el numeros de intentos (try)
         * se procede a blquear la cuenta
         */
        'inactivate' => false
    ],

    'user_status' => array(
        'logical_erasure' => -1,
        'inactive' => 0,
        'active' => 1,
        'pending_activation' => 2,
    ),

    'user_ambit' => array(
        'frontend' =>  [
            'require' => [
                'email' => Lang::get('auth.email_required'),
                'pass'=> Lang::get('auth.pass_required'),
            ],
            'table' => 'users',
            'auth_redir' => '/dashboard/'
        ],
        'backend'=> [
            'require' => [
                'email' => Lang::get('email_required'),
                'pass'=> Lang::get('pass_required'),
            ],
            'table' => 'administrators',
            'auth_redir' => '/backend/dashboard/'
        ]
    )

];

?>