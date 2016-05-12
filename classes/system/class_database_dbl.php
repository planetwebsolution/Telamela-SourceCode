<?php
/**
*
* Module name : Database
*
* Parent module : None
*
* Date created : 18th October 2013
*
* Date last modified : 18th October 2013
*
* Author : Vivek Avasthi
*
* Last modified by : Vivek Avasthi
*
* Comments : Database class use for connection. Execute queries like insert , update, delete etc.
*
*/ 	

class Database

{

	/**
	*
	* Variable declaration begins
	*
	*/ 

	// 0 = die($error), 1 = notify & continue, 2 = do nothing & continue

	var $onError = 0; 

	// 0 = ignore, otherwise email($query) if query time > $longQuery	

	var $longQuery = 0; 

	var $errorFrom = 'info@yakto.com';

	var $db;

	var $dbname;

	var $host;

	var $password;

	var $queries;

	var $result;

	var $user;	

	var $id;

	var $id_name;

	var $table_name;

	var $columns = array();



	/**
	*
	* Variable declaration ends
	*
	*/ 

	

	/**
	*
	*  Function name : Database
	*
	*  Return type : none
	*
	*  Date created : 18th October 2013
	*
	*  Date last modified : 18th October 2013
	*
	*  Author :  Vivek Avasthi
	*
	*  Last modified by : Vivek Avasthi
	*
	*  Comments : Constructor of database class
	*
	*  User instruction :$objDb = new Database($varDbServer, $varDbUser, $varDbPass, $varDbName);
	*
	*/

	function Database($host, $user, $password, $dbname)

	{

		$this->host     = $host;

		$this->user     = $user;

		$this->password = $password;

		$this->dbname   = $dbname;			

		

		if(LOCAL_MODE)

		{

			$errorTo = 'ashok@localhost.com';

			$errorPage = 'http://localhost/yakto/';

			$errorMsg = '';

		}

		else

		{

			$errorTo = 'ashok.negi@vinove.com';

			$errorPage= 'http://10.0.0.1/~sandbox/labs/yakto/';

			$errorMsg = '';

		}

	}



	/**
	*
	*  Function Name : connect
	*
	*  Return type : none
	*
	*  Date created : 18th October 2013
	*
	*  Date last modified : 18th October 2013
	*
	*  Author :  Vivek Avasthi
	*
	*  Last modified by : Vivek Avasthi
	*
	*  Comments : Use to connect with database If error redirect to notify page
	*
	*  User instruction :$objDb->connect($arg);
	*
	*/ 

	function connect($redirect = false)

	{

		 $this->queries = array();

		

		$this->db = mysql_connect($this->host, $this->user, $this->password) or $this->notify(mysql_error(), false, true);



		mysql_select_db($this->dbname, $this->db) or $this->notify(mysql_error(), false, true);

	}



	/**
	*
	*  Function Name : query
	*
	*  Return type : Record set
	*
	*  Date created : 18th October 2013
	*
	*  Date last modified : 18th October 2013
	*
	*  Author :  Vivek Avasthi
	*
	*  Last modified by : Vivek Avasthi
	*
	*  Comments : Execute mysql query. It takes one argument as a parameter. If error redirect to notify page
	*
	*  Calling function : getArrayResult();
	*
	*  User instruction :$objDb->query($sql);
	*
	*/

	function query($sql)

	{

		//Set multiple queries
		//echo "$sql <br><br>";
		$this->queries[] = $sql;
            
		//echo $sql;exit;

		$varStart = microtime();

		$this->result = mysql_query($sql) or $this->notify(mysql_error(),false ,true);

		$varStop = microtime();



		$varQueryExecutionTime = $varStop - $varStart;

		

		if(($this->longQuery != 0) && ($varQueryExecutionTime > $this->longQuery))

		{

			$msg  = $_SERVER['PHP_SELF'] . " @ " . date("Y-m-d H:ia") . "\n\n";

			$msg .= 'The following query took $varQueryExecutionTime to complete:\n\n';

			$msg .= $this->lastQuery() . "\n\n";

			$msg .= $this->queries() . "\n\n";

			

			@mail($this->errorTo, "Long Query " . $_SERVER['PHP_SELF'], $msg, "From: {$this->errorFrom}");

		}

		return $this->result;

	}

	

