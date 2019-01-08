<?php
header("X-Frame-Options: SAMEORIGIN");
header("Content-Type: text/html; charset=utf-8");

$sessionobj = Session::getInstance(_USER_SESSION_NAME_);

$uriobj = new URI();

$post_variables = $uriobj->getAllVariables("post");
$get_variables = $uriobj->getAllVariables("get");

$ctg = $uriobj->segment(0);
$action = $uriobj->segment(1);
$subctg = "";


if($uriobj->segment(2) != "")
{

	$subctg = $uriobj->segment(1);
	$action = $uriobj->segment(2);
}


if($ctg == '')
{
	$ctg = "home";
	$action = "view";
}

if($action == '')
	$action = "view";


if($sessionobj['user_id'] =="" and $ctg != "user")
{
	if($_REQUEST['ajax'] == 1)
	{
		die("loginerror");
	}
	else
	{
		Tools::redirectTo("user/login");
	}
}

if($sessionobj['user_id'] > 0 and $ctg == "user")
{
	Tools::redirectTo();
}

if($_REQUEST['ajax'] != 1)
{
	/********************** filter session ***********************/
	if($sessionobj['filter_ctg'] != $ctg)
	{
		$sessionobj['filter_ctg'] = $ctg;
		$sessionobj['filter_string'] = '';
	}
	/*************************************************************/
}

if($sessionobj['user_id'] > 0)
{
	/*********** Validate Token **************/
	if(!Tools::validatePageToken())
	{
		if($_REQUEST['ajax'] == 1)
			die("tokenerror");
		else
		{
			$ctg = "tokenerror";
			$action = "view";
		}
	}
	/**********************************************/

	
}

$action_page_ctg = str_replace("-", "_", $ctg);
$action_page_subctg = str_replace("-", "_", $subctg);

if($subctg != "")
{
	$action_page_path = _APP_PATH_.$action_page_ctg."_".$action_page_subctg.".php";

}
else
	$action_page_path = _APP_PATH_.$action_page_ctg.".php";

if(!file_exists($action_page_path))
	Tools::redirectTo("404");

include($action_page_path);

$sessionobj->offsetUnset('msgtype');
$sessionobj->offsetUnset('msg');
?>
