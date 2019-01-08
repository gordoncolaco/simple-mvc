<?php
define('_MODE_DEV_', true);
if (_MODE_DEV_)
{
	error_reporting(E_ALL & ~E_NOTICE);
	@ini_set('display_errors', 'on');
}
else
{
	error_reporting(0);
	@ini_set('display_errors', 'off');
}

define("_TOKEN_SALT_", "tLk+gerM%Ki4%+TGH3A");
define("_ENCRYPT_SALT_", "fES#Aep&oK");

if((isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1)) || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https'))
{
	$protocol = 'https://';
}
else
{
	$protocol = 'http://';
}

if($_SERVER['SERVER_NAME'] == 'localhost')
	$project_folder = "login_system/";

// ========= Site Root paths (Document Root) ===========
define("_SITE_ROOT_PATH_", $_SERVER['DOCUMENT_ROOT']."/".$project_folder);

define("_MAIL_TEMPLATE_PATH_", _SITE_ROOT_PATH_."mail_template/");

// ========= Site Web paths ===========
define("_SITE_WEB_PATH_", $protocol.$_SERVER['SERVER_NAME']."/".$project_folder);

define("_SITE_NAME_", "Login System");





define("_USER_SESSION_NAME_", "USER_SESS");

// ================= Root paths ==================================
define("_ROOT_PATH_", _SITE_ROOT_PATH_);
define("_APP_PATH_", _ROOT_PATH_."app/");
define("_VIEW_PATH_", _ROOT_PATH_."views/");

define("_LIBRARY_PATH_", _ROOT_PATH_."libraries/");
define("_CLASS_PATH_", _ROOT_PATH_."classes/");

// ========= Web paths ===========
define("_WEB_PATH_", _SITE_WEB_PATH_);
define("_VIEW_WEB_PATH_", _WEB_PATH_."views/");