	/**
	*
	*  Function Name : formatColumnValue
	*
	*  Return type : Associative array
	*
	*  Date created : 18th October 2013
	*
	*  Date last modified : 18th October 2013
	*
	*  Author :  Vivek Avasthi
	*
	*  Last modified by : Vivek Avasthi
	*
	*  Comments : Add slashes in column values. It takes one argument as a parameter. Used in insert() and update().
	*
	*  User Instruction : $objDb->formatColumnValue($columnVals)
	*
	*/

	function formatColumnValue($columnVals)

	{

		foreach($columnVals  as $key => $val)

		{

			$columnVals[$key] = @mysql_real_escape_string($val);

		}	

		return $columnVals;

	}	

	

	/**
	*
	*  Function Name : quotedColumnValue
	*
	*  Return type : Associative array
	*
	*  Date created : 18th October 2013
	*
	*  Date last modified : 18th October 2013
	*
	*  Author :  Vivek Avasthi
	*
	*  Last modified by : Vivek Avasthi
	*
	*  Comments : Escapes special characters in a string for use in a SQL statement. It takes one argument as a parameter.
	*
	*  User Instruction : $objDb->quotedColumnValue($columnVals)
	*
	*/ 

	function quotedColumnValue($columnVals)

	{

		foreach($columnVals  as $key => $val)

		{	

			if($val=="now()" )

			{

				$columnValues[$key] = @mysql_real_escape_string($val);				

			}

			else

			{	$clmValue = @mysql_real_escape_string($val);

				$columnValues[$key] = "'".$clmValue."'";

			}	

		}	

		return $columnValues;

	}

	

	/**
	*
	*  Function Name : getArrayResult
	*
	*  Return type : Associative array
	*
	*  Date created : 18th October 2013
	*
	*  Date last modified : 18th October 2013
	*
	*  Author : Vivek Avasthi
	*
	*  Last modified by : Vivek Avasthi
	*
	*  Comments : Generate assoc array from record set. Used in selecting values from database. It takes query as a parameter.
	*
	*  User Instruction : $objDb->getArrayResult($columnVals)
	*
	*/ 

	function getArrayResult($sql)

	{

		$res = $this->query($sql);
                $resultProvider = array();
		

		if($res)

		{

			while ($row = mysql_fetch_assoc($res))

			{	

				$row = $this->formatDbValue($row);

				$resultProvider[] = $row;

			}

		}

		return $resultProvider;  

	 }

	

	/**
	*
	*  Function Name : formatDbValue
	*
	*  Return type : Associative array
	*
	*  Date created : 18th October 2013
	*
	*  Date last modified : 18th October 2013
	*
	*  Author : Vivek Avasthi
	*
	*  Last modified by : Vivek Avasthi
	*
	*  Comments : Format database value and remove addshlashes and htmlspecial chars. It takes two arg. as a parameter.
	*
	*  User Instruction : $objDb->formatDbValue($text, $nl2br = false)
	*
	*/ 

	function formatDbValue($text, $nl2br = false) 

	{

		if(is_array($text)) 

		{

			$tmp_array = Array();

			foreach($text as $key => $value) 

			{

				$tmp_array[$key] = $this->formatDbValue($value);

			} 

			return $tmp_array;

		} 

		else 

		{
			
                    if(mb_detect_encoding($text) == 'UTF-8')
			{
				$text = html_entity_decode(@htmlspecialchars(stripslashes($text), ENT_QUOTES, 'UTF-8'));
			}
			else
			{
				$text = iconv("ISO-8859-1", "UTF-8", $text);
				$text = html_entity_decode(utf8_encode(@htmlspecialchars(stripslashes($text), ENT_COMPAT | ENT_XHTML, 'UTF-8')));
				//$text = html_entity_decode(utf8_encode(@htmlspecialchars(stripslashes($text), ENT_QUOTES, 'UTF-8')));
			}	
			
			//$text = @htmlspecialchars(stripslashes($text));
			if($nl2br) 

			{

				return nl2br($text);

			} 

			else 

			{

				return $text;

			} 

		} 

	} 

	

