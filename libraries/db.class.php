<?php
class Db extends MySqliDB
{
	/*
    * @var object array $instance
    */
	private static $instance = array();

    public static function getInstance($db = "default")
    {
		if(is_null(self::$instance[$db]))
		{
			include(_ROOT_PATH_.'config/dbconfig.php');
			self::$instance[$db] = new Db($db_config[$db]['host'], $db_config[$db]['username'], $db_config[$db]['password'], $db_config[$db]['database'], $db_config[$db]['port'], $db_config[$db]['charset']);
		}

		return self::$instance[$db];
    }

	/**
	 * Method to get the first row of the result set from the database query as an associative array
	 * of ['field_name' => 'row_value'].
	 *
	 * @param   mixed   $cursor  The optional result set cursor from which to fetch the row.
	 *
	 * @return  mixed  The return value or null if the query failed.
	 */
	public function loadAssoc($cursor = null)
	{
		// Initialise variables.
		$ret = null;

		// Get the first row from the result set as an associative array.
		if($this->getNumRows($cursor) == 1)
		{
			if ($array = $this->fetch_assoc($cursor))
			{
				$ret = $array;
			}
		}

		return $ret;
	}

	/**
	 * Method to get an array of the result set rows from the database query where each row is an associative array
	 * of ['field_name' => 'row_value'].  The array of rows can optionally be keyed by a field name, but defaults to
	 * a sequential numeric array.
	 *
	 * NOTE: Chosing to key the result array by a non-unique field name can result in unwanted
	 * behavior and should be avoided.
	 *
	 * @param   string  $key     The name of a field on which to key the result array.
	 *
	 * @param   mixed   $cursor  The optional result set cursor from which to fetch the row.
	 *
	 *
	 * @return  mixed   The return value or null if the query failed.
	 */
	public function loadAssocList($key = null, $cursor = null)
	{
		// Initialise variables.
		$array = array();

		// Get all of the rows from the result set.
		if($this->getNumRows($cursor) > 0)
		{
			while ($row = $this->fetch_assoc($cursor))
			{
				if ($key)
					$array[$row[$key]] = $row;
				else
					$array[] = $row;
			}
		}

		return $array;
	}

	/**
	 * Method to get the first row of the result set from the database query as an object.
	 *
	 * @param   mixed   $cursor  The optional result set cursor from which to fetch the row.
	 *
	 * @return  mixed   The return value or null.
	 */
	public function loadObject($cursor = null)
	{
		// Initialise variables.
		$ret = null;

		// Get the first row from the result set as an object of type $class.
		if($this->getNumRows($cursor) == 1)
		{
			if ($object = $this->fetch_object($cursor))
				$ret = $object;
		}

		return $ret;
	}

	/**
	 * Method to get an array of the result set rows from the database query where each row is an object.  The array
	 * of objects can optionally be keyed by a field name, but defaults to a sequential numeric array.
	 *
	 * NOTE: Chosing to key the result array by a non-unique field name can result in unwanted
	 * behavior and should be avoided.
	 *
	 * @param   string  $key    The name of a field on which to key the result array.
	 * @param   mixed   $cursor  The optional result set cursor from which to fetch the row.
	 *
	 * @return  mixed   The return value or null.
	 */
	public function loadObjectList($key='', $cursor = null)
	{
		// Initialise variables.
		$array = array();

		// Get all of the rows from the result set as objects of type $class.
		if($this->getNumRows($cursor) > 0)
		{
			while ($row = $this->fetch_object($cursor, $class))
			{
				if ($key)
					$array[$row->$key] = $row;
				else
					$array[] = $row;
			}
		}

		return $array;
	}

	/**
	 * Method to get the first row of the result set from the database query as an array.  Columns are indexed
	 * numerically so the first column in the result set would be accessible via <var>$row[0]</var>, etc.
	 *
	 * @param   mixed   $cursor  The optional result set cursor from which to fetch the row.
	 *
	 * @return  mixed  The return value or null if the query failed.
	 */
	public function loadArray($cursor = null)
	{
		// Initialise variables.
		$ret = null;

		// Get the first row from the result set as an array.
		if($this->getNumRows($cursor) == 1)
		{
			if ($row = $this->fetch_array($cursor))
				$ret = $row;
		}

		return $ret;
	}

	/**
	 * Method to get an array of the result set rows from the database query where each row is an array.  The array
	 * of objects can optionally be keyed by a field offset, but defaults to a sequential numeric array.
	 *
	 * NOTE: Chosing to key the result array by a non-unique field can result in unwanted
	 * behavior and should be avoided.
	 *
	 * @param   string  $key  The name of a field on which to key the result array.
	 *
	 * @param   mixed   $cursor  The optional result set cursor from which to fetch the row.
	 *
	 * @return  mixed   The return value or null if the query failed.
	 */
	public function loadArrayList($key=null, $cursor = null)
	{
		// Initialise variables.
		$array = array();

		// Get all of the rows from the result set as arrays.
		if($this->getNumRows($cursor) > 0)
		{
			while ($row = $this->fetch_array($cursor))
			{
				if ($key !== null)
					$array[$row[$key]] = $row;
				else
					$array[] = $row;
			}
		}

		return $array;
	}

