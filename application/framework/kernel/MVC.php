<?php

/** -----------------------------------------------------------------------
 * MVC
 * ------------------------------------------------------------------------
 * 
 * 
 * @category MVC
 * @version 1.0.0
 * @author Brayan Rincon <brayan262@gmail.com>
 */
class MVC 
{
    public static function get_controllers()
    {
        print_r (scandir(PATH_CONTROLLERS));
    }


    public static function get_backendcontrollers()
    {
        $path_controllers = PATH_APP . 'modules' .DS. 'backend' .DS. 'controllers' .DS ;
        $files = scandir($path_controllers);
        $controllers = [];

        foreach ($files  as $key => $value) {
            $path = $path_controllers.'/'.$value;

            if( strpos($value, '.php') ){
                if(is_file($path) AND is_readable($path)){
                    $class = str_ireplace('controller.php','',$value);
                    $métodos_clase = '';

                    $fp = fopen($path, 'r');
                    $method = $buffer = '';
                    $content = file_get_contents($path);
                    //while(!feof($fp)){
                        $buffer .= fread($fp, 512);
                        if (preg_match_all('/public function\s+(\w+)(.*)?\{/', $content, $match)) {
                            $method = $match[1];
                        }
                    //}

                    $controllers[] = array($class, $method);

                }
            }
        }

        return $controllers;

    }
}

?>