	/**
	*
	*  Function Name : select
	*
	*  Return type : Associative array
	*
	*  Date created : 18th October 2013
	*
	*  Date last modified : 18th October 2013
	*
	*  Author :  Vivek Avasthi
	*
	*  Last modified by : Vivek Avasthi
	*
	*  Comments : Used to select values from a table. It takes table name and assoc column array, where, order by and limit as a parameter.
	*
	*  User Instruction : $objDb->formatDbValue($tableName, $arrColumns='', $where='', $orderBy='' , $limit='')
	*
	*/	

	function select($tableName, $arrColumns='', $where='', $orderBy='' , $limit='', $extra_option='', $resendQuery = false)

	{	

		if(!(is_array($arrColumns)) )

		{

			 $this->notify('function :  select() <br> Error: Passed argument should be an array!', false, true);

		}

		

		if(is_array($arrColumns)) 

		{

			$arrColumns = implode(',',$arrColumns);			

		}

		

		if($arrColumns=='*')

		{

			 $this->notify('function :  select() <br> Error: Passed argument should be an column no astric(*)!', false, true);

		}

		

		if($where=='')

		{

			$where = ' 1 ';

		}

		

		if($orderBy!='')

		{

			$orderBy = ' ORDER BY ' .	$orderBy;

		}

		

		if($limit!='')

		{

			$limit = ' LIMIT '.$limit;

		}

		

		$query = 'SELECT ' . $extra_option . $arrColumns . ' FROM '.$tableName . ' WHERE '. $where . $orderBy . $limit;
		
		$query=$query;
                if($resendQuery){
                    return $query;
                }
		//echo $query."<br /> <br />";

		return $this->getArrayResult($query);

	}



	/**
	*
	*  Function Name : insert
	*
	*  Return type : Integer
	*
	*  Date created : 18th October 2013
	*
	*  Date last modified : 18th October 2013
	*
	*  Author : Vivek Avasthi
	*
	*  Last modified by : Vivek Avasthi
	*
	*  Comments : Used to insert values in a table. It takes table name and assoc column array as a parameter.
	*
	*  User Instruction : $objDb->insert($tableName, $arrColumns)
	*
	*/

	function insert($tableName, $arrColumns)

	{

		$columnsKeys = join(", ", array_keys($arrColumns));

		

		$values  = $this->quotedColumnValue($arrColumns);

		 

		$values  =  join(", ", $values);



		//echo $values  = "'" . join("', '", $this->formatColumnValue($arrColumns)) . "'";



		$query =$this->query("INSERT INTO " . $tableName . " ($columnsKeys) VALUES ($values)");

		//Return inserted id

		$this->id = mysql_insert_id();

		return $this->id;

	}



	/**
	*
	*  Function Name : update
	*
	*  Return type : Integer
	*
	*  Date created : 18th October 2013
	*
	*  Date last modified : 18th October 2013
	*
	*  Author : Vivek Avasthi
	*
	*  Last modified by : Vivek Avasthi
	*
	*  Comments : Used to update values in a table. It takes table name,  assoc column array and where condition as a parameter.
	*
	*  User Instruction : $objDb->update($tableName, $arrColumns, $where)
	*
	*/

	function update($tableName, $arrColumns, $where)

	{

		$arrStuff = array();

		if(!(is_array($arrColumns)))

		{

			$this->notify('function :  update() <br> Error: Passed argument should be an array!', false, true);

		}

		

		if($where=='')

		{

			$this->notify('function :  update() <br> Error:  where condition is missing !', false, true);

		}

		

		//unset($this->columns[$this->id_name]);

		foreach($arrColumns as $key => $val)

		{	

			//if($val == 'now()')

			$varPosition = strpos($val, 'now()');

			$varPositionTwo = strpos($val, 'encode(');

			//if(strpos($val) === true)

			

			if($varPosition !== false )

			{

				$arrStuff[] = "$key = ".@mysql_real_escape_string($val);

			}

			else if($varPositionTwo !== false)

			{

				$arrStuff[] = "$key = ".$val;

			}

			else

			{

				$arrStuff[] = "$key = '".@mysql_real_escape_string($val)."'";

			}

			

				

		}

			

		$stuff = implode(", ", $arrStuff);

		

		//$id = mysql_real_escape_string($id);

		

		$sqlUpdate = 'UPDATE ' . $tableName . ' SET '. $stuff .' WHERE  ' . $where;	
        
        //echo $sqlUpdate;die; 
        
		 $this->query($sqlUpdate);

		// Not always correct due to mysql update bug/feature

		return mysql_affected_rows(); 

	}

	

