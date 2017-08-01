<?php
abstract class Helper
{

    private static $helpers = [];

    public static function initialize(){
        self::$config = Creative::include_config( 'app' );
        Creative::get( 'Conexant' )->open();
    }


    public static function get( $helper ){
        if( file_exists( PATH_APP .'helpers' .DS. $helper .DS. $helper. '.php') ){
            if( isset(self::$helpers[$helper]) ){
                return self::$helpers[$helper];
            } else {
                include_once PATH_APP .'helpers' .DS. $helper .DS. $helper. '.php';
                $helper_class = new $helper();
                self::$helpers[$helper] = $helper_class;
                return self::$helpers[$helper];
            }            
		}
    }    
}

Creative::alias('h','Helper::get');

?>