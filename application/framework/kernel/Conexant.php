<?php

define('DB_DRIVER_MYSQL', 'mysql');
define('DB_DRIVER_MSSQL', 'mssql');
define('DB_DRIVER_PGSQL', 'pgsql');
define('DB_DRIVER_SQLITE', 'sqlite');

/**
* Esta clase permite crear conexiones con MySQL y hacer consultas a base de datos
*/
class Conexant 
{

	const 
		  DNS_MYSQL = 'mysql:dbname=@dbname;host=@host;port=@port;charset=@charset'
		, DNS_MSSQL = 'sqlsrv:Server=@host;Database=@dbname;ConnectionPooling=0'
		, DNS_PGSQL = 'pgsql:dbname=@dbname;host=@host';

	protected 
		  $DRIVER		= DB_DRIVER_MYSQL
		, $DB_USER 		= NULL
		, $DB_PASSWORD 	= NULL
		, $DB_HOST 		= NULL
		, $DB_DATABASE 	= NULL
		, $DB_PORT 		= NULL
		, $DB_COLLATE 	= NULL
		, $connection	= NULL
		, $statement 	= NULL;
	
    private 
    	  $error 	= NULL
		, $result 	= NULL
		, $conected = FALSE
		, $options 	= array(
			  PDO::ATTR_PERSISTENT		 => FALSE
			, PDO::ATTR_ERRMODE			 => PDO::ERRMODE_EXCEPTION
			, PDO::ATTR_EMULATE_PREPARES => FALSE
	    );
    
	

    /**
	* -----------------------------------------------------------------------------
	* Conexant Constructor
	* -----------------------------------------------------------------------------
	* 
	* @return
	*/
    public function __construct($DB_USER = NULL, $DB_PASSWORD = NULL, $DB_DATABASE = NULL, $DB_HOST = 'localhost', $DB_PORT = '3306', $DB_COLLATE = 'utf8' )
	{
		if( $DB_USER != NULL )
		{
			$this->open($DB_USER, $DB_PASSWORD, $DB_DATABASE, $DB_HOST, $DB_PORT, $DB_COLLATE);
		}			
    }
    

    
    /**
	* Esta es la función que se conecta a la base de datos, 
	* en caso de existir un error en la conexión, 
	* lo almacena en el log de errores de PHP
	* @return
	*/
	public function open( $DB_USER = NULL, $DB_PASSWORD = NULL, $DB_DATABASE = NULL, $DB_HOST = 'localhost', $DB_PORT = '3306', $DB_COLLATE = 'utf8' )
	{		
		
		if( $DB_USER == NULL)
		{
			$this->DB_USER 		= DB_USER;
			$this->DB_PASSWORD 	= DB_PASSWORD;
			$this->DB_HOST 		= DB_HOST;
			$this->DB_DATABASE 	= DB_DATABASE;
			$this->DB_PORT 		= DB_PORT;
			$this->DB_COLLATE 	= DB_COLLATE;
		} else {
			$this->DB_USER 		= $DB_USER;
			$this->DB_PASSWORD 	= $DB_PASSWORD;
			$this->DB_HOST 		= $DB_HOST;
			$this->DB_DATABASE 	= $DB_DATABASE;
			$this->DB_PORT 		= $DB_PORT;
			$this->DB_COLLATE 	= $DB_COLLATE;
		}
		
    	mb_internal_encoding( 'UTF-8' );
		mb_regex_encoding( 'UTF-8' );
		
		try 
		{			
			//Seleccionar el Driver de Base de Datos por defecto para armar el DSN
			switch( $this->DRIVER )
			{
				//Connection to MariaDB or MySQL
				case 'mariadb':	

				case DB_DRIVER_MYSQL:
					$dsn = str_ireplace(
						array('@dbname', '@host','@port', '@charset'),
						array($this->DB_DATABASE, $this->DB_HOST, $this->DB_PORT, $this->DB_COLLATE),
						self::DNS_MYSQL
					);
					$this->connection = new PDO($dsn, $this->DB_USER, $this->DB_PASSWORD, $this->options);
				break;

				//Connection to PostgreSQL
				case DB_DRIVER_PGSQL:
					$dsn = str_ireplace(
						array('@dbname','@host'),
						array($this->DB_DATABASE, $this->DB_HOST),
						self::DNS_PGSQL
					);
					$this->connection = new PDO($dsn, $this->DB_USER, $this->DB_PASSWORD);
				break;

				//Connection to Microsoft SQL Server
				case DB_DRIVER_MSSQL:
					$dsn = str_ireplace(
						array('@dbname','@host'),
						array($this->DB_DATABASE, $this->DB_HOST),
						self::DNS_MSSQL
					);
					$this->connection = new PDO($dsn, $this->DB_USER, $this->DB_PASSWORD);
				break;

				//Connection to SQL Lite
				case DB_DRIVER_SQLITE:
					$this->pdo = new PDO('sqlite:' . $options[ 'connection_file' ], null, null,  $this->options);
				break;

				default :
					ErrorHandler::exception('database', 'EC0001' ,'DRIVER DATABASE Not support');
				break;
			}
			
			$this->conected = TRUE;
			return $this->conected;

		} catch (PDOException $ex) {
						
			//error_log($ex->getMessage());
			$title = 'Could not connect to database';

			if( ENVIRONMENT == 'development' )
			{
				$message  = '<strong>Connection Data:</strong><br/>';
				$message .= '<strong>Driver:</strong> '.$this->DRIVER.'<br/>';
				$message .= '<strong>Server:</strong> '.$this->DB_HOST.'<br/>';
				$message .= '<strong>DataBase:</strong> '.$this->DB_DATABASE.'<br/>';
				$message .= '<strong>User:</strong> '.$this->DB_USER.'<br/>';
				$message .= '<strong>Password:</strong> '.$this->DB_PASSWORD.'<br/>';
				$message .= '<strong>Port:</strong> '.$this->DB_PORT.'<br/>';
				$message .= '<strong>Collate:</strong> '.$this->DB_COLLATE.'<br/>';

				ErrorHandler::exception('database', 'EC0002', $title,  $message);
				
			} else {
				ErrorHandler::exception('database', 'EC0002', $title);
			}

			return FALSE;
		}
	}    
    
   
    
