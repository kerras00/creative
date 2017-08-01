<?php
abstract class OuterHTML 
{

    private static $outer;

    public static function add($html){
        return self::$outer[] = $html;
    }

    public static function get(){
        return self::$outer;
    }
    
}

?>