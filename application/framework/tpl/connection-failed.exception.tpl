Connection error. Could not connect to database

<strong style="color:red">'.$ex->getMessage().'</strong><br/>
<strong>File:</strong> '.$ex->getFile().'<br/>
<strong>Method:</strong> '. __FUNCTION__ .'<br/>
<strong>Line:</strong> '.$ex->getLine();

<strong>Connection Data:</strong><br/>
<strong>Server:</strong> '.$this->DB_HOST.'<br/>
<strong>DataBase:</strong> '.$this->DB_DATABASE.'<br/>
<strong>User:</strong> '.$this->DB_USER.'<br/>
<strong>Password:</strong> '.$this->DB_PASSWORD.'<br/>
<strong>Port:</strong> '.$this->DB_PORT.'<br/>
<strong>Collate:</strong> '.$this->DB_COLLATE.'<br/><br/>