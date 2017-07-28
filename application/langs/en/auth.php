<?php

return [
    'auth'=> 'Login',
    'email'=> 'E-mail',
    'pass'=> 'Password',
    'back'=> 'Back',
    'recovery'=> 'Recovery Password',

    'send_recovery'=> 'Hemos enviado un conreo electrónico con las instracciones para reestablecer tu contaseña',

    'recovery_email'=> [
        'intro' => 'Hola, :name',
        'body' => 'Recientemente nos ha notificado que ha olvidado su contraseña. Para ayudarle a recordar su contraseña, utilice la siguiente información. Si usted no solicitó esta petición ignore este email.',
        'body_food' => 'Tenga en cuenta que no tienemos acceso a su cuenta y no puede restablecer su contraseña.',
        'footer' => 'Este correo electrónico se envió a :email. SU SEGURIDAD ES NUESTRA PRIORIDAD. NUNCA COMPARTA SU CONTRASEÑA CON NADIE, ¡INCLUIDOS NOSOTROS!',
        'link_text' => 'Reestablecer Contraseña',
        'ip' => 'La persona que solicitó que se envíe este correo electrónico tenía una dirección IP: :ip'
    ],

    'processing'=> 'Procesando',
    'admin'=> 'Administrators',
    'send'=> 'Send',
    'enter'=> 'Go',

    'email_required' => 'You need to know your email address!',
    'pass_required' => 'You need to enter your password.',
    'failed' => 'The combination of email address and password is not correct.',
    'throttle'=> 'Too many login attempts. Please try again in a few seconds.',    
    'throttle_time'=> 'Demasiados intentos de inicio de sesión. Inténtalo de nuevo en {0} minuto.|Demasiados intentos de inicio de sesión. Inténtalo de nuevo en {0} minutos.',
    'inactive'=> 'Your account has been blocked.',
    'activate'=> 'You must confirm your registration. We have sent an Email with the steps to activate your account.',
    'success'=> 'Welcome!'
];

?>