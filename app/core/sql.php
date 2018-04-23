<?php
	$json = json_decode(file_get_contents('config.json', '.'));
	$con = new mysqli($json->host, $json->username, $json->password, $json->dbname, $json->port)
		or die ('Could not connect to the database server' . mysqli_connect_error());


	class Query
	{


		function select($selection, $table, $key=NULL, $value=NULL, $bindstring=NULL)
		{
			$bind_params = [];
			$sql = "SELECT ";
			if(is_array($selection) == true)
			{
				foreach($selection as $column)
				{
					$sql .= $column." , ";
				}
				$sql = substr($sql, 0, strlen($sql)- 2);

			}
			else
			{
				$sql .= $selection. " ";
			}

			$sql .= "FROM ". $table." ";
			if(isset($key))
			{
				$bind_params[] = $bindstring;
				if(is_array($key) == true)
				{

					$sql .= "WHERE ";

					for($i=0; $i< sizeof($key); $i++)
					{
						$sql .= $key[$i]. " = ? AND ";
					}
					$sql = substr($sql, 0, strlen($sql)- 5);

					foreach($value as $paramkey => $paramvalue)
					{
						$bind_params[] = & $value[$paramkey];
					}

				}
				else
				{
					$sql .= "WHERE ".$key. " = ?";
					$bind_params[] = &$value;
				}
			}


			if ($stmt = $GLOBALS["con"]->prepare($sql)) {
				if(isset($key))
					call_user_func_array(array($stmt, 'bind_param'), $bind_params);
    				$stmt->execute();
				$result = $stmt->get_result();
				if($result->num_rows > 0)
					return $result;
				else
					return NULL;
			}
			else
				return NULL;


		}

		function insert($insertion, $value, $table, $bindstring)
		{
			$bind_params = [];
			$bind_params[] = $bindstring;

			$sql = "INSERT INTO ". $table. " ( ";
			foreach($insertion as $column)
			{
				$sql .= $column." , ";
			}
			$sql = substr($sql, 0, strlen($sql)- 2);

			$sql .= ") VALUES ( ";
			foreach($value as $paramkey => $paramvalue)
			{
				$sql .= "? , ";
				$bind_params[] = & $value[$paramkey];
			}
			$sql = substr($sql, 0, strlen($sql)- 2);
			$sql .= ") ";

			if ($stmt = $GLOBALS["con"]->prepare($sql)) {
				call_user_func_array(array($stmt, 'bind_param'), $bind_params);
    				$stmt->execute();
				return true;

			}
			else
				return false;
		}

		function delete($table, $key, $value, $bindstring)
		{
			$bind_params = [];
			$bind_params[] = $bindstring;

			$sql = "DELETE FROM ". $table. " ";
			if(is_array($key) == true)
			{

				$sql .= "WHERE ";
				for($i=0; $i< sizeof($key); $i++)
				{
					$sql .= $key[$i]. " = ? AND ";
				}
				$sql = substr($sql, 0, strlen($sql)- 5);
				foreach($value as $paramkey => $paramvalue)
				{
					$bind_params[] = & $value[$paramkey];
				}
			}
			else
			{
				$sql .= "WHERE ".$key. " = ?";
				$bind_params[] = &$value;
			}

			
			
			if ($stmt = $GLOBALS["con"]->prepare($sql)) {
				call_user_func_array(array($stmt, 'bind_param'), $bind_params);
    				$stmt->execute();
				return true;

			}
			else
				return false;

		}

		function find( $string, $column, $table, $key, $value, $bindstring)
		{

			$bind_params = [];


			$sql = "SELECT ". $column. " FROM ". $table. " ";
			if(isset($key))
			{
				$bind_params[] = $bindstring;
				if(is_array($key) == true)
				{

					$sql .= "WHERE ";
					for($i=0; $i< sizeof($key); $i++)
					{
						$sql .= $key[$i]. " = ? AND ";
					}
					$sql = substr($sql, 0, strlen($sql)- 5);
					foreach($value as $paramkey => $paramvalue)
					{
						$bind_params[] = & $value[$paramkey];
					}
				}
				else
				{
					$sql .= "WHERE ".$key. " = ?";
					$bind_params[] = &$value;
				}
			}


			if ($stmt = $GLOBALS["con"]->prepare($sql)) {

				if(isset($key))
					call_user_func_array(array($stmt, 'bind_param'), $bind_params);
    				$stmt->execute();
				$result = $stmt->get_result();
				if($result->num_rows > 0)
				{

					while($row = $result -> fetch_assoc())
					{
						if($row[$column] == $string)
							return true;
					}
				}
				else
					return false;
			}
			else
				return false;

		}

		function update( $table, $column, $data, $key, $value, $bindstring)
		{
			$bind_params = [];
			$bind_params[] = $bindstring;

			$sql = "UPDATE ". $table. " SET ";
			if(is_array($column) == true)
			{
				for($i=0; $i< sizeof($column); $i++)
				{
					$sql .= $column[$i]. " = ? , ";
				}
				$sql = substr($sql, 0, strlen($sql)- 2);
				foreach($data as $paramkey => $paramvalue)
				{
					$bind_params[] = & $data[$paramkey];
				}
			}
			else
			{
				$sql .= $column. " = ? ";
				$bind_params[] = &$data;
			}

			if(is_array($key) == true)
			{

				$sql .= "WHERE ";
				for($i=0; $i< sizeof($key); $i++)
				{
					$sql .= $key[$i]. " = ? AND ";
				}
				$sql = substr($sql, 0, strlen($sql)- 5);
				foreach($value as $paramkey => $paramvalue)
				{
					$bind_params[] = & $value[$paramkey];
				}
			}
			else
			{
				$sql .= "WHERE ".$key. " = ?";
				$bind_params[] = &$value;
			}

			if ($stmt = $GLOBALS["con"]->prepare($sql)) {
				call_user_func_array(array($stmt, 'bind_param'), $bind_params);
    				$stmt->execute();
				return true;

			}
			else
				return false;
		}

		function querySQL($sql){

			if ($stmt = $GLOBALS["con"]->prepare($sql)) {
				$stmt->execute();
				$result = $stmt->get_result();
				if($result !=NULL)
				{
					if($result->num_rows > 0)
						return $result;
					else
						return NULL;
				}
				else
					return NULL;
			}
			else
				return NULL;
		}


		function getInsertId(){
			return $GLOBALS["con"]->insert_id;
		}
	}


?>