    /**
    * Desconecta y cierra la conexión activa con la base de datos
    * @return void
    */
    public function close()
	{
    	try
		{
    		if( $this->conected )
			{
				$this->connection = null;
		        $this->connection = NULL;
		        $this->conected = FALSE;
			}
		} catch ( Excepcion $ex) {
			
		}
    }
    


    /**
	* Esta función nos devuelve el número de error (en caso de haberlo) 
	* al haberse ejecutado una consulta o procedimiento.
	* 
	* @return
	*/
    public function get_error_no()
	{
        return $this->resource->errno;
    }


    
    /**
	* Esta función nos devuelve el mensaje de error (sin el número).
	* 
	* @return
	*/
    public function get_error()
	{
        return $this->resource->error;
    }
        
    

	/** 
	 * TODO: Revisar
	 * -----------------------------------------------------------------------
	 * Query
	 * ------------------------------------------------------------------------
	 * Execute an SQL statement, returning a result set as a PDOStatement object
	 * 
	 * @category Controllers
	 * @version 1.0.0
	 * @author name <name@email.com>
	 */
	public function query( $query )
	{
	
		if ( !$this->conected )
		{
	        $this->open( $this->DB_USER, $this->DB_PASSWORD, $this->DB_DATABASE, $this->DB_HOST );
	    }

		try
		{
			$std = $this->connection->query($query);
			return $std;
		} catch (Exception $ex) {
			ErrorHandler::error('Error in Query not found: ' . $ex->getMessage().'<br/>');
			return FALSE;
		}
	}
    
    
    /**
	* 
	* @param undefined $query
	* 
	* @return
	*/
    private function format_before( $query ){
		return 
			trim(
				str_ireplace(
					array(
						chr(13).chr(10),
						"\r\n",
						"\n",
						"\r",
						"\t"
					),
					array("", "", "", "", " "),
					$query)
			);
	}
    

