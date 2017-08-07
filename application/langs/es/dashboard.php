 <?php

return [

       
    'success_save' => '¡Éxito! Registro guardado',
    'users' => 'Usuario|Usuarios',
    'profile' => 'Perfil|Perfiles',
    'my_profile' => 'Mi Perfil',
    'customize' => 'Personalizar',
    'field' => 'Campo|Campos',
    'access' => 'Acceso',


    'required'=> 'El campo :required es requerido.',
    'email_required' => 'Ingresa un correo electrónico para continuar.',
    'pass_required' => 'Ingresa una contraseña para continuar.',
    'name_required' => 'Necesitas ingresar un nombre para continuar',
    'required_continue'=> 'El campo :required es requerido para continuar.',
    'required_status'=> 'Seleccione un estatus.',
    'required_profile'=> 'Seleccione un perfil.',

    'modules' => [
        'users' => 'Usuarios',
        'profiles' => 'Perfiles',
        'administration' => 'Administración', 
    ],


    'exists_record'=> 'Existe un registro con el mismo correo electrónico.',
    
    'status' => [
        'active'=> 'Activo',
        'inactive'=> 'Inactivo',      
    ],

    'info' => [
        'search' => 'Buscar',
        'filter' => 'Filtros de busqueda',
        'module' => 'Módulo o entidad|Módulos o entidades',
        'view' => 'Lectura',
        'details' => 'Ver detalles',
        'add' => 'Agregar un nuevo registro|Agregar nuevos registros.',
        'edit' => 'Editar registro|Editar registros',
        'delete' => 'Eliminar registro|Eliminar registros',
        'print' => 'Imprimir registro|Imprimir registros',
        'custom' => 'Permite personalizar el acceso (Lectura y Escritura) de los campos del módulo.',
        'shared' => 'Compartir',
        'avanced_search' => 'Realizar una busqueda avanzada.',
        'users_module' => 'Gestión de usuarios del sistema.',
        'status' => 'Estatus',
        'modules_field_undefined' => 'No existen campos para configurar.',

        'profiles_module' => 'Gestión de perfiles y control de acceso de usuarios.',
        'profile_name' => 'Establece el nombre del perfil',

        'permission_custom' => 'Personalizar permisos.'      ,  
        'permission_access_yes' => 'Puede escribir en el campo.',
        'permission_access_hidden' => 'El campo estará oculto.',
        'permission_access_readonly' => 'El campo será de solo lectura.',
        'default_module' => 'Página de inicio por defecto.',

        'description'=> 'Descripción',

        'selection_check'=> 'Seleccionar todos',
        'selection_inverse'=> 'Invertir selección',
        'selection_uncheck'=> 'Borrar selección',

    ],

    'attrs' => [
        'code' => 'Código',
        'status' => 'Estatus',
        'name' => 'Nombre',
        'last_name' => 'Apellido',
        'nicname' => 'Alias',
        'pass' => 'Contraseña',
        'repeat_pass' => 'Repita tu contraseña',
        'profile' => 'Perfil',
        'dni' => 'Cédula',
        'email' => 'Correo electrónico',
        'birthdate' => 'Fecha de nacimiento',
        'description' => 'Descripción',
        'default_module' => 'Página de inicio',
        'status'=> 'Estatus',         
    ],


    'personal_attr' => [
        'code' => 'Código',
        'status' => 'Estatus',
        'name' => 'Nombre',
        'last_name' => 'Apellido',
        'nicname' => 'Alias',
        'pass' => 'Contraseña',
        'repeat_pass' => 'Repita tu contraseña',
        'profile' => 'Perfil',
        'dni' => 'Cédula',
        'email' => 'Correo electrónico',
        'birthdate' => 'Fecha de nacimiento',
        
    ],

    'module' => 'Módulo|Módulos',
    'actions' =>[        
        'actions' => 'Acciones',
        'view' => 'Lectura',
        'add' => 'Agregar',
        'edit' => 'Editar',
        'delete' => 'Eliminar',
        'print' => 'Imprimir',
        'custom' => 'Personalizar',
        'shared' => 'Compartir',
        'avanced_search' => 'Busqueda avanzada',
        'visualize' => 'Visualizar',
        'delete_confir' => '¿Confirma que desea eliminar este registro?'
    ]

];

?>
