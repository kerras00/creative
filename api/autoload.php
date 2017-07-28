<?php

/**
 * Función de autoload
 * Se utiliza para incluir el controlador apropiado, solo cuando se necesita
 * @param String el nombre de la clase
 */ 
function autoload_kernel_api($file) {
	if(file_exists( __DIR__ .DS. '/kernel' .DS. $file . '.php')){
		include_once( __DIR__ .DS. '/kernel' .DS. $file . '.php' );
	}
}
spl_autoload_register('autoload_kernel_api');



function autoload_controllers_api($ClassName) {
	/*if(file_exists(PATH_CONTROLLERS . $ClassName . '.php')){
		include_once(PATH_CONTROLLERS . $ClassName . '.php' );
	}*/
}
spl_autoload_register('autoload_controllers_api');
