<?php
abstract class Auth 
{

    private static $config;


    public static function initialize(){
        self::$config = Creative::include_config( 'auth' );;
    }

    public static function get(){
        return self::$config;
    }
    
}

?>