	/**
	*
	*  Function Name : updateList
	*
	*  Return type : Integer value
	*
	*  Date created : 18th October 2013
	*
	*  Date last modified : 18th October 2013
	*
	*  Author :  Vivek Avasthi
	*
	*  Last modified by : Vivek Avasthi
	*
	*  Comments : Used to update values in a table. It takes table name,  assoc column array, column name and it's values (comma seperated or single array )  as a parameter.
	*
	*  User Instruction : $objDb->updateList($tableName, $arrColumns, $idName, $idValues)
	*
	*/

	function updateList($tableName, $arrColumns, $idName, $idValues)

	{	

		

		if(!(is_array($arrColumns)) || !(is_array($idValues)))

		{

			$this->notify('function :  updateList() <br> Error: Passed argument should be an array!', false, true);

		}

		

		if(count($idValues)>0)

		{

			if(is_array($idValues))

			{

				$idValues = implode(',',$idValues);

			}

		}

		else

		{

			$this->notify('function :  updateList() <br> Error: Passed array is blank!', false,true );

		}		

		

		$arrStuff = array();			

		

		foreach($this->formatColumnValue($arrColumns) as $key => $val)

		{

			$arrStuff[] = "$key = '".@mysql_real_escape_string($val)."'";

		}			

		$stuff = implode(", ", $arrStuff);		

		

		$sql="UPDATE " . $tableName . " SET " . $stuff . " WHERE ".$idName." IN ( ".$idValues." )";	

		$this->query($sql);		

		// Not always correct due to mysql update bug/feature

		return mysql_affected_rows(); 

	}

	

	/**
	*
	*  Function Name : delete
	*
	*  Return type : Integer value
	*
	*  Date created : 18th October 2013
	*
	*  Date last modified : 18th October 2013
	*
	*  Author : Vivek Avasthi
	*
	*  Last modified by : Vivek Avasthi
	*
	*  Comments : Used to delete records from a table. It takes table name and where condition as a parameter.
	*
	*  User Instruction : $objDb->updateList($tableName, $where)
	*
	*/ 					

	function delete($tableName, $where)

	{

		if($where=='')

		{

			$this->notify('function :  delete() <br> Error: where condition is missing !', false, true);

		}

	

		$idValue = @mysql_real_escape_string($idValue);
                	//echo "DELETE FROM " . $tableName . " WHERE " . $where; die;

		$varDel=$this->query("DELETE FROM " . $tableName . " WHERE " . $where);

//		echo $varDel;
//                die();

		return mysql_affected_rows();

	}		

	

	/**
	*
	*  Function Name : deleteList
	*
	*  Return type : Integer value
	*
	*  Date created : 18th October 2013
	*
	*  Date last modified : 18th October 2013
	*
	*  Author : Vivek Avasthi
	*
	*  Last modified by : Vivek Avasthi
	*
	*  Comments : Used to delete records from a table. It takes table name, column name and it's values (comma seperated or single array )as a parameter.
	*
	*  User Instruction : $objDb->deleteList($tableName, $idName, $idValues)
	*
	*/ 

	function deleteList($tableName, $idName, $idValues)

	{	

		if(!(is_array($idValues)))

		{

			$this->notify('function :  deleteList() <br> Error: passargument should be an array (idValues)!', false, true);

		}



		if(is_array($idValues))

		{

			$idValues = implode(',',$idValues);

		}

		

		$sqlDel = 'DELETE FROM ' . $tableName . ' WHERE ' . $idName . ' IN (' . $idValues . ')';

		//echo $sqlDel;exit;

		$this->query($sqlDel);

		return mysql_affected_rows();

	}		



	/**
	*
	*  Function Name : getNumRows
	*
	*  Return type : Number
	*
	*  Date created : 18th October 2013
	*
	*  Date last modified : 18th October 2013
	*
	*  Author :  Vivek Avasthi
	*
	*  Last modified by : Vivek Avasthi
	*
	*  Comments : Number of records in  a table . It takes three argument as a parameter.
	*
	*  User Instruction : $objDb->getNumRows($argTableName, $argClmn, $argWhr='1')
	*
	*/	

