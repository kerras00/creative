<?php
abstract class Route 
{

    private static $routes;

    /**
     * Undocumented function
     *
     * @param [type] $lang
     * @return void
     */
    public static function get( $url, $func){
        self::$routes = array($url, $func);
    }
}

?>