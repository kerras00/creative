<?php

/**
 * ------------------------------------------------------------------------
 * Class Controller
 * ------------------------------------------------------------------------
 * It contains the necessary code to respond to the requests that are 
 * requested in the application through the protocol HTTP, the requests 
 * can be considered as actions that the user executes like to make a 'click', 
 * to fill a field of text, to request record of a table , among others. 
 * It acts as an intermediate layer between Views and Models, managing the 
 * flow of information between them, responding to the mechanisms that may 
 * be required to implement the needs of the application
 * 
 * 
 * Contiene el código necesario para responder a las peticiones que se 
 * solicitan en la aplicación a traves del protocolo HTTP, las peticiones
 * pueden ser consideradas como acciones que el usuario ejecuta como hacer 
 * un 'click', rellenar un campo de texto, solicitar registro de una tabla, 
 * entre otros. Actua como una capa intermedia entre las Vistas y lo Modelos, 
 * gestionando el flujo de información entre ellos, respondiendo a los 
 * mecanismos que puedan requerirse para implementar las necesidades de la aplicación
 * 
 * @copyright   © 2017 Brayan Rincon
 * @version     1.0.
 * @author      Brayan Rincon <brayan262@gmail.com>
 */
abstract class Controller extends ControllerBase
{
	
	protected

		/** 
		 * ------------------------------------------------------------------------
		 * Controller Name
		 * ------------------------------------------------------------------------
		 * Controller name without Controller suffix
		 * 
		 * Nombre del controlador sin el sufijo Controller
		 * 
		 * @var string
		 */
		$controller_name = ''


		/** 
		 * -----------------------------------------------------------------------
		 * Controller Public Name
		 * ------------------------------------------------------------------------
		 * Controller Public Name, it may contain special characters such as 
		 * spaces and punctuation marks
		 * 
		 * Nombre Publico del controlador, este podrá contener caracteres 
		 * especiales como espacios y signos de puntuación
		 * 
		 * @var string
		 */
		, $controller_public_name = ''


		/** 
		 * -----------------------------------------------------------------------
		 * Controller Public Name
		 * ------------------------------------------------------------------------
		 * Describes a title for the Controller, it can be used in case the Controller 
		 * renders a view as the content of the <title> </ title>
		 * 
		 * 
		 * Describe un titulo para el Controller, puede ser utilizado en el 
		 * caso de que el Controller renderize una vista como el contenido 
		 * de la eqtiqueta <title></title>
		 * 
		 * @var string (Optional)
		 */
		, $title = ''


		/** 
		 * -----------------------------------------------------------------------
		 * Controller Public Name
		 * ------------------------------------------------------------------------
		 * It is used to group controllers by groups
		 * 
		 * Es utilizado para agrupar a los controladores por grupos>
		 * 
		 * @var array|null (Optional)
		 */
		, $category = NULL;


	/**
	 * ------------------------------------------------------------------------
	 * Controller Constructor
	 * ------------------------------------------------------------------------
	 *
	 * @param string $class
	 */
	public function __construct() {
		parent::__construct();
		$this->controller_name = str_ireplace( 'Controller', '', get_class($this) );
		/*$this->registry = [
			'root' => $this->controller_name
		];*/
	}

	

	/**
	* 
	* @param undefined $position
	* @param undefined $params
	* 
	* @return
	*/
	protected function add_btn_action_datatable( $position , $params){
		$this->view->assign('action_datatable_'.$position, array(
			array(
				'color'=> $params['color'],
				'onclick' => $params['onclick'],
				'tooltip' => $params['tooltip'],
				'icon' => $params['icon'],
			)
		));
	}
    
    protected function get_source_view($file, $group, $ambit = BACKEND){
    	if( ! file_exists(PATH_MODULES . $ambit .DS. 'views' .DS. $group .DS. $file . '.inc.tpl') ){
            return false;
        }
        return file_get_contents( PATH_MODULES . $ambit .DS. 'views' .DS. $group .DS. $file . '.inc.tpl');
    }
	
}
