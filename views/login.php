<?php
$sessionMsg = $sessionobj['msg'];
$sessionMsgtype = $sessionobj['msgtype'];

$sessionobj['msg'] = '';
$sessionobj['msgtype'] = '';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title><?php echo _SITE_NAME_; ?></title>
	<meta name="Author" content="">
	<meta name="Keywords" content="">
	<meta name="Description" content="">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<base href="<?php echo _WEB_PATH_; ?>">

	<link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet' type='text/css'>
	<script src="<?php echo _VIEW_WEB_PATH_; ?>js/jquery-1.10.2.min.js"></script>
<!-- css -->
	<link href="<?php echo _VIEW_WEB_PATH_; ?>css/custom.css" rel="stylesheet">
	<style>
	body{background-color: #F2F7F8 !important;}
	</style>
</head>
<body>
     <div class="logo">Login Form</div>
     <div class="middle_page">
	<div class="login_heading">Login</div>
	<form id="loginform" action="<?php echo Tools::getPageLink($ctg."/login"); ?>" method="post" name="login" onsubmit="return false" autocomplete="off" class="form_section">
		<input type="text" class="text" name="email" value="" placeholder="Email Address" />
		<input type="password" name="password" value="" placeholder="Password" />
		<input type="hidden" name="formAction" value="userlogin" />
		<input type="button" onclick="return userLogin()" value="Log In" class="login_button" >

		<div class='errormsg errormsg_bg'><span class='<?php echo $sessionMsgtype?>'><?php echo $sessionMsg; ?></span></div>
	</form>
   </div>

	<script>
	function userLogin()
	{
		var frm = document.forms["login"];
		var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,10})$/;
		var emailaddress = frm.email.value.trim();

		if(emailaddress == "")
		{
			$('.errormsg').html('Please enter email address');
			frm.email.focus();
			return false;
		}
		else if(reg.test(emailaddress) == false)
		{
			$('.errormsg').html('Please enter a valid email address')
			frm.email.focus();
			return false;
		}
		else if(frm.password.value.trim() == "")
		{
			$('.errormsg').html('Please enter your password');
			frm.password.focus();
			return false;
		}
		else
			frm.submit();
	}
	</script>

</body>
</html>
