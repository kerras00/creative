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

    /** 
     * -----------------------------------------------------------------------
     * GET Menu
     * -----------------------------------------------------------------------
     * Dvuelve un listado organizado del menu de la aplciación
     */
    public static function get_menu()
    {
        $registry = self::$controllers;
        asort($registry);
  
        $arr = array_reverse($registry, true); 
        $arr['dashboard'] = [
            'text' => 'Dashboard',
            'icon'=> 'fa fa-dashboard',
            'module' => 'backend',
        ];
        $registry = array_reverse($arr, true);

        foreach (array_reverse($arr, true) as $mdule_name => $module_attr) {
            $temp = [
                'text' => isset($module_attr['text']) ? $module_attr['text'] : '',
                'icon' => isset($module_attr['icon']) ? $module_attr['icon'] : '',
                'module' => isset($module_attr['module']) ? $module_attr['module'] : '',
                'info' => isset($module_attr['info']) ? $module_attr['info'] : '',
            ];

            if( isset($module_attr['modules']) AND count($module_attr['modules']) ){
                $registry[$mdule_name]['modules'] = [];
                foreach ($module_attr['modules'] as $key => $value){
                    $registry[$mdule_name]['modules'][$value] = [
                        'text' => isset($registry[$value]['text']) ? $registry[$value]['text'] : '',
                        'icon' => isset($registry[$value]['icon']) ? $registry[$value]['icon'] : '',
                        'module' => isset($registry[$value]['module']) ? $registry[$value]['module'] : '',
                        'info' => isset($registry[$value]['info']) ? $registry[$value]['info'] : '',
                    ];    
                    unset($registry[$value]);
                }                
            }
        }

        return $registry;
    }


    /** 
     * -----------------------------------------------------------------------
     * GET Menu
     * ------------------------------------------------------------------------
     */
    public static function get_modules()
    {
        $registry = self::$controllers;
        asort($registry);
  
        $arr = array_reverse($registry, true); 
        $arr['dashboard'] = [
            'text' => 'Dashboard',
            'icon'=> 'fa fa-dashboard',
            'module' => 'backend',
        ];
        $registry = array_reverse($arr, true);

        foreach (array_reverse($arr, true) as $mdule_name => $module_attr) {
            if( isset($module_attr['modules']) AND count($module_attr['modules']) ){
                unset($registry[$mdule_name]);
            }
        }

        return $registry;
    }


    public static function get_registry_of_modules_json()
    {
        $registry = self::$controllers;
        asort($registry);
  
        $arr = array_reverse($registry, true); 
        $arr['dashboard'] = [
            'text' => 'Dashboard',
            'icon'=> 'fa fa-dashboard',
            'module' => 'backend',
        ];

        $registry = array_reverse($arr, true);
        foreach (array_reverse($arr, true) as $mdule_name => $module_attr) 
        {
            $registry[$mdule_name]['access'] = 0;
        }
        $registry = json_encode($registry, JSON_PRETTY_PRINT);

        return $registry;
    }

}

?>