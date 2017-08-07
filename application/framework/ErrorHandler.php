<?php


/**
* Manejador de errores
* 
* @param undefined $codigo
* @param undefined $message
* @param undefined $file
* @param undefined $line
* 
* @return
*/

include_once __DIR__ . '/ExceptionHandler.php';

abstract class ErrorHandler{

	public static function error($code, $message, $file, $line){
		
		if (!(error_reporting() & $code)) {
			return; // Este código de error no está incluido en error_reporting
		}

		$file = substr($file, strpos($file, "application"));
		$file = str_replace(DS, '/', $file);
		
		$error = '<pre>';
		switch ($code) {
			case E_ERROR:
				$error .= "<pre><strong>FATAL ERROR  [{$code}]</strong> {$message}</pre><br/>\n";
				
			break;
			
			case E_COMPILE_ERROR:
				$error .= "<strong>COMPILE ERROR  [{$code}]</strong> $message<br/>\n";
				
			break;
			
			case E_PARSE:
				$error .= "<b>PARSE ERROR: </b> [$code] $message<br />\n";
				$error .= "  Error fatal en la línea $line en el archivo $file";
				$error .= "Abortando...<br />\n";
				
				
			case E_USER_ERROR:
				$error .= "<b>ERROR: </b> [$code] $message<br />\n";
				$error .= "  Error fatal en la línea $line en el archivo $file";
				$error .= "Abortando...<br />\n";
				
			break;
				
			case E_USER_WARNING:
				$error .= "<strong>WARNING[{$code}]</strong> {$message}<br/>\n";
				
			break;
				
			case E_USER_NOTICE:
				$error .= "<strong>USER NOTICE [$code]</strong> {$message} <strong>Line:</strong> $line in {$file}<br/<br/>\n";
				
			break;
			
			/**
			* Avisos en tiempo de ejecución. 
			* Indican que el script encontró algo que podría señalar un error, 
			* pero que también podría ocurrir en el curso normal al ejecutar un script.
			*/
			case E_NOTICE:
				$error .= "<strong>NOTICE:</strong> {$message} [<strong>line:</strong> $line <strong>in</strong> {$file}]";
			break;
			
			
			case E_STRICT:
				$error .= "<strong>STRICT ERROR  [{$code}]</strong> $message<br/>\n";
				
			break;
			
        	
			
			default:
				if( ENVIRONMENT == 'development' ){
					$error .= "<strong>UNDEFINED ERROR [{$code}]: </strong> {$message}  <strong>Line:</strong>: $line in {$file}<br/>\n";
					
				} else {
					logs::error( "UNDEFINED ERROR [{$code}]: {$message} </strong> Line: {$line} in {$file}" );
				}
			break;
				
		}
		echo $error . '</pre>';
		/* No ejecutar el gestor de errores interno de PHP */
		//return true;
	}

	/**
	* Checks for a fatal error, work around for set_error_handler not working on fatal errors.
	*/
	public static function  fatal_error(){
		$error = error_get_last();
		if ( $error["type"] == E_ERROR  ){
			$message = "LINE " . $error["line"] ." IN ". $error["file"] . " | " . $error["message"] . "\n";
			logs::error( $message );
		}			
	}

	private static
		$exception_type = [
			'database' => 'CreativeDataBaseException'
			, 'SmartyCompilerException' => 'CreativeSmartyCompilerException'
		];

	public static function exception( $type, $number, $title, $message = '' ){
		
		$template = Creative::default_template_html();	
		$content_file =  file_get_contents( __DIR__ . '/tpl/exception.tpl');
		$type = self::$exception_type[$type] == '' ? 'CreativeException' : self::$exception_type[$type];

		$content_file = str_ireplace(':content', $content_file, $template);
		$content_file = str_ireplace(':content', $content_file, $template);
		
		$content_file = str_ireplace(':header', CreativeBase::get_name() . '  <small>v'.CreativeBase::get_version().'</small>', $content_file);	
		$content_file = str_ireplace(':exception_number', $number, $content_file);
		$content_file = str_ireplace(':exception_type', $type, $content_file);
		$content_file = str_ireplace(':exception_title',$title, $content_file);			
			
		if( $message != '' ){
			$message = '<div class="error_info"><p>' . $message . '</p></div>';
		}
			
		$content_file = str_ireplace(':exception_message',$message, $content_file);
		
		$out = '<ul>';
		$trace = debug_backtrace();
		array_shift($trace);

		foreach( $trace as $key => $value){
			
			$out .= '<li>';
			$line = $value['line'];
			$file = $value['file'];

			$file = substr($file, strpos($file, "application"));
			$file = str_replace(DS, '/', $file);

			if( isset($value['class']) ){

				$out .= '<strong>'.$value['class'] .'</strong>';

				if( isset($value['function']) ){
					$out .= ' -> <strong>'.$value['function'].'</strong> ';
				}
				if( isset($value['line']) ){
					$out .= "[line: {$value['line']} - ". $file . "] ";
				}
				if( isset($value['args']) ){
					
					$arguments = '';
					foreach ($value['args'] as $args_ix => $arg) {
						if (!empty($args)) {
							$arguments .= ', ';
						}
						switch (gettype($arg)) {
							case 'integer':
							case 'double':
								$a = $arg;
							break;
							case 'string':
								$arg = htmlspecialchars(substr($arg, 0, 64)).((strlen($arg) > 64) ? '...' : '');
								$a = "'$arg'";
							break;
							case 'array':
								$a = 'Array('.count($arg).')';
							break;
							case 'object':
								$a = 'Object('.get_class($arg).')';
							break;
							case 'resource':
								$a = 'Resource('.strstr($arg, '#').')';
							break;
							case 'boolean':
								$a = $arg ? 'True' : 'False';
							break;
							case 'NULL':
								$a = 'Null';
							break;
							default:
								$a = 'Unknown';
						}

						$arguments .= $args_ix+1 .': '. $a.'<br/>';
					}

					$popover = 'data-toggle="popover" data-placement="top" data-content="'.$arguments.'"';
					$out .= ' - <a '.$popover.'>['.count($value['args']) .' Argument'. (count($value['args'])>0 ? 's': '') .']</a>';
				}

			} else {
				if( isset($value['function']) ){
					$out .= '<strong>'.$value['function'].'</strong> ';
				}
				if( isset($value['line']) ){
					$out .= "[line: {$value['line']} - ". $file . "] ";
				}
			}			
			$out .= ' -  [mem: ' . ceil( memory_get_usage()/1024) . 'Kb] </li>';
		}



		if( $out != '' ){
			$out = '<div class="error_info"><p>' . $out . '</ul></p></div>';
		}
			

		$content_file = str_ireplace(':calleds',$out, $content_file);
		
		echo($content_file);
		exit;
	}