	/**
	 * ----------------------------------------------------------------------------
	 * Execute SQL Query
	 * ----------------------------------------------------------------------------
	 * It executes a prepared SQL statement, returning a result set as an 
	 * indexed array either by column name, or numerically with base index 0 
	 * as returned in the result set.
	 * 
	 * Ejecuta una sentencia SQL preparada, devolviendo un conjunto de 
	 * resultados como un array indexado tanto por nombre de columna, 
	 * como numéricamente con índice de base 0 tal como fue devuelto en 
	 * el conjunto de resultados.
	 * 
	 * @param string $query
	 * @param array $params
	 * 
	 * @return void
	 */
	public function execute( $query, $params = [] ) 
	{
		$result = NULL;

		if ( !empty($params) )
		{
			foreach ($params as $key => $value)
			{
				switch (gettype($value))
				{
					case 'NULL':
						$params[ $key ] = [null, PDO::PARAM_NULL];
					break;
					case 'resource':
						$params[ $key ] = [$value, PDO::PARAM_LOB];
					break;
					case 'boolean':
						$params[ $key ] = [($value ? '1' : '0'), PDO::PARAM_BOOL];
					break;
					case 'integer':
					case 'double':
						$params[ $key ] = [$value, PDO::PARAM_INT];
					break;
					case 'string':
						$params[ $key ] = [$value, PDO::PARAM_STR];
					break;
				}
			}
		}
		
	  	if ( !$this->conected )
		{
	        $this->open( $this->DB_USER, $this->DB_PASSWORD, $this->DB_DATABASE, $this->DB_HOST );
	    }	    

    	$query_formated = $this->format_before($query);
		
    	try 
		{    		
			if ( $statement = $this->connection->prepare($query_formated) )
			{
				foreach ($params as $key => $value)
				{
					$statement->bindValue($key, $value[ 0 ], $value[ 1 ]);
				}

				if ( $statement->execute() )
				{
					$result = $statement->fetchAll( PDO::FETCH_ASSOC );
					$this->statement = $statement;
					return $result;
				} else {
					ErrorHandler::error(E_PDO, $statement->errorInfo(), $query , __LINE__);
					return FALSE;
				}				
			}
		} catch(PDOException $ex) {
			
			$message  = '<strong style="color:red">'.$ex->getMessage().'</strong> ';
			$message .= '[<strong>line:</strong> '.$ex->getLine().' <strong>in</strong> '.$ex->getFile().']<br/>';
			$message .= '<pre>' . $query.'</pre>';

			ErrorHandler::error(E_PDO, $ex->getMessage(),  $query, $ex->getLine());
		}
    }
    
    
    /**
	* Devuelve el número de filas afectadas por una sentencia DELETE, INSERT, o UPDATE.
	* 
	* @return
	*/
    public function row_count(){
		$result = $this->statement->rowCount();
		return $result;
	}
    
    
    /**
	* Ejecuta una consulta de tipo escalar
	* 
	* @param string $query
	* @param array $params
	* 
	* @return
	*/
	public function row( $query, $params = [] )
	{
        $result = $this->execute($query, $params);
        if (!is_null($result))
		{
            if (!is_object($result))
			{
                return count($result) > 0 ? $result[0] : [];
            } else {
               return $result[0];
            }
        }
        return FALSE;
    }
    
    
    /**
	* Cambia la base de datos
	* @param undefined $database
	* 
	* @return
	*/
    public function change_database($database)
	{
        $this->connection->changeDB($database);
    }
    

    /**
     * Iniciar una transacción
     * @return boolean, true on success or false on failure
     */
    public function begin()
	{
	  	if ( !$this->conected )
		{
	        $this->open( $this->DB_USER, $this->DB_PASSWORD, $this->DB_DATABASE, $this->DB_HOST );
	    }
        return $this->connection->beginTransaction();
    }
    

    /**
     * confirmar una transacción
     *  @return boolean, true on success or false on failure
     */
    public function commit()
	{
        return $this->connection->commit();
    }
    

    /**
     *  Revertir una transacción
     *  @return boolean, true on success or false on failure
     */
    public function rollback()
	{
        return $this->connection->rollBack();
    }
    
    
  	/**
     * Ejecuta una consulta
     * @param String La consulta
     * @return void
     */
    public function execute_call($sp, $params = null)
	{
    	if( empty($params) )
		{
            return false;
        }

    	$sql = "CALL {$sp} ";
        $values = [];

        foreach( $params as $field => $value )
		{
            $values[] = "'" .$value. "'";
        }
        
        $sql .= ' ('. implode(', ', $values) .')';
        $results = $this->connection->query( $sql );

        if( $this->connection->error )
		{
            $this->log_db_errors( $this->connection->error, $sql );
            return false;
        } else {
            return $results->fetch_assoc();
        }
    }


	/**
	 *  Devuelve el ultimo ID autonumerico insertado
	 *  @return string
	 */
    public function last_insert_id(){
		return $this->connection->lastInsertId();
    }
    	
	
	/**
	* Extra function to filter when only mysqli_real_escape_string is needed
	* @access public
	* @param mixed $data
	* @return mixed $data
	*/
	public function escape( $data ){
	   if( !is_array($data) )
	   {
	       $data = $this->connection->real_escape_string( $data );
	   } else {
	       $data = array_map( array( $this, 'escape' ), $data );
	   }
	   return $data;
	}



    /**
    * Destruir el objeto
    * Cierra todas las conexiones a la base de datos
    */
    public function __deconstruct()
	{
        foreach ( $this->connections as $connections )
		{
            $connections->close();
        }
    }

}
