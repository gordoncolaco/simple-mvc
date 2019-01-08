<?php
abstract class MySqliDB
{
	private $querycount = 0;
	
	// The database connection.
	private $connection;

	// resource  The database connection cursor from the last query.
	private $cursor;
	
	function __construct($host = null, $username = null, $password = null, $db = null, $port = null, $charset = 'utf8')
	{
		// Attempt to connect to the server.
		$this->connection = mysqli_connect($host, $username, $password, $db, $port);
		
		if(!$this->connection)
		{
			if(_MODE_DEV_)
				echo "Failed to connect to MySQL: (".mysqli_connect_error().")";
			else
				include("maintenance.php");
			
			die;
		}

		$this->setCharset($charset);
	}

	public function __destruct()
	{
		//echo "<br />".$this->querycount;
		
		if (is_object($this->connection))
			mysqli_close($this->connection);
	}

	/**
	 * Method to escape a string for usage in an SQL statement.
	 *
	 * @param   string  $text   The string to be escaped.
	 * @param   bool    $extra  Optional parameter to provide extra escaping.
	 *
	 * @return  string  The escaped string.
	 */
	public function escape($text, $extra = false)
	{
		$result = mysqli_real_escape_string($this->connection, $text);

		if ($extra)
			$result = addcslashes($result, '%_');

		return $result;
	}

	/**
	 * Get the number of affected rows for the previous executed SQL statement.
	 *
	 * @return  integer  The number of affected rows.
	 */
	public function getAffectedRows()
	{
		return mysqli_affected_rows($this->connection);
	}

	/**
	 * Get the number of returned rows for the previous executed SQL statement.
	 *
	 * @param   resource  $cursor  An optional database cursor resource to extract the row count from.
	 *
	 * @return  integer   The number of returned rows.
	 */
	public function getNumRows($cursor = null)
	{
		return mysqli_num_rows($cursor ? $cursor : $this->cursor);
	}

	/**
	 * Method to get the auto-incremented value from the last INSERT statement.
	 *
	 * @return  integer  The value of the auto-increment field from the last inserted row.
	 */
	public function insertid()
	{
		return mysqli_insert_id($this->connection);
	}

	/**
	 * Execute the SQL statement.
	 *
	 * @return  mixed  A database cursor resource on success, boolean false on failure.
	 */
	public function query($sql)
	{
		$this->querycount++;
		$this->cursor = mysqli_query($this->connection, $sql);

		if(!$this->cursor && _MODE_DEV_)
			die($sql."<br /><b>".mysqli_error($this->connection)."<br />");

		return $this->cursor;
	}

	/**
	 * Method to fetch a row from the result set cursor as an array.
	 *
	 * @param   mixed  $cursor  The optional result set cursor from which to fetch the row.
	 *
	 * @return  mixed  Either the next row from the result set or false if there are no more rows.
	 */
	protected function fetch_array($cursor = null)
	{
		return mysqli_fetch_array($cursor ? $cursor : $this->cursor);
	}

	/**
	 * Method to fetch a row from the result set cursor as an row.
	 *
	 * @param   mixed  $cursor  The optional result set cursor from which to fetch the row.
	 *
	 * @return  mixed  Either the next row from the result set or false if there are no more rows.
	 */
	protected function fetch_row($cursor = null)
	{
		return mysqli_fetch_row($cursor ? $cursor : $this->cursor);
	}

	/**
	 * Method to fetch a row from the result set cursor as an associative array.
	 *
	 * @param   mixed  $cursor  The optional result set cursor from which to fetch the row.
	 *
	 * @return  mixed  Either the next row from the result set or false if there are no more rows.
	 */
	protected function fetch_assoc($cursor = null)
	{
		return mysqli_fetch_assoc($cursor ? $cursor : $this->cursor);
	}

	/**
	 * Method to fetch a row from the result set cursor as an object.
	 *
	 * @param   mixed   $cursor  The optional result set cursor from which to fetch the row.
	 *
	 * @return  mixed   Either the next row from the result set or false if there are no more rows.
	 */
	protected function fetch_object($cursor = null)
	{
		return mysqli_fetch_object($cursor ? $cursor : $this->cursor);
	}

	public function setCharset($charset)
	{
		mysqli_set_charset($this->connection, $charset);
	}
	
	public function error()
	{
		return mysqli_error($this->connection);
	}
}