	/**
	 * Method to get the first row of the result set from the database query as an row.  Columns are indexed
	 * numerically so the first column in the result set would be accessible via <var>$row[0]</var>, etc.
	 *
	 * @param   mixed   $cursor  The optional result set cursor from which to fetch the row.
	 *
	 * @return  mixed  The return value or null if the query failed.
	 */
	public function loadRow($cursor = null)
	{
		// Initialise variables.
		$ret = null;

		// Get the first row from the result set as an array.
		if($this->getNumRows($cursor) == 1)
		{
			if ($row = $this->fetch_row($cursor))
				$ret = $row;
		}

		return $ret;
	}

	/**
	 * Method to get an array of the result set rows from the database query where each row is an array.  The array
	 * of objects can optionally be keyed by a field offset, but defaults to a sequential numeric array.
	 *
	 * NOTE: Chosing to key the result array by a non-unique field can result in unwanted
	 * behavior and should be avoided.
	 *
	 * @param   string  $key  The name of a field on which to key the result array.
	 *
	 * @param   mixed   $cursor  The optional result set cursor from which to fetch the row.
	 *
	 * @return  mixed   The return value or null if the query failed.
	 */
	public function loadRowList($key=null, $cursor = null)
	{
		// Initialise variables.
		$array = array();

		// Get all of the rows from the result set as arrays.
		if($this->getNumRows($cursor) > 0)
		{
			while ($row = $this->fetch_row($cursor))
			{
				if ($key !== null)
					$array[$row[$key]] = $row;
				else
					$array[] = $row;
			}
		}

		return $array;
	}

	/**
	 * Method to get an array of the result set rows from the database query where each row is an associative array
	 * of ['field_name' => 'row_value'].  The array of rows can optionally be keyed by a field name, but defaults to
	 * a sequential numeric array.
	 *
	 * NOTE: Chosing to key the result array by a non-unique field name can result in unwanted
	 * behavior and should be avoided.
	 *
	 * @param   string  $sql	The SQL statement.
	 *
	 * @param   string  $key	The name of a field on which to key the result array.
	 *
	 * @return  array.
	 */
	public function fetchRows($sql, $key = null)
	{
		// This method must be used only with queries which display results
		if (!preg_match('#^\s*\(?\s*(select|show|explain|describe|desc)\s#i', $sql))
			die('database->retrieveAssocList() must be used only with select, show, explain or describe queries');

		$this->query($sql);

		$result_array = $this->loadAssocList($key);

		return $result_array;
	}

	public function fetchArray($sql)
	{
		// This method must be used only with queries which display results
		if (!preg_match('#^\s*\(?\s*(select|show|explain|describe|desc)\s#i', $sql))
			die('database->retrieveAssoc() must be used only with select, show, explain or describe queries');

		$this->query($sql);

		$result_array = $this->loadAssoc();

		return $result_array;
	}

	/**
	 * Inserts a row into a table based on an fields's properties.
	 *
	 * @param   string  $table  The name of a database table.
	 *
	 * @param   array   $fields  The row values of table.
	 *
	 * @return  boolean True on success.
	 */

	public function insertTableData($table, $fields)
	{
		$fields = $this->cc_addSlashes($fields);

		array_walk($fields, create_function('&$v, $k', 'if (is_string($v)) $v = "\'".$v."\'"; else if (is_null($v)) $v = "null"; else if ($v === false) $v = 0; else if ($v === true) $v = 1;'));

		$sql = "insert into $table (".implode(",", array_keys($fields)).") values (".implode(",", ($fields)).")";

		$result = $this->query($sql);

		return $result;
	}

	/**
	 * Updates a row in a table based on an fields's properties.
	 *
	 * @param   string  $table  The name of a database table.
	 *
	 * @param   array   $fields  The row values of table.
	 *
	 * @param   string  $where  The condition.
	 *
	 * @return  boolean True on success.
	 */

	public function updateTableData($table, $fields, $where = '')
	{
		$fields = $this->cc_addSlashes($fields);

		array_walk($fields, create_function('&$v, $k', 'if (is_string($v)) $v = "\'".$v."\'"; else if (is_null($v)) $v = "null"; else if ($v === false) $v = 0; else if ($v === true) $v = 1; $v=$k."=".$v;'));

		$sql = "update $table set ".implode(",", $fields);
		if ($where != "")
			$sql .= " where ".$where;

		$result = $this->query($sql);

		return $result;
	}

	/**
	 * Delete a row in a table.
	 *
	 * @param   string  $table  The name of a database table.
	 *
	 * @param   string  $where  The condition.
	 *
	 * @return  boolean True on success.
	 */
	public function deleteTableData($table, $where = "")
	{
		$sql = "delete from ".$table;
		if ($where != "")
			$sql .= " where ".$where;

		$result = $this->query($sql);

		return $result;
	}

	public function cc_addSlashes($fields)
	{
		if(is_array($fields))
			array_walk_recursive($fields, function(&$item, $key) {$item = addslashes(trim($item));});
		else
			$fields = addslashes(trim($fields));

		return $fields;
	}

	public function cc_stripSlashes($fields)
	{
		if(is_array($fields))
			array_walk_recursive($fields, function(&$item, $key) {$item = trim(stripslashes($item));});
		else
			$fields = stripslashes($fields);

		return $fields;
	}
}
