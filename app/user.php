<?php

$userobj = new User();

if($action == 'login')
{
	if(isset($post_variables['formAction']) && $post_variables['formAction'] == 'userlogin')
	{
		$email = trim($post_variables['email']);
		$password = $post_variables['password'];
		$redirectto = $ctg.'/login';

		$validation = true;
		if(!filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			$sessionobj['msgtype'] = 'error';
			$sessionobj['msg'] = "Email address is not valid";
			$validation = false;
		}
		else if(strlen($password) == 0)
		{
			$sessionobj['msgtype'] = 'error';
			$sessionobj['msg'] = "Password is not valid";
			$validation = false;
		}
		if(!$validation)
			Tools::redirectTo($redirectto);

		$login_result = $userobj->login($email, $password);

		if($login_result == "success")
		{
			$redirectto = '';
		}
		else if($login_result == "inactive")
		{
			$sessionobj['msgtype'] = 'error';
			$sessionobj['msg'] = "Your account has been blocked";
		}
		else if($login_result == "passwordmismatch")
		{
			$sessionobj['msgtype'] = 'error';
			$sessionobj['msg'] = "Password you entered is incorrect";
		}
		else if($login_result == "usernotfound")
		{
			$sessionobj['msgtype'] = 'error';
			$sessionobj['msg'] = "There is no user registered with this email";
		}
		else
		{
			$sessionobj['msgtype'] = 'error';
			$sessionobj['msg'] = "Email address or password you entered is incorrect";
		}

		Tools::redirectTo($redirectto);
	}
	$view_page = "login";
	include(_VIEW_PATH_."login.php");
}
else
	Tools::redirectTo('404');
