<?php
class URI
{
	private $page_url = "";
	private $uri_string = '';
	private $segments = array();
	
	public function __construct()
	{
		$this->_detect_uri();
		$this->_explode_segments();
	}
	
	private function _detect_uri()
	{
		if (!isset($_SERVER['REQUEST_URI']) OR !isset($_SERVER['SCRIPT_NAME']))
			return '';

		$uri = $_SERVER['REQUEST_URI'];
		if (strpos($uri, $_SERVER['SCRIPT_NAME']) === 0)
		{
			$uri = substr($uri, strlen($_SERVER['SCRIPT_NAME']));
		}
		else if (strpos($uri, dirname($_SERVER['SCRIPT_NAME'])) === 0)
		{
			$uri = substr($uri, strlen(dirname($_SERVER['SCRIPT_NAME'])));
		}

		// This section ensures that even on servers that require the URI to be in the query string (Nginx) a correct
		// URI is found, and also fixes the QUERY_STRING server var and $_GET array.
		if (strncmp($uri, '?/', 2) === 0)
		{
			$uri = substr($uri, 2);
		}
		$parts = preg_split('#\?#i', $uri, 2);
		$uri = $parts[0];
		if (isset($parts[1]))
		{
			$_SERVER['QUERY_STRING'] = $parts[1];
			parse_str($_SERVER['QUERY_STRING'], $_GET);
		}
		else
		{
			$_SERVER['QUERY_STRING'] = '';
			$_GET = array();
		}

		if ($uri == '/' || empty($uri))
			return '';

		$uri = parse_url($uri, PHP_URL_PATH);

		// Do some final cleaning of the URI and return it
		$this->uri_string = str_replace(array('//', '../'), '/', trim($uri, '/'));
		
		$this->page_url = $this->uri_string;
		
		if($_SERVER['QUERY_STRING'] != "")
			$this->page_url .= "?".$_SERVER['QUERY_STRING'];
	}

	/**
	 * Explode the URI Segments. The individual segments will
	 * be stored in the $this->segments array.
	 *
	 * @access	private
	 * @return	void
	 */
	private function _explode_segments()
	{
		if($this->uri_string != '')
			$this->segments = explode("/", preg_replace("|/*(.+?)/*$|", "\\1", $this->uri_string));
	}

	/**
	 * Fetch a URI Segment
	 *
	 * This function returns the URI segment based on the number provided.
	 *
	 * @param	integer
	 * @return	string
	 */
	public function segment($no)
	{
		return (isset($this->segments[$no])) ? $this->segments[$no] : false;
	}
	
	/**
	 * Segment Array
	 *
	 * @return	array
	 */
	public function segment_array()
	{
		return $this->segments;
	}
	
	/**
	 * Total number of segments
	 *
	 * @return	integer
	 */
	public function total_segments()
	{
		return count($this->segments);
	}
	
	/**
	 * Fetch the entire URI string
	 *
	 * @return	string
	 */
	public function uri_string()
	{
		return $this->uri_string;
	}
	
	/**
	 * Fetch the entire query string
	 *
	 * @return	string
	 */
	public function page_url()
	{
		return $this->page_url;
	}

	/**	This function use to fetch GET or POST method value. **/
	public function getVariable($var_name = '', $method = 'all')
	{
		if($method == 'all' and isset($_REQUEST[$var_name]))
			return $_REQUEST[$var_name];
		else if($method == 'get' and isset($_GET[$var_name]))
			return $_GET[$var_name];
		else if($method == 'post' and isset($_POST[$var_name]))
			return $_POST[$var_name];
		else
			return "";
	}

	public function getAllVariables($method = 'all')
	{
		$variables = array();
	
		if(($method == 'all' or $method == 'get') and count($_GET) > 0)
			$variables = array_merge($variables, $_GET);
	
		if(($method == 'all' or $method == 'post') and count($_POST) > 0)
			$variables = array_merge($variables, $_POST);
		
		return $variables;
	}
}
?>