	function getNumRows($argTableName, $argClmn, $argWhr = '')

	{	
                
		$varWhr = '1 '.$argWhr;		

		$sqlNum = 'SELECT count('.$argClmn.') as numrows FROM ' . $argTableName .' Where '.$varWhr ;
		//echo $sqlNum;

		$varResult = mysql_query($sqlNum) or die(mysql_error());

		$resutlNum = mysql_fetch_assoc($varResult);

		return $resutlNum['numrows'];

	}

		

	/**
	*
	*  Function Name : numQueries
	*
	*  Return type : Number of queries. 
	*
	*  Date created : 18th October 2013
	*
	*  Date last modified : 18th October 2013
	*
	*  Author :  Vivek Avasthi
	*
	*  Last modified by : Vivek Avasthi
	*
	*  Comments : Display number of queries in queries array.
	*
	*  User Instruction : $objDb->numQueries()
	*
	*/ 	

	function numQueries()

	{

		return count($this->queries);

	}



	/**
	*
	*  Function Name : numQueries
	*
	*  Return type : query. 
	*
	*  Date created : 18th October 2013
	*
	*  Date last modified : 18th October 2013
	*
	*  Author : Vivek Avasthi
	*
	*  Last modified by : Vivek Avasthi
	*
	*  Comments : Display last executed query from  queries array.
	*
	*  User Instruction : $objDb->lastQuery()
	*
	*/ 

	function lastQuery()

	{

		return $this->queries[count($this->queries) - 1];

	}



	/**
	*
	*  Function Name : queries
	*
	*  Return type : queries. 
	*
	*  Date created : 18th October 2013
	*
	*  Date last modified : 18th October 2013
	*
	*  Author :  Vivek Avasthi
	*
	*  Last modified by : Vivek Avasthi
	*
	*  Comments : Display all queries from queries array .
	*
	*  User Instruction : $objDb->queries()
	*
	*/ 	

	function queries()

	{

		return implode("\n", $this->queries);

	}

	

	/**
	*
	*  Function Name : isValid
	*
	*  Return type : Boolean. 
	*
	*  Date created : 18th October 2013
	*
	*  Date last modified : 18th October 2013
	*
	*  Author :  Vivek Avasthi
	*
	*  Last modified by : Vivek Avasthi
	*
	*  Comments : Display all queries from queries array .
	*
	*  User Instruction : $objDb->queries()	
	*
	*/	

	function isValid() 

	{

		return isset($this->result) && (mysql_num_rows($this->result) > 0);

	}



	/**
	*
	*  Function Name : notify
	*
	*  Return type : none
	*
	*  Date created : 18th October 2013
	*
	*  Date last modified : 18th October 2013
	*
	*  Author : Vivek Avasthi
	*
	*  Last modified by : Vivek Avasthi
	*
	*  Comments : Display error message to user .There is  three parameter error message , redirect and show last query.
	*
	*  User Instruction : $objDb->notify($errMsg, $redirect = false, $showQuery = true)
	*
	*/ 	

	function notify($errMsg, $redirect = false, $showQuery = true)

	{	

		switch($this->onError)

		{

			case 0:

				if($showQuery)

				{

					$errMsg = $errMsg . "<br/><br/>" . $this->lastQuery();

				}

				else

				{

					$errMsg = $errMsg . "<br/><br/>";

				}	

				$_SESSION[sessErrMsg] = $errMsg;

				

				break;

			

			case 1:

				$msg  = $_SERVER['PHP_SELF'] . " @ " . date("Y-m-d H:ia") . "\n";

				$msg .= $errMsg . "\n\n";

				$msg .= $this->queries() . "\n\n";

				

				$msg .= "POST VARIABLES\n==============\n" . var_export($_POST, true) . "\n\n";

				$msg .= "GET VARIABLES\n=============\n"   . var_export($_GET, true)  . "\n\n";

				@mail($this->errorTo, $_SERVER['PHP_SELF'], $msg, "From: {$this->errorFrom}");

				header("Location: $_SERVER[HTTP_REFERER]");

				exit();

				break;

		}

		

		if($redirect)

		{	

			header("Location: $this->errorPage");

			exit();

		}

		else

		{

			die($_SESSION[sessErrMsg]);

		}			

	}

}
?>
