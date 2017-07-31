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
        $msg = '';
        if( strpos($message,'.') !== FALSE ){
            $arr = explode('.', $message);
            $file = $arr[0];
            $message = $arr[1];

            $file = $file == '' ? 'default' : $file ;

            if( file_exists(PATH_APP .DS. 'langs' .DS. self::$lang_active .DS. $file.'.php') ){
                $messages = include PATH_APP . 'langs' .DS. self::$lang_active .DS. $file.'.php';
                $msg = $messages[$message];
            } else {
                $messages = include PATH_APP . 'langs' .DS. self::$lang_active .DS. 'default.php';
                $msg = $messages[$arr[0]];
            };
            
        } else {
            if( file_exists(PATH_APP .DS. 'langs' .DS. self::$lang_active .DS. 'default.php') ){
                $messages = include PATH_APP .DS. 'langs' .DS. self::$lang_active .DS. 'default.php';
                $msg = $messages[$message];
            } else return '';            
        }

        if( is_array($msg) ){
            if( $file == 'default' )
                $msg = $msg[$arr[1]];
            else $msg = $msg[$arr[2]];
        }

        //Pluralización
        if( strpos($msg,'|') !== FALSE ){
            if( is_numeric($option) ){
                if( $option <= 1 ){
                    $msg = explode('|', $msg)[0];
                } else {
                    $msg = explode('|', $msg)[1];
                }
            } else{
                $msg = explode('|', $msg)[0];
            }
        }

        //Reemplazo de texto
        if( is_array($option) ){
            foreach ($option as $key => $value) {
                $msg = substr( ':'.$key, $value, $msg );
            }
        } elseif( is_numeric($option) ){
            $msg = str_ireplace( '{0}', $option, $msg );
        }       

        return $msg;
        
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