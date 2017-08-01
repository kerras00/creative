<?php


class Registry
{

    private static $controllers = [];

    public static function initialize()
    {        
        $path_files = PATH_APP . 'registry' .DS ;
        $files = scandir($path_files);

        foreach ($files as $key => $value) {
            $path = $path_files.'/'.$value;

            if( strpos($value, '.php') ){
                if(is_file($path) AND is_readable($path)){
                    self::$controllers[str_replace('.php','',$value)] = include_once $path;
                }
            }

        }
    }


    public static function get($key)
    {
        if( isset(self::$controllers[$key]) ){
            $r = self::$controllers[$key];
            return $r;
        }   
    }


    /** 
     * -----------------------------------------------------------------------
     * Registry GET
     * ------------------------------------------------------------------------
     */
    public static function get_all()
    {
        $registry = self::$controllers;
        asort($registry);
  
        $arr = array_reverse($registry, true); 
        $arr['dashboard'] = [
            'text' => 'Dashboard',
            'icon'=> 'fa fa-dashboard',
            'module' => 'backend',
            'methods' => []
        ]; 
        $registry = array_reverse($arr, true);
        return $registry;
    }


    public static function get_json()
    {
        $registry = self::$controllers;
        asort($registry);
  
        $arr = array_reverse($registry, true); 
        $arr['dashboard'] = [
            'text' => 'Dashboard',
            'icon'=> 'fa fa-dashboard',
            'module' => 'backend',
            'methods' => []
        ]; 
        $registry = array_reverse($arr, true);
        
        $registry = json_encode($registry, JSON_PRETTY_PRINT);

        return $registry;
    }

}
?>
