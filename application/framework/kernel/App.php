<?php
abstract class App 
{

    private static $config;

    /**
     * Undocumented function
     *
     * @param [type] $lang
     * @return void
     */
    public static function set_locale( $lang = NULL){
        Lang::set_locale($lang);        
    }


    public static function initialize(){
        self::$config = Creative::include_config( 'app' );
    }


    public static function get(){
        return self::$config;
    }
    
}

?>