<?php
/** -----------------------------------------------------------------------
 * Index Controller
 * ------------------------------------------------------------------------
 * #
 * 
 * @category Controllers
 * @version 1.0.0
 * @author name <name@email.com>
 */
class indexController extends Controller 
{
    function __construct() {
		parent::__construct(__CLASS__);
		
		/**
		* Default template in which views are rendered
		*/
        $this->view->template ( 'default' );

		/**
		* Avoid caching
		*/
        $this->no_cache();
    }



    /** 
     * ------------------------------------------------------------------------
     * Default Index Method
     * ------------------------------------------------------------------------
     * #
     * 
     * @author name <name@email.com>
     */
    public function index(){
        $this->view->render( __FUNCTION__ );
    }
}


?>