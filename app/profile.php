<?php

$userobj = new User();

if($action == 'logout')
{
	$sessionobj->destroy();
	$redirectto = $ctg.'/login';
	Tools::redirectTo($redirectto);
}
else
	Tools::redirectTo('404');
