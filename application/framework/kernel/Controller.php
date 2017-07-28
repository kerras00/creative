<?php

include_once PATH_KERNEL . 'ModelGenerator.php';


/**
 * 
 * 
 * @copyright   © 2017 Brayan Rincon
 * @version     1.0.0
 * @author      Brayan Rincon <brayan262@gmail.com>
 */
abstract class Controller extends ControllerBase
{
	
	public function __construct( $class ) {	
		parent::__construct($class);
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