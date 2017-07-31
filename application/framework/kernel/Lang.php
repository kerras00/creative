<?php
abstract class Lang 
{
    private static $lang_active;

    /**
     * Undocumented function
     *
     * @param [type] $message
     * @param [type] $option
     * @return void
     */
    public static function get($message, $option = NULL, $other = NULL)
    {
        $path_lang = PATH_APP .DS. 'langs' .DS. self::$lang_active .DS;

        $patterns = explode('.', $message);

        //array|string in lang.php
        if ( count($patterns) > 1 AND file_exists( $path_lang . $patterns[0].'.php') ){
           
            $content = include $path_lang . $patterns[0].'.php';
            $taken = $content[$patterns[1]]; //array|string
            
            if( is_array($taken) ){
                $taken = $taken[$patterns[2]];
            }

        //array|string in default
        } elseif ( count($patterns) > 1 AND !file_exists( $path_lang . $patterns[0].'.php') ){

            $content = include $path_lang . 'default.php';
            $taken = $content[$patterns[0]]; //array|string

            if( is_array($taken) ){
                $taken = $taken[$patterns[1]];
            }
            
        } else {
            $content = include $path_lang . 'default.php';
            $taken = $content[$message]; //string
        }

        if( is_string($taken) ){
            return self::process($taken , $option, $other);
        } else {
            $taken = $taken[$patterns[2]];
            return self::process($taken , $option, $other);
        }


        
    }

    static function process( $taken, $option = NULL, $other = NULL )
    {
        //Pluralización
        if( strpos($taken,'|') !== FALSE ){
            if( is_numeric($option) ){
                if( $option <= 1 ){
                    $taken = explode('|', $taken)[0];
                } else {
                    $taken = explode('|', $taken)[1];
                }
            } else{
                $taken = explode('|', $taken)[0];
            }
        }

        //Reemplazo de texto
        if( is_array($option) ){
            foreach ($option as $key => $value) {
                $taken = substr( ':'.$key, $value, $taken );
            }
        } elseif( is_numeric($option) ){
            $taken = str_ireplace( '{0}', $option, $taken );
        }       

        return $taken;
    }

    /**
     * Undocumented function
     *
     * @param [type] $lang
     * @return void
     */
    public static function set_locale( $lang = NULL){
        self::$lang_active = $lang;        
    }

    public static function get_locale(){
        return self::$lang_active;
    }
}

Creative::alias('l','Lang::get');

?>