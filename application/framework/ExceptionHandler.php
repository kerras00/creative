<?php 

class ExceptionHandler extends Exception{
    public $status;
	public $code;
	
    public function __construct($status, $statusText, $debug = '')
    {
        $this->status = $status;
        $this->statusText = $statusText;
        $this->debug = $debug 
        	? $debug 
        	: array("Line: " => $this->line ,"File: " => $this->file);
    }

}


class CreativeDatabaseException extends Exception 
{
    const
        FAILED_CONNECTION = 0
        , QUERY_ERROR = 1;

    private   
        $string
        , $trace;                          // Unknown

    protected 
        $message = 'Unknown exception'     // Exception message    
        , $code  = 0                       // User-defined exception code
        , $file                            // Source filename of exception
        , $line;                           // Source line of exception

	
    public function __construct($message, $code = self::QUERY_ERROR, $query = '')
    {
        parent::__construct($message, $code);
        $this->code = $code;
        $this->message = $message;
        $this->query = $query;
    }


    public function __toString()
    {
        return get_class($this) . " '{$this->message}' in {$this->file}({$this->line})\n"
                                . "{$this->getTraceAsString()}";
    }

}


?>