	public static function exception_ex( $type, $number, $ex ){
	
		$template = Creative::default_template_html();	
		$content_file =  file_get_contents( __DIR__ . '/tpl/exception.tpl');
		$type = self::$exception_type[$type] == '' ? 'CreativeException' : self::$exception_type[$type];

		$content_file = str_ireplace(':content', $content_file, $template);
		$content_file = str_ireplace(':content', $content_file, $template);
		
		$content_file = str_ireplace(':header', CreativeBase::get_name() . '  <small>v'.CreativeBase::get_version().'</small>', $content_file);	
		$content_file = str_ireplace(':exception_number', $number, $content_file);
		$content_file = str_ireplace(':exception_type', $type, $content_file);
		$content_file = str_ireplace(':exception_title',$ex->desc, $content_file);

		$message = $ex->getMessage();
		$message = '<div class="error_info"><p>' . $message . '</p></div>';	
				
		$content_file = str_ireplace(':exception_message',$message, $content_file);		
		$content_file = str_ireplace(':calleds','', $content_file);
		
		echo($content_file);
		exit;
	}


	public static function _run_exception_( $exception_title, $exception_message = '' ){
		
		$template = Creative::default_template_html();	
		$file = __DIR__ . '/tpl/exception.tpl';
		$content_file = '';

		if (file_exists($file)){
			$file = fopen($file, 'r');
			while(!feof($file)) {
				$content_file .= fgets($file);
			}
			fclose($file);
		} else {
			die( $error_title );
		}

		$content_file = str_ireplace('@content',$content_file, $template);	
			
		$content_file = str_ireplace('@header',CreativeBase::get_info() . ' - <small>v'.CreativeBase::get_version().'</small>', $content_file);		
		$content_file = str_ireplace('@exception_title',$exception_title, $content_file);
		
		
		if( $exception_message != '' )
			$exception_message = '<div class="error_info"><p>' . $exception_message . '</p></div>';
			
		$content_file = str_ireplace('@exception_message',$exception_message, $content_file);
		
		
		$debug = debug_backtrace();
		$out = '';
		foreach( $debug as $key => $value){
			
			if( isset($value['line']) )
				$out .= '<strong>Line:</strong> '.$value['line'].' <strong>IN File:</strong> '.$value['file'].'<br/>';

			/*if( isset($value['file']) )
				$out .= '<strong>File:</strong> '.$value['file'].'<br/>';
			*/
			if( isset($value['class']) )
				$out .= '<strong>Class:</strong> '.$value['class'].' -> ';
			
			if( isset($value['function']) )
				$out .= '<strong>Function:</strong> '.$value['function'].'<br/>';
				
			$out .= '<br/>';
		}
		if( $out != '' )
			$out = '<div class="error_info"><p>' . $out . '</p></div>';

		$content_file = str_ireplace('@calleds',$out, $content_file);
		
		throw new Exception($content_file);
	}
	
	


}


set_error_handler("ErrorHandler::error");

set_exception_handler( 	
	function ($ex){

		$type = get_class($ex);

		switch ( TRUE ) {
			case $type == 'SmartyCompilerException':
				ErrorHandler::exception_ex( 'SmartyCompilerException', 'SM0001', $ex );
			break;
			
			default:
				echo $ex->getMessage();
			break;
		}
		
	}
);

register_shutdown_function( "ErrorHandler::fatal_error" );





?>