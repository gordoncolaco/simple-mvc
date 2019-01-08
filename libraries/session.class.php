<?php
class Session implements ArrayAccess
{
	private $started;

	/*
    * @var object $instance
    */
	private static $instance = null;

	/**
     * Return Session instance
     *
     * @return object
     */
    public static function getInstance($session_name = '')
    {
		if(is_null(self::$instance))
			self::$instance = new Session($session_name);

        return self::$instance;
    }

	public function __construct($session_name = '')
	{
		$this->started = (isset($_SESSION) ? true : false);

		if (!$this->started)
			$this->start($session_name);
	}

	// Avoids that pesky notice error if the session was already started previously in the stack.
	public function start($session_name = '')
	{
		if (!$this->started)
		{
			if($session_name != '')
			{
				$session_name = str_replace(".", "", $session_name);
				$this->setName($session_name);
			}

			$secure = false;

			if ((isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1)) || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https'))
				$secure = true;

			$currentCookieParams = session_get_cookie_params();
			session_set_cookie_params($currentCookieParams["lifetime"], $currentCookieParams["path"], $currentCookieParams['domain'], $secure, true);

			session_start();
			$this->started = true;
		}
	}

	// destroy the session.
	public function destroy($clear_cookie = true, $clear_data = true)
	{
		if ($this->started)
		{
			if ($clear_cookie == true && ini_get("session.use_cookies") == true)
			{
				$params = session_get_cookie_params();
				setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
			}

			if($clear_data)
				$_SESSION = array();

			session_destroy();
			session_write_close();

			$this->started = false;
		}
	}

	public function offsetSet($key, $value)
	{
		$_SESSION[$key] = $value;
	}

	public function offsetExists($offset)
    {
        return isset($_SESSION[$offset]);
    }

	public function offsetGet($key)
	{
		return (isset($_SESSION[$key]) ? $_SESSION[$key] : false);
	}

	public function offsetUnset($key)
	{
		unset($_SESSION[$key]);
	}

	public function getId()
    {
        return session_id();
    }

	public function changeId()
	{
		session_regenerate_id();
	}

	public function setName($name)
    {
        return session_name($name);
    }

	public function getName()
    {
        return session_name();
    }

	public function closeSession()
	{
		session_write_close();
	}

	public function getSessionArray()
	{
		return $_SESSION;
	}
}