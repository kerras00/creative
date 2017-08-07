<?php

/**
 * 
 * @package     Creative
 * @copyright   © 2017 Brayan Rincon
 * @version     1.0.0
 * @author      Brayan Rincon <brayan262@gmail.com>
 */
abstract class ControllerBase
{

	private   $registry; 
    protected 
        $view,
        $request,
        $acl,
        $metadata,
        $storage,
        $module;
	
	public function __construct() {		

		$storage 			= new \SplObjectStorage();

		$this->request		= $GLOBALS['CREATIVE']['request'];
		$this->acl 			= new Acl();
		
		$this->view = new View( $this->request, $this->acl );
	}


	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	abstract public function index();


	/**
	* 
	* @param undefined $observer
	* 
	* @return
	*/
	protected function attach(\SplObserver $observer){}
    
    
    /**
	* 
	* @param undefined $observer
	* 
	* @return
	*/
    protected function detach(\SplObserver $observer){ }	
    

    /**
	* 
	* 
	* @return
	*/
	protected function notify(){}
	
    	
	
	/**
	* Load a new module
	* @param string $model Name of the model to load
	* @param string $module Name of the module where the model is located (Optional)
	* 
	* @return
	*/
	protected function load_model( $model, $primary_key = 'id' ) {
		
		$model =  $model . 'Model';
		$path_model = PATH_APP . 'mvc' .DS. 'models' .DS. $model . '.php';
		
		if (is_readable($path_model)) {
			
		  require_once $path_model;
		  $model = new $model;
		  return $model;
		  
		} else {
			
			$path_model =  PATH_KERNEL . 'ModelGenerator.php';
			
			if (is_readable($path_model)) {
				
				$table = str_ireplace('Model','', $model);
				$ModelGenerator = 'ModelGenerator';
				$model = new $ModelGenerator($table, $primary_key);
		  		return $model;
				
			} else {
				if( ENVIRONMENT == 'development' ){
					$message = '<h3 style="text-transform: uppercase;">Error al cargar modelo</h3>';
					$message .= '<strong>Model</strong> [<span style="color:red">'.$model.'</span>]<br/>';
					$message .= '<strong>Path</strong> [<span style="color:red">'.$path_model.'</span>]';
				} else {
					$message = 'Error al cargar modelo: '.$modelo;
				}
				
				ErrorHandler::run_exception( $message );
				return FALSE;
			}
		}
	}


	/**
	* Carga una librería
	* @param undefined $libreria
	* @param undefined $subdir
	* 
	* @return
	**/
    protected function load_librery($lib, $instance = FALSE) {
        $dir_lib = PATH_LIBS . $lib .DS. $lib .'.php';
        if (is_readable($dir_lib)) {
            require_once $dir_lib;
            if($instance){
            	$lib = new $lib;
            	return $lib;
            }
        } else {
            throw new Exception('Error en librería');
        }
    }
    

	/**
	* Si no existe la variable POST se devuelve una cadena vacía '', 
	* y Convierte caracteres especiales en entidades HTML 
	* @param undefined $clave
	* 
	* @return
	*/
    protected function get_string($clave){
        if(isset($_POST[$clave]) && !empty($_POST[$clave])){
            $_POST[$clave] = htmlspecialchars($_POST[$clave], ENT_QUOTES);
            return $_POST[$clave];
        }
        return '';
    }
    

    /**
	* Si no existe la variable POST se devuelve una cadena vacía ''
	* @param undefined $clave
	* 
	* @return
	*/
    protected function get_post($clave){
        if(isset($_POST[$clave]) && !empty($_POST[$clave])){
            return $_POST[$clave];
        }
        return '';
    }
    
    
    protected function get_float($clave){
        if(isset($_POST[$clave]) && !empty($_POST[$clave])){
            return (float)$_POST[$clave];
        }
        return 0.0;
    }
    
    
    protected function get_int($clave){
        if(isset($_POST[$clave]) && !empty($_POST[$clave])){
            $_POST[$clave] = filter_input(INPUT_POST, $clave, FILTER_VALIDATE_INT);
            return $_POST[$clave];
        }
        return 0;
    }
    
    
    /** -------------------------------------------------------
     * Location
     * --------------------------------------------------------
     * Gets a POST variable and applies a filter to return only alphanumeric characters
	* @param undefined $clave
	* 
	* @return string $key 
	*/
    protected function get_alphanum($key){
        if(isset($_POST[$clave]) && !empty($_POST[$key])){
            $_POST[$key] = (string) preg_replace('/[^a-zA-Z0-9_]/i', '', $_POST[$clave]);
            return trim($_POST[$key]);
        }
        return '';
    }

    
    /** -------------------------------------------------------
     * Location
     * --------------------------------------------------------
     * Redirect to a URL specified by the $route parameter
     * 
     * @param string $route
     */
	protected function location($route = FALSE, $external = FALSE){
   		if( $external ){
			header('Location: ' . $route);
			exit;
		}	

        if($route){
            header('Location: /' . $route);
            exit;
        }
    }
    

    /** -------------------------------------------------------
     * No Chaching
     * --------------------------------------------------------
     * Prevents cache in the application
     */
	protected function no_cache() {
		header("Expires: Tue, 01 Jul 2001 06:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
	